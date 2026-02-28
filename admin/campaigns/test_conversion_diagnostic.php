<?php
/**
 * Diagnostic Test for Conversion Tracking
 * Detailed investigation of E2E-5 failure
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/campaign_manager.php';
require_once __DIR__ . '/../../db.php';

echo "=== Conversion Tracking Diagnostic ===\n\n";

$manager = new CampaignManager();

// Create test campaign
$campaign = $manager->createCampaign([
    'name' => 'Diagnostic Test Campaign',
    'template' => 'facebook_ads',
    'status' => 'active',
    'white_action' => 'redirect',
    'white_urls' => ['https://example.com'],
    'black_prelandings' => [],
    'black_landings' => ['land1'],
    'facebook_pixel' => '',
    'tiktok_pixel' => '',
    'gtm_id' => '',
    'settings' => ['tds' => ['mode' => 'on']],
]);

$campaignId = $campaign['id'];
echo "Created test campaign: $campaignId\n\n";

// Apply campaign to make it active
$manager->applyCampaignSettings($campaignId);
echo "Applied campaign (now active)\n\n";

// Get initial stats
$initialStats = $manager->getCampaign($campaignId)['stats'];
echo "Initial Stats:\n";
echo "  Clicks: {$initialStats['clicks']}\n";
echo "  Conversions: {$initialStats['conversions']}\n";
echo "  Revenue: {$initialStats['revenue']}\n\n";

// Track a conversion
echo "Calling update_campaign_conversion_stats(25.00)...\n";
update_campaign_conversion_stats(25.00);

// Get updated stats
$afterStats = $manager->getCampaign($campaignId)['stats'];
echo "\nAfter Stats:\n";
echo "  Clicks: {$afterStats['clicks']}\n";
echo "  Conversions: {$afterStats['conversions']}\n";
echo "  Revenue: {$afterStats['revenue']}\n\n";

// Detailed comparison
echo "Comparison:\n";
echo "  Conversions changed: " . ($afterStats['conversions'] !== $initialStats['conversions'] ? "YES" : "NO") . "\n";
echo "  Expected conversions: " . ($initialStats['conversions'] + 1) . "\n";
echo "  Actual conversions: {$afterStats['conversions']}\n";
echo "  Match: " . ($afterStats['conversions'] === $initialStats['conversions'] + 1 ? "YES" : "NO") . "\n\n";

echo "  Revenue changed: " . ($afterStats['revenue'] !== $initialStats['revenue'] ? "YES" : "NO") . "\n";
echo "  Expected revenue: " . ($initialStats['revenue'] + 25.00) . "\n";
echo "  Actual revenue: {$afterStats['revenue']}\n";
echo "  Match (===): " . ($afterStats['revenue'] === $initialStats['revenue'] + 25.00 ? "YES" : "NO") . "\n";
echo "  Match (abs diff < 0.01): " . (abs($afterStats['revenue'] - ($initialStats['revenue'] + 25.00)) < 0.01 ? "YES" : "NO") . "\n\n";

// Type inspection
echo "Type Inspection:\n";
echo "  Initial revenue type: " . gettype($initialStats['revenue']) . "\n";
echo "  After revenue type: " . gettype($afterStats['revenue']) . "\n";
echo "  Initial conversions type: " . gettype($initialStats['conversions']) . "\n";
echo "  After conversions type: " . gettype($afterStats['conversions']) . "\n\n";

// Cleanup
$manager->deleteCampaign($campaignId);
echo "✓ Test campaign deleted\n";

// Restore settings
$settingsFile = __DIR__ . '/../../settings.json';
$settings = json_decode(file_get_contents($settingsFile), true);
unset($settings['active_campaign_id']);
file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "✓ Settings restored\n";
