# Test Filters

Verify individual filter logic in isolation to ensure traffic classification is working correctly.

## Objective
Test each filter (bot IP, user agent, country, VPN, etc.) independently to confirm they're detecting traffic correctly.

## Inputs
- Test cases with known characteristics (bot IPs, suspicious user agents, blocked countries, etc.)
- Access to `core.php` and filter functions
- PHP CLI for running tests

## Steps

### 1. Test Bot IP Detection
```bash
php -r "
require 'core.php';
\$cloaker = new Cloaker();
\$test_ips = ['1.2.3.4', '8.8.8.8', '66.249.64.0'];
foreach (\$test_ips as \$ip) {
    \$_SERVER['REMOTE_ADDR'] = \$ip;
    \$result = \$cloaker->check_bot_ip();
    echo \$ip . ': ' . (\$result ? 'BLOCKED' : 'PASS') . PHP_EOL;
}
"
```

### 2. Test User Agent Detection
```bash
php -r "
require 'core.php';
\$cloaker = new Cloaker();
\$test_uas = [
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    'Googlebot/2.1',
    'facebookexternalhit/1.1'
];
foreach (\$test_uas as \$ua) {
    \$_SERVER['HTTP_USER_AGENT'] = \$ua;
    \$result = \$cloaker->check_user_agent();
    echo \$ua . ': ' . (\$result ? 'BLOCKED' : 'PASS') . PHP_EOL;
}
"
```

### 3. Test Country Filtering
```bash
php -r "
require 'core.php';
require 'bases/geoip.php';
\$test_ips = ['1.1.1.1', '8.8.8.8'];
foreach (\$test_ips as \$ip) {
    \$country = get_country_by_ip(\$ip);
    echo \$ip . ' -> ' . \$country . PHP_EOL;
}
"
```

### 4. Test VPN Detection
```bash
php -r "
require 'core.php';
\$cloaker = new Cloaker();
\$_SERVER['REMOTE_ADDR'] = '1.2.3.4';
\$result = \$cloaker->check_vpn();
echo 'VPN Check: ' . (\$result ? 'BLOCKED' : 'PASS') . PHP_EOL;
"
```

### 5. Test Language Detection
```bash
php -r "
require 'core.php';
\$cloaker = new Cloaker();
\$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en-US,en;q=0.9';
\$lang = \$cloaker->get_language();
echo 'Language: ' . \$lang . PHP_EOL;
"
```

### 6. Test Referrer Filtering
```bash
php -r "
require 'core.php';
\$cloaker = new Cloaker();
\$_SERVER['HTTP_REFERER'] = 'https://facebook.com/page';
\$result = \$cloaker->check_referrer();
echo 'Referrer: ' . (\$result ? 'BLOCKED' : 'PASS') . PHP_EOL;
"
```

### 7. Create Test Suite
Create `test_filters.php` for repeatable testing:
```php
<?php
require 'core.php';
require 'bases/geoip.php';

$cloaker = new Cloaker();
$tests = [
    'bot_ip' => ['8.8.8.8', '66.249.64.0'],
    'user_agent' => ['Googlebot/2.1', 'facebookexternalhit/1.1'],
    'country' => ['US', 'RU', 'CN'],
];

foreach ($tests as $filter => $cases) {
    echo "Testing $filter:\n";
    foreach ($cases as $case) {
        // Run test
    }
}
?>
```

## Tools
- Manual: PHP CLI for running filter tests
- Manual: Create `test_filters.php` for repeatable testing

## Expected Output
- Each filter returns expected result (BLOCKED or PASS)
- Bot IPs are detected correctly
- Suspicious user agents are flagged
- Country filtering works as configured
- VPN detection responds (may timeout if API is slow)

## Edge Cases

### VPN Check Times Out
- **Issue**: VPN detection hangs or takes >5 seconds
- **Fix**: The check calls `blackbox.ipinfo.app`. If it's slow, disable `vpn_check_enabled` or increase timeout.

### GeoIP Returns Wrong Country
- **Issue**: IP is detected as wrong country
- **Fix**: GeoLite2 databases may be outdated. Download fresh `.mmdb` files from MaxMind.

### Filter Returns Unexpected Result
- **Issue**: A filter that should block is passing (or vice versa)
- **Fix**: Check `settings.json` to verify the filter is enabled and configured correctly.

## Verification
1. All filters return expected results
2. Bot IPs are consistently detected
3. Suspicious user agents are flagged
4. Country filtering matches configuration
5. Test suite can be run repeatedly with consistent results
