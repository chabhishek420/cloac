<?php
/**
 * TikTok Events API - серверная отправка событий
 * Отправляет события напрямую в TikTok без участия браузера.
 * Не блокируется AdBlock, iOS Privacy, Safari ITP.
 */

/**
 * Хеширование PII для TikTok Events API (SHA256, lowercase, trimmed)
 */
function tt_hash($value){
    if(empty($value)) return null;
    return hash('sha256', strtolower(trim($value)));
}

/**
 * Нормализация телефона для TikTok (только цифры, с кодом страны)
 */
function tt_normalize_phone($phone){
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    $phone = ltrim($phone, '+');
    if(empty($phone)) return null;
    return $phone;
}

/**
 * Генерация уникального event_id для дедупликации клиент/сервер
 */
function tt_generate_event_id(){
    return bin2hex(random_bytes(16));
}

/**
 * Отправка события в TikTok Events API
 *
 * @param string $pixel_id   TikTok Pixel ID
 * @param string $token      Access Token для Events API
 * @param string $event_name Имя события (CompleteRegistration, SubmitForm, PlaceAnOrder и т.д.)
 * @param array  $user_data  Данные пользователя для матчинга
 * @param array  $properties Свойства события (value, currency и т.д.)
 * @param string $event_id   ID для дедупликации (опционально)
 * @param string $test_code  Код тестового события (опционально)
 * @return array             [success => bool, response => string]
 */
function send_tt_event($pixel_id, $token, $event_name, $user_data=[], $properties=[], $event_id='', $test_code=''){
    if(empty($pixel_id) || empty($token)) return ['success'=>false,'response'=>'No pixel_id or token'];

    $url = 'https://business-api.tiktok.com/open_api/v1.3/event/track/';

    //Формируем user data для матчинга
    $user = [];
    if(!empty($user_data['phone'])){
        $ph = tt_normalize_phone($user_data['phone']);
        if($ph) $user['phone_number'] = tt_hash($ph);
    }
    if(!empty($user_data['email'])) $user['email'] = tt_hash($user_data['email']);
    if(!empty($user_data['ip'])) $user['ip'] = $user_data['ip'];
    if(!empty($user_data['ua'])) $user['user_agent'] = $user_data['ua'];
    if(!empty($user_data['external_id'])) $user['external_id'] = tt_hash($user_data['external_id']);

    //TikTok click ID (ttclid)
    if(!empty($user_data['ttclid'])) $user['ttclid'] = $user_data['ttclid'];
    if(!empty($user_data['ttp'])) $user['ttp'] = $user_data['ttp'];

    //Формируем событие
    $event = [
        'event' => $event_name,
        'event_time' => time(),
        'user' => $user,
    ];

    if(!empty($event_id)) $event['event_id'] = $event_id;
    if(!empty($user_data['event_source_url'])) $event['page'] = ['url' => $user_data['event_source_url']];
    if(!empty($properties)) $event['properties'] = $properties;

    //Формируем запрос
    $payload = [
        'pixel_code' => $pixel_id,
        'event_source' => 'web',
        'data' => [$event],
    ];

    if(!empty($test_code)) $payload['test_event_code'] = $test_code;

    //Отправка через cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Access-Token: ' . $token,
    ]);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    //Логирование
    tt_log($event_name, $pixel_id, $http_code, $response, $error);

    return ['success' => ($http_code >= 200 && $http_code < 300), 'response' => $response];
}

/**
 * Отправка Lead события при конверсии (вызывается из send.php)
 */
function tt_send_lead($name, $phone, $subid){
    global $tt_events_enabled, $tt_access_token, $tt_test_code, $ttpixel_subname, $tt_lead_event;

    if(!$tt_events_enabled || empty($tt_access_token)) return null;

    $pixel_id = isset($_COOKIE[$ttpixel_subname]) ? $_COOKIE[$ttpixel_subname] : '';
    if(empty($pixel_id)) $pixel_id = isset($_GET[$ttpixel_subname]) ? $_GET[$ttpixel_subname] : '';
    if(empty($pixel_id)) return null;

    $event_id = tt_generate_event_id();
    //Сохраняем event_id в куки для дедупликации с клиентским пикселем
    if(function_exists('ywbsetcookie')) ywbsetcookie('tt_event_id', $event_id, '/');

    $user_data = [
        'phone' => $phone,
        'name' => $name,
        'ip' => isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] :
               (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] :
               (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0] :
               $_SERVER['REMOTE_ADDR'])),
        'ua' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
        'ttclid' => isset($_COOKIE['ttclid']) ? $_COOKIE['ttclid'] : '',
        'ttp' => isset($_COOKIE['_ttp']) ? $_COOKIE['_ttp'] : '',
        'external_id' => $subid,
        'event_source_url' => 'https://'.(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'').(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:''),
    ];

    $event_name = !empty($tt_lead_event) ? $tt_lead_event : 'SubmitForm';

    return send_tt_event($pixel_id, $tt_access_token, $event_name, $user_data, [], $event_id, $tt_test_code);
}

/**
 * Отправка Purchase события на постбэке (вызывается из postback.php)
 */
function tt_send_purchase($subid, $payout, $currency='USD'){
    global $tt_events_enabled, $tt_access_token, $tt_test_code;

    if(!$tt_events_enabled || empty($tt_access_token)) return null;

    //Ищем лид по subid для получения данных пользователя
    $dataDir = __DIR__."/logs";
    $leadsStore = new \SleekDB\Store("leads", $dataDir);
    $lead = $leadsStore->findOneBy([["subid", "=", $subid]]);
    if($lead===null) return null;

    //Ищем клик по subid для IP/UA
    $bclicksStore = new \SleekDB\Store("blackclicks", $dataDir);
    $click = $bclicksStore->findOneBy([["subid", "=", $subid]]);

    $pixel_id = isset($lead['ttpixelid']) ? $lead['ttpixelid'] : '';
    if(empty($pixel_id)) return null;

    $user_data = [
        'phone' => isset($lead['phone']) ? $lead['phone'] : '',
        'name' => isset($lead['name']) ? $lead['name'] : '',
        'email' => isset($lead['email']) ? $lead['email'] : '',
        'external_id' => $subid,
        'ttclid' => isset($lead['ttclid']) ? $lead['ttclid'] : '',
        'ttp' => isset($lead['ttp']) ? $lead['ttp'] : '',
    ];
    if($click!==null){
        $user_data['ip'] = isset($click['ip']) ? $click['ip'] : '';
        $user_data['ua'] = isset($click['ua']) ? $click['ua'] : '';
    }

    $properties = [];
    if(!empty($payout)){
        $properties['value'] = floatval($payout);
        $properties['currency'] = $currency;
    }

    return send_tt_event($pixel_id, $tt_access_token, 'PlaceAnOrder', $user_data, $properties, '', $tt_test_code);
}

/**
 * Логирование TikTok Events API
 */
function tt_log($event, $pixel, $http_code, $response, $error=''){
    $log_dir = __DIR__."/pblogs";
    if(!file_exists($log_dir)) mkdir($log_dir);
    $file = $log_dir."/".date("d.m.y").".ttevents.log";
    $msg = date("Y-m-d H:i:s")." $event pixel=$pixel code=$http_code";
    if(!empty($error)) $msg .= " error=$error";
    $msg .= " response=".substr($response,0,200)."\n";
    file_put_contents($file, $msg, FILE_APPEND);
}
?>
