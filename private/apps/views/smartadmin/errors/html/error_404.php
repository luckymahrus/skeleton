<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();

if( ! isset($CI))
{
    $CI = new CI_Controller();
}

$CI->load->helper('url');

$themes = (($CI->config->item('themes')) ? $CI->config->item('themes').'/' : 'default/');
$page_title=$heading;
$page_title_separator= @$CI->config->item('page_title_separator');
$site_name= @$CI->config->item('site_name');
$site_description= @$CI->config->item('company_description');
$site_keyword= @$CI->config->item('company_keyword');
$lang= (isset($CI->session->lang) ? (($CI->session->lang == 'en' || $CI->session->lang == 'english') ? 'english' : 'dutch') : $CI->config->item('language'));
$nav = generateNavigationData($themes);
include (__DIR__.'/../../layouts/walkernav.php'); ?><!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title>Error <?php echo $heading; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">
            
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url()?>themes/smartadmin/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url()?>themes/smartadmin/css/font-awesome.min.css">

        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url()?>themes/smartadmin/css/smartadmin-production-plugins.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url()?>themes/smartadmin/css/smartadmin-production.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url()?>themes/smartadmin/css/smartadmin-skins.min.css">

        <!-- SmartAdmin RTL Support -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url()?>themes/smartadmin/css/smartadmin-rtl.min.css"> 

        <!-- We recommend you use "your_style.css" to override SmartAdmin
             specific styles this will also ensure you retrain your customization with each SmartAdmin update. -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url()?>themes/smartadmin/css/style.css">

        <style>
			.error-text-2
			{
				text-align: center;
				font-size: 700%;
				font-weight: bold;
				font-weight: 100;
				color: #333;
				line-height: 1;
				letter-spacing: -.05em;
				background-image: -webkit-linear-gradient(92deg,#333,#ed1c24);
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent;
			}
			.particle
			{
				position: absolute;
				top: 50%;
				left: 50%;
				width: 1rem;
				height: 1rem;
				border-radius: 100%;
				background-color: #ed1c24;
				background-image: -webkit-linear-gradient(rgba(0,0,0,0),rgba(0,0,0,.3) 75%,rgba(0,0,0,0));
				box-shadow: inset 0 0 1px 1px rgba(0,0,0,.25);
			}
			.particle--a
			{
				-webkit-animation: particle-a 1.4s infinite linear;
				-moz-animation: particle-a 1.4s infinite linear;
				-o-animation: particle-a 1.4s infinite linear;
				animation: particle-a 1.4s infinite linear;
			}
			.particle--b
			{
				-webkit-animation: particle-b 1.3s infinite linear;
				-moz-animation: particle-b 1.3s infinite linear;
				-o-animation: particle-b 1.3s infinite linear;
				animation: particle-b 1.3s infinite linear;
				background-color: #00A300;
			}
			.particle--c
			{
				-webkit-animation: particle-c 1.5s infinite linear;
				-moz-animation: particle-c 1.5s infinite linear;
				-o-animation: particle-c 1.5s infinite linear;
				animation: particle-c 1.5s infinite linear;
				background-color: #57889C;
			}

			@-webkit-keyframes particle-a
			{
				0%
				{
					-webkit-transform: translate3D(-3rem,-3rem,0);
					z-index: 1;
					-webkit-animation-timing-function: ease-in-out;
				}

				25%
				{
					width: 1.5rem;
					height: 1.5rem;
				}
			
				50%
				{
					-webkit-transform: translate3D(4rem, 3rem, 0);
					opacity: 1;
					z-index: 1;
					-webkit-animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .75rem;
					height: .75rem;
					opacity: .5;
				}
			
				100%
				{
					-webkit-transform: translate3D(-3rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@-moz-keyframes particle-a
			{
				0%
				{
					-moz-transform: translate3D(-3rem,-3rem,0);
					z-index: 1;
					-moz-animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.5rem;
					height: 1.5rem;
				}
			
				50%
				{
					-moz-transform: translate3D(4rem, 3rem, 0);
					opacity: 1;
					z-index: 1;
					-moz-animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .75rem;
					height: .75rem;
					opacity: .5;
				}
			
				100%
				{
					-moz-transform: translate3D(-3rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@-o-keyframes particle-a
			{
				0%
				{
					-o-transform: translate3D(-3rem,-3rem,0);
					z-index: 1;
					-o-animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.5rem;
					height: 1.5rem;
				}
			
				50%
				{
					-o-transform: translate3D(4rem, 3rem, 0);
					opacity: 1;
					z-index: 1;
					-o-animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .75rem;
					height: .75rem;
					opacity: .5;
				}
			
				100%
				{
					-o-transform: translate3D(-3rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@keyframes particle-a
			{
				0%
				{
					transform: translate3D(-3rem,-3rem,0);
					z-index: 1;
					animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.5rem;
					height: 1.5rem;
				}
			
				50%
				{
					transform: translate3D(4rem, 3rem, 0);
					opacity: 1;
					z-index: 1;
					animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .75rem;
					height: .75rem;
					opacity: .5;
				}
			
				100%
				{
					transform: translate3D(-3rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@-webkit-keyframes particle-b
			{
				0%
				{
					-webkit-transform: translate3D(3rem,-3rem,0);
					z-index: 1;
					-webkit-animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.5rem;
					height: 1.5rem;
				}
			
				50%
				{
					-webkit-transform: translate3D(-3rem, 3.5rem, 0);
					opacity: 1;
					z-index: 1;
					-webkit-animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .5rem;
					height: .5rem;
					opacity: .5;
				}
			
				100%
				{
					-webkit-transform: translate3D(3rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@-moz-keyframes particle-b
			{
				0%
				{
					-moz-transform: translate3D(3rem,-3rem,0);
					z-index: 1;
					-moz-animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.5rem;
					height: 1.5rem;
				}
			
				50%
				{
					-moz-transform: translate3D(-3rem, 3.5rem, 0);
					opacity: 1;
					z-index: 1;
					-moz-animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .5rem;
					height: .5rem;
					opacity: .5;
				}
			
				100%
				{
					-moz-transform: translate3D(3rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@-o-keyframes particle-b
			{
				0%
				{
					-o-transform: translate3D(3rem,-3rem,0);
					z-index: 1;
					-o-animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.5rem;
					height: 1.5rem;
				}
			
				50%
				{
					-o-transform: translate3D(-3rem, 3.5rem, 0);
					opacity: 1;
					z-index: 1;
					-o-animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .5rem;
					height: .5rem;
					opacity: .5;
				}
			
				100%
				{
					-o-transform: translate3D(3rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@keyframes particle-b
			{
				0%
				{
					transform: translate3D(3rem,-3rem,0);
					z-index: 1;
					animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.5rem;
					height: 1.5rem;
				}
			
				50%
				{
					transform: translate3D(-3rem, 3.5rem, 0);
					opacity: 1;
					z-index: 1;
					animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .5rem;
					height: .5rem;
					opacity: .5;
				}
			
				100%
				{
					transform: translate3D(3rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@-webkit-keyframes particle-c
			{
				0%
				{
					-webkit-transform: translate3D(-1rem,-3rem,0);
					z-index: 1;
					-webkit-animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.3rem;
					height: 1.3rem;
				}
			
				50%
				{
					-webkit-transform: translate3D(2rem, 2.5rem, 0);
					opacity: 1;
					z-index: 1;
					-webkit-animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .5rem;
					height: .5rem;
					opacity: .5;
				}
			
				100%
				{
					-webkit-transform: translate3D(-1rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@-moz-keyframes particle-c
			{
				0%
				{
					-moz-transform: translate3D(-1rem,-3rem,0);
					z-index: 1;
					-moz-animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.3rem;
					height: 1.3rem;
				}
			
				50%
				{
					-moz-transform: translate3D(2rem, 2.5rem, 0);
					opacity: 1;
					z-index: 1;
					-moz-animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .5rem;
					height: .5rem;
					opacity: .5;
				}
			
				100%
				{
					-moz-transform: translate3D(-1rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@-o-keyframes particle-c
			{
				0%
				{
					-o-transform: translate3D(-1rem,-3rem,0);
					z-index: 1;
					-o-animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.3rem;
					height: 1.3rem;
				}
			
				50%
				{
					-o-transform: translate3D(2rem, 2.5rem, 0);
					opacity: 1;
					z-index: 1;
					-o-animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .5rem;
					height: .5rem;
					opacity: .5;
				}
			
				100%
				{
					-o-transform: translate3D(-1rem,-3rem,0);
					z-index: -1;
				}
			}
		
			@keyframes particle-c
			{
				0%
				{
					transform: translate3D(-1rem,-3rem,0);
					z-index: 1;
					animation-timing-function: ease-in-out;
				}
			
				25%
				{
					width: 1.3rem;
					height: 1.3rem;
				}
			
				50%
				{
					transform: translate3D(2rem, 2.5rem, 0);
					opacity: 1;
					z-index: 1;
					animation-timing-function: ease-in-out;
				}
			
				55%
				{
					z-index: -1;
				}
			
				75%
				{
					width: .5rem;
					height: .5rem;
					opacity: .5;
				}
			
				100%
				{
					transform: translate3D(-1rem,-3rem,0);
					z-index: -1;
				}
			}
		    </style>

        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <!-- <link rel="stylesheet" type="text/css" media="screen" href="<?=assets_url()?>themes/smartadmin/css/demo.min.css"> -->

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="<?=assets_url()?>themes/smartadmin/img/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?=assets_url()?>themes/smartadmin/img/favicon/favicon.ico" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

        <!-- Specifying a Webpage Icon for Web Clip 
             Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
        <link rel="apple-touch-icon" href="<?=assets_url()?>themes/smartadmin/img/splash/sptouch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?=assets_url()?>themes/smartadmin/img/splash/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?=assets_url()?>themes/smartadmin/img/splash/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?=assets_url()?>themes/smartadmin/img/splash/touch-icon-ipad-retina.png">
        
        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        
        <!-- Startup image for web apps -->
        <link rel="apple-touch-startup-image" href="<?=assets_url()?>themes/smartadmin/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="<?=assets_url()?>themes/smartadmin/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="<?=assets_url()?>themes/smartadmin/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

        
    </head>
    
    <body class="fixed-header">
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
                            <?=@$CI->session->userdata('users_fullname')?> 
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </a> 
                </span>
            </div>

            <nav>
                <?=build_nav('main_navigation',$nav['main_navigation'],'active','webmenu_parent_id')?>
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
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<div class="col-sm-12">
								<div class="text-center error-box">
									<h1 class="error-text-2 bounceInDown animated"> Error 404 <span class="particle particle--c"></span><span class="particle particle--a"></span><span class="particle particle--b"></span></h1>
									<h2 class="font-xl"><strong><i class="fa fa-fw fa-warning fa-lg text-warning"></i> <?php echo $heading; ?></strong></h2>
									<br>
									<p class="lead">
										<?php echo $message; ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
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

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <script data-pace-options='{ "restartOnRequestAfter": true }' src="<?=assets_url()?>themes/smartadmin/js/plugin/pace/pace.min.js"></script>

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
            if (!window.jQuery) {
                document.write('<script src="<?=assets_url()?>themes/smartadmin/js/libs/jquery-2.1.1.min.js"><\/script>');
            }
        </script>

        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script>
            if (!window.jQuery.ui) {
                document.write('<script src="<?=assets_url()?>themes/smartadmin/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
            }
        </script>

        <!-- IMPORTANT: APP CONFIG -->
        <script src="<?=assets_url()?>themes/smartadmin/js/app.config.js"></script>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
        <script src="<?=assets_url()?>themes/smartadmin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

        <!-- BOOTSTRAP JS -->
        <script src="<?=assets_url()?>themes/smartadmin/js/bootstrap/bootstrap.min.js"></script>

        <!-- CUSTOM NOTIFICATION -->
        <script src="<?=assets_url()?>themes/smartadmin/js/notification/SmartNotification.min.js"></script>

        <!-- JARVIS WIDGETS -->
        <script src="<?=assets_url()?>themes/smartadmin/js/smartwidgets/jarvis.widget.min.js"></script>

        <!-- EASY PIE CHARTS -->
        <script src="<?=assets_url()?>themes/smartadmin/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

        <!-- SPARKLINES -->
        <script src="<?=assets_url()?>themes/smartadmin/js/plugin/sparkline/jquery.sparkline.min.js"></script>

        <!-- JQUERY VALIDATE -->
        <script src="<?=assets_url()?>themes/smartadmin/js/plugin/jquery-validate/jquery.validate.min.js"></script>

        <!-- JQUERY MASKED INPUT -->
        <script src="<?=assets_url()?>themes/smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

        <!-- JQUERY SELECT2 INPUT -->
        <script src="<?=assets_url()?>themes/smartadmin/js/plugin/select2/select2.min.js"></script>

        <!-- JQUERY UI + Bootstrap Slider -->
        <script src="<?=assets_url()?>themes/smartadmin/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

        <!-- browser msie issue fix -->
        <script src="<?=assets_url()?>themes/smartadmin/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

        <!-- FastClick: For mobile devices -->
        <script src="<?=assets_url()?>themes/smartadmin/js/plugin/fastclick/fastclick.min.js"></script>

        <!--[if IE 8]>

        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

        <![endif]-->

        <!-- MAIN APP JS FILE -->
        <script src="<?=assets_url()?>themes/smartadmin/js/app.min.js"></script>

        <!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
        <!-- Voice command : plugin -->
        <!-- <script src="<?=assets_url()?>themes/smartadmin/js/speech/voicecommand.min.js"></script> -->

        <!-- SmartChat UI : plugin -->
        <!-- <script src="<?=assets_url()?>themes/smartadmin/js/smart-chat-ui/smart.chat.ui.min.js"></script>
        <script src="<?=assets_url()?>themes/smartadmin/js/smart-chat-ui/smart.chat.manager.min.js"></script> -->

        <!-- PAGE RELATED PLUGIN(S) -->

                

        <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        $(document).ready(function() {
            pageSetUp();
        })

        </script>

        
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