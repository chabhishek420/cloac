# Debug Traffic Routing

Diagnose why traffic is being classified as white (blocked) or black (legitimate).

## Objective
Identify which filter is blocking traffic and why, or verify that traffic is being routed correctly.

## Inputs
- Test user agent, IP, country, or other visitor characteristics
- Expected routing result (should be white or black)
- Access to admin panel statistics

## Steps

### 1. Enable Debug Logging
Add temporary logging to `core.php` in the `Cloaker` class `check()` method:
```php
error_log("TDS Check: UA=" . $_SERVER['HTTP_USER_AGENT'] . ", IP=" . $_SERVER['REMOTE_ADDR']);
```

### 2. Identify the Visitor
Determine what characteristics the test visitor has:
- User agent (bot, browser, mobile, etc.)
- IP address and geolocation
- Country and language
- Referrer
- ISP/VPN status

### 3. Check TDS Mode
Verify the current TDS mode in admin panel:
- `tds_mode == 'full'`: all traffic goes to white (full cloak)
- `tds_mode == 'on'`: filters are active
- `tds_mode == 'off'`: all traffic goes to black

If mode is wrong, change it and test again.

### 4. Test Individual Filters
In `core.php`, temporarily disable filters one by one to isolate which one is blocking:
```php
// Comment out individual filter checks
// $this->check_bot_ip();
// $this->check_user_agent();
// $this->check_country();
```

### 5. Check Filter Configuration
Review `settings.json` for each filter:
- `bot_ips_enabled` - Is bot IP checking enabled?
- `bot_ua_enabled` - Is user agent checking enabled?
- `country_filter_enabled` - Is country filtering enabled?
- `country_whitelist` / `country_blacklist` - Which countries are blocked?
- `vpn_check_enabled` - Is VPN detection enabled?

### 6. Verify GeoIP Database
Test GeoIP lookup for the IP:
```bash
php -r "require 'bases/geoip.php'; var_dump(get_country_by_ip('1.2.3.4'));"
```

### 7. Check Admin Statistics
Go to admin panel → Statistics:
- Verify clicks are being recorded
- Check if traffic appears as white or black
- Look for patterns (all traffic white = full cloak mode, mixed = filters working)

## Tools
- Manual: Edit `core.php` for debug logging
- Manual: Review `settings.json` filter configuration
- Manual: Test GeoIP lookup via PHP CLI

## Expected Output
- Identified which filter is blocking the traffic
- Confirmed filter configuration is correct
- Traffic routing matches expected behavior

## Edge Cases

### All Traffic Going to White
- **Issue**: Even legitimate traffic is blocked
- **Fix**: Check if `tds_mode == 'full'`. If so, change to `'on'`. Also verify bot IP list isn't too aggressive.

### All Traffic Going to Black
- **Issue**: Even bot traffic is passing through
- **Fix**: Check if `tds_mode == 'off'`. If so, change to `'on'`. Verify filter settings are enabled.

### GeoIP Lookup Failing
- **Issue**: `get_country_by_ip()` returns null
- **Fix**: Verify GeoLite2 `.mmdb` files exist in `bases/`. Download fresh databases from MaxMind if corrupted.

### VPN Check Timing Out
- **Issue**: Page loads slowly, VPN check seems to hang
- **Fix**: The VPN check calls `blackbox.ipinfo.app` API. If it times out, disable `vpn_check_enabled` or increase timeout in `core.php`.

## Verification
1. Identified the specific filter causing the block
2. Confirmed filter configuration matches intent
3. Traffic routing now matches expected behavior
4. Admin statistics show correct white/black split
