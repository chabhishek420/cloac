# YellowCloaker Workflows

Standard Operating Procedures for YellowCloaker development, deployment, and operations.

## Core Workflows

### Setup & Configuration
- **[setup_environment.md](setup_environment.md)** - Initial environment setup, dependencies, HTTPS configuration
- **[manage_settings.md](manage_settings.md)** - Add/modify settings in settings.json and admin UI

### Traffic Filtering & Detection
- **[debug_traffic_routing.md](debug_traffic_routing.md)** - Diagnose why traffic is being classified as white/black
- **[test_filters.md](test_filters.md)** - Test individual filter logic (GeoIP, bot detection, VPN checks)
- **[automate_ip_updates.md](automate_ip_updates.md)** - Automatically update bot IP ranges from GitHub sources
- **[setup_botd_detection.md](setup_botd_detection.md)** - Configure BotD for advanced bot detection (headless browsers, automation frameworks)

### HTML Processing & Injection
- **[add_landing_page.md](add_landing_page.md)** - Add new landing/prelanding pages with proper URL rewriting
- **[inject_pixels.md](inject_pixels.md)** - Add Facebook, TikTok, GTM, or Yandex pixels to pages

### Server-Side Conversion Tracking
- **[setup_tiktok_events_api.md](setup_tiktok_events_api.md)** - Configure TikTok Events API for server-side conversion tracking
- **[setup_google_ads_tracking.md](setup_google_ads_tracking.md)** - Setup Google Ads conversion tracking with GCLID capture and CSV export

### Database & Tracking
- **[verify_conversions.md](verify_conversions.md)** - Check if leads/clicks are being recorded correctly
- **[export_statistics.md](export_statistics.md)** - Pull click/lead data from SleekDB logs

### Deployment
- **[deploy_to_server.md](deploy_to_server.md)** - Deploy cloaker to production via FTP/SCP
- **[rollback_deployment.md](rollback_deployment.md)** - Revert to previous version if deployment fails

### Testing & Verification
- **[manual_traffic_test.md](manual_traffic_test.md)** - Test traffic routing with different user agents, IPs, countries
- **[verify_https.md](verify_https.md)** - Ensure HTTPS certificate is valid and cloaker works over HTTPS

## How to Use

1. **Identify your task** - Find the relevant workflow above
2. **Read the workflow** - Understand the objective, inputs, and expected outputs
3. **Execute tools** - Run the tools specified in the workflow
4. **Handle edge cases** - Follow the workflow's guidance for failures
5. **Update workflow** - If you discover new constraints or better methods, update the workflow

## Workflow Structure

Each workflow includes:
- **Objective** - What you're trying to accomplish
- **Inputs** - Required information/files before starting
- **Steps** - Ordered sequence of actions
- **Tools** - Which Python scripts or manual steps to use
- **Expected Output** - What success looks like
- **Edge Cases** - Common failures and how to handle them
- **Verification** - How to confirm the task completed successfully
