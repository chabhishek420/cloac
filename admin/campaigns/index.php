<?php
/**
 * Campaign Management Dashboard
 * Lists all campaigns with stats and management actions
 */

session_start();
require_once __DIR__ . '/../../settings.php';
require_once __DIR__ . '/../password.php';
check_password();
require_once __DIR__ . '/campaign_manager.php';

$manager = new CampaignManager();
$campaigns = $manager->getAllCampaigns();

// Get current active campaign from settings.json
$settingsFile = __DIR__ . '/../../settings.json';
$currentSettings = json_decode(file_get_contents($settingsFile), true);
$activeCampaignId = $currentSettings['active_campaign_id'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Management - YellowCloaker</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            color: white !important;
            font-weight: 600;
        }
        .campaign-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 24px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .campaign-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }
        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .campaign-name {
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
        }
        .campaign-template {
            display: inline-block;
            padding: 4px 12px;
            background: #edf2f7;
            border-radius: 6px;
            font-size: 13px;
            color: #4a5568;
            margin-left: 12px;
        }
        .campaign-status {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .status-active {
            background: #c6f6d5;
            color: #22543d;
        }
        .status-paused {
            background: #fed7d7;
            color: #742a2a;
        }
        .status-archived {
            background: #e2e8f0;
            color: #4a5568;
        }
        .campaign-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin: 20px 0;
        }
        .stat-box {
            text-align: center;
            padding: 12px;
            background: #f7fafc;
            border-radius: 8px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
        }
        .stat-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .campaign-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-action {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-apply {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        .btn-apply:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .active-badge {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 12px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .empty-state i {
            font-size: 64px;
            color: #cbd5e0;
            margin-bottom: 20px;
        }
        .empty-state h3 {
            color: #2d3748;
            margin-bottom: 12px;
        }
        .empty-state p {
            color: #718096;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-shield-alt"></i> YellowCloaker
            </a>
            <div class="ml-auto">
                <a href="../index.php" class="btn btn-sm btn-outline-light mr-2">
                    <i class="fas fa-arrow-left"></i> Back to Admin
                </a>
                <a href="create.php" class="btn btn-sm btn-light">
                    <i class="fas fa-plus"></i> New Campaign
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">
                        <i class="fas fa-bullhorn"></i> Campaign Management
                    </h2>
                    <?php if ($activeCampaignId): ?>
                        <button class="btn btn-warning" onclick="deactivateCampaign()">
                            <i class="fas fa-power-off"></i> Deactivate Active Campaign
                        </button>
                    <?php endif; ?>
                </div>

                <?php if (empty($campaigns)): ?>
                    <div class="empty-state">
                        <i class="fas fa-rocket"></i>
                        <h3>No campaigns yet</h3>
                        <p>Create your first campaign to get started with pre-configured templates</p>
                        <a href="create.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus"></i> Create Campaign
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($campaigns as $campaign):
                        $metrics = $manager->getCampaignMetrics($campaign['id']);
                        $isActive = ($activeCampaignId === $campaign['id']);
                    ?>
                        <div class="campaign-card">
                            <div class="campaign-header">
                                <div>
                                    <span class="campaign-name">
                                        <?= htmlspecialchars($campaign['name']) ?>
                                        <?php if ($isActive): ?>
                                            <span class="active-badge">
                                                <i class="fas fa-check-circle"></i> ACTIVE
                                            </span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="campaign-template">
                                        <i class="fas fa-layer-group"></i>
                                        <?= ucwords(str_replace('_', ' ', $campaign['template'])) ?>
                                    </span>
                                </div>
                                <span class="campaign-status status-<?= $campaign['status'] ?>">
                                    <?= ucfirst($campaign['status']) ?>
                                </span>
                            </div>

                            <div class="campaign-stats">
                                <div class="stat-box">
                                    <div class="stat-value"><?= number_format($metrics['clicks']) ?></div>
                                    <div class="stat-label">Clicks</div>
                                </div>
                                <div class="stat-box">
                                    <div class="stat-value"><?= number_format($metrics['conversions']) ?></div>
                                    <div class="stat-label">Conversions</div>
                                </div>
                                <div class="stat-box">
                                    <div class="stat-value"><?= number_format($metrics['cr'], 2) ?>%</div>
                                    <div class="stat-label">CR%</div>
                                </div>
                                <div class="stat-box">
                                    <div class="stat-value">$<?= number_format($metrics['epc'], 2) ?></div>
                                    <div class="stat-label">EPC</div>
                                </div>
                                <div class="stat-box">
                                    <div class="stat-value">$<?= number_format($metrics['revenue'], 2) ?></div>
                                    <div class="stat-label">Revenue</div>
                                </div>
                            </div>

                            <div class="campaign-actions">
                                <?php if (!$isActive): ?>
                                    <button class="btn btn-action btn-apply" onclick="applyCampaign('<?= $campaign['id'] ?>')">
                                        <i class="fas fa-play"></i> Apply Campaign
                                    </button>
                                <?php endif; ?>
                                <a href="edit.php?id=<?= $campaign['id'] ?>" class="btn btn-action btn-secondary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-action btn-info" onclick="cloneCampaign('<?= $campaign['id'] ?>')">
                                    <i class="fas fa-copy"></i> Clone
                                </button>
                                <?php if ($campaign['status'] === 'active'): ?>
                                    <button class="btn btn-action btn-warning" onclick="pauseCampaign('<?= $campaign['id'] ?>')">
                                        <i class="fas fa-pause"></i> Pause
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-action btn-success" onclick="resumeCampaign('<?= $campaign['id'] ?>')">
                                        <i class="fas fa-play"></i> Resume
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-action btn-danger" onclick="deleteCampaign('<?= $campaign['id'] ?>', '<?= htmlspecialchars($campaign['name']) ?>')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function applyCampaign(id) {
            if (confirm('Apply this campaign? This will update your global settings.')) {
                $.post('api.php', {
                    action: 'apply',
                    id: id
                }, function(response) {
                    if (response.success) {
                        alert('Campaign applied successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + response.error);
                    }
                }, 'json');
            }
        }

        function cloneCampaign(id) {
            const newName = prompt('Enter name for cloned campaign:');
            if (newName) {
                $.post('api.php', {
                    action: 'clone',
                    id: id,
                    name: newName
                }, function(response) {
                    if (response.success) {
                        alert('Campaign cloned successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + response.error);
                    }
                }, 'json');
            }
        }

        function pauseCampaign(id) {
            $.post('api.php', {
                action: 'update_status',
                id: id,
                status: 'paused'
            }, function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + response.error);
                }
            }, 'json');
        }

        function resumeCampaign(id) {
            $.post('api.php', {
                action: 'update_status',
                id: id,
                status: 'active'
            }, function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + response.error);
                }
            }, 'json');
        }

        function deleteCampaign(id, name) {
            if (confirm('Delete campaign "' + name + '"? This cannot be undone.')) {
                $.post('api.php', {
                    action: 'delete',
                    id: id
                }, function(response) {
                    if (response.success) {
                        alert('Campaign deleted successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + response.error);
                    }
                }, 'json');
            }
        }

        function deactivateCampaign() {
            if (confirm('Deactivate the current campaign? This will return to manual configuration.')) {
                $.post('api.php', {
                    action: 'deactivate'
                }, function(response) {
                    if (response.success) {
                        alert('Campaign deactivated successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + response.error);
                    }
                }, 'json');
            }
        }
    </script>
</body>
</html>
