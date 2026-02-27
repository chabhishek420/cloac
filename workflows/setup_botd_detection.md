# Setup BotD (Bot Detection)

Advanced client-side bot detection using FingerprintJS BotD library to identify automated traffic, headless browsers, and sophisticated bots.

## Objective
Enable BotD (Bot Detection) to identify and block advanced bots that bypass traditional server-side filters using browser fingerprinting and behavioral analysis.

## Why BotD?

**Traditional Filters Miss:**
- Headless browsers (Puppeteer, Playwright, Selenium)
- Browser automation tools with stealth plugins
- Sophisticated bots that mimic real user behavior
- AI-powered scraping tools

**BotD Detects:**
- Headless Chrome/Firefox
- Automation frameworks (Puppeteer, Playwright, Selenium, PhantomJS)
- Browser inconsistencies (missing APIs, spoofed properties)
- Automation indicators (webdriver flags, CDP connections)
- Virtual machines and emulators

## How It Works

### 1. Client-Side Detection
When a visitor lands on a black page (prelanding or landing):
- BotD JavaScript library loads from CDN (no build process required)
- Runs 40+ detection signals in the browser
- Analyzes browser APIs, properties, and behaviors
- Generates bot detection result with confidence score

### 2. Result Submission
Detection result is sent to `botd_result.php`:
- Stores result in PHP session
- Includes bot status, bot kind, and detection components
- Timestamped for freshness validation

### 3. Server-Side Filtering
On subsequent requests or page navigation:
- `core.php` checks session for BotD result
- If bot detected and result is fresh (within timeout) → block traffic
- Result expires after configured timeout (default: 300 seconds)

## Setup Steps

### Step 1: Enable BotD in settings.json

Edit `settings.json` and enable BotD detection:

```json
{
  "tds": {
    "filters": {
      "blocked": {
        "botd": {
          "enabled": true,
          "timeout": 300
        }
      }
    }
  }
}
```

**Configuration Options:**
- `enabled`: Set to `true` to enable BotD detection
- `timeout`: How long (in seconds) to trust a BotD result (default: 300 = 5 minutes)

### Step 2: Verify Integration

BotD is automatically integrated into all black pages (prelandings and landings). No additional configuration needed.

**Test it:**
1. Enable BotD in `settings.json`
2. Visit your landing page in a normal browser → should work normally
3. Visit with a headless browser (Puppeteer/Selenium) → should be blocked
4. Check admin panel → Statistics → verify bot traffic is being filtered

### Step 3: Test with Headless Browser

Create a test script to verify BotD is working:

```javascript
// test_botd.js (Node.js with Puppeteer)
const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch({ headless: true });
  const page = await browser.newPage();

  await page.goto('https://your.domain/');

  // Wait for BotD detection
  await page.waitForTimeout(3000);

  // Check if blocked
  const content = await page.content();
  console.log('Page loaded:', content.includes('white') ? 'BLOCKED' : 'ALLOWED');

  await browser.close();
})();
```

Expected result: Headless browser should be blocked and see white page.

## Detection Flow

### Normal Browser (Allowed)
1. Visitor lands on black page
2. BotD script loads and runs detection
3. Result: `bot: 0` (not a bot)
4. Result stored in session
5. Visitor continues normally

### Headless Browser (Blocked)
1. Bot lands on black page
2. BotD script loads and runs detection
3. Result: `bot: 1`, `botKind: "headlessChrome"` (detected as bot)
4. Result stored in session
5. On next request → `core.php` checks session → blocks traffic
6. Bot sees white page

## Bot Detection Categories

BotD identifies these bot types:

| Bot Kind | Description |
|----------|-------------|
| `headlessChrome` | Headless Chrome/Chromium |
| `headlessFirefox` | Headless Firefox |
| `phantomJS` | PhantomJS browser |
| `selenium` | Selenium WebDriver |
| `puppeteer` | Puppeteer automation |
| `playwright` | Playwright automation |
| `automation` | Generic automation detection |
| `unknown` | Bot detected but type unknown |

## Files Modified

| File | Changes |
|------|---------|
| `settings.json` | Added `tds.filters.blocked.botd` configuration |
| `settings.php` | Load BotD settings into `$botd_enabled` and `$botd_timeout` globals |
| `core.php` | Added BotD properties to `Cloaker` class, updated constructor, added BotD check in `check()` method |
| `index.php` | Pass BotD parameters to `Cloaker` constructor |
| `htmlprocessing.php` | Added `insert_botd_script()` function, inject BotD script into prelandings and landings |
| `js/botd_detection.js` | Client-side BotD detection script (NEW) |
| `botd_result.php` | Server-side endpoint to receive BotD results (NEW) |

## Troubleshooting

### BotD Not Blocking Bots
**Issue:** Headless browsers are not being blocked

**Fixes:**
1. Verify `botd.enabled` is `true` in `settings.json`
2. Check that `js/botd_detection.js` is accessible (visit `https://your.domain/js/botd_detection.js`)
3. Verify `botd_result.php` is receiving results (check PHP session data)
4. Ensure session is started (check `session_status()` in `core.php`)
5. Test with a known headless browser (Puppeteer, Selenium)

### False Positives
**Issue:** Real users are being blocked

**Fixes:**
1. Increase `timeout` value in `settings.json` (e.g., 600 seconds)
2. Check admin panel statistics for `botd:*` entries
3. Verify detection is accurate (check `botKind` in session data)
4. Consider disabling BotD temporarily to verify it's the cause

### BotD Script Not Loading
**Issue:** BotD script fails to load from CDN

**Fixes:**
1. Check browser console for errors
2. Verify CDN is accessible: `https://openfpcdn.io/botd/v2`
3. Check firewall/network restrictions
4. Ensure HTTPS is enabled (BotD requires secure context)

### Session Not Persisting
**Issue:** BotD results not stored in session

**Fixes:**
1. Verify PHP sessions are enabled
2. Check `session_start()` is called before BotD check
3. Verify `botd_result.php` is writable and accessible
4. Check PHP session storage directory permissions

## Performance Impact

**Client-Side:**
- BotD library size: ~15KB (gzipped)
- Detection time: 50-200ms
- Runs asynchronously (non-blocking)

**Server-Side:**
- Session read: <1ms
- No external API calls
- Minimal CPU overhead

## CDN Dependency

BotD loads from FingerprintJS CDN:
```
https://openfpcdn.io/botd/v2
```

**Pros:**
- No build process required
- Always up-to-date detection logic
- Fast global CDN delivery
- No local hosting overhead

**Cons:**
- Requires external CDN access
- Slight dependency on third-party service

**Fallback:** If CDN is unavailable, detection simply doesn't run and traffic is not blocked (fail-open behavior).

## Advanced: Custom Detection Logic

To customize bot detection behavior, edit `botd_result.php`:

```php
// Example: Only block high-confidence detections
if ($bot === 1 && isset($components['automationTool']) && $components['automationTool']['probability'] > 0.8) {
    $_SESSION['botd_result'] = [
        'bot' => 1,
        'botKind' => $botKind,
        'components' => $components,
        'timestamp' => time()
    ];
}
```

## Comparison: BotD vs Traditional Filters

| Detection Method | Coverage | False Positives | Performance |
|------------------|----------|-----------------|-------------|
| IP Blacklist | Low | Low | Fast |
| User-Agent Check | Low | Medium | Fast |
| ISP/Datacenter | Medium | Medium | Medium |
| VPN/Tor Check | Medium | High | Slow (API call) |
| **BotD** | **High** | **Low** | **Fast** |

**Recommendation:** Use BotD in combination with traditional filters for maximum protection.

## Expected Results

After implementing BotD:
- ✓ Headless browsers blocked (Puppeteer, Playwright, Selenium)
- ✓ Automation frameworks detected and filtered
- ✓ Browser inconsistencies identified
- ✓ Real users unaffected (low false positive rate)
- ✓ No build process or Composer dependencies
- ✓ Simple deployment maintained

## Next Steps

1. Enable BotD in `settings.json`
2. Test with headless browser (Puppeteer/Selenium)
3. Monitor admin panel statistics for `botd:*` entries
4. Adjust `timeout` if needed based on traffic patterns
5. Combine with other filters for comprehensive protection

## Future Enhancements

Consider upgrading to **FingerprintJS Pro** for:
- 99.5% accuracy (vs 85% for open-source BotD)
- 1,600+ fingerprint signals
- Machine learning-based scoring
- Visitor identification across sessions
- Advanced bot detection (AI scrapers, residential proxies)

See `workflows/setup_fingerprintjs_pro.md` for upgrade guide (future documentation).
