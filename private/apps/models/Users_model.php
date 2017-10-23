<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Users_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Users_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Users_model extends APP_Model
{
    protected $_table   = 'users';

	protected $primary_key	= 'users_id';

    public $protected_attributes = array( 'users_id' );

    protected $dt_grouped   = 'users.users_id';

	public function __construct()
	{
        parent::__construct();
	}

    public function datatables_customize_all()
    {
        $this->db->select(array($this->_table.'.users_id',$this->_table.'.users_first_name',$this->_table.'.users_last_name',$this->_table.'.users_email',$this->_table.'.users_avatar',$this->_table.'.users_last_login',$this->_table.'.status'));
    }

    public function datatables_customize_filtered()
    {
    	$this->datatables_customize_all();
        $this->_database->join('usersgroups','usersgroups.users_id=users.users_id','left');
        $this->_database->join('groups','groups.groups_id=usersgroups.groups_id','left');
    }

    public function datatables_populated($get_filtered_data)
    {
        if($get_filtered_data && count($get_filtered_data) > 0)
        {
        	$this->load->model('usersgroups_model','usersgroups');
            foreach ($get_filtered_data as $idxRow => $row)
            {
                $groups = array();
            	$usersgroups = $this->usersgroups->with('groups')->get_many_by('users_id',$row->{$this->primary_key});
            	if($usersgroups)
            	{
            		foreach($usersgroups as $idxUG => $group)
            		{
            			$groups[$group->groups_id]	= $group->groups;
            		}
            	}
                $return[$idxRow]                    = $row;
                $return[$idxRow]->groups            = @$groups;
                $return[$idxRow]->DT_RowId          = 'row_'.$row->{$this->primary_key};
                $return[$idxRow]->DT_RowData        = new stdClass();
                $return[$idxRow]->DT_RowData->pkey  = $row->{$this->primary_key};
            }
            return $return;
        }
        return array();
    }
}


/* End of file Users_model.php */
/* Location: private/apps/models/Users_model.php */


