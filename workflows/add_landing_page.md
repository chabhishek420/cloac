# Add Landing Page

Add new landing or prelanding pages with proper URL rewriting and form handling.

## Objective
Create a new landing or prelanding page that integrates with YellowCloaker's traffic routing, URL rewriting, and conversion tracking.

## Inputs
- HTML file for the landing/prelanding page
- Page type: prelanding or landing
- Whether it needs A/B testing variants
- Conversion script endpoint (default: `order.php` in landing folder)

## Steps

### 1. Create Page Directory
```bash
mkdir -p landing/my_page
# or for prelanding
mkdir -p prelanding/my_page
```

### 2. Add HTML File
Place your HTML file at:
- `landing/my_page/index.html` (landing page)
- `prelanding/my_page/index.html` (prelanding page)

### 3. Update settings.json
Add the page to the appropriate section:
```json
{
  "black_land_pages": ["my_page"],
  "black_prelanding_pages": ["my_page"]
}
```

### 4. Configure Form Action
For landing pages, ensure form `action` points to a relative path:
```html
<form action="send.php" method="POST">
  <input type="text" name="name" placeholder="Your Name">
  <input type="tel" name="phone" placeholder="Your Phone">
  <button type="submit">Submit</button>
</form>
```

The `send.php` handler will:
- Extract name and phone
- Check for duplicates
- Forward to conversion script
- Redirect to thank you page

### 5. Add Macros (Optional)
Use macros in your HTML that will be replaced at render time:
```html
<p>Your country: {country}</p>
<p>Your city: {CITY,Unknown}</p>
<p>Tracking ID: {subid}</p>
```

Available macros:
- `{subid}` - Sub-ID from query string
- `{country}` - Visitor's country code
- `{CITY,default}` - Visitor's city (with fallback)
- `{lang}` - Visitor's language

### 6. Add Pixels (Optional)
For conversion tracking, add pixel placeholders that will be injected:
```html
<!-- Facebook pixel will be injected here -->
<!-- TikTok pixel will be injected here -->
```

See `inject_pixels.md` for detailed pixel setup.

### 7. Test URL Rewriting
If this is a prelanding page with links to landing pages:
```html
<a href="landing.php?page=my_landing">Click Here</a>
```

The `landing.php` handler will:
- Load the landing page HTML
- Rewrite form actions to `send.php`
- Inject sub-ID hidden inputs
- Inject pixels

### 8. Add to A/B Test (Optional)
Edit `abtests/config.json` to include the page in A/B tests:
```json
{
  "test_name": {
    "prelanding": ["my_page", "other_page"],
    "landing": ["my_landing", "other_landing"]
  }
}
```

## Tools
- Manual: Create page directories and HTML files
- Manual: Update `settings.json`
- Manual: Update `abtests/config.json` if using A/B tests

## Expected Output
- Page loads without errors at `/landing/my_page/` or `/prelanding/my_page/`
- Forms submit to `send.php` correctly
- Macros are replaced with actual values
- Pixels are injected (if configured)
- Conversions are tracked in admin statistics

## Edge Cases

### Form Not Submitting
- **Issue**: Form submission fails or redirects incorrectly
- **Fix**: Verify form `action="send.php"` is correct. Check that `send.php` can access the conversion script.

### Macros Not Replaced
- **Issue**: `{country}` appears as literal text in page
- **Fix**: Verify macros are in the HTML file before it's loaded. Check `htmlprocessing.php` for macro replacement logic.

### Pixels Not Injecting
- **Issue**: Pixel code doesn't appear in page source
- **Fix**: Verify pixel injection is enabled in `settings.json`. Check `pixels.php` for injection functions.

### Page Not Loading
- **Issue**: 404 error when accessing page
- **Fix**: Verify directory structure matches `settings.json` configuration. Check file permissions on HTML file.

## Verification
1. Page loads without errors
2. Forms submit and reach conversion script
3. Macros are replaced with actual values
4. Conversions appear in admin statistics
5. A/B test variants load correctly (if configured)
