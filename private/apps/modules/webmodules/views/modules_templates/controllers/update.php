
	public function update()
	{
		if($this->input->method() == 'post')
		{
			$data = $this->input->post();

			$<?=$model_name?> = $this-><?=$model_name?>->get($data['id']);

<?php
if($table_fields && count($table_fields) > 0)
{
	foreach ($table_fields as $idxTF => $field)
	{
		if($field->name <> $table_pkey && $field->name <> '_created_by' && $field->name <> '_updated_by' && $field->name <> '_created_at' && $field->name <> '_updated_at' && $field->name <> 'is_deleted')
		{
echo "			\$sqlData['".$field->name."']	= \$data['".$field->name."'];
";
		}
	}
}
?>

	        $this->form_validation->set_data($data);
	
<?php
if($table_fields && count($table_fields) > 0)
{
	foreach ($table_fields as $idxTF => $field)
	{
		if($field->name <> $table_pkey && $field->name <> '_created_by' && $field->name <> '_updated_by' && $field->name <> '_created_at' && $field->name <> '_updated_at' && $field->name <> 'is_deleted')
		{
			if($field->type == 'smallint' || $field->type == 'tinyint' || $field->type == 'int' || $field->type == 'integer' || $field->type == 'bigint')
			{
echo "			\$this->form_validation->set_rules('".$field->name."', \$this->lang->line('label_input_".$field->name."'), 'trim|required|numeric|max_length[".$field->max_length."]');
";
			}
			elseif($field->type == 'text')
			{
echo "			\$this->form_validation->set_rules('".$field->name."', \$this->lang->line('label_input_".$field->name."'), 'trim|required');
";
			}
			else
			{
echo "			\$this->form_validation->set_rules('".$field->name."', \$this->lang->line('label_input_".$field->name."'), 'trim|required|max_length[".$field->max_length."]');
";
			}
		}
	}
}
?>

	        if ($this->form_validation->run() == true)
	        {
	        	$this->form_validation->clear_field_data();

				$update		= $this-><?=$model_name?>->update($<?=$model_name?>-><?=$table_pkey?>,$sqlData);

		        if($update)
				{
	        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>$this->lang->line('notification_update_success')');
				}
				else
				{
	        		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>$this->lang->line('notification_update_failed')');
				}
			}
			else
			{
<?php
if($table_fields && count($table_fields) > 0)
{
	foreach ($table_fields as $idxTF => $field)
	{
		if($field->name <> $table_pkey && $field->name <> '_created_by' && $field->name <> '_updated_by' && $field->name <> '_created_at' && $field->name <> '_updated_at' && $field->name <> 'is_deleted')
		{
echo "				if(form_error('".$field->name."',' ',' ') <> ''){ \$alert['".$field->name."']	= form_error('".$field->name."',' ',' '); }
";
		}
	}
}
?>

				return array('code'=>400,'class'=>'danger','icon'=>'times','status'=>'error','text'=>validation_errors(),'data'=>@$alert);
		    }
		}   	
		else
		{
			return array('code'=>405,'class'=>'danger','icon'=>'times','status'=>'error','text'=>$this->lang->line('notification_update_failed'));
	    }
    }

