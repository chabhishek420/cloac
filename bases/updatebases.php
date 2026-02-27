<?php
/**
 * Скрипт обновления базы IP адресов датацентров
 * Загружает актуальные CIDR из lord-alfred/ipranges (обновляется ежедневно)
 *
 * Использование:
 *   php bases/updatebases.php
 *   или через админку (кнопка "Обновить базы")
 *
 * Источники:
 *   https://github.com/lord-alfred/ipranges
 */

$is_cli = (php_sapi_name() === 'cli');
$is_admin = false;

if(!$is_cli){
    require_once __DIR__.'/../admin/password.php';
    check_password();
    $is_admin = true;
}

function logmsg($msg, $is_cli){
    if($is_cli){
        echo $msg."\n";
    } else {
        echo htmlspecialchars($msg)."<br>";
    }
}

//Провайдеры датацентров для блокировки (только IPv4 merged для скорости)
$datacenter_sources = [
    'amazon'       => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/amazon/ipv4_merged.txt',
    'google'       => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/google/ipv4_merged.txt',
    'microsoft'    => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/microsoft/ipv4_merged.txt',
    'oracle'       => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/oracle/ipv4_merged.txt',
    'digitalocean' => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/digitalocean/ipv4_merged.txt',
    'linode'       => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/linode/ipv4_merged.txt',
    'vultr'        => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/vultr/ipv4_merged.txt',
    'github'       => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/github/ipv4_merged.txt',
    'openai'       => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/openai/ipv4_merged.txt',
    'perplexity'   => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/perplexity/ipv4_merged.txt',
    'facebook'     => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/facebook/ipv4_merged.txt',
    'twitter'      => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/twitter/ipv4_merged.txt',
];

//VPN выходные ноды - НЕ включаем в datacenter.txt
//ProtonVPN детектится через blackbox/proxycheck/ipqs API
//Включение в datacenter.txt вызывает ложные срабатывания
//когда VPN-блокировка выключена, а блокировка датацентров включена

//Бот-краулеры (отдельно от датацентров)
$bot_sources = [
    'googlebot'    => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/googlebot/ipv4_merged.txt',
    'bing'         => 'https://raw.githubusercontent.com/lord-alfred/ipranges/main/bing/ipv4_merged.txt',
];

$output_file = __DIR__.'/datacenter.txt';
$bots_extra_file = __DIR__.'/bots_extra.txt';
$ctx = stream_context_create(['http'=>['timeout'=>15,'user_agent'=>'YellowCloaker-Updater/1.0']]);

$all_cidrs = [];
$total_ranges = 0;
$errors = [];

logmsg("=== Обновление базы IP датацентров ===", $is_cli);
logmsg("Дата: ".date('Y-m-d H:i:s'), $is_cli);
logmsg("", $is_cli);

//Загрузка IP датацентров
foreach($datacenter_sources as $name => $url){
    $data = @file_get_contents($url, false, $ctx);
    if($data === false){
        $errors[] = $name;
        logmsg("[ОШИБКА] $name: не удалось загрузить", $is_cli);
        continue;
    }
    $lines = array_filter(array_map('trim', explode("\n", $data)), function($l){
        return !empty($l) && $l[0] !== '#';
    });
    $count = count($lines);
    $total_ranges += $count;
    $all_cidrs = array_merge($all_cidrs, $lines);
    logmsg("[OK] $name: $count диапазонов", $is_cli);
}

//Удаляем дубликаты
$all_cidrs = array_unique($all_cidrs);
$unique_count = count($all_cidrs);

//Записываем datacenter.txt
$header = "# Datacenter IP ranges - auto-updated ".date('Y-m-d H:i:s')."\n";
$header .= "# Source: github.com/lord-alfred/ipranges\n";
$header .= "# Total: $unique_count unique CIDR ranges\n";
$content = $header . implode("\n", $all_cidrs) . "\n";

if(file_put_contents($output_file, $content) !== false){
    logmsg("", $is_cli);
    logmsg("Записано $unique_count уникальных диапазонов в datacenter.txt", $is_cli);
} else {
    logmsg("[ОШИБКА] Не удалось записать datacenter.txt", $is_cli);
}

//Загрузка доп. ботов
$bot_cidrs = [];
foreach($bot_sources as $name => $url){
    $data = @file_get_contents($url, false, $ctx);
    if($data === false){
        logmsg("[ПРОПУСК] $name: не удалось загрузить", $is_cli);
        continue;
    }
    $lines = array_filter(array_map('trim', explode("\n", $data)), function($l){
        return !empty($l) && $l[0] !== '#';
    });
    $bot_cidrs = array_merge($bot_cidrs, $lines);
    logmsg("[OK] $name (боты): ".count($lines)." диапазонов", $is_cli);
}

if(!empty($bot_cidrs)){
    $bot_cidrs = array_unique($bot_cidrs);
    $bot_header = "# Bot crawler IP ranges - auto-updated ".date('Y-m-d H:i:s')."\n";
    $bot_header .= "# Source: github.com/lord-alfred/ipranges\n";
    $bot_content = $bot_header . implode("\n", $bot_cidrs) . "\n";
    file_put_contents($bots_extra_file, $bot_content);
    logmsg("Записано ".count($bot_cidrs)." бот-диапазонов в bots_extra.txt", $is_cli);
}

logmsg("", $is_cli);
if(!empty($errors)){
    logmsg("ВНИМАНИЕ: не удалось загрузить: ".implode(', ', $errors), $is_cli);
}
logmsg("=== Обновление завершено ===", $is_cli);

if($is_admin){
    echo '<br><a href="editsettings.php?password='.$log_password.'">Назад в настройки</a>';
}
?>
