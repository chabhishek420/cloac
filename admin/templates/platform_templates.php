<?php
/**
 * Pre-configured platform templates for YellowCloaker
 * Battle-tested settings for major traffic sources
 */

class PlatformTemplates {

    public static function getTemplates() {
        return [
            'facebook_ads' => self::getFacebookAdsTemplate(),
            'tiktok_ads' => self::getTikTokAdsTemplate(),
            'google_ads' => self::getGoogleAdsTemplate(),
            'native_push' => self::getNativePushTemplate(),
            'taboola' => self::getTaboolaTemplate(),
            'outbrain' => self::getOutbrainTemplate(),
            'custom' => self::getCustomTemplate(),
        ];
    }

    private static function getFacebookAdsTemplate() {
        return [
            'name' => 'Facebook Ads',
            'description' => 'Optimized for Facebook/Instagram ad campaigns with strict moderation',
            'icon' => '📘',
            'category' => 'social',
            'settings' => [
                'tds' => [
                    'mode' => 'on',
                    'saveuserflow' => true,
                    'filters' => [
                        'allowed' => [
                            'countries' => [], // All countries
                            'os' => ['Android', 'iOS', 'Windows', 'OS X'],
                            'languages' => [],
                            'inurl' => ['fbclid'], // Require Facebook click ID
                        ],
                        'blocked' => [
                            'ips' => [
                                'filename' => 'bases/bots.txt',
                                'cidrformat' => false,
                            ],
                            'tokens' => ['preview', 'test', 'debug'],
                            'useragents' => ['facebook', 'Facebot', 'facebookexternalhit', 'curl', 'wget', 'bot'],
                            'isps' => ['facebook', 'meta', 'google', 'amazon', 'microsoft', 'digitalocean'],
                            'referer' => [
                                'empty' => true, // Block empty referrer
                                'stopwords' => ['facebook.com/business', 'facebook.com/ads'],
                            ],
                            'vpntor' => true,
                            'spyservices' => true,
                            'datacenter' => true,
                            'vpnfallback' => false,
                            'botd' => [
                                'enabled' => true,
                                'timeout' => 300,
                            ],
                        ],
                    ],
                ],
                'white' => [
                    'action' => 'folder',
                    'jschecks' => [
                        'enabled' => true,
                        'events' => ['mousemove', 'scroll', 'audiocontext', 'timezone'],
                        'timeout' => '30000',
                        'obfuscate' => true,
                        'tzstart' => '-12',
                        'tzend' => '14',
                    ],
                ],
                'pixels' => [
                    'fb' => [
                        'subname' => 'px',
                        'pageview' => true,
                        'viewcontent' => [
                            'use' => true,
                            'time' => '30',
                            'percent' => '75',
                        ],
                        'conversion' => [
                            'event' => 'Lead',
                            'fireonbutton' => false,
                        ],
                        'capi' => [
                            'enabled' => true, // User must add token
                        ],
                    ],
                ],
                'subids' => [
                    ['name' => 'subid', 'rewrite' => 'sub1'],
                    ['name' => 'campaign_id', 'rewrite' => 'sub2'],
                    ['name' => 'adset_id', 'rewrite' => 'sub3'],
                    ['name' => 'ad_id', 'rewrite' => 'sub4'],
                    ['name' => 'placement', 'rewrite' => 'sub5'],
                ],
            ],
            'recommended' => [
                'Use custom thank you page for better tracking',
                'Enable Facebook CAPI for iOS 14.5+ tracking',
                'Set ViewContent at 30s + 75% scroll for quality signals',
                'Block datacenter IPs and VPN/Tor aggressively',
                'Use JS checks to filter bots during moderation',
            ],
        ];
    }

    private static function getTikTokAdsTemplate() {
        return [
            'name' => 'TikTok Ads',
            'description' => 'Optimized for TikTok ad campaigns with Events API integration',
            'icon' => '🎵',
            'category' => 'social',
            'settings' => [
                'tds' => [
                    'mode' => 'on',
                    'saveuserflow' => true,
                    'filters' => [
                        'allowed' => [
                            'countries' => [],
                            'os' => ['Android', 'iOS'],
                            'languages' => [],
                            'inurl' => ['ttclid'], // Require TikTok click ID
                        ],
                        'blocked' => [
                            'ips' => [
                                'filename' => 'bases/bots.txt',
                                'cidrformat' => false,
                            ],
                            'tokens' => ['preview', 'test'],
                            'useragents' => ['tiktok', 'bytespider', 'bot', 'curl'],
                            'isps' => ['bytedance', 'tiktok', 'google', 'amazon', 'microsoft'],
                            'referer' => [
                                'empty' => true,
                                'stopwords' => [],
                            ],
                            'vpntor' => true,
                            'spyservices' => true,
                            'datacenter' => true,
                            'vpnfallback' => false,
                            'botd' => [
                                'enabled' => true,
                                'timeout' => 300,
                            ],
                        ],
                    ],
                ],
                'white' => [
                    'action' => 'folder',
                    'jschecks' => [
                        'enabled' => true,
                        'events' => ['mousemove', 'scroll', 'devicemotion', 'deviceorientation'],
                        'timeout' => '25000',
                        'obfuscate' => true,
                        'tzstart' => '-12',
                        'tzend' => '14',
                    ],
                ],
                'pixels' => [
                    'tt' => [
                        'subname' => 'tpx',
                        'pageview' => true,
                        'viewcontent' => [
                            'use' => true,
                            'time' => '25',
                            'percent' => '70',
                        ],
                        'conversion' => [
                            'event' => 'CompletePayment',
                            'fireonbutton' => false,
                        ],
                        'eventsapi' => [
                            'enabled' => true, // User must add token
                            'leadevent' => 'SubmitForm',
                        ],
                    ],
                ],
                'subids' => [
                    ['name' => 'subid', 'rewrite' => 'sub1'],
                    ['name' => 'campaign_id', 'rewrite' => 'sub2'],
                    ['name' => 'adgroup_id', 'rewrite' => 'sub3'],
                    ['name' => 'creative_id', 'rewrite' => 'sub4'],
                ],
            ],
            'recommended' => [
                'Enable TikTok Events API for server-side tracking',
                'Use mobile-optimized prelandings (TikTok is 95% mobile)',
                'Set shorter ViewContent time (25s) for mobile attention span',
                'Block ByteSpider crawler aggressively',
                'Use device motion/orientation checks for mobile verification',
            ],
        ];
    }

    private static function getGoogleAdsTemplate() {
        return [
            'name' => 'Google Ads',
            'description' => 'Optimized for Google Search/Display/YouTube campaigns',
            'icon' => '🔍',
            'category' => 'search',
            'settings' => [
                'tds' => [
                    'mode' => 'on',
                    'saveuserflow' => true,
                    'filters' => [
                        'allowed' => [
                            'countries' => [],
                            'os' => ['Android', 'iOS', 'Windows', 'OS X'],
                            'languages' => [],
                            'inurl' => ['gclid'], // Require Google click ID
                        ],
                        'blocked' => [
                            'ips' => [
                                'filename' => 'bases/bots.txt',
                                'cidrformat' => false,
                            ],
                            'tokens' => ['preview', 'test'],
                            'useragents' => ['google', 'googlebot', 'adsbot', 'mediapartners', 'bot'],
                            'isps' => ['google', 'googleusercontent', 'amazon', 'microsoft'],
                            'referer' => [
                                'empty' => false, // Google often has referrer
                                'stopwords' => ['google.com/ads', 'adwords.google.com'],
                            ],
                            'vpntor' => true,
                            'spyservices' => true,
                            'datacenter' => true,
                            'vpnfallback' => false,
                            'botd' => [
                                'enabled' => true,
                                'timeout' => 300,
                            ],
                        ],
                    ],
                ],
                'white' => [
                    'action' => 'folder',
                    'jschecks' => [
                        'enabled' => true,
                        'events' => ['mousemove', 'keydown', 'scroll'],
                        'timeout' => '35000',
                        'obfuscate' => true,
                        'tzstart' => '-12',
                        'tzend' => '14',
                    ],
                ],
                'pixels' => [
                    'gtm' => [
                        'id' => '', // User must add GTM ID
                    ],
                ],
                'subids' => [
                    ['name' => 'subid', 'rewrite' => 'sub1'],
                    ['name' => 'campaignid', 'rewrite' => 'sub2'],
                    ['name' => 'adgroupid', 'rewrite' => 'sub3'],
                    ['name' => 'keyword', 'rewrite' => 'sub4'],
                    ['name' => 'placement', 'rewrite' => 'sub5'],
                ],
            ],
            'recommended' => [
                'Use Google Tag Manager for conversion tracking',
                'Capture GCLID for offline conversion import',
                'Block Google crawler IPs (googlebot, adsbot)',
                'Use keyword-level tracking with sub5',
                'Enable JS checks for Quality Score protection',
            ],
        ];
    }

    private static function getNativePushTemplate() {
        return [
            'name' => 'Native/Push Networks',
            'description' => 'Aggressive filtering for PropellerAds, RichAds, MGID, etc.',
            'icon' => '🔔',
            'category' => 'native',
            'settings' => [
                'tds' => [
                    'mode' => 'on',
                    'saveuserflow' => true,
                    'filters' => [
                        'allowed' => [
                            'countries' => [], // Set specific GEOs
                            'os' => ['Android', 'iOS', 'Windows'],
                            'languages' => [],
                            'inurl' => [],
                        ],
                        'blocked' => [
                            'ips' => [
                                'filename' => 'bases/bots.txt',
                                'cidrformat' => false,
                            ],
                            'tokens' => ['preview', 'test', 'admin'],
                            'useragents' => ['bot', 'crawler', 'spider', 'curl', 'wget', 'python'],
                            'isps' => ['google', 'amazon', 'microsoft', 'digitalocean', 'ovh', 'hetzner'],
                            'referer' => [
                                'empty' => false, // Require referrer
                                'stopwords' => ['adspy', 'bigspy', 'anstrex'],
                            ],
                            'vpntor' => true,
                            'spyservices' => true,
                            'datacenter' => true,
                            'vpnfallback' => false,
                            'botd' => [
                                'enabled' => true,
                                'timeout' => 300,
                            ],
                        ],
                    ],
                ],
                'white' => [
                    'action' => 'folder',
                    'jschecks' => [
                        'enabled' => false, // Native traffic is fast, no time for JS
                        'events' => [],
                        'timeout' => '0',
                        'obfuscate' => false,
                    ],
                ],
                'scripts' => [
                    'comebacker' => true,
                    'callbacker' => true,
                    'addedtocart' => true,
                ],
                'subids' => [
                    ['name' => 'subid', 'rewrite' => 'sub1'],
                    ['name' => 'source', 'rewrite' => 'sub2'],
                    ['name' => 'campaign', 'rewrite' => 'sub3'],
                    ['name' => 'widget', 'rewrite' => 'sub4'],
                ],
            ],
            'recommended' => [
                'Use aggressive ISP/datacenter blocking',
                'Disable JS checks (native traffic bounces fast)',
                'Enable all engagement scripts (comebacker, social proof)',
                'Require referrer to block direct access',
                'Set specific GEO targeting (native has low-quality traffic)',
            ],
        ];
    }

    private static function getTaboolaTemplate() {
        return [
            'name' => 'Taboola',
            'description' => 'Optimized for Taboola native advertising',
            'icon' => '📰',
            'category' => 'native',
            'settings' => [
                'tds' => [
                    'mode' => 'on',
                    'saveuserflow' => true,
                    'filters' => [
                        'allowed' => [
                            'countries' => [],
                            'os' => ['Android', 'iOS', 'Windows', 'OS X'],
                            'languages' => [],
                            'inurl' => [],
                        ],
                        'blocked' => [
                            'ips' => [
                                'filename' => 'bases/bots.txt',
                                'cidrformat' => false,
                            ],
                            'tokens' => ['preview', 'test'],
                            'useragents' => ['taboola', 'bot', 'crawler'],
                            'isps' => ['taboola', 'google', 'amazon', 'microsoft'],
                            'referer' => [
                                'empty' => false,
                                'stopwords' => ['taboola.com/admin'],
                            ],
                            'vpntor' => true,
                            'spyservices' => true,
                            'datacenter' => true,
                            'vpnfallback' => false,
                            'botd' => [
                                'enabled' => true,
                                'timeout' => 300,
                            ],
                        ],
                    ],
                ],
                'subids' => [
                    ['name' => 'subid', 'rewrite' => 'sub1'],
                    ['name' => 'campaign', 'rewrite' => 'sub2'],
                    ['name' => 'site', 'rewrite' => 'sub3'],
                    ['name' => 'thumbnail', 'rewrite' => 'sub4'],
                ],
            ],
            'recommended' => [
                'Block Taboola crawler IPs',
                'Track site-level performance with sub3',
                'Use thumbnail tracking for creative optimization',
                'Enable datacenter blocking',
            ],
        ];
    }

    private static function getOutbrainTemplate() {
        return [
            'name' => 'Outbrain',
            'description' => 'Optimized for Outbrain native advertising',
            'icon' => '📱',
            'category' => 'native',
            'settings' => [
                'tds' => [
                    'mode' => 'on',
                    'saveuserflow' => true,
                    'filters' => [
                        'allowed' => [
                            'countries' => [],
                            'os' => ['Android', 'iOS', 'Windows', 'OS X'],
                            'languages' => [],
                            'inurl' => [],
                        ],
                        'blocked' => [
                            'ips' => [
                                'filename' => 'bases/bots.txt',
                                'cidrformat' => false,
                            ],
                            'tokens' => ['preview', 'test'],
                            'useragents' => ['outbrain', 'bot', 'crawler'],
                            'isps' => ['outbrain', 'google', 'amazon', 'microsoft'],
                            'referer' => [
                                'empty' => false,
                                'stopwords' => ['outbrain.com/admin'],
                            ],
                            'vpntor' => true,
                            'spyservices' => true,
                            'datacenter' => true,
                            'vpnfallback' => false,
                            'botd' => [
                                'enabled' => true,
                                'timeout' => 300,
                            ],
                        ],
                    ],
                ],
                'subids' => [
                    ['name' => 'subid', 'rewrite' => 'sub1'],
                    ['name' => 'campaign_id', 'rewrite' => 'sub2'],
                    ['name' => 'publisher_id', 'rewrite' => 'sub3'],
                    ['name' => 'section_id', 'rewrite' => 'sub4'],
                ],
            ],
            'recommended' => [
                'Block Outbrain crawler IPs',
                'Track publisher-level performance',
                'Use section tracking for placement optimization',
                'Enable datacenter blocking',
            ],
        ];
    }

    private static function getCustomTemplate() {
        return [
            'name' => 'Custom Configuration',
            'description' => 'Start from scratch with default settings',
            'icon' => '⚙️',
            'category' => 'custom',
            'settings' => [
                'tds' => [
                    'mode' => 'on',
                    'saveuserflow' => false,
                    'filters' => [
                        'allowed' => [
                            'countries' => [],
                            'os' => [],
                            'languages' => [],
                            'inurl' => [],
                        ],
                        'blocked' => [
                            'ips' => [
                                'filename' => '',
                                'cidrformat' => false,
                            ],
                            'tokens' => [],
                            'useragents' => [],
                            'isps' => [],
                            'referer' => [
                                'empty' => false,
                                'stopwords' => [],
                            ],
                            'vpntor' => false,
                            'spyservices' => false,
                            'datacenter' => false,
                            'vpnfallback' => false,
                            'botd' => [
                                'enabled' => false,
                                'timeout' => 300,
                            ],
                        ],
                    ],
                ],
                'subids' => [
                    ['name' => 'subid', 'rewrite' => 'sub1'],
                ],
            ],
            'recommended' => [
                'Configure filters based on your traffic source',
                'Add pixel tracking for your platform',
                'Set up sub-ID mapping for tracking',
                'Test with TDS mode "off" first',
            ],
        ];
    }
}
