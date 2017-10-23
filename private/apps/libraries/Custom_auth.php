<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Auth.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/libraries/Auth.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Custom_auth
{
    public function __construct()
    {

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

    public function is_allowed_to($class,$method)
    {
        $this->load->model('webmodules_model', 'webmodules');
        
        $webmodules = $this->webmodules->get_by(array('webmodules_class'=>$class,'webmodules_method'=>$method,'status'=>'1'));

        if(count($webmodules) > 0)
        {
            if($webmodules->need_login && !$this->ion_auth->logged_in()){ return false; }

            $arrGroups  = @unserialize($webmodules->groups_access);
            if($arrGroups == true)
            {
                if($this->ion_auth->in_group($arrGroups)){ return true;}
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

    public function checkPermission()
    {
        $fnc    = $this->router->method;
        switch($fnc)
        {
            case 'insert'   : $fnc = 'add';     break;
            case 'update'   : $fnc = 'edit';    break;
            case 'remove'   : $fnc = 'delete';  break;
        }
        
        if(($this->config->item('maintenance_mode') == TRUE && $this->session->userdata('is_maintenance_login') == TRUE) || $this->config->item('maintenance_mode') == FALSE)
        {
            if($this->router->class == 'auth' && $fnc == 'login_dev' && !$this->ion_auth->logged_in())
            {
                redirect(links_url(array('class'=>'auth','method'=>'login')), 'refresh');
            }

            if($this->ion_auth->logged_in())
            {
                if($this->router->class == 'auth' && $fnc == 'login') redirect(secure_url(), 'refresh');

                if($this->ion_auth->is_locked())
                {
                    if($this->router->class <> 'auth' && $fnc <> 'locked') redirect(links_url(array('class'=>'auth','method'=>'locked')), 'refresh');
                }
                else
                {
                    if($this->router->class == 'auth' && ($fnc <> 'lock' && $fnc <> 'logout' && $fnc <> 'login_otp')) redirect(links_url(array('class'=>'home','method'=>'index')), 'refresh');
                }
            }

            $this->load->model('webmodules_model', 'webmodules');
            
            $webmodules = $this->webmodules->get_by(array('webmodules_class'=>$this->router->class,'webmodules_method'=>$fnc,'status'=>'1'));

            if(count($webmodules) > 0)
            {
                if($webmodules->need_login && !$this->ion_auth->logged_in())
                {
                    if(!$this->input->is_ajax_request())
                    {
                        redirect(links_url(array('class'=>'auth','method'=>'login')), 'refresh');
                    }
                    else
                    {
                        $this->output
                             ->set_content_type('application/json')
                             ->set_status_header(403)
                             ->set_output(json_encode(array()));exit;
                    }
                }

                $webmodules_name    = @unserialize($webmodules->webmodules_name);

                $arrGroups  = @unserialize($webmodules->groups_access);
                if($arrGroups == true)
                {
                    if($this->ion_auth->in_group($arrGroups))  return true;
                    else show_404();exit;
                }
                else
                {
                    return true;
                }
            }
            else
            {
                show_404();exit;
            }
        }
        else
        {
            if($this->config->item('maintenance_mode') == TRUE && $this->session->userdata('is_maintenance_login') == FALSE && $this->router->method <> 'login_dev')
            {
                redirect(links_url(array('class'=>'auth','method'=>'login_dev')), 'refresh');
            }

            return true;
        }
    }

    public function generateNavigationData()
    {
        $data = array();
        $themes = $this->session->userdata('themes').'/';

        $this->load->model('webmenu_model', 'webmenu');

        $logged     = (!$this->ion_auth->logged_in()) ? 0 : 1;
        $mainmenus  = $this->webmenu->order_by('webmenu_order','asc')->getWebmenu($logged);

        if(count($mainmenus) > 0)
        {
            $i  = 0;
            $countlead  = 0;
            foreach($mainmenus as $mainmenu)
            {
                $arrGroups = @unserialize($mainmenu->groups_access);
                if(($themes == $mainmenu->webthemes_name.'/' || (is_null($mainmenu->webthemesmenu_id) && empty($mainmenu->webthemesmenu_id))) && $mainmenu->status == '1' &&
                    (
                        (empty($arrGroups) || $arrGroups == false) ||
                        (
                            ($this->ion_auth->logged_in() && $this->ion_auth->in_group($arrGroups)) ||
                            ($this->ion_auth->logged_in() && $this->ion_auth->in_group($arrGroups) && ($mainmenu->need_login == 2 || $mainmenu->need_login == 4)) ||
                            (!$this->ion_auth->logged_in() && ($mainmenu->need_login == 0 || $mainmenu->need_login == 2 || $mainmenu->need_login == 3))
                        )
                    )
                )
                {
                    $webthemesmenu_name   = str_replace(' ', '_',preg_replace('/[^A-Za-z_ ]/', '', strtolower($mainmenu->webthemesmenu_name)));
                    $data[((empty($webthemesmenu_name)) ? 'main_navigation' : $webthemesmenu_name)][$i] = $mainmenu;
                    $i++;
                }
            }
        }
        //echo "<pre>";print_r($data);echo "</pre>";
        return $data;
    }

	public function login()
	{
		
	}

	public function logout()
	{
		
	}

	public function lock()
	{

	}

	public function unlock()
	{

	}

	public function is_logged()
	{
		return TRUE;
	}

	public function is_locked()
	{
		return FALSE;
	}
}


/* End of file Auth.php */
/* Location: private/apps/libraries/Auth.php */


