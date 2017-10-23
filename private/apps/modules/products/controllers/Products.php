<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Products.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/products/controllers/Products.php
 * created		: 2017 Friday 13th / 11:12:18
 * last edit	: 2017 Friday 13th / 11:12:18
 * edited by	: Lukman Hakim Mahrus
 * version		: 1.0
 *
 */

class Products extends APP_Controller
{
	protected $models = array('xinve_items');

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
			$response 	= $this->xinve_items->datatables();
		}
		else
		{
			$response 	= $this->xinve_items->get_all();
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

		$product = $this->xinve_items->get($id);

		if($product)
		{
			$this->data['xinve_items']		= $product;
			$this->data['id']	= $product->id;

			$this->data['tcode']['value'] 			= $this->form_validation->set_value('tcode', (($this->session->flashdata('tcode')) ? $this->session->flashdata('tcode') : ((isset($product->tcode)) ? $product->tcode : $this->input->get_post('tcode'))));
			$this->data['ttype']['value'] 		= $this->form_validation->set_value('ttype', (($this->session->flashdata('ttype')) ? $this->session->flashdata('ttype') : ((isset($product->ttype)) ? $product->ttype : $this->input->get_post('ttype'))));
			$this->data['tdesc']['value'] 			= $this->form_validation->set_value('tdesc', (($this->session->flashdata('tdesc')) ? $this->session->flashdata('tdesc') : ((isset($product->tdesc)) ? $product->tdesc : $this->input->get_post('tdesc'))));
			$this->data['tattr']['value'] 			= $this->form_validation->set_value('tattr', (($this->session->flashdata('tattr')) ? $this->session->flashdata('tattr') : ((isset($product->tattr)) ? $product->tattr : $this->input->get_post('tattr'))));
			$this->data['pcode']['value'] 			= $this->form_validation->set_value('pcode', (($this->session->flashdata('pcode')) ? $this->session->flashdata('pcode') : ((isset($product->pcode)) ? $product->pcode : $this->input->get_post('pcode'))));
			$this->data['tnote']['value'] 			= $this->form_validation->set_value('tnote', (($this->session->flashdata('tnote')) ? $this->session->flashdata('tnote') : ((isset($product->tnote)) ? $product->tnote : $this->input->get_post('tnote'))));
			$this->data['list_price']['value'] 			= $this->form_validation->set_value('list_price', (($this->session->flashdata('list_price')) ? $this->session->flashdata('list_price') : ((isset($product->list_price)) ? $product->list_price : $this->input->get_post('list_price'))));
			$this->data['status']['selected']				= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($product->status)) ? $product->status : $this->input->get_post('status'))));
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

		$this->data['tcode']['value'] 		= $this->form_validation->set_value('tcode', (($this->session->flashdata('tcode')) ? $this->session->flashdata('tcode') : $this->input->get_post('tcode')));
		$this->data['ttype']['value'] 	= $this->form_validation->set_value('ttype', (($this->session->flashdata('ttype')) ? $this->session->flashdata('ttype') : $this->input->get_post('ttype')));
		$this->data['tdesc']['value'] 		= $this->form_validation->set_value('tdesc', (($this->session->flashdata('tdesc')) ? $this->session->flashdata('tdesc') : $this->input->get_post('tdesc')));
		$this->data['tattr']['value'] 		= $this->form_validation->set_value('tattr', (($this->session->flashdata('tattr')) ? $this->session->flashdata('tattr') : $this->input->get_post('tattr')));
		$this->data['pcode']['value'] 		= $this->form_validation->set_value('pcode', (($this->session->flashdata('pcode')) ? $this->session->flashdata('pcode') : $this->input->get_post('pcode')));
		$this->data['tnote']['value'] 		= $this->form_validation->set_value('tnote', (($this->session->flashdata('tnote')) ? $this->session->flashdata('tnote') : $this->input->get_post('tnote')));
		$this->data['list_price']['value'] 		= $this->form_validation->set_value('list_price', (($this->session->flashdata('list_price')) ? $this->session->flashdata('list_price') : $this->input->get_post('list_price')));
	}

	public function insert()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$sqlData['tcode']		= $data['tcode'];
			$sqlData['ttype']		= $data['ttype'];
			$sqlData['tdesc']		= $data['tdesc'];
			$sqlData['tattr']		= $data['tattr'];
			$sqlData['pcode']		= $data['pcode'];
			$sqlData['tnote']		= $data['tnote'];
			$sqlData['tcorp']		= 'SYS';
			$sqlData['tstat']		= 's';
			$sqlData['ocode']		= 'OCODE';
			$sqlData['beg_dt']		= '9999-12-31 23:59:59';
			$sqlData['beg_by']		= 1;
			$sqlData['end_by']		= 2;
			 



			$sqlData['list_price']		= (int)$data['list_price'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('tcode', $this->lang->line('label_input_tcode'), 'trim|required|max_length[50]|is_unique[xinve_items.tcode]');
	        $this->form_validation->set_rules('ttype', $this->lang->line('label_input_ttype'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('tdesc', $this->lang->line('label_input_tdesc'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('tattr', $this->lang->line('label_input_tattr'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('pcode', $this->lang->line('label_input_pcode'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('tnote', $this->lang->line('label_input_tnote'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('list_price', $this->lang->line('label_input_list_price'), 'trim|required|max_length[100]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$insert 	= $this->xinve_items->insert($sqlData);

		        if($insert)
				{
					$this->xinve_items->update($insert,array('status'=>'0'));

	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Product successfully added!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add product!');
				}
			}
			else
			{
				if(form_error('tcode',' ',' ') <> '')		{ $alert['tcode']		= form_error('tcode',' ',' '); 		}
				if(form_error('ttype',' ',' ') <> '')	{ $alert['ttype']	= form_error('ttype',' ',' '); 	}
				if(form_error('tdesc',' ',' ') <> '')		{ $alert['tdesc']		= form_error('tdesc',' ',' '); 		}
				if(form_error('tattr',' ',' ') <> '')		{ $alert['tattr']		= form_error('tattr',' ',' '); 		}
				if(form_error('pcode',' ',' ') <> '')		{ $alert['pcode']		= form_error('pcode',' ',' '); 		}
				if(form_error('tnote',' ',' ') <> '')		{ $alert['tnote']		= form_error('tnote',' ',' '); 	}
				if(form_error('list_price',' ',' ') <> '')		{ $alert['list_price']		= form_error('list_price',' ',' '); 	}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add product!');
	    }
	}

	public function edit($id=NULL)
	{
		if($this->input->is_ajax_request())
		{
			$this->layout = FALSE;
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

		$product = $this->xinve_items->get($id);

		if($product)
		{
			$this->data['xinve_items']		= $product;
			$this->data['id']	= $product->id;

			$this->data['tcode']['value'] 			= $this->form_validation->set_value('tcode', (($this->session->flashdata('tcode')) ? $this->session->flashdata('tcode') : ((isset($product->tcode)) ? $product->tcode : $this->input->get_post('tcode'))));
			$this->data['ttype']['value'] 		= $this->form_validation->set_value('ttype', (($this->session->flashdata('ttype')) ? $this->session->flashdata('ttype') : ((isset($product->ttype)) ? $product->ttype : $this->input->get_post('ttype'))));
			$this->data['tdesc']['value'] 			= $this->form_validation->set_value('tdesc', (($this->session->flashdata('tdesc')) ? $this->session->flashdata('tdesc') : ((isset($product->tdesc)) ? $product->tdesc : $this->input->get_post('tdesc'))));
			$this->data['tattr']['value'] 			= $this->form_validation->set_value('tattr', (($this->session->flashdata('tattr')) ? $this->session->flashdata('tattr') : ((isset($product->tattr)) ? $product->tattr : $this->input->get_post('tattr'))));
			$this->data['pcode']['value'] 			= $this->form_validation->set_value('pcode', (($this->session->flashdata('pcode')) ? $this->session->flashdata('pcode') : ((isset($product->pcode)) ? $product->pcode : $this->input->get_post('pcode'))));
			$this->data['tnote']['value'] 			= $this->form_validation->set_value('tnote', (($this->session->flashdata('tnote')) ? $this->session->flashdata('tnote') : ((isset($product->tnote)) ? $product->tnote : $this->input->get_post('tnote'))));
			$this->data['list_price']['value'] 			= $this->form_validation->set_value('list_price', (($this->session->flashdata('list_price')) ? $this->session->flashdata('list_price') : ((isset($product->list_price)) ? $product->list_price : $this->input->get_post('list_price'))));
			$this->data['status']['selected']				= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($product->status)) ? $product->status : $this->input->get_post('status'))));
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

			$xinve_items = $this->xinve_items->get($data['id']);
			

			$sqlData['tcode']		= $data['tcode'];
			$sqlData['ttype']		= $data['ttype'];
			$sqlData['tdesc']		= $data['tdesc'];
			$sqlData['tattr']		= $data['tattr'];
			$sqlData['pcode']		= $data['pcode'];
			$sqlData['tnote']		= $data['tnote'];
			$sqlData['list_price']	= (int)$data['list_price'];
			$sqlData['status']		= $data['status'];
						

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('tcode', $this->lang->line('label_input_tcode'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('ttype', $this->lang->line('label_input_ttype'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('tdesc', $this->lang->line('label_input_tdesc'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('tattr', $this->lang->line('label_input_tattr'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('pcode', $this->lang->line('label_input_pcode'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('tnote', $this->lang->line('label_input_tnote'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('list_price', $this->lang->line('label_input_list_price'), 'trim|required|numeric|max_length[100]');
	        $this->form_validation->set_rules('status', $this->lang->line('label_input_status'), 'trim|required|numeric|in_list[0,1,2,3,10]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$update		= $this->xinve_items->update($xinve_items->id,$sqlData);

		        if($update)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Product data updated!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update product!');
				}
			}
			else
			{
				if(form_error('tcode',' ',' ') <> '')		{ $alert['tcode']		= form_error('tcode',' ',' '); 		}
				if(form_error('ttype',' ',' ') <> '')	{ $alert['ttype']	= form_error('ttype',' ',' '); 	}
				if(form_error('tdesc',' ',' ') <> '')		{ $alert['tdesc']		= form_error('tdesc',' ',' '); 		}
				if(form_error('tattr',' ',' ') <> '')		{ $alert['tattr']		= form_error('tattr',' ',' '); 		}
				if(form_error('pcode',' ',' ') <> '')		{ $alert['pcode']		= form_error('pcode',' ',' '); 		}
				if(form_error('tnote',' ',' ') <> '')		{ $alert['tnote']		= form_error('tnote',' ',' '); 	}
				if(form_error('list_price',' ',' ') <> '')		{ $alert['list_price']		= form_error('list_price',' ',' '); 	}
				if(form_error('status',' ',' ') <> '')				{ $alert['status']				= form_error('status',' ',' '); 				}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add product!');
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
						$textSuccess 	= 'Product deactivated!';
						$textFailed		= 'Failed to deactivate product!';
						break;
			case 1 :
						$textSuccess 	= 'Product Activated!';
						$textFailed		= 'Failed to activate product!';
						break;
			case 2 :
						$textSuccess 	= 'Product archived!';
						$textFailed		= 'Failed to archive product!';
						break;
			case 3 :
						$textSuccess 	= 'Product blocked!';
						$textFailed		= 'Failed to block product!';
						break;
			default :
						$textSuccess 	= 'Product status updated!';
						$textFailed		= 'Failed to change product status!';
						break;
		}

		$products	= $this->xinve_items->get_by(array('products_id'=>$id));

		if($products)
		{
			$sqlData['status'] 	= $status;

			$update 	= $this->xinve_items->update($products->id,$sqlData);

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

		$products		= $this->xinve_items->get_by(array('id'=>$id));

		if($products)
		{
			$delete 	= $this->xinve_items->delete_by('id',$products->id);

			if ($delete)
			{
    			return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Themes successfully removed!');
    		}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed themes!');
    }

    private function _form_input()
    {
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

		$this->data['tnote']	= array(
											'name'			=> 'tnote',
											'id'			=> 'tnote',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_tnote'),
											'placeholder'	=> $this->lang->line('placeholder_input_tnote'),
											'title'			=> $this->lang->line('title_input_tnote'),
										);

		$this->data['list_price']	= array(
											'name'			=> 'list_price',
											'id'			=> 'list_price',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_list_price'),
											'placeholder'	=> $this->lang->line('placeholder_input_list_price'),
											'title'			=> $this->lang->line('title_input_list_price'),
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


/* End of file Products.php */
/* private/apps/modules/products/controllers/Products.php */
