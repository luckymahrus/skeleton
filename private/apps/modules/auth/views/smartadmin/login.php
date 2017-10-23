<!DOCTYPE html>
<html lang="en-us" id="extr-page">
	<head>
		<meta charset="utf-8">
		<title> SmartAdmin</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- #CSS Links -->
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

	</head>
	
	<body class="animated fadeInDown">

		<header id="header">

			<div id="logo-group">
				<span id="logo"> <img src="<?=assets_url('themes/smartadmin/img/logo.png')?>" alt="SmartAdmin"> </span>
			</div>

			<!-- <span id="extr-page-header-space"> <span class="hidden-mobile hiddex-xs">Need an account?</span> <a href="register.html" class="btn btn-danger">Create account</a> </span> -->

		</header>

		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
						<div class="well no-padding">
							<?=form_open(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), array('class' => 'smart-form client-form', 'id' => 'login-form', 'method' => 'post'))?>
								<header class="strong">
									<?=@$module_detail->webmodules_title?>
								</header>

								<fieldset>
									<section>
										<?=lang('login_subheading', '', array('class'=>'label'))?>
									</section>

									<?php if($this->session->flashdata('message') || isset($message)) : $message = (($this->session->flashdata('message')) ? $this->session->flashdata('message') : $message); ?>
									<section>
										<div class="alert alert-<?=((isset($message['class'])) ? $message['class'] : 'info')?> fade in">
											<button class="close" data-dismiss="alert">×</button>
											<i class="fa-fw fa <?=((isset($message['icon'])) ? $message['icon'] : 'fa-info')?>"></i>
											<strong><?=((isset($message['status'])) ? $message['status'] : 'Info')?></strong>
											<?php
											if(isset($message['text']))
											{
												if(is_array($message['text']))
												{
													foreach ($message['text'] as $idxM => $msg)
													{
														echo $msg.'<br>';
													}
												}
												else
												{
													echo $message['text'];
												}
											}
											?>
										</div>
									</section>
									<?php endif; ?>

									<section>
										<label class="label strong"><?=$identity['label'].((isset($identity['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input"> <i class="icon-append fa fa-envelope"></i>
											<?=form_input($identity,$identity['value'],array('class'=>'','maxlength'=>'50','title'=>$identity['title'],'placeholder'=>$identity['placeholder']))?>
											<!-- <?=form_input($identity)?> -->
											<b class="tooltip tooltip-top-right"><i class="fa fa-envelope txt-color-teal"></i> <?=$this->lang->line('login_identity_label')?></b>
										</label>
                                    	<?=form_error($identity['name'],'<div class="note note-error">','</div>')?>
									</section>

									<section>
										<label class="label strong"><?=$password['label'].((isset($password['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<?=form_password($password,$password['value'],array('class'=>'','maxlength'=>'50','title'=>$password['title'],'placeholder'=>$password['placeholder']))?>
											<!-- <?=form_password($password)?> -->
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> <?=$this->lang->line('login_password_label')?></b>
										</label>
                                    	<?=form_error($password['name'],'<div class="note note-error">','</div>')?>
										<div class="note">
											<a href="<?=links_url(array('class'=>'auth','method'=>'forgot_password'))?>"><small><?=$this->lang->line('text_link_forgot_password')?></small></a>
										</div>
									</section>

									<section>
										<label class="checkbox"><input type="checkbox" name="remember" id="remember" value="1"><i></i> <?=$this->lang->line('text_link_rememberme')?></label>
									</section>
								</fieldset>
								<footer>
									<button type="submit" class="btn btn-primary"><?=$this->lang->line('label_btn_login')?></button>
									<?php if($this->config->item('maintenance_mode') == TRUE) : ?>
									<a href="<?=links_url(array('class'=>$this->router->class,'method'=>'logout'))?>" class="btn btn-warning"><?=$this->lang->line('label_btn_logout_dev')?></a>
									<?php endif; ?>
								</footer>
							<?=form_close()?>

						</div>
					</div>
				</div>
			</div>

		</div>

		<!--================================================== -->	

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script src="<?=assets_url('themes/smartadmin/js/plugin/pace/pace.min.js')?>"></script>

	    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script> if (!window.jQuery) { document.write('<script src="<?=assets_url('themes/smartadmin/js/libs/jquery-2.1.1.min.js')?>"><\/script>');} </script>

	    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script> if (!window.jQuery.ui) { document.write('<script src="<?=assets_url('themes/smartadmin/js/libs/jquery-ui-1.10.3.min.js')?>"><\/script>');} </script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="<?=assets_url('themes/smartadmin/js/app.config.js')?>"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events 		
		<script src="<?=assets_url('themes/smartadmin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js')?>"></script> -->

		<!-- BOOTSTRAP JS -->		
		<script src="<?=assets_url('themes/smartadmin/js/bootstrap/bootstrap.min.js')?>"></script>

		<!-- JQUERY VALIDATE -->
		<script src="<?=assets_url('themes/smartadmin/js/plugin/jquery-validate/jquery.validate.min.js')?>"></script>
		
		<!-- JQUERY MASKED INPUT -->
		<script src="<?=assets_url('themes/smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js')?>"></script>
		
		<!--[if IE 8]>
			
			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
			
		<![endif]-->

		<!-- MAIN APP JS FILE -->
		<script src="<?=assets_url('themes/smartadmin/js/app.min.js')?>"></script>

		<script type="text/javascript">
			runAllForms();

			$(function() {
				// Validation
				$("#login-form").validate({
					// Rules for form validation
					rules : {
						email : {
							required : true,
							email : true
						},
						password : {
							required : true,
							minlength : 3,
							maxlength : 20
						}
					},

					// Messages for form validation
					messages : {
						email : {
							required : 'Please enter your email address',
							email : 'Please enter a VALID email address'
						},
						password : {
							required : 'Please enter your password'
						}
					},

					// Do not change code below
					errorPlacement : function(error, element) {
						error.insertAfter(element.parent());
					}
				});
			});
		</script>

	</body>
</html>