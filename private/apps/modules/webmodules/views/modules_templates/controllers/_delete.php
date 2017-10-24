
	<?=$method_type?> function <?=$webmodules_method?>($id=NULL)
	{
		if($id === NULL)
		{
			show_404();exit;
		}

		$<?=$model_name?>		= $this-><?=$model_name?>->get_by(array('<?=$table_pkey?>'=>$id));

		if($<?=$model_name?>)
		{
			$delete 	= $this-><?=$model_name?>->delete_by('<?=$table_pkey?>',$<?=$model_name?>-><?=$table_pkey?>);

			if ($delete)
			{
    			return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>$this->lang->line('notification_remove_success'));
    		}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>$this->lang->line('notification_remove_failed'));
    }
