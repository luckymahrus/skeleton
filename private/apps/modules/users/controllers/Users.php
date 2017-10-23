<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Users.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/users/controllers/Users.php
 * created		: 2017 September 25th / 08:00:00
 * last edit	: 2017 September 25th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Users extends APP_Controller
{
	protected $models = array('users','groups','usersgroups');

	public function __construct()
	{
		parent::__construct();
		$this->data['allow_reset'] 	= $this->custom_auth->is_allowed_to($this->router->class,'reset_password');
	}

	public function index()
	{

    }

	public function get()
	{
		if(@$this->input->get_post('format') == 'datatables')
		{
			$response 	= $this->users->datatables();
		}
		else
		{
			$response 	= $this->users->get_all();
		}

		if (!$this->input->is_ajax_request())
		{
			return $response;
		}
		else
		{
			$this->ajax_json_response($response,(($response && count($response['data']) > 0) ? 200 : 404));
		}
    }

	public function detail($id=NULL)
	{
		if($this->input->is_ajax_request())
		{
			$this->layout = FALSE;
			//$this->view = 'detail_ajax';
		}

		$this->_form_input();

		if($id === NULL)
		{
			show_404();exit;
		}

		$user = $this->users->get($id);

		if($user)
		{
			$groups 		= $this->usersgroups->get_by(array('users_id'=>$id));

			$this->data['user']	= $user;
			$this->data['users_id']	= $user->users_id;

			$this->data['users_first_name']['value'] 	= $this->form_validation->set_value('users_first_name', (($this->session->flashdata('users_first_name')) ? $this->session->flashdata('users_first_name') : ((isset($user->users_first_name)) ? $user->users_first_name : $this->input->get_post('users_first_name'))));
			$this->data['users_last_name']['value'] 	= $this->form_validation->set_value('users_last_name', (($this->session->flashdata('users_last_name')) ? $this->session->flashdata('users_last_name') : ((isset($user->users_last_name)) ? $user->users_last_name : $this->input->get_post('users_last_name'))));
			$this->data['users_email']['value'] 		= $this->form_validation->set_value('users_email', (($this->session->flashdata('users_email')) ? $this->session->flashdata('users_email') : ((isset($user->users_email)) ? $user->users_email : $this->input->get_post('users_email'))));
			$this->data['groups_id']['selected'] 		= $this->form_validation->set_value('groups_id', (($this->session->flashdata('groups_id')) ? $this->session->flashdata('groups_id') : ((isset($groups->groups_id)) ? $groups->groups_id : $this->input->get_post('groups_id'))));
			$this->data['status']['selected']			= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($user->status)) ? $user->status : $this->input->get_post('status'))));
	    }
		else
		{
			show_404();exit;
		}
    }

	public function get_detail()
	{

    }

	public function add()
	{
		if($this->input->is_ajax_request())
		{
			$this->layout = FALSE;
			//$this->view = 'add_ajax';
		}

		$this->_form_input();

		if($this->input->method() == 'post')
		{
			$this->data['message']	= $responses['message'] = $this->insert();

			if(!$this->input->is_ajax_request())
			{
				$this->session->set_flashdata($responses);
				if(isset($responses['message']['status']) && $responses['message']['status'] == 'success')
				{
					redirect(links_url(array('class'=>$this->router->class,'method'=>'index')), 'refresh');
				}
			}
			else
			{
				$this->ajax_json_response($responses,$responses['message']['code']);
			}
		}

		$this->data['users_first_name']['value'] 	= $this->form_validation->set_value('users_first_name', (($this->session->flashdata('users_first_name')) ? $this->session->flashdata('users_first_name') : $this->input->get_post('users_first_name')));
		$this->data['users_last_name']['value'] 	= $this->form_validation->set_value('users_last_name', (($this->session->flashdata('users_last_name')) ? $this->session->flashdata('users_last_name') : $this->input->get_post('users_last_name')));
		$this->data['users_email']['value'] 		= $this->form_validation->set_value('users_email', (($this->session->flashdata('users_email')) ? $this->session->flashdata('users_email') : $this->input->get_post('users_email')));
		$this->data['groups_id']['selected'] 		= $this->form_validation->set_value('groups_id', (($this->session->flashdata('groups_id')) ? $this->session->flashdata('groups_id') : $this->input->get_post('groups_id')));
    }

	public function insert()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$sqlData['users_first_name']	= $data['users_first_name'];
			$sqlData['users_last_name']		= $data['users_last_name'];
			$sqlData['users_email']			= $data['users_email'];
			$sqlData['users_username']		= $data['users_email'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('users_first_name', $this->lang->line('label_input_users_first_name'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('users_last_name', $this->lang->line('label_input_users_last_name'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('users_email', $this->lang->line('label_input_users_email'), 'trim|required|is_unique[users.users_email]|valid_email');
	        $this->form_validation->set_rules('groups_id', $this->lang->line('label_input_groups_id'), 'trim|required|numeric|callback__group_check');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$usersUsername = $sqlData['users_username'];	unset($sqlData['users_username']);
				$usersEmail    = $sqlData['users_email'];		unset($sqlData['users_email']);
				$usersPassword = $usersEmail;

				$groups 	= array((int)$data['groups_id']);

				$insert 	= $this->ion_auth->register($usersUsername, $usersPassword, $usersEmail, $sqlData, $groups);

		        if($insert)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>$this->ion_auth->messages());
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>$this->ion_auth->errors());
				}
			}
			else
			{
				if(form_error('users_first_name',' ',' ') <> ''){ $alert['users_first_name']	= form_error('users_first_name',' ',' '); }
				if(form_error('users_last_name',' ',' ') <> '')	{ $alert['users_last_name']		= form_error('users_last_name',' ',' '); 	}
				if(form_error('users_email',' ',' ') <> '')		{ $alert['users_email']			= form_error('users_email',' ',' '); 		}
				if(form_error('groups_id',' ',' ') <> '')		{ $alert['groups_id']			= form_error('groups_id',' ',' '); 		}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add user!');
	    }
    }

	public function edit($id=NULL)
	{
		if($this->input->is_ajax_request())
		{
			$this->layout = FALSE;
			$this->view = 'edit_ajax';
		}

		$this->_form_input();

		if($this->input->method() == 'post')
		{
			$this->data['message']	= $responses['message'] = $this->update();

			if(!$this->input->is_ajax_request())
			{
				$this->session->set_flashdata($responses);
				if(isset($responses['message']['status']) && $responses['message']['status'] == 'success')
				{
					redirect(links_url(array('class'=>$this->router->class,'method'=>'index')), 'refresh');
				}
			}
			else
			{
				$this->ajax_json_response($responses,$responses['message']['code']);
			}
		}

		if((!isset($responses['message']['code']) && $id === NULL) || ($id !== NULL && $id === $this->session->userdata('users_id')))
		{
			show_404();exit;
		}

		$user = $this->users->get($id);

		if($user)
		{
			$groups 		= $this->usersgroups->get_by(array('users_id'=>$id));

			$this->data['user']	= $user;
			$this->data['users_id']	= $user->users_id;

			$this->data['users_first_name']['value'] 	= $this->form_validation->set_value('users_first_name', (($this->session->flashdata('users_first_name')) ? $this->session->flashdata('users_first_name') : ((isset($user->users_first_name)) ? $user->users_first_name : $this->input->get_post('users_first_name'))));
			$this->data['users_last_name']['value'] 	= $this->form_validation->set_value('users_last_name', (($this->session->flashdata('users_last_name')) ? $this->session->flashdata('users_last_name') : ((isset($user->users_last_name)) ? $user->users_last_name : $this->input->get_post('users_last_name'))));
			$this->data['users_email']['value'] 		= $this->form_validation->set_value('users_email', (($this->session->flashdata('users_email')) ? $this->session->flashdata('users_email') : ((isset($user->users_email)) ? $user->users_email : $this->input->get_post('users_email'))));
			$this->data['groups_id']['selected'] 		= $this->form_validation->set_value('groups_id', (($this->session->flashdata('groups_id')) ? $this->session->flashdata('groups_id') : ((isset($groups->groups_id)) ? $groups->groups_id : $this->input->get_post('groups_id'))));
			$this->data['status']['selected']			= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($user->status)) ? $user->status : $this->input->get_post('status'))));
	    }
		else
		{
			show_404();exit;
		}
    }

	public function update()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$users = $this->users->get($data['id']);

			$sqlData['users_first_name']	= $data['users_first_name'];
			$sqlData['users_last_name']		= $data['users_last_name'];
			$sqlData['users_email']			= $data['users_email'];
			$sqlData['users_username']		= $data['users_email'];
			$sqlData['status']				= $data['status'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('users_first_name', 	$this->lang->line('label_input_users_first_name'), 	'trim|required|max_length[50]');
	        $this->form_validation->set_rules('users_last_name', 	$this->lang->line('label_input_users_last_name'), 	'trim|required|max_length[50]');
	        $this->form_validation->set_rules('users_email', 		$this->lang->line('label_input_users_email'), 		'trim|required|'.(($users->users_email <> $data['users_email']) ? 'is_unique[users.users_email]|' : '').'valid_email');
	        $this->form_validation->set_rules('groups_id', 			$this->lang->line('label_input_groups_id'), 		'trim|required|numeric|callback__group_check');
	        $this->form_validation->set_rules('status', 			$this->lang->line('label_input_status'), 			'trim|required|numeric');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$groupsId	= (int)$data['groups_id'];

				if($data['users_email'] == $users->users_email){ unset($sqlData['users_email']); }

				$update		= $this->users->update($users->users_id,$sqlData);

		        if($update)
				{
					$this->usersgroups->update_by(array('users_id'=>$users->users_id),array('groups_id'=>$groupsId));

					if($this->data['allow_reset'] && $data['reset_password'] == '1')
					{
						$reset = $this->_reset_password($users->users_id);
					}

	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'User data updated!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update user!');
				}
			}
			else
			{
				if(form_error('users_first_name',' ',' ') <> ''){ $alert['users_first_name']	= form_error('users_first_name',' ',' '); 	}
				if(form_error('users_last_name',' ',' ') <> '')	{ $alert['users_last_name']		= form_error('users_last_name',' ',' '); 	}
				if(form_error('users_email',' ',' ') <> '')		{ $alert['users_email']			= form_error('users_email',' ',' '); 		}
				if(form_error('groups_id',' ',' ') <> '')		{ $alert['groups_id']			= form_error('groups_id',' ',' '); 			}
				if(form_error('status',' ',' ') <> '')			{ $alert['status']				= form_error('status',' ',' '); 			}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add user!');
	    }
    }

	public function activate()
	{
		if($this->input->method() == 'post')
		{
			$id = $this->input->post('id');

			if($this->input->post('id') === NULL || $id === $this->session->userdata('users_id'))
			{
				show_404();exit;
			}

			$this->data['message']	= $responses['message'] = $this->_change_status($id,1);

			if(!$this->input->is_ajax_request())
			{
				$this->session->set_flashdata($responses);
				if(isset($responses['message']['status']) && $responses['message']['status'] == 'success')
				{
					redirect(links_url(array('class'=>$this->router->class,'method'=>'index')), 'refresh');
				}
			}
			else
			{
				$this->ajax_json_response($responses,$responses['message']['code']);
			}
		}
		else
		{
			show_404();exit;
		}
    }

	public function deactivate()
	{
		if($this->input->method() == 'post')
		{
			$id = $this->input->post('id');

			if($this->input->post('id') === NULL || $id === $this->session->userdata('users_id'))
			{
				show_404();exit;
			}

			$this->data['message']	= $responses['message'] = $this->_change_status($id,0);

			if(!$this->input->is_ajax_request())
			{
				$this->session->set_flashdata($responses);
				if(isset($responses['message']['status']) && $responses['message']['status'] == 'success')
				{
					redirect(links_url(array('class'=>$this->router->class,'method'=>'index')), 'refresh');
				}
			}
			else
			{
				$this->ajax_json_response($responses,$responses['message']['code']);
			}
		}
		else
		{
			show_404();exit;
		}
    }

	private function _change_status($id=NULL,$status=0)
	{
		if($id === NULL || $id === $this->session->userdata('users_id'))
		{
			show_404();exit;
		}

		switch($status)
		{
			case 0 :
						$textSuccess 	= 'User deactivated!';
						$textFailed		= 'Failed to deactivate user!';
						break;
			case 1 :
						$textSuccess 	= 'User Activated!';
						$textFailed		= 'Failed to activate user!';
						break;
			case 2 :
						$textSuccess 	= 'User archived!';
						$textFailed		= 'Failed to archive user!';
						break;
			case 3 :
						$textSuccess 	= 'User blocked!';
						$textFailed		= 'Failed to block user!';
						break;
			default :
						$textSuccess 	= 'User status updated!';
						$textFailed		= 'Failed to change user status!';
						break;
		}

		$user	= $this->users->get_by(array('users_id'=>$id));

		if($user)
		{
			$sqlData['status'] 				= $status;
			$sqlData['users_activation_code']	= NULL;

			$update 	= $this->users->update($user->users_id,$sqlData);

			if ($update)
			{
        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>$textSuccess);
			}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>$textFailed);
    }

	public function delete()
	{
		if($this->input->method() == 'post')
		{
			$id = $this->input->post('id');

			if($this->input->post('id') === NULL || $id === $this->session->userdata('users_id'))
			{
				show_404();exit;
			}

			$this->data['message']	= $responses['message'] = $this->_delete($id);

			if(!$this->input->is_ajax_request())
			{
				$this->session->set_flashdata($responses);
				redirect(links_url(array('class'=>$this->router->class,'method'=>'index')), 'refresh');
			}
			else
			{
				$this->ajax_json_response($responses,$responses['message']['code']);
			}

		}
		else
		{
			show_404();exit;
		}
    }

	private function _delete($id=NULL)
	{
		if($id === NULL || $id === $this->session->userdata('users_id'))
		{
			show_404();exit;
		}

		$user	= $this->users->get_by(array('users_id'=>$id));

		if($user)
		{
			$sqlData['users_id'] 				= NULL;
			$sqlData['users_ip_address'] 		= NULL;
			$sqlData['users_username'] 			= NULL;
			$sqlData['users_password'] 			= NULL;
			$sqlData['users_password_ori'] 		= NULL;
			$sqlData['users_otp'] 				= NULL;
			$sqlData['users_otp_login_code'] 	= NULL;
			$sqlData['users_otp_backup_codes'] 	= NULL;
			$sqlData['users_salt'] 				= NULL;
			$sqlData['users_email'] 			= NULL;
			$sqlData['users_activation_code'] 	= NULL;
			$sqlData['forgotten_password_code'] = NULL;
			$sqlData['forgotten_password_time'] = NULL;
			$sqlData['remember_code'] 			= NULL;
			$sqlData['users_last_login'] 		= NULL;
			$sqlData['status'] 					= 10;
			$sqlData['is_deleted'] 				= 1;

			$delete 	= $this->users->update($user->users_id,$sqlData);

			if ($delete)
			{
				$this->usersgroups->delete_by(array('users_id'=>$user->users_id));

        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'User successfully removed!');
			}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed user!');
    }

	public function reset_password()
	{
		if($this->input->method() == 'post')
		{
			$id = $this->input->post();

			if($this->input->post('id') === NULL || $id === $this->session->userdata('users_id'))
			{
				show_404();exit;
			}

			$this->data['message']	= $responses['message'] = $this->_reset_password($id);

			if(!$this->input->is_ajax_request())
			{
				$this->session->set_flashdata($responses);
				redirect(links_url(array('class'=>$this->router->class,'method'=>'index')), 'refresh');
			}
			else
			{
				$this->ajax_json_response($responses,$responses['message']['code']);
			}

		}
		else
		{
			show_404();exit;
		}
    }

	private function _reset_password($id=NULL)
	{
		if($id === NULL || $id === $this->session->userdata('users_id'))
		{
			show_404();exit;
		}

		$user	= $this->users->get_by(array('users_id'=>$id));
		if($user)
		{
			$identity = $user->{$this->config->item('identity','ion_auth')};

			$forgotten = $this->ion_auth->forgotten_password($identity);

			if ($forgotten)
			{
        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'User password successfully reset!');
			}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to reset user password!');
    }

    private function _form_input()
    {
		$this->data['users_first_name']	= array(
											'name'			=> 'users_first_name',
											'id'			=> 'users_first_name',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_users_first_name'),
											'placeholder'	=> $this->lang->line('placeholder_input_users_first_name'),
											'title'			=> $this->lang->line('title_input_users_first_name'),
										);

		$this->data['users_last_name']	= array(
											'name'			=> 'users_last_name',
											'id'			=> 'users_last_name',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_users_last_name'),
											'placeholder'	=> $this->lang->line('placeholder_input_users_last_name'),
											'title'			=> $this->lang->line('title_input_users_last_name'),
										);

		$this->data['users_email']		= array(
											'name'			=> 'users_email',
											'id'			=> 'users_email',
											'type'			=> 'email',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_users_email'),
											'placeholder'	=> $this->lang->line('placeholder_input_users_email'),
											'title'			=> $this->lang->line('title_input_users_email'),
										);

		$groups 		= $this->groups->get_all();
		$groupData	= array();
		if($groups && count($groups) > 0)
		{
			foreach ($groups as $idxO => $group)
			{
				if($this->ion_auth->is_superuser() || (!$this->ion_auth->is_superuser() && $group->groups_name <> $this->config->item('superadmin_group','ion_auth') && $group->groups_internal == TRUE))
				{
					$groupData[$group->groups_id]	= $group->groups_description;
				}
			}
		}
		$this->data['groups_id']	= array(
											'name'			=> 'groups_id',
											'id'			=> 'groups_id',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_groups_id'),
											'placeholder'	=> $this->lang->line('placeholder_input_groups_id'),
											'title'			=> $this->lang->line('title_input_groups_id'),
											'data'			=> $groupData,
										);

		$this->data['status']	= array(
											'name'			=> 'status',
											'id'			=> 'status',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_status'),
											'placeholder'	=> $this->lang->line('placeholder_input_status'),
											'title'			=> $this->lang->line('title_input_status'),
											'data'			=> array(0=>$this->lang->line('title_status_unactive'),1=>$this->lang->line('title_status_active'),2=>$this->lang->line('title_status_archived'),3=>$this->lang->line('title_status_blocked')),
										);

		$this->data['reset_password']	= array(
											'name'			=> 'reset_password',
											'id'			=> 'reset_password',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_reset_password'),
											'placeholder'	=> $this->lang->line('placeholder_input_reset_password'),
											'title'			=> $this->lang->line('title_input_reset_password'),
											'data'			=> array(0=>$this->lang->line('title_status_no'),1=>$this->lang->line('title_status_yes')),
										);
    }

    public function _group_check($groupid=NULL)
    {
    	if($groupid == NULL)
    	{
	        $this->form_validation->set_message('_group_check', 'Required group ID');
			return false;
    	}

    	if(!is_array($groupid))
    	{
    		$groupids = array($groupid);
    	}

    	foreach ($groupids as $idx => $id)
    	{
	    	$check = $this->ion_auth->group($id);
	    	if($check)
	    	{
	    		$group = $check->row();

	    		if(!$this->ion_auth->is_superuser() && $group->groups_name == $this->config->item('superadmin_group','ion_auth'))
	    		{
			    	$this->form_validation->set_message('_group_check', 'Invalid group ID');
					return false;
	    		}
	    	}
    	}
		return true;
    }

}


/* End of file Users.php */
/* Location: private/apps/modules/users/controllers/Users.php */


 