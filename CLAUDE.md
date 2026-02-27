<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# YellowCloaker

## Purpose
Main application directory containing the complete traffic cloaking system. Entry point is `index.php`, which loads settings, initializes the `Cloaker` class, runs traffic checks, and routes visitors to either "white" (decoy) or "black" (target) content paths.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `index.php` | Entry point; loads core, settings, db, main; instantiates `Cloaker` and routes traffic |
| `core.php` | `Cloaker` class; detects visitor OS/country/lang/IP/UA/ISP/referer, runs all filter checks |
| `main.php` | `white()` and `black()` functions; renders decoy or target content based on check result |
| `settings.php` | Loads `settings.json` via Noodlehaus Config into ~60 global variables |
| `settings.json` | Master configuration file (white/black actions, pixel IDs, TDS filters, scripts) |
| `db.php` | Database operations: `add_white_click()`, `add_black_click()`, `add_lead()`, `update_lead()`, `lead_is_duplicate()`, `add_email()`, `email_exists_for_subid()`, `add_lpctr()` |
| `htmlprocessing.php` | HTML loading and transformation pipeline: `load_prelanding()`, `load_landing()`, `load_white_content()`, URL rewriting, phone/name fix, city macros |
| `htmlinject.php` | Low-level HTML injection helpers: `insert_before_tag()`, `insert_after_tag()`, `insert_file_content()` |
| `pixels.php` | Facebook, TikTok, GTM, Yandex pixel injection functions |
| `cookies.php` | Cookie management: `ywbsetcookie()`, `get_cookie()`, `get_subid()`, `set_subid()`, `set_facebook_cookies()`, `has_conversion_cookies()` |
| `send.php` | Lead form submission handler; extracts name (from `name`/`fio`/`first_name`+`last_name`) and phone (from `phone`/`tel`), checks duplicates via `has_conversion_cookies()`, POSTs form data to the original conversion script (default: `order.php` in landing folder), handles 302/200 responses, then redirects to thankyou page |
| `postback.php` | S2S postback endpoint; receives status updates (lead/purchase/reject/trash) from affiliate networks via URL params `subid` and `status` |
| `abtest.php` | A/B test selection logic; picks landing/prelanding variants |
| `redirect.php` | HTTP redirect helper with configurable status codes (301/302/303/307) |
| `requestfunc.php` | HTTP request utilities: cURL wrapper, domain/port detection, query string helpers |
| `url.php` | URL manipulation: macro replacement (`{subid}`, `{country}`, etc.), sub-ID link injection |
| `landing.php` | Landing page loader endpoint (called from prelanding via link rewrite) |
| `worder.php` | White page form redirect; sends decoy form submissions to the shared `thankyou/thankyou.php` page |
| `buttonlog.php` | Logs button click events for conversion tracking |
| `.htaccess` | Apache config: custom ErrorDocument 404 pointing to `/404/index.php`, blocks direct access to `settings.json`, enables error display |
| `README.md` | Detailed setup and usage documentation (in Russian) |

## Subdirectories
| Directory | Purpose |
|-----------|---------|
| `admin/` | Password-protected admin dashboard: settings editor, statistics viewer (see `admin/CLAUDE.md`) |
| `bases/` | Detection libraries: GeoIP databases, bot IP list, browser/OS/language detection (see `bases/CLAUDE.md`) |
| `config/` | Noodlehaus Config library for JSON/Properties file parsing (see `config/CLAUDE.md`) |
| `db/` | SleekDB embedded JSON database engine (see `db/CLAUDE.md`) |
| `js/` | Client-side JavaScript bot detection system with obfuscation (see `js/CLAUDE.md`) |
| `scripts/` | Injected scripts: pixel tracking code, UI widgets, input masks (see `scripts/CLAUDE.md`) |
| `abtests/` | A/B testing engine with multi-armed bandit strategies (see `abtests/CLAUDE.md`) |
| `404/` | Custom 404 error page template with styling (see `404/CLAUDE.md`) |
| `thankyou/` | Post-conversion thank-you page templates and upsell system (see `thankyou/CLAUDE.md`) |
| `tos/` | Terms of service page templates |
| `logs/` | Runtime data storage directory for SleekDB (whiteclicks, blackclicks, leads, lpctr) |

## Claude-specific Guidance

### Deployment Requirements
- HTTPS certificate is mandatory; cloaker will not work properly over HTTP
- PHP 7.2+ with `file_get_contents` wrappers enabled (for GeoIP and VPN checks)
- Apache with `.htaccess` support (mod_rewrite not required; only ErrorDocument and Files directives used)
- No build process, no Composer; deploy by uploading files via FTP/SCP

### TDS Modes
- `tds_mode == 'full'`: all traffic goes to white (full cloak mode, used during ad moderation)
- `tds_mode == 'on'`: filters are active; traffic is classified white/black based on checks
- `tds_mode == 'off'`: filters disabled; all traffic goes to black (used for testing)

### Request Lifecycle
1. `index.php` boots: loads `core.php`, `settings.php`, `db.php`, `main.php`
2. `Cloaker` instantiated with all filter parameters from settings
3. If `tds_mode == 'full'`: all traffic goes to white (full cloak)
4. If `use_js_checks == true`: white page served first with embedded JS detection; JS calls back to `js/jsprocessing.php` which runs server-side checks
5. Otherwise: `$cloaker->check()` runs all filters; returns 0 (pass) or 1 (blocked)
6. Pass -> `black()`: serves prelanding/landing with pixel injection
7. Blocked -> `white()`: serves decoy content (folder/redirect/curl/error)

### Black Page Traffic Flow (detail)
1. `black()` sets sub-ID cookie, Facebook cookies, CORS headers
2. A/B test selects prelanding + landing combination; `save_user_flow` cookie ensures repeat visitors see the same pages
3. If prelandings exist: prelanding HTML loaded, all links rewritten to point to `landing.php`
4. When visitor clicks a prelanding link -> `landing.php` loads the landing HTML, rewrites all form `action` attributes to `send.php`, injects sub-ID hidden inputs, adds pixel/script injections
5. Visitor fills form -> `send.php` receives POST data, checks for duplicates, then forwards form data to the original conversion script (default: `order.php` in the landing folder)
6. `send.php` handles the conversion script's response (302 redirect or 200 HTML), records the lead, then redirects to `thankyou/thankyou.php`

### White Page Actions
- **folder**: loads local HTML from a named subfolder (e.g., `white/`)
- **redirect**: HTTP redirect (301/302/303/307) to an external URL
- **curl**: proxies external site content without redirect (visitor stays on your domain)
- **error**: returns an HTTP error code (e.g., 404)
- **Domain-specific**: when `white_use_domain_specific` is enabled, different domains/subdomains can use different white actions via the `white_domain_specific` array

### JS Integration (External Website Builders)
The cloaker can be embedded on external sites (Wix, Shopify, GitHub Pages, etc.) via script tags:
- **Content replacing**: `<script src="https://your.domain/js"></script>` -- replaces the builder's page content with the black page (requires prelandings)
- The `js/index.php` file serves as the entry point for this mode

### When Editing Files Here
- The `Cloaker` class in `core.php` is the single most critical file; changes affect all traffic filtering
- `htmlprocessing.php` is the most complex file; it builds the final HTML output via a pipeline of regex replacements and string injections
- Settings are loaded ONCE at startup via `settings.php`; adding a new setting requires changes in both `settings.json` and `settings.php`
- The admin UI in `admin/editsettings.php` must also be updated when adding new settings
- All database writes go through `db.php` functions; data is stored as JSON files in `logs/`

### Testing
- No automated tests exist; test by deploying and checking traffic routing manually
- Use `admin/statistics.php` to verify clicks and leads are being recorded
- The `js/testpage.html` can be used to test JavaScript detection in isolation

### Common Patterns & Conventions
- Traffic terminology: "white" = safe/decoy content for bots, "black" = real content for target users
- Facebook and TikTok pixel functions follow the pattern: `get_{platform}pixel()` -> `insert_{platform}pixel_*()` -> `full_{platform}pixel_processing()`. GTM and Yandex are simpler, with only `insert_gtm_script()` and `insert_yandex_script()` respectively.
- HTML is manipulated as strings, never via DOM parsing
- Sub-IDs are passed via query strings and persisted in cookies; the `$sub_ids` array maps internal names (e.g., `subid`) to affiliate network param names (e.g., `sub1`); `send.php` injects these as hidden form fields and `url.php` appends them to redirect links
- Macros like `{subid}`, `{country}`, `{CITY,default}` are replaced at render time
- Postback URL format: `https://your.domain/postback.php?subid={sub1}&status={status}` -- affiliate networks call this to update lead status
- Conversion script: configurable via `$black_land_conversion_script` (default: `order.php`); `send.php` calls it via HTTP POST and processes the response

### Dependencies -- Internal
- `bases/` provides all detection capabilities (GeoIP, browser, bot IPs)
- `config/` provides settings file parsing
- `db/` provides data persistence
- `scripts/` provides injectable JS/CSS/HTML snippets
- `js/` provides client-side bot detection

### Dependencies -- External
- MaxMind GeoLite2 databases (bundled in `bases/`)
- blackbox.ipinfo.app API (for VPN/Tor detection, called at runtime)

### Gotchas
- `settings.json` is blocked by `.htaccess` -- safe from web access, but don't commit secrets carelessly
- `htmlprocessing.php` uses `file_get_contents()` / output buffering to load pages -- not cURL
- `logs/` directory must be writable by the web server; SleekDB creates subdirectories automatically
- `.htaccess` has `display_errors 1` -- disable for production deployments
- The `Cloaker` class in `core.php` is the single most critical file; changes affect all traffic routing

<!-- MANUAL SECTION -- preserve on regeneration -->
<!-- Add project-specific notes, warnings, future plans, etc. below -->
