<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * walkernav_helper.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2015
 * license		: http://www.luckymahrus.com/
 * file			: private/application/apps/helpers/walkernav_helper.php
 * created		: 2015 October 21th / 23:20:46
 * last edit	: 2015 October 21th / 23:20:46
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */


if ( ! function_exists('is_allowed_to'))
{
    function is_allowed_to($class,$method)
    {
        $CI =& get_instance();

        if( ! isset($CI))
        {
            $CI = new CI_Controller();
        }
        $CI->load->model('webmodules_model', 'webmodules');
        
        $webmodules = $CI->webmodules->get_by(array('webmodules_class'=>$class,'webmodules_method'=>$method,'status'=>'1'));

        if(count($webmodules) > 0)
        {
            if($webmodules->need_login == 1 && !$CI->ion_auth->logged_in()){ return false; }

            $arrGroups  = @unserialize($webmodules->groups_access);
            if($arrGroups == true)
            {
                if($CI->ion_auth->in_group($arrGroups)){ return true;}
                else{ return false; }
            }
            else
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }
}

if ( ! function_exists('get_module_detail'))
{
    function get_module_detail($class,$method)
    {
        $CI =& get_instance();

        if( ! isset($CI))
        {
            $CI = new CI_Controller();
        }
        //$CI->load->model('webmodules_model', 'webmodules');

        return $CI->webmodules->get_by(array('webmodules_class'=>$class,'webmodules_method'=>$method,'status'=>'1'));
    }
}

if ( ! function_exists('generateNavigationData'))
{
    function generateNavigationData($themes='default')
    {
        $CI =& get_instance();

        if( ! isset($CI))
        {
            $CI = new CI_Controller();
        }
        $CI->load->model('webmenu_model', 'webmenu');

        $logged     = (!$CI->ion_auth->logged_in()) ? 0 : 1;
        $mainmenus  = $CI->webmenu->getWebmenu($logged);

        if(count($mainmenus) > 0)
        {
            $i  = 0;
            $leadsfound  = false;
            $countlead  = 0;
            foreach($mainmenus as $mainmenu)// => $item)
            {
                $arrGroups = @unserialize($mainmenu->groups_access);
                if($themes == $mainmenu->webthemes_name.'/' && $mainmenu->status == '1' &&
                    (
                        (empty($arrGroups) || $arrGroups == false) ||
                        (
                            (@$CI->ion_auth->logged_in() && @$CI->ion_auth->in_group(@$arrGroups)) ||
                            (@$CI->ion_auth->logged_in() && @$CI->ion_auth->in_group(@$arrGroups) && (@$mainmenu->need_login == 2 || @$mainmenu->need_login == 4)) ||
                            (!@$CI->ion_auth->logged_in() && (@$mainmenu->need_login == 0 || @$mainmenu->need_login == 2 || @$mainmenu->need_login == 3))
                        )
                    )
                )
                {
                    $data[str_replace(' ', '_',preg_replace('/[^A-Za-z_ ]/', '', strtolower($mainmenu->webthemesmenu_name)))][$i]       = $mainmenu;
                    $i++;
                }
            }
            return @$data;
        }
//$arr = array(1,2,3,4,5,6);echo serialize($arr);exit;
    }
}

 
/* End of file walkernav_helper.php */
/* Location: private/application/apps/helpers/walkernav_helper.php */

