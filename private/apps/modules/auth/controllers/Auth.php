<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Auth.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/auth/controllers/Auth.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Auth extends APP_Controller
{
	protected	$identity;

	public function __construct()
	{
		parent::__construct();

		$this->identity 	= $this->config->item('identity', 'ion_auth');

		//$this->layout	= FALSE;
	}

	public function index()
	{

    }

	function forgot_password()
	{
		$identity = (($this->identity == 'users_username') ? 'users_username' : 'users_email');

		if($this->input->method() == 'post')
		{
		    $this->form_validation->set_rules($identity, $this->lang->line('label_input_'.$identity), 'trim|required'.(($identity == 'users_email') ? '|valid_email' : ''));
		    $this->form_validation->set_rules('customerId', $this->lang->line('label_input_customerId'), 'trim');

			if ($this->form_validation->run() == false)
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			}
			else
			{
				$identities = $this->ion_auth->where($identity, strtolower($this->input->post($identity)))->users()->row();

	        	if(empty($identities) || (!empty($identities->customerId) && !is_null($identities->customerId) && $identities->customerId <> $this->input->post('customerId')))
	        	{
	        		$this->data['message']	= $authData['message'] = array('class'=>'danger','icon'=>'times','status'=>'error','text'=>'User not found');
					$this->session->set_flashdata($authData);
					//redirect(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), 'refresh');
	    		}
	    		else
	    		{
					//run the forgotten password method to email an activation code to the user
					$forgotten = $this->ion_auth->forgotten_password($identities->{$identity});

					if ($forgotten)
					{
						//if there were no errors
						$this->data['message']	= $authData['message'] = array('class'=>'success','icon'=>'check','status'=>'success','text'=>$this->ion_auth->messages());
						$this->session->set_flashdata($authData);
						redirect(links_url(array('class'=>$this->router->class,'method'=>'login')), 'refresh');
					}
					else
					{
						$this->data['message']	= $authData['message'] = array('class'=>'danger','icon'=>'times','status'=>'error','text'=>$this->ion_auth->errors());
						$this->session->set_flashdata($authData);
						redirect(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), 'refresh');
					}
	    		}
			}
		}

		$this->data[$identity]				= array(
													'name'			=> $identity,
													'id'			=> $identity,
													'type'			=> (($identity == 'users_email') ? 'email' : 'text'),
													'required'		=> 'required',
													'label'			=> $this->lang->line('label_input_'.$identity),
													'placeholder'	=> $this->lang->line('placeholder_input_'.$identity),
													'title'			=> $this->lang->line('title_input_'.$identity),
													'value'			=> $this->form_validation->set_value($identity, $this->input->post($identity)),
												);
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			$this->form_validation->set_rules('new', $this->lang->line('label_input_new_password'), 'trim|required|min_length[' . $this->config->item('min_password_length') . ']|max_length[' . $this->config->item('max_password_length') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('label_input_new_password_confirm'), 'trim|required');

			if ($this->form_validation->run() == false)
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length');
				$this->data['new_password']		= array(
														'name'			=> 'new',
														'id'			=> 'new',
														'type'			=> 'password',
														'required'		=> 'required',
														'placeholder'	=> $this->lang->line('placeholder_input_new_password'),
														'title'			=> sprintf($this->lang->line('title_input_new_password'),$this->config->item('min_password_length'),$this->config->item('max_password_length')),
														'value'			=> $this->form_validation->set_value('new', $this->input->get_post('new')),
														'pattern' 		=> '^.{'.$this->data['min_password_length'].'}.*$',
													);
				$this->data['new_password_confirm']		= array(
														'name'			=> 'new_confirm',
														'id'			=> 'new_confirm',
														'type'			=> 'password',
														'required'		=> 'required',
														'placeholder'	=> $this->lang->line('placeholder_input_new_password_confirm'),
														'title'			=> $this->lang->line('title_input_new_password_confirm'),
														'value'			=> $this->form_validation->set_value('new_confirm', $this->input->get_post('new_confirm')),
														'pattern' 		=> '^.{'.$this->data['min_password_length'].'}.*$',
													);
				$this->data['users_id'] = $user->users_id;
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;
			}
			else
			{
				//if ($this->_valid_csrf_nonce() === FALSE || $user->users_id != $this->input->post('users_id'))
				if ($user->users_id != $this->input->post('users_id'))
				{
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					$identity = $user->{$this->config->item('identity')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect(links_url(array('class'=>$this->router->class,'method'=>'reset_password')), 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect(links_url(array('class'=>$this->router->class,'method'=>'forgot_password')), 'refresh');
		}
	}

	//reset password - final step for forgotten password
	public function reset_password2($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['users_id'] = array(
					'name'  => 'users_id',
					'id'    => 'users_id',
					'type'  => 'hidden',
					'value' => $user->users_id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->users_id != $this->input->post('users_id'))
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect(links_url(array('class'=>$this->router->class,'method'=>'reset_password')), 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect(links_url(array('class'=>$this->router->class,'method'=>'forgot_password')), 'refresh');
		}
	}

	public function login_dev()
	{
		$this->data['page_title'] = "Developer Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			if ($this->ion_auth->login_dev($this->input->post('identity'), $this->input->post('password')))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', array('class'=>'success','icon'=>'fa-check','status'=>'Success!','text'=>$this->ion_auth->messages()));
				redirect(links_url(array('class'=>$this->router->class,'method'=>'login')), 'refresh');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', array('class'=>'danger','icon'=>'fa-times','status'=>'Error!','text'=>$this->ion_auth->errors()));
				redirect(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), 'refresh');
			}
		}
		//the user is not logging in so display the login page
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		$identity = (($this->identity == 'users_username') ? 'users_username' : 'users_email');
		$this->data['identity']	= array(
											'name'			=> 'identity',
											'id'			=> 'identity',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_'.$identity.'_dev'),
											'placeholder'	=> $this->lang->line('placeholder_input_'.$identity.'_dev'),
											'title'			=> $this->lang->line('title_input_'.$identity.'_dev'),
											'value'			=> $this->form_validation->set_value('identity', (($this->session->flashdata('identity')) ? $this->session->flashdata('identity') : $this->input->get_post('identity')))
										);

		$this->data['password']	= array(
											'name'			=> 'password',
											'id'			=> 'password',
											'type'			=> 'password',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_password_dev'),
											'placeholder'	=> $this->lang->line('placeholder_input_password_dev'),
											'title'			=> $this->lang->line('title_input_password_dev'),
											'value'			=> $this->form_validation->set_value('password', (($this->session->flashdata('password')) ? $this->session->flashdata('password') : $this->input->get_post('password')))
										);
    }

	public function login()
	{
		//$this->data['page_title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			//check to see if the user is logging in
			//check for "remember me"
			$remember = $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				if ( $this->ion_auth->is_otp_set( $this->input->post('identity') ) )
				{
					$activation_code = $this->ion_auth->set_otp_login_activation($this->input->post('identity'));
					if($activation_code)
					{
						$this->session->set_flashdata('otp_login_key', $activation_code);
						$this->session->set_flashdata('identity', $this->input->post('identity'));
						$this->session->set_flashdata('remember', $remember);
						redirect(links_url(array('class'=>$this->router->class,'method'=>'login_otp')), 'refresh');
					}
					else
					{
						//if the set activation was un-successful
						//redirect them back to the login page
						$this->session->set_flashdata('message', array('class'=>'danger','icon'=>'fa-times','status'=>'Error!','text'=>$this->ion_auth->errors()));
						redirect(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), 'refresh');
					}
				}
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', array('class'=>'success','icon'=>'fa-check','status'=>'Success!','text'=>$this->ion_auth->messages()));
				redirect(secure_url(), 'refresh');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', array('class'=>'danger','icon'=>'fa-times','status'=>'Error!','text'=>$this->ion_auth->errors()));
				redirect(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), 'refresh');
			}
		}
		//the user is not logging in so display the login page
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		$identity = (($this->identity == 'users_username') ? 'users_username' : 'users_email');
		$this->data['identity']	= array(
											'name'			=> 'identity',
											'id'			=> 'identity',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_'.$identity),
											'placeholder'	=> $this->lang->line('placeholder_input_'.$identity),
											'title'			=> $this->lang->line('title_input_'.$identity),
											'value'			=> $this->form_validation->set_value('identity', (($this->session->flashdata('identity')) ? $this->session->flashdata('identity') : $this->input->get_post('identity')))
										);

		$this->data['password']	= array(
											'name'			=> 'password',
											'id'			=> 'password',
											'type'			=> 'password',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_password'),
											'placeholder'	=> $this->lang->line('placeholder_input_password'),
											'title'			=> $this->lang->line('title_input_password'),
											'value'			=> $this->form_validation->set_value('password', (($this->session->flashdata('password')) ? $this->session->flashdata('password') : $this->input->get_post('password')))
										);
    }

	function login_otp()
	{
		//$this->data['page_title'] = "Login";

		//validate form input

		if($this->input->method() == 'post')
		{
			$this->form_validation->set_rules('token'			, 'Token', 'required');
			$this->form_validation->set_rules('identity'		, 'Identity');
			$this->form_validation->set_rules('otp_login_key'	, 'Login key');
			$this->form_validation->set_rules('remember'		, 'Remember Me');
			if ($this->form_validation->run() == true)
			{
				$remember = (bool) $this->input->post('remember');

				if ($this->ion_auth->is_otp_set($this->input->post('identity')))
				{
					if ($this->ion_auth->otp_login($this->input->post('identity'), $this->input->post('token'), $remember, $this->input->post('otp_login_key')))
					{
						//if the login is successful
						//redirect them back to the home page
						$this->session->set_flashdata('message', array('class'=>'success','icon'=>'fa-check','status'=>'Success!','text'=>$this->ion_auth->messages()));
						redirect(secure_url(), 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', array('class'=>'danger','icon'=>'fa-times','status'=>'Error!','text'=>$this->ion_auth->errors()));
						redirect(links_url(array('class'=>$this->router->class,'method'=>'login')), 'refresh');
					}
				}
				else
				{
					$this->session->set_flashdata('message', array('class'=>'danger','icon'=>'fa-times','status'=>'Error!','text'=>$this->ion_auth->errors()));
					redirect(links_url(array('class'=>$this->router->class,'method'=>'login')), 'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('message', array('class'=>'danger','icon'=>'fa-times','status'=>'Error!','text'=>validation_errors()));
				redirect(links_url(array('class'=>$this->router->class,'method'=>'login')), 'refresh');
			}
		}
		else
		{
			if(!$this->session->flashdata('otp_login_key'))
			{
				redirect(links_url(array('class'=>$this->router->class,'method'=>'login')), 'refresh');
			}
		}
		//the user is not logging in so display the login page
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		$this->data['token']			= array(
												'name'			=> 'token',
												'id'			=> 'token',
												'type'			=> 'text',
												'required'		=> 'required',
												'label'			=> $this->lang->line('label_input_token'),
												'placeholder'	=> $this->lang->line('placeholder_input_token'),
												'title'			=> $this->lang->line('title_input_token'),
											);

		$this->data['identity'] 		= array('identity' => $this->session->flashdata('identity'));
		$this->data['remember'] 		= array('remember' => $this->session->flashdata('remember_me'));
		$this->data['otp_login_key'] 	= array('otp_login_key' => $this->session->flashdata('otp_login_key'));
	}

	public function logout()
	{
		$this->data['page_title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', array('class'=>'success','icon'=>'fa-check','status'=>'Success!','text'=>$this->ion_auth->messages()));
		redirect(links_url(array('class'=>$this->router->class,'method'=>'login')), 'refresh');
	}

	public function unlock()
	{
		$this->layout	= FALSE;

		$this->data['page_title'] = "Unlock";

		//validate form input
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			if ($this->ion_auth->login($this->session->userdata('identity'), $this->input->post('password')))
			{
				$this->session->set_flashdata('message', array('class'=>'success','icon'=>'fa-check','status'=>'Success!','text'=>$this->ion_auth->messages()));
				redirect(secure_url(), 'refresh');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', array('class'=>'danger','icon'=>'fa-times','status'=>'Error!','text'=>$this->ion_auth->errors()));
				redirect(links_url(array('class'=>$this->router->class,'method'=>'locked')), 'refresh');
			}
		}
		//the user is not logging in so display the login page
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		$this->data['identity']		= array(
												'name'			=> 'identity',
												'id'			=> 'identity',
												'type'			=> 'text',
												'required'		=> 'required',
												'placeholder'	=> $this->lang->line('login_identity_label'),
												'title'			=> $this->lang->line('login_identity_label'),
												'value'			=> $this->form_validation->set_value('identity', ((isset($postData['postTitle'])) ? $postData['postTitle'] : $this->input->get_post('postTitle'))),
											);

		$this->data['password']		= array(
												'name'			=> 'password',
												'id'			=> 'password',
												'type'			=> 'text',
												'required'		=> 'required',
												'placeholder'	=> $this->lang->line('login_password_label'),
												'title'			=> $this->lang->line('login_password_label'),
												'value'			=> $this->form_validation->set_value('password', ((isset($postData['postTitle'])) ? $postData['postTitle'] : $this->input->get_post('postTitle'))),
											);
    }

	public function locked()
	{
		if(!$this->ion_auth->logged_in())
		{
			redirect(links_url(array('class'=>$this->router->class,'method'=>'login')), 'refresh');
		}

		$this->layout	= FALSE;

		$this->data['page_title'] = "Locked";

		//validate form input
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			if ($this->ion_auth->login($this->session->userdata('identity'), $this->input->post('password')))
			{
				$this->session->unset_userdata('locked');
				$this->session->set_flashdata('message', array('class'=>'success','icon'=>'fa-check','status'=>'Success!','text'=>$this->ion_auth->messages()));
				redirect(secure_url(), 'refresh');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', array('class'=>'danger','icon'=>'fa-times','status'=>'Error!','text'=>$this->ion_auth->errors()));
				redirect(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), 'refresh');
			}
		}
		//the user is not logging in so display the login page
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		$this->data['password']		= array(
												'name'			=> 'password',
												'id'			=> 'password',
												'type'			=> 'text',
												'required'		=> 'required',
												'placeholder'	=> $this->lang->line('login_password_label'),
												'title'			=> $this->lang->line('login_password_label'),
												'value'			=> $this->form_validation->set_value('password', ''),
											);
    }

	public function lock()
	{
		if(!$this->ion_auth->logged_in())
		{
			redirect(links_url(array('class'=>$this->router->class,'method'=>'login')), 'refresh');
		}

		$this->session->set_userdata('locked',TRUE);

		redirect(links_url(array('class'=>$this->router->class,'method'=>'locked')), 'refresh');
    }


	public function activate($id, $code=false)
	{
		$this->layout 	= FALSE;
		$this->view 	= FALSE;
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if (isset($activation) && $activation == TRUE)
		{
			$this->data['message']	= $authData['message'] = array('class'=>'success','icon'=>'uk-icon uk-icon-check','status'=>'success','text'=>$this->ion_auth->messages());
			$this->session->set_flashdata($authData);
			redirect(links_url(array('class'=>'auth','method'=>'login')), 'refresh');
		}
		else
		{
			$this->data['message']	= $authData['message'] = array('class'=>'danger','icon'=>'uk-icon uk-icon-times','status'=>'error','text'=>$this->ion_auth->errors());
			$this->session->set_flashdata($authData);
			redirect(links_url(array('class'=>'auth','method'=>'forgot_password')), 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
		}
	}

	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('users_id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect(links_url(array('class'=>'auth','method'=>'logout')), 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
		}
	}

}


/* End of file Auth.php */
/* Location: private/apps/modules/auth/controllers/Auth.php */


