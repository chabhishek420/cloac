<?php
//Включение отладочной информации
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', 1);
//Конец включения отладочной информации
require_once __DIR__.'/../settings.php';
require_once 'password.php';
check_password();

$date_str='';
if (isset($_GET['startdate'])&& isset($_GET['enddate'])) {
    $startstr = $_GET['startdate'];
    $endstr = $_GET['enddate'];
    $date_str="&startdate={$startstr}&enddate={$endstr}";
}

// Get active tab from URL or default to 'traffic'
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'traffic';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>YellowCloaker Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/nalika-icon.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/metisMenu/metisMenu.min.css" />
    <link rel="stylesheet" href="css/metisMenu/metisMenu-vertical.css" />
    <link rel="stylesheet" href="css/style.css" />
    <style>
        .nav-tabs { border-bottom: 2px solid #dee2e6; margin-bottom: 20px; }
        .nav-tabs .nav-link { border: none; color: #6c757d; padding: 12px 24px; }
        .nav-tabs .nav-link:hover { border: none; color: #495057; background-color: #f8f9fa; }
        .nav-tabs .nav-link.active { color: #007bff; border-bottom: 3px solid #007bff; background-color: transparent; }
        .settings-section { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group-inner { margin-bottom: 25px; }
        .section-header { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #333; border-bottom: 1px solid #e9ecef; padding-bottom: 10px; }
        .save-button-fixed { position: fixed; bottom: 30px; right: 30px; z-index: 1000; }
        .save-button-fixed button { padding: 12px 30px; font-size: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <div class="left-sidebar-pro">
        <nav id="sidebar">
            <div class="sidebar-header">
                <a href="/admin/settings_new.php?password=<?=$_GET['password']?><?=$date_str?>">
                    <img class="main-logo" src="img/logo/logo.png" alt="" />
                </a>
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
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="icon nalika-bar-chart icon-wrap"></i>
                                <span class="mini-click-non">Traffic</span>
                            </a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a href="statistics.php?password=<?=$_GET['password']?><?=$date_str?>"><span class="mini-sub-pro">Statistics</span></a></li>
                                <li><a href="index.php?password=<?=$_GET['password']?><?=$date_str?>"><span class="mini-sub-pro">Allowed</span></a></li>
                                <li><a href="index.php?filter=leads&password=<?=$_GET['password']?><?=$date_str?>"><span class="mini-sub-pro">Leads</span></a></li>
                                <li><a href="index.php?filter=blocked&password=<?=$_GET['password']?><?=$date_str?>"><span class="mini-sub-pro">Blocked</span></a></li>
                            </ul>
                        </li>
                        <li class="active">
                            <a href="settings_new.php?password=<?=$_GET['password']?><?=$date_str?>" aria-expanded="false">
                                <i class="icon nalika-table icon-wrap"></i>
                                <span class="mini-click-non">Settings</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
    </div>

    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-pro">
                        <a href="settings_new.php?password=<?=$_GET['password']?><?=$date_str?>">
                            <img class="main-logo" src="img/logo/logo.png" alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-advance-area">
            <div class="header-top-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="header-top-wraper">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <div class="menu-switcher-pro">
                                            <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                <i class="icon nalika-menu-task"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-11">
                                        <div class="header-right-info">
                                            <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="editsettings.php?password=<?=$_GET['password']?><?=$date_str?>">Old Settings</a>
                                                </li>
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

        <div class="container-fluid" style="padding: 20px;">
            <form method="POST" action="savesettings.php?password=<?=$_GET['password']?><?=$date_str?>">

                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?=$active_tab=='traffic'?'active':''?>" href="?password=<?=$_GET['password']?><?=$date_str?>&tab=traffic">
                            Traffic Routing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?=$active_tab=='filters'?'active':''?>" href="?password=<?=$_GET['password']?><?=$date_str?>&tab=filters">
                            Filters & Detection
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?=$active_tab=='pixels'?'active':''?>" href="?password=<?=$_GET['password']?><?=$date_str?>&tab=pixels">
                            Pixels & Tracking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?=$active_tab=='scripts'?'active':''?>" href="?password=<?=$_GET['password']?><?=$date_str?>&tab=scripts">
                            Scripts & Features
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?=$active_tab=='advanced'?'active':''?>" href="?password=<?=$_GET['password']?><?=$date_str?>&tab=advanced">
                            Advanced
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <?php if ($active_tab == 'traffic'): ?>
                        <?php include 'settings_tabs/traffic.php'; ?>
                    <?php elseif ($active_tab == 'filters'): ?>
                        <?php include 'settings_tabs/filters.php'; ?>
                    <?php elseif ($active_tab == 'pixels'): ?>
                        <?php include 'settings_tabs/pixels.php'; ?>
                    <?php elseif ($active_tab == 'scripts'): ?>
                        <?php include 'settings_tabs/scripts.php'; ?>
                    <?php elseif ($active_tab == 'advanced'): ?>
                        <?php include 'settings_tabs/advanced.php'; ?>
                    <?php endif; ?>
                </div>

                <!-- Fixed Save Button -->
                <div class="save-button-fixed">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="icon nalika-check"></i> Save Settings
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/jquery.meanmenu.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/metisMenu/metisMenu.min.js"></script>
    <script src="js/metisMenu/metisMenu-active.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
