<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# js

## Purpose
Client-side JavaScript bot detection system. When JS checks are enabled, visitors first receive a page with embedded detection scripts that analyze browser capabilities (AudioContext, timezone, WebGL, etc.) to distinguish real browsers from headless bots. Detection results are sent back to the server for verification before routing.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `detector.js` | Main bot detection logic: checks AudioContext, timezone offset, canvas fingerprint, WebGL, and other browser APIs |
| `detect.js` | Lightweight detection trigger; runs detector checks and reports results |
| `connect.js` | Client-to-server communication; sends detection results to `jsprocessing.php` via AJAX |
| `process.js` | Client-side result processing and page transition logic |
| `process.php` | Server-side endpoint receiving JS detection results |
| `jsprocessing.php` | Main server-side JS check handler; receives AJAX callback, runs `Cloaker->check()`, returns white/black decision |
| `detection.php` | Alternative detection endpoint |
| `logjsbot.php` | Logs visitors detected as bots by JavaScript checks |
| `obfuscator.php` | `HunterObfuscator` class; obfuscates JS code to evade anti-cloaking detection |
| `index.php` | Entry point for external JS integration; when accessed via `<script src="https://your.domain/js">`, serves the cloaker's content-replacing mode for external website builders (Wix, Shopify, etc.) |
| `testpage.html` | Standalone HTML page for testing JS detection in isolation |
| `loading.gif` | Loading animation shown while JS detection runs |
| `arrow-long-down.png` | Down-arrow image asset used in detection UI |

## Claude-specific Guidance

### When Editing Files Here
- The JS detection flow: `white(true)` -> serves page with `connect.js` -> client runs `detector.js` -> AJAX POST to `jsprocessing.php` -> server decides white/black -> client redirects or loads content
- `obfuscator.php` uses character encoding tricks to make the JS harder to reverse-engineer; it's called when `js_obfuscate` is enabled in settings
- The `{DOMAIN}` placeholder in `connect.js` is replaced server-side with the actual domain
- Timezone checks use `js_tzstart` and `js_tzend` settings to filter by UTC offset range
- Detection results are checked against configurable events in `settings.json` under `white.jschecks.events`

### Common Patterns
- All PHP endpoints in this directory are AJAX handlers, not full page renderers
- For internal use (cloaker's own pages): JS is injected into HTML via `htmlprocessing.php`
- For external use (website builders like Wix/Shopify): JS is loaded via `<script src="https://your.domain/js"></script>` for content-replacing mode; `index.php` serves as the entry point for this
- The obfuscator converts JS into encoded string representations that self-decode at runtime

<!-- MANUAL SECTION -- preserve on regeneration -->
