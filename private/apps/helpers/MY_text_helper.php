<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * MY_url_helper.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2015
 * license		: http://www.luckymahrus.com/
 * file			: private/application/apps/helpers/MY_url_helper.php
 * created		: 2015 October 21th / 23:20:46
 * last edit	: 2015 October 21th / 23:20:46
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

if ( ! function_exists('padding_left'))
{
    function padding_left($s, $c, $n)
    {
        if (strlen($s) >= $n)
        {
            return $s;
        }
        $max = ($n - strlen($s))/strlen($c);
        for ($i = 0; $i < $max; $i++)
        {
            $s = $c.$s;
        }
        return $s;
    }
}

if ( ! function_exists('padding_right'))
{
    function padding_right($s, $c, $n)
    {
        if (strlen($s) >= $n)
        {
            return $s;
        }
        $max = ($n - strlen($s))/strlen($c);
        for ($i = 0; $i < $max; $i++)
        {
            $s = $s.$c;
        }
        return $s;
    }
}

if ( ! function_exists('if_date_convert'))
{
    function if_date_convert($text, $delimiter="-", $date_format="Y-m-d")
    {
		$regex = '/[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}/';

		if (preg_match($regex, $text))
		{
			list($date,$month,$year) = explode($delimiter, $text);

			return date($date_format, mktime(0,0,0,padding_left($month,'0',2),padding_left($date,'0',2),$year));
		}
		else
		{
		    return $text;
		}

		return FALSE;
    }
}

if ( ! function_exists('is_decimal'))
{
    function is_decimal_convert($text, $delimiter=".",$decimal_number=2)
    {
		$regex = '/[-]{0,1}[0-9]{1}[.]{0,1}[0-9]{0,}/';

		$exploded = explode($delimiter, $text);

		if (preg_match($regex, $text))
		{
			if(isset($exploded[1]))
			{
				list($number,$decimal) = $exploded;
				$decimal_length = strlen($decimal);
				if($decimal_length > $decimal_number) $decimal_number = $decimal_length; 
			}
			else
			{
				$number	 = $text;
				$decimal = '0';	
			}

			return floatval($number.$delimiter.padding_right($decimal,'0',$decimal_number));
		}
		else
		{
		    return $text;
		}

		return FALSE;
    }
}

if ( ! function_exists('localize_date'))
{
	function localize_date($datetime,$unixtime=TRUE,$time = TRUE)
	{
        $ci = &get_instance();

        $baselang = (isset($ci->session->lang) ? (($ci->session->lang == 'en' || $ci->session->lang == 'english') ? 'english' : 'dutch') : $ci->config->item('language'));
        
        $ci->lang->load('global', $baselang);

        if($unixtime == FALSE)
        {
    		if($time == TRUE)
    		{
            	list($date, $time) 				= explode(' ', $datetime);
            	list($year, $month, $date) 		= explode('-', $date);
            	list($hour, $minute, $second) 	= explode(':', $time);
    		}
    		else
    		{
            	list($year, $month, $date) 		= explode('-', $datetime);
    		}

    		$hour	= (isset($hour)) ? $hour : 0;
    		$minute	= (isset($minute)) ? $minute : 0;
    		$second	= (isset($second)) ? $second : 0;

            $datetime = mktime($hour,$minute,$second,$month,$date,$year);
        }

        if($baselang == 'dutch')
        {
        	if($unixtime == TRUE)
        	{
				$date = $ci->lang->line(gmdate("l", $datetime)).' '.gmdate("d", $datetime).' '.strtolower($ci->lang->line(gmdate("F", $datetime))).gmdate(" Y", $datetime).(($time == TRUE) ? gmdate(" / H:i", $datetime) : '');
        	}
        	else
        	{
				$date = $ci->lang->line(date("l", $datetime)).' '.date("d", $datetime).' '.strtolower($ci->lang->line(date("F", $datetime))).date(" Y", $datetime).(($time == TRUE) ? date(" / H:i", $datetime) : '');
        	}
        }
        else
        {
        	if($unixtime == TRUE)
        	{
				$date = gmdate("l, F d", $datetime).'<sup>'.gmdate("S", $datetime).'</sup>'.gmdate(" Y", $datetime).(($time == TRUE) ? gmdate(" / H:i", $datetime) : '');
        	}
        	else
        	{
				$date = date("l, F d", $datetime).'<sup>'.date("S", $datetime).'</sup>'.date(" Y", $datetime).(($time == TRUE) ? date(" / H:i", $datetime) : '');
        	}
        }

		return $date;
	}
}

 
/* End of file MY_url_helper.php */
/* Location: private/application/apps/helpers/MY_url_helper.php */

