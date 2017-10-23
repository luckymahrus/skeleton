<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Parameters.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/parameters/controllers/Parameters.php
 * created		: 2017 Friday 13th / 10:04:38
 * last edit	: 2017 Friday 13th / 10:04:38
 * edited by	: Lukman Hakim Mahrus
 * version		: 1.0
 *
 */

class Parameters extends APP_Controller
{
	protected $models = array('parameters');

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
				
			$response 	= $this->parameters->datatables();

		}
		else
		{
			$response 	= $this->parameters->get_all();
			
			
		}

		if (!$this->input->is_ajax_request())
		{


			return $response;
		}
		else
		{
			$this->ajax_json_response($response,200);
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

		$parameter = $this->parameters->get($id);

		if($parameter)
		{
			$this->data['parameter']		= $parameter;
			$this->data['parameters_id']	= $parameter->id;
			//var_dump($parameter->ttype);die;

			$this->data['tcorp']['value'] 		= $this->form_validation->set_value('tcorp', (($this->session->flashdata('tcorp')) ? $this->session->flashdata('tcorp') : ((isset($parameter->tcorp)) ? $parameter->tcorp : $this->input->get_post('tcorp'))));
			$this->data['tcode']['value'] 		= $this->form_validation->set_value('tcode', (($this->session->flashdata('tcode')) ? $this->session->flashdata('tcode') : ((isset($parameter->tcode)) ? $parameter->tcode : $this->input->get_post('tcode'))));
			$this->data['tdesc']['value'] 		= $this->form_validation->set_value('tdesc', (($this->session->flashdata('tdesc')) ? $this->session->flashdata('tdesc') : ((isset($parameter->tdesc)) ? $parameter->tdesc : $this->input->get_post('tdesc'))));
			$this->data['ttype']['selected'] 	= $this->form_validation->set_value('ttype', (($this->session->flashdata('ttype')) ? $this->session->flashdata('ttype') : ((isset($parameter->ttype)) ? (int)$parameter->ttype : $this->input->get_post('ttype'))));
			$this->data['tstat']['selected']	= $this->form_validation->set_value('tstat', (($this->session->flashdata('tstat')) ? $this->session->flashdata('tstat') : ((isset($parameter->tstat)) ? (int)$parameter->tstat : $this->input->get_post('tstat'))));
			$this->data['tnote']['value'] 		= $this->form_validation->set_value('tnote', (($this->session->flashdata('tnote')) ? $this->session->flashdata('tnote') : ((isset($parameter->tnote)) ? $parameter->tnote : $this->input->get_post('tnote'))));
			$this->data['tattr']['value'] 		= $this->form_validation->set_value('tattr', (($this->session->flashdata('tattr')) ? $this->session->flashdata('tattr') : ((isset($parameter->tattr)) ? $parameter->tattr : $this->input->get_post('tattr'))));
			$this->data['pcode']['value'] 		= $this->form_validation->set_value('pcode', (($this->session->flashdata('pcode')) ? $this->session->flashdata('pcode') : ((isset($parameter->pcode)) ? $parameter->pcode : $this->input->get_post('pcode'))));
			$this->data['seqno']['value'] 		= $this->form_validation->set_value('seqno', (($this->session->flashdata('seqno')) ? $this->session->flashdata('seqno') : ((isset($parameter->seqno)) ? $parameter->seqno : $this->input->get_post('seqno'))));
			$this->data['status']['selected']	= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($parameter->status)) ? $parameter->status : $this->input->get_post('status'))));
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

		//$this->data['tcorp']['value'] 		= $this->form_validation->set_value('tcorp', (($this->session->flashdata('tcorp')) ? $this->session->flashdata('tcorp') : $this->input->get_post('tcorp')));
		$this->data['tcorp']['value']		= $this->form_validation->set_value('tcorp', (($this->session->flashdata('tcorp')) ? $this->session->flashdata('tcorp') : 'SYS'));
		$this->data['tcode']['value'] 		= $this->form_validation->set_value('tcode', (($this->session->flashdata('tcode')) ? $this->session->flashdata('tcode') : $this->input->get_post('tcode')));
		$this->data['tdesc']['value'] 		= $this->form_validation->set_value('tdesc', (($this->session->flashdata('tdesc')) ? $this->session->flashdata('tdesc') : $this->input->get_post('tdesc')));

		// $this->data['ttype']['selected'] 	= $this->form_validation->set_value('ttype', (($this->session->flashdata('ttype')) ? $this->session->flashdata('ttype') : $this->input->get_post('ttype')));
		$this->data['ttype']['selected'] 	= $this->form_validation->set_value('ttype', (($this->session->flashdata('ttype')) ? $this->session->flashdata('ttype') : 'PARAM'));
		$this->data['tstat']['value'] 		= $this->form_validation->set_value('tstat', (($this->session->flashdata('tstat')) ? $this->session->flashdata('tstat') : 'ACTVE'));
		//$this->data['tnote']['value'] 		= $this->form_validation->set_value('tnote', (($this->session->flashdata('tnote')) ? $this->session->flashdata('tnote') : $this->input->get_post('tnote')));
		//$this->data['tattr']['value'] 		= $this->form_validation->set_value('tattr', (($this->session->flashdata('tattr')) ? $this->session->flashdata('tattr') : $this->input->get_post('tattr')));
		//$this->data['pcode']['value'] 		= $this->form_validation->set_value('pcode', (($this->session->flashdata('pcode')) ? $this->session->flashdata('pcode') : $this->input->get_post('pcode')));
		$this->data['seqno']['value'] 		= $this->form_validation->set_value('seqno', (($this->session->flashdata('seqno')) ? $this->session->flashdata('seqno') : $this->input->get_post('seq_no')));
		//$this->data['status']['selected'] 	= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : $this->input->get_post('status')));
	}

	public function insert()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();
			var_dump($this->input->post());die;
			$data['tcorp']='SYS';
			$data['ttype']='PARAM';
			$data['tstat']='ACTVE';
			 if ($data['chkbox']!= NULL) {
			 	$data['chkbox'] = 0; 
			 }else{
			 	$data['chkbox'] = 1;
			 }	
			

			$sqlData['tcorp']	= $data['tcorp'];
			$sqlData['tcode']	= $data['tcode'];
			$sqlData['tdesc']	= $data['tdesc'];
			$sqlData['ttype']	= $data['ttype'];
			$sqlData['is_enabled']	= $data['chkbox'];
			$sqlData['tstat']	= $data['tstat'];
			//$sqlData['tattr']	= $data['tattr'];
			//$sqlData['pcode']	= $data['pcode'];
			$sqlData['seqno']	= $data['seqno'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('tcorp', $this->lang->line('label_input_tcorp'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('tcode', $this->lang->line('label_input_tcode'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('tdesc', $this->lang->line('label_input_tdesc'), 'trim|required|max_length[255]');
	        $this->form_validation->set_rules('ttype', $this->lang->line('label_input_ttype'), 'trim|required|max_length[51]');
	        $this->form_validation->set_rules('tstat', $this->lang->line('label_input_tstat'), 'trim|required|max_length[5]');
	        //$this->form_validation->set_rules('tnote', $this->lang->line('label_input_tnote'), 'trim|required|max_length[255]');
	        //$this->form_validation->set_rules('tattr', $this->lang->line('label_input_tattr'), 'trim|required|max_length[255]');
	        //$this->form_validation->set_rules('pcode', $this->lang->line('label_input_pcode'), 'trim|required|max_length[255]');
	        $this->form_validation->set_rules('seqno', $this->lang->line('label_input_seqno'), 'trim|required|max_length[5]');
	        
	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$insert 	= $this->parameters->insert($sqlData);

		        if($insert)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Parameter successfully added!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add parameter!');
				}
			}
			else
			{
				if(form_error('tcorp',' ',' ') <> '')	{ $alert['tcorp']	= form_error('tcorp',' ',' '); 		}
				if(form_error('tcode',' ',' ') <> '')	{ $alert['tcode']	= form_error('tcode',' ',' '); 		}
				if(form_error('tdesc',' ',' ') <> '')	{ $alert['tdesc']	= form_error('tdesc',' ',' '); 		}
				if(form_error('ttype',' ',' ') <> '')	{ $alert['ttype']	= form_error('ttype',' ',' '); 		}
				if(form_error('tstat',' ',' ') <> '')	{ $alert['tstat']	= form_error('tstat',' ',' '); 		}
				if(form_error('tnote',' ',' ') <> '')	{ $alert['tnote']	= form_error('tnote',' ',' '); 		}
				if(form_error('tattr',' ',' ') <> '')	{ $alert['tattr']	= form_error('tattr',' ',' '); 		}
				if(form_error('pcode',' ',' ') <> '')	{ $alert['pcode']	= form_error('pcode',' ',' '); 		}
				if(form_error('seqno',' ',' ') <> '')	{ $alert['seqno']	= form_error('seqno',' ',' '); 		}
				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add parameter!');
	    }
	}

	public function edit($id=NULL)
	{
		if($this->input->is_ajax_request())
		{
			$this->layout = FALSE;
			//$this->view = 'edit_ajax';
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

		$parameter = $this->parameters->get($id);
		
		if($parameter)
		{
			$this->data['parameter']			= $parameter;
			$this->data['parameters_id']		= $parameter->id;

			$this->data['tcorp']['value'] 		= $this->form_validation->set_value('tcorp', (($this->session->flashdata('tcorp')) ? $this->session->flashdata('tcorp') : ((isset($parameter->tcorp)) ? $parameter->tcorp : $this->input->get_post('tcorp'))));
			$this->data['tcode']['value'] 		= $this->form_validation->set_value('tcode', (($this->session->flashdata('tcode')) ? $this->session->flashdata('tcode') : ((isset($parameter->tcode)) ? $parameter->tcode : $this->input->get_post('tcode'))));
			$this->data['tdesc']['value'] 		= $this->form_validation->set_value('tdesc', (($this->session->flashdata('tdesc')) ? $this->session->flashdata('tdesc') : ((isset($parameter->tdesc)) ? $parameter->tdesc : $this->input->get_post('tdesc'))));
			$this->data['ttype']['selected'] 	= $this->form_validation->set_value('ttype', (($this->session->flashdata('ttype')) ? $this->session->flashdata('ttype') : ((isset($parameter->ttype)) ? (int)$parameter->ttype : $this->input->get_post('ttype'))));
			$this->data['isenabled']['value'] 	= $this->form_validation->set_value('isenabled', (($this->session->flashdata('isenabled')) ? $this->session->flashdata('isenabled') : ((isset($parameter->isenabled)) ? $parameter->isenabled : $this->input->get_post('isenabled'))));
			//$this->data['tstat']['selected'] 	= $this->form_validation->set_value('tstat', (($this->session->flashdata('tstat')) ? $this->session->flashdata('tstat') : ((isset($parameter->tstat)) ? (int)$parameter->tstat : $this->input->get_post('tstat'))));
			//$this->data['tnote']['value'] 	    = $this->form_validation->set_value('tnote', (($this->session->flashdata('tnote')) ? $this->session->flashdata('tnote') : ((isset($parameter->tnote)) ? $parameter->tnote : $this->input->get_post('tnote'))));
			$this->data['tattr']['value'] 		= $this->form_validation->set_value('tattr', (($this->session->flashdata('tattr')) ? $this->session->flashdata('tattr') : ((isset($parameter->tattr)) ? $parameter->tattr : $this->input->get_post('tattr'))));
			//$this->data['pcode']['value'] 		= $this->form_validation->set_value('pcode', (($this->session->flashdata('pcode')) ? $this->session->flashdata('pcode') : ((isset($parameter->pcode)) ? $parameter->pcode : $this->input->get_post('pcode'))));
			$this->data['seqno']['value'] 		= $this->form_validation->set_value('seqno', (($this->session->flashdata('seqno')) ? $this->session->flashdata('seqno') : ((isset($parameter->seqno)) ? $parameter->seqno : $this->input->get_post('seqno'))));
			//$this->data['status']['selected']	= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($parameter->status)) ? $parameter->status : $this->input->get_post('status'))));
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

			$parameter = $this->parameters->get($data['id']);
			$data['tcorp']='SYS';
			$data['ttype']='PARAM';
			$data['tstat']='ACTVE';
			//$sqlData['tcorp']	= $data['tcorp'];
			$sqlData['tcode']	= $data['tcode'];
			$sqlData['tdesc']	= $data['tdesc'];
			$sqlData['ttype']	= $data['ttype'];
			$sqlData['tstat']	= $data['tstat'];
			//$sqlData['tnote']	= $data['tnote'];
			//$sqlData['tattr']	= $data['tattr'];
			//$sqlData['pcode']	= $data['pcode'];
			$sqlData['seqno']	= $data['seqno'];
			//$sqlData['status']	= $data['status'];

	        $this->form_validation->set_data($data);
	
	       // $this->form_validation->set_rules('tcorp', $this->lang->line('label_input_tcorp'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('tcode', $this->lang->line('label_input_tcode'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('tdesc', $this->lang->line('label_input_tdesc'), 'trim|required|max_length[255]');
	        $this->form_validation->set_rules('ttype', $this->lang->line('label_input_ttype'), 'trim|required|max_length[5]');
	        //$this->form_validation->set_rules('tstat', $this->lang->line('label_input_tstat'), 'trim|required|max_length[5]');
	        //$this->form_validation->set_rules('tnote', $this->lang->line('label_input_tnote'), 'trim|required|max_length[255]');
	        //$this->form_validation->set_rules('tattr', $this->lang->line('label_input_tattr'), 'trim|required|max_length[255]');
	        //$this->form_validation->set_rules('pcode', $this->lang->line('label_input_pcode'), 'trim|required|max_length[255]');
	        $this->form_validation->set_rules('seqno', $this->lang->line('label_input_seqno'), 'trim|required|max_length[5]');
	       //$this->form_validation->set_rules('status',$this->lang->line('label_input_status'), 'trim|required|max_length[5]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$update		= $this->parameters->update($parameter->id,$sqlData);

		        if($update)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Parameter data updated!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update parameter!');
				}
			}
			else
			{
				if(form_error('tcorp',' ',' ') <> '')	{ $alert['tcorp']	= form_error('tcorp',' ',' '); 		}
				if(form_error('tcode',' ',' ') <> '')	{ $alert['tcode']	= form_error('tcode',' ',' '); 		}
				if(form_error('tdesc',' ',' ') <> '')	{ $alert['tdesc']	= form_error('tdesc',' ',' '); 		}
				if(form_error('ttype',' ',' ') <> '')	{ $alert['ttype']	= form_error('ttype',' ',' '); 		}
				if(form_error('tstat',' ',' ') <> '')	{ $alert['tstat']	= form_error('tstat',' ',' '); 		}
				if(form_error('tnote',' ',' ') <> '')	{ $alert['tnote']	= form_error('tnote',' ',' '); 		}
				if(form_error('tattr',' ',' ') <> '')	{ $alert['tattr']	= form_error('tattr',' ',' '); 		}
				if(form_error('pcode',' ',' ') <> '')	{ $alert['pcode']	= form_error('pcode',' ',' '); 		}
				if(form_error('status',' ',' ') <> '')	{ $alert['status']	= form_error('status',' ',' '); 	}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update parameter!');
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

	private function _change_status()
	{
		if($id === NULL)
		{
			show_404();exit;
		}

		switch($status)
		{
			case 0 :
						$textSuccess 	= 'Parameter deactivated!';
						$textFailed		= 'Failed to deactivate parameter!';
						break;
			case 1 :
						$textSuccess 	= 'Parameter Activated!';
						$textFailed		= 'Failed to activate parameter!';
						break;
			case 2 :
						$textSuccess 	= 'Parameter archived!';
						$textFailed		= 'Failed to archive parameter!';
						break;
			case 3 :
						$textSuccess 	= 'Parameter blocked!';
						$textFailed		= 'Failed to block parameter!';
						break;
			default :
						$textSuccess 	= 'Parameter status updated!';
						$textFailed		= 'Failed to change parameter status!';
						break;
		}

		$parameter	= $this->parameters->get_by(array('id'=>$id));

		if($parameter)
		{
			$sqlData['status'] 				= $status;

			$update 	= $this->parameters->update($parameter->id,$sqlData);

			if ($update)
			{
        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>$textSuccess);
			}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>$textFailed);
	}

	public function delete($id)
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
		if($id === NULL)
		{
			show_404();exit;
		}

		$parameter		= $this->parameters->get_by(array('id'=>$id));

		if($parameter)
		{
			$delete 	= $this->parameters->delete_by('id',$parameter->id);

			if ($delete)
			{
    			return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Parameter successfully removed!');
    		}
        	else
        	{
				return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed parameter!');
        	}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed parameter!');
	}

	private function _form_input()
	{
		$this->data['tcorp']	= array(
											'name'			=> 'tcorp',
											'id'			=> 'tcorp',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_tcorp'),
											'placeholder'	=> $this->lang->line('placeholder_input_tcorp'),
											'title'			=> $this->lang->line('title_input_tcorp'),
										);

		$this->data['tcode']	= array(
											'name'			=> 'tcode',
											'id'			=> 'tcode',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_tcode'),
											'placeholder'	=> $this->lang->line('placeholder_input_tcode'),
											'title'			=> $this->lang->line('title_input_tcode'),
										);

		$this->data['ttype']	= array(
											'name'			=> 'ttype',
											'id'			=> 'ttype',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_ttype'),
											'placeholder'	=> $this->lang->line('placeholder_input_ttype'),
											'title'			=> $this->lang->line('title_input_ttype'),
									        'data'			=> array('0'=>$this->lang->line('title_status_parameter'),'1'=>$this->lang->line('title_status_config')),
										);
		$this->data['tdesc']	= array(
											'name'			=> 'tdesc',
											'id'			=> 'tdesc',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_tdesc'),
											'placeholder'	=> $this->lang->line('placeholder_input_tdesc'),
											'title'			=> $this->lang->line('title_input_tdesc'),
										);

		$this->data['tstat']	= array(
											'name'			=> 'tstat',
											'id'			=> 'tstat',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_tstat'),
											'placeholder'	=> $this->lang->line('placeholder_input_tstat'),
											'title'			=> $this->lang->line('title_input_tstat'),
											'data'			=> array(0=>$this->lang->line('title_status_unactive'),1=>$this->lang->line('title_status_active')),
										);

		$this->data['tnote']	= array(
											'name'			=> 'tnote',
											'id'			=> 'tnote',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_tnote'),
											'placeholder'	=> $this->lang->line('placeholder_input_tnote'),
											'title'			=> $this->lang->line('title_input_tnote'),
										);

		$this->data['tattr']	= array(
											'name'			=> 'tattr',
											'id'			=> 'tattr',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_tattr'),
											'placeholder'	=> $this->lang->line('placeholder_input_tattr'),
											'title'			=> $this->lang->line('title_input_tattr'),
										);

		$this->data['pcode']	= array(
											'name'			=> 'pcode',
											'id'			=> 'pcode',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_pcode'),
											'placeholder'	=> $this->lang->line('placeholder_input_pcode'),
											'title'			=> $this->lang->line('title_input_pcode'),
										);
		$this->data['seqno']	= array(
											'name'			=> 'seqno',
											'id'			=> 'seqno',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_seqno'),
											'placeholder'	=> $this->lang->line('placeholder_input_seqno'),
											'title'			=> $this->lang->line('title_input_seqno'),
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
		$this->data['chkbox']	= array(
											'name'			=> 'chkbox',
											'id'			=> 'chkbox',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_chkbox'),
											'placeholder'	=> $this->lang->line('placeholder_input_chkbox'),
											'title'			=> $this->lang->line('title_input_chkbox'),
											'value'         => 'accept',
        									'checked'       => FALSE,
        									//'data'			=> array(0=>$this->lang->line('title_status_unactive'),1=>$this->lang->line('title_status_active')),
										);
	
		 

	}
}


/* End of file Parameters.php */
/* private/apps/modules/parameters/controllers/Parameters.php */
