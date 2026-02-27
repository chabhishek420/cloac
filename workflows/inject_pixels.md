# Inject Pixels

Add Facebook, TikTok, GTM, or Yandex pixels to landing pages for conversion tracking.

## Objective
Inject conversion tracking pixels into landing pages so that conversions are tracked across advertising platforms.

## Inputs
- Pixel type: Facebook, TikTok, GTM, or Yandex
- Pixel ID or configuration
- Which pages to inject into (all, specific landing pages, etc.)

## Steps

### 1. Add Pixel ID to settings.json
```json
{
  "facebook_pixel_id": "123456789",
  "tiktok_pixel_id": "987654321",
  "gtm_id": "GTM-XXXXXX",
  "yandex_metrica_id": "12345678"
}
```

### 2. Load Pixel Settings in settings.php
```php
$facebook_pixel_id = $config->get('facebook_pixel_id', '');
$tiktok_pixel_id = $config->get('tiktok_pixel_id', '');
$gtm_id = $config->get('gtm_id', '');
$yandex_metrica_id = $config->get('yandex_metrica_id', '');
```

### 3. Enable Pixel Injection in settings.json
```json
{
  "inject_facebook_pixel": true,
  "inject_tiktok_pixel": true,
  "inject_gtm": true,
  "inject_yandex": true
}
```

### 4. Review Pixel Functions in pixels.php
Each pixel type has injection functions:
- Facebook: `get_facebook_pixel()`, `insert_facebook_pixel_head()`, `insert_facebook_pixel_body()`
- TikTok: `get_tiktok_pixel()`, `insert_tiktok_pixel_head()`, `insert_tiktok_pixel_body()`
- GTM: `insert_gtm_script()`
- Yandex: `insert_yandex_script()`

### 5. Inject into Landing Pages
In `htmlprocessing.php`, pixels are injected during page load:
```php
$html = load_landing($page);
$html = full_facebook_pixel_processing($html);
$html = full_tiktok_pixel_processing($html);
$html = insert_gtm_script($html);
$html = insert_yandex_script($html);
```

### 6. Test Pixel Injection
Load a landing page and check page source for pixel code:
```bash
curl -s https://your.domain/landing/my_page/ | grep -i "facebook\|tiktok\|gtm\|yandex"
```

### 7. Verify Conversions in Pixel Dashboard
- Facebook Ads Manager: Check Events Manager for conversions
- TikTok Ads Manager: Check Pixel Events for conversions
- Google Tag Manager: Check Real-time view for events
- Yandex Metrica: Check Goals for conversions

## Tools
- Manual: Edit `settings.json` to add pixel IDs
- Manual: Edit `settings.php` to load pixel settings
- Manual: Review `pixels.php` for injection logic
- Manual: Test pixel injection via curl

## Expected Output
- Pixel IDs are stored in `settings.json`
- Pixel code appears in landing page HTML
- Conversions are tracked in pixel dashboards
- Admin statistics match pixel dashboard conversions

## Edge Cases

### Pixel Code Not Appearing
- **Issue**: Pixel code doesn't appear in page source
- **Fix**: Verify `inject_*_pixel` is set to `true` in `settings.json`. Check that pixel ID is not empty.

### Conversions Not Tracking
- **Issue**: Pixel code is present but conversions don't appear in dashboard
- **Fix**: Verify pixel ID is correct. Check that conversion script is being called (see `send.php`). Ensure HTTPS is enabled (required for pixel tracking).

### Multiple Pixels Conflicting
- **Issue**: Multiple pixels cause page to load slowly or break
- **Fix**: Disable unused pixels in `settings.json`. Check for duplicate pixel injections in `htmlprocessing.php`.

### Pixel ID Format Wrong
- **Issue**: Pixel dashboard shows no events
- **Fix**: Verify pixel ID format matches platform requirements (Facebook: numeric, TikTok: numeric, GTM: GTM-XXXXXX, Yandex: numeric).

## Verification
1. Pixel code appears in page source
2. Pixel dashboard shows events being fired
3. Conversions are tracked in pixel dashboard
4. Admin statistics match pixel dashboard data
5. Page load time is acceptable (< 3 seconds)
