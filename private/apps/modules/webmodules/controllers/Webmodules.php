<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Webmodules.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/webmodules/controllers/Webmodules.php
 * created		: 2017 September 25th / 08:00:00
 * last edit	: 2017 September 25th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Webmodules extends APP_Controller
{
	protected $models = array('webmodules','groups','webthemes','webmenu','webroutes');

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        /*$view   = $this->router->class . '/' . ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "") .
        'modules_templates/controllers/insert';
        $data['webmodules_title'] = 'Test';
		$data['model_name'] = 'webmodules';
		$data['table_pkey'] = 'webmodules_id';
		$data['table_fields'] = $this->db->field_data('webmodules');
		echo $this->load->view($view, $data, true);
		echo "<pre>";print_r($view);echo "</pre>";
		echo "<pre>";print_r($data);echo "</pre>";
		exit;*/
    }

	public function get()
	{
		if(@$this->input->get_post('format') == 'datatables')
		{
			$response 	= $this->webmodules->datatables(array('webmodules_parent_id'=>0));
		}
		else
		{
			$response 	= $this->webmodules->get_all();
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

		$webmodules = $this->webmodules->get($id);

		if($webmodules)
		{
			if($webmodules->editable == 'f' && !$this->ion_auth->is_superuser())
			{
				show_404();exit;
			}

			$this->data['webmodules']		= $webmodules;
			$this->data['webmodules_id']	= $webmodules->webmodules_id;
			$this->data['methods']			= $this->webmodules->get_many_by('webmodules_parent_id',$webmodules->webmodules_id);

			if(isset($webmodules->groups_access) && !is_null($webmodules->groups_access) && !empty($webmodules->groups_access))
			{
				$groups_access = unserialize($webmodules->groups_access);
				foreach ($groups_access as $idxGA => $group)
				{
					$selGroups[$group] = $group;
				}
			}

			$this->data['webmodules_class']['value'] 		= $this->form_validation->set_value('webmodules_class', (($this->session->flashdata('webmodules_class')) ? $this->session->flashdata('webmodules_class') : ((isset($webmodules->webmodules_class)) ? $webmodules->webmodules_class : $this->input->get_post('webmodules_class'))));
			$this->data['webmodules_title']['value'] 		= $this->form_validation->set_value('webmodules_title', (($this->session->flashdata('webmodules_title')) ? $this->session->flashdata('webmodules_title') : ((isset($webmodules->webmodules_title)) ? $webmodules->webmodules_title : $this->input->get_post('webmodules_title'))));
			$this->data['webmodules_description']['value'] 	= $this->form_validation->set_value('webmodules_description', (($this->session->flashdata('webmodules_description')) ? $this->session->flashdata('webmodules_description') : ((isset($webmodules->webmodules_description)) ? $webmodules->webmodules_description : $this->input->get_post('webmodules_description'))));
			$this->data['webmodules_icon']['value'] 		= $this->form_validation->set_value('webmodules_icon', (($this->session->flashdata('webmodules_icon')) ? $this->session->flashdata('webmodules_icon') : ((isset($webmodules->webmodules_icon)) ? $webmodules->webmodules_icon : $this->input->get_post('webmodules_icon'))));
			$this->data['need_login']['selected']			= $this->form_validation->set_value('need_login', (($this->session->flashdata('need_login')) ? $this->session->flashdata('need_login') : ((isset($webmodules->need_login)) ? (($webmodules->need_login) ? 1 : 0) : $this->input->get_post('need_login'))));
			$this->data['groups_access']['selected']		= $this->form_validation->set_value('groups_access', (($this->session->flashdata('groups_access')) ? $this->session->flashdata('groups_access') : ((isset($selGroups)) ? $selGroups : $this->input->get_post('groups_access'))));
			$this->data['editable']['selected']				= $this->form_validation->set_value('editable', (($this->session->flashdata('editable')) ? $this->session->flashdata('editable') : ((isset($webmodules->editable)) ? (($webmodules->editable) ? 1 : 0) : $this->input->get_post('editable'))));
			$this->data['removeable']['selected']			= $this->form_validation->set_value('removeable', (($this->session->flashdata('removeable')) ? $this->session->flashdata('removeable') : ((isset($webmodules->removeable)) ? (($webmodules->removeable) ? 1 : 0) : $this->input->get_post('removeable'))));
			$this->data['status']['selected']				= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($webmodules->status)) ? $webmodules->status : $this->input->get_post('status'))));
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
			//$this->data['message']	= $responses['message'] = array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Module successfully added!','data'=>$this->input->post());

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

		$this->data['webmodules_title']['value'] 		= $this->form_validation->set_value('webmodules_title', (($this->session->flashdata('webmodules_title')) ? $this->session->flashdata('webmodules_title') : $this->input->get_post('webmodules_title')));
		$this->data['webmodules_description']['value'] 	= $this->form_validation->set_value('webmodules_description', (($this->session->flashdata('webmodules_description')) ? $this->session->flashdata('webmodules_description') : $this->input->get_post('webmodules_description')));
		$this->data['webmodules_icon']['value'] 		= $this->form_validation->set_value('webmodules_icon', (($this->session->flashdata('webmodules_icon')) ? $this->session->flashdata('webmodules_icon') : $this->input->get_post('webmodules_icon')));
		$this->data['webmodules_class']['value'] 		= $this->form_validation->set_value('webmodules_class', (($this->session->flashdata('webmodules_class')) ? $this->session->flashdata('webmodules_class') : $this->input->get_post('webmodules_class')));
		$this->data['need_login']['selected'] 			= $this->form_validation->set_value('need_login', (($this->session->flashdata('need_login')) ? $this->session->flashdata('need_login') : $this->input->get_post('need_login')));
		$this->data['groups_access']['selected'] 		= $this->form_validation->set_value('groups_access', (($this->session->flashdata('groups_access')) ? $this->session->flashdata('groups_access') : $this->input->get_post('groups_access')));
		$this->data['editable']['selected'] 			= $this->form_validation->set_value('editable', (($this->session->flashdata('editable')) ? $this->session->flashdata('editable') : $this->input->get_post('editable')));
		$this->data['removeable']['selected'] 			= $this->form_validation->set_value('removeable', (($this->session->flashdata('removeable')) ? $this->session->flashdata('removeable') : $this->input->get_post('removeable')));
    }

	public function insert()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();
			$testReturn['original'] = $data;
			$groupsSerial = NULL;
			if(isset($data['groups_access']) && count($data['groups_access']) > 0)
			{
				$groupsSerial = array();
				foreach ($data['groups_access'] as $idxGA => $group)
				{
					$groups[(int) $group]	= (int) $group;
				}
				$groupsSerial = serialize($groups);
			}

			$sqlData['webmodules_title']		= $data['webmodules_title'];
			$sqlData['webmodules_description']	= $data['webmodules_description'];
			$sqlData['webmodules_icon']			= (isset($data['webmodules_icon']) && !empty($data['webmodules_icon']) && !is_null($data['webmodules_icon'])) ? $data['webmodules_icon'] : NULL;
			$sqlData['webmodules_class']		= strtolower($data['webmodules_class']);
			$sqlData['webmodules_method']		= 'index';
			$sqlData['need_login']				= $data['need_login'];
			$sqlData['groups_access']			= $groupsSerial;
			$sqlData['editable']				= $data['editable'];
			$sqlData['removeable']				= $data['removeable'];
			$sqlData['webmodules_parent_id']	= '0';
			$sqlData['webmodules_uri_routes']	= str_replace('_', '-', $sqlData['webmodules_class']);
			$sqlData['webmodules_name']			= $sqlData['webmodules_class'].'_'.$sqlData['webmodules_method'];

	        $this->form_validation->set_data($sqlData);
	
	        $this->form_validation->set_rules('webmodules_name', $this->lang->line('label_input_webmodules_name'), 'trim|required|max_length[50]|is_unique[webmodules.webmodules_name]');
	        $this->form_validation->set_rules('webmodules_title', $this->lang->line('label_input_webmodules_description'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('webmodules_description', $this->lang->line('label_input_webmodules_description'), 'trim|max_length[100]');
	        $this->form_validation->set_rules('webmodules_icon', $this->lang->line('label_input_webmodules_icon'), 'trim|max_length[100]');
	        $this->form_validation->set_rules('webmodules_class', $this->lang->line('label_input_webmodules_class'), 'trim|required|max_length[50]|is_unique[webmodules.webmodules_class]');
	        $this->form_validation->set_rules('webmodules_method', $this->lang->line('label_input_webmodules_method'), 'trim|required');
	        $this->form_validation->set_rules('need_login', $this->lang->line('label_input_need_login'), 'trim|required|numeric|in_list[0,1]');
	        $this->form_validation->set_rules('groups_access', $this->lang->line('label_input_groups_access'), 'trim');
	        $this->form_validation->set_rules('editable', $this->lang->line('label_input_editable'), 'trim|required|numeric|in_list[0,1]');
	        $this->form_validation->set_rules('removeable', $this->lang->line('label_inputremoveable'), 'trim|required|numeric|in_list[0,1]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$testReturn['parent'] = $sqlData;
				$insert 	= $this->webmodules->insert($sqlData);

		        if($insert)
				{
			        $arrmodules     = $this->config->item('modules_locations');
			        if(!empty($arrmodules) && is_array($arrmodules))    $modules    = array_keys($arrmodules);

	            	if(isset($data['db_model']) && $data['db_model'] <> '0')
	            	{
	            		$this->load->model($data['db_model'].'_model',$data['db_model']);

						$mainControllerData['model_name'] = $data['db_model'];

						$table_fields = $this->db->field_data($this->{$data['db_model']}->table());
						$mainControllerData['table_fields'] = $table_fields;
						$arrField	= array();
						foreach ($table_fields as $idxF => $field)
						{
							$arrField[$field->name]	= $field->name;
						}

						if(in_array($this->{$data['db_model']}->table().'_id', $arrField))
						{
							$mainControllerData['table_pkey'] = $this->{$data['db_model']}->table().'_id';
						}
						else
						{
							$mainControllerData['table_pkey'] = 'id';
						}
	            	}

					$jsonConfigFile['index']['custom_js_files'][]	= '../../js/plugins/jquery-redirect/jquery.redirect.js';
					$jsonConfigFile['index']['custom_js_files'][]	= 'js/plugins/datatables/jquery.dataTables.min.js';
					$jsonConfigFile['index']['custom_js_files'][]	= 'js/plugins/datatables/dataTables.colVis.min.js';
					$jsonConfigFile['index']['custom_js_files'][]	= 'js/plugins/datatables/dataTables.tableTools.min.js';
					$jsonConfigFile['index']['custom_js_files'][]	= 'js/plugins/datatables/dataTables.bootstrap.min.js';
					$jsonConfigFile['index']['custom_js_files'][]	= 'js/plugins/datatable-responsive/dataTables.responsive.min.js';
					$jsonConfigFile['index']['custom_css_files'][]	= '';
					$jsonConfigFile['index']['asides'][]			= '';

					if(isset($data['webmodules_method']) && count($data['webmodules_method']) > 0)
					{
						$controllerFileDataFunction = '';
						foreach ($data['webmodules_method'] as $idxMM => $method)
						{
							if(isset($data['webmodules_method'][$idxMM]) && !empty($data['webmodules_method'][$idxMM]) && !is_null($data['webmodules_method'][$idxMM]))
							{
								$mgroupsSerial[$idxMM] = $groupsSerial;
								if(isset($data['method_groups_access'][$idxMM]) && count($data['method_groups_access'][$idxMM]) > 0)
								{
									$mgroupsSerial[$idxMM] = array();
									foreach ($data['method_groups_access'][$idxMM] as $idxGA2 => $group2)
									{
										$mgroupsSerial[$idxMM][(int) $group2]	= (int) $group2;
									}
									$mgroupsSerial[$idxMM] = serialize($mgroupsSerial[$idxMM]);
								}

								$sqlSubData[$idxMM]['webmodules_title']			= ((isset($data['webmodules_method_title'][$idxMM]) && !empty($data['webmodules_method_title'][$idxMM]) && !is_null($data['webmodules_method_title'][$idxMM])) ? $data['webmodules_method_title'][$idxMM] : ucwords(str_replace('_', ' ', $data['webmodules_title'][$idxMM])));
								$sqlSubData[$idxMM]['webmodules_description']	= NULL;//$sqlData['webmodules_description'];
								$sqlSubData[$idxMM]['webmodules_icon']			= NULL;//(isset($sqlData['webmodules_icon']) && !empty($sqlData['webmodules_icon']) && !is_null($sqlData['webmodules_icon'])) ? $sqlData['webmodules_icon'] : NULL;
								$sqlSubData[$idxMM]['webmodules_class']			= $sqlData['webmodules_class'];
								$sqlSubData[$idxMM]['webmodules_method']		= strtolower($data['webmodules_method'][$idxMM]);
								$sqlSubData[$idxMM]['need_login']				= $sqlData['need_login'];

								$sqlSubData[$idxMM]['groups_access']			= $mgroupsSerial[$idxMM];
								$sqlSubData[$idxMM]['editable']					= $sqlData['editable'];
								$sqlSubData[$idxMM]['removeable']				= $sqlData['removeable'];
								$sqlSubData[$idxMM]['webmodules_parent_id']		= $insert;
								$sqlSubData[$idxMM]['webmodules_uri_routes']	= $sqlSubData[$idxMM]['webmodules_class'].'/'.str_replace('_', '-', $sqlSubData[$idxMM]['webmodules_method']);
								$sqlSubData[$idxMM]['webmodules_name']			= $sqlSubData[$idxMM]['webmodules_class'].'_'.$sqlSubData[$idxMM]['webmodules_method'];
								$sqlSubData[$idxMM]['webmodules_method_type']	= $data['method_type'][$idxMM];

								if($data['method_type'][$idxMM] == 'public')
								{
									$jsonConfigFile[$sqlSubData[$idxMM]['webmodules_method']]['custom_js_files']	= array();
									$jsonConfigFile[$sqlSubData[$idxMM]['webmodules_method']]['custom_css_files']	= array();
									$jsonConfigFile[$sqlSubData[$idxMM]['webmodules_method']]['asides']				= array();
									//$jsonConfigFile[$sqlSubData[$idxMM]['webmodules_method']]['layout']				= ((isset($data['create_view'][$idxMM])) ? (($this->config->item('form_in_ajax_modal') == FALSE) ? FALSE : TRUE) : FALSE);
									$jsonConfigFile[$sqlSubData[$idxMM]['webmodules_method']]['view']				= ((isset($data['create_view'][$idxMM])) ? TRUE : FALSE);
								}
								else
								{
									$sqlSubData[$idxMM]['groups_access']			= NULL;
									$sqlSubData[$idxMM]['webmodules_uri_routes']	= NULL;
								}
								$testReturn['child'][$idxMM] 	= $sqlSubData[$idxMM];
								$insertmethod 					= $this->webmodules->insert($sqlSubData[$idxMM]);

								$controllerTemplatePath	= FALSE;
					            if(isset($modules))
					            {
					                foreach($modules as $module)
					                {
					                    if(file_exists($module.$this->router->class.'/views/modules_templates/controllers/'.$sqlSubData[$idxMM]['webmodules_method'].'.php'))
					                    {
					                        $controllerTemplatePath   = $this->router->class . '/modules_templates/controllers/' . $sqlSubData[$idxMM]['webmodules_method']; break;
					                    }
					                    else if(file_exists(APPPATH.'views/'.$this->router->class.'/modules_templates/controllers/'.$sqlSubData[$idxMM]['webmodules_method'].'.php'))
					                    {
					                        $controllerTemplatePath   = $this->router->class . '/modules_templates/controllers/' .$sqlSubData[$idxMM]['webmodules_method']; break;
					                    }
					                }

					            }
					            else
					            {
					                $controllerTemplatePath   = (($custom_view != "" && (file_exists(APPPATH.'views/'.$this->router->class.'/modules_templates/controllers/'.$sqlSubData[$idxMM]['webmodules_method'].'.php') || file_exists(APPPATH.'views/'.$custom_view.'.php'))) ? $custom_view : ((file_exists(APPPATH.'views/'.$this->router->class.'/'.$this->router->method.'.php')) ? ($this->router->class . '/' . $this->router->method) : FALSE));
					            }

					            if ($controllerTemplatePath != FALSE)
					            {
					            	if(isset($data['db_model']) && $data['db_model'] <> '0')
					            	{
					            		$controllerData[$idxMM]							= $mainControllerData;
								        $controllerData[$idxMM]['webmodules_title'] 	= $sqlSubData[$idxMM]['webmodules_title'];
								        $controllerData[$idxMM]['method_type'] 			= $data['method_type'][$idxMM];
								        $controllerData[$idxMM]['webmodules_method'] 	= strtolower($data['webmodules_method'][$idxMM]);
						                $controllerFileDataFunction .= $this->load->view($controllerTemplatePath, $controllerData[$idxMM], TRUE);
					            	}
					            }
					            else
					            {
$controllerFileDataFunction .= '
	'.$data['method_type'][$idxMM].' function '.strtolower($data['webmodules_method'][$idxMM]).'()
	{
		
	}
	';
					            }
							}
						}
					}

					$this->load->helper('file');

					$modulesPath	= APPPATH.'modules/'.$sqlData['webmodules_class'].'/';
					check_dir($modulesPath);
					check_dir($modulesPath.'controllers/');

$fileHeading = '<?php defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');

/***
 *
 * '.ucfirst($sqlData['webmodules_class']).'.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) '.date("Y").'
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/'.$sqlData['webmodules_class'].'/%s/'.ucfirst($sqlData['webmodules_class']).'.php
 * created		: '.date("Y l jS / H:i:s").'
 * last edit	: '.date("Y l jS / H:i:s").'
 * edited by	: '.$this->session->userdata('users_first_name').' '.$this->session->userdata('users_last_name').'
 * version		: 1.0
 *
 */

';

$fileFooter = '


/* End of file '.ucfirst($sqlData['webmodules_class']).'.php */
/* private/apps/modules/'.$sqlData['webmodules_class'].'/%s/'.ucfirst($sqlData['webmodules_class']).'.php */
';

$controllerFileData = 'class '.ucfirst($sqlData['webmodules_class']).' extends APP_Controller
{
	'.((isset($data['db_model']) && $data['db_model'] <> '0') ? 'protected $models = array(\''.$data['db_model'].'\');' : '').'

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
    }
    '.@$controllerFileDataFunction.'
}';
echo "1<br><pre>";print_r($modulesPath.'controllers/');echo "</pre>";

					check_file(array('server_path'=>$modulesPath.'controllers/','name'=>ucfirst($sqlData['webmodules_class']).'.php'),true,sprintf($fileHeading,'controllers').$controllerFileData.sprintf($fileFooter,'controllers'));
					check_dir($modulesPath.'language/');
					check_dir($modulesPath.'language/english/');
					check_file(array('server_path'=>$modulesPath.'language/english/','name'=>strtolower($sqlData['webmodules_class']).'_lang.php'),true,sprintf($fileHeading,'language/english').'$lang[\'modules_name\']	= \''.$sqlData['webmodules_title'].'\';'.sprintf($fileFooter,'language/english'));
					check_dir($modulesPath.'language/indonesian/');
					check_file(array('server_path'=>$modulesPath.'language/indonesian/','name'=>strtolower($sqlData['webmodules_class']).'_lang.php'),true,sprintf($fileHeading,'language/indonesian').'$lang[\'modules_name\']	= \''.$sqlData['webmodules_title'].'\';'.sprintf($fileFooter,'language/indonesian'));
					check_dir($modulesPath.'views/');

					$webthemes = $this->webthemes->get_all();
					if($webthemes && count($webthemes) > 0)
					{
						foreach ($webthemes as $idxWT => $themes)
						{
							check_dir($modulesPath.'views/'.$themes->webthemes_name.'/');
							check_file(array('server_path'=>$modulesPath.'views/'.$themes->webthemes_name.'/','name'=>'index.php'),true,'<?php defined(\'BASEPATH\') OR exit(\'No direct script access allowed\'); ?>');
							check_file(array('server_path'=>$modulesPath.'views/'.$themes->webthemes_name.'/','name'=>'index_script.php'),true,'<?php defined(\'BASEPATH\') OR exit(\'No direct script access allowed\'); ?>');
							check_file(array('server_path'=>$modulesPath.'views/'.$themes->webthemes_name.'/','name'=>'config.json'),true,json_encode($jsonConfigFile));
							if(isset($data['webmodules_method']) && count($data['webmodules_method']) > 0)
							{
								foreach ($data['webmodules_method'] as $idxMM => $method)
								{
									$viewFileData = '';
									if(isset($data['webmodules_method'][$idxMM]) && !empty($data['webmodules_method'][$idxMM]) && !is_null($data['webmodules_method'][$idxMM]) && $data['method_type'][$idxMM] == 'public' && isset($data['create_view'][$idxMM]))
									{
										$viewFileData .= '<?php defined(\'BASEPATH\') OR exit(\'No direct script access allowed\'); ?>';
										$viewTemplatePath	= FALSE;
							            if(isset($modules))
							            {
							                foreach($modules as $module)
							                {
							                    if(file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'modules_templates/views/'.$data['webmodules_method'][$idxMM].'.php'))
							                    {
							                        $viewTemplatePath   = $this->router->class . '/' . ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "") . '/modules_templates/views/' . $data['webmodules_method'][$idxMM]; break;
							                    }
							                    else if(file_exists(APPPATH.'views/'.$this->router->class.'/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'modules_templates/views/'.$data['webmodules_method'][$idxMM].'.php'))
							                    {
							                        $viewTemplatePath   = $this->router->class . '/' . ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "") . '/modules_templates/views/' .$data['webmodules_method'][$idxMM]; break;
							                    }
							                }

							            }
							            else
							            {
							                $viewTemplatePath   = (($custom_view != "" && (file_exists(APPPATH.'views/'.$this->router->class.'/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'/modules_templates/views/'.$data['webmodules_method'][$idxMM].'.php') || file_exists(APPPATH.'views/'.$custom_view.'.php'))) ? $custom_view : ((file_exists(APPPATH.'views/'.$this->router->class.'/'.$this->router->method.'.php')) ? ($this->router->class . '/' . $this->router->method) : FALSE));
							            }

							            if ($viewTemplatePath != FALSE)
							            {
							            	if(isset($data['db_model']) && $data['db_model'] <> '0')
							            	{
								                $viewFileData .= $this->load->view($viewTemplatePath, $controllerData[$idxMM], TRUE);
							            	}
							            }
										check_file(array('server_path'=>$modulesPath.'views/'.$themes->webthemes_name.'/','name'=>$data['webmodules_method'][$idxMM].'.php'),true,$viewFileData);
									}
								}
							}
						}
					}
exit;

	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Module successfully added!','test'=>@$testReturn);
				}
				else
				{
echo "2<br><pre>";print_r($testReturn);echo "</pre>";
exit;
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add module!','test'=>@$testReturn);
				}
			}
			else
			{
				if(form_error('webmodules_title',' ',' ') <> '')		{ $alert['webmodules_title']		= form_error('webmodules_title',' ',' '); 		}
				if(form_error('webmodules_description',' ',' ') <> '')	{ $alert['webmodules_description']	= form_error('webmodules_description',' ',' '); }
				if(form_error('webmodules_icon',' ',' ') <> '')			{ $alert['webmodules_icon']			= form_error('webmodules_icon',' ',' '); 		}
				if(form_error('webmodules_class',' ',' ') <> '')		{ $alert['webmodules_class']		= form_error('webmodules_class',' ',' '); 		}
				if(form_error('need_login',' ',' ') <> '')				{ $alert['need_login']				= form_error('need_login',' ',' '); 			}
				if(form_error('groups_access',' ',' ') <> '')			{ $alert['groups_access']			= form_error('groups_access',' ',' '); 			}
				if(form_error('editable',' ',' ') <> '')				{ $alert['editable']				= form_error('editable',' ',' '); 				}
				if(form_error('removeable',' ',' ') <> '')				{ $alert['removeable']				= form_error('removeable',' ',' '); 			}

echo "3<br><pre>";print_r($alert);echo "</pre>";
exit;
				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert,'test'=>@$testReturn);
		    }
		}   	
		else
		{
echo "4<br><pre>";print_r($testReturn);echo "</pre>";
exit;
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add module!','test'=>@$testReturn);
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

		$webmodules = $this->webmodules->get($id);

		if($webmodules)
		{
			if($webmodules->editable == 'f' && !$this->ion_auth->is_superuser())
			{
				show_404();exit;
			}

			$this->data['webmodules']		= $webmodules;
			$this->data['webmodules_id']	= $webmodules->webmodules_id;
			$this->data['methods']			= $this->webmodules->get_many_by('webmodules_parent_id',$webmodules->webmodules_id);

			if(isset($webmodules->groups_access) && !is_null($webmodules->groups_access) && !empty($webmodules->groups_access))
			{
				$groups_access = unserialize($webmodules->groups_access);
				foreach ($groups_access as $idxGA => $group)
				{
					$selGroups[$group] = $group;
				}
			}

			$this->data['webmodules_class']['value'] 		= $this->form_validation->set_value('webmodules_class', (($this->session->flashdata('webmodules_class')) ? $this->session->flashdata('webmodules_class') : ((isset($webmodules->webmodules_class)) ? $webmodules->webmodules_class : $this->input->get_post('webmodules_class'))));
			$this->data['webmodules_title']['value'] 		= $this->form_validation->set_value('webmodules_title', (($this->session->flashdata('webmodules_title')) ? $this->session->flashdata('webmodules_title') : ((isset($webmodules->webmodules_title)) ? $webmodules->webmodules_title : $this->input->get_post('webmodules_title'))));
			$this->data['webmodules_description']['value'] 	= $this->form_validation->set_value('webmodules_description', (($this->session->flashdata('webmodules_description')) ? $this->session->flashdata('webmodules_description') : ((isset($webmodules->webmodules_description)) ? $webmodules->webmodules_description : $this->input->get_post('webmodules_description'))));
			$this->data['webmodules_icon']['value'] 		= $this->form_validation->set_value('webmodules_icon', (($this->session->flashdata('webmodules_icon')) ? $this->session->flashdata('webmodules_icon') : ((isset($webmodules->webmodules_icon)) ? $webmodules->webmodules_icon : $this->input->get_post('webmodules_icon'))));
			$this->data['need_login']['selected']			= $this->form_validation->set_value('need_login', (($this->session->flashdata('need_login')) ? $this->session->flashdata('need_login') : ((isset($webmodules->need_login)) ? (($webmodules->need_login) ? 1 : 0) : $this->input->get_post('need_login'))));
			$this->data['groups_access']['selected']		= $this->form_validation->set_value('groups_access', (($this->session->flashdata('groups_access')) ? $this->session->flashdata('groups_access') : ((isset($selGroups)) ? $selGroups : $this->input->get_post('groups_access'))));
			$this->data['editable']['selected']				= $this->form_validation->set_value('editable', (($this->session->flashdata('editable')) ? $this->session->flashdata('editable') : ((isset($webmodules->editable)) ? (($webmodules->editable) ? 1 : 0) : $this->input->get_post('editable'))));
			$this->data['removeable']['selected']			= $this->form_validation->set_value('removeable', (($this->session->flashdata('removeable')) ? $this->session->flashdata('removeable') : ((isset($webmodules->removeable)) ? (($webmodules->removeable) ? 1 : 0) : $this->input->get_post('removeable'))));
			$this->data['status']['selected']				= $this->form_validation->set_value('status', (($this->session->flashdata('status')) ? $this->session->flashdata('status') : ((isset($webmodules->status)) ? $webmodules->status : $this->input->get_post('status'))));
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
			$testReturn['original'] = $data;
			$webmodules = $this->webmodules->get($data['id']);

			$groupsSerial = NULL;
			if(isset($data['groups_access']) && count($data['groups_access']) > 0)
			{
				$groupsSerial = array();
				foreach ($data['groups_access'] as $idxGA => $group)
				{
					$groups[(int) $group]	= (int) $group;
				}
				$groupsSerial = serialize($groups);
			}

			$sqlData['webmodules_title']		= $data['webmodules_title'];
			$sqlData['webmodules_description']	= (isset($data['webmodules_description']) && !empty($data['webmodules_description']) && !is_null($data['webmodules_description']) && $data['webmodules_description'] <> '') ? $data['webmodules_description'] : NULL;
			$sqlData['webmodules_icon']			= (isset($data['webmodules_icon']) && !empty($data['webmodules_icon']) && !is_null($data['webmodules_icon']) && $data['webmodules_icon'] <> '') ? $data['webmodules_icon'] : NULL;
			$sqlData['need_login']				= $data['need_login'];
			$sqlData['groups_access']			= $groupsSerial;
			$sqlData['editable']				= $data['editable'];
			$sqlData['removeable']				= $data['removeable'];
			$sqlData['status']					= $data['status'];

	        $this->form_validation->set_data($sqlData);
	
	        $this->form_validation->set_rules('webmodules_title', $this->lang->line('label_input_webmodules_description'), 'trim|required|max_length[100]');
	        $this->form_validation->set_rules('webmodules_description', $this->lang->line('label_input_webmodules_description'), 'trim|max_length[100]');
	        $this->form_validation->set_rules('webmodules_icon', $this->lang->line('label_input_webmodules_icon'), 'trim|max_length[100]');
	        $this->form_validation->set_rules('need_login', $this->lang->line('label_input_need_login'), 'trim|required|numeric|in_list[0,1]');
	        $this->form_validation->set_rules('groups_access', $this->lang->line('label_input_groups_access'), 'trim');
	        $this->form_validation->set_rules('editable', $this->lang->line('label_input_editable'), 'trim|required|numeric|in_list[0,1]');
	        $this->form_validation->set_rules('removeable', $this->lang->line('label_inputremoveable'), 'trim|required|numeric|in_list[0,1]');
	        $this->form_validation->set_rules('status', $this->lang->line('label_input_status'), 'trim|required|numeric|in_list[0,1,2,3,10]');

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$testReturn['parent'] = $sqlData;
				$update		= $this->webmodules->update($webmodules->webmodules_id,$sqlData);

		        if($update)
				{
					if(isset($data['webmodules_method']) && count($data['webmodules_method']) > 0)
					{
						$controllerFileDataFunction = '';
						foreach ($data['webmodules_method'] as $idxMM => $method)
						{
							if(isset($data['webmodules_method'][$idxMM]) && !empty($data['webmodules_method'][$idxMM]) && !is_null($data['webmodules_method'][$idxMM]))
							{
								$mgroupsSerial[$idxMM] = $groupsSerial;
								if(isset($data['method_groups_access'][$idxMM]) && count($data['method_groups_access'][$idxMM]) > 0)
								{
									$mgroupsSerial[$idxMM] = array();
									foreach ($data['method_groups_access'][$idxMM] as $idxGA2 => $group2)
									{
										$mgroupsSerial[$idxMM][(int) $group2]	= (int) $group2;
									}
									$mgroupsSerial[$idxMM] = serialize($mgroupsSerial[$idxMM]);
								}

								$sqlSubData[$idxMM]['webmodules_title']			= ucwords(str_replace('_', ' ', $data['webmodules_method_title'][$idxMM]));
								$sqlSubData[$idxMM]['webmodules_description']	= (isset($sqlData['webmodules_description']) && !empty($sqlData['webmodules_description']) && !is_null($sqlData['webmodules_description']) && $sqlData['webmodules_description'] <> '') ? $sqlData['webmodules_description'] : NULL;
								$sqlSubData[$idxMM]['webmodules_icon']			= (isset($sqlData['webmodules_icon']) && !empty($sqlData['webmodules_icon']) && !is_null($sqlData['webmodules_icon']) && $sqlData['webmodules_icon'] <> '') ? $sqlData['webmodules_icon'] : NULL;
								$sqlSubData[$idxMM]['webmodules_class']			= $webmodules->webmodules_class;
								$sqlSubData[$idxMM]['webmodules_method']		= strtolower($data['webmodules_method'][$idxMM]);
								$sqlSubData[$idxMM]['need_login']				= $sqlData['need_login'];
								$sqlSubData[$idxMM]['webmodules_parent_id']		= $webmodules->webmodules_id;
								$sqlSubData[$idxMM]['groups_access']			= $mgroupsSerial[$idxMM];
								$sqlSubData[$idxMM]['editable']					= $sqlData['editable'];
								$sqlSubData[$idxMM]['removeable']				= $sqlData['removeable'];
								$sqlSubData[$idxMM]['webmodules_uri_routes']	= $webmodules->webmodules_class.'/'.str_replace('_', '-', $sqlSubData[$idxMM]['webmodules_method']);
								$sqlSubData[$idxMM]['webmodules_name']			= $webmodules->webmodules_class.'_'.$sqlSubData[$idxMM]['webmodules_method'];
								$sqlSubData[$idxMM]['webmodules_method_type']	= @$data['method_type'][$idxMM];
								$sqlSubData[$idxMM]['status']					= $sqlData['status'];

								if(@$data['method_type'][$idxMM] <> 'public')
								{
									$sqlSubData[$idxMM]['groups_access']			= NULL;
									$sqlSubData[$idxMM]['webmodules_uri_routes']	= NULL;
								}

								if(isset($data['method_id'][$idxMM]))
								{
									$updatemethod 	= $this->webmodules->update($data['method_id'][$idxMM],$sqlSubData[$idxMM]);
								}
								else
								{
									$insertmethod 	= $this->webmodules->insert($sqlSubData[$idxMM]);
								}
								$testReturn['child'][$idxMM] = $sqlSubData[$idxMM];
							}
						}
					}

					if(isset($data['removed_method_id']) && count($data['removed_method_id']) > 0)
					{
						foreach ($data['removed_method_id'] as $idxRM => $id)
						{
							$this->webmodules->delete($id);
							$this->webmenu->delete_by('webmodules_id',$id);
							$this->webroutes->delete_by('webmodules_id',$id);
						}
					}
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Themes data updated!','test'=>@$testReturn);
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to update themes!','test'=>@$testReturn);
				}
			}
			else
			{
				if(form_error('webmodules_title',' ',' ') <> '')		{ $alert['webmodules_title']		= form_error('webmodules_title',' ',' '); 		}
				if(form_error('webmodules_description',' ',' ') <> '')	{ $alert['webmodules_description']	= form_error('webmodules_description',' ',' '); }
				if(form_error('webmodules_icon',' ',' ') <> '')			{ $alert['webmodules_icon']			= form_error('webmodules_icon',' ',' '); 		}
				if(form_error('need_login',' ',' ') <> '')				{ $alert['need_login']				= form_error('need_login',' ',' '); 			}
				if(form_error('groups_access',' ',' ') <> '')			{ $alert['groups_access']			= form_error('groups_access',' ',' '); 			}
				if(form_error('editable',' ',' ') <> '')				{ $alert['editable']				= form_error('editable',' ',' '); 				}
				if(form_error('removeable',' ',' ') <> '')				{ $alert['removeable']				= form_error('removeable',' ',' '); 			}
				if(form_error('status',' ',' ') <> '')					{ $alert['status']					= form_error('status',' ',' '); 				}

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert,'test'=>@$testReturn);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to add themes!','test'=>@$testReturn);
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
						$textSuccess 	= 'Module deactivated!';
						$textFailed		= 'Failed to deactivate module!';
						break;
			case 1 :
						$textSuccess 	= 'Module Activated!';
						$textFailed		= 'Failed to activate module!';
						break;
			case 2 :
						$textSuccess 	= 'Module archived!';
						$textFailed		= 'Failed to archive module!';
						break;
			case 3 :
						$textSuccess 	= 'Module blocked!';
						$textFailed		= 'Failed to block module!';
						break;
			default :
						$textSuccess 	= 'Module status updated!';
						$textFailed		= 'Failed to change module status!';
						break;
		}

		$webmodules	= $this->webmodules->get_by(array('webmodules_id'=>$id));

		if($webmodules)
		{
			if($webmodules->editable == 'f' && !$this->ion_auth->is_superuser())
			{
				show_404();exit;
			}

			$sqlData['status'] 	= $status;

			$methods 	= $this->webmodules->get_many_by('webmodules_parent_id',$webmodules->webmodules_id);
			$update 	= $this->webmodules->update($webmodules->webmodules_id,$sqlData);

			if ($update)
			{
				$this->webmenu->update_by(array('webmodules_id'=>$webmodules->webmodules_id),$sqlData);
				$this->webroutes->update_by(array('webmodules_id'=>$webmodules->webmodules_id),$sqlData);

				if($methods && count($methods) > 0)
				{
					//$delete 	= $this->webmodules->delete_by('webmodules_id',$webmodules->webmodules_id);
					foreach ($methods as $idxM => $method)
					{
						$this->webmodules->update_by(array('webmodules_id'=>$method->webmodules_id),$sqlData);
						$this->webmenu->update_by(array('webmodules_id'=>$method->webmodules_id),$sqlData);
						$this->webroutes->update_by(array('webmodules_id'=>$method->webmodules_id),$sqlData);
					}
				}
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

		$webmodules		= $this->webmodules->get_by(array('webmodules_id'=>$id));

		if($webmodules)
		{
			if($webmodules->removeable == 'f' && !$this->ion_auth->is_superuser())
			{
				show_404();exit;
			}

			$methods 	= $this->webmodules->get_many_by('webmodules_parent_id',$webmodules->webmodules_id);
			$delete 	= $this->webmodules->delete_by('webmodules_id',$webmodules->webmodules_id);

			if ($delete)
			{
				$this->webmenu->delete_by('webmodules_id',$webmodules->webmodules_id);
				$this->webroutes->delete_by('webmodules_id',$webmodules->webmodules_id);

				if($methods && count($methods) > 0)
				{
					//$delete 	= $this->webmodules->delete_by('webmodules_id',$webmodules->webmodules_id);
					foreach ($methods as $idxM => $method)
					{
						$this->webmodules->delete($method->webmodules_id);
						$this->webmenu->delete_by('webmodules_id',$method->webmodules_id);
						$this->webroutes->delete_by('webmodules_id',$method->webmodules_id);
					}
				}
    			return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Module successfully removed!');
    		}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Failed to removed module!');
    }

    private function _form_input()
    {
		$this->data['webmodules_name']	= array(
											'name'			=> 'webmodules_name',
											'id'			=> 'webmodules_name',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_webmodules_name'),
											'placeholder'	=> $this->lang->line('placeholder_input_webmodules_name'),
											'title'			=> $this->lang->line('title_input_webmodules_name'),
										);

		$this->data['webmodules_title']	= array(
											'name'			=> 'webmodules_title',
											'id'			=> 'webmodules_title',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_webmodules_title'),
											'placeholder'	=> $this->lang->line('placeholder_input_webmodules_title'),
											'title'			=> $this->lang->line('title_input_webmodules_title'),
										);


		$this->data['webmodules_description']	= array(
											'name'			=> 'webmodules_description',
											'id'			=> 'webmodules_description',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_webmodules_description'),
											'placeholder'	=> $this->lang->line('placeholder_input_webmodules_description'),
											'title'			=> $this->lang->line('title_input_webmodules_description'),
										);

		$this->data['webmodules_icon']	= array(
											'name'			=> 'webmodules_icon',
											'id'			=> 'webmodules_icon',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_webmodules_icon'),
											'placeholder'	=> $this->lang->line('placeholder_input_webmodules_icon'),
											'title'			=> $this->lang->line('title_input_webmodules_icon'),
										);

		$this->data['webmodules_class']	= array(
											'name'			=> 'webmodules_class',
											'id'			=> 'webmodules_class',
											'type'			=> 'text',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_webmodules_class'),
											'placeholder'	=> $this->lang->line('placeholder_input_webmodules_class'),
											'title'			=> $this->lang->line('title_input_webmodules_class'),
										);

		$this->data['need_login']	= array(
											'name'			=> 'need_login',
											'id'			=> 'need_login',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_need_login'),
											'placeholder'	=> $this->lang->line('placeholder_input_need_login'),
											'title'			=> $this->lang->line('title_input_need_login'),
											'data'			=> array(1=>$this->lang->line('title_status_yes'),0=>$this->lang->line('title_status_no')),
										);

		$groups = $this->groups->get_all();
		$groupsData	= array();
		if($groups)
		{
			foreach ($groups as $idxG => $group)
			{
				$groupsData[$group->groups_id]	= $group->groups_description;
			}
		}

		$this->data['groups_access']	= array(
											'name'			=> 'groups_access[]',
											'id'			=> 'groups_access',
											'label'			=> $this->lang->line('label_input_groups_access'),
											'placeholder'	=> $this->lang->line('placeholder_input_groups_access'),
											'title'			=> $this->lang->line('title_input_groups_access'),
											'data'			=> $groupsData,
										);

		//$groups = $this->groups->get_all();
		$this->load->helper('file');

		$modelFiles = check_dir(APPPATH.'models/','array');
		$db_modelData[0]	= 'No Model Selected';
		if($modelFiles && count($modelFiles) > 0)
		{
			foreach ($modelFiles as $idxMF => $modelFile)
			{
				if($idxMF <> 'index.html' && $idxMF <> '.htacess' && is_file($modelFile['server_path']))
				{
					$db_modelData[str_replace('_model.php', '', strtolower($idxMF))]	= $idxMF;
				}
			}
		}

		$this->data['db_model']	= array(
											'name'			=> 'db_model',
											'id'			=> 'db_model',
											'label'			=> $this->lang->line('label_input_db_model'),
											'placeholder'	=> $this->lang->line('placeholder_input_db_model'),
											'title'			=> $this->lang->line('title_input_db_model'),
											'data'			=> $db_modelData,
										);

		$this->data['method_groups_access']	= array(
											'name'			=> 'method_groups_access[0][]',
											'id'			=> 'method_groups_access',
											'label'			=> $this->lang->line('label_input_method_groups_access'),
											'placeholder'	=> $this->lang->line('placeholder_input_method_groups_access'),
											'title'			=> $this->lang->line('title_input_method_groups_access'),
											'data'			=> $groupsData,
										);

		$this->data['editable']	= array(
											'name'			=> 'editable',
											'id'			=> 'editable',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_editable'),
											'placeholder'	=> $this->lang->line('placeholder_input_editable'),
											'title'			=> $this->lang->line('title_input_editable'),
											'data'			=> array(0=>$this->lang->line('title_status_no'),1=>$this->lang->line('title_status_yes')),
										);

		$this->data['removeable']	= array(
											'name'			=> 'removeable',
											'id'			=> 'removeable',
											'required'		=> 'required',
											'label'			=> $this->lang->line('label_input_removeable'),
											'placeholder'	=> $this->lang->line('placeholder_input_removeable'),
											'title'			=> $this->lang->line('title_input_removeable'),
											'data'			=> array(0=>$this->lang->line('title_status_no'),1=>$this->lang->line('title_status_yes')),
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

		$this->data['webmodules_method']	= array(
											'name'			=> 'webmodules_method[0]',
											'id'			=> 'webmodules_method-0',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_webmodules_method'),
											'placeholder'	=> $this->lang->line('placeholder_input_webmodules_method'),
											'title'			=> $this->lang->line('title_input_webmodules_method'),
										);

		$this->data['webmodules_method_title']	= array(
											'name'			=> 'webmodules_method_title[0]',
											'id'			=> 'webmodules_method_title-0',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_webmodules_method_title'),
											'placeholder'	=> $this->lang->line('placeholder_input_webmodules_method_title'),
											'title'			=> $this->lang->line('title_input_webmodules_method_title'),
										);

		$this->data['method_type']	= array(
											'name'			=> 'method_type[0]',
											'id'			=> 'method_type-0',
											'label'			=> $this->lang->line('label_input_method_type'),
											'placeholder'	=> $this->lang->line('placeholder_input_method_type'),
											'title'			=> $this->lang->line('title_input_method_type'),
											'data'			=> array('public'=>$this->lang->line('title_status_public'),'protected'=>$this->lang->line('title_status_protected'),'private'=>$this->lang->line('title_status_private')),
										);

		$this->data['create_view']	= array(
											'name'			=> 'create_view[0]',
											'id'			=> 'create_view-0',
											'label'			=> $this->lang->line('label_input_create_view'),
											'placeholder'	=> $this->lang->line('placeholder_input_create_view'),
											'title'			=> $this->lang->line('title_input_create_view'),
											'data'			=> $this->lang->line('title_input_create_view'),
										);
    }

}


/* End of file Webmodules.php */
/* Location: private/apps/modules/webmodules/controllers/Webmodules.php */


