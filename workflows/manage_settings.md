# Manage Settings

Add, modify, or remove configuration settings in YellowCloaker.

## Objective
Update `settings.json` and corresponding admin UI controls to add new configuration options or modify existing ones.

## Inputs
- Setting name and description
- Default value and data type
- Whether it needs an admin UI control
- Which section it belongs to (filters, pixels, white actions, etc.)

## Steps

### 1. Add to settings.json
Edit `settings.json` and add your new setting with a sensible default:
```json
{
  "new_setting_name": "default_value",
  "nested_settings": {
    "sub_setting": "value"
  }
}
```

### 2. Load in settings.php
Edit `settings.php` and add a line to load the setting into a global variable:
```php
$new_setting_name = $config->get('new_setting_name', 'default_value');
```

### 3. Add Admin UI Control (if needed)
Edit `admin/editsettings.php` and add an HTML form control:
```html
<label>New Setting Name:</label>
<input type="text" name="new_setting_name" value="<?php echo htmlspecialchars($new_setting_name); ?>">
```

### 4. Handle Form Submission
In `admin/editsettings.php`, add handling for the POST data:
```php
if ($_POST) {
    $settings['new_setting_name'] = $_POST['new_setting_name'] ?? '';
    file_put_contents('settings.json', json_encode($settings, JSON_PRETTY_PRINT));
}
```

### 5. Use in Code
Reference the global variable in any PHP file:
```php
global $new_setting_name;
if ($new_setting_name) {
    // do something
}
```

## Tools
- Manual: Edit `settings.json`, `settings.php`, `admin/editsettings.php`

## Expected Output
- New setting appears in `settings.json` with default value
- Setting is loaded as global variable in `settings.php`
- Admin UI shows control for editing the setting
- Setting can be modified and persists after page reload

## Edge Cases

### Setting Not Persisting
- **Issue**: Value changes in admin but reverts on reload
- **Fix**: Ensure `admin/editsettings.php` is writing to `settings.json` correctly. Check file permissions on `settings.json`.

### Global Variable Not Available
- **Issue**: `$new_setting_name` is undefined in a PHP file
- **Fix**: Add `global $new_setting_name;` at the top of the function/file where you're using it.

### Admin UI Not Showing
- **Issue**: New form control doesn't appear in admin panel
- **Fix**: Verify the HTML is added to `admin/editsettings.php` and the page is reloaded (not cached).

## Verification
1. New setting appears in `settings.json`
2. Admin panel shows the control
3. Changing the value in admin saves it
4. Value persists after page reload
5. Code can access the setting via global variable
