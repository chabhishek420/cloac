#!/usr/bin/env python3
"""
Google Ads Offline Conversion Exporter for YellowCloaker
Exports leads with GCLID to CSV format for Google Ads offline conversion import.

Usage:
    python3 tools/export_google_conversions.py [--days 7] [--status Lead]
"""

import argparse
import csv
import json
import logging
import sys
from datetime import datetime, timedelta
from pathlib import Path
from typing import List, Dict

# Logging setup
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)


def read_leads_from_sleekdb(logs_dir: Path) -> List[Dict]:
    """Read all leads from SleekDB JSON files."""
    leads = []
    leads_dir = logs_dir / 'leads'

    if not leads_dir.exists():
        logger.error(f"Leads directory not found: {leads_dir}")
        return leads

    # SleekDB stores data in numbered JSON files
    for json_file in leads_dir.glob('*.json'):
        try:
            with open(json_file, 'r') as f:
                lead_data = json.load(f)
                leads.append(lead_data)
        except Exception as e:
            logger.warning(f"Failed to read {json_file}: {e}")

    return leads


def filter_leads(leads: List[Dict], days: int = None, status: str = None) -> List[Dict]:
    """Filter leads by date range and status."""
    filtered = []

    if days:
        cutoff_time = datetime.now().timestamp() - (days * 24 * 60 * 60)
    else:
        cutoff_time = 0

    for lead in leads:
        # Filter by time
        if lead.get('time', 0) < cutoff_time:
            continue

        # Filter by status
        if status and lead.get('status', '') != status:
            continue

        # Must have GCLID
        if not lead.get('gclid'):
            continue

        filtered.append(lead)

    return filtered


def format_conversion_time(timestamp: int) -> str:
    """Format timestamp to Google Ads conversion time format."""
    dt = datetime.fromtimestamp(timestamp)
    # Format: yyyy-MM-dd HH:mm:ss+00:00 (assuming UTC)
    return dt.strftime('%Y-%m-%d %H:%M:%S+00:00')


def export_to_csv(leads: List[Dict], output_file: Path, conversion_name: str = 'Lead',
                  currency: str = 'USD') -> int:
    """Export leads to Google Ads offline conversion CSV format."""

    if not leads:
        logger.warning("No leads to export")
        return 0

    # Google Ads offline conversion CSV format
    # Required: Google Click ID, Conversion Name, Conversion Time
    # Optional: Conversion Value, Conversion Currency

    fieldnames = [
        'Google Click ID',
        'Conversion Name',
        'Conversion Time',
        'Conversion Value',
        'Conversion Currency'
    ]

    exported_count = 0

    try:
        with open(output_file, 'w', newline='') as csvfile:
            writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
            writer.writeheader()

            for lead in leads:
                gclid = lead.get('gclid', '')
                if not gclid:
                    continue

                conversion_time = format_conversion_time(lead.get('time', 0))

                # Get payout if available (from postback updates)
                payout = lead.get('payout', '')

                row = {
                    'Google Click ID': gclid,
                    'Conversion Name': conversion_name,
                    'Conversion Time': conversion_time,
                    'Conversion Value': payout if payout else '',
                    'Conversion Currency': currency if payout else ''
                }

                writer.writerow(row)
                exported_count += 1

        logger.info(f"✓ Exported {exported_count} conversions to {output_file}")
        return exported_count

    except Exception as e:
        logger.error(f"Failed to write CSV: {e}")
        return 0


def main():
    parser = argparse.ArgumentParser(
        description='Export Google Ads offline conversions from YellowCloaker'
    )
    parser.add_argument(
        '--days',
        type=int,
        default=7,
        help='Export conversions from last N days (default: 7)'
    )
    parser.add_argument(
        '--status',
        type=str,
        default='Lead',
        help='Filter by conversion status (default: Lead)'
    )
    parser.add_argument(
        '--conversion-name',
        type=str,
        default='Lead',
        help='Conversion action name in Google Ads (default: Lead)'
    )
    parser.add_argument(
        '--currency',
        type=str,
        default='USD',
        help='Currency code for conversion value (default: USD)'
    )
    parser.add_argument(
        '--output',
        type=str,
        help='Output CSV file path (default: .tmp/google_conversions_YYYYMMDD.csv)'
    )

    args = parser.parse_args()

    # Determine project root
    script_dir = Path(__file__).parent
    project_root = script_dir.parent
    logs_dir = project_root / 'logs'

    logger.info("=" * 60)
    logger.info("Google Ads Offline Conversion Exporter")
    logger.info("=" * 60)
    logger.info(f"Project root: {project_root}")
    logger.info(f"Logs directory: {logs_dir}")
    logger.info(f"Days filter: {args.days}")
    logger.info(f"Status filter: {args.status}")
    logger.info("")

    # Read leads
    logger.info("Reading leads from SleekDB...")
    all_leads = read_leads_from_sleekdb(logs_dir)
    logger.info(f"Found {len(all_leads)} total leads")

    # Filter leads
    logger.info(f"Filtering leads (last {args.days} days, status={args.status}, with GCLID)...")
    filtered_leads = filter_leads(all_leads, days=args.days, status=args.status)
    logger.info(f"Filtered to {len(filtered_leads)} leads with GCLID")

    if not filtered_leads:
        logger.warning("No leads with GCLID found. Make sure:")
        logger.warning("  1. Google Ads campaigns are passing ?gclid= parameter")
        logger.warning("  2. set_google_cookies() is being called")
        logger.warning("  3. Leads have been submitted in the last {} days".format(args.days))
        return 1

    # Determine output file
    if args.output:
        output_file = Path(args.output)
    else:
        tmp_dir = project_root / '.tmp'
        tmp_dir.mkdir(exist_ok=True)
        output_file = tmp_dir / f"google_conversions_{datetime.now().strftime('%Y%m%d_%H%M%S')}.csv"

    # Export to CSV
    logger.info("")
    logger.info(f"Exporting to {output_file}...")
    exported = export_to_csv(
        filtered_leads,
        output_file,
        conversion_name=args.conversion_name,
        currency=args.currency
    )

    if exported > 0:
        logger.info("")
        logger.info("=" * 60)
        logger.info("✓ Export completed successfully")
        logger.info("=" * 60)
        logger.info(f"File: {output_file}")
        logger.info(f"Conversions: {exported}")
        logger.info("")
        logger.info("Next steps:")
        logger.info("1. Go to Google Ads → Tools → Conversions")
        logger.info("2. Click 'Uploads' → 'Upload'")
        logger.info("3. Select your conversion action")
        logger.info("4. Upload the CSV file")
        return 0
    else:
        logger.error("Export failed")
        return 1


if __name__ == '__main__':
    sys.exit(main())
