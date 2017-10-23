<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Webthemesmenu.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/webthemesmenu/controllers/Webthemesmenu.php
 * created		: 2017 September 25th / 08:00:00
 * last edit	: 2017 September 25th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Webthemesmenu extends APP_Controller
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
			$response 	= $this->webthemesmenu->datatables();
		}
		else
		{
			$response 	= $this->webthemesmenu->get_all();
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
			$this->data['message']	= $responses['message'] = $this->_update();

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
				$this->ajax_json_response($responses['message']['status'],$responses,(($delete) ? 200 : 403));
			}
		}

		if($id === NULL)
		{
			show_404();exit;
		}

		$webthemesmenu = $this->webthemesmenu->get($id);

		if($webthemesmenu)
		{
			$this->data['webthemesmenu']	= $webthemesmenu;
			$this->data['webthemesmenu_id']	= $webthemesmenu->webthemesmenu_id;

			$this->data['webthemesmenu_name']['value'] 			= $this->form_validation->set_value('webthemesmenu_name', (($this->session->flashdata('webthemesmenu_name')) ? $this->session->flashdata('webthemesmenu_name') : ((isset($webthemesmenu->webthemesmenu_name)) ? $webthemesmenu->webthemesmenu_name : $this->input->get_post('webthemesmenu_name'))));
			$this->data['webthemesmenu_title']['value'] 		= $this->form_validation->set_value('webthemesmenu_title', (($this->session->flashdata('webthemesmenu_title')) ? $this->session->flashdata('webthemesmenu_title') : ((isset($webthemesmenu->webthemesmenu_title)) ? $webthemesmenu->webthemesmenu_title : $this->input->get_post('webthemesmenu_title'))));
			$this->data['webthemesmenu_description']['value'] 	= $this->form_validation->set_value('webthemesmenu_description', (($this->session->flashdata('webthemesmenu_description')) ? $this->session->flashdata('webthemesmenu_description') : ((isset($webthemesmenu->webthemesmenu_description)) ? $webthemesmenu->webthemesmenu_description : $this->input->get_post('webthemesmenu_description'))));
			$this->data['status']['selected']					= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($webthemesmenu->status)) ? $webthemesmenu->status : $this->input->get_post('status'))));
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
				$this->ajax_json_response($responses['message']['status'],$responses,(($delete) ? 200 : 403));
			}
		}

		$this->data['webthemes_id']['selected'] 			= $this->form_validation->set_value('webthemes_id', (($this->session->flashdata('webthemes_id')) ? $this->session->flashdata('webthemes_id') : $this->input->get_post('webthemes_id')));
		$this->data['webthemesmenu_name']['value'] 			= $this->form_validation->set_value('webthemesmenu_name', (($this->session->flashdata('webthemesmenu_name')) ? $this->session->flashdata('webthemesmenu_name') : $this->input->get_post('webthemesmenu_name')));
		$this->data['webthemesmenu_title']['value'] 		= $this->form_validation->set_value('webthemesmenu_title', (($this->session->flashdata('webthemesmenu_title')) ? $this->session->flashdata('webthemesmenu_title') : $this->input->get_post('webthemesmenu_title')));
		$this->data['webthemesmenu_description']['value'] 	= $this->form_validation->set_value('webthemesmenu_description', (($this->session->flashdata('webthemesmenu_description')) ? $this->session->flashdata('webthemesmenu_description') : $this->input->get_post('webthemesmenu_description')));
    }

	public function insert()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$sqlData['webthemes_id']				= $data['webthemes_id'];
			$sqlData['webthemesmenu_name']			= $data['webthemesmenu_name'];
			$sqlData['webthemesmenu_title']			= $data['webthemesmenu_title'];
			$sqlData['webthemesmenu_description']	= $data['webthemesmenu_description'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('webthemes_id', $this->lang->line('label_input_webthemes_id'), 'trim|required|numeric');
	        $this->form_validation->set_rules('webthemesmenu_name', $this->lang->line('label_input_webthemesmenu_name'), 'trim|required|max_length[50]|is_unique[webthemesmenu.webthemesmenu_name]');
	        $this->form_validation->set_rules('webthemesmenu_title', $this->lang->line('label_input_webthemesmenu_description'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('webthemesmenu_description', $this->lang->line('label_input_webthemesmenu_description'), 'trim|max_length[100]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$insert 	= $this->webthemesmenu->insert($sqlData);

		        if($insert)
				{
	        		return array('class'=>'success','icon'=>'check','status'=>'success','text'=>'Themes menu successfully added!');
				}
				else
				{
	        		return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add themes menu!');
				}
			}
			else
			{
				return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors());
		    }
		}   	
		else
		{
			return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add themes menu!');
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
			$this->data['message']	= $responses['message'] = $this->_update();

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
				$this->ajax_json_response($responses['message']['status'],$responses,(($delete) ? 200 : 403));
			}
		}

		if($id === NULL)
		{
			show_404();exit;
		}

		$webthemesmenu = $this->webthemesmenu->get($id);

		if($webthemesmenu)
		{
			$this->data['webthemesmenu']	= $webthemesmenu;
			$this->data['webthemesmenu_id']	= $webthemesmenu->webthemesmenu_id;

			$this->data['webthemesmenu_name']['value'] 			= $this->form_validation->set_value('webthemesmenu_name', (($this->session->flashdata('webthemesmenu_name')) ? $this->session->flashdata('webthemesmenu_name') : ((isset($webthemesmenu->webthemesmenu_name)) ? $webthemesmenu->webthemesmenu_name : $this->input->get_post('webthemesmenu_name'))));
			$this->data['webthemesmenu_title']['value'] 		= $this->form_validation->set_value('webthemesmenu_title', (($this->session->flashdata('webthemesmenu_title')) ? $this->session->flashdata('webthemesmenu_title') : ((isset($webthemesmenu->webthemesmenu_title)) ? $webthemesmenu->webthemesmenu_title : $this->input->get_post('webthemesmenu_title'))));
			$this->data['webthemesmenu_description']['value'] 	= $this->form_validation->set_value('webthemesmenu_description', (($this->session->flashdata('webthemesmenu_description')) ? $this->session->flashdata('webthemesmenu_description') : ((isset($webthemesmenu->webthemesmenu_description)) ? $webthemesmenu->webthemesmenu_description : $this->input->get_post('webthemesmenu_description'))));
			$this->data['status']['selected']					= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($webthemesmenu->status)) ? $webthemesmenu->status : $this->input->get_post('status'))));
	    }
		else
		{
			show_404();exit;
		}
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
				$this->ajax_json_response($responses['message']['status'],$responses,(($responses['message']['status'] == 'success') ? 200 : 403));
			}

		}
		else
		{
			show_404();exit;
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
				$this->ajax_json_response($responses['message']['status'],$responses,(($responses['message']['status'] == 'success') ? 200 : 403));
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
				$this->ajax_json_response($responses['message']['status'],$responses,(($responses['message']['status'] == 'success') ? 200 : 403));
			}
		}
		else
		{
			show_404();exit;
		}
    }

	private function _update()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$themes = $this->webthemesmenu->get($data['id']);

			$sqlData['webthemes_id']				= $data['webthemes_id'];
			$sqlData['webthemesmenu_name']			= $data['webthemesmenu_name'];
			$sqlData['webthemesmenu_title']			= $data['webthemesmenu_title'];
			$sqlData['webthemesmenu_description']	= $data['webthemesmenu_description'];
			$sqlData['status']						= $data['status'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('webthemes_id', $this->lang->line('label_input_webthemes_id'), 'trim|required|numeric');
	        $this->form_validation->set_rules('webthemesmenu_name', $this->lang->line('label_input_webthemesmenu_name'), 'trim|required|'.(($themes->webthemesmenu_name <> $data['webthemesmenu_name']) ? 'is_unique[webthemesmenu.webthemesmenu_name]|' : '').'max_length[50]');
	        $this->form_validation->set_rules('webthemesmenu_title', $this->lang->line('label_input_webthemesmenu_title'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('webthemesmenu_description', $this->lang->line('label_input_webthemesmenu_description'), 'trim|max_length[100]');
	        $this->form_validation->set_rules('status', $this->lang->line('label_input_status'), 'trim|required|numeric|in_list[0,1,2,3,10]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$update		= $this->webthemesmenu->update($themes->webthemesmenu_id,$sqlData);

		        if($update)
				{
					if($sqlData['status'] == '1')
					{
						$deactivate	= $this->webthemesmenu->update_by(array('status'=>'1','webthemesmenu_id !='=>$themes->webthemesmenu_id),array('status'=>'0'));
					}
	        		return array('class'=>'success','icon'=>'check','status'=>'success','text'=>'Themes  menudata updated!');
				}
				else
				{
	        		return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update themes menu!');
				}
			}
			else
			{
				return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors());
		    }
		}   	
		else
		{
			return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update themes menu!');
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
						$textSuccess 	= 'Themes menu deactivated!';
						$textFailed		= 'Failed to deactivate themes menu!';
						break;
			case 1 :
						$textSuccess 	= 'Themes menu Activated!';
						$textFailed		= 'Failed to activate themes menu!';
						break;
			case 2 :
						$textSuccess 	= 'Themes menu archived!';
						$textFailed		= 'Failed to archive themes menu!';
						break;
			case 3 :
						$textSuccess 	= 'Themes menu blocked!';
						$textFailed		= 'Failed to block themes menu!';
						break;
			default :
						$textSuccess 	= 'Themes menu status updated!';
						$textFailed		= 'Failed to change themes status menu!';
						break;
		}

		$themes	= $this->webthemesmenu->get_by(array('webthemesmenu_id'=>$id));

		if($themes)
		{
			$sqlData['status']	= $status;

			$update 	= $this->webthemesmenu->update($themes->webthemesmenu_id,$sqlData);

			if ($update)
			{
        		return array('class'=>'success','icon'=>'check','status'=>'success','text'=>$textSuccess);
			}
		}
		return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>$textFailed);
    }

	private function _delete($id=NULL)
	{
		if($id === NULL)
		{
			show_404();exit;
		}

		$webthemesmenu		= $this->webthemesmenu->get_by(array('webthemesmenu_id'=>$id));

		if($webthemesmenu)
		{
			$delete 	= $this->webthemesmenu->delete_by('webthemesmenu_id',$webthemesmenu->webthemesmenu_id);

			if ($delete)
			{
        		return array('class'=>'success','icon'=>'check','status'=>'success','text'=>'Themes menu successfully removed!');
			}
			else
			{
				return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed themes menu!');
			}
		}
		return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed themes menu! Themes might still active');
    }

    private function _form_input()
    {
    	$themes = $this->webthemes->get_all();

    	$arrThemes = array();
    	if($themes && count($themes) > 0)
    	{
    		foreach ($themes as $idxT => $theme)
    		{
    			$arrThemes[$theme->webthemes_id] = $theme->webthemes_title;
    		}
    	}

		$this->data['webthemes_id']	= array(
											'name'			=> 'webthemes_id',
											'id'			=> 'webthemes_id',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_webthemes_id'),
											'placeholder'	=> $this->lang->line('placeholder_input_webthemes_id'),
											'title'			=> $this->lang->line('title_input_webthemes_id'),
											'data'			=> $arrThemes,
										);

		$this->data['webthemesmenu_name']	= array(
											'name'			=> 'webthemesmenu_name',
											'id'			=> 'webthemesmenu_name',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_webthemesmenu_name'),
											'placeholder'	=> $this->lang->line('placeholder_input_webthemesmenu_name'),
											'title'			=> $this->lang->line('title_input_webthemesmenu_name'),
										);

		$this->data['webthemesmenu_title']	= array(
											'name'			=> 'webthemesmenu_title',
											'id'			=> 'webthemesmenu_title',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_webthemesmenu_title'),
											'placeholder'	=> $this->lang->line('placeholder_input_webthemesmenu_title'),
											'title'			=> $this->lang->line('title_input_webthemesmenu_title'),
										);

		$this->data['webthemesmenu_description']	= array(
											'name'			=> 'webthemesmenu_description',
											'id'			=> 'webthemesmenu_description',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_webthemesmenu_description'),
											'placeholder'	=> $this->lang->line('placeholder_input_webthemesmenu_description'),
											'title'			=> $this->lang->line('title_input_webthemesmenu_description'),
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


/* End of file Webthemesmenu.php */
/* Location: private/apps/modules/webthemesmenu/controllers/Webthemesmenu.php */


