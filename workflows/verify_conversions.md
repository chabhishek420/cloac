# Verify Conversions

Check if leads, clicks, and LPCTR events are being recorded correctly in YellowCloaker's SleekDB logs.

## Objective
Verify that user actions (clicks, lead form submissions, LPCTR) are being captured and stored in the database correctly.

## Inputs
- Access to admin panel statistics
- Test visitor characteristics (IP, country, user agent)
- Access to `logs/` directory

## Steps

### 1. Test Click Tracking
Access `https://your.domain/` with a test visitor:
- For white traffic: access from a bot IP or suspicious user agent
- For black traffic: access from a legitimate browser

### 2. Check Admin Statistics
Go to admin panel → Statistics:
- Verify a new click appears in the list
- Check if it's classified as white or black
- Verify details: IP, country, user agent, referral, sub-ID

### 3. Test Lead Submission
Fill out a form on a landing page:
- `https://your.domain/landing/my_page/`
- Submit form with test name and phone

### 4. Check Lead Statistics
Go to admin panel → Leads:
- Verify a new lead appears in the list
- Check if details match: name, phone, sub-ID, country
- Verify status: `lead` (initial status)

### 5. Check LPCTR Tracking
If using prelanding pages, click a link to a landing page:
- `https://your.domain/prelanding/my_page/` → click link to landing
- Verify LPCTR event is recorded in admin panel → Statistics

### 6. Inspect SleekDB Logs
Check JSON files in `logs/` directory:
- White clicks: `logs/whiteclicks/data.json`
- Black clicks: `logs/blackclicks/data.json`
- Leads: `logs/leads/data.json`
- LPCTR: `logs/lpctr/data.json`

Verify new entries match the test visitor's characteristics.

### 7. Test Duplicate Lead Detection
Submit the same form again with the same name/phone:
- Verify `send.php` detects the duplicate (via `has_conversion_cookies()`)
- Check that no new lead is recorded in `logs/leads/data.json`

## Tools
- Manual: Access `https://your.domain/` for click tracking
- Manual: Submit lead form on landing page
- Manual: Check admin panel statistics and leads
- Manual: Inspect JSON files in `logs/`

## Expected Output
- Clicks appear in admin statistics within 5 seconds
- Leads appear in admin leads list after form submission
- LPCTR events are recorded when clicking from prelanding
- JSON files in `logs/` match the test visitor's data
- Duplicate leads are correctly blocked

## Edge Cases

### Clicks Not Appearing in Statistics
- **Issue**: No new clicks appear in admin panel
- **Fix**: Verify `logs/` directory is writable by web server. Check `db.php` for `add_white_click()` or `add_black_click()` calls.

### Leads Not Recording
- **Issue**: Lead form submitted but no lead appears in admin panel
- **Fix**: Check `send.php` for `add_lead()` call. Verify that `send.php` can reach the conversion script. Check file permissions on `logs/leads/`.

### LPCTR Events Not Tracking
- **Issue**: Clicking prelanding link doesn't record LPCTR event
- **Fix**: Verify `buttonlog.php` is called when link is clicked. Check `htmlprocessing.php` for link rewriting logic.

### Duplicate Lead Detection Failing
- **Issue**: Same visitor can submit multiple leads
- **Fix**: Verify `ywbsetcookie()` is working correctly in `cookies.php`. Check that `has_conversion_cookies()` is called in `send.php`.

## Verification
1. Clicks appear in admin statistics
2. Leads appear in admin leads list
3. LPCTR events are recorded correctly
4. JSON files in `logs/` match test data
5. Duplicate leads are blocked
6. Admin panel reports match actual user actions
