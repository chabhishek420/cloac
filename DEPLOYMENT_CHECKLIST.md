# YellowCloaker Deployment Checklist

**Date:** February 28, 2026
**Version:** 2.0 (TikTok Events API + Automated IP Updates)

## Pre-Deployment Verification ✓

### Code Quality
- [x] All PHP files syntax validated (no errors)
- [x] TikTok Events API implementation complete (193 lines)
- [x] IP updater tool tested (71,651 ranges fetched)
- [x] Database schema updated (TikTok tracking fields added)
- [x] Settings configuration added (disabled by default)

### Files Modified
```
M  CLAUDE.md                    # Updated project documentation
M  db.php                        # Added TikTok tracking fields
M  postback.php                  # Added TikTok Events API integration
M  send.php                      # Added TikTok Events API integration
M  settings.json                 # Added TikTok Events API config
M  settings.php                  # Loaded TikTok Events API settings
M  bases/bots.txt                # Updated with 71,651 IP ranges
```

### New Files Created
```
??  ttcapi.php                   # TikTok Events API implementation
??  tools/update_ip_ranges.py    # IP automation tool
??  workflows/*.md               # 10 workflow documentation files
??  IMPLEMENTATION_SUMMARY.md    # Technical summary
??  .env.example                 # Environment template
```

---

## Deployment Steps

### Step 1: Backup Current Production
```bash
# Create backup of current production files
tar -czf yellowcloaker_backup_$(date +%Y%m%d_%H%M%S).tar.gz \
  *.php settings.json bases/bots.txt
```

### Step 2: Deploy New Files
```bash
# Upload new files via FTP/SCP
scp ttcapi.php user@server:/path/to/YellowCloaker/
scp -r tools/ user@server:/path/to/YellowCloaker/
scp -r workflows/ user@server:/path/to/YellowCloaker/
```

### Step 3: Deploy Modified Files
```bash
# Upload modified files
scp send.php postback.php db.php settings.php settings.json \
  user@server:/path/to/YellowCloaker/
```

### Step 4: Update IP Ranges
```bash
# SSH into server and run IP updater
ssh user@server
cd /path/to/YellowCloaker
python3 tools/update_ip_ranges.py
```

### Step 5: Verify Permissions
```bash
# Ensure web server can write to logs
chown -R www-data:www-data logs/ pblogs/
chmod 755 logs/ pblogs/
chmod 644 bases/bots.txt
```

### Step 6: Test Basic Functionality
```bash
# Test PHP syntax on server
php -l ttcapi.php
php -l send.php
php -l postback.php

# Test traffic routing
curl -I https://your.domain/
```

---

## Post-Deployment Testing

### Test 1: IP Range Detection
- [ ] Access site from Google IP (should be blocked)
- [ ] Access site from residential IP (should pass)
- [ ] Verify admin statistics show correct classification

### Test 2: TikTok Events API (If Enabled)
- [ ] Configure access token in settings.json
- [ ] Submit test lead with `?tpx=PIXEL_ID`
- [ ] Check logs: `pblogs/DD.MM.YY.ttevents.log`
- [ ] Verify event in TikTok Events Manager
- [ ] Test purchase postback
- [ ] Verify Purchase event in TikTok

### Test 3: Facebook CAPI (Existing)
- [ ] Submit test lead with `?px=PIXEL_ID`
- [ ] Check logs: `pblogs/DD.MM.YY.capi.log`
- [ ] Verify event in Facebook Events Manager

### Test 4: Database Integrity
- [ ] Submit test lead
- [ ] Check admin panel → Leads
- [ ] Verify TikTok fields populated (ttp, ttclid, ttpixelid)
- [ ] Verify Facebook fields still working (fbp, fbclid, pixelid)

---

## Configuration Guide

### Enable TikTok Events API

1. **Get Access Token:**
   - Go to TikTok Ads Manager → Assets → Events
   - Select your pixel → Settings → Generate Access Token
   - Copy the token

2. **Update settings.json:**
   ```json
   "pixels": {
     "tt": {
       "eventsapi": {
         "enabled": true,
         "accesstoken": "YOUR_TIKTOK_ACCESS_TOKEN",
         "testcode": "",
         "leadevent": "SubmitForm"
       }
     }
   }
   ```

3. **Test Integration:**
   ```bash
   # Submit test lead
   curl -X POST https://your.domain/send.php \
     -d "name=Test User" \
     -d "phone=1234567890" \
     -d "subid=test123" \
     -b "tpx=YOUR_PIXEL_ID"

   # Check logs
   tail -f pblogs/$(date +%d.%m.%y).ttevents.log
   ```

### Setup Automated IP Updates

**Option 1: Cron (Recommended)**
```bash
# Add to crontab
crontab -e

# Run daily at 3 AM
0 3 * * * cd /path/to/YellowCloaker && python3 tools/update_ip_ranges.py >> logs/ip_update.log 2>&1
```

**Option 2: Systemd Timer**
```bash
# See workflows/automate_ip_updates.md for full setup
systemctl enable yellowcloaker-ip-update.timer
systemctl start yellowcloaker-ip-update.timer
```

---

## Rollback Plan

If issues occur, rollback is simple:

### Quick Rollback (Disable TikTok API)
```json
// In settings.json
"eventsapi": {
  "enabled": false
}
```

### Full Rollback (Restore Backup)
```bash
# Extract backup
tar -xzf yellowcloaker_backup_YYYYMMDD_HHMMSS.tar.gz

# Restore files
cp backup/*.php .
cp backup/settings.json .
cp backup/bases/bots.txt bases/

# Remove new files
rm ttcapi.php
rm -rf tools/ workflows/
```

---

## Monitoring & Maintenance

### Daily Checks
- [ ] Check IP updater logs: `logs/ip_update.log`
- [ ] Monitor conversion logs: `pblogs/*.ttevents.log`, `pblogs/*.capi.log`
- [ ] Review admin statistics for anomalies

### Weekly Checks
- [ ] Verify IP range count: `wc -l bases/bots.txt` (should be ~70k+)
- [ ] Check TikTok Events Manager for conversion data
- [ ] Review error logs for API failures

### Monthly Checks
- [ ] Verify TikTok access token hasn't expired
- [ ] Review and update workflows documentation
- [ ] Check for new IP sources in lord-alfred/ipranges

---

## Troubleshooting

### TikTok Events API Not Working
1. Check `eventsapi.enabled` is `true`
2. Verify access token is correct
3. Check logs: `pblogs/DD.MM.YY.ttevents.log`
4. Test with `testcode` in TikTok Events Manager

### IP Updater Failing
1. Check network connectivity to GitHub
2. Verify Python 3 is installed
3. Check file permissions on `bases/bots.txt`
4. Run with `--verbose` flag for detailed errors

### Conversions Not Tracking
1. Verify HTTPS is enabled (required for pixels)
2. Check cookie settings (SameSite=None; Secure)
3. Verify pixel ID is passed via URL
4. Check database for lead records

---

## Success Metrics

After deployment, you should see:
- ✓ Bot detection accuracy improved (more bots blocked)
- ✓ TikTok conversions tracked server-side (iOS 14.5+ working)
- ✓ Zero manual IP range maintenance required
- ✓ Conversion logs showing both Facebook and TikTok events
- ✓ Admin statistics showing accurate traffic classification

---

## Next Phase (Optional)

### Priority 1: Google Ads Enhanced Conversions
- Estimated time: 2-3 hours
- Impact: High (closes another major gap)
- See: `IMPLEMENTATION_SUMMARY.md` for details

### Priority 2: Advanced Fingerprinting
- Estimated time: 1-2 days
- Impact: High (1,600+ signals vs current basic detection)
- Requires: FingerprintJS integration

### Priority 3: ML-Based Scoring
- Estimated time: 1-2 weeks
- Impact: High (matches premium competitors)
- Requires: Training data collection + model deployment

---

## Support & Documentation

- **Workflows:** See `workflows/` directory for detailed SOPs
- **Technical Summary:** See `IMPLEMENTATION_SUMMARY.md`
- **Competitor Research:** See original research report
- **Issues:** Check PHP error logs and `pblogs/` directory

---

**Deployment Status:** Ready for Production ✓
**Breaking Changes:** None (all changes backward-compatible)
**Rollback Risk:** Low (simple disable via settings.json)
