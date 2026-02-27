<?php
require 'bases/browser/DetectorInterface.php';
require 'bases/browser/UserAgent.php';
require 'bases/browser/Os.php';
require 'bases/browser/OsDetector.php';
require 'bases/browser/AcceptLanguage.php';
require 'bases/browser/Language.php';
require 'bases/browser/LanguageDetector.php';
require 'bases/iputils.php';
require 'bases/ipcountry.php';
use Sinergi\BrowserDetector\Os;
use Sinergi\BrowserDetector\Language;

class Cloaker{
	var $os_white;
	var $country_white;
	var $lang_white;
	var $tokens_black;
	var $url_should_contain;
	var $ua_black;
	var $ip_black_filename;
	var $ip_black_cidr;
	var $block_without_referer;
	var $referer_stopwords;
    var $block_vpnandtor;
    var $isp_black;
    var $block_spyservices;
    var $block_datacenter;
    var $vpn_fallback;
    var $proxycheck_key;
    var $ipqs_key;
    var $botd_enabled;
    var $botd_timeout;
    var $detect=[];
    var $result=[];

    //Паттерны шпионских сервисов (UA подстроки)
    private $spy_ua_patterns = [
        'AdSpy','adspy',
        'AdPlexity','adplexity',
        'Anstrex','anstrex',
        'BigSpy','bigspy',
        'PiPiADS','pipiads',
        'SpyPush','spypush',
        'AdHeart','adheart',
        'Adbeat','adbeat',
        'WhatRunsWhere','whatrunswhere',
        'PowerAdSpy','poweradspy',
        'Dropispy','dropispy',
        'SocialAdScout','socialadscout',
        'AdSector','adsector',
        'SemrushBot','semrush',
        'AhrefsBot','ahrefs',
        'DotBot','dotbot',
        'MJ12bot','mj12bot',
        'SimilarWeb','similarweb',
        'SEOkicks','seokicks',
        'BLEXBot','blexbot',
        'MegaIndex','megaindex',
        'SerpstatBot','serpstatbot',
        'DataForSeoBot','dataforseo',
        'Bytespider','bytespider',
        'PetalBot','petalbot',
        'GPTBot','gptbot',
        'CCBot','ccbot',
        'ClaudeBot','claudebot',
        'anthropic-ai',
        'PerplexityBot','perplexitybot',
        'HeadlessChrome',
        'PhantomJS','phantomjs',
        'Puppeteer','puppeteer',
        'Playwright','playwright',
        'Selenium','selenium',
        'webdriver',
    ];

    //Паттерны шпионских сервисов (домены в реферере)
    private $spy_referer_domains = [
        'adspy.com',
        'adplexity.com',
        'anstrex.com',
        'bigspy.com',
        'pipiads.com',
        'spypush.com',
        'adheart.me',
        'adbeat.com',
        'whatrunswhere.com',
        'dropispy.com',
        'poweradspy.com',
        'socialadscout.com',
        'adsector.com',
        'semrush.com',
        'ahrefs.com',
        'similarweb.com',
        'moz.com',
        'majestic.com',
        'seokicks.de',
        'serpstat.com',
        'dataforseo.com',
        'spyfu.com',
        'nativeadsbuzz.com',
        'admobispy.com',
        'magicadz.co',
        'idvert.com',
    ];

	public function __construct($os_white,$country_white,$lang_white,$ip_black_filename,$ip_black_cidr,$tokens_black,$url_should_contain,$ua_black,$isp_black,$block_without_referer,$referer_stopwords,$block_vpnandtor,$block_spyservices=true,$block_datacenter=true,$vpn_fallback=false,$proxycheck_key='',$ipqs_key='',$botd_enabled=false,$botd_timeout=300){
		$this->os_white = $os_white;
		$this->country_white = $country_white;
		$this->lang_white=$lang_white;
		$this->ip_black_filename = $ip_black_filename;
        $this->ip_black_cidr = $ip_black_cidr;
		$this->tokens_black = $tokens_black;
		$this->url_should_contain= $url_should_contain;
		$this->ua_black = $ua_black;
		$this->isp_black = $isp_black;
		$this->block_without_referer = $block_without_referer;
		$this->referer_stopwords = $referer_stopwords;
		$this->block_vpnandtor = $block_vpnandtor;
		$this->block_spyservices = $block_spyservices;
		$this->block_datacenter = $block_datacenter;
		$this->vpn_fallback = $vpn_fallback;
		$this->proxycheck_key = $proxycheck_key;
		$this->ipqs_key = $ipqs_key;
		$this->botd_enabled = $botd_enabled;
		$this->botd_timeout = $botd_timeout;
		$this->detect();
	}

	public function detect(){
		$a['os']='Unknown';
		$a['country']='Unknown';
		$a['language']='Unknown';
		if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
			$a['referer']=$_SERVER['HTTP_REFERER'];
		}
		else if (isset($_COOKIE['referer']) && !empty($_COOKIE['referer']))
        {
			$a['referer']=$_COOKIE['referer'];
        }
		else{
			$a['referer']='';
		}

		$lang=new Language();
		$a['lang']=$lang->getLanguage();
		$os = new Os();
	    $a['os']=$os->getName();
		$a['ip'] = getip();
		$a['ua']=isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'Not Found!';
		$a['country'] = getcountry($a['ip']);
		$a['isp'] = getisp($a['ip']);
		$this->detect=$a;
	}

	//Основной API blackbox.ipinfo.app
	private function blackbox($ip){
        $url = 'https://blackbox.ipinfo.app/lookup/';
        $ctx = stream_context_create(['http'=>['timeout'=>5]]);
        $res = @file_get_contents($url . $ip, false, $ctx);
        $headers = function_exists('http_get_last_response_headers') ? http_get_last_response_headers() : (isset($http_response_header)?$http_response_header:[]);

        if(!is_string($res) || empty($headers) || !strpos($headers[0], "200")){
			return null; //API недоступен - возвращаем null вместо false
        }

        if($res !== null && $res === 'Y'){
            return true;
        }

        return false;
    }

    //Фоллбэк: ProxyCheck.io
    private function proxycheck($ip){
        if(empty($this->proxycheck_key)) return null;
        $url = 'http://proxycheck.io/v2/'.$ip.'?key='.$this->proxycheck_key.'&vpn=1&risk=1';
        $ctx = stream_context_create(['http'=>['timeout'=>5]]);
        $res = @file_get_contents($url, false, $ctx);
        if(!is_string($res)) return null;
        $data = @json_decode($res, true);
        if(!is_array($data) || !isset($data[$ip])) return null;
        $info = $data[$ip];
        if(isset($info['proxy']) && $info['proxy']==='yes') return true;
        if(isset($info['type']) && in_array(strtolower($info['type']),['vpn','tor','socks','inference engine','hosting'])) return true;
        return false;
    }

    //Фоллбэк: IPQualityScore
    private function ipqs($ip){
        if(empty($this->ipqs_key)) return null;
        $url = 'https://ipqualityscore.com/api/json/ip/'.$this->ipqs_key.'/'.$ip.'?strictness=1&allow_public_access_points=true';
        $ctx = stream_context_create(['http'=>['timeout'=>5]]);
        $res = @file_get_contents($url, false, $ctx);
        if(!is_string($res)) return null;
        $data = @json_decode($res, true);
        if(!is_array($data) || !isset($data['success']) || $data['success']!==true) return null;
        if(!empty($data['vpn']) || !empty($data['tor']) || !empty($data['proxy']) || !empty($data['is_crawler'])) return true;
        if(isset($data['fraud_score']) && $data['fraud_score']>=85) return true;
        return false;
    }

    //Проверка VPN/Tor с фоллбэками
    private function check_vpn($ip){
        //Сначала blackbox
        $result = $this->blackbox($ip);
        if($result===true) return true;
        if($result===false) return false;
        //blackbox недоступен - пробуем фоллбэки
        if(!$this->vpn_fallback) return false;
        //ProxyCheck.io
        $result = $this->proxycheck($ip);
        if($result===true) return true;
        if($result===false) return false;
        //IPQualityScore
        $result = $this->ipqs($ip);
        if($result===true) return true;
        return false;
    }

	public function check(){
		$result=0;

		$current_ip=$this->detect['ip'];
		$cidr = file(__DIR__."/bases/bots.txt", FILE_IGNORE_NEW_LINES);
		$checked=IpUtils::checkIp($current_ip, $cidr);

		if ($checked===true){
            $result=1;
			$this->result[]='ipbase';
        }

		if(!$checked &&
		   !empty($this->ip_black_filename) &&
		   file_exists(__DIR__."/bases/".$this->ip_black_filename)===true)
		{
			$ip_black_checker=false;
			$custom_base_path=__DIR__."/bases/".$this->ip_black_filename;
			if ($this->ip_black_cidr){
                $cbf = file($custom_base_path, FILE_IGNORE_NEW_LINES);
                $ip_black_checker=IpUtils::checkIp($current_ip, $cbf);
            }
			else{
                if(strpos(file_get_contents($custom_base_path),$current_ip) !== false) {
                    $ip_black_checker=true;
                }
            }

			if($ip_black_checker===true){
				$result=1;
				$this->result[]='ipblack';
			}
		}

		//Проверка IP по базе датацентров
		if($this->block_datacenter){
			$dc_file = __DIR__."/bases/datacenter.txt";
			if(file_exists($dc_file)){
				$dc_cidr = file($dc_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				if(!empty($dc_cidr) && IpUtils::checkIp($current_ip, $dc_cidr)===true){
					$result=1;
					$this->result[]='datacenter';
				}
			}
		}

		if ($this->block_vpnandtor){
            if ($this->check_vpn($current_ip)===true){
				$result=1;
				$this->result[]='vnp&tor';
            }
        }

		//Проверка шпионских сервисов (UA + реферер)
		if($this->block_spyservices){
			$ua=$this->detect['ua'];
			foreach($this->spy_ua_patterns as $spy_ua){
				if(stripos($ua,$spy_ua)!==false){
					$result=1;
					$this->result[]='spy:'.$spy_ua;
					break;
				}
			}
			$ref=$this->detect['referer'];
			if(!empty($ref)){
				foreach($this->spy_referer_domains as $spy_ref){
					if(stripos($ref,$spy_ref)!==false){
						$result=1;
						$this->result[]='spyref:'.$spy_ref;
						break;
					}
				}
			}
		}

		if($this->ua_black!=[])
		{
			$ua=$this->detect['ua'];
			foreach($this->ua_black as $ua_black_single){
				if(!empty(stristr($ua,$ua_black_single))){
					$result=1;
					$this->result[]='ua';
				}
			}
		}

		$os_white_checker = in_array($this->detect['os'],$this->os_white);
		if(!empty($this->os_white) && $os_white_checker===false){
			$result=1;
			$this->result[]='os';
		}

		$country_white_checker = in_array($this->detect['country'],$this->country_white);
		if($this->country_white!=[] &&
			in_array('WW',$this->country_white)===false &&
			$country_white_checker===false){
			$result=1;
			$this->result[]='country';
		}

		$lang_white_checker = in_array($this->detect['lang'],$this->lang_white);
		if($this->lang_white!==[] &&
			in_array('any',$this->lang_white)===false &&
			$lang_white_checker===false){
			$result=1;
			$buf=strtoupper($this->detect['lang']);
			$this->result[]='language:'.$buf;
		}

		if($this->block_without_referer===true &&$this->detect['referer']===''){
			$result=1;
			$this->result[]='referer';
		}

		if($this->referer_stopwords!==[] &&$this->detect['referer']!==''){
			foreach($this->referer_stopwords AS $stop){
				if ($stop==='')continue;
				if (stripos($this->detect['referer'],$stop)!==false){
					$result=1;
					$this->result[]='refstop:'.$stop;
					break;
				}
			}
		}

		if($this->tokens_black!==[]){
			foreach($this->tokens_black AS $token){
				if ($token==='')continue;
				if (strpos($_SERVER['REQUEST_URI'],$token)!==false){
					$result=1;
					$this->result[]='token:'.$token;
					break;
				}
			}
		}

		if($this->url_should_contain!==[]){
			foreach($this->url_should_contain AS $should){
				if ($should==='') continue;
				if (strpos($_SERVER['REQUEST_URI'],$should)===false){
					$result=1;
					$this->result[]='url:'.$should;
					break;
				}
			}
		}

		if(!empty($this->isp_black))
		{
			$isp=$this->detect['isp'];
			foreach($this->isp_black as $isp_black_single){
				if(!empty(stristr($isp,$isp_black_single))){
					$result=1;
					$this->result[]='isp';
				}
			}
		}

		//Проверка BotD (Bot Detection)
		if($this->botd_enabled && session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['botd_result'])){
			$botd = $_SESSION['botd_result'];
			//Проверяем, что результат не старше настроенного таймаута
			if(isset($botd['timestamp']) && (time() - $botd['timestamp']) < $this->botd_timeout){
				if(isset($botd['bot']) && $botd['bot'] === 1){
					$result=1;
					$botKind = isset($botd['botKind']) ? $botd['botKind'] : 'unknown';
					$this->result[]='botd:'.$botKind;
				}
			}
		}

		return $result;
	}

}
?>
