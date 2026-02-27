<?php
require_once __DIR__ . "/db/Exceptions/IOException.php";
require_once __DIR__ . "/db/Exceptions/JsonException.php";
require_once __DIR__ . "/db/Classes/IoHelper.php";
require_once __DIR__ . "/db/SleekDB.php";
require_once __DIR__ . "/db/Store.php";
require_once __DIR__ . "/db/QueryBuilder.php";
require_once __DIR__ . "/db/Query.php";
require_once __DIR__ . "/db/Cache.php";
require_once __DIR__ . "/cookies.php";

use SleekDB\Store;

function add_white_click($data, $reason)
{
    $dataDir = __DIR__ . "/logs";
    $wclicksStore = new Store("whiteclicks", $dataDir);

    $calledIp = $data['ip'];
    $country = $data['country'];
    $dt = new DateTime();
    $time = $dt->getTimestamp();
    $os = $data['os'];
    $isp = str_replace(',', ' ', $data['isp']);
    $user_agent = str_replace(',', ' ', $data['ua']);

    parse_str($_SERVER['QUERY_STRING'], $queryarr);

    $click = [
        "time" => $time,
        "ip" => $calledIp,
        "country" => $country,
        "os" => $os,
        "isp" => $isp,
        "ua" => $user_agent,
        "reason" => $reason,
        "subs" => $queryarr
    ];
    $wclicksStore->insert($click);
}

function add_black_click($subid, $data, $preland, $land)
{
    $dataDir = __DIR__ . "/logs";
    $bclicksStore = new Store("blackclicks", $dataDir);

    $calledIp = $data['ip'];
    $country = $data['country'];
    $dt = new DateTime();
    $time = $dt->getTimestamp();
    $os = $data['os'];
    $isp = str_replace(',', ' ', $data['isp']);
    $user_agent = str_replace(',', ' ', $data['ua']);
    $prelanding = empty($preland) ? 'unknown' : $preland;
    $landing = empty($land) ? 'unknown' : $land;

    parse_str($_SERVER['QUERY_STRING'], $queryarr);

    $click = [
        "subid" => $subid,
        "time" => $time,
        "ip" => $calledIp,
        "country" => $country,
        "os" => $os,
        "isp" => $isp,
        "ua" => $user_agent,
        "subs" => $queryarr,
        "preland" => $prelanding,
        "land" => $landing
    ];
    $bclicksStore->insert($click);

    // Update campaign stats if campaign is active
    update_campaign_click_stats();
}

function add_lead($subid, $name, $phone, $status = 'Lead')
{
    global $fbpixel_subname, $ttpixel_subname;
    $dataDir = __DIR__ . "/logs";
    $leadsStore = new Store("leads", $dataDir);

    $fbp = get_cookie('_fbp');
    $fbclid = get_cookie('fbclid');
    if ($fbclid === '') $fbclid = get_cookie('_fbc');

    $pixelid = '';
    if (!empty($fbpixel_subname)) $pixelid = get_cookie($fbpixel_subname);

    // TikTok tracking data
    $ttp = get_cookie('_ttp');
    $ttclid = get_cookie('ttclid');
    $ttpixelid = '';
    if (!empty($ttpixel_subname)) $ttpixelid = get_cookie($ttpixel_subname);

    // Google Ads tracking data
    $gclid = get_cookie('gclid');

    if ($status == '') $status = 'Lead';

    $dt = new DateTime();
    $time = $dt->getTimestamp();

    $land = get_cookie('landing');
    if (empty($land)) $land = 'unknown';
    $preland = get_cookie('prelanding');
    if (empty($preland)) $preland = 'unknown';

    $lead = [
        "subid" => $subid,
        "time" => $time,
        "name" => $name,
        "phone" => $phone,
        "status" => $status,
        "fbp" => $fbp,
        "fbclid" => $fbclid,
        "pixelid" => $pixelid,
        "ttp" => $ttp,
        "ttclid" => $ttclid,
        "ttpixelid" => $ttpixelid,
        "gclid" => $gclid,
        "preland" => $preland,
        "land" => $land
    ];

    $result = $leadsStore->insert($lead);

    // Update campaign conversion stats
    update_campaign_conversion_stats(0);

    return $result;
}

function update_lead($subid, $status, $payout)
{
    $dataDir = __DIR__ . "/logs";
    $leadsStore = new Store("leads", $dataDir);
    $lead = $leadsStore->findOneBy([["subid", "=", $subid]]);
    if ($lead === null) {
        $bclicksStore = new Store("blackclicks", $dataDir);
        $click = $bclicksStore->findOneBy([["subid", "=", $subid]]);
        if ($click === null) return false;
        $lead = add_lead($subid, '', '');
    }

    $lead["status"] = $status;
    $lead["payout"] = $payout;
    $leadsStore->update($lead);
    return true;
}

function email_exists_for_subid($subid)
{
    $dataDir = __DIR__ . "/logs";
    $leadsStore = new Store("leads", $dataDir);
    $lead = $leadsStore->findOneBy([["subid", "=", $subid]]);
    if ($lead === null) return false;
    if (array_key_exists("email", $lead)) return true;
    return false;
}

function add_email($subid, $email)
{
    $dataDir = __DIR__ . "/logs";
    $leadsStore = new Store("leads", $dataDir);
    $lead = $leadsStore->findOneBy([["subid", "=", $subid]]);
    if ($lead === null) return;
    $lead["email"] = $email;
    $leadsStore->update($lead);
}

function add_lpctr($subid, $preland)
{
    $dataDir = __DIR__ . "/logs";
    $lpctrStore = new Store("lpctr", $dataDir);
    $dt = new DateTime();
    $time = $dt->getTimestamp();

    $lpctr = [
        "time" => $time,
        "subid" => $subid,
        "preland" => $preland
    ];
    $lpctrStore->insert($lpctr);
}

//проверяем, есть ли в файле лидов subid текущего пользователя
//если есть, и также есть такой же номер - значит ЭТО ДУБЛЬ!
//И нам не нужно слать его в ПП и не нужно показывать пиксель ФБ!!
function lead_is_duplicate($subid, $phone)
{
    $dataDir = __DIR__ . "/logs";
    $leadsStore = new Store("leads", $dataDir);
    if ($subid != '') {
        $lead = $leadsStore->findOneBy([["subid", "=", $subid]]);
        if ($lead === null) return false;
        header("YWBDuplicate: We have this sub!");
        $phoneexists = ($lead["phone"] === $phone);
        if ($phoneexists) {
            header("YWBDuplicate: We have this phone!");
            return true;
        } else {
            return false;
        }
    } else {
        //если куки c subid у нас почему-то нет, то проверяем по номеру телефона
        $lead = $leadsStore->findOneBy([["phone", "=", $phone]]);
        if ($lead === null) return false;
        return true;
    }
}



/**
 * Get active campaign ID from settings.json
 */
function get_active_campaign_id() {
    $settingsFile = __DIR__ . "/settings.json";
    if (!file_exists($settingsFile)) {
        return null;
    }

    $settings = json_decode(file_get_contents($settingsFile), true);
    return $settings['active_campaign_id'] ?? null;
}

/**
 * Update campaign click stats
 */
function update_campaign_click_stats() {
    $campaignId = get_active_campaign_id();
    if (!$campaignId) {
        return;
    }

    // Direct SleekDB update to avoid circular dependency
    try {
        $dataDir = __DIR__ . "/logs";
        $campaignsStore = new Store('campaigns', $dataDir);
        $campaign = $campaignsStore->findById($campaignId);

        if ($campaign) {
            $campaign['stats']['clicks'] = ($campaign['stats']['clicks'] ?? 0) + 1;
            $campaign['updated_at'] = time();
            $campaignsStore->updateById($campaignId, $campaign);
        }
    } catch (Exception $e) {
        // Silently fail - don't break traffic flow if campaign tracking fails
    }
}

/**
 * Update campaign conversion stats
 */
function update_campaign_conversion_stats($revenue = 0) {
    $campaignId = get_active_campaign_id();
    if (!$campaignId) {
        return;
    }

    // Direct SleekDB update to avoid circular dependency
    try {
        $dataDir = __DIR__ . "/logs";
        $campaignsStore = new Store('campaigns', $dataDir);
        $campaign = $campaignsStore->findById($campaignId);

        if ($campaign) {
            $campaign['stats']['conversions'] = ($campaign['stats']['conversions'] ?? 0) + 1;
            $campaign['stats']['revenue'] = ($campaign['stats']['revenue'] ?? 0) + $revenue;
            $campaign['updated_at'] = time();
            $campaignsStore->updateById($campaignId, $campaign);
        }
    } catch (Exception $e) {
        // Silently fail - don't break traffic flow if campaign tracking fails
    }
}
