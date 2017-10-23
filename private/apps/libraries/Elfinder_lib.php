<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Elfinder.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/libraries/Elfinder.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */


require APPPATH."third_party/elfinder/elFinderConnector.class.php";
require APPPATH."third_party/elfinder/elFinder.class.php";
require APPPATH."third_party/elfinder/elFinderVolumeDriver.class.php";
require APPPATH."third_party/elfinder/elFinderVolumeLocalFileSystem.class.php";

class Elfinder_lib
{
	public function __construct($opts) 
	{
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}
}


/* End of file Elfinder.php */
/* Location: private/apps/libraries/Elfinder.php */


