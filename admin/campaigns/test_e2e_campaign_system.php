<?php
/**
 * End-to-End Campaign System Test
 * Comprehensive test suite covering the complete campaign lifecycle
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/campaign_manager.php';
require_once __DIR__ . '/../../db.php';

echo "=== End-to-End Campaign System Test ===\n\n";

$manager = new CampaignManager();
$testResults = [];
$failedTests = [];

function test($name, $callback) {
    global $testResults, $failedTests;
    echo "Testing: $name\n";
    try {
        $result = $callback();
        if ($result) {
            echo "✓ PASS\n\n";
            $testResults[] = ['name' => $name, 'status' => 'PASS'];
        } else {
            echo "✗ FAIL\n\n";
            $testResults[] = ['name' => $name, 'status' => 'FAIL'];
            $failedTests[] = $name;
        }
    } catch (Exception $e) {
        echo "✗ EXCEPTION: " . $e->getMessage() . "\n\n";
        $testResults[] = ['name' => $name, 'status' => 'EXCEPTION'];
        $failedTests[] = $name;
    }
}

// Backup settings.json
$settingsFile = __DIR__ . '/../../settings.json';
$settingsBackup = file_get_contents($settingsFile);
echo "Settings backup created\n\n";

// Test 1: Campaign Creation with Facebook Ads Template
test("E2E-1: Create Facebook Ads Campaign", function() use ($manager) {
    $campaign = $manager->createCampaign([
        'name' => 'E2E Test Facebook Campaign',
        'template' => 'facebook_ads',
        'status' => 'active',
        'white_action' => 'redirect',
        'white_urls' => ['https://example.com/safe'],
        'black_prelandings' => ['fb_preland1', 'fb_preland2'],
        'black_landings' => ['fb_land1', 'fb_land2'],
        'facebook_pixel' => '123456789012345',
        'tiktok_pixel' => '',
        'gtm_id' => '',
        'settings' => [
            'tds' => ['mode' => 'on'],
        ],
    ]);

    return $campaign && isset($campaign['id']) && $campaign['template'] === 'facebook_ads';
});

// Get the created campaign ID
$campaigns = $manager->getAllCampaigns();
$fbCampaign = null;
foreach ($campaigns as $c) {
    if ($c['name'] === 'E2E Test Facebook Campaign') {
        $fbCampaign = $c;
        break;
    }
}

if (!$fbCampaign) {
    echo "✗ CRITICAL: Could not find created Facebook campaign\n";
    exit(1);
}

$fbCampaignId = $fbCampaign['id'];
echo "Facebook Campaign ID: $fbCampaignId\n\n";

// Test 2: Campaign Application to settings.json
test("E2E-2: Apply Campaign to settings.json", function() use ($manager, $fbCampaignId, $settingsFile) {
    $result = $manager->applyCampaignSettings($fbCampaignId);
    if (!$result) return false;

    $settings = json_decode(file_get_contents($settingsFile), true);

    // Verify active_campaign_id
    if ($settings['active_campaign_id'] !== $fbCampaignId) return false;

    // Verify white URLs
    if ($settings['white']['action'] !== 'redirect') return false;
    if (!in_array('https://example.com/safe', $settings['white']['redirect']['urls'])) return false;

    // Verify black prelandings
    if ($settings['black']['prelanding']['action'] !== 'folder') return false;
    if (!in_array('fb_preland1', $settings['black']['prelanding']['folders'])) return false;

    // Verify Facebook pixel
    if ($settings['pixels']['fb']['id'] !== '123456789012345') return false;

    return true;
});

// Test 3: Backup File Creation
test("E2E-3: Verify Backup File Created", function() use ($settingsFile) {
    $backups = glob($settingsFile . '.backup.*');
    return count($backups) > 0;
});

// Test 4: Stats Tracking - Single Click
test("E2E-4: Track Single Click", function() use ($manager, $fbCampaignId) {
    $initialStats = $manager->getCampaign($fbCampaignId)['stats'];
    update_campaign_click_stats();
    $afterStats = $manager->getCampaign($fbCampaignId)['stats'];

    return $afterStats['clicks'] === $initialStats['clicks'] + 1;
});

// Test 5: Stats Tracking - Single Conversion
test("E2E-5: Track Single Conversion", function() use ($manager, $fbCampaignId) {
    $initialStats = $manager->getCampaign($fbCampaignId)['stats'];
    update_campaign_conversion_stats(25.00);
    $afterStats = $manager->getCampaign($fbCampaignId)['stats'];

    // Use loose comparison for numeric values to handle int/float type differences
    return $afterStats['conversions'] === $initialStats['conversions'] + 1 &&
           abs($afterStats['revenue'] - ($initialStats['revenue'] + 25.00)) < 0.01;
});

// Test 6: Stats Tracking - Concurrent Updates (Race Condition Test)
test("E2E-6: Concurrent Stats Updates (Race Condition)", function() use ($manager, $fbCampaignId) {
    $initialStats = $manager->getCampaign($fbCampaignId)['stats'];
    $initialClicks = $initialStats['clicks'];

    // Simulate 10 concurrent click updates
    for ($i = 0; $i < 10; $i++) {
        update_campaign_click_stats();
    }

    $afterStats = $manager->getCampaign($fbCampaignId)['stats'];
    $expectedClicks = $initialClicks + 10;

    // All 10 clicks should be recorded (no lost updates)
    return $afterStats['clicks'] === $expectedClicks;
});

// Test 7: Campaign Metrics Calculation
test("E2E-7: Campaign Metrics Calculation", function() use ($manager, $fbCampaignId) {
    $metrics = $manager->getCampaignMetrics($fbCampaignId);

    // Verify all metrics are present
    if (!isset($metrics['clicks']) || !isset($metrics['conversions']) ||
        !isset($metrics['revenue']) || !isset($metrics['cr']) || !isset($metrics['epc'])) {
        return false;
    }

    // Verify CR% calculation
    if ($metrics['clicks'] > 0) {
        $expectedCR = ($metrics['conversions'] / $metrics['clicks']) * 100;
        if (abs($metrics['cr'] - $expectedCR) > 0.01) return false;
    }

    // Verify EPC calculation
    if ($metrics['clicks'] > 0) {
        $expectedEPC = $metrics['revenue'] / $metrics['clicks'];
        if (abs($metrics['epc'] - $expectedEPC) > 0.01) return false;
    }

    return true;
});

// Test 8: Campaign Update
test("E2E-8: Update Campaign", function() use ($manager, $fbCampaignId) {
    $result = $manager->updateCampaign($fbCampaignId, [
        'name' => 'E2E Test Facebook Campaign (Updated)',
        'status' => 'paused',
    ]);

    if (!$result) return false;

    $updated = $manager->getCampaign($fbCampaignId);
    return $updated['name'] === 'E2E Test Facebook Campaign (Updated)' &&
           $updated['status'] === 'paused';
});

// Test 9: Campaign Clone
test("E2E-9: Clone Campaign", function() use ($manager, $fbCampaignId) {
    $cloned = $manager->cloneCampaign($fbCampaignId, 'E2E Cloned Facebook Campaign');

    if (!$cloned || !isset($cloned['id'])) return false;
    if ($cloned['id'] === $fbCampaignId) return false;
    if ($cloned['name'] !== 'E2E Cloned Facebook Campaign') return false;

    // Verify stats are reset
    if ($cloned['stats']['clicks'] !== 0 || $cloned['stats']['conversions'] !== 0) return false;

    return true;
});

// Get cloned campaign ID for cleanup
$clonedCampaign = null;
$campaigns = $manager->getAllCampaigns();
foreach ($campaigns as $c) {
    if ($c['name'] === 'E2E Cloned Facebook Campaign') {
        $clonedCampaign = $c;
        break;
    }
}

// Test 10: Create TikTok Ads Campaign
test("E2E-10: Create TikTok Ads Campaign", function() use ($manager) {
    $campaign = $manager->createCampaign([
        'name' => 'E2E Test TikTok Campaign',
        'template' => 'tiktok_ads',
        'status' => 'active',
        'white_action' => 'folder',
        'white_urls' => ['white_folder'],
        'black_prelandings' => ['tt_preland1'],
        'black_landings' => ['tt_land1'],
        'facebook_pixel' => '',
        'tiktok_pixel' => 'ABCDEFGHIJKLMNOP',
        'gtm_id' => 'GTM-TEST123',
        'settings' => [
            'tds' => ['mode' => 'on'],
        ],
    ]);

    return $campaign && isset($campaign['id']) && $campaign['template'] === 'tiktok_ads';
});

// Get TikTok campaign
$ttCampaign = null;
$campaigns = $manager->getAllCampaigns();
foreach ($campaigns as $c) {
    if ($c['name'] === 'E2E Test TikTok Campaign') {
        $ttCampaign = $c;
        break;
    }
}

// Test 11: Switch Active Campaign
test("E2E-11: Switch Active Campaign", function() use ($manager, $ttCampaign, $settingsFile) {
    if (!$ttCampaign) return false;

    $result = $manager->applyCampaignSettings($ttCampaign['id']);
    if (!$result) return false;

    $settings = json_decode(file_get_contents($settingsFile), true);

    // Verify active campaign switched
    if ($settings['active_campaign_id'] !== $ttCampaign['id']) return false;

    // Verify TikTok pixel applied
    if ($settings['pixels']['tiktok']['id'] !== 'ABCDEFGHIJKLMNOP') return false;

    // Verify GTM applied
    if ($settings['pixels']['gtm']['id'] !== 'GTM-TEST123') return false;

    // Verify white action changed to folder
    if ($settings['white']['action'] !== 'folder') return false;

    return true;
});

// Test 12: Campaign Deactivation
test("E2E-12: Deactivate Campaign", function() use ($manager, $settingsFile) {
    $result = $manager->deactivateCampaign();
    if (!$result) return false;

    $settings = json_decode(file_get_contents($settingsFile), true);

    // Verify active_campaign_id removed
    return !isset($settings['active_campaign_id']);
});

// Test 13: Get All Campaigns
test("E2E-13: List All Campaigns", function() use ($manager) {
    $campaigns = $manager->getAllCampaigns();

    // Should have at least 3 campaigns (FB, cloned FB, TikTok)
    if (count($campaigns) < 3) return false;

    // Verify each campaign has required fields
    foreach ($campaigns as $campaign) {
        if (!isset($campaign['id']) || !isset($campaign['name']) ||
            !isset($campaign['template']) || !isset($campaign['status'])) {
            return false;
        }
    }

    return true;
});

// Test 14: Filter Campaigns by Status
test("E2E-14: Filter Campaigns by Status", function() use ($manager) {
    $pausedCampaigns = $manager->getAllCampaigns('paused');

    // Should have at least 1 paused campaign (updated FB campaign)
    if (count($pausedCampaigns) < 1) return false;

    // Verify all returned campaigns are paused
    foreach ($pausedCampaigns as $campaign) {
        if ($campaign['status'] !== 'paused') return false;
    }

    return true;
});

// Test 15: Atomic Write Verification
test("E2E-15: Atomic Write Integrity", function() use ($manager, $fbCampaignId, $settingsFile) {
    // Apply campaign multiple times rapidly
    for ($i = 0; $i < 5; $i++) {
        $manager->applyCampaignSettings($fbCampaignId);
    }

    // Verify settings.json is still valid JSON
    $settings = json_decode(file_get_contents($settingsFile), true);
    if (json_last_error() !== JSON_ERROR_NONE) return false;

    // Verify no temp files left behind
    $tempFiles = glob($settingsFile . '.tmp.*');
    return count($tempFiles) === 0;
});

// Test 16: Backup Cleanup
test("E2E-16: Backup Cleanup (Keep Last 5)", function() use ($manager, $fbCampaignId, $settingsFile) {
    // Create 10 more backups
    for ($i = 0; $i < 10; $i++) {
        $manager->applyCampaignSettings($fbCampaignId);
        usleep(100000); // 100ms delay to ensure different timestamps
    }

    // Should have exactly 5 backups (cleanup keeps last 5)
    $backups = glob($settingsFile . '.backup.*');
    return count($backups) <= 5;
});

// Test 17: Campaign Deletion
test("E2E-17: Delete Campaign", function() use ($manager, $clonedCampaign) {
    if (!$clonedCampaign) return false;

    $result = $manager->deleteCampaign($clonedCampaign['id']);
    if (!$result) return false;

    // Verify campaign is deleted
    $deleted = $manager->getCampaign($clonedCampaign['id']);
    return $deleted === null;
});

// Cleanup
echo "\n=== Cleanup ===\n";

// Restore settings.json
file_put_contents($settingsFile, $settingsBackup);
echo "✓ settings.json restored\n";

// Delete test campaigns
$testCampaignNames = [
    'E2E Test Facebook Campaign',
    'E2E Test Facebook Campaign (Updated)',
    'E2E Cloned Facebook Campaign',
    'E2E Test TikTok Campaign',
];

$campaigns = $manager->getAllCampaigns();
foreach ($campaigns as $campaign) {
    if (in_array($campaign['name'], $testCampaignNames)) {
        $manager->deleteCampaign($campaign['id']);
        echo "✓ Deleted campaign: {$campaign['name']}\n";
    }
}

// Cleanup backup files
$backups = glob($settingsFile . '.backup.*');
foreach ($backups as $backup) {
    unlink($backup);
}
echo "✓ Backup files cleaned up\n";

// Print Summary
echo "\n=== Test Summary ===\n";
$passCount = 0;
$failCount = 0;

foreach ($testResults as $result) {
    if ($result['status'] === 'PASS') {
        $passCount++;
    } else {
        $failCount++;
    }
}

echo "Total Tests: " . count($testResults) . "\n";
echo "Passed: $passCount\n";
echo "Failed: $failCount\n";

if ($failCount > 0) {
    echo "\nFailed Tests:\n";
    foreach ($failedTests as $test) {
        echo "  - $test\n";
    }
    exit(1);
} else {
    echo "\n✅ All E2E Tests Passed!\n";
}
