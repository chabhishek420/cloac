<?php
/**
 * Campaign Creation Wizard
 * Multi-step wizard for creating campaigns with pre-configured templates
 */

session_start();
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../templates/platform_templates.php';

$templates = PlatformTemplates::getTemplates();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Campaign - YellowCloaker</title>
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
        .wizard-container {
            max-width: 1200px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .wizard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .wizard-header h2 {
            margin: 0;
            font-weight: 600;
        }
        .wizard-steps {
            display: flex;
            justify-content: space-between;
            padding: 30px 50px;
            background: #f7fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .wizard-step {
            flex: 1;
            text-align: center;
            position: relative;
        }
        .wizard-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            right: -50%;
            width: 100%;
            height: 2px;
            background: #cbd5e0;
            z-index: 0;
        }
        .wizard-step.active:not(:last-child)::after {
            background: #667eea;
        }
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #cbd5e0;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }
        .wizard-step.active .step-number {
            background: #667eea;
        }
        .wizard-step.completed .step-number {
            background: #48bb78;
        }
        .step-label {
            font-size: 14px;
            color: #718096;
        }
        .wizard-step.active .step-label {
            color: #2d3748;
            font-weight: 600;
        }
        .wizard-content {
            padding: 40px 50px;
            min-height: 500px;
        }
        .wizard-actions {
            padding: 20px 50px;
            background: #f7fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
        }
        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .template-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        .template-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }
        .template-card.selected {
            border-color: #667eea;
            background: #f7faff;
        }
        .template-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        .template-name {
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }
        .template-category {
            display: inline-block;
            padding: 4px 12px;
            background: #edf2f7;
            border-radius: 6px;
            font-size: 12px;
            color: #4a5568;
            margin-bottom: 12px;
        }
        .template-description {
            font-size: 14px;
            color: #718096;
            line-height: 1.6;
        }
        .template-features {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
        }
        .template-feature {
            font-size: 13px;
            color: #4a5568;
            margin-bottom: 6px;
        }
        .template-feature i {
            color: #48bb78;
            margin-right: 8px;
        }
        .form-section {
            margin-bottom: 30px;
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
        .step-content {
            display: none;
        }
        .step-content.active {
            display: block;
        }
        .review-section {
            background: #f7fafc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .review-section h5 {
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 12px;
        }
        .review-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .review-item:last-child {
            border-bottom: none;
        }
        .review-label {
            font-weight: 500;
            color: #4a5568;
        }
        .review-value {
            color: #2d3748;
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

    <div class="wizard-container">
        <div class="wizard-header">
            <h2><i class="fas fa-magic"></i> Create New Campaign</h2>
            <p class="mb-0 mt-2">Choose a pre-configured template and customize your campaign</p>
        </div>

        <div class="wizard-steps">
            <div class="wizard-step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Template</div>
            </div>
            <div class="wizard-step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Basic Info</div>
            </div>
            <div class="wizard-step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">URLs</div>
            </div>
            <div class="wizard-step" data-step="4">
                <div class="step-number">4</div>
                <div class="step-label">Pixels</div>
            </div>
            <div class="wizard-step" data-step="5">
                <div class="step-number">5</div>
                <div class="step-label">Review</div>
            </div>
        </div>

        <div class="wizard-content">
            <!-- Step 1: Template Selection -->
            <div class="step-content active" data-step="1">
                <h3 class="mb-4">Choose a Platform Template</h3>
                <p class="text-muted">Select a pre-configured template optimized for your traffic source</p>

                <div class="template-grid">
                    <?php foreach ($templates as $key => $template): ?>
                        <div class="template-card" data-template="<?= $key ?>" onclick="selectTemplate('<?= $key ?>')">
                            <div class="template-icon"><?= $template['icon'] ?></div>
                            <div class="template-name"><?= $template['name'] ?></div>
                            <div class="template-category"><?= $template['category'] ?></div>
                            <div class="template-description"><?= $template['description'] ?></div>
                            <div class="template-features">
                                <?php foreach (array_slice($template['recommended'], 0, 3) as $feature): ?>
                                    <div class="template-feature">
                                        <i class="fas fa-check-circle"></i>
                                        <?= $feature ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Step 2: Basic Info -->
            <div class="step-content" data-step="2">
                <h3 class="mb-4">Campaign Information</h3>

                <div class="form-section">
                    <h4>Basic Details</h4>
                    <div class="form-group">
                        <label>Campaign Name *</label>
                        <input type="text" class="form-control" id="campaign_name" placeholder="e.g., Facebook Weight Loss Q1 2026" required>
                        <small class="form-text text-muted">Choose a descriptive name to identify this campaign</small>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="campaign_status">
                            <option value="active">Active</option>
                            <option value="paused">Paused</option>
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <h4>Selected Template</h4>
                    <div id="selected_template_info" class="alert alert-info">
                        <strong id="template_name_display"></strong>
                        <p class="mb-0 mt-2" id="template_desc_display"></p>
                    </div>
                </div>
            </div>

            <!-- Step 3: URLs -->
            <div class="step-content" data-step="3">
                <h3 class="mb-4">URL Configuration</h3>

                <div class="form-section">
                    <h4>White Pages (Safe Content)</h4>
                    <p class="text-muted">URLs shown to bots and moderators</p>

                    <div class="form-group">
                        <label>White Page Action</label>
                        <select class="form-control" id="white_action">
                            <option value="redirect">Redirect (302/303 to external URL)</option>
                            <option value="folder">Folder (serve local HTML files)</option>
                            <option value="curl">CURL (proxy external site content)</option>
                        </select>
                        <small class="form-text text-muted">How to handle blocked traffic</small>
                    </div>

                    <div class="url-list" id="white_urls">
                        <div class="url-item">
                            <input type="text" class="form-control white-url" placeholder="https://example.com/safe-page">
                            <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addWhiteUrl()">
                        <i class="fas fa-plus"></i> Add White URL
                    </button>
                </div>

                <div class="form-section">
                    <h4>Black Prelandings (Pre-sell Pages)</h4>
                    <p class="text-muted">Pre-landing pages shown before the main offer</p>
                    <div class="url-list" id="black_prelandings">
                        <div class="url-item">
                            <input type="text" class="form-control prelanding-url" placeholder="https://example.com/prelanding">
                            <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addPrelandingUrl()">
                        <i class="fas fa-plus"></i> Add Prelanding
                    </button>
                </div>

                <div class="form-section">
                    <h4>Black Landings (Main Offer Pages)</h4>
                    <p class="text-muted">Main landing pages with conversion forms</p>
                    <div class="url-list" id="black_landings">
                        <div class="url-item">
                            <input type="text" class="form-control landing-url" placeholder="https://example.com/landing">
                            <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addLandingUrl()">
                        <i class="fas fa-plus"></i> Add Landing
                    </button>
                </div>
            </div>

            <!-- Step 4: Pixels -->
            <div class="step-content" data-step="4">
                <h3 class="mb-4">Tracking Pixels</h3>

                <div class="form-section">
                    <h4>Facebook Pixel</h4>
                    <div class="form-group">
                        <label>Pixel ID</label>
                        <input type="text" class="form-control" id="facebook_pixel" placeholder="123456789012345">
                        <small class="form-text text-muted">Your Facebook Pixel ID (15 digits)</small>
                    </div>
                </div>

                <div class="form-section">
                    <h4>TikTok Pixel</h4>
                    <div class="form-group">
                        <label>Pixel ID</label>
                        <input type="text" class="form-control" id="tiktok_pixel" placeholder="ABCDEFGHIJKLMNOP">
                        <small class="form-text text-muted">Your TikTok Pixel ID</small>
                    </div>
                </div>

                <div class="form-section">
                    <h4>Google Tag Manager</h4>
                    <div class="form-group">
                        <label>GTM Container ID</label>
                        <input type="text" class="form-control" id="gtm_id" placeholder="GTM-XXXXXXX">
                        <small class="form-text text-muted">Your Google Tag Manager container ID</small>
                    </div>
                </div>
            </div>

            <!-- Step 5: Review -->
            <div class="step-content" data-step="5">
                <h3 class="mb-4">Review & Create</h3>

                <div class="review-section">
                    <h5>Campaign Details</h5>
                    <div class="review-item">
                        <span class="review-label">Name:</span>
                        <span class="review-value" id="review_name"></span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">Template:</span>
                        <span class="review-value" id="review_template"></span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">Status:</span>
                        <span class="review-value" id="review_status"></span>
                    </div>
                </div>

                <div class="review-section">
                    <h5>URLs</h5>
                    <div class="review-item">
                        <span class="review-label">White Page Action:</span>
                        <span class="review-value" id="review_white_action"></span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">White Pages:</span>
                        <span class="review-value" id="review_white_count"></span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">Prelandings:</span>
                        <span class="review-value" id="review_prelanding_count"></span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">Landings:</span>
                        <span class="review-value" id="review_landing_count"></span>
                    </div>
                </div>

                <div class="review-section">
                    <h5>Tracking Pixels</h5>
                    <div class="review-item">
                        <span class="review-label">Facebook:</span>
                        <span class="review-value" id="review_fb_pixel"></span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">TikTok:</span>
                        <span class="review-value" id="review_tt_pixel"></span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">GTM:</span>
                        <span class="review-value" id="review_gtm"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="wizard-actions">
            <button type="button" class="btn btn-secondary" id="btn_prev" onclick="prevStep()" style="display: none;">
                <i class="fas fa-arrow-left"></i> Previous
            </button>
            <div></div>
            <button type="button" class="btn btn-primary" id="btn_next" onclick="nextStep()">
                Next <i class="fas fa-arrow-right"></i>
            </button>
            <button type="button" class="btn btn-success" id="btn_create" onclick="createCampaign()" style="display: none;">
                <i class="fas fa-check"></i> Create Campaign
            </button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 1;
        let selectedTemplate = null;
        const templates = <?= json_encode($templates) ?>;

        function selectTemplate(key) {
            selectedTemplate = key;
            $('.template-card').removeClass('selected');
            $(`.template-card[data-template="${key}"]`).addClass('selected');
        }

        function nextStep() {
            if (currentStep === 1 && !selectedTemplate) {
                alert('Please select a template');
                return;
            }

            if (currentStep === 2) {
                const name = $('#campaign_name').val().trim();
                if (!name) {
                    alert('Please enter a campaign name');
                    return;
                }
            }

            if (currentStep < 5) {
                currentStep++;
                updateWizard();
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateWizard();
            }
        }

        function updateWizard() {
            // Update steps
            $('.wizard-step').removeClass('active completed');
            $('.wizard-step').each(function() {
                const step = parseInt($(this).data('step'));
                if (step < currentStep) {
                    $(this).addClass('completed');
                } else if (step === currentStep) {
                    $(this).addClass('active');
                }
            });

            // Update content
            $('.step-content').removeClass('active');
            $(`.step-content[data-step="${currentStep}"]`).addClass('active');

            // Update buttons
            $('#btn_prev').toggle(currentStep > 1);
            $('#btn_next').toggle(currentStep < 5);
            $('#btn_create').toggle(currentStep === 5);

            // Update step 2 template info
            if (currentStep === 2 && selectedTemplate) {
                const template = templates[selectedTemplate];
                $('#template_name_display').text(template.name);
                $('#template_desc_display').text(template.description);
            }

            // Update review
            if (currentStep === 5) {
                updateReview();
            }
        }

        function updateReview() {
            const template = templates[selectedTemplate];
            $('#review_name').text($('#campaign_name').val() || 'Not set');
            $('#review_template').text(template.name);
            $('#review_status').text($('#campaign_status').val());

            const whiteAction = $('#white_action').val();
            const whiteActionLabels = {
                'redirect': 'Redirect',
                'folder': 'Folder',
                'curl': 'CURL Proxy'
            };
            $('#review_white_action').text(whiteActionLabels[whiteAction] || whiteAction);

            const whiteUrls = $('.white-url').map(function() { return $(this).val(); }).get().filter(v => v);
            const prelandingUrls = $('.prelanding-url').map(function() { return $(this).val(); }).get().filter(v => v);
            const landingUrls = $('.landing-url').map(function() { return $(this).val(); }).get().filter(v => v);

            $('#review_white_count').text(whiteUrls.length + ' URL(s)');
            $('#review_prelanding_count').text(prelandingUrls.length + ' URL(s)');
            $('#review_landing_count').text(landingUrls.length + ' URL(s)');

            $('#review_fb_pixel').text($('#facebook_pixel').val() || 'Not set');
            $('#review_tt_pixel').text($('#tiktok_pixel').val() || 'Not set');
            $('#review_gtm').text($('#gtm_id').val() || 'Not set');
        }

        function addWhiteUrl() {
            $('#white_urls').append(`
                <div class="url-item">
                    <input type="text" class="form-control white-url" placeholder="https://example.com/safe-page">
                    <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `);
        }

        function addPrelandingUrl() {
            $('#black_prelandings').append(`
                <div class="url-item">
                    <input type="text" class="form-control prelanding-url" placeholder="https://example.com/prelanding">
                    <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `);
        }

        function addLandingUrl() {
            $('#black_landings').append(`
                <div class="url-item">
                    <input type="text" class="form-control landing-url" placeholder="https://example.com/landing">
                    <button type="button" class="btn btn-danger" onclick="removeUrl(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `);
        }

        function removeUrl(btn) {
            $(btn).closest('.url-item').remove();
        }

        function createCampaign() {
            const whiteUrls = $('.white-url').map(function() { return $(this).val(); }).get().filter(v => v);
            const prelandingUrls = $('.prelanding-url').map(function() { return $(this).val(); }).get().filter(v => v);
            const landingUrls = $('.landing-url').map(function() { return $(this).val(); }).get().filter(v => v);

            const data = {
                action: 'create',
                name: $('#campaign_name').val(),
                template: selectedTemplate,
                status: $('#campaign_status').val(),
                white_action: $('#white_action').val(),
                white_urls: whiteUrls,
                black_prelandings: prelandingUrls,
                black_landings: landingUrls,
                facebook_pixel: $('#facebook_pixel').val(),
                tiktok_pixel: $('#tiktok_pixel').val(),
                gtm_id: $('#gtm_id').val(),
                settings: templates[selectedTemplate].settings
            };

            $.post('api.php', data, function(response) {
                if (response.success) {
                    alert('Campaign created successfully!');
                    window.location.href = 'index.php';
                } else {
                    alert('Error: ' + response.error);
                }
            }, 'json');
        }
    </script>
</body>
</html>
