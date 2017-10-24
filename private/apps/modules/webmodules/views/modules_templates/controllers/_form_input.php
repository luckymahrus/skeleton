
    <?=$method_type?> function <?=$webmodules_method?>()
    {
<?php
if($table_fields && count($table_fields) > 0)
{
	foreach ($table_fields as $idxTF => $field)
	{
		if($field->name <> $table_pkey && $field->name <> '_created_by' && $field->name <> '_updated_by' && $field->name <> '_created_at' && $field->name <> '_updated_at' && $field->name <> 'is_deleted')
		{
			if($field->name == 'status' || (($field->type == 'smallint' || $field->type == 'tinyint') && $field->max_length <= 2))
			{
echo "		\$this->data['".$field->name."']	= array(
											'name'			=> '".$field->name."',
											'id'			=> '".$field->name."',
											'required'		=> 'required',
											'label'			=> \$this->lang->line('label_input_".$field->name."'),
											'placeholder'	=> \$this->lang->line('placeholder_input_".$field->name."'),
											'title'			=> \$this->lang->line('title_input_".$field->name."'),
";
				if($field->name == 'status')
				{
echo "											'data'			=> array(
																	0	=> \$this->lang->line('title_status_unactive'),
																	1	=> \$this->lang->line('title_status_active'),
																	2	=> \$this->lang->line('title_status_archived'),
																	3	=> \$this->lang->line('title_status_blocked')
																),
";
				}
				elseif($field->name == 'need_login' || $field->name == 'editable' || $field->name == 'removeable' || $field->name == 'is_enabled' || $field->name == 'is_deleted')
				{
echo "											'data'			=> array(
																	0	=> \$this->lang->line('title_status_no'),
																	1	=> \$this->lang->line('title_status_yes')
																),
";
				}

echo "										);

";
			}
			else
			{
echo "		\$this->data['".$field->name."']	= array(
											'name'			=> '".$field->name."',
											'id'			=> '".$field->name."',
											'type'			=> '".(($field->type == 'smallint' || $field->type == 'tinyint' || $field->type == 'int' || $field->type == 'integer' || $field->type == 'bigint') ? 'numeric' : 'text')."',
											'required'		=> 'required',
											'label'			=> \$this->lang->line('label_input_".$field->name."'),
											'placeholder'	=> \$this->lang->line('placeholder_input_".$field->name."'),
											'title'			=> \$this->lang->line('title_input_".$field->name."'),
										);

";
			}
		}
	}
}
?>
    }
