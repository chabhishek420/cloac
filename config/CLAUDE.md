<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# config

## Purpose
Vendored Noodlehaus Config library for loading and accessing configuration from JSON files. Provides dot-notation access to nested settings (e.g., `$conf->get('white.action')`). Used exclusively by `settings.php` to load `settings.json`.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `Config.php` | Main `Config` class; `Config::load()` factory, array-access interface, dot-notation `get()` |
| `AbstractConfig.php` | Base class with merge logic, `get()`/`set()`/`has()`, `ArrayAccess` implementation |
| `ConfigInterface.php` | Interface defining the Config contract |
| `ErrorException.php` | Base error exception |
| `Exception.php` | Base exception class |

## Subdirectories
| Directory | Purpose |
|-----------|---------|
| `Parser/` | File format parsers: `Json.php`, `Properties.php`, `Serialize.php` with abstract base and interface |
| `Writer/` | File format writers: `Json.php`, `Properties.php`, `Serialize.php` for saving config back to disk |
| `Exception/` | Specific exceptions: `ParseException`, `FileNotFoundException`, `UnsupportedFormatException`, `EmptyDirectoryException`, `WriteException` |

## Claude-specific Guidance

### When Editing Files Here
- This is a vendored library (Noodlehaus namespace); avoid modifications
- The project only uses JSON parsing; Properties and Serialize parsers are unused
- `Config::load()` accepts a file path and auto-detects format by extension
- Dot-notation access: `$conf['white.action']` or `$conf->get('white.action', 'default')`
- The Writer is used by `admin/savesettings.php` to persist settings changes

<!-- MANUAL SECTION -- preserve on regeneration -->
