# Setup Google Ads Conversion Tracking

Track Google Ads conversions using GCLID (Google Click ID) capture and offline conversion imports.

## Objective
Enable Google Ads conversion tracking by capturing GCLID with each conversion and exporting them to CSV format for Google Ads offline conversion import.

## Why This Approach?

**Google Ads API Complexity:**
- Requires OAuth2 authentication (developer token, client ID, client secret, refresh token)
- Needs Google Ads API PHP library (Composer dependency)
- Goes against YellowCloaker's "no Composer, simple deployment" philosophy

**Our Pragmatic Solution:**
- ✓ Capture GCLID with every conversion
- ✓ Export to CSV for manual upload
- ✓ No external dependencies
- ✓ Simple deployment
- ✓ Works immediately

## How It Works

### 1. GCLID Capture
When a visitor clicks a Google Ads ad, Google appends `?gclid=` to the URL:
```
https://your.domain/?gclid=Cj0KCQiA...&subid=123
```

YellowCloaker automatically:
- Captures the GCLID from the URL
- Stores it in a cookie
- Associates it with the conversion when the form is submitted

### 2. Conversion Storage
When a lead is submitted:
- GCLID is stored in the database alongside name, phone, subid
- Available for export at any time

### 3. CSV Export
Use the export tool to generate Google Ads offline conversion CSV files:
```bash
python3 tools/export_google_conversions.py --days 7
```

### 4. Manual Upload
Upload the CSV to Google Ads:
- Go to Google Ads → Tools → Conversions
- Click "Uploads" → "Upload"
- Select your conversion action
- Upload the CSV file

## Setup Steps

### Step 1: Verify GCLID Tracking is Active

GCLID tracking is automatically enabled. No configuration needed.

**Test it:**
1. Visit your landing page with `?gclid=TEST123`
2. Submit a test lead
3. Check admin panel → Leads
4. Verify GCLID appears in the lead data

### Step 2: Create Conversion Action in Google Ads

1. Go to Google Ads → Tools → Conversions
2. Click "New conversion action"
3. Select "Import" → "Other data sources or CRMs"
4. Choose "Track conversions from clicks"
5. Name it (e.g., "Lead")
6. Set category: "Lead"
7. Set value: Use different values for each conversion (if tracking payout)
8. Click "Create and continue"

### Step 3: Export Conversions

Run the export tool to generate a CSV file:

```bash
# Export last 7 days of leads
python3 tools/export_google_conversions.py --days 7

# Export last 30 days
python3 tools/export_google_conversions.py --days 30

# Export with custom conversion name
python3 tools/export_google_conversions.py --days 7 --conversion-name "Lead"

# Export to specific file
python3 tools/export_google_conversions.py --days 7 --output /path/to/conversions.csv
```

**Output:**
```
============================================================
Google Ads Offline Conversion Exporter
============================================================
Project root: /var/www/YellowCloaker
Logs directory: /var/www/YellowCloaker/logs
Days filter: 7
Status filter: Lead

Reading leads from SleekDB...
Found 150 total leads
Filtering leads (last 7 days, status=Lead, with GCLID)...
Filtered to 45 leads with GCLID

Exporting to .tmp/google_conversions_20260228_015030.csv...
✓ Exported 45 conversions to .tmp/google_conversions_20260228_015030.csv

============================================================
✓ Export completed successfully
============================================================
File: .tmp/google_conversions_20260228_015030.csv
Conversions: 45

Next steps:
1. Go to Google Ads → Tools → Conversions
2. Click 'Uploads' → 'Upload'
3. Select your conversion action
4. Upload the CSV file
```

### Step 4: Upload to Google Ads

1. Go to Google Ads → Tools → Conversions
2. Click "Uploads" → "Upload"
3. Select your conversion action (e.g., "Lead")
4. Click "Choose file" and select the exported CSV
5. Click "Upload"
6. Wait for processing (usually 1-2 minutes)
7. Check for errors or warnings

### Step 5: Verify Conversions

After upload:
1. Go to Google Ads → Campaigns
2. Add "Conversions" column
3. Wait 3-6 hours for data to populate
4. Verify conversions are attributed to campaigns

## CSV Format

The export tool generates CSV files in Google Ads offline conversion format:

```csv
Google Click ID,Conversion Name,Conversion Time,Conversion Value,Conversion Currency
Cj0KCQiA...,Lead,2026-02-28 01:30:45+00:00,50.00,USD
Cj0KCQiB...,Lead,2026-02-28 02:15:22+00:00,,
```

**Fields:**
- **Google Click ID** (required): GCLID from the ad click
- **Conversion Name** (required): Must match your conversion action name in Google Ads
- **Conversion Time** (required): When the conversion occurred (UTC)
- **Conversion Value** (optional): Payout amount (from postback)
- **Conversion Currency** (optional): Currency code (default: USD)

## Automation Options

### Option 1: Cron Job (Daily Upload)
```bash
# Add to crontab
crontab -e

# Export and upload daily at 3 AM
0 3 * * * cd /path/to/YellowCloaker && python3 tools/export_google_conversions.py --days 1 >> logs/google_export.log 2>&1
```

Then manually upload the CSV daily, or use Google Ads API for full automation.

### Option 2: Google Ads API (Full Automation)
For fully automated uploads without manual CSV uploads, you'll need to:
1. Set up Google Ads API credentials
2. Install Google Ads API PHP library (requires Composer)
3. Implement API upload script

See `workflows/google_ads_api_setup.md` for advanced setup (future documentation).

## Troubleshooting

### No Conversions Exported
**Issue:** Export tool shows "0 leads with GCLID"

**Fixes:**
1. Verify Google Ads campaigns are passing `?gclid=` parameter
2. Check that `set_google_cookies()` is being called in `main.php:113`
3. Ensure leads have been submitted in the specified time range
4. Test manually: visit `https://your.domain/?gclid=TEST123` and submit a lead

### GCLID Not Captured
**Issue:** Leads in database have empty GCLID field

**Fixes:**
1. Verify `set_google_cookies()` is called in `main.php`
2. Check that cookies are enabled (HTTPS required)
3. Test with `?gclid=TEST123` in URL
4. Check browser console for cookie errors

### Upload Fails in Google Ads
**Issue:** Google Ads rejects the CSV upload

**Fixes:**
1. Verify conversion action name matches exactly (case-sensitive)
2. Check that GCLID format is correct (starts with "Cj0K...")
3. Ensure conversion time is within 90 days
4. Verify CSV format matches Google's requirements

### Conversions Not Attributing
**Issue:** Conversions upload successfully but don't appear in campaigns

**Fixes:**
1. Wait 3-6 hours for data to populate
2. Verify GCLID is from an actual ad click (not manually typed)
3. Check that conversion action is enabled
4. Ensure conversion time is within attribution window (default: 30 days)

## Advanced: Purchase Events

The export tool automatically includes payout values from postback updates:

1. Lead is submitted → stored with GCLID
2. Affiliate network sends postback → payout is updated in database
3. Export tool includes payout in "Conversion Value" column
4. Google Ads receives revenue data for ROAS optimization

**Example:**
```csv
Google Click ID,Conversion Name,Conversion Time,Conversion Value,Conversion Currency
Cj0KCQiA...,Purchase,2026-02-28 01:30:45+00:00,50.00,USD
```

## Comparison: Manual CSV vs. API

| Feature | Manual CSV Upload | Google Ads API |
|---------|-------------------|----------------|
| Setup Complexity | Low | High |
| Dependencies | None | Composer, OAuth2 |
| Automation | Partial (cron + manual upload) | Full |
| Real-time | No (batch daily) | Yes |
| Deployment | Simple | Complex |
| Cost | Free | Free (API quota) |

**Recommendation:** Start with manual CSV uploads. Upgrade to API only if you need real-time automation.

## Expected Results

After implementing Google Ads conversion tracking:
- ✓ GCLID captured with every conversion
- ✓ Conversions exportable to CSV format
- ✓ Manual upload to Google Ads works
- ✓ Conversions attributed to campaigns
- ✓ ROAS optimization enabled (with payout data)
- ✓ No external dependencies required
- ✓ Simple deployment maintained

## Next Steps

1. Test GCLID capture with `?gclid=TEST123`
2. Submit test lead and verify GCLID is stored
3. Export conversions to CSV
4. Upload to Google Ads
5. Verify conversions appear in campaigns
6. Set up daily cron job for automated exports
