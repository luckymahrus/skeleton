<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * MY_Config.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2015
 * license		: http://www.webdev-lucky.com/
 * file			: private/application/apps/core/MY_Config.php
 * created		: 2015 October 21th / 23:20:46
 * last edit	: 2015 October 21th / 23:20:46
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

require APPPATH."third_party/MX/Config.php";

class MY_Config extends MX_Config
{
	public function __construct()
	{
		parent::__construct();
	}

	public function api_url($uri = '', $protocol = NULL)
	{
		$api_url = $this->slash_item('api_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$api_url = substr($api_url, strpos($api_url, '//'));
			}
			else
			{
				$api_url = $protocol.substr($api_url, strpos($api_url, '://'));
			}
		}

		return $api_url.ltrim($this->_uri_string($uri), '/');
	}

	public function assets_url($uri = '', $protocol = NULL)
	{
		$assets_url = $this->slash_item('assets_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$assets_url = substr($assets_url, strpos($assets_url, '//'));
			}
			else
			{
				$assets_url = $protocol.substr($assets_url, strpos($assets_url, '://'));
			}
		}

		return $assets_url.ltrim($this->_uri_string($uri), '/');
	}

	public function secure_url($uri = '', $protocol = NULL)
	{
		$secure_url = $this->slash_item('secure_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$secure_url = substr($secure_url, strpos($secure_url, '//'));
			}
			else
			{
				$secure_url = $protocol.substr($secure_url, strpos($secure_url, '://'));
			}
		}

		return $secure_url.ltrim($this->_uri_string($uri), '/');
	}
}

 
/* End of file MY_Config.php */
/* Location: private/application/apps/core/MY_Config.php */

