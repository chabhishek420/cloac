# Setup Environment

Initialize YellowCloaker for local development or production deployment.

## Objective
Prepare a fresh YellowCloaker installation with all dependencies, configuration, and HTTPS ready.

## Inputs
- Server/local machine with PHP 7.2+
- Apache with `.htaccess` support
- HTTPS certificate (required for production)
- `settings.json` template or existing configuration

## Steps

### 1. Verify PHP Version
```bash
php -v
```
Ensure PHP 7.2 or higher is installed.

### 2. Check Apache Modules
```bash
apache2ctl -M | grep rewrite
```
Note: `.htaccess` support requires `mod_rewrite` (though cloaker only uses ErrorDocument, not URL rewriting).

### 3. Create Logs Directory
```bash
mkdir -p logs
chmod 755 logs
```
SleekDB will create subdirectories (`whiteclicks`, `blackclicks`, `leads`, `lpctr`) automatically.

### 4. Configure HTTPS Certificate
For production:
- Obtain SSL certificate (Let's Encrypt recommended)
- Configure Apache VirtualHost with `SSLEngine on`
- Update `.htaccess` to force HTTPS:
  ```apache
  RewriteEngine On
  RewriteCond %{HTTPS} off
  RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
  ```

For local development:
- Generate self-signed certificate:
  ```bash
  openssl req -x509 -newkey rsa:4096 -keyout key.pem -out cert.pem -days 365 -nodes
  ```

### 5. Load Initial Settings
- Copy `settings.json` to project root (or use existing)
- Verify all required keys are present (see `manage_settings.md`)
- Test by accessing admin panel: `https://your.domain/admin/`

### 6. Verify File Permissions
```bash
chmod 644 *.php
chmod 644 settings.json
chmod 755 logs
chmod 755 admin
```

### 7. Test Traffic Routing
- Access `https://your.domain/` with different user agents
- Check admin panel statistics to verify clicks are recorded
- See `manual_traffic_test.md` for detailed testing

## Tools
- Manual: Apache/PHP configuration
- Manual: SSL certificate generation
- Manual: File permission setup

## Expected Output
- PHP 7.2+ confirmed
- HTTPS working (no browser warnings)
- `logs/` directory writable
- Admin panel accessible at `/admin/`
- First test traffic recorded in statistics

## Edge Cases

### HTTPS Certificate Errors
- **Issue**: Browser shows "untrusted certificate"
- **Fix**: For production, use Let's Encrypt. For dev, add self-signed cert to trusted store.

### Permission Denied on logs/
- **Issue**: SleekDB can't write to `logs/`
- **Fix**: Ensure web server user (www-data, _www, etc.) owns the directory:
  ```bash
  chown -R www-data:www-data logs/
  ```

### PHP Extensions Missing
- **Issue**: `file_get_contents()` fails for GeoIP or VPN checks
- **Fix**: Enable `allow_url_fopen` in `php.ini`:
  ```ini
  allow_url_fopen = On
  ```

## Verification
1. Admin panel loads without errors
2. Settings are readable (no PHP warnings)
3. First test click appears in statistics within 5 seconds
4. HTTPS certificate is valid (no browser warnings)
