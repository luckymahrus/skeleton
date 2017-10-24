
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

		$<?=$model_name?> = $this-><?=$model_name?>->get($id);

		if($<?=$model_name?>)
		{
			$this->data['<?=$model_name?>']		= $<?=$model_name?>;
			$this->data['<?=$table_pkey?>']	= $<?=$model_name?>-><?=$table_pkey?>;

			<?php
			if($table_fields && count($table_fields) > 0)
			{
				foreach ($table_fields as $idxTF => $field)
				{
					if($field->name <> '_created_by' && $field->name <> '_updated_by' && $field->name <> '_created_at' && $field->name <> '_updated_at' && $field->name <> 'is_deleted')
					{
						if(($field->type == 'smallint' || $field->type == 'tinyint') && $field->max_length <= 2)
						{
echo "			\$this->data['".$field->name."']['selected']	= \$this->form_validation->set_value('".$field->name."', ((\$this->session->flashdata('".$field->name."')) ? \$this->session->flashdata('".$field->name."') : ((isset($".$model_name."->".$field->name.")) ? $".$model_name."->".$field->name." : \$this->input->get_post('".$field->name."'))));
";
						}
						else
						{
echo "			\$this->data['".$field->name."']['value']	= \$this->form_validation->set_value('".$field->name."', ((\$this->session->flashdata('".$field->name."')) ? \$this->session->flashdata('".$field->name."') : ((isset($".$model_name."->".$field->name.")) ? $".$model_name."->".$field->name." : \$this->input->get_post('".$field->name."'))));
";
						}
					}
				}
			}
			?>
	    }
		else
		{
			show_404();exit;
		}
    }
