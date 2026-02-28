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
            'timeout' => false, // Deprecated, use set_timeout_limit() if needed
        ]);
    }

    /**
     * Normalize campaign data (map _id to id for consistency)
     */
    private function normalizeCampaign($campaign) {
        if ($campaign && isset($campaign['_id'])) {
            $campaign['id'] = $campaign['_id'];
        }
        return $campaign;
    }

    /**
     * Normalize multiple campaigns
     */
    private function normalizeCampaigns($campaigns) {
        return array_map([$this, 'normalizeCampaign'], $campaigns);
    }

    /**
     * Create a new campaign from template
     */
    public function createCampaign($data) {
        $campaign = [
            'name' => $data['name'],
            'template' => $data['template'],
            'status' => 'active', // active, paused, archived
            'created_at' => time(),
            'updated_at' => time(),
            'white_action' => $data['white_action'] ?? 'redirect',
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

        $result = $this->db->insert($campaign);
        return $this->normalizeCampaign($result);
    }

    /**
     * Get campaign by ID
     */
    public function getCampaign($id) {
        $campaign = $this->db->findById($id);
        return $this->normalizeCampaign($campaign);
    }

    /**
     * Get all campaigns
     */
    public function getAllCampaigns($status = null) {
        if ($status) {
            $campaigns = $this->db->findBy(['status', '=', $status]);
        } else {
            $campaigns = $this->db->findAll();
        }
        return $this->normalizeCampaigns($campaigns);
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

        // Remove _id and id before updating (SleekDB doesn't allow updating primary key)
        $updateData = $updated;
        unset($updateData['_id']);
        unset($updateData['id']);

        return $this->db->updateById($id, $updateData);
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

        // Merge campaign template settings with current settings
        $newSettings = array_replace_recursive($currentSettings, $campaign['settings']);

        // Apply white page URLs (default to redirect action)
        if (!empty($campaign['urls']['white'])) {
            $whiteAction = $campaign['white_action'] ?? 'redirect';

            if ($whiteAction === 'folder') {
                $newSettings['white']['action'] = 'folder';
                $newSettings['white']['folder']['names'] = $campaign['urls']['white'];
            } elseif ($whiteAction === 'redirect') {
                $newSettings['white']['action'] = 'redirect';
                $newSettings['white']['redirect']['urls'] = $campaign['urls']['white'];
            } elseif ($whiteAction === 'curl') {
                $newSettings['white']['action'] = 'curl';
                $newSettings['white']['curl']['urls'] = $campaign['urls']['white'];
            }
        }

        // Apply black prelanding URLs
        if (!empty($campaign['urls']['black']['prelandings'])) {
            $newSettings['black']['prelanding']['action'] = 'folder';
            $newSettings['black']['prelanding']['folders'] = $campaign['urls']['black']['prelandings'];
        }

        // Apply black landing URLs
        if (!empty($campaign['urls']['black']['landings'])) {
            $newSettings['black']['landing']['action'] = 'folder';
            $newSettings['black']['landing']['folder']['names'] = $campaign['urls']['black']['landings'];
        }

        // Apply pixel IDs
        if (!empty($campaign['pixels']['facebook'])) {
            $newSettings['pixels']['fb']['id'] = $campaign['pixels']['facebook'];
        }
        if (!empty($campaign['pixels']['tiktok'])) {
            $newSettings['pixels']['tiktok']['id'] = $campaign['pixels']['tiktok'];
        }
        if (!empty($campaign['pixels']['gtm'])) {
            $newSettings['pixels']['gtm']['id'] = $campaign['pixels']['gtm'];
        }

        // Store active campaign ID
        $newSettings['active_campaign_id'] = $campaignId;

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

        // Remove SleekDB's auto-generated _id and id fields
        unset($campaign['_id']);
        unset($campaign['id']);

        $campaign['name'] = $newName;
        $campaign['created_at'] = time();
        $campaign['updated_at'] = time();
        $campaign['stats'] = [
            'clicks' => 0,
            'conversions' => 0,
            'revenue' => 0,
        ];

        $result = $this->db->insert($campaign);
        return $this->normalizeCampaign($result);
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
