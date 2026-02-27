<?php
//Включение отладочной информации
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', 1);
//Конец включения отладочной информации
require_once __DIR__.'/../settings.php';
require_once 'password.php';
check_password();

$startdate=isset($_GET['startdate'])?DateTime::createFromFormat('d.m.y', $_GET['startdate']):new DateTime();
$enddate=isset($_GET['enddate'])?DateTime::createFromFormat('d.m.y', $_GET['enddate']):new DateTime();

$date_str='';
if (isset($_GET['startdate'])&& isset($_GET['enddate'])) {
    $startstr = $_GET['startdate'];
    $endstr = $_GET['enddate'];
    $date_str="&startdate={$startstr}&enddate={$endstr}";
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Binomo Cloaker by Yellow Web</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png" />
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet" />
    <!-- nalika Icon CSS
		============================================ -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/nalika-icon.css" />
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="css/main.css" />
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="css/metisMenu/metisMenu.min.css" />
    <link rel="stylesheet" href="css/metisMenu/metisMenu-vertical.css" />
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="left-sidebar-pro">
        <nav id="sidebar" class="">
            <div class="sidebar-header">
                <a href="/admin/index.php?password=<?=$_GET['password']?><?=$date_str!==''?$date_str:''?>"><img class="main-logo" src="img/logo/logo.png" alt="" /></a>
                <strong><img src="img/favicon.png" alt="" style="width:50px"/></strong>
            </div>
			<div class="nalika-profile">
				<div class="profile-dtl">
					<a href="https://t.me/yellow_web"><img src="img/notification/4.jpg" alt="" /></a>
                    <?php include "version.php" ?>
				</div>
			</div>
            <div class="left-custom-menu-adp-wrap comment-scrollbar">
                <nav class="sidebar-nav left-sidebar-menu-pro">
                  <ul class="metismenu" id="menu1">
                        <li class="active">

                            <a class="has-arrow" href="index.php?password=<?=$_GET['password']?><?=$date_str!==''?$date_str:''?>" aria-expanded="false"><i class="icon nalika-bar-chart icon-wrap"></i> <span class="mini-click-non">Traffic</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Стата" href="statistics.php?password=<?=$_GET['password']?><?=$date_str!==''?$date_str:''?>"><span class="mini-sub-pro">Statistics</span></a></li>
                                <li><a title="Разрешённый" href="index.php?password=<?=$_GET['password']?><?=$date_str!==''?$date_str:''?>"><span class="mini-sub-pro">Allowed</span></a></li>
                                <li><a title="Лиды" href="index.php?filter=leads&password=<?=$_GET['password']?><?=$date_str!==''?$date_str:''?>"><span class="mini-sub-pro">Leads</span></a></li>
                                <li><a title="Заблокированный" href="index.php?filter=blocked&password=<?=$_GET['password']?><?=$date_str!==''?$date_str:''?>"><span class="mini-sub-pro">Blocked</span></a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="editsettings.php?password=<?=$_GET['password']?><?=$date_str!==''?$date_str:''?>" aria-expanded="false"><i class="icon nalika-table icon-wrap"></i> <span class="mini-click-non">Settings</span></a>
                        </li>
                  </ul>
                </nav>
            </div>
        </nav>
    </div>
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                        <a href="index.html"><img class="main-logo" src="img/logo/logo.png" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-advance-area">
            <div class="header-top-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="header-top-wraper">
                                <div class="row">
                                    <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                        <div class="menu-switcher-pro">
                                            <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
													<i class="icon nalika-menu-task"></i>
												</button>
                                        </div>
                                    </div>

                                    <div class="col-lg-11 col-md-1 col-sm-12 col-xs-12">
                                        <div class="header-right-info">
                                            <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                                <li class="nav-item dropdown">
                             <li class="nav-item">
                            <a class="nav-link" href="" onClick="location.reload()">Refresh</a>
                            </li>
                                                </i>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <a name="top"></a>

    <form action="savesettings.php?password=<?=$log_password?>" method="post">
        <div class="basic-form-area mg-tb-15">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline12-list">
                            <div class="sparkline12-graph">
                                <div class="basic-login-form-ad">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="all-form-element-inner">
                                                <hr>
<h4>#1 Настройка вайта</h4>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Выберите метод: </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_action==='folder'?'checked':''?> value="folder" name="white.action" onclick="(document.getElementById('b_2').style.display='block'); (document.getElementById('b_3').style.display='none'); (document.getElementById('b_4').style.display='none'); (document.getElementById('b_5').style.display='none')"> Локальный вайт-пейдж из папки </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_action==='redirect'?'checked':''?> value="redirect" name="white.action" onclick="(document.getElementById('b_2').style.display='none'); (document.getElementById('b_3').style.display='block'); (document.getElementById('b_4').style.display='none'); (document.getElementById('b_5').style.display='none')"> Редирект </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_action==='curl'?'checked':''?> value="curl" name="white.action" onclick="(document.getElementById('b_2').style.display='none'); (document.getElementById('b_3').style.display='none'); (document.getElementById('b_4').style.display='block'); (document.getElementById('b_5').style.display='none')">  Подгрузка внешнего сайта через curl </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_action==='error'?'checked':''?> value="error" name="white.action" onclick="(document.getElementById('b_2').style.display='none'); (document.getElementById('b_3').style.display='none'); (document.getElementById('b_4').style.display='none'); (document.getElementById('b_5').style.display='block')">  Возврат HTTP-кода <small>(например, ошибки 404 или просто 200)</small> </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="b_2" style="display:<?=$white_action==='folder'?'block':'none'?>;">
    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <label class="login2 pull-left pull-left-pro">Папка, где лежит вайт: </label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="input-group custom-go-button">
                    <input type="text" class="form-control" placeholder="white" name="white.folder.names" value="<?=implode(',',$white_folder_names)?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="b_3" style="display:<?=$white_action==='redirect'?'block':'none'?>;">
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Адрес для редиректа: </label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="https://ya.ru" name="white.redirect.urls" value="<?=implode(',',$white_redirect_urls)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Выберите код редиректа: </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_redirect_type==='301'?'checked':''?> value="301" name="white.redirect.type"> 301 </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_redirect_type==='302'?'checked':''?> value="302" name="white.redirect.type"> 302 </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_redirect_type==='303'?'checked':''?> value="303" name="white.redirect.type">  303 </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_redirect_type==='307'?'checked':''?> value="307" name="white.redirect.type">  307 </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div id="b_4" style="display:<?=$white_action==='curl'?'block':'none'?>;">
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Адрес для подгрузки через curl: </label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="https://ya.ru" name="white.curl.urls" value="<?=implode(',',$white_curl_urls)?>">
            </div>
        </div>
    </div>
</div>
</div>

<div id="b_5" style="display:<?=$white_action==='error'?'block':'none'?>;">
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">HTTP-код для возврата вместо вайта: </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="404" name="white.error.codes" value="<?=implode(',',$white_error_codes)?>">
            </div>
        </div>
    </div>
</div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Показывать индивидуальный вайт под каждый домен? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_use_domain_specific===false?'checked':''?> value="false" name="white.domainfilter.use" onclick="(document.getElementById('b_6').style.display='none')"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$white_use_domain_specific===true?'checked':''?> value="true" name="white.domainfilter.use" onclick="(document.getElementById('b_6').style.display='block')"> Да, показывать </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="b_6" style="display:<?=$white_use_domain_specific===true?'block':'none'?>;">
<div id="white_domainspecific">
<?php for($j=0;$j<count($white_domain_specific);$j++){ ?>
<div class="form-group-inner white">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <label class="login2 pull-left pull-left-pro">Домен => Метод:Направление</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
             <div class="input-group">
                <input type="text" class="form-control" placeholder="xxx.yyy.com" value="<?=$white_domain_specific[$j]["name"]?>" name="white.domainfilter.domains[<?=$j?>][name]">
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
             <p>=></p>  
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="site:white" value="<?=$white_domain_specific[$j]["action"]?>" name="white.domainfilter.domains[<?=$j?>][action]">
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <a href="javascript:void(0)" class="remove-domain-item btn btn-sm btn-primary">Удалить</a>
        </div>
    </div>
</div>
<?php } ?>
</div>
<a id="add-domain-item" class="btn btn-sm btn-primary" href="javascript:;">Добавить</a>
</div>

<div class="form-group-inner">
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <label class="login2 pull-left pull-left-pro">Использовать JS проверку? 
            <small>
Если проверка по JS включена, то пользователь всегда попадает вначале на вайт, и только если проверки пройдены, тогда ему показывается блэк.
            </small> 
        </label>
    </div>
    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
        <div class="bt-df-checkbox pull-left">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="i-checks pull-left">
                        <label>
                                <input type="radio" <?=$use_js_checks===false?'checked="checked"':''?> value="false" name="white.jschecks.enabled" onclick="(document.getElementById('jscheckssettings').style.display = 'none')"> Нет, не использовать </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="i-checks pull-left">
                        <label>
                                <input type="radio" value="true" <?=$use_js_checks===true?'checked="checked"':''?> name="white.jschecks.enabled" onclick="(document.getElementById('jscheckssettings').style.display = 'block')">  Использовать </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div id="jscheckssettings" style="display:<?=$use_js_checks===true?'block':'none'?>;">
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Время теста в миллисекундах: </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="10000" name="white.jschecks.timeout" value="<?=$js_timeout?>">
            </div>
        </div>
    </div>
</div>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Что проверять? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="checkbox" name="white.jschecks.events[]" value="mousemove" <?=in_array('mousemove',$js_checks)?'checked':''?>> Движения мыши </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="checkbox" name="white.jschecks.events[]" value="keydown" <?=in_array('keydown',$js_checks)?'checked':''?>> Нажатия клавиш </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="checkbox" name="white.jschecks.events[]" value="scroll" <?=in_array('scroll',$js_checks)?'checked':''?>> Скроллинг </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="checkbox" name="white.jschecks.events[]" value="devicemotion" <?=in_array('devicemotion',$js_checks)?'checked':''?>> Датчик движения (только для Android)</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="checkbox" name="white.jschecks.events[]" value="deviceorientation" <?=in_array('deviceorientation',$js_checks)?'checked':''?>> Датчик ориентации в пространстве (только для Android)</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="checkbox" name="white.jschecks.events[]" value="audiocontext" <?=in_array('audiocontext',$js_checks)?'checked':''?>> Наличие аудиодвижка в браузере</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input id="tzcheck" type="checkbox" name="white.jschecks.events[]" value="timezone" <?=in_array('timezone',$js_checks)?'checked':''?> onchange="(document.getElementById('jscheckstz').style.display = this.checked?'block':'none')"> Часовой пояс </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="jscheckstz" class="form-group-inner" style="display:<?=in_array('timezone',$js_checks)?'block':'none'?>;">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Минимально допустимый часовой пояс</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="-3" name="white.jschecks.tzstart" value="<?=$js_tzstart?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Максимально допустимый часовой пояс</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="3" name="white.jschecks.tzend" value="<?=$js_tzend?>">
            </div>
        </div>
    </div>
</div>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Маскировать код JS-проверки? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" value="true" <?=$js_obfuscate===true?'checked="checked"':''?> name="white.jschecks.obfuscate">  Маскировать </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" value="false" <?=$js_obfuscate===false?'checked="checked"':''?> name="white.jschecks.obfuscate"> Нет, не маскировать </label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<br>
<hr>
<h4>#2 Настройка блэка</h4>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Выберите метод загрузки прокладок: </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_preland_action==='none'?'checked':''?> value="none" name="black.prelanding.action" onclick="(document.getElementById('b_8').style.display='none')"> Не использовать прелендинг </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_preland_action==='folder'?'checked':''?> value="folder" name="black.prelanding.action" onclick="(document.getElementById('b_8').style.display='block')"> Локальный прелендинг из папки </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="b_8" style="display:<?=$black_preland_action==='folder'?'block':'none'?>;">
    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <label class="login2 pull-left pull-left-pro">Папки, где лежат прелендинги </label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="input-group custom-go-button">
                    <input type="text" class="form-control" placeholder="p1,p2" name="black.prelanding.folders" value="<?=implode(',',$black_preland_folder_names)?>">
                </div>
            </div>
        </div>
    </div>

</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Выберите метод загрузки лендингов: </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_action==='folder'?'checked':''?> value="folder" name="black.landing.action" onclick="(document.getElementById('b_landings_redirect').style.display='none'); (document.getElementById('b_landings_folder').style.display='block')"> Локальный лендинг из папки </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_action==='redirect'?'checked':''?> value="redirect" name="black.landing.action" onclick="(document.getElementById('b_landings_redirect').style.display='block'); (document.getElementById('b_landings_folder').style.display='none')"> Редирект </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="b_landings_folder" style="display:<?=$black_land_action==='folder'?'block':'none'?>;">
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Папки, где лежат лендинги </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="l1,l2" name="black.landing.folder.names" value="<?=implode(',',$black_land_folder_names)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Использовать страницу Спасибо: </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_use_custom_thankyou_page===true?'checked':''?> value="true" name="black.landing.folder.customthankyoupage.use" onclick="(document.getElementById('ctpage').style.display = 'block'); (document.getElementById('pppage').style.display = 'none')"> Кастомную, на стороне кло </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_use_custom_thankyou_page===false?'checked':''?> value="false" name="black.landing.folder.customthankyoupage.use" onclick="(document.getElementById('ctpage').style.display = 'none'); (document.getElementById('pppage').style.display = 'block')"> Обычную, на стороне ПП </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="ctpage" class="form-group-inner" style="display:<?=$black_land_use_custom_thankyou_page===true?'block':'none'?>">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Язык, на котором показывать страницу Спасибо Кло: </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="EN" name="black.landing.folder.customthankyoupage.language" value="<?=$black_land_thankyou_page_language?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro"> Путь от корня лендинга до скрипта отправки данных с формы:</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="order.php" name="black.landing.folder.conversions.script" value="<?=$black_land_conversion_script?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Использовать допродажи на странице Спасибо: </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$thankyou_upsell===true?'checked':''?> value="true" name="black.landing.folder.customthankyoupage.upsell.use" onclick="document.getElementById('thankupsell').style.display = 'block'"> Да</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$thankyou_upsell===false?'checked':''?> value="false" name="black.landing.folder.customthankyoupage.upsell.use" onclick="document.getElementById('thankupsell').style.display = 'none'">Нет</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="thankupsell" class="form-group-inner" style="display:<?=$thankyou_upsell===true?'block':'none'?>">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Заголовок апсейла:</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="This is a header" name="black.landing.folder.customthankyoupage.upsell.header" value="<?=$thankyou_upsell_header?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Текст апсейла:</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="This is a text" name="black.landing.folder.customthankyoupage.upsell.text" value="<?=$thankyou_upsell_text?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Полный адрес ленда апсейла:</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="https://ya.ru" name="black.landing.folder.customthankyoupage.upsell.url" value="<?=$thankyou_upsell_url?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Имя папки с картинками для витрины <small>папка должна быть создана в thankyou/upsell</small></label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="img" name="black.landing.folder.customthankyoupage.upsell.imgdir" value="<?=$thankyou_upsell_imgdir?>">
            </div>
        </div>
    </div>
</div>
<div id="pppage" class="form-group-inner" style="display:<?=$black_land_use_custom_thankyou_page===false?'block':'none'?>">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Добавить в обработчик кнопки Заказать на ленде подсчёт конверсий кло? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_log_conversions_on_button_click===false?'checked':''?> value="false" name="black.landing.folder.conversions.logonbuttonclick"> Нет <small>(конверсия будет считаться на КАСТОМНОЙ стр.Спасибо)</small> </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_log_conversions_on_button_click===true?'checked':''?> value="true" name="black.landing.folder.conversions.logonbuttonclick"> Да </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Откуда отстукивать в Facebook конверсию? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$fb_add_button_pixel===false?'checked':''?> value="false" name="pixels.fb.conversion.fireonbutton"> Со страницы спасибо <small>(если не используете кастомную Спасибо, впишите код пикселя!)</small></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$fb_add_button_pixel===true?'checked':''?> value="true" name="pixels.fb.conversion.fireonbutton"> С кнопки на ленде </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Откуда отстукивать в TikTok конверсию? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$tt_add_button_pixel===false?'checked':''?> value="false" name="pixels.tt.conversion.fireonbutton"> Со страницы спасибо <small>(если не используете кастомную Спасибо, впишите код пикселя!)</small></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$tt_add_button_pixel===true?'checked':''?> value="true" name="pixels.tt.conversion.fireonbutton"> С кнопки на ленде </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div id="b_landings_redirect" style="display:<?=$black_land_action==='redirect'?'block':'none'?>;">
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Адреса для редиректа: <small>(Можно НЕСКОЛЬКО через запятую)</small> </label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="https://ya.ru,https://google.com" name="black.landing.redirect.urls" value="<?=implode(',',$black_land_redirect_urls)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Выберите код редиректа: </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_redirect_type==='301'?'checked':''?> value="301" name="black.landing.redirect.type"> 301 </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_redirect_type==='302'?'checked':''?> value="302" name="black.landing.redirect.type"> 302 </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_redirect_type==='303'?'checked':''?> value="303" name="black.landing.redirect.type">  303 </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_land_redirect_type==='307'?'checked':''?> value="307" name="black.landing.redirect.type">  307 </label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Действие при подключении кло через Javascript (для конструкторов) <small>Если в качестве блэка выбран редирект, то и с конструктора ВСЕГДА будет редирект. Если же блэк локальный, то возможны только: подмена, iframe</small> </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_jsconnect_action==='redirect'?'checked':''?> value="redirect" name="black.jsconnect"> Редирект </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_jsconnect_action==='replace'?'checked':''?> value="replace" name="black.jsconnect"> Подмена </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$black_jsconnect_action==='iframe'?'checked':''?> value="iframe" name="black.jsconnect"> IFrame </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<hr>
<h4>#3 Настройка метрик и пикселей</h4>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Идентификатор Google Tag Manager: </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder=" " name="pixels.gtm.id" value="<?=$gtm_id?>">
            </div>
        </div>
    </div>
</div>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Идентификатор Яндекс.Метрики: </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="" name="pixels.ya.id" value="<?=$ya_id?>">
            </div>
        </div>
    </div>
</div>

<h5>#3.1 Настройка пикселя Facebook</h5>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Имя параметра в котором лежит ID пикселя Facebook: </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="px" name="pixels.fb.subname" value="<?=$fbpixel_subname?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Добавлять ли на проклы-ленды событие PageView? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$fb_use_pageview===false?'checked':''?> value="false" name="pixels.fb.pageview"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$fb_use_pageview===true?'checked':''?> value="true" name="pixels.fb.pageview"> Да, добавлять </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Добавлять событие ViewContent после просмотра страницы в течении указанного ниже времени? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$fb_use_viewcontent===false?'checked':''?> value="false" name="pixels.fb.viewcontent.use" onclick="(document.getElementById('b_8-2').style.display='none')"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$fb_use_viewcontent===true?'checked':''?> value="true" name="pixels.fb.viewcontent.use" onclick="(document.getElementById('b_8-2').style.display='block')"> Да, добавлять </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="b_8-2" style="display:<?=$fb_use_viewcontent===true?'block':'none'?>;">
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Время в сек после которго отправляется ViewContent:<br><small>если 0, то событие не будет вызвано</small> </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="30" name="pixels.fb.viewcontent.time" value="<?=$fb_view_content_time?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Процент проскролливания страницы, до вызова события ViewContent:<br><small>если 0, то событие не будет вызвано</small> </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="75" name="pixels.fb.viewcontent.percent" value="<?=$fb_view_content_percent?>">
            </div>
        </div>
    </div>
</div>
</div>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Какое событие будем использовать для конверсии в Facebook? <small>Например: Lead или Purchase</small></label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="Lead" name="pixels.fb.conversion.event" value="<?=$fb_thankyou_event?>">
            </div>
        </div>
    </div>
</div>

<h5>#3.1.1 Facebook Conversions API (серверная отправка)</h5>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Использовать Facebook Conversions API (CAPI)?</label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$fb_capi_enabled===false?'checked':''?> value="false" name="pixels.fb.capi.enabled" onclick="(document.getElementById('capi_settings').style.display='none')"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$fb_capi_enabled===true?'checked':''?> value="true" name="pixels.fb.capi.enabled" onclick="(document.getElementById('capi_settings').style.display='block')"> Да </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="capi_settings" style="display:<?=$fb_capi_enabled===true?'block':'none'?>">
    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <label class="login2 pull-left pull-left-pro">Facebook Conversions API Access Token <small>Получить в Events Manager → Settings → Conversions API</small></label>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="input-group custom-go-button">
                    <input type="text" class="form-control" placeholder="EAAxxxxxxxxxxxx" name="pixels.fb.capi.accesstoken" value="<?=$fb_capi_token?>">
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <label class="login2 pull-left pull-left-pro">Test Event Code (опционально) <small>Для тестирования в Events Manager → Test Events</small></label>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="input-group custom-go-button">
                    <input type="text" class="form-control" placeholder="TEST12345" name="pixels.fb.capi.testcode" value="<?=$fb_capi_testcode?>">
                </div>
            </div>
        </div>
    </div>
</div>

<h5>#3.2 Настройка пикселя TikTok</h5>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Имя параметра в котором лежит ID пикселя TikTok: </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="tpx" name="pixels.tt.subname" value="<?=$ttpixel_subname?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Добавлять ли на проклы-ленды событие PageView? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$tt_use_pageview===false?'checked':''?> value="false" name="pixels.tt.pageview"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$tt_use_pageview===true?'checked':''?> value="true" name="pixels.tt.pageview"> Да, добавлять </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
