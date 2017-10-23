<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/***
 *
 * routes.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: https://www.webdev-lucky.com
 * file			: private/apps/config/routes.php
 * generated	: 2017 March 9th / 00:53:32
 * last edit	: 2017 March 9th / 00:53:32
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */


$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
$route['login-dev'] = 'auth/login_dev';
$route['register'] = 'auth/register';
$route['activate/(:any)/(:any)'] = 'auth/activate/$1/$2';
$route['activate/(:any)'] = 'auth/activate/$1';
$route['activate'] = 'auth/activate/$1';
$route['deactivate/(:any)'] = 'auth/deactivate/$1';
$route['login'] = 'auth/login';
$route['login-otp'] = 'auth/login_otp';
$route['forgot-password'] = 'auth/forgot_password';
$route['reset-password/(:any)'] = 'auth/reset_password/$1';
$route['lock'] = 'auth/lock';
$route['locked'] = 'auth/locked';
$route['unlock'] = 'auth/unlock';
$route['logout'] = 'auth/logout';
$route['my-profile'] = 'user/index';
$route['my-login-history'] = 'user/login_history';
$route['my-documents'] = 'user/documents';
$route['(:any)/(:num)'] = '$1/index/$2';


/* End of file routes.php */
/* Location: private/apps/config/routes.php */


