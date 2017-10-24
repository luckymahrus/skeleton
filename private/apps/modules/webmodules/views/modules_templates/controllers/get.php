	public function get()
	{
		if(@$this->input->get_post('format') == 'datatables')
		{
			$response 	= $this-><?=$model_name?>->datatables();
		}
		else
		{
			$response 	= $this-><?=$model_name?>->get_all();
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
