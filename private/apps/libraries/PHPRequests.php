<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/***
 *
 * PHPRequests.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/libraries/PHPRequests.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

require_once APPPATH."third_party/Requests/Requests.php";

class PHPRequests
{
    public function __construct()
    {
       Requests::register_autoloader();
    }
}


/* End of file PHPRequests.php */
/* Location: private/apps/libraries/PHPRequests.php */


