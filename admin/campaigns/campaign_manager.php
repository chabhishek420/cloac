<?php
/**
 * Campaign Management System
 * Handles campaign CRUD operations and template application
 */

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../templates/platform_templates.php';

class CampaignManager {
    private $db;
    private $campaignsStore;

    public function __construct() {
        $this->db = new \SleekDB\Store('campaigns', __DIR__ . '/../../logs', [
            'auto_cache' => true,
            'cache_lifetime' => null,
            'timeout' => 120,
            'primary_key' => 'id',
        ]);
    }

    /**
     * Create a new campaign from template
     */
    public function createCampaign($data) {
        $campaign = [
            'id' => uniqid('camp_', true),
            'name' => $data['name'],
            'template' => $data['template'],
            'status' => 'active', // active, paused, archived
            'created_at' => time(),
            'updated_at' => time(),
            'settings' => $data['settings'],
            'urls' => [
                'white' => $data['white_urls'] ?? [],
                'black' => [
                    'prelandings' => $data['black_prelandings'] ?? [],
                    'landings' => $data['black_landings'] ?? [],
                ],
            ],
            'pixels' => [
                'facebook' => $data['facebook_pixel'] ?? '',
                'tiktok' => $data['tiktok_pixel'] ?? '',
                'gtm' => $data['gtm_id'] ?? '',
            ],
            'stats' => [
                'clicks' => 0,
                'conversions' => 0,
                'revenue' => 0,
            ],
        ];

        return $this->db->insert($campaign);
    }

    /**
     * Get campaign by ID
     */
    public function getCampaign($id) {
        return $this->db->findById($id);
    }

    /**
     * Get all campaigns
     */
    public function getAllCampaigns($status = null) {
        if ($status) {
            return $this->db->findBy(['status', '=', $status]);
        }
        return $this->db->findAll();
    }

    /**
     * Update campaign
     */
    public function updateCampaign($id, $data) {
        $campaign = $this->getCampaign($id);
        if (!$campaign) {
            return false;
        }

        $updated = array_merge($campaign, $data);
        $updated['updated_at'] = time();

        return $this->db->updateById($id, $updated);
    }

    /**
     * Delete campaign
     */
    public function deleteCampaign($id) {
        return $this->db->deleteById($id);
    }

    /**
     * Apply campaign settings to global settings.json
     */
    public function applyCampaignSettings($campaignId) {
        $campaign = $this->getCampaign($campaignId);
        if (!$campaign) {
            return false;
        }

        $settingsFile = __DIR__ . '/../../settings.json';
        $currentSettings = json_decode(file_get_contents($settingsFile), true);

        // Merge campaign settings with current settings
        $newSettings = array_replace_recursive($currentSettings, $campaign['settings']);

        // Write back to settings.json
        file_put_contents($settingsFile, json_encode($newSettings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return true;
    }

    /**
     * Clone campaign
     */
    public function cloneCampaign($id, $newName) {
        $campaign = $this->getCampaign($id);
        if (!$campaign) {
            return false;
        }

        unset($campaign['_id']);
        $campaign['id'] = uniqid('camp_', true);
        $campaign['name'] = $newName;
        $campaign['created_at'] = time();
        $campaign['updated_at'] = time();
        $campaign['stats'] = [
            'clicks' => 0,
            'conversions' => 0,
            'revenue' => 0,
        ];

        return $this->db->insert($campaign);
    }

    /**
     * Update campaign stats
     */
    public function updateStats($campaignId, $clicks = 0, $conversions = 0, $revenue = 0) {
        $campaign = $this->getCampaign($campaignId);
        if (!$campaign) {
            return false;
        }

        $campaign['stats']['clicks'] += $clicks;
        $campaign['stats']['conversions'] += $conversions;
        $campaign['stats']['revenue'] += $revenue;
        $campaign['updated_at'] = time();

        return $this->db->updateById($campaignId, $campaign);
    }

    /**
     * Get campaign performance metrics
     */
    public function getCampaignMetrics($campaignId) {
        $campaign = $this->getCampaign($campaignId);
        if (!$campaign) {
            return null;
        }

        $clicks = $campaign['stats']['clicks'];
        $conversions = $campaign['stats']['conversions'];
        $revenue = $campaign['stats']['revenue'];

        return [
            'clicks' => $clicks,
            'conversions' => $conversions,
            'revenue' => $revenue,
            'cr' => $clicks > 0 ? ($conversions / $clicks * 100) : 0,
            'epc' => $clicks > 0 ? ($revenue / $clicks) : 0,
            'avg_payout' => $conversions > 0 ? ($revenue / $conversions) : 0,
        ];
    }
}
