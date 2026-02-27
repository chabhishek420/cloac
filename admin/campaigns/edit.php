<?php
/**
 * Campaign Edit Page
 * Edit existing campaign settings
 */

session_start();
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/campaign_manager.php';
require_once __DIR__ . '/../templates/platform_templates.php';

$id = $_GET['id'] ?? '';
if (empty($id)) {
    header('Location: index.php');
    exit;
}

$manager = new CampaignManager();
$campaign = $manager->getCampaign($id);

if (!$campaign) {
    header('Location: index.php');
    exit;
}

$templates = PlatformTemplates::getTemplates();
$currentTemplate = $templates[$campaign['template']] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Campaign - YellowCloaker</title>
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
        .edit-container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 40px;
        }
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid #e2e8f0;
        }
        .form-section:last-child {
            border-bottom: none;
        }
        .form-section h4 {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 16px;
        }
        .url-list {
            margin-top: 12px;
        }
        .url-item {
            display: flex;
            gap: 8px;
            margin-bottom: 8px;
        }
        .url-item input {
            flex: 1;
        }
        .template-info {
            background: #f7fafc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .template-icon {
            font-size: 32px;
            margin-right: 12px;
        }
        .save-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #e2e8f0;
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
                <a href="index.php" class="btn btn-sm btn-outline-light">
                    <i class="fas fa-arrow-left"></i> Back to Campaigns
                </a>
            </div>
        </div>
    </nav>

    <div class="edit-container">
        <h2 class="mb-4">
            <i class="fas fa-edit"></i> Edit Campaign
        </h2>

        <?php if ($currentTemplate): ?>
        <div class="template-info">
            <div class="d-flex align-items-center">
                <span class="template-icon"><?= $currentTemplate['icon'] ?></span>
                <div>
                    <strong><?= $currentTemplate['name'] ?></strong>
                    <p class="mb-0 text-muted"><?= $currentTemplate['description'] ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <form id="edit_form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

            <div class="form-section">
                <h4>Basic Information</h4>
                <div class="form-group">
                    <label>Campaign Name *</label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($campaign['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="active" <?= $campaign['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="paused" <?= $campaign['status'] === 'paused' ? 'selected' : '' ?>>Paused</option>
                        <option value="archived" <?= $campaign['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h4>White Pages (Safe Content)</h4>
                <p class="text-muted">URLs shown to bots and moderators</p>

                <div class="form-group">
                    <label>White Page Action</label>
                    <select class="form-control" name="white_action">
                        <option value="redirect" <?= ($campaign['white_action'] ?? 'redirect') === 'redirect' ? 'selected' : '' ?>>Redirect (302/303 to external URL)</option>
                        <option value="folder" <?= ($campaign['white_action'] ?? 'redirect') === 'folder' ? 'selected' : '' ?>>Folder (serve local HTML files)</option>
                        <option value="curl" <?= ($campaign['white_action'] ?? 'redirect') === 'curl' ? 'selected' : '' ?>>CURL (proxy external site content)</option>
                    </select>
                    <small class="form-text text-muted">How to handle blocked traffic</small>
                </div>

                <div class="url-list" id="white_urls">
                    <?php
                    $whiteUrls = $campaign['urls']['white'] ?? [];
                    if (empty($whiteUrls)) {
                        $whiteUrls = [''];
                    }
                    foreach ($whiteUrls as $url):
                    ?>
                        <div class="url-item">
                            <input type="text" class="form-control white-url" name="white_urls[]" value="<?= htmlspecialchars($url) ?>" placeholder="https://example.com/safe-page">
                            <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addWhiteUrl()">
                    <i class="fas fa-plus"></i> Add White URL
                </button>
            </div>

            <div class="form-section">
                <h4>Black Prelandings (Pre-sell Pages)</h4>
                <p class="text-muted">Pre-landing pages shown before the main offer</p>
                <div class="url-list" id="black_prelandings">
                    <?php
                    $prelandings = $campaign['urls']['black']['prelandings'] ?? [];
                    if (empty($prelandings)) {
                        $prelandings = [''];
                    }
                    foreach ($prelandings as $url):
                    ?>
                        <div class="url-item">
                            <input type="text" class="form-control prelanding-url" name="black_prelandings[]" value="<?= htmlspecialchars($url) ?>" placeholder="https://example.com/prelanding">
                            <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addPrelandingUrl()">
                    <i class="fas fa-plus"></i> Add Prelanding
                </button>
            </div>

            <div class="form-section">
                <h4>Black Landings (Main Offer Pages)</h4>
                <p class="text-muted">Main landing pages with conversion forms</p>
                <div class="url-list" id="black_landings">
                    <?php
                    $landings = $campaign['urls']['black']['landings'] ?? [];
                    if (empty($landings)) {
                        $landings = [''];
                    }
                    foreach ($landings as $url):
                    ?>
                        <div class="url-item">
                            <input type="text" class="form-control landing-url" name="black_landings[]" value="<?= htmlspecialchars($url) ?>" placeholder="https://example.com/landing">
                            <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addLandingUrl()">
                    <i class="fas fa-plus"></i> Add Landing
                </button>
            </div>

            <div class="form-section">
                <h4>Tracking Pixels</h4>

                <div class="form-group">
                    <label>Facebook Pixel ID</label>
                    <input type="text" class="form-control" name="facebook_pixel" value="<?= htmlspecialchars($campaign['pixels']['facebook'] ?? '') ?>" placeholder="123456789012345">
                </div>

                <div class="form-group">
                    <label>TikTok Pixel ID</label>
                    <input type="text" class="form-control" name="tiktok_pixel" value="<?= htmlspecialchars($campaign['pixels']['tiktok'] ?? '') ?>" placeholder="ABCDEFGHIJKLMNOP">
                </div>

                <div class="form-group">
                    <label>Google Tag Manager ID</label>
                    <input type="text" class="form-control" name="gtm_id" value="<?= htmlspecialchars($campaign['pixels']['gtm'] ?? '') ?>" placeholder="GTM-XXXXXXX">
                </div>
            </div>

            <div class="save-actions">
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addWhiteUrl() {
            $('#white_urls').append(`
                <div class="url-item">
                    <input type="text" class="form-control white-url" name="white_urls[]" placeholder="https://example.com/safe-page">
                    <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `);
        }

        function addPrelandingUrl() {
            $('#black_prelandings').append(`
                <div class="url-item">
                    <input type="text" class="form-control prelanding-url" name="black_prelandings[]" placeholder="https://example.com/prelanding">
                    <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `);
        }

        function addLandingUrl() {
            $('#black_landings').append(`
                <div class="url-item">
                    <input type="text" class="form-control landing-url" name="black_landings[]" placeholder="https://example.com/landing">
                    <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `);
        }

        function removeUrl(btn) {
            $(btn).closest('.url-item').remove();
        }

        $('#edit_form').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('action', 'update');

            $.ajax({
                url: 'api.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Campaign updated successfully!');
                        window.location.href = 'index.php';
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function() {
                    alert('An error occurred while saving the campaign');
                }
            });
        });
    </script>
</body>
</html>
