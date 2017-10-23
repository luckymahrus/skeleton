<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Suppliers.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/suppliers/controllers/Suppliers.php
 * created		: 2017 Thursday 12th / 15:52:18
 * last edit	: 2017 Thursday 12th / 15:52:18
 * edited by	: Bambang Priyatna
 * version		: 1.0
 *
 */

class Suppliers extends APP_Controller
{
	protected $models = array('suppliers');
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		
    }

	public function get()
	{
		if(@$this->input->get_post('format') == 'datatables')
		{
			$response 	= $this->suppliers->datatables();
			
		}
		else
		{
			$response 	= $this->suppliers->get_all();
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

		$group = $this->suppliers->get($id);

		if($group)
		{
			$this->data['group']		= $group;
			$this->data['id']	= $group->id;
			
			$this->data['code']['value'] 		= $this->form_validation->set_value('tcode', (($this->session->flashdata('tcode')) ? $this->session->flashdata('tcode') : ((isset($group->tcode)) ? $group->tcode : $this->input->get_post('tcode'))));
			$this->data['name']['value'] 	= $this->form_validation->set_value('tdesc', (($this->session->flashdata('tdesc')) ? $this->session->flashdata('tdesc') : ((isset($group->tdesc)) ? $group->tdesc : $this->input->get_post('tdesc'))));
			$this->data['category']['value'] 		= $this->form_validation->set_value('tstat', (($this->session->flashdata('tstat')) ? $this->session->flashdata('tstat') : ((isset($group->tstat)) ? $group->tstat : $this->input->get_post('tstat'))));
			$this->data['note']['value']	= $this->form_validation->set_value('tnote', (($this->session->flashdata('tnote')) ? $this->session->flashdata('tnote') : ((isset($group->tnote)) ? $group->tnote : $this->input->get_post('tnote'))));
			$this->data['website']['value'] 		= $this->form_validation->set_value('website', (($this->session->flashdata('website')) ? $this->session->flashdata('website') : ((isset($group->website)) ? $group->website : $this->input->get_post('website'))));
			$this->data['address']['value'] 	= $this->form_validation->set_value('address_street', (($this->session->flashdata('address_street')) ? $this->session->flashdata('address_street') : ((isset($group->address_street)) ? $group->address_street : $this->input->get_post('address_street'))));
			$this->data['city']['value'] 		= $this->form_validation->set_value('address_city', (($this->session->flashdata('address_city')) ? $this->session->flashdata('address_city') : ((isset($group->address_city)) ? $group->address_city : $this->input->get_post('address_city'))));
			$this->data['province']['value']	= $this->form_validation->set_value('address_state', (($this->session->flashdata('address_state')) ? $this->session->flashdata('address_state') : ((isset($group->address_state)) ? $group->address_state : $this->input->get_post('address_state'))));
			$this->data['country']['value'] 		= $this->form_validation->set_value('address_country', (($this->session->flashdata('address_country')) ? $this->session->flashdata('address_country') : ((isset($group->address_country)) ? $group->address_country : $this->input->get_post('address_country'))));
			$this->data['post_code']['value'] 		= $this->form_validation->set_value('address_zip', (($this->session->flashdata('address_zip')) ? $this->session->flashdata('address_zip') : ((isset($group->address_zip)) ? $group->address_zip : $this->input->get_post('address_zip'))));
			$this->data['phone']['value'] 	= $this->form_validation->set_value('phone', (($this->session->flashdata('phone')) ? $this->session->flashdata('phone') : ((isset($group->phone)) ? $group->phone : $this->input->get_post('phone'))));
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

		$this->data['code']['value'] 	= $this->form_validation->set_value('code', (($this->session->flashdata('code')) ? $this->session->flashdata('code') : $this->input->get_post('code')));
		$this->data['name']['value'] 	= $this->form_validation->set_value('name', (($this->session->flashdata('name')) ? $this->session->flashdata('name') : $this->input->get_post('name')));
		$this->data['category']['value'] 	= $this->form_validation->set_value('category', (($this->session->flashdata('category')) ? $this->session->flashdata('category') : $this->input->get_post('category')));
		$this->data['note']['value'] 		= $this->form_validation->set_value('note', (($this->session->flashdata('note')) ? $this->session->flashdata('note') : $this->input->get_post('note')));
		$this->data['website']['value'] 		= $this->form_validation->set_value('website', (($this->session->flashdata('website')) ? $this->session->flashdata('website') : $this->input->get_post('website')));
		$this->data['address']['value'] 	= $this->form_validation->set_value('address', (($this->session->flashdata('address')) ? $this->session->flashdata('address') : $this->input->get_post('address')));
		$this->data['city']['value'] 		= $this->form_validation->set_value('city', (($this->session->flashdata('city')) ? $this->session->flashdata('city') : $this->input->get_post('city')));
		$this->data['province']['value'] 		= $this->form_validation->set_value('province', (($this->session->flashdata('province')) ? $this->session->flashdata('province') : $this->input->get_post('province')));
		$this->data['country']['value'] 	= $this->form_validation->set_value('country', (($this->session->flashdata('country')) ? $this->session->flashdata('country') : $this->input->get_post('country')));
		$this->data['post_code']['value'] 		= $this->form_validation->set_value('note', (($this->session->flashdata('note')) ? $this->session->flashdata('note') : $this->input->get_post('note')));
		$this->data['phone']['value'] 		= $this->form_validation->set_value('phone', (($this->session->flashdata('phone')) ? $this->session->flashdata('phone') : $this->input->get_post('phone')));

		// $this->data['status']['selected'] 		= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : $this->input->get_post('status')));
		
	}

	public function insert()
	{
		if($this->input->method() == 'post')
		{
			
			
			$data = $this->input->post();
			$sqlData['tcorp']	= 'SYS';
			$sqlData['ttype']	= 'VEND';
			$sqlData['tcode']	= $data['code'];
			$sqlData['tdesc']	= $data['name'];
			$sqlData['tstat']		= $data['category'];
			$sqlData['tnote']			= $data['note'];
			$sqlData['website']		= $data['website'];
			$sqlData['address_street']	= $data['address'];
			$sqlData['address_city']		= $data['city'];
			$sqlData['address_state']			= $data['province'];
			$sqlData['address_country']		= $data['country'];
			$sqlData['address_zip']		= $data['post_code'];
			$sqlData['phone']		= $data['phone'];
			// $sqlData['status']		= $data['status'];
			

	        $this->form_validation->set_data($data);
			$this->form_validation->set_rules('code', $this->lang->line('label_input_code'), 'trim|required|max_length[30]');
	        $this->form_validation->set_rules('name', $this->lang->line('label_input_name'), 'trim|required|max_length[70]');
	        $this->form_validation->set_rules('category', $this->lang->line('label_input_category'), 'trim|required|max_length[70]');
	        $this->form_validation->set_rules('note', $this->lang->line('label_input_note'), 'trim|required|max_length[150]');
	        $this->form_validation->set_rules('website', $this->lang->line('label_input_website'), 'trim|required|max_length[50]');
			$this->form_validation->set_rules('address', $this->lang->line('label_input_address'), 'trim|required|max_length[50]');
			$this->form_validation->set_rules('city', $this->lang->line('label_input_city'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('province', $this->lang->line('label_input_province'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('country', $this->lang->line('label_input_country'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('post_code', $this->lang->line('label_input_code'), 'trim|required|max_length[50]');
			$this->form_validation->set_rules('phone', $this->lang->line('label_input_phone'), 'trim|required|max_length[50]');
			// $this->form_validation->set_rules('status', $this->lang->line('label_input_status'), 'trim|required|numeric|in_list[0,1,2,3,10]');
			 
			if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();
				$insert 	= $this->suppliers->insert($sqlData);
		        if($insert)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Supplier success added');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>$this->suppliers->errors());
				}
			}
			else
			{
				if(form_error('code',' ',' ') <> '')		{ $alert['code']		= form_error('code',' ',' '); 		}
				if(form_error('name',' ',' ') <> '')		{ $alert['name']		= form_error('name',' ',' '); 		}
				if(form_error('category',' ',' ') <> '')	{ $alert['category']	= form_error('category',' ',' '); 	}
				if(form_error('note',' ',' ') <> '')		{ $alert['note']		= form_error('note',' ',' '); 		}
				if(form_error('website',' ',' ') <> '')		{ $alert['website']		= form_error('website',' ',' '); 	}
				if(form_error('address',' ',' ') <> '')		{ $alert['address']		= form_error('address',' ',' ');	}
				if(form_error('city',' ',' ') <> '')		{ $alert['city']		= form_error('city',' ',' '); 		}
				if(form_error('province',' ',' ') <> '')	{ $alert['province']	= form_error('province',' ',' '); 	}
				if(form_error('post_code',' ',' ') <> '')	{ $alert['post_code']	= form_error('post_code',' ',' '); 	}
				if(form_error('phone',' ',' ') <> '')		{ $alert['phone']		= form_error('phone',' ',' '); 		}
				// if(form_error('status',' ',' ') <> '')		{ $alert['status']			= form_error('status',' ',' '); }

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add supplier!');
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
		$group = $this->suppliers->get($id);
		
		if($group)
		{
			$group 		= $this->suppliers->get_by(array('id'=>$id));
			
			$this->data['supplier']		= $group;
			$this->data['id']	= $group->id;
			
			$this->data['code']['value'] 		= $this->form_validation->set_value('tcode', (($this->session->flashdata('tcode')) ? $this->session->flashdata('tcode') : ((isset($group->tcode)) ? $group->tcode : $this->input->get_post('tcode'))));
			$this->data['name']['value'] 	= $this->form_validation->set_value('tdesc', (($this->session->flashdata('tdesc')) ? $this->session->flashdata('tdesc') : ((isset($group->tdesc)) ? $group->tdesc : $this->input->get_post('tdesc'))));
			$this->data['category']['value'] 		= $this->form_validation->set_value('tstat', (($this->session->flashdata('tstat')) ? $this->session->flashdata('tstat') : ((isset($group->tstat)) ? $group->tstat : $this->input->get_post('tstat'))));
			$this->data['note']['value']	= $this->form_validation->set_value('tnote', (($this->session->flashdata('tnote')) ? $this->session->flashdata('tnote') : ((isset($group->tnote)) ? $group->tnote : $this->input->get_post('tnote'))));
			$this->data['website']['value'] 		= $this->form_validation->set_value('website', (($this->session->flashdata('website')) ? $this->session->flashdata('website') : ((isset($group->website)) ? $group->website : $this->input->get_post('website'))));
			$this->data['address']['value'] 	= $this->form_validation->set_value('address_street', (($this->session->flashdata('address_street')) ? $this->session->flashdata('address_street') : ((isset($group->address_street)) ? $group->address_street : $this->input->get_post('address_street'))));
			$this->data['city']['value'] 		= $this->form_validation->set_value('address_city', (($this->session->flashdata('address_city')) ? $this->session->flashdata('address_city') : ((isset($group->address_city)) ? $group->address_city : $this->input->get_post('address_city'))));
			$this->data['province']['value']	= $this->form_validation->set_value('address_state', (($this->session->flashdata('address_state')) ? $this->session->flashdata('address_state') : ((isset($group->address_state)) ? $group->address_state : $this->input->get_post('address_state'))));
			$this->data['country']['value'] 		= $this->form_validation->set_value('address_country', (($this->session->flashdata('address_country')) ? $this->session->flashdata('address_country') : ((isset($group->address_country)) ? $group->address_country : $this->input->get_post('address_country'))));
			$this->data['post_code']['value'] 		= $this->form_validation->set_value('address_zip', (($this->session->flashdata('address_zip')) ? $this->session->flashdata('address_zip') : ((isset($group->address_zip)) ? $group->address_zip : $this->input->get_post('address_zip'))));
			$this->data['phone']['value'] 	= $this->form_validation->set_value('phone', (($this->session->flashdata('phone')) ? $this->session->flashdata('phone') : ((isset($group->phone)) ? $group->phone : $this->input->get_post('phone'))));
			$this->data['status']['selected']			= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($group->status)) ? $group->status : $this->input->get_post('status'))));
	    }
		else
		{
			// show_404();exit;
		}
    }
	
	public function update()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();
			$group = $this->suppliers->get($data['id']);
			
			$sqlData['tcorp']			= 'SYS';
			$sqlData['ttype']			= 'VEND';
			$sqlData['tcode']			= $data['code'];
			$sqlData['tdesc']			= $data['name'];
			$sqlData['tstat']			= $data['category'];
			$sqlData['tnote']			= $data['note'];
			$sqlData['website']			= $data['website'];
			$sqlData['address_street']	= $data['address'];
			$sqlData['address_city']	= $data['city'];
			$sqlData['address_state']	= $data['province'];
			$sqlData['address_country']	= $data['country'];
			$sqlData['address_zip']		= $data['post_code'];
			$sqlData['phone']			= $data['phone'];
			$sqlData['status']			= $data['status'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_data($data);
			$this->form_validation->set_rules('code', $this->lang->line('label_input_code'), 'trim|required|max_length[30]');
	        $this->form_validation->set_rules('name', $this->lang->line('label_input_name'), 'trim|required|max_length[70]');
	        $this->form_validation->set_rules('category', $this->lang->line('label_input_category'), 'trim|required|max_length[70]');
	        $this->form_validation->set_rules('note', $this->lang->line('label_input_note'), 'trim|required|max_length[150]');
	        $this->form_validation->set_rules('website', $this->lang->line('label_input_website'), 'trim|required|max_length[50]');
			$this->form_validation->set_rules('address', $this->lang->line('label_input_address'), 'trim|required|max_length[50]');
			$this->form_validation->set_rules('city', $this->lang->line('label_input_city'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('province', $this->lang->line('label_input_province'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('country', $this->lang->line('label_input_country'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('post_code', $this->lang->line('label_input_code'), 'trim|required|max_length[50]');
			$this->form_validation->set_rules('phone', $this->lang->line('label_input_phone'), 'trim|required|max_length[50]');
			$this->form_validation->set_rules('status', $this->lang->line('label_input_status'), 'trim|required|numeric|in_list[0,1,2,3,10]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$update		= $this->suppliers->update($group->id,$sqlData);
				
		        if($update)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Supplier data updated!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update supplier!');
				}
			}
			else
			{
				if(form_error('code',' ',' ') <> '')		{ $alert['code']		= form_error('code',' ',' '); 		}
				if(form_error('name',' ',' ') <> '')		{ $alert['name']		= form_error('name',' ',' '); 		}
				if(form_error('category',' ',' ') <> '')	{ $alert['category']	= form_error('category',' ',' '); 	}
				if(form_error('note',' ',' ') <> '')		{ $alert['note']		= form_error('note',' ',' '); 		}
				if(form_error('website',' ',' ') <> '')		{ $alert['website']		= form_error('website',' ',' '); 	}
				if(form_error('address',' ',' ') <> '')		{ $alert['address']		= form_error('address',' ',' ');	}
				if(form_error('city',' ',' ') <> '')		{ $alert['city']		= form_error('city',' ',' '); 		}
				if(form_error('province',' ',' ') <> '')	{ $alert['province']	= form_error('province',' ',' '); 	}
				if(form_error('post_code',' ',' ') <> '')	{ $alert['post_code']	= form_error('post_code',' ',' '); 	}
				if(form_error('phone',' ',' ') <> '')		{ $alert['phone']		= form_error('phone',' ',' '); 		}
				if(form_error('status',' ',' ') <> '')		{ $alert['status']			= form_error('status',' ',' '); }

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add supplier!');
	    }
	}

	public function activate()
	{
		
	}

	public function deactivate()
	{
		
	}

	private function _change_status()
	{
		
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

		$group		= $this->suppliers->get_by(array('id'=>$id));

		if($group)
		{
			$delete 	= $this->suppliers->delete_by('id',$group->id);
			if ($delete)
			{
				return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Supplier successfully removed!');
			}
			else
			{
				return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed supplier! Some data still connected with this group!');
			}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed supplier!');
    }

	private function _form_input()
    {
		$this->data['code']	= array(
											'name'			=> 'code',
											'id'			=> 'code',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_code'),
											'placeholder'	=> $this->lang->line('placeholder_input_code'),
											'title'			=> $this->lang->line('title_input_code'),
										);

		$this->data['name']	= array(
											'name'			=> 'name',
											'id'			=> 'name',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_name'),
											'placeholder'	=> $this->lang->line('placeholder_input_name'),
											'title'			=> $this->lang->line('title_input_name'),
										);
		
		$this->data['category']		= array(
											'name'			=> 'category',
											'id'			=> 'category',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_category'),
											'placeholder'	=> $this->lang->line('placeholder_input_category'),
											'title'			=> $this->lang->line('title_input_category'),
										);
										
		$this->data['note']		= array(
											'name'			=> 'note',
											'id'			=> 'note',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_note'),
											'placeholder'	=> $this->lang->line('placeholder_input_note'),
											'title'			=> $this->lang->line('title_input_note'),
										);
		$this->data['website']		= array(
											'name'			=> 'website',
											'id'			=> 'website',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_website'),
											'placeholder'	=> $this->lang->line('placeholder_input_website'),
											'title'			=> $this->lang->line('title_input_website'),
										);	
		$this->data['address']		= array(
											'name'			=> 'address',
											'id'			=> 'address',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_address'),
											'placeholder'	=> $this->lang->line('placeholder_input_address'),
											'title'			=> $this->lang->line('title_input_address'),
										);	
		$this->data['city']		= array(
											'name'			=> 'city',
											'id'			=> 'city',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_city'),
											'placeholder'	=> $this->lang->line('placeholder_input_city'),
											'title'			=> $this->lang->line('title_input_city'),
										);	
		$this->data['province']		= array(
											'name'			=> 'province',
											'id'			=> 'province',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_province'),
											'placeholder'	=> $this->lang->line('placeholder_input_province'),
											'title'			=> $this->lang->line('title_input_province'),
										);	
		$this->data['country']		= array(
											'name'			=> 'country',
											'id'			=> 'country',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_country'),
											'placeholder'	=> $this->lang->line('placeholder_input_country'),
											'title'			=> $this->lang->line('title_input_country'),
										);	
		$this->data['post_code']		= array(
											'name'			=> 'post_code',
											'id'			=> 'post_code',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_post_code'),
											'placeholder'	=> $this->lang->line('placeholder_input_post_code'),
											'title'			=> $this->lang->line('title_input_post_code'),
										);	
		$this->data['phone']		= array(
											'name'			=> 'phone',
											'id'			=> 'phone',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_phone'),
											'placeholder'	=> $this->lang->line('placeholder_input_phone'),
											'title'			=> $this->lang->line('title_input_phone'),
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


/* End of file Suppliers.php */
/* private/apps/modules/suppliers/controllers/Suppliers.php */
