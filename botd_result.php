<?php
/**
 * BotD Result Receiver
 * Receives bot detection results from client-side BotD library
 * Stores results in session for use in filtering logic
 */

// Start session to store bot detection result
if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set("session.cookie_secure", 1);
    session_start();
}

// Get bot detection result from POST data
$bot = isset($_POST['bot']) ? intval($_POST['bot']) : 0;
$botKind = isset($_POST['botKind']) ? $_POST['botKind'] : '';
$components = isset($_POST['components']) ? $_POST['components'] : '';

// Store in session
$_SESSION['botd_result'] = [
    'bot' => $bot,
    'botKind' => $botKind,
    'components' => $components,
    'timestamp' => time()
];

// Log bot detection (optional)
if ($bot === 1) {
    $log_dir = __DIR__ . "/pblogs";
    if (!file_exists($log_dir)) mkdir($log_dir);
    $file = $log_dir . "/" . date("d.m.y") . ".botd.log";
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown';
    $msg = date("Y-m-d H:i:s") . " BOT DETECTED ip=$ip kind=$botKind ua=$ua\n";
    file_put_contents($file, $msg, FILE_APPEND);
}

// Return success
http_response_code(204); // No Content
session_write_close();
?>
