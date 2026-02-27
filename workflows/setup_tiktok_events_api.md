# Setup TikTok Events API

Configure server-side conversion tracking for TikTok Ads to bypass iOS privacy restrictions and ad blockers.

## Objective
Enable TikTok Events API (server-side tracking) to send Lead and Purchase events directly from your server to TikTok, ensuring accurate conversion tracking even when client-side pixels are blocked.

## Prerequisites
- TikTok Ads account with active campaigns
- TikTok Pixel ID
- TikTok Events API Access Token

## Steps

### 1. Get TikTok Events API Access Token

1. Go to TikTok Ads Manager: https://ads.tiktok.com/
2. Navigate to **Assets** → **Events**
3. Select your pixel
4. Click **Settings** → **Generate Access Token**
5. Copy the access token (starts with a long alphanumeric string)

### 2. Configure settings.json

Edit `settings.json` and update the TikTok Events API section:

```json
{
  "pixels": {
    "tt": {
      "subname": "tpx",
      "pageview": true,
      "viewcontent": {
        "use": true,
        "time": "30",
        "percent": "75"
      },
      "conversion": {
        "event": "Purchase",
        "fireonbutton": false
      },
      "eventsapi": {
        "enabled": true,
        "accesstoken": "YOUR_TIKTOK_ACCESS_TOKEN_HERE",
        "testcode": "",
        "leadevent": "SubmitForm"
      }
    }
  }
}
```

**Configuration Options:**
- `enabled`: Set to `true` to enable TikTok Events API
- `accesstoken`: Your TikTok Events API access token
- `testcode`: Optional test event code for debugging (leave empty for production)
- `leadevent`: Event name for lead submissions (default: `SubmitForm`, can also use `CompleteRegistration`)

### 3. Pass TikTok Pixel ID via URL

Add the TikTok Pixel ID to your campaign URLs using the `tpx` parameter:

```
https://your.domain/?tpx=YOUR_TIKTOK_PIXEL_ID&subid=123
```

The pixel ID will be stored in a cookie and used for all conversion events.

### 4. Verify Integration

After configuration, test the integration:

1. **Submit a test lead:**
   - Visit your landing page with `?tpx=YOUR_PIXEL_ID`
   - Fill out and submit the form
   - Check logs: `pblogs/DD.MM.YY.ttevents.log`

2. **Check TikTok Events Manager:**
   - Go to TikTok Ads Manager → Events
   - Select your pixel
   - Click **Test Events** tab
   - You should see `SubmitForm` events appearing

3. **Test Purchase event (postback):**
   - Trigger a postback: `https://your.domain/postback.php?subid=123&status=purchase&payout=50`
   - Check logs: `pblogs/DD.MM.YY.ttevents.log`
   - Verify `PlaceAnOrder` event appears in TikTok Events Manager

## Event Flow

### Lead Event (Form Submission)
1. User visits landing page with `?tpx=PIXEL_ID`
2. User fills out form and submits
3. `send.php` calls `tt_send_lead()`
4. Server sends `SubmitForm` event to TikTok Events API
5. Event logged to `pblogs/DD.MM.YY.ttevents.log`

### Purchase Event (Postback)
1. Affiliate network sends postback: `postback.php?subid=123&status=purchase&payout=50`
2. `postback.php` calls `tt_send_purchase()`
3. Server sends `PlaceAnOrder` event with value and currency to TikTok Events API
4. Event logged to `pblogs/DD.MM.YY.ttevents.log`

## Deduplication

The system automatically deduplicates events between client-side pixel and server-side API:
- Each event gets a unique `event_id`
- Event ID is stored in `tt_event_id` cookie
- TikTok uses this ID to prevent double-counting

## User Data Matching

TikTok Events API sends hashed user data for better conversion matching:
- **Phone**: SHA256 hashed, normalized (digits only)
- **Email**: SHA256 hashed (if available)
- **IP Address**: Raw IP (Cloudflare-aware)
- **User Agent**: Raw user agent string
- **TikTok Click ID**: `ttclid` cookie (if available)
- **TikTok Browser ID**: `_ttp` cookie (if available)
- **External ID**: Hashed subid for cross-platform matching

## Troubleshooting

### Events Not Appearing in TikTok
- **Issue**: No events in TikTok Events Manager
- **Fix**:
  - Verify `eventsapi.enabled` is `true` in `settings.json`
  - Check access token is correct and not expired
  - Verify pixel ID is being passed via URL (`?tpx=PIXEL_ID`)
  - Check logs: `pblogs/DD.MM.YY.ttevents.log` for HTTP errors

### HTTP 401 Unauthorized
- **Issue**: Log shows `code=401`
- **Fix**: Access token is invalid or expired. Generate a new token in TikTok Ads Manager.

### HTTP 400 Bad Request
- **Issue**: Log shows `code=400`
- **Fix**: Check that pixel ID is correct. Verify event payload structure in logs.

### Events Duplicating
- **Issue**: Same conversion counted twice
- **Fix**: Ensure `event_id` cookie is being set correctly. Check `ttcapi.php:115` for cookie setting.

### No Pixel ID Found
- **Issue**: Log shows "No pixel_id or token"
- **Fix**: Ensure URL includes `?tpx=PIXEL_ID` parameter. Check that `$ttpixel_subname` is set to `"tpx"` in `settings.php`.

## Log Files

All TikTok Events API calls are logged to:
```
pblogs/DD.MM.YY.ttevents.log
```

Log format:
```
2026-02-28 01:30:45 SubmitForm pixel=C9ABC123XYZ code=200 response={"code":0,"message":"OK"}
2026-02-28 01:35:12 PlaceAnOrder pixel=C9ABC123XYZ code=200 response={"code":0,"message":"OK"}
```

## Testing with Test Events

To test without affecting production data:

1. Get test event code from TikTok Ads Manager → Events → Test Events
2. Add to `settings.json`:
   ```json
   "eventsapi": {
     "enabled": true,
     "accesstoken": "YOUR_TOKEN",
     "testcode": "TEST123ABC"
   }
   ```
3. Submit test conversions
4. View results in TikTok Ads Manager → Test Events tab
5. Remove `testcode` when ready for production

## Expected Output

Successful TikTok Events API integration:
- ✓ Lead events appear in TikTok Events Manager within 1-2 minutes
- ✓ Purchase events appear with correct value and currency
- ✓ Conversion attribution improves (more conversions matched to campaigns)
- ✓ iOS 14.5+ conversions are tracked accurately
- ✓ Ad blocker bypass ensures all conversions are counted
