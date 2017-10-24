<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Webthemes.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/webthemes/controllers/Webthemes.php
 * created		: 2017 September 25th / 08:00:00
 * last edit	: 2017 September 25th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Webthemes extends APP_Controller
{
	protected $models = array('webthemes','webthemesmenu');

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
			$response 	= $this->webthemes->datatables();
		}
		else
		{
			$response 	= $this->webthemes->get_all();
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

		$themes = $this->webthemes->get($id);

		if($themes)
		{
			$this->data['themes']		= $themes;
			$this->data['webthemes_id']	= $themes->webthemes_id;

			$this->data['webthemes_name']['value'] 			= $this->form_validation->set_value('webthemes_name', (($this->session->flashdata('webthemes_name')) ? $this->session->flashdata('webthemes_name') : ((isset($themes->webthemes_name)) ? $themes->webthemes_name : $this->input->get_post('webthemes_name'))));
			$this->data['webthemes_title']['value'] 		= $this->form_validation->set_value('webthemes_title', (($this->session->flashdata('webthemes_title')) ? $this->session->flashdata('webthemes_title') : ((isset($themes->webthemes_title)) ? $themes->webthemes_title : $this->input->get_post('webthemes_title'))));
			$this->data['webthemes_description']['value'] 	= $this->form_validation->set_value('webthemes_description', (($this->session->flashdata('webthemes_description')) ? $this->session->flashdata('webthemes_description') : ((isset($themes->webthemes_description)) ? $themes->webthemes_description : $this->input->get_post('webthemes_description'))));
			$this->data['status']['selected']				= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($themes->status)) ? $themes->status : $this->input->get_post('status'))));
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

		$this->data['webthemes_name']['value'] 			= $this->form_validation->set_value('webthemes_name', (($this->session->flashdata('webthemes_name')) ? $this->session->flashdata('webthemes_name') : $this->input->get_post('webthemes_name')));
		$this->data['webthemes_title']['value'] 		= $this->form_validation->set_value('webthemes_title', (($this->session->flashdata('webthemes_title')) ? $this->session->flashdata('webthemes_title') : $this->input->get_post('webthemes_title')));
		$this->data['webthemes_description']['value'] 	= $this->form_validation->set_value('webthemes_description', (($this->session->flashdata('webthemes_description')) ? $this->session->flashdata('webthemes_description') : $this->input->get_post('webthemes_description')));
    }

	public function insert()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$sqlData['webthemes_name']			= $data['webthemes_name'];
			$sqlData['webthemes_title']			= $data['webthemes_title'];
			$sqlData['webthemes_description']	= $data['webthemes_description'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('webthemes_name', $this->lang->line('label_input_webthemes_name'), 'trim|required|max_length[50]|is_unique[webthemes.webthemes_name]');
	        $this->form_validation->set_rules('webthemes_title', $this->lang->line('label_input_webthemes_description'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('webthemes_description', $this->lang->line('label_input_webthemes_description'), 'trim|required|max_length[100]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$insert 	= $this->webthemes->insert($sqlData);

		        if($insert)
				{
					$this->webthemes->update($insert,array('status'=>'0'));

	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Themes successfully added!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add themes!');
				}
			}
			else
			{
				if(form_error('webthemes_name',' ',' ') <> '')			{ $alert['webthemes_name']			= form_error('webthemes_name',' ',' '); 		}
				if(form_error('webthemes_title',' ',' ') <> '')			{ $alert['webthemes_title']			= form_error('webthemes_title',' ',' '); 		}
				if(form_error('webthemes_description',' ',' ') <> '')	{ $alert['webthemes_description']	= form_error('webthemes_description',' ',' '); 	}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add themes!');
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

		$themes = $this->webthemes->get($id);

		if($themes)
		{
			$this->data['themes']		= $themes;
			$this->data['webthemes_id']	= $themes->webthemes_id;

			$this->data['webthemes_name']['value'] 			= $this->form_validation->set_value('webthemes_name', (($this->session->flashdata('webthemes_name')) ? $this->session->flashdata('webthemes_name') : ((isset($themes->webthemes_name)) ? $themes->webthemes_name : $this->input->get_post('webthemes_name'))));
			$this->data['webthemes_title']['value'] 		= $this->form_validation->set_value('webthemes_title', (($this->session->flashdata('webthemes_title')) ? $this->session->flashdata('webthemes_title') : ((isset($themes->webthemes_title)) ? $themes->webthemes_title : $this->input->get_post('webthemes_title'))));
			$this->data['webthemes_description']['value'] 	= $this->form_validation->set_value('webthemes_description', (($this->session->flashdata('webthemes_description')) ? $this->session->flashdata('webthemes_description') : ((isset($themes->webthemes_description)) ? $themes->webthemes_description : $this->input->get_post('webthemes_description'))));
			$this->data['status']['selected']				= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($themes->status)) ? $themes->status : $this->input->get_post('status'))));
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

			$webthemes = $this->webthemes->get($data['id']);

			$sqlData['webthemes_name']			= $data['webthemes_name'];
			$sqlData['webthemes_title']			= $data['webthemes_title'];
			$sqlData['webthemes_description']	= $data['webthemes_description'];
			$sqlData['status']					= $data['status'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('webthemes_name', $this->lang->line('label_input_webthemes_name'), 'trim|required|'.(($webthemes->webthemes_name <> $data['webthemes_name']) ? 'is_unique[webthemes.webthemes_name]|' : '').'max_length[50]');
	        $this->form_validation->set_rules('webthemes_title', $this->lang->line('label_input_webthemes_title'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('webthemes_description', $this->lang->line('label_input_webthemes_description'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('status', $this->lang->line('label_input_status'), 'trim|required|numeric|in_list[0,1,2,3,10]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$update		= $this->webthemes->update($webthemes->webthemes_id,$sqlData);

		        if($update)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Themes data updated!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update themes!');
				}
			}
			else
			{
				if(form_error('webthemes_name',' ',' ') <> '')			{ $alert['webthemes_name']			= form_error('webthemes_name',' ',' '); 		}
				if(form_error('webthemes_title',' ',' ') <> '')			{ $alert['webthemes_title']			= form_error('webthemes_title',' ',' '); 		}
				if(form_error('webthemes_description',' ',' ') <> '')	{ $alert['webthemes_description']	= form_error('webthemes_description',' ',' '); 	}
				if(form_error('status',' ',' ') <> '')					{ $alert['status']					= form_error('status',' ',' '); 				}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add themes!');
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
			case 0 	:	$action	= 'deactivate';	break;
			case 1 	:	$action	= 'activation';	break;
			case 2 	:	$action	= 'archiving';	break;
			case 3 	:	$action	= 'blocking';	break;
			default :	$action	= 'update';		break;
		}

		$textSuccess 	= $this->lang->line('notification_'.$action.'_success');
		$textFailed		= $this->lang->line('notification_'.$action.'_failed');

		$webthemes	= $this->webthemes->get_by(array('webthemes_id'=>$id));

		if($webthemes)
		{
			$sqlData['status'] 	= $status;

			$update 	= $this->webthemes->update($webthemes->webthemes_id,$sqlData);

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

		$webthemes		= $this->webthemes->get_by(array('webthemes_id'=>$id));

		if($webthemes)
		{
			$delete 	= $this->webthemes->delete_by('webthemes_id',$webthemes->webthemes_id);

			if ($delete)
			{
    			return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Themes successfully removed!');
    		}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed themes!');
    }

    private function _form_input()
    {
		$this->data['webthemes_name']	= array(
											'name'			=> 'webthemes_name',
											'id'			=> 'webthemes_name',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_webthemes_name'),
											'placeholder'	=> $this->lang->line('placeholder_input_webthemes_name'),
											'title'			=> $this->lang->line('title_input_webthemes_name'),
										);

		$this->data['webthemes_title']	= array(
											'name'			=> 'webthemes_title',
											'id'			=> 'webthemes_title',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_webthemes_title'),
											'placeholder'	=> $this->lang->line('placeholder_input_webthemes_title'),
											'title'			=> $this->lang->line('title_input_webthemes_title'),
										);

		$this->data['webthemes_description']	= array(
											'name'			=> 'webthemes_description',
											'id'			=> 'webthemes_description',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_webthemes_description'),
											'placeholder'	=> $this->lang->line('placeholder_input_webthemes_description'),
											'title'			=> $this->lang->line('title_input_webthemes_description'),
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

}


/* End of file Webthemes.php */
/* Location: private/apps/modules/webthemes/controllers/Webthemes.php */


