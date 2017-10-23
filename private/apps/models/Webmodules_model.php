<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Webmodules_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Webmodules_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Webmodules_model extends APP_Model
{
    protected $_table   = 'webmodules';

	protected $primary_key	= 'webmodules_id';

    public $protected_attributes = array( 'webmodules_id' );

    protected $soft_delete = FALSE;

	public function __construct()
	{
        parent::__construct();
	}

	public function get_by_modules($condition=array())
	{
        $where = func_get_args();

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $this->_database->where($this->soft_delete_key, $this->_temporary_only_deleted);
        }

		$this->_set_where($where);

        $this->trigger('before_get');

        $sql	=  "SELECT wmo.*, wro.*
					FROM webmodules wmo
					LEFT JOIN webroutes wro ON (wmo.webmodules_id = wro.webmodules_id)
					WHERE ";

		if(isset($condition['class']))
		{
			$sql	.= "wmo.webmodules_class = '".$condition['class']."' AND wmo.webmodules_method = '".((isset($condition['method'])) ? $condition['method'] : "index")."' ";
		}
		if(isset($condition['uri']))
		{
			$sql	.= ((isset($condition['class'])) ? "AND " : "").("(wmo.webmodules_uri_routes = '".$condition['uri']."' OR wmo.webmodules_uri_routes LIKE '%".$condition['uri']."%')");
		}

        $row = $this->_database->query($sql)
                        ->{$this->_return_type()}();
        $this->_temporary_return_type = $this->return_type;

        $row = $this->trigger('after_get', $row);

        $this->_with = array();
        return $row;

		$result = $this->get_by(array('webmodules_class'=>$webmodules_class,'webmodules_method'=>$webmodules_method));

		if(count($result) > 0)
		{
			return $result;
		}

		return FALSE;
	}

    public function datatables_populated($get_filtered_data)
    {
        if($get_filtered_data && count($get_filtered_data) > 0)
        {
        	$this->load->model('groups_model','groups');

            foreach ($get_filtered_data as $idxRow => $row)
            {
                $return[$idxRow]                    = $row;
                $return[$idxRow]->DT_RowId          = 'row_'.$row->{$this->primary_key};
                $return[$idxRow]->DT_RowData        = new stdClass();
                $return[$idxRow]->DT_RowData->pkey  = $row->{$this->primary_key};
                
            	$groups	= unserialize($row->groups_access);
                $return[$idxRow]->groups			= $groups;

                $return[$idxRow]->groups_access		= [];
                if($groups && count($groups) > 0)
                {
	            	foreach ($groups as $key => $group)
	            	{
	            		$getGroup = $this->groups->get($group);
	            		$return[$idxRow]->groups_access[$getGroup->groups_id] = $getGroup->groups_description;
	            	}
                }
            }
            return $return;
        }
        return array();
    }
}


/* End of file Webmodules_model.php */
/* Location: private/apps/models/Webmodules_model.php */


