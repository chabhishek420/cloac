# Export Statistics

Extract click, lead, and LPCTR data from YellowCloaker's SleekDB logs for analysis or reporting.

## Objective
Pull raw data from the JSON logs in the `logs/` directory and format it for analysis or reporting.

## Inputs
- Access to the `logs/` directory
- Target date range or criteria (specific country, sub-ID, etc.)
- Desired output format (CSV, Excel, JSON)

## Steps

### 1. Identify Data Source
SleekDB stores data in JSON files in subdirectories of `logs/`:
- White clicks: `logs/whiteclicks/data.json`
- Black clicks: `logs/blackclicks/data.json`
- Leads: `logs/leads/data.json`
- LPCTR: `logs/lpctr/data.json`

Note: SleekDB might use multiple files or different structures depending on version.

### 2. Read JSON Data
Use PHP or Python to read the JSON files:
```php
<?php
$data = json_decode(file_get_contents('logs/blackclicks/data.json'), true);
// Process data
?>
```

### 3. Filter by Criteria
Filter the data based on your requirements:
- Date range: `createdAt` field
- Country: `country` field
- Sub-ID: `subid` field
- Visitor ID: `vid` field

### 4. Format for Export
Format the filtered data for your desired output:
- CSV: Use `fputcsv()` in PHP
- JSON: Use `json_encode()`
- Excel: Use a library like PhpSpreadsheet (not included, may need to use CSV)

### 5. Download Exported Data
Provide a download link or save the file to a temporary location:
```php
<?php
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="stats.csv"');
// Output CSV data
?>
```

### 6. Verify Exported Data
Check the exported file to ensure it matches the requested criteria and contains the correct data.

## Tools
- Manual: Read JSON files in `logs/`
- Manual: Filter and format data using PHP or Python
- Manual: Export to CSV or JSON

## Expected Output
- Exported file contains the requested data (clicks, leads, or LPCTR)
- Data matches the specified criteria (date range, country, sub-ID)
- Output format is correct (CSV, JSON, etc.)
- Exported file is accessible and readable

## Edge Cases

### JSON Data Too Large
- **Issue**: `file_get_contents()` fails for large JSON files
- **Fix**: Use a streaming JSON parser or read the files line by line if SleekDB stores one record per line.

### Data Corrupted or Missing
- **Issue**: JSON data is invalid or missing required fields
- **Fix**: Check `db.php` for `add_*_click()` and `add_lead()` calls. Verify that data is being recorded correctly.

### Export Format Not Supported
- **Issue**: Unable to export to Excel or other complex formats
- **Fix**: Use CSV as a universal format that can be imported into Excel, Google Sheets, etc.

## Verification
1. Exported file contains the correct number of records
2. Data matches the specified criteria (date, country, etc.)
3. File is in the requested format (CSV, JSON, etc.)
4. Exported data can be imported into analysis tools
