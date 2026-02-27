<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# thankyou

## Purpose
Post-conversion thank-you page system. After a lead submits a form, they are redirected here (from both `send.php` for black traffic and `worder.php` for white traffic). Supports multiple language templates, email confirmation flows, and upsell product carousels.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `thankyou.php` | Main thank-you page renderer; selects template by language, injects `{NAME}` and `{PHONE}` macros from cookies, fires conversion pixels (FB Lead, TT conversion), handles POST for email collection, inserts upsell widget |

## Subdirectories
| Directory | Purpose |
|-----------|---------|
| `templates/` | Language-specific thank-you page HTML: `EN.html`, `PT.html`, `RU.html`, `SI.html`, `SK.html` |
| `templates/email/` | Email confirmation form templates per language: `{LANG}fill.html` (form), `{LANG}save.html` (confirmation) |
| `upsell/` | Product upsell widget: `upsell.template.html`, `upsell.css`, `upsell.js`, and `carousel/` subdirectory for slider |

## Claude-specific Guidance

### When Editing Files Here
- Template language is selected via `$black_land_thankyou_page_language` setting (2-letter code, e.g., `EN`, `RU`, `SK`)
- Templates contain `{NAME}` and `{PHONE}` macros -- these are replaced with values from cookies set by `send.php`; do NOT rename these macros (Google Translate may accidentally translate them)
- Conversion pixels (Facebook Lead event, TikTok conversion) fire on this page to report successful leads; skipped when `?nopixel=1` is present (duplicate leads)
- The upsell system is optional; controlled by `thankyou_upsell` setting
- Email collection: `thankyou.php` handles POST from the email form; email templates use `{LANG}fill.html` for the form and `{LANG}save.html` for confirmation
- To add a new language: create `templates/{LANG}.html` using an existing template, optionally create `templates/email/{LANG}fill.html` and `{LANG}save.html`

<!-- MANUAL SECTION -- preserve on regeneration -->
