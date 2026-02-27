# Automate IP Range Updates

Keep YellowCloaker's bot detection fresh by automatically updating IP ranges from authoritative sources.

## Objective
Automatically fetch and update bot IP ranges from GitHub repositories (lord-alfred/ipranges, platformbuilds/ip-ranges) to keep detection accurate without manual maintenance.

## What It Does
The `tools/update_ip_ranges.py` script:
- Fetches IP ranges for Google, Facebook, Microsoft, AWS, Cloudflare, DigitalOcean, Linode, OVH
- Merges all ranges into a single file
- Backs up the existing file before updating
- Writes to `bases/bots.txt` (used by `core.php` for bot detection)

## Manual Usage

### Test Run (Dry Run)
```bash
python3 tools/update_ip_ranges.py --dry-run --verbose
```

### Update IP Ranges
```bash
python3 tools/update_ip_ranges.py
```

This will:
1. Fetch ~70,000+ IP ranges from GitHub
2. Create backup: `bases/bots.txt.backup`
3. Write new ranges to `bases/bots.txt`

## Automated Updates

### Option 1: Cron Job (Linux/macOS)
Add to crontab to run daily at 3 AM:
```bash
crontab -e
```

Add this line:
```
0 3 * * * cd /path/to/YellowCloaker && python3 tools/update_ip_ranges.py >> logs/ip_update.log 2>&1
```

### Option 2: Systemd Timer (Linux)
Create `/etc/systemd/system/yellowcloaker-ip-update.service`:
```ini
[Unit]
Description=Update YellowCloaker IP Ranges
After=network.target

[Service]
Type=oneshot
User=www-data
WorkingDirectory=/var/www/YellowCloaker
ExecStart=/usr/bin/python3 tools/update_ip_ranges.py
StandardOutput=append:/var/www/YellowCloaker/logs/ip_update.log
StandardError=append:/var/www/YellowCloaker/logs/ip_update.log
```

Create `/etc/systemd/system/yellowcloaker-ip-update.timer`:
```ini
[Unit]
Description=Update YellowCloaker IP Ranges Daily

[Timer]
OnCalendar=daily
Persistent=true

[Install]
WantedBy=timers.target
```

Enable and start:
```bash
systemctl enable yellowcloaker-ip-update.timer
systemctl start yellowcloaker-ip-update.timer
```

### Option 3: GitHub Actions (If Using Git)
Create `.github/workflows/update-ip-ranges.yml`:
```yaml
name: Update IP Ranges
on:
  schedule:
    - cron: '0 3 * * *'  # Daily at 3 AM UTC
  workflow_dispatch:  # Manual trigger

jobs:
  update:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - uses: actions/setup-python@v4
        with:
          python-version: '3.x'
      - name: Update IP ranges
        run: python3 tools/update_ip_ranges.py
      - name: Commit changes
        run: |
          git config user.name "GitHub Actions"
          git config user.email "actions@github.com"
          git add bases/bots.txt
          git diff --staged --quiet || git commit -m "chore: update bot IP ranges"
          git push
```

## Expected Output

### Successful Run
```
============================================================
YellowCloaker IP Range Updater
============================================================
Project root: /var/www/YellowCloaker
Output file: /var/www/YellowCloaker/bases/bots.txt
Dry run: False

Fetching IP ranges from GitHub...
Fetching google IP ranges...
  ✓ Fetched 1366 ranges for google
Fetching facebook IP ranges...
  ✓ Fetched 1272 ranges for facebook
Fetching microsoft IP ranges...
  ✓ Fetched 62802 ranges for microsoft
...

Merging IP ranges...
Total unique ranges: 71651

Summary by platform:
  cloudflare     :     22 ranges
  digitalocean   :   1057 ranges
  facebook       :   1272 ranges
  google         :   1366 ranges
  linode         :   5132 ranges
  microsoft      :  62802 ranges

Created backup: bases/bots.txt.backup
✓ Wrote 71651 ranges to bases/bots.txt

============================================================
✓ IP ranges updated successfully
============================================================
```

## Verification

After updating, verify the new ranges are being used:
1. Check file size: `wc -l bases/bots.txt` (should show ~71,000+ lines)
2. Check header: `head -10 bases/bots.txt` (should show auto-generated timestamp)
3. Test detection: Access your cloaker from a Google IP and verify it's blocked

## Troubleshooting

### Script Fails to Fetch Ranges
- **Issue**: Network timeout or GitHub rate limiting
- **Fix**: Run with `--verbose` to see which source failed. Some sources (AWS, OVH) may return 404 if the repo structure changed.

### Permission Denied Writing File
- **Issue**: Script can't write to `bases/bots.txt`
- **Fix**: Ensure the user running the script has write permissions:
  ```bash
  chown www-data:www-data bases/bots.txt
  chmod 644 bases/bots.txt
  ```

### Backup File Not Created
- **Issue**: No space or permission issues
- **Fix**: Check disk space with `df -h` and ensure write permissions on `bases/` directory.

## What Gets Updated

The script updates detection for:
- **Google**: Googlebot, AdsBot-Google, Mediapartners-Google
- **Facebook/Meta**: facebookexternalhit, Facebot
- **Microsoft/Bing**: bingbot, msnbot
- **Cloudflare**: CDN IPs (often used by bots)
- **Data Centers**: DigitalOcean, Linode (common bot hosting)

These ranges are checked in `core.php:221-227` via the `IpUtils::checkIp()` function.
