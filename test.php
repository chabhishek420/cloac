<?php
/**
 * Cloaker Test Page
 * Shows detection results without blocking
 */
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once 'core.php';
require_once 'settings.php';

//Instantiate cloaker with all filters
$cloaker = new Cloaker(
    $os_white,$country_white,$lang_white,$ip_black_filename,$ip_black_cidr,
    $tokens_black,$url_should_contain,$ua_black,$isp_black,
    $block_without_referer,$referer_stopwords,$block_vpnandtor,
    $block_spyservices,$block_datacenter,$vpn_fallback,$proxycheck_key,$ipqs_key
);

//Run check but don't block
$check_result = $cloaker->check();

//Get detection data
$detect = $cloaker->detect;
$reasons = $cloaker->result;

//Output as JSON for easy parsing
header('Content-Type: application/json');
echo json_encode([
    'blocked' => ($check_result === 1),
    'detection' => [
        'ip' => $detect['ip'],
        'country' => $detect['country'],
        'os' => $detect['os'],
        'isp' => $detect['isp'],
        'ua' => $detect['ua'],
        'referer' => $detect['referer'],
        'language' => $detect['lang']
    ],
    'triggered_filters' => $reasons,
    'filter_status' => [
        'spy_services' => $block_spyservices,
        'datacenter' => $block_datacenter,
        'vpn_tor' => $block_vpnandtor,
        'vpn_fallback' => $vpn_fallback
    ],
    'timestamp' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT);
?>
