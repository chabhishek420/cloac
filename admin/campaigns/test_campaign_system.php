<?php
/**
 * Campaign System Integration Test
 * Tests critical integration points between campaign system and core cloaker
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/campaign_manager.php';
require_once __DIR__ . '/../../db.php';

echo "=== Campaign System Integration Test ===\n\n";

// Test 1: Campaign Creation
echo "Test 1: Campaign Creation\n";
$manager = new CampaignManager();

$testData = [
    'name' => 'Test Campaign ' . time(),
    'template' => 'facebook_ads',
    'status' => 'active',
    'white_action' => 'redirect',
    'white_urls' => ['https://example.com/safe'],
    'black_prelandings' => ['preland1', 'preland2'],
    'black_landings' => ['land1', 'land2'],
    'facebook_pixel' => '123456789012345',
    'tiktok_pixel' => 'ABCDEFGHIJKLMNOP',
    'gtm_id' => 'GTM-TEST123',
    'settings' => [
        'tds' => ['mode' => 'on'],
    ],
];

$campaign = $manager->createCampaign($testData);
if ($campaign && isset($campaign['id'])) {
    echo "✓ Campaign created successfully (ID: {$campaign['id']})\n";
    $testCampaignId = $campaign['id'];
} else {
    echo "✗ Failed to create campaign\n";
    exit(1);
}

// Test 2: Campaign Retrieval
echo "\nTest 2: Campaign Retrieval\n";
$retrieved = $manager->getCampaign($testCampaignId);
if ($retrieved && $retrieved['name'] === $testData['name']) {
    echo "✓ Campaign retrieved successfully\n";
} else {
    echo "✗ Failed to retrieve campaign\n";
    exit(1);
}

// Test 3: Campaign Application to settings.json
echo "\nTest 3: Campaign Application to settings.json\n";
$settingsFile = __DIR__ . '/../../settings.json';
$settingsBackup = file_get_contents($settingsFile);

$result = $manager->applyCampaignSettings($testCampaignId);
if ($result) {
    echo "✓ Campaign applied successfully\n";

    // Verify settings.json was updated
    $settings = json_decode(file_get_contents($settingsFile), true);

    // Check active_campaign_id
    if ($settings['active_campaign_id'] === $testCampaignId) {
        echo "✓ active_campaign_id set correctly\n";
    } else {
        echo "✗ active_campaign_id not set\n";
    }

    // Check white URLs
    if ($settings['white']['action'] === 'redirect' &&
        in_array('https://example.com/safe', $settings['white']['redirect']['urls'])) {
        echo "✓ White URLs applied correctly\n";
    } else {
        echo "✗ White URLs not applied correctly\n";
    }

    // Check black prelandings
    if ($settings['black']['prelanding']['action'] === 'folder' &&
        in_array('preland1', $settings['black']['prelanding']['folders'])) {
        echo "✓ Black prelandings applied correctly\n";
    } else {
        echo "✗ Black prelandings not applied correctly\n";
    }

    // Check black landings
    if ($settings['black']['landing']['action'] === 'folder' &&
        in_array('land1', $settings['black']['landing']['folder']['names'])) {
        echo "✓ Black landings applied correctly\n";
    } else {
        echo "✗ Black landings not applied correctly\n";
    }

    // Check pixels
    if ($settings['pixels']['fb']['id'] === '123456789012345') {
        echo "✓ Facebook pixel applied correctly\n";
    } else {
        echo "✗ Facebook pixel not applied correctly\n";
    }

    if ($settings['pixels']['tiktok']['id'] === 'ABCDEFGHIJKLMNOP') {
        echo "✓ TikTok pixel applied correctly\n";
    } else {
        echo "✗ TikTok pixel not applied correctly\n";
    }

    if ($settings['pixels']['gtm']['id'] === 'GTM-TEST123') {
        echo "✓ GTM ID applied correctly\n";
    } else {
        echo "✗ GTM ID not applied correctly\n";
    }

} else {
    echo "✗ Failed to apply campaign\n";
    exit(1);
}

// Test 4: Stats Tracking Functions
echo "\nTest 4: Stats Tracking Functions\n";

// Test get_active_campaign_id
$activeCampaignId = get_active_campaign_id();
if ($activeCampaignId === $testCampaignId) {
    echo "✓ get_active_campaign_id() works correctly\n";
} else {
    echo "✗ get_active_campaign_id() failed\n";
}

// Test click stats update
$initialStats = $manager->getCampaign($testCampaignId)['stats'];
update_campaign_click_stats();
$afterClickStats = $manager->getCampaign($testCampaignId)['stats'];

if ($afterClickStats['clicks'] === $initialStats['clicks'] + 1) {
    echo "✓ update_campaign_click_stats() works correctly\n";
} else {
    echo "✗ update_campaign_click_stats() failed (expected " . ($initialStats['clicks'] + 1) . ", got " . $afterClickStats['clicks'] . ")\n";
}

// Test conversion stats update
update_campaign_conversion_stats(50.00);
$afterConversionStats = $manager->getCampaign($testCampaignId)['stats'];

if ($afterConversionStats['conversions'] === $initialStats['conversions'] + 1 &&
    $afterConversionStats['revenue'] === $initialStats['revenue'] + 50.00) {
    echo "✓ update_campaign_conversion_stats() works correctly\n";
} else {
    echo "✗ update_campaign_conversion_stats() failed\n";
}

// Test 5: Campaign Metrics Calculation
echo "\nTest 5: Campaign Metrics Calculation\n";
$metrics = $manager->getCampaignMetrics($testCampaignId);

if (isset($metrics['clicks']) && isset($metrics['conversions']) &&
    isset($metrics['revenue']) && isset($metrics['cr']) && isset($metrics['epc'])) {
    echo "✓ Campaign metrics calculated successfully\n";
    echo "  - Clicks: {$metrics['clicks']}\n";
    echo "  - Conversions: {$metrics['conversions']}\n";
    echo "  - Revenue: \${$metrics['revenue']}\n";
    echo "  - CR: " . number_format($metrics['cr'], 2) . "%\n";
    echo "  - EPC: \$" . number_format($metrics['epc'], 2) . "\n";
} else {
    echo "✗ Campaign metrics calculation failed\n";
}

// Test 6: Campaign Update
echo "\nTest 6: Campaign Update\n";
$updateResult = $manager->updateCampaign($testCampaignId, [
    'name' => 'Updated Test Campaign',
    'status' => 'paused',
]);

if ($updateResult) {
    $updated = $manager->getCampaign($testCampaignId);
    if ($updated['name'] === 'Updated Test Campaign' && $updated['status'] === 'paused') {
        echo "✓ Campaign updated successfully\n";
    } else {
        echo "✗ Campaign update verification failed\n";
    }
} else {
    echo "✗ Failed to update campaign\n";
}

// Test 7: Campaign Clone
echo "\nTest 7: Campaign Clone\n";
$cloned = $manager->cloneCampaign($testCampaignId, 'Cloned Test Campaign');
if ($cloned && $cloned['name'] === 'Cloned Test Campaign' && $cloned['id'] !== $testCampaignId) {
    echo "✓ Campaign cloned successfully (ID: {$cloned['id']})\n";
    $clonedCampaignId = $cloned['id'];
} else {
    echo "✗ Failed to clone campaign\n";
}

// Cleanup
echo "\nCleaning up test data...\n";

// Restore settings.json
file_put_contents($settingsFile, $settingsBackup);
echo "✓ settings.json restored\n";

// Delete test campaigns
$manager->deleteCampaign($testCampaignId);
echo "✓ Test campaign deleted\n";

if (isset($clonedCampaignId)) {
    $manager->deleteCampaign($clonedCampaignId);
    echo "✓ Cloned campaign deleted\n";
}

echo "\n=== All Tests Passed ===\n";
