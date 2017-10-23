<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Document.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/document/controllers/Document.php
 * created		: 2017 Monday 9th / 19:14:23
 * last edit	: 2017 Monday 9th / 19:14:23
 * edited by	: Lukman Hakim Mahrus
 * version		: 1.0
 *
 */

class Document extends APP_Controller
{
	protected $models = array('uploads','uploadsrelations');

	protected $uploads_config;

	public function __construct()
	{
		parent::__construct();

		$this->uploads_config	= $this->config->item('uploads');
	}

	public function index()
	{
		/*$table = $this->uploads->get_field_table();

		foreach ($table as $idxT => $field)
		{
			$this->data[$field]	= array(
												'name'			=> $field,
												'id'			=> $field,
												'type'			=> 'text',
												'label'			=> $this->lang->line('label_input_'.$field),
												'placeholder'	=> $this->lang->line('placeholder_input_'.$field),
												'title'			=> $this->lang->line('title_input_'.$field),
											);
			echo '$lang[\'table_column_'.$field.'\'] 				= \''.ucwords(str_replace('_', ' ', $field)).'\';<br>';
			echo '$lang[\'label_input_'.$field.'\'] 				= \''.ucwords(str_replace('_', ' ', $field)).'\';<br>';
			echo '$lang[\'placeholder_input_'.$field.'\'] 		= \''.ucwords(str_replace('_', ' ', $field)).'\';<br>';
			echo '$lang[\'title_input_'.$field.'\'] 				= \''.ucwords(str_replace('_', ' ', $field)).'\';<br>';
			echo '$lang[\'tooltips_'.$field.'\']					= \''.ucwords(str_replace('_', ' ', $field)).'\';<br>';
			echo '<br>';
echo '								&lt;section><br>';
echo '									&lt;label class="label strong"&gt;&lt;?=$'.$field.'[\'label\']?>&lt;/label&gt;<br>';
echo '									&lt;label class="input state-disabled"&gt;<br>';
echo '										&lt;?=form_input($'.$field.',@$'.$field.'[\'value\'],array(\'class\'=&gt;\'\',\'disabled\'=&gt;\'disabled\',\'readonly\'=&gt;\'readonly\',\'maxlength\'=&gt;\'100\',\'title\'=&gt;$'.$field.'[\'title\'],\'placeholder\'=>$'.$field.'[\'placeholder\']))?&gt;<br>';
echo '									&lt;/label&gt;<br>';
echo '									&lt;div class="note"&gt;&lt;/div&gt;<br>';
echo '								&lt;/section&gt;<br>';

		}
		exit;*/
    }

	public function get()
	{
		if(@$this->input->get_post('format') == 'datatables')
		{
			$response 	= $this->uploads->datatables();
		}
		else
		{
			$response 	= $this->uploads->get_all();
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

		$uploads = $this->uploads->get($id);

		if($uploads)
		{
			$this->data['uploads']		= $uploads;
			$this->data['uploads_id']	= $uploads->uploads_id;

			$table = $this->uploads->get_field_table();
			foreach ($table as $idxT => $field)
			{
				@$this->data[$field]['value']	= $this->form_validation->set_value($field, (($this->session->flashdata($field)) ? $this->session->flashdata($field) : ((isset($uploads->{$field})) ? $uploads->{$field} : $this->input->get_post($field))));
			}

			$this->data['status']['selected']			= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($uploads->status)) ? $uploads->status : $this->input->get_post('status'))));
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

		$this->data['uploads_name']['value'] 			= $this->form_validation->set_value('uploads_name', (($this->session->flashdata('uploads_name')) ? $this->session->flashdata('uploads_name') : $this->input->get_post('uploads_name')));
		$this->data['uploads_description']['value'] 	= $this->form_validation->set_value('uploads_description', (($this->session->flashdata('uploads_description')) ? $this->session->flashdata('uploads_description') : $this->input->get_post('uploads_description')));
	}

	public function insert()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$sqlData['uploads_name']			= $data['uploads_name'];
			$sqlData['uploads_description']		= $data['uploads_description'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('uploads_name', $this->lang->line('label_input_uploads_name'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('uploads_description', $this->lang->line('label_input_uploads_description'), 'trim|max_length[100]');
			if (empty($_FILES['files']['name']))
			{
			    $this->form_validation->set_rules('files', $this->lang->line('label_input_files'), 'required');
			}

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

                $this->load->library('upload', $this->uploads_config);
                $this->upload->initialize($this->uploads_config);
                if($this->upload->do_upload('files'))
                {
                    $fileMeta = $this->upload->data();
                    foreach($fileMeta as $key => $val)
                    {
                    	$sqlData['uploads_'.$key]	= $val;
                    }

					$insert 	= $this->uploads->insert($sqlData);

			        if($insert)
					{
		        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Document uploaded!');
					}
					else
					{
						unlink($sqlData['uploads_full_path']);
		        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to upload document!');
					}
                }
                else
                {
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to upload document!');
                }
			}
			else
			{
				if(form_error('uploads_name',' ',' ') <> '')		{ $alert['uploads_name']		= form_error('uploads_name',' ',' '); 			}
				if(form_error('uploads_description',' ',' ') <> '')	{ $alert['uploads_description']	= form_error('uploads_description',' ',' '); 	}
				if(form_error('files',' ',' ') <> '')				{ $alert['files']				= form_error('files',' ',' '); 					}

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

		if(!isset($responses['message']['code']) && $id === NULL)
		{
			show_404();exit;
		}

		$uploads = $this->uploads->get($id);

		if($uploads)
		{
			$this->data['uploads']		= $uploads;
			$this->data['uploads_id']	= $uploads->uploads_id;

			$this->data['uploads_name']['value'] 		= $this->form_validation->set_value('uploads_name', (($this->session->flashdata('uploads_name')) ? $this->session->flashdata('uploads_name') : ((isset($uploads->uploads_name)) ? $uploads->uploads_name : $this->input->get_post('uploads_name'))));
			$this->data['uploads_description']['value'] = $this->form_validation->set_value('uploads_description', (($this->session->flashdata('uploads_description')) ? $this->session->flashdata('uploads_description') : ((isset($uploads->uploads_description)) ? $uploads->uploads_description : $this->input->get_post('uploads_description'))));
			$this->data['status']['selected']			= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($uploads->status)) ? $uploads->status : $this->input->get_post('status'))));
	    }
		else
		{
			show_404();exit;
		}
	}

	public function update($id=NULL)
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$group = $this->uploads->get($data['id']);

			$sqlData['uploads_name']		= $data['uploads_name'];
			$sqlData['uploads_description']	= $data['uploads_description'];
			$sqlData['status']				= $data['status'];

	        $this->form_validation->set_data($data);
	
	        $this->form_validation->set_rules('id', $this->lang->line('label_input_uploads_id'), 'trim|required');
	        $this->form_validation->set_rules('uploads_name', $this->lang->line('label_input_uploads_name'), 'trim|required|max_length[50]');
	        $this->form_validation->set_rules('uploads_description', $this->lang->line('label_input_uploads_description'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('status', $this->lang->line('label_input_status'), 'trim|required|numeric|in_list[0,1,2,3,10]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$update		= $this->uploads->update($group->uploads_id,$sqlData);

		        if($update)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Document updated!');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update document!');
				}
			}
			else
			{
				if(form_error('uploads_name',' ',' ') <> '')		{ $alert['uploads_name']		= form_error('uploads_name',' ',' '); 			}
				if(form_error('uploads_description',' ',' ') <> '')	{ $alert['uploads_description']	= form_error('uploads_description',' ',' '); 	}
				if(form_error('status',' ',' ') <> '')				{ $alert['status']				= form_error('status',' ',' '); 				}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update document!');
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
						$textSuccess 	= 'Document deactivated!';
						$textFailed		= 'Failed to deactivate document!';
						break;
			case 1 :
						$textSuccess 	= 'Document Activated!';
						$textFailed		= 'Failed to activate document!';
						break;
			case 2 :
						$textSuccess 	= 'Document archived!';
						$textFailed		= 'Failed to archive document!';
						break;
			case 3 :
						$textSuccess 	= 'Document blocked!';
						$textFailed		= 'Failed to block document!';
						break;
			default :
						$textSuccess 	= 'Document status updated!';
						$textFailed		= 'Failed to change document status!';
						break;
		}

		$uploads	= $this->uploads->get_by(array('uploads_id'=>$id));

		if($uploads)
		{
			$sqlData['status'] 	= $status;

			$update 	= $this->uploads->update($uploads->uploads_id,$sqlData);

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

		$uploads		= $this->uploads->get_by(array('uploads_id'=>$id));

		if($uploads)
		{
			$delete 	= $this->uploads->delete_by('uploads_id',$uploads->uploads_id);

			if ($delete)
			{
				if($this->uploads_config['soft_delete'] == false)
				{
					unlink($uploads->uploads_full_path);
				}

				$deleteRel 	= $this->uploadsrelations->delete_by('uploads_id',$uploads->uploads_id);

    			return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Document successfully removed!','test'=>$uploads);
    		}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed document!');
	}

	private function _form_input()
	{
		$table = $this->uploads->get_field_table();

		foreach ($table as $idxT => $field)
		{
			$this->data[$field]	= array(
												'name'			=> $field,
												'id'			=> $field,
												'type'			=> 'text',
												'label'			=> $this->lang->line('label_input_'.$field),
												'placeholder'	=> $this->lang->line('placeholder_input_'.$field),
												'title'			=> $this->lang->line('title_input_'.$field),
											);
		}

		$this->data['uploads_name']['required']	= 'required';

		$this->data['files']	= array(
											'name'			=> 'files',
											'id'			=> 'files',
											'type'			=> 'file',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_files'),
											'placeholder'	=> $this->lang->line('placeholder_input_files'),
											'title'			=> $this->lang->line('title_input_files'),
											'accept'		=> '.'.str_replace('|', ',.', $this->uploads_config['allowed_types']),
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

    public function download($Filename=NULL)
    {
		$this->view 	= FALSE;
		$this->layout	= FALSE;

        if($Filename === NULL)
        {
        	show_404();exit;
        }

        $file = $this->uploads->get_by(array('uploads_raw_name'=>$Filename));

        if($file)
        {

			$this->load->helper('file');

	        $filePath 	= $this->uploads_config['upload_path'].$file->uploads_file_name;

        	if(is_file($filePath))
        	{
			    if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

			    header('Pragma: public');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($filePath)).' GMT');
			    header('Cache-Control: private',false);
			    header('Content-Type: '.get_mime_by_extension($filePath));
			    header('Content-Disposition: attachment; filename="'.$file->uploads_client_name.'"');
			    header('Content-Transfer-Encoding: binary');
			    header('Content-Length: '.filesize($filePath));
			    header('Connection: close');
			    readfile($filePath);
			    exit();
        	}
        }

    	show_404();exit;
    }
}


/* End of file Document.php */
/* private/apps/modules/document/controllers/Document.php */
