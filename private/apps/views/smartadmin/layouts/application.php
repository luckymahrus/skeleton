<?php defined('BASEPATH') OR exit('No direct script access allowed'); include (__DIR__.'/walkernav.php'); ?><!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title><?=@$page_title?><?=@$page_title_separator?><?=@$site_apps?></title>
        <meta name="description" content="">
        <meta name="author" content="">
            
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url('themes/smartadmin/css/bootstrap.min.css')?>">
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url('themes/smartadmin/css/font-awesome.min.css')?>">

        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url('themes/smartadmin/css/smartadmin-production-plugins.min.css')?>">
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url('themes/smartadmin/css/smartadmin-production.min.css')?>">
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url('themes/smartadmin/css/smartadmin-skins.min.css')?>">

        <!-- SmartAdmin RTL Support -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url('themes/smartadmin/css/smartadmin-rtl.min.css')?>"> 

        <!-- We recommend you use "your_style.css" to override SmartAdmin
             specific styles this will also ensure you retrain your customization with each SmartAdmin update. -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url('themes/smartadmin/css/style.css')?>">

        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <!-- <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url('themes/smartadmin/css/demo.min.css')?>"> -->

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="<?=assets_url('img/favicon/favicon.ico')?>" type="image/x-icon">
        <link rel="icon" href="<?=assets_url('img/favicon/favicon.ico')?>" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

        <!-- Specifying a Webpage Icon for Web Clip 
             Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?=assets_url('img/favicon/apple-icon-57x57.png')?>">
        <link rel="apple-touch-icon" sizes="60x60" href="<?=assets_url('img/favicon/apple-icon-60x60.png')?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?=assets_url('img/favicon/apple-icon-72x72.png')?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?=assets_url('img/favicon/apple-icon-76x76.png')?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?=assets_url('img/favicon/apple-icon-114x114.png')?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?=assets_url('img/favicon/apple-icon-120x120.png')?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?=assets_url('img/favicon/apple-icon-144x144.png')?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?=assets_url('img/favicon/apple-icon-152x152.png')?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?=assets_url('img/favicon/apple-icon-180x180.png')?>">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?=assets_url('img/favicon/android-icon-192x192.png')?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?=assets_url('img/favicon/favicon-32x32.png')?>">
        <link rel="icon" type="image/png" sizes="96x96" href="<?=assets_url('img/favicon/favicon-96x96.png')?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?=assets_url('img/favicon/favicon-16x16.png')?>">
        <link rel="manifest" href="<?=assets_url('img/favicon/manifest.json')?>">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?=assets_url('img/favicon/ms-icon-144x144.png')?>">
        <meta name="theme-color" content="#ffffff">

        <!-- <link rel="apple-touch-icon" href="<?=assets_url('themes/smartadmin/img/splash/sptouch-icon-iphone.png')?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?=assets_url('themes/smartadmin/img/splash/touch-icon-ipad.png')?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?=assets_url('themes/smartadmin/img/splash/touch-icon-iphone-retina.png')?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?=assets_url('themes/smartadmin/img/splash/touch-icon-ipad-retina.png')?>"> -->
        
        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        
        <!-- Startup image for web apps -->
        <!-- <link rel="apple-touch-startup-image" href="<?=assets_url('themes/smartadmin/img/splash/ipad-landscape.png')?>" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="<?=assets_url('themes/smartadmin/img/splash/ipad-portrait.png')?>" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="<?=assets_url('themes/smartadmin/img/splash/iphone.png')?>" media="screen and (max-device-width: 320px)"> -->

        <?=((isset($custom_css_links)) ? $custom_css_links : '')?>

        <?=@$yield_style?>
    </head>
    
    <body class="fixed-header ">
        <header id="header">
            <div id="logo-group">
                <span id="logo"> <img src="<?=assets_url('themes/smartadmin/img/logo.png')?>" alt="SmartAdmin"> </span>
            </div>

            <div class="pull-right">
                <div id="hide-menu" class="btn-header pull-right">
                    <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
                </div>
                <ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
                    <li class="">
                        <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 
                            <img src="<?=assets_url('themes/smartadmin/img/avatars/sunny.png')?>" alt="John Doe" class="online" />  
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?=links_url(array('class'=>'auth','method'=>'logout'))?>" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div id="logout" class="btn-header transparent pull-right">
                    <span> <a href="<?=links_url(array('class'=>'auth','method'=>'logout'))?>" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
                </div>

                <div id="fullscreen" class="btn-header transparent pull-right">
                    <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
                </div>
            </div>

        </header>

        <aside id="left-panel">
            <div class="login-info">
                <span> 
                    <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                        <img src="<?=assets_url('themes/smartadmin/img/avatars/sunny.png')?>" alt="me" class="online" /> 
                        <span>
                            <?=@$this->session->userdata('users_fullname')?> 
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </a> 
                </span>
            </div>

            <nav>
                <?=build_nav('main_navigation',$menu['main_navigation'],'active','webmenu_parent_id')?>
            </nav>

            <span class="minifyme" data-action="minifyMenu"> 
                <i class="fa fa-arrow-circle-left hit"></i> 
            </span>
        </aside>

        <div id="main" role="main">
            <div id="ribbon">
                <span class="ribbon-button-alignment"> 
                    <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
                        <i class="fa fa-refresh"></i>
                    </span> 
                </span>
            </div>

            <div id="content">
                <?=@$yield?>
            </div>
        </div>

        <div class="page-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <span class="txt-color-white">Lucky Mahrus © 2017</span>
                </div>

                <div class="col-xs-6 col-sm-6 text-right hidden-xs">
                    <div class="txt-color-white inline-block">
                        <i class="txt-color-blueLight hidden-mobile">Last account activity <i class="fa fa-clock-o"></i> <strong>52 mins ago &nbsp;</strong> </i>
                    </div>
                </div>
            </div>
        </div>

        <div id="shortcut">
            <ul>
                <li>
                    <a href="inbox.html" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
                </li>
                <li>
                    <a href="calendar.html" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
                </li>
                <li>
                    <a href="gmap-xml.html" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
                </li>
                <li>
                    <a href="invoice.html" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
                </li>
                <li>
                    <a href="gallery.html" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
                </li>
                <li>
                    <a href="profile.html" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
                </li>
            </ul>
        </div>
        <!-- END SHORTCUT AREA -->

        <!--================================================== -->

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <script data-pace-options='{ "restartOnRequestAfter": true }' src="<?=assets_url('themes/smartadmin/js/plugin/pace/pace.min.js')?>"></script>

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
            if (!window.jQuery) {
                document.write('<script src="<?=assets_url('themes/smartadmin/js/libs/jquery-2.1.1.min.js')?>"><\/script>');
            }
        </script>

        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script>
            if (!window.jQuery.ui) {
                document.write('<script src="<?=assets_url('themes/smartadmin/js/libs/jquery-ui-1.10.3.min.js')?>"><\/script>');
            }
        </script>

        <!-- IMPORTANT: APP CONFIG -->
        <script src="<?=assets_url('themes/smartadmin/js/app.config.js')?>"></script>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
        <script src="<?=assets_url('themes/smartadmin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js')?>"></script> 

        <!-- BOOTSTRAP JS -->
        <script src="<?=assets_url('themes/smartadmin/js/bootstrap/bootstrap.min.js')?>"></script>

        <!-- CUSTOM NOTIFICATION -->
        <script src="<?=assets_url('themes/smartadmin/js/notification/SmartNotification.min.js')?>"></script>

        <!-- JARVIS WIDGETS -->
        <script src="<?=assets_url('themes/smartadmin/js/smartwidgets/jarvis.widget.min.js')?>"></script>

        <!-- EASY PIE CHARTS -->
        <script src="<?=assets_url('themes/smartadmin/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js')?>"></script>

        <!-- SPARKLINES -->
        <script src="<?=assets_url('themes/smartadmin/js/plugin/sparkline/jquery.sparkline.min.js')?>"></script>

        <!-- JQUERY VALIDATE -->
        <script src="<?=assets_url('themes/smartadmin/js/plugin/jquery-validate/jquery.validate.min.js')?>"></script>

        <!-- JQUERY MASKED INPUT -->
        <script src="<?=assets_url('themes/smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js')?>"></script>

        <!-- JQUERY SELECT2 INPUT -->
        <script src="<?=assets_url('themes/smartadmin/js/plugin/select2/select2.min.js')?>"></script>

        <!-- JQUERY UI + Bootstrap Slider -->
        <script src="<?=assets_url('themes/smartadmin/js/plugin/bootstrap-slider/bootstrap-slider.min.js')?>"></script>

        <!-- browser msie issue fix -->
        <script src="<?=assets_url('themes/smartadmin/js/plugin/msie-fix/jquery.mb.browser.min.js')?>"></script>

        <!-- FastClick: For mobile devices -->
        <script src="<?=assets_url('themes/smartadmin/js/plugin/fastclick/fastclick.min.js')?>"></script>

        <!--[if IE 8]>

        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

        <![endif]-->

        <!-- MAIN APP JS FILE -->
        <script src="<?=assets_url('themes/smartadmin/js/app.min.js')?>"></script>

        <!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
        <!-- Voice command : plugin -->
        <!-- <script src="<?=assets_url('themes/smartadmin/js/speech/voicecommand.min.js')?>"></script> -->

        <!-- SmartChat UI : plugin -->
        <!-- <script src="<?=assets_url('themes/smartadmin/js/smart-chat-ui/smart.chat.ui.min.js')?>"></script>
        <script src="<?=assets_url('themes/smartadmin/js/smart-chat-ui/smart.chat.manager.min.js')?>"></script> -->

        <!-- PAGE RELATED PLUGIN(S) -->

        <?=@$custom_js_links?>
        

        <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        $(document).ready(function() {
            pageSetUp();
        })

        </script>

        <?=@$yield_script?>

        <!-- Your GOOGLE ANALYTICS CODE Below -->
        <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
        _gaq.push(['_trackPageview']);
        
        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

        </script>

    </body>

</html>