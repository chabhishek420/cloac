#!/usr/bin/env python3
"""
IP Range Updater for YellowCloaker
Fetches bot IP ranges from authoritative sources and updates local detection files.

Sources:
- lord-alfred/ipranges (Google, Meta, Bing, AWS, Cloudflare, etc.)
- platformbuilds/ip-ranges (community-sourced)

Usage:
    python tools/update_ip_ranges.py [--dry-run] [--verbose]
"""

import argparse
import json
import logging
import os
import sys
from datetime import datetime
from pathlib import Path
from typing import Dict, List, Set
import urllib.request
import urllib.error

# Configuration
GITHUB_REPOS = {
    'lord-alfred': 'https://raw.githubusercontent.com/lord-alfred/ipranges/main',
    'platformbuilds': 'https://raw.githubusercontent.com/platformbuilds/ip-ranges/main'
}

# IP range files to fetch (platform -> filename mapping)
IP_SOURCES = {
    'google': {
        'repo': 'lord-alfred',
        'files': ['google/ipv4.txt', 'google/ipv6.txt']
    },
    'facebook': {
        'repo': 'lord-alfred',
        'files': ['facebook/ipv4.txt', 'facebook/ipv6.txt']
    },
    'microsoft': {
        'repo': 'lord-alfred',
        'files': ['microsoft/ipv4.txt', 'microsoft/ipv6.txt']
    },
    'aws': {
        'repo': 'lord-alfred',
        'files': ['aws/ipv4.txt', 'aws/ipv6.txt']
    },
    'cloudflare': {
        'repo': 'lord-alfred',
        'files': ['cloudflare/ipv4.txt', 'cloudflare/ipv6.txt']
    },
    'digitalocean': {
        'repo': 'lord-alfred',
        'files': ['digitalocean/ipv4.txt']
    },
    'linode': {
        'repo': 'lord-alfred',
        'files': ['linode/ipv4.txt']
    },
    'ovh': {
        'repo': 'lord-alfred',
        'files': ['ovh/ipv4.txt']
    }
}

# Output file in YellowCloaker bases directory
OUTPUT_FILE = 'bases/bots.txt'
BACKUP_SUFFIX = '.backup'

# Logging setup
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)


def fetch_url(url: str, timeout: int = 10) -> str:
    """Fetch content from URL with error handling."""
    try:
        with urllib.request.urlopen(url, timeout=timeout) as response:
            return response.read().decode('utf-8')
    except urllib.error.HTTPError as e:
        logger.error(f"HTTP error fetching {url}: {e.code} {e.reason}")
        return ""
    except urllib.error.URLError as e:
        logger.error(f"URL error fetching {url}: {e.reason}")
        return ""
    except Exception as e:
        logger.error(f"Unexpected error fetching {url}: {e}")
        return ""


def fetch_ip_ranges() -> Dict[str, Set[str]]:
    """Fetch IP ranges from all configured sources."""
    all_ranges = {}

    for platform, config in IP_SOURCES.items():
        logger.info(f"Fetching {platform} IP ranges...")
        ranges = set()

        repo_base = GITHUB_REPOS[config['repo']]

        for file_path in config['files']:
            url = f"{repo_base}/{file_path}"
            logger.debug(f"  Fetching {url}")

            content = fetch_url(url)
            if content:
                # Parse IP ranges (one per line, skip comments and empty lines)
                for line in content.splitlines():
                    line = line.strip()
                    if line and not line.startswith('#'):
                        ranges.add(line)

        if ranges:
            all_ranges[platform] = ranges
            logger.info(f"  ✓ Fetched {len(ranges)} ranges for {platform}")
        else:
            logger.warning(f"  ✗ No ranges fetched for {platform}")

    return all_ranges


def merge_ranges(ranges_dict: Dict[str, Set[str]]) -> List[str]:
    """Merge all IP ranges into a single sorted list."""
    all_ranges = set()

    for platform, ranges in ranges_dict.items():
        all_ranges.update(ranges)

    # Sort for consistent output
    return sorted(all_ranges)


def backup_existing_file(file_path: Path) -> bool:
    """Create backup of existing file."""
    if not file_path.exists():
        return True

    backup_path = file_path.with_suffix(file_path.suffix + BACKUP_SUFFIX)
    try:
        import shutil
        shutil.copy2(file_path, backup_path)
        logger.info(f"Created backup: {backup_path}")
        return True
    except Exception as e:
        logger.error(f"Failed to create backup: {e}")
        return False


def write_ranges_file(ranges: List[str], output_path: Path, dry_run: bool = False) -> bool:
    """Write IP ranges to output file with header."""
    if dry_run:
        logger.info(f"[DRY RUN] Would write {len(ranges)} ranges to {output_path}")
        return True

    try:
        # Create header
        header = f"""# YellowCloaker Bot IP Ranges
# Auto-generated on {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}
# Sources: lord-alfred/ipranges, platformbuilds/ip-ranges
# Total ranges: {len(ranges)}
#
# This file is automatically updated by tools/update_ip_ranges.py
# Do not edit manually - changes will be overwritten
#

"""

        # Write file
        with open(output_path, 'w') as f:
            f.write(header)
            for ip_range in ranges:
                f.write(f"{ip_range}\n")

        logger.info(f"✓ Wrote {len(ranges)} ranges to {output_path}")
        return True

    except Exception as e:
        logger.error(f"Failed to write file: {e}")
        return False


def main():
    parser = argparse.ArgumentParser(description='Update YellowCloaker bot IP ranges')
    parser.add_argument('--dry-run', action='store_true', help='Show what would be done without making changes')
    parser.add_argument('--verbose', '-v', action='store_true', help='Enable verbose logging')
    args = parser.parse_args()

    if args.verbose:
        logger.setLevel(logging.DEBUG)

    # Determine project root (script is in tools/ subdirectory)
    script_dir = Path(__file__).parent
    project_root = script_dir.parent
    output_path = project_root / OUTPUT_FILE

    logger.info("=" * 60)
    logger.info("YellowCloaker IP Range Updater")
    logger.info("=" * 60)
    logger.info(f"Project root: {project_root}")
    logger.info(f"Output file: {output_path}")
    logger.info(f"Dry run: {args.dry_run}")
    logger.info("")

    # Fetch IP ranges
    logger.info("Fetching IP ranges from GitHub...")
    ranges_dict = fetch_ip_ranges()

    if not ranges_dict:
        logger.error("Failed to fetch any IP ranges. Aborting.")
        return 1

    # Merge ranges
    logger.info("")
    logger.info("Merging IP ranges...")
    merged_ranges = merge_ranges(ranges_dict)
    logger.info(f"Total unique ranges: {len(merged_ranges)}")

    # Show summary by platform
    logger.info("")
    logger.info("Summary by platform:")
    for platform, ranges in sorted(ranges_dict.items()):
        logger.info(f"  {platform:15s}: {len(ranges):6d} ranges")

    # Backup existing file
    if not args.dry_run and output_path.exists():
        logger.info("")
        if not backup_existing_file(output_path):
            logger.error("Failed to create backup. Aborting.")
            return 1

    # Write new file
    logger.info("")
    if write_ranges_file(merged_ranges, output_path, dry_run=args.dry_run):
        logger.info("")
        logger.info("=" * 60)
        logger.info("✓ IP ranges updated successfully")
        logger.info("=" * 60)
        return 0
    else:
        logger.error("Failed to write IP ranges file")
        return 1


if __name__ == '__main__':
    sys.exit(main())
