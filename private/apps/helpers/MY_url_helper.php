<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * MY_url_helper.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2015
 * license		: http://www.webdev-lucky.com/
 * file			: private/application/apps/helpers/MY_url_helper.php
 * created		: 2015 October 21th / 23:20:46
 * last edit	: 2015 October 21th / 23:20:46
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

if ( ! function_exists('assets_url'))
{
	function assets_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->assets_url($uri, $protocol);
	}
}

if ( ! function_exists('api_url'))
{
	function api_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->api_url($uri, $protocol);
	}
}

if ( ! function_exists('secure_url'))
{
	function secure_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->secure_url($uri, $protocol);
	}
}

if ( ! function_exists('links_url'))
{
	function links_url($condition,$data=NULL,$url=NULL)
	{
		get_instance()->load->model('webmodules_model','webmodules');
		$webmodules 	= get_instance()->webmodules->get_by_modules($condition);
		$uri	= '';
		if(count($webmodules) > 0)
		{
			$uri		= @$webmodules->webmodules_uri_routes;
		}
		return (($url === NULL) ? secure_url($uri) : base_url($uri));
		//return ($slug);
	}
}

 
/* End of file MY_url_helper.php */
/* Location: private/application/apps/helpers/MY_url_helper.php */

