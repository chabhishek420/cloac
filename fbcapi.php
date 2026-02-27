<?php
/**
 * Facebook Conversions API (CAPI) - серверная отправка событий
 * Отправляет события напрямую в Facebook без участия браузера.
 * Не блокируется AdBlock, iOS Privacy, Safari ITP.
 */

/**
 * Хеширование PII для CAPI (SHA256, lowercase, trimmed)
 */
function capi_hash($value){
    if(empty($value)) return null;
    return hash('sha256', strtolower(trim($value)));
}

/**
 * Нормализация телефона (только цифры, с кодом страны)
 */
function capi_normalize_phone($phone){
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    $phone = ltrim($phone, '+');
    if(empty($phone)) return null;
    return $phone;
}

/**
 * Генерация уникального event_id для дедупликации клиент/сервер
 */
function capi_generate_event_id(){
    return bin2hex(random_bytes(16));
}

/**
 * Отправка события в Facebook Conversions API
 *
 * @param string $pixel_id   ID пикселя Facebook
 * @param string $token       Access Token для CAPI
 * @param string $event_name  Имя события (Lead, Purchase, ViewContent и т.д.)
 * @param array  $user_data   Данные пользователя для матчинга
 * @param array  $custom_data Данные события (value, currency и т.д.)
 * @param string $event_id    ID для дедупликации (опционально)
 * @param string $test_code   Код тестового события (опционально)
 * @return array              [success => bool, response => string]
 */
function send_fb_capi_event($pixel_id, $token, $event_name, $user_data=[], $custom_data=[], $event_id='', $test_code=''){
    if(empty($pixel_id) || empty($token)) return ['success'=>false,'response'=>'No pixel_id or token'];

    $url = 'https://graph.facebook.com/v21.0/'.$pixel_id.'/events';

    //Формируем user_data для матчинга
    $ud = [];
    if(!empty($user_data['phone'])){
        $ph = capi_normalize_phone($user_data['phone']);
        if($ph) $ud['ph'] = [capi_hash($ph)];
    }
    if(!empty($user_data['email'])) $ud['em'] = [capi_hash($user_data['email'])];
    if(!empty($user_data['name'])){
        $parts = explode(' ', $user_data['name'], 2);
        $ud['fn'] = [capi_hash($parts[0])];
        if(isset($parts[1])) $ud['ln'] = [capi_hash($parts[1])];
    }
    if(!empty($user_data['country'])) $ud['country'] = [capi_hash(strtolower($user_data['country']))];
    if(!empty($user_data['ip'])) $ud['client_ip_address'] = $user_data['ip'];
    if(!empty($user_data['ua'])) $ud['client_user_agent'] = $user_data['ua'];
    if(!empty($user_data['fbc'])) $ud['fbc'] = $user_data['fbc'];
    if(!empty($user_data['fbp'])) $ud['fbp'] = $user_data['fbp'];
    if(!empty($user_data['external_id'])) $ud['external_id'] = [capi_hash($user_data['external_id'])];

    //Формируем событие
    $event = [
        'event_name' => $event_name,
        'event_time' => time(),
        'action_source' => 'website',
        'user_data' => $ud,
    ];
    if(!empty($event_id)) $event['event_id'] = $event_id;
    if(!empty($user_data['event_source_url'])) $event['event_source_url'] = $user_data['event_source_url'];
    if(!empty($custom_data)) $event['custom_data'] = $custom_data;

    //Формируем запрос
    $payload = ['data' => [json_encode([$event])],'access_token' => $token];
    if(!empty($test_code)) $payload['test_event_code'] = $test_code;

    //Отправка через cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    //Логирование
    capi_log($event_name, $pixel_id, $http_code, $response, $error);

    return ['success' => ($http_code >= 200 && $http_code < 300), 'response' => $response];
}

/**
 * Отправка Lead события при конверсии (вызывается из send.php)
 */
function capi_send_lead($name, $phone, $subid){
    global $fb_capi_enabled, $fb_capi_token, $fb_capi_testcode, $fbpixel_subname, $fb_thankyou_event;

    if(!$fb_capi_enabled || empty($fb_capi_token)) return null;

    $pixel_id = isset($_COOKIE[$fbpixel_subname]) ? $_COOKIE[$fbpixel_subname] : '';
    if(empty($pixel_id)) $pixel_id = isset($_GET[$fbpixel_subname]) ? $_GET[$fbpixel_subname] : '';
    if(empty($pixel_id)) return null;

    $event_id = capi_generate_event_id();
    //Сохраняем event_id в куки для дедупликации с клиентским пикселем
    if(function_exists('ywbsetcookie')) ywbsetcookie('capi_event_id', $event_id, '/');

    $user_data = [
        'phone' => $phone,
        'name' => $name,
        'ip' => isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] :
               (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] :
               (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0] :
               $_SERVER['REMOTE_ADDR'])),
        'ua' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
        'fbc' => isset($_COOKIE['_fbc']) ? $_COOKIE['_fbc'] : (isset($_COOKIE['fbclid']) ? 'fb.1.'.time().'.'.$_COOKIE['fbclid'] : ''),
        'fbp' => isset($_COOKIE['_fbp']) ? $_COOKIE['_fbp'] : '',
        'external_id' => $subid,
        'event_source_url' => 'https://'.(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'').(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:''),
    ];

    $event_name = !empty($fb_thankyou_event) ? $fb_thankyou_event : 'Lead';

    return send_fb_capi_event($pixel_id, $fb_capi_token, $event_name, $user_data, [], $event_id, $fb_capi_testcode);
}

/**
 * Отправка Purchase события на постбэке (вызывается из postback.php)
 */
function capi_send_purchase($subid, $payout, $currency='USD'){
    global $fb_capi_enabled, $fb_capi_token, $fb_capi_testcode;

    if(!$fb_capi_enabled || empty($fb_capi_token)) return null;

    //Ищем лид по subid для получения данных пользователя
    $dataDir = __DIR__."/logs";
    $leadsStore = new \SleekDB\Store("leads", $dataDir);
    $lead = $leadsStore->findOneBy([["subid", "=", $subid]]);
    if($lead===null) return null;

    //Ищем клик по subid для IP/UA/country
    $bclicksStore = new \SleekDB\Store("blackclicks", $dataDir);
    $click = $bclicksStore->findOneBy([["subid", "=", $subid]]);

    $pixel_id = isset($lead['pixelid']) ? $lead['pixelid'] : '';
    if(empty($pixel_id)) return null;

    $user_data = [
        'phone' => isset($lead['phone']) ? $lead['phone'] : '',
        'name' => isset($lead['name']) ? $lead['name'] : '',
        'email' => isset($lead['email']) ? $lead['email'] : '',
        'external_id' => $subid,
        'fbc' => isset($lead['fbclid']) ? $lead['fbclid'] : '',
        'fbp' => isset($lead['fbp']) ? $lead['fbp'] : '',
    ];
    if($click!==null){
        $user_data['ip'] = isset($click['ip']) ? $click['ip'] : '';
        $user_data['ua'] = isset($click['ua']) ? $click['ua'] : '';
        $user_data['country'] = isset($click['country']) ? $click['country'] : '';
    }

    $custom_data = [];
    if(!empty($payout)){
        $custom_data['value'] = floatval($payout);
        $custom_data['currency'] = $currency;
    }

    return send_fb_capi_event($pixel_id, $fb_capi_token, 'Purchase', $user_data, $custom_data, '', $fb_capi_testcode);
}

/**
 * Логирование CAPI событий
 */
function capi_log($event, $pixel, $http_code, $response, $error=''){
    $log_dir = __DIR__."/pblogs";
    if(!file_exists($log_dir)) mkdir($log_dir);
    $file = $log_dir."/".date("d.m.y").".capi.log";
    $msg = date("Y-m-d H:i:s")." $event pixel=$pixel code=$http_code";
    if(!empty($error)) $msg .= " error=$error";
    $msg .= " response=".substr($response,0,200)."\n";
    file_put_contents($file, $msg, FILE_APPEND);
}
?>
