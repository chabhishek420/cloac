<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# 404

## Purpose
Custom 404 error page template. Displayed when white traffic is configured to return HTTP 404 errors or when a genuinely missing resource is requested. Includes a styled "page not found" layout with multiple image variants and a mail feedback form.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `index.php` | 404 page HTML template with responsive layout |
| `style.css` | Page styling |
| `scripts.js` | Minimal page interactions |
| `mail.php` | Form handler for the feedback/contact form on the 404 page |
| `image.png` through `image4.png` | Visual assets for the error page (multiple size variants) |

## Claude-specific Guidance

### When Editing Files Here
- This directory is referenced as a white page folder when `white_action` is `folder` and the folder name is `404`
- The page should look like a legitimate 404 error to be convincing as a decoy
- Keep styling generic and professional; avoid any branding that might expose the cloaker

<!-- MANUAL SECTION -- preserve on regeneration -->
