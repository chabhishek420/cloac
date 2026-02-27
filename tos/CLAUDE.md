<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# tos

## Purpose
Terms of service page system with country-specific localization. When `add_tos` is enabled in settings, a TOS link is injected into landing pages via `scripts/tos.html`. The link points to `tos/index.php`, which detects the visitor's country via GeoIP and serves the matching localized HTML template.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `index.php` | Entry point; detects visitor country via `getcountry()`, loads `tos/{CC}.html`, falls back to `tos/EN.html` if country template is missing |

## Subdirectories
| Directory | Purpose |
|-----------|---------|
| `tos/` | 17 country-specific TOS HTML templates: BA, BG, CZ, EE, EN, GR, HR, HU, IT, LT, LV, MK, PL, RO, RS, SI, SK |

## Claude-specific Guidance

### When Editing Files Here
- `index.php` requires `ipcountry.php` from the parent directory (`require_once __DIR__.'/../ipcountry.php'`)
- To add a new country: create `tos/{CC}.html` using an existing template as reference; no other changes needed
- `EN.html` is the default fallback for any unrecognized country code
- The TOS link is injected by `scripts/tos.html`, which is loaded by `htmlprocessing.php` when `add_tos` is enabled
- Keep TOS content generic enough to match the offer being promoted

<!-- MANUAL SECTION -- preserve on regeneration -->
