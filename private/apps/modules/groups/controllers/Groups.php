<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Groups.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/groups/controllers/Groups.php
 * created		: 2017 September 25th / 08:00:00
 * last edit	: 2017 September 25th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Groups extends APP_Controller
{
	protected $models = array('groups','users_groups');

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

    }

	public function get()
	{
		if(@$this->input->get_post('format') == 'datatables')
		{
			$response 	= $this->groups->datatables();
		}
		else
		{
			$response 	= $this->groups->get_all();
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
			$this->view = 'detail_ajax';
		}

		$this->_form_input();

		if($id === NULL)
		{
			show_404();exit;
		}

		$group = $this->groups->get($id);

		if($group)
		{
			$this->data['group']		= $group;
			$this->data['groups_id']	= $group->groups_id;

			$this->data['groups_name']['value'] 		= $this->form_validation->set_value('groups_name', (($this->session->flashdata('groups_name')) ? $this->session->flashdata('groups_name') : ((isset($group->groups_name)) ? $group->groups_name : $this->input->get_post('groups_name'))));
			$this->data['groups_description']['value'] 	= $this->form_validation->set_value('groups_description', (($this->session->flashdata('groups_description')) ? $this->session->flashdata('groups_description') : ((isset($group->groups_description)) ? $group->groups_description : $this->input->get_post('groups_description'))));
			$this->data['groups_level']['value'] 		= $this->form_validation->set_value('groups_level', (($this->session->flashdata('groups_level')) ? $this->session->flashdata('groups_level') : ((isset($group->groups_level)) ? $group->groups_level : $this->input->get_post('groups_level'))));
			$this->data['groups_internal']['selected']	= $this->form_validation->set_value('groups_internal', (($this->session->flashdata('groups_internal')) ? $this->session->flashdata('groups_internal') : ((isset($group->groups_internal)) ? $group->groups_internal : $this->input->get_post('groups_internal'))));
			$this->data['status']['selected']			= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($group->status)) ? $group->status : $this->input->get_post('status'))));
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
			$this->view = 'add_ajax';
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

		$this->data['groups_name']['value'] 		= $this->form_validation->set_value('groups_name', (($this->session->flashdata('groups_name')) ? $this->session->flashdata('groups_name') : $this->input->get_post('groups_name')));
		$this->data['groups_description']['value'] 	= $this->form_validation->set_value('groups_description', (($this->session->flashdata('groups_description')) ? $this->session->flashdata('groups_description') : $this->input->get_post('groups_description')));
		$this->data['groups_level']['value'] 		= $this->form_validation->set_value('groups_level', (($this->session->flashdata('groups_level')) ? $this->session->flashdata('groups_level') : $this->input->get_post('groups_level')));
		$this->data['groups_internal']['selected'] 	= $this->form_validation->set_value('groups_internal', (($this->session->flashdata('groups_internal')) ? $this->session->flashdata('groups_internal') : $this->input->get_post('groups_internal')));
    }

	public function insert()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$sqlData['groups_name']			= $data['groups_name'];
			$sqlData['groups_description']	= $data['groups_description'];
			$sqlData['groups_level']		= $data['groups_level'];
			$sqlData['groups_internal']		= $data['groups_internal'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('groups_name', $this->lang->line('label_input_groups_name'), 'trim|required|max_length[50]|is_unique[groups.groups_name]');
	        $this->form_validation->set_rules('groups_description', $this->lang->line('label_input_groups_description'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('groups_level', $this->lang->line('label_input_groups_level'), 'trim|required|numeric');
	        $this->form_validation->set_rules('groups_internal', $this->lang->line('label_input_groups_id'), 'trim|required|numeric|in_list[0,1]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$insert 	= $this->groups->insert($sqlData);

		        if($insert)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Group successfully added!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add group!');
				}
			}
			else
			{
				if(form_error('groups_name',' ',' ') <> ''){ $alert['groups_name']	= form_error('groups_name',' ',' '); }
				if(form_error('groups_description',' ',' ') <> '')	{ $alert['groups_description']		= form_error('groups_description',' ',' '); 	}
				if(form_error('groups_level',' ',' ') <> '')		{ $alert['groups_level']			= form_error('groups_level',' ',' '); 		}
				if(form_error('groups_internal',' ',' ') <> '')		{ $alert['groups_internal']			= form_error('groups_internal',' ',' '); 		}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add group!');
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

		if(!isset($responses['message']['code']) && $id === NULL)
		{
			show_404();exit;
		}

		$group = $this->groups->get($id);

		if($group)
		{
			$this->data['group']		= $group;
			$this->data['groups_id']	= $group->groups_id;

			$this->data['groups_name']['value'] 		= $this->form_validation->set_value('groups_name', (($this->session->flashdata('groups_name')) ? $this->session->flashdata('groups_name') : ((isset($group->groups_name)) ? $group->groups_name : $this->input->get_post('groups_name'))));
			$this->data['groups_description']['value'] 	= $this->form_validation->set_value('groups_description', (($this->session->flashdata('groups_description')) ? $this->session->flashdata('groups_description') : ((isset($group->groups_description)) ? $group->groups_description : $this->input->get_post('groups_description'))));
			$this->data['groups_level']['value'] 		= $this->form_validation->set_value('groups_level', (($this->session->flashdata('groups_level')) ? $this->session->flashdata('groups_level') : ((isset($group->groups_level)) ? $group->groups_level : $this->input->get_post('groups_level'))));
			$this->data['groups_internal']['selected']	= $this->form_validation->set_value('groups_internal', (($this->session->flashdata('groups_internal')) ? $this->session->flashdata('groups_internal') : ((isset($group->groups_internal)) ? $group->groups_internal : $this->input->get_post('groups_internal'))));
			$this->data['status']['selected']			= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($group->status)) ? $group->status : $this->input->get_post('status'))));
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

			$group = $this->groups->get($data['id']);

			$sqlData['groups_name']			= $data['groups_name'];
			$sqlData['groups_description']	= $data['groups_description'];
			$sqlData['groups_level']		= $data['groups_level'];
			$sqlData['groups_internal']		= $data['groups_internal'];
			$sqlData['status']				= $data['status'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('id', $this->lang->line('label_input_groups_id'), 'trim|required|callback__group_check');
	        $this->form_validation->set_rules('groups_name', $this->lang->line('label_input_groups_name'), 'trim|required|'.(($group->groups_name <> $data['groups_name']) ? 'is_unique[groups.groups_name]|' : '').'max_length[50]');
	        $this->form_validation->set_rules('groups_description', $this->lang->line('label_input_groups_description'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('groups_level', $this->lang->line('label_input_groups_level'), 'trim|required|numeric');
	        $this->form_validation->set_rules('groups_internal', $this->lang->line('label_input_groups_internal'), 'trim|required|numeric|in_list[0,1]');
	        $this->form_validation->set_rules('status', $this->lang->line('label_input_status'), 'trim|required|numeric|in_list[0,1,2,3,10]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$update		= $this->groups->update($group->groups_id,$sqlData);

		        if($update)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'User data updated!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update user!');
				}
			}
			else
			{
				if(form_error('groups_name',' ',' ') <> '')			{ $alert['groups_name']			= form_error('groups_name',' ',' '); 		}
				if(form_error('groups_description',' ',' ') <> '')	{ $alert['groups_description']	= form_error('groups_description',' ',' '); }
				if(form_error('groups_level',' ',' ') <> '')		{ $alert['groups_level']		= form_error('groups_level',' ',' '); 		}
				if(form_error('groups_internal',' ',' ') <> '')		{ $alert['groups_internal']		= form_error('groups_internal',' ',' '); 	}
				if(form_error('status',' ',' ') <> '')				{ $alert['status']				= form_error('status',' ',' '); 			}

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

			if($this->input->post('id') === NULL)
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

			if($this->input->post('id') === NULL)
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
		if($id === NULL)
		{
			show_404();exit;
		}

		switch($status)
		{
			case 0 :
						$textSuccess 	= 'Group deactivated!';
						$textFailed		= 'Failed to deactivate group!';
						break;
			case 1 :
						$textSuccess 	= 'Group Activated!';
						$textFailed		= 'Failed to activate group!';
						break;
			case 2 :
						$textSuccess 	= 'Group archived!';
						$textFailed		= 'Failed to archive group!';
						break;
			case 3 :
						$textSuccess 	= 'Group blocked!';
						$textFailed		= 'Failed to block group!';
						break;
			default :
						$textSuccess 	= 'Group status updated!';
						$textFailed		= 'Failed to change group status!';
						break;
		}

		$group	= $this->groups->get_by(array('groups_id'=>$id));

		if($group)
		{
			$sqlData['status'] 				= $status;

			$update 	= $this->groups->update($group->groups_id,$sqlData);

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

			if($this->input->post('id') === NULL)
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
		if($id === NULL)
		{
			show_404();exit;
		}

		$group		= $this->groups->get_by(array('groups_id'=>$id));
		$totUser	= $this->users_groups->count_by(array('groups_id'=>$id));

		if($group)
		{
			if($totUser == 0)
			{
				$delete 	= $this->groups->delete_by('groups_id',$group->groups_id);

				if ($delete)
				{
        			return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'User successfully removed!');
        		}
        	}
        	else
        	{
				return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed group! Some data still connected with this group!');
        	}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed user!');
    }

    private function _form_input()
    {
		$this->data['groups_name']	= array(
											'name'			=> 'groups_name',
											'id'			=> 'groups_name',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_groups_name'),
											'placeholder'	=> $this->lang->line('placeholder_input_groups_name'),
											'title'			=> $this->lang->line('title_input_groups_name'),
										);

		$this->data['groups_description']	= array(
											'name'			=> 'groups_description',
											'id'			=> 'groups_description',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_groups_description'),
											'placeholder'	=> $this->lang->line('placeholder_input_groups_description'),
											'title'			=> $this->lang->line('title_input_groups_description'),
										);

		$this->data['groups_level']		= array(
											'name'			=> 'groups_level',
											'id'			=> 'groups_level',
											'type'			=> 'numeric',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_groups_level'),
											'placeholder'	=> $this->lang->line('placeholder_input_groups_level'),
											'title'			=> $this->lang->line('title_input_groups_level'),
										);

		$this->data['groups_internal']	= array(
											'name'			=> 'groups_internal',
											'id'			=> 'groups_internal',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_groups_internal'),
											'placeholder'	=> $this->lang->line('placeholder_input_groups_internal'),
											'title'			=> $this->lang->line('title_input_groups_internal'),
											'data'			=> array(1=>$this->lang->line('title_status_yes'),0=>$this->lang->line('title_status_no')),
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

	    		if($group->groups_name == $this->config->item('superadmin_group','ion_auth') && in_array($group->groups_name, $this->config->item('superadmin_group','ion_auth')))
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


