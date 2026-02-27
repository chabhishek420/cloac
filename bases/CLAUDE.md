<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# bases

## Purpose
Core detection and lookup libraries. Contains MaxMind GeoIP databases for country/city/ASN resolution, a known-bot IP list, browser/OS/language detection classes, and IP utility functions. These are the foundational data sources the `Cloaker` class uses to classify traffic.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `bots.txt` | CIDR list of ~10K known bot/crawler IP ranges (Google, Bing, Facebook, etc.) |
| `GeoLite2-Country.mmdb` | MaxMind country-level GeoIP database (~6.5MB) |
| `GeoLite2-City.mmdb` | MaxMind city-level GeoIP database (~50MB) for `{CITY}` macro replacement |
| `GeoLite2-ASN.mmdb` | MaxMind ASN database (~8.5MB) for ISP detection and filtering |
| `geoip2.phar` | MaxMind GeoIP2 PHP library (bundled as PHAR archive) |
| `ipcountry.php` | Functions: `getcountry($ip)`, `getcity($ip, $default)`, `getisp($ip)` using GeoIP2 |
| `iputils.php` | `IpUtils` class with `checkIp()` for matching IPs against CIDR ranges |

## Subdirectories
| Directory | Purpose |
|-----------|---------|
| `browser/` | Sinergi BrowserDetector library: OS, language, and user-agent detection (see `browser/CLAUDE.md`) |

## Claude-specific Guidance

### When Editing Files Here
- The `.mmdb` files are binary databases; update them by downloading new versions from MaxMind
- `bots.txt` can be extended with new CIDR ranges; one range per line
- `ipcountry.php` wraps the GeoIP2 PHAR; errors are silently caught and return defaults
- `iputils.php` provides IPv4 and IPv6 CIDR matching; the `IpUtils::checkIp()` method is called in `core.php`
- Do NOT modify `geoip2.phar` directly -- it's a vendored library archive

### Dependencies
- `geoip2.phar` is loaded via `require` in `ipcountry.php`
- The `Cloaker` class in `core.php` requires both `iputils.php` and `ipcountry.php`

<!-- MANUAL SECTION -- preserve on regeneration -->
