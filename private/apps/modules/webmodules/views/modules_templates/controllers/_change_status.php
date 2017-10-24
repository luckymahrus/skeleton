
	private function _change_status($id=NULL,$status=0)
	{
		if($id === NULL)
		{
			show_404();exit;
		}

		switch($status)
		{
			case 0 	:	$action	= 'deactivate';	break;
			case 1 	:	$action	= 'activation';	break;
			case 2 	:	$action	= 'archiving';	break;
			case 3 	:	$action	= 'blocking';	break;
			default :	$action	= 'update';		break;
		}

		$<?=$model_name?>	= $this-><?=$model_name?>->get_by(array('<?=$table_pkey?>'=>$id));

		if($<?=$model_name?>)
		{
			$sqlData['status'] 	= $status;

			$update 	= $this-><?=$model_name?>->update($<?=$model_name?>-><?=$table_pkey?>,$sqlData);

			if ($update)
			{
        		return array('code'=>200,'class'=>'success','icon'=>'check','status'=>'success','text'=>$this->lang->line('notification_'.$action.'_success'));
			}
		}
		return array('code'=>406,'class'=>'danger','icon'=>'times','status'=>'error','text'=>$this->lang->line('notification_'.$action.'_failed'));
    }
