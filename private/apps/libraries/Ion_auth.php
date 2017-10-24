<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth
*
* Version: 2.5.2
*
* Author: Ben Edmunds
*		  ben.edmunds@gmail.com
*         @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Ion_auth
{
	/**
	 * account status ('not_activated', etc ...)
	 *
	 * @var string
	 **/
	protected $status;

	/**
	 * extra where
	 *
	 * @var array
	 **/
	public $_extra_where = array();

	/**
	 * extra set
	 *
	 * @var array
	 **/
	public $_extra_set = array();

	/**
	 * caching of users and their groups
	 *
	 * @var array
	 **/
	public $_cache_user_in_group;

	/**
	 * __construct
	 *
	 * @return void
	 * @author Ben
	 **/
	public function __construct()
	{
		$this->load->config('ion_auth', TRUE);
		$this->load->library(array('email', 'google_authenticator'));
		$this->lang->load('ion_auth');
		$this->load->helper(array('cookie', 'language','url'));

		$this->load->library('session');

		$this->load->model('ion_auth_model');

		$this->_cache_user_in_group =& $this->ion_auth_model->_cache_user_in_group;

		//auto-login the user if they are remembered
		if (!$this->logged_in() && get_cookie($this->config->item('identity_cookie_name')) && get_cookie($this->config->item('remember_cookie_name')))
		{
			$this->ion_auth_model->login_remembered_user();
		}

		$email_config = $this->config->item('email_config');

		if ($this->config->item('use_ci_email') && isset($email_config) && is_array($email_config))
		{
			$this->email->initialize($email_config);
		}

		$this->ion_auth_model->trigger_events('library_constructor');
	}

	/**
	 * __call
	 *
	 * Acts as a simple way to call model methods without loads of stupid alias'
	 *
	 **/
	public function __call($method, $arguments)
	{
		if (!method_exists( $this->ion_auth_model, $method) )
		{
			throw new Exception('Undefined method Ion_auth::' . $method . '() called');
		}
		if($method == 'create_user')
		{
			return call_user_func_array(array($this, 'register'), $arguments);
		}
		if($method=='update_user')
		{
			return call_user_func_array(array($this, 'update'), $arguments);
		}
		return call_user_func_array( array($this->ion_auth_model, $method), $arguments);
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

	/**
	 * Generates a code that stores in database.
	 * Could be used with flashdata to redirect to another loginform with login data and send securely with custom login token
	 *
	 * Possibly useless
	 *
	 * @return void
	 * @author Mathew and SpyTec
	 **/
	public function set_otp_login_activation($identity)
	{
		if ( $this->ion_auth_model->set_otp_login_activation($identity) )
		{
			// Get user information
			$user = $this->where($this->config->item('identity'), $identity)->where('status', 1)->users()->row();  //changed to get_user_by_identity from email

			if ($user)
			{
				return $this->ion_auth_model->get_otp_login_activation($identity);
			}
			else
			{
				$this->set_error('otp_activation_key_unsuccessful');
				return FALSE;
			}
		}
		else
		{
			$this->set_error('otp_activation_key_unsuccessful');
			return FALSE;
		}
	}
	
	/**
	 * forgotten password feature
	 *
	 * @return mixed  boolian / array
	 * @author Mathew
	 **/
	public function forgotten_password($identity)    //changed $email to $identity
	{
		if ( $this->ion_auth_model->forgotten_password($identity) )   //changed
		{
			// Get user information
			$this->load->model('users_model','users');
			$user = $this->users->get_by(array($this->config->item('identity')=>$identity,'status'=>1));
            //$user = $this->where($this->config->item('identity'), $identity)->where('status', 1)->users()->row();  //changed to get_user_by_identity from email

			if ($user)
			{
				$data = array(
					'identity'		=> $user->{$this->config->item('identity')},
					'forgotten_password_code' => str_replace('-', '_', $user->forgotten_password_code),
					'users_first_name'  => $user->users_first_name,
					'users_last_name'   => $user->users_last_name,
				);

				$mailSubject	= $this->config->item('site_title') . ' - ' . $this->lang->line('email_forgotten_password_subject');
				$mailTemplates	= $this->session->userdata('themes').'/'.$this->config->item('email_templates').$this->config->item('email_forgot_password');
				//$this->emails->sendEmail('Authentication System',$user->email,$mailSubject,$data,$mailTemplates);

		        //if ($this->emails->sendEmail($this->config->item('site_title').' Authentication System',$user->users_email,$mailSubject,$data,$mailTemplates) == TRUE)
		        //{
					//$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
					$this->set_message('forgot_password_successful');
					return TRUE;
		        //}
		        //else
		        //{
					//$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful'));
				//	$this->set_error('forgot_password_unsuccessful');
				//	return FALSE;
		        //}

				/*if(!$this->config->item('use_ci_email'))
				{
					$this->set_message('forgot_password_successful');
					return $data;
				}
				else
				{
					$message = $this->load->view($this->config->item('email_templates').$this->config->item('email_forgot_password'), $data, true);
					$this->email->clear();
					$this->email->from($this->config->item('admin_email'), $this->config->item('site_title'));
					$this->email->to((($this->config->item('development_mode') == TRUE) ? $this->config->item('email_development') : $user->email));
					$this->email->subject($this->config->item('site_title') . ' - ' . $this->lang->line('email_forgotten_password_subject'));
					$this->email->message($message);

					if ($this->email->send())
					{
						$this->set_message('forgot_password_successful');
						return TRUE;
					}
					else
					{
						$this->set_error('forgot_password_unsuccessful');
						return FALSE;
					}
				}*/
			}
			else
			{
				$this->set_error('forgot_password_unsuccessful');
				return FALSE;
			}
		}
		else
		{
			$this->set_error('forgot_password_unsuccessful');
			return FALSE;
		}
	}

	/**
	 * forgotten_password_complete
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password_complete($code)
	{
		$this->ion_auth_model->trigger_events('pre_password_change');

		$identity = $this->config->item('identity');
		$profile  = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

		if (!$profile)
		{
			$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$new_password = $this->ion_auth_model->forgotten_password_complete($code, $profile->salt);

		if ($new_password)
		{
			$data = array(
				'identity'     => $profile->{$identity},
				'new_password' => $new_password,
				'users_first_name'  => $profile->users_first_name,
				'users_last_name'   => $profile->users_last_name,
			);
			if(!$this->config->item('use_ci_email'))
			{
				$this->set_message('password_change_successful');
				$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_successful'));
					return $data;
			}
			else
			{
				$mailSubject	= $this->config->item('site_title') . ' - ' . $this->lang->line('email_new_password_subject');
				$mailTemplates	= $this->session->userdata('themes').'/'.$this->config->item('email_templates').$this->config->item('email_forgot_password_complete');
				//$this->emails->sendEmail('Authentication System',$user->email,$mailSubject,$data,$mailTemplates);

		        if ($this->emails->sendEmail($this->config->item('site_title').' Authentication System',$profile->users_email,$mailSubject,$data,$mailTemplates) == TRUE)
		        {
					//$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
					$this->set_message('password_change_successful');
					return TRUE;
		        }
		        else
		        {
					//$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful'));
					$this->set_error('password_change_unsuccessful');
					return FALSE;
		        }
/*				$message = $this->load->view($this->config->item('email_templates').$this->config->item('email_forgot_password_complete'), $data, true);

				$this->email->clear();
				$this->email->from($this->config->item('admin_email'), $this->config->item('site_title'));
				$this->email->to((($this->config->item('development_mode') == TRUE) ? $this->config->item('email_development') : $profile->email));
				$this->email->subject($this->config->item('site_title') . ' - ' . $this->lang->line('email_new_password_subject'));
				$this->email->message($message);

				if ($this->email->send())
				{
					$this->set_message('password_change_successful');
					$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_successful'));
					return TRUE;
				}
				else
				{
					$this->set_error('password_change_unsuccessful');
					$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
					return FALSE;
				}*/

			}
		}

		$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
		return FALSE;
	}

	/**
	 * forgotten_password_check
	 *
	 * @return void
	 * @author Michael
	 **/
	public function forgotten_password_check($code)
	{
		$profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

		if (!is_object($profile))
		{
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}
		else
		{
			if ($this->config->item('forgot_password_expiration') > 0)
			{
				//Make sure it isn't expired
				$expiration = $this->config->item('forgot_password_expiration');
				if (time() - $profile->forgotten_password_time > $expiration)
				{
					//it has expired
					$this->clear_forgotten_password_code($code);
					$this->set_error('password_change_unsuccessful');
					return FALSE;
				}
			}
			return $profile;
		}
	}

	/**
	 * register
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function register($username, $password, $email, $additional_data = array(), $group_ids = array()) //need to test email activation
	{
		$this->ion_auth_model->trigger_events('pre_account_creation');

		$email_activation = $this->config->item('email_activation');

		if($password === $email)
		{
			$data['password']	= $password = $this->ion_auth->random_password($this->config->item('min_password_length','ion_auth'));
		}

		if (!$email_activation)
		{
			$id = $this->ion_auth_model->register($username, $password, $email, $additional_data, $group_ids);
			if ($id !== FALSE)
			{
				$this->set_message('account_creation_successful');
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful'));
				return $id;
			}
			else
			{
				$this->set_error('account_creation_unsuccessful');
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
				return FALSE;
			}
		}
		else
		{
			$id = $this->ion_auth_model->register($username, $password, $email, $additional_data, $group_ids);

			if (!$id)
			{
				$this->set_error('account_creation_unsuccessful');
				return FALSE;
			}

			$deactivate = $this->ion_auth_model->deactivate($id);

			if (!$deactivate)
			{
				$this->set_error('deactivate_unsuccessful');
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
				return FALSE;
			}

			$activation_code = $this->ion_auth_model->activation_code;
			$identity        = $this->config->item('identity');
			$user            = $this->ion_auth_model->user($id)->row();

			$data['identity']		= $user->{$identity};
			$data['id']				= $user->users_id;
			$data['email']			= (($this->config->item('development_mode') == TRUE) ? $this->config->item('email_development') : $email);
			$data['activation']		= $activation_code;
			$data['users_first_name']	= $user->users_first_name;
			$data['users_last_name']	= $user->users_last_name;

			$mailSubject	= $this->config->item('site_title') . ' - ' . $this->lang->line('email_activation_subject');
			$mailTemplates	= $this->session->userdata('themes').'/'.$this->config->item('email_templates').$this->config->item('email_activate');
			//$this->emails->sendEmail('Authentication System',$user->email,$mailSubject,$data,$mailTemplates);

	        //if ($this->emails->sendEmail($this->config->item('site_title').' Authentication System',$email,$mailSubject,$data,$mailTemplates) == TRUE)
	        //{
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
				$this->set_message('activation_email_successful');
				return $id;
	        //}
	        //else
	        //{
			//	$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful'));
			//	$this->set_error('activation_email_unsuccessful');
			//	return FALSE;
	        //}

			/*if(!$this->config->item('use_ci_email'))
			{
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
				$this->set_message('activation_email_successful');
					return $data;
			}
			else
			{
				$message = $this->load->view($this->config->item('email_templates').$this->config->item('email_activate'), $data, true);

				$this->email->clear();
				$this->email->from($this->config->item('admin_email'), $this->config->item('site_title'));
				$this->email->to($email);
				$this->email->subject($this->config->item('site_title') . ' - ' . $this->lang->line('email_activation_subject'));
				$this->email->message($message);

				if ($this->email->send() == TRUE)
				{
					$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
					$this->set_message('activation_email_successful');
					return $id;
				}

			}*/

			$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful'));
			$this->set_error('activation_email_unsuccessful');
			return FALSE;
		}
	}

	/**
	 * register
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function register2($username, $password, $email, $additional_data = array(), $group_ids = array()) //need to test email activation
	{
		$this->ion_auth_model->trigger_events('pre_account_creation');

		if($password === $email)
		{
			$data['password']	= $password = $this->ion_auth->random_password($this->config->item('min_password_length','ion_auth'));
		}

		$id = $this->ion_auth_model->register2($username, $password, $email, $additional_data, $group_ids);
		if ($id !== FALSE)
		{
			$this->set_message('account_creation_successful');
			$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful'));
			return $id;
		}
		else
		{
			$this->set_error('account_creation_unsuccessful');
			$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
			return FALSE;
		}
	}

	/**
	 * logout
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function logout()
	{
		$this->ion_auth_model->trigger_events('logout');
		$this->load->model('loginhistory_model','loginhistory');

		$identity = $this->config->item('identity');
		$sessId = session_id();

        if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->unset_userdata( array($identity => '', 'id' => '', 'users_id' => '') );
        }
        else
        {
        	$this->session->unset_userdata( array($identity, 'id', 'users_id') );
        }

		// delete the remember me cookies if they exist
		if (get_cookie($this->config->item('identity_cookie_name')))
		{
			delete_cookie($this->config->item('identity_cookie_name'));
		}
		if (get_cookie($this->config->item('remember_cookie_name')))
		{
			delete_cookie($this->config->item('remember_cookie_name'));
		}

		// Destroy the session
		$this->session->sess_destroy();
		$this->loginhistory->update_by(array('sessions_id'=>$sessId), array('time_logout'=>time()));

		//Recreate the session
		if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->sess_create();
		}
		else
		{
			if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
				session_start();
			}
			$this->session->sess_regenerate(TRUE);
		}

		$this->set_message('logout_successful');
		return TRUE;
	}

	/**
	 * logged_in
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function logged_in()
	{
		$this->ion_auth_model->trigger_events('logged_in');

		return (bool) $this->session->userdata('identity');
	}

	public function user_session_reset()
	{
		$this->ion_auth_model->reset_user_session();
	}

	/**
	 * is_locked
	 *
	 * @return bool
	 * @author Lucky Mahrus
	 **/
	public function is_locked()
	{
		$this->ion_auth_model->trigger_events('is_locked');

		return (bool) $this->session->userdata('locked');
	}

	/**
	 * logged_in
	 *
	 * @return integer
	 * @author jrmadsen67
	 **/
	public function get_user_id()
	{
		$user_id = $this->session->userdata('users_id');
		if (!empty($user_id))
		{
			return $user_id;
		}
		return null;
	}


	/**
	 * is_admin
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function is_admin($id=false)
	{
		$this->ion_auth_model->trigger_events('is_admin');

		$admin_group = $this->config->item('admin_group');

		return $this->in_group($admin_group, $id);
	}


	/**
	 * is_admin
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function is_superuser($id=false)
	{
		$this->ion_auth_model->trigger_events('is_superuser');

		$superadmin_group = $this->config->item('superadmin_group');

		return $this->in_group($superadmin_group, $id);
	}

	/**
	 * in_group
	 *
	 * @param mixed group(s) to check
	 * @param bool user id
	 * @param bool check if all groups is present, or any of the groups
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function in_group($check_group, $id=false, $check_all = false)
	{
		$this->ion_auth_model->trigger_events('in_group');

		$id || $id = $this->session->userdata('users_id');

		if (!is_array($check_group))
		{
			$check_group = array($check_group);
		}

		if (isset($this->_cache_user_in_group[$id]))
		{
			$groups_array = $this->_cache_user_in_group[$id];
		}
		else
		{
			$users_groups = $this->ion_auth_model->get_users_groups($id)->result();
			$groups_array = array();
			foreach ($users_groups as $group)
			{
				$groups_array[$group->groups_id] = $group->groups_name;
			}
			$this->_cache_user_in_group[$id] = $groups_array;
		}
		foreach ($check_group as $key => $value)
		{
			$groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

			/**
			 * if !all (default), in_array
			 * if all, !in_array
			 */
			if (in_array($value, $groups) xor $check_all)
			{
				/**
				 * if !all (default), true
				 * if all, false
				 */
				return !$check_all;
			}
		}

		/**
		 * if !all (default), false
		 * if all, true
		 */
		return $check_all;
	}

	function random_password($length=8)
	{
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}

    /*protected function sendEmail($sender,$email,$subject,$data,$template,$attachment=null)
    {return true;
        $email_config = $this->config->item('email_config');

        $email_config['protocol']   = 'smtp';
        $email_config['smtp_host']  = 'ssl://smtp.googlemail.com';
        $email_config['smtp_port']  = 465;
        $email_config['smtp_user']  = 'u.digital.magnetic@gmail.com';
        $email_config['smtp_pass']  = 'd161t4lm@gn3t1c';
        $email_config['mailtype']   = 'html';
        $email_config['charset']    = 'iso-8859-1';

        $this->load->library('email', $email_config);

        $this->email->attach(FCPATH.'assets/default/images/background/bg-header-mail-zat412.jpg');

        $data['header'] = $this->email->attachment_cid(FCPATH.'assets/default/images/background/bg-header-mail-zat412.jpg');

        $message = $this->load->view($template, $data, true);

        $this->email->clear();
        $this->email->set_mailtype($email_config['mailtype']);
        $this->email->set_newline($email_config['newline']);
        $this->email->from('no-reply@'.$_SERVER['HTTP_HOST'], $sender);
        //$this->email->to((($this->config->item('development_mode') == TRUE) ? $this->config->item('email_development') : $email));
       	//$this->email->to('lukman@u-digital.nl,mahrus.lukmanhakim@gmail.com');
       	$this->email->to('lukman@u-digital.nl,barbara@u-digital.nl');
        //$this->email->cc('ayun@u-digital.nl');
        //$this->email->cc('sam@u-digital.nl');
        //$this->email->cc('barbara@u-digital.nl');
        $this->email->subject($subject);
        $this->email->message($message);

        if(!is_null($attachment))
        {
            if(is_array($attachment))
            {
                foreach ($attachment as $key)
                {
                    $this->email->attach($key);
                }
            }
            else
            {
                $this->email->attach($attachment);
            }
        }

        return $this->email->send();
    }*/
}
