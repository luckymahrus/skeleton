<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Webmenu.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2017
 * license		: http://luckymahrus.com
 * file			: private/apps/modules/webmenu/controllers/Webmenu.php
 * created		: 2017 September 25th / 08:00:00
 * last edit	: 2017 September 25th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Webmenu extends APP_Controller
{
	protected $models = array('webmodules','webthemes','webthemesmenu','webmenu','groups');

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->_form_input();

		if($this->input->method() == 'post' || ($this->session->flashdata('webthemes_id') && $this->session->flashdata('webthemesmenu_id') && $this->session->flashdata('groups_id')))
		{
			$arrData['webthemes_id']		= $this->session->flashdata('webthemes_id');
			$arrData['webthemesmenu_id']	= $this->session->flashdata('webthemesmenu_id');
			$arrData['groups_id']			= $this->session->flashdata('groups_id');

			$data	= ($this->session->flashdata('webthemes_id') && $this->session->flashdata('webthemesmenu_id') && $this->session->flashdata('groups_id')) ? $arrData : $this->input->post();

			$webthemesmenu = $this->webthemesmenu->get_by(array('webthemesmenu_id'=>$data['webthemesmenu_id'],'webthemes_id'=>$data['webthemes_id']));

			if(isset($webthemesmenu) && count($webthemesmenu) > 0)
			{
				$webmodules = $this->webmodules->order_by('webmodules_title','asc')->get_many_by('webmodules_parent_id',0);
				$arrModules = array();
				if($webmodules && count($webmodules) > 0)
				{
					foreach ($webmodules as $idxM => $modules)
					{
						$groups_access	= (!empty($modules->groups_access) && !is_null($modules->groups_access)) ? unserialize($modules->groups_access) : NULL;

						if($groups_access == NULL || in_array($data['groups_id'], $groups_access))
						{
							$arrModules[$modules->webmodules_id]['parent']							= $modules;
							$arrModules[$modules->webmodules_id]['child'][$modules->webmodules_id]	= $modules;
							$websubmodules = $this->webmodules->order_by('webmodules_title','asc')->get_many_by('webmodules_parent_id',$modules->webmodules_id);
							if($websubmodules && count($websubmodules) > 0)
							{
								foreach ($websubmodules as $idxSM => $submodules)
								{
									$subgroups_access	= (!empty($submodules->groups_access) && !is_null($submodules->groups_access)) ? unserialize($submodules->groups_access) : NULL;

									if($subgroups_access == NULL || in_array($data['groups_id'], $subgroups_access))
									{
										$arrModules[$modules->webmodules_id]['child'][$submodules->webmodules_id]	= $submodules;
									}
								}
							}
						}
					}
				}

				$webmenu = $this->webmenu->order_by('webmenu_order','asc')->get_many_by('webmenu_parent_id',0);
				$arrMenu = array();
				if($webmenu && count($webmenu) > 0)
				{
					foreach ($webmenu as $idxM => $menu)
					{
						$groups_access	= (!empty($menu->groups_access) && !is_null($menu->groups_access)) ? unserialize($menu->groups_access) : NULL;

						if($groups_access == NULL || in_array($data['groups_id'], $groups_access))
						{
							$websubmenu = $this->webmenu->order_by('webmenu_order','asc')->get_many_by('webmenu_parent_id',$menu->webmenu_id);
							$arrMenu[$menu->webmenu_id]['parent']					= $menu;
							if($websubmenu && count($websubmenu) > 0)
							{
								foreach ($websubmenu as $idxSM => $submenu)
								{
									$subgroups_access	= (!empty($submenu->groups_access) && !is_null($submenu->groups_access)) ? unserialize($submenu->groups_access) : NULL;

									if($subgroups_access == NULL || in_array($data['groups_id'], $subgroups_access))
									{
										$arrMenu[$menu->webmenu_id]['child'][$submenu->webmenu_id]['parent']						= $submenu;
										$websubmenu2 = $this->webmenu->order_by('webmenu_order','asc')->get_many_by('webmenu_parent_id',$submenu->webmenu_id);
										if($websubmenu2 && count($websubmenu2) > 0)
										{
											foreach ($websubmenu2 as $idxSM2 => $submenu2)
											{
												$subgroups_access2	= (!empty($submenu2->groups_access) && !is_null($submenu2->groups_access)) ? unserialize($submenu2->groups_access) : NULL;

												if($subgroups_access2 == NULL || in_array($data['groups_id'], $subgroups_access2))
												{
													$arrMenu[$menu->webmenu_id]['child'][$submenu->webmenu_id]['child'][$submenu2->webmenu_id]	= $submenu2;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}

			if(isset($arrModules) && count($arrModules) > 0)
			{
				$this->data['webmodules']	= $arrModules;
				if(isset($arrMenu) && count($arrMenu) > 0)
				{
					$this->data['webmenu']	= $arrMenu;
				}
			}
			else
			{
        		$responses	= array('code'=>200,'class'=>'danger','icon'=>'times','groups_id'=>'error','text'=>'Menu not found');
				$this->session->set_flashdata($responses);
				$this->data['message']	= $responses;
			}
		}

		$this->data['webthemes_id']['selected']		= $this->form_validation->set_value('webthemes_id', (($this->session->flashdata('webthemes_id')) ? $this->session->flashdata('webthemes_id') : ((isset($webmodules->webthemes_id)) ? (($webmodules->webthemes_id) ? 1 : 0) : $this->input->get_post('webthemes_id'))));
		$this->data['webthemesmenu_id']['selected']	= $this->form_validation->set_value('webthemesmenu_id', (($this->session->flashdata('webthemesmenu_id')) ? $this->session->flashdata('webthemesmenu_id') : ((isset($webmodules->webthemesmenu_id)) ? (($webmodules->webthemesmenu_id) ? 1 : 0) : $this->input->get_post('webthemesmenu_id'))));
		$this->data['groups_id']['selected']		= $this->form_validation->set_value('groups_id', (($this->session->flashdata('groups_id')) ? $this->session->flashdata('groups_id') : ((isset($webmodules->groups_id)) ? $webmodules->groups_id : $this->input->get_post('groups_id'))));
    }

	public function get()
	{

    }

	public function detail()
	{

    }

	public function get_detail()
	{

    }

	public function add()
	{
		$this->layout 	= FALSE;
		$this->view 	= FALSE;

		if($this->input->method() == 'post')
		{
			$responses['message'] = $this->insert();

			$this->ajax_json_response($responses,$responses['message']['code']);
		}
		else
		{
			show_404();exit;
		}
    }

	protected function insert()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$sqlData['webmodules_id']		= $data['mid'];
			$sqlData['webthemesmenu_id']	= $data['tid'];
			$sqlData['groups_access']		= serialize(array((int)$data['gid']=>(int)$data['gid']));

			$webmodules = $this->webmodules->get($data['mid']);

			if($webmodules && count($webmodules) > 0)
			{
				$sqlData['webmenu_name']		= $webmodules->webmodules_name;
				$sqlData['webmenu_title']		= $webmodules->webmodules_title;
				$sqlData['webmenu_description']	= $webmodules->webmodules_description;
				$sqlData['webmenu_icon']		= $webmodules->webmodules_icon;
				$sqlData['webmenu_parent_id']	= 0;
				$sqlData['webmenu_order']		= count($this->webmenu->get_all());
				$sqlData['need_login']			= $webmodules->need_login;

				$insert	= $this->webmenu->insert($sqlData);

		        if($insert)
				{
					$sqlData['webmenu_id']		= $insert;
					$sqlData['groups_access']	= unserialize($sqlData['groups_access']);
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Module successfully added to menu!','data'=>$sqlData);
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Module failed to add menu!');
				}
			}
			else
			{
				return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Module failed to add menu!');
			}
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Module failed to add menu!');
	    }
    }

	public function edit()
	{
		$this->layout 	= FALSE;
		$this->view 	= FALSE;

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
		else
		{
			show_404();exit;
		}
    }

	protected function update()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			if(isset($data['all_menu']))
			{
				if(isset($data['remove_id']) && count($data['remove_id']) > 0)
				{
					foreach ($data['remove_id'] as $idxRM => $id)
					{
						$delete = $this->webmenu->delete($id);
						$update = $this->webmenu->update_by(array('webmenu_parent_id'=>$id),array('webmenu_parent_id'=>0));
					}
				}

				$allMenu = json_decode($data['all_menu']);
				foreach ($allMenu as $idx1 => $menu)
				{
					$update = $this->webmenu->update($menu->id,array('webmenu_order'=>$idx1));

					if(isset($menu->children) && count($menu->children) > 0)
					{
						foreach ($menu->children as $idx2 => $submenu2)
						{
							$update = $this->webmenu->update($submenu2->id,array('webmenu_order'=>$idx2,'webmenu_parent_id'=>$menu->id));

							if(isset($submenu2->children) && count($submenu2->children) > 0)
							{
								foreach ($submenu2->children as $idx3 => $submenu3)
								{
									$update = $this->webmenu->update($submenu3->id,array('webmenu_order'=>$idx3,'webmenu_parent_id'=>$submenu2->id));
								}
							}
						}
					}
				}
				$this->session->set_flashdata('webthemes_id',$data['webthemes_id']);
				$this->session->set_flashdata('webthemesmenu_id',$data['webthemesmenu_id']);
				$this->session->set_flashdata('groups_id',$data['groups_id']);
        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Menu successfully update!');
			}
			else
			{
				$sqlData['webmenu_title']	= $data['webmenu_title'];
				$sqlData['webmenu_icon']	= $data['webmenu_icon'];

				$webmenu = $this->webmenu->get($data['id']);

				if($webmenu && count($webmenu) > 0)
				{
					$update	= $this->webmenu->update($webmenu->webmenu_id,$sqlData);

			        if($update)
					{
		        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>'Menu successfully update!');
					}
					else
					{
		        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Menu failed to update!');
					}
				}
				else
				{
					return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Menu failed to update!');
				}
			}
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>'Menu failed to update!');
	    }
    }

	public function delete()
	{

    }

	protected function remove()
	{

    }

	public function activate()
	{

    }

	public function deactivate()
	{

    }


    private function _form_input()
    {
		$webthemes 		= $this->webthemes->get_all();
		$themesData		= array();
		$themesmenuData	= array();
		if($webthemes)
		{
			foreach ($webthemes as $idxWT => $themes)
			{
				$themesData[$themes->webthemes_id]	= $themes->webthemes_title;
				$webthemesmenu = $this->webthemesmenu->get_many_by('webthemes_id',$themes->webthemes_id);
				if($webthemesmenu && count($webthemesmenu) > 0)
				{
					//$themesmenuData[$themes->webthemes_id]	= $themes->webthemes_title;
					foreach ($webthemesmenu as $idxWM => $themesmenu)
					{
						$themesmenuData[$themes->webthemes_id][$themesmenu->webthemesmenu_id]	= $themesmenu->webthemesmenu_title;
					}
					//echo "<pre>";print_r($themesmenuData);echo "</pre>";exit;
				}

			}
		}
		$this->data['webthemes_id']	= array(
											'name'			=> 'webthemes_id',
											'id'			=> 'webthemes_id',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_webthemes_title'),
											'placeholder'	=> $this->lang->line('placeholder_input_webthemes_title'),
											'title'			=> $this->lang->line('title_input_webthemes_title'),
											'data'			=> $themesData,
										);

		$this->data['webthemesmenu_id']	= array(
											'name'			=> 'webthemesmenu_id',
											'id'			=> 'webthemesmenu_id',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_webthemesmenu_title'),
											'placeholder'	=> $this->lang->line('placeholder_input_webthemesmenu_title'),
											'title'			=> $this->lang->line('title_input_webthemesmenu_title'),
											'data'			=> $themesmenuData,
										);

		$groups = $this->groups->get_all();
		$groupsData[0]	= 'No login required';
		if($groups)
		{
			foreach ($groups as $idxG => $group)
			{
				$groupsData[$group->groups_id]	= $group->groups_description;
			}
		}
		$this->data['groups_id']	= array(
											'name'			=> 'groups_id',
											'id'			=> 'groups_id',
											'type'			=> 'text',
											'label'			=> $this->lang->line('label_input_groups_description'),
											'placeholder'	=> $this->lang->line('placeholder_input_groups_description'),
											'title'			=> $this->lang->line('title_input_groups_description'),
											'data'			=> $groupsData,
										);
    }

}


/* End of file Webmenu.php */
/* Location: private/apps/modules/webmenu/controllers/Webmenu.php */


