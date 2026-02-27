<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# admin

## Purpose
Password-protected web admin dashboard for managing cloaker configuration and viewing traffic statistics. Provides a Bootstrap-based UI for editing all `settings.json` parameters and viewing click/lead/conversion analytics.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `index.php` | Main admin dashboard page; renders navigation, stats summary, and settings UI |
| `editsettings.php` | Large (~100KB) settings editor form; renders all configuration fields grouped by category |
| `savesettings.php` | POST handler that writes updated settings back to `settings.json` |
| `statistics.php` | Analytics dashboard; queries SleekDB for white/black clicks, leads, conversions with date filtering |
| `password.php` | Simple password authentication check (default password: `12345`) |
| `db.php` | Admin-specific database queries for statistics aggregation |
| `version.php` | Version info display |

## Subdirectories
| Directory | Purpose |
|-----------|---------|
| `css/` | Bootstrap, Font Awesome, custom stylesheets, MetisMenu sidebar CSS |
| `js/` | jQuery plugins (meanmenu, sticky), MetisMenu, clone data utility, custom `main.js` |
| `fonts/` | Custom Nalika icon font (SVG, TTF, WOFF) |
| `img/` | Dashboard images: favicon, logo, notification assets |

## Claude-specific Guidance

### When Editing Files Here
- `editsettings.php` is the largest file in the project; it renders a massive HTML form for all settings
- When adding a new setting: add the form field in `editsettings.php`, handle it in `savesettings.php`, and add the default in `settings.json`
- Authentication is basic: password is stored in `settings.json` under `statistics.password` (default: `12345`)
- There is no front-controller or URL rewriting; admin pages are accessed directly via their file paths (e.g., `/admin/index.php`)
- Legacy statistics URL: `/logs?password=yourpassword` also works as an access path
- Creative tracking: the `$creative_sub_name` setting lets you track clicks per ad creative name passed from the traffic source

### Common Patterns
- Settings form fields use `name` attributes matching the dot-notation keys in `settings.json`
- Statistics queries use SleekDB's `findBy()` with timestamp-based date filtering
- The dashboard uses Bootstrap 3.x grid layout with MetisMenu for sidebar navigation

<!-- MANUAL SECTION -- preserve on regeneration -->
