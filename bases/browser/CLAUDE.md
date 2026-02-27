<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# browser

## Purpose
Vendored Sinergi BrowserDetector library for detecting visitor operating system, browser language, and user-agent details. Used by the `Cloaker` class to populate the `detect` array with OS and language information for traffic filtering.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `Os.php` | `Os` value object with OS name/version constants and getters |
| `OsDetector.php` | Main detection logic: parses user-agent string to identify OS (Windows, macOS, Linux, iOS, Android, etc.) |
| `Language.php` | `Language` value object wrapping detected browser language |
| `LanguageDetector.php` | Parses `Accept-Language` header to extract primary language |
| `AcceptLanguage.php` | Helper for parsing the Accept-Language header format |
| `Browser.php` | `Browser` value object (browser name/version) |
| `BrowserDetector.php` | Full browser detection from user-agent (Chrome, Firefox, Safari, etc.) |
| `UserAgent.php` | User-agent string wrapper |
| `Device.php` | Device type detection (mobile/tablet/desktop) |
| `DetectorInterface.php` | Interface contract for detector classes |
| `InvalidArgumentException.php` | Custom exception class |

## Claude-specific Guidance

### When Editing Files Here
- This is a vendored third-party library (Sinergi\BrowserDetector namespace)
- Prefer NOT modifying these files; if detection is wrong, override in `core.php` instead
- The `Cloaker` class only uses `Os` and `Language` from this library
- `BrowserDetector.php` is the most complex file (~32KB) with extensive UA parsing regex

<!-- MANUAL SECTION -- preserve on regeneration -->
