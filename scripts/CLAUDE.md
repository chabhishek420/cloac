<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# scripts

## Purpose
Collection of injectable JavaScript, CSS, and HTML snippets that are dynamically inserted into landing and pre-landing pages by `htmlprocessing.php`. Includes ad tracking pixels (Facebook, TikTok, Yandex, GTM), UI widgets (callbacker, comebacker, cart notification), input masking, and navigation control scripts.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `btnclicklog.js` | Logs form button clicks to `buttonlog.php` for conversion tracking |
| `disableback.js` | Disables browser back button via `history.pushState` loop |
| `disablecopy.js` | Prevents text selection and right-click on the page |
| `replaceback.js` | Replaces back button behavior to redirect to a specified URL |
| `replacelanding.js` | Replaces current page URL when navigating away from landing |
| `replaceprelanding.js` | Replaces current page URL when navigating away from prelanding |
| `replaceanchorswithsmoothscroll.js` | Converts anchor links to smooth-scroll behavior |
| `tos.html` | Terms of service footer snippet injected into pages |
| `removeland.html` | List of JS/CSS resources to strip from landing pages |
| `removepreland.html` | List of JS/CSS resources to strip from prelanding pages |

## Subdirectories
| Directory | Purpose |
|-----------|---------|
| `pixels/` | Ad platform tracking pixel code: Facebook, TikTok, Yandex Metrica, Google Tag Manager |
| `addedtocart/` | "Added to cart" notification widget (CSS, JS, HTML template, image) |
| `callbacker/` | Callback request popup widget (CSS, JS, HTML template, images) |
| `comebacker/` | Exit-intent popup widget shown when user tries to leave (CSS, JS, HTML template, images) |
| `inputmask/` | Vendored Inputmask library for phone number formatting |

## Claude-specific Guidance

### When Editing Files Here
- Scripts are injected into pages via `insert_file_content()` and `insert_file_content_with_replace()` from `htmlinject.php`
- Injection points are typically `</head>` or `</body>` tags
- `{PLACEHOLDER}` tokens in scripts are replaced server-side before injection (e.g., `{REDIRECT}`, `{MASK}`, `{RA}`)
- Widget directories (addedtocart, callbacker, comebacker) each follow the same structure: `head.html` (CSS/meta), `template.html` (markup), `script.js` (behavior), `css.css` (styles)
- The `remove*.html` files contain file paths (one per line) of resources to strip from scraped pages; line suffix determines type (.js, .css, or literal HTML)
- Do NOT use `disableback.js` and `replaceback.js` simultaneously -- they conflict with each other
- Each script is controlled by a corresponding boolean setting: `$disable_back_button`, `$replace_back_button`, `$disable_text_copy`, `$replace_prelanding`, `$black_land_use_phone_mask`, etc.

### Pixel Structure
- Each pixel platform has its own subdirectory under `pixels/`
- Facebook: `fbpxcode.js` (base pixel), `fbpxviewcontent*.js` (ViewContent events), `fbpxbuttonconversion.js` (button-triggered conversion)
- TikTok: same pattern as Facebook with `ttpx` prefix
- Google: `gtmcode.js` (GTM container snippet)
- Yandex: `yacode.js` (Metrica counter snippet)

<!-- MANUAL SECTION -- preserve on regeneration -->
