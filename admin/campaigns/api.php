<?php
/**
 * Campaign Management API
 * Handles AJAX requests for campaign operations
 */

session_start();
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/campaign_manager.php';

header('Content-Type: application/json');

$manager = new CampaignManager();
$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'create':
            // Create new campaign
            $data = [
                'name' => $_POST['name'] ?? '',
                'template' => $_POST['template'] ?? '',
                'status' => $_POST['status'] ?? 'active',
                'white_action' => $_POST['white_action'] ?? 'redirect',
                'white_urls' => $_POST['white_urls'] ?? [],
                'black_prelandings' => $_POST['black_prelandings'] ?? [],
                'black_landings' => $_POST['black_landings'] ?? [],
                'facebook_pixel' => $_POST['facebook_pixel'] ?? '',
                'tiktok_pixel' => $_POST['tiktok_pixel'] ?? '',
                'gtm_id' => $_POST['gtm_id'] ?? '',
                'settings' => json_decode($_POST['settings'] ?? '{}', true),
            ];

            if (empty($data['name'])) {
                throw new Exception('Campaign name is required');
            }

            $campaign = $manager->createCampaign($data);
            echo json_encode(['success' => true, 'campaign' => $campaign]);
            break;

        case 'update':
            // Update existing campaign
            $id = $_POST['id'] ?? '';
            if (empty($id)) {
                throw new Exception('Campaign ID is required');
            }

            $data = [
                'name' => $_POST['name'] ?? null,
                'status' => $_POST['status'] ?? null,
                'white_action' => $_POST['white_action'] ?? null,
                'urls' => [
                    'white' => $_POST['white_urls'] ?? null,
                    'black' => [
                        'prelandings' => $_POST['black_prelandings'] ?? null,
                        'landings' => $_POST['black_landings'] ?? null,
                    ],
                ],
                'pixels' => [
                    'facebook' => $_POST['facebook_pixel'] ?? null,
                    'tiktok' => $_POST['tiktok_pixel'] ?? null,
                    'gtm' => $_POST['gtm_id'] ?? null,
                ],
            ];

            // Remove null values
            $data = array_filter($data, function($v) { return $v !== null; });

            $result = $manager->updateCampaign($id, $data);
            if (!$result) {
                throw new Exception('Campaign not found');
            }

            echo json_encode(['success' => true]);
            break;

        case 'update_status':
            // Update campaign status
            $id = $_POST['id'] ?? '';
            $status = $_POST['status'] ?? '';

            if (empty($id) || empty($status)) {
                throw new Exception('Campaign ID and status are required');
            }

            $result = $manager->updateCampaign($id, ['status' => $status]);
            if (!$result) {
                throw new Exception('Campaign not found');
            }

            echo json_encode(['success' => true]);
            break;

        case 'delete':
            // Delete campaign
            $id = $_POST['id'] ?? '';
            if (empty($id)) {
                throw new Exception('Campaign ID is required');
            }

            $result = $manager->deleteCampaign($id);
            if (!$result) {
                throw new Exception('Campaign not found');
            }

            echo json_encode(['success' => true]);
            break;

        case 'clone':
            // Clone campaign
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';

            if (empty($id) || empty($name)) {
                throw new Exception('Campaign ID and new name are required');
            }

            $campaign = $manager->cloneCampaign($id, $name);
            if (!$campaign) {
                throw new Exception('Campaign not found');
            }

            echo json_encode(['success' => true, 'campaign' => $campaign]);
            break;

        case 'apply':
            // Apply campaign settings to global settings.json
            $id = $_POST['id'] ?? '';
            if (empty($id)) {
                throw new Exception('Campaign ID is required');
            }

            $result = $manager->applyCampaignSettings($id);
            if (!$result) {
                throw new Exception('Campaign not found');
            }

            // Update active_campaign_id in settings.json
            $settingsFile = __DIR__ . '/../../settings.json';
            $settings = json_decode(file_get_contents($settingsFile), true);
            $settings['active_campaign_id'] = $id;
            file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            echo json_encode(['success' => true]);
            break;

        case 'get':
            // Get single campaign
            $id = $_POST['id'] ?? $_GET['id'] ?? '';
            if (empty($id)) {
                throw new Exception('Campaign ID is required');
            }

            $campaign = $manager->getCampaign($id);
            if (!$campaign) {
                throw new Exception('Campaign not found');
            }

            echo json_encode(['success' => true, 'campaign' => $campaign]);
            break;

        case 'list':
            // List all campaigns
            $status = $_POST['status'] ?? $_GET['status'] ?? null;
            $campaigns = $manager->getAllCampaigns($status);

            echo json_encode(['success' => true, 'campaigns' => $campaigns]);
            break;

        case 'stats':
            // Get campaign metrics
            $id = $_POST['id'] ?? $_GET['id'] ?? '';
            if (empty($id)) {
                throw new Exception('Campaign ID is required');
            }

            $metrics = $manager->getCampaignMetrics($id);
            if (!$metrics) {
                throw new Exception('Campaign not found');
            }

            echo json_encode(['success' => true, 'metrics' => $metrics]);
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
