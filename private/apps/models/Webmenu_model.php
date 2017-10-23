<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Webmenu_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Webmenu_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Webmenu_model extends APP_Model
{
    protected $_table   = 'webmenu';

	protected $primary_key	= 'webmenu_id';

    public $protected_attributes = array( 'webmenu_id' );

    protected $soft_delete = FALSE;

	public function __construct()
	{
        parent::__construct();
	}

    public function datatables_customize_filtered()
    {
        $this->db->select(array($this->table().'.*','webmodules.webmodules_title','webmodules.webmodules_uri_routes'));
        $this->db->join('webmodules','webmodules.webmodules_id = webmenu.webmodules_id','left');
        $this->db->join('webthemesmenu','webthemesmenu.webthemesmenu_id = webmenu.webthemesmenu_id','left');
        $this->db->join('webthemes','webthemes.webthemes_id = webthemesmenu.webthemes_id','left');
    }

    public function datatables_customize_all()
    {
        $this->datatables_customize_filtered();
    }

    public function datatables_populated($get_filtered_data)
    {
        if($get_filtered_data && count($get_filtered_data) > 0)
        {
            foreach ($get_filtered_data as $idxRow => $row)
            {
                $return[$idxRow]                    = $row;
                $return[$idxRow]->DT_RowId          = 'row_'.$row->{$this->primary_key};
                $return[$idxRow]->DT_RowData        = new stdClass();
                $return[$idxRow]->DT_RowData->pkey  = $row->{$this->primary_key};
            }
            return $return;
        }
        return array();
    }

	public function getWebmenu($need_login=0,$group_id='0')
	{
        $this->_database->join('webmodules','webmodules.webmodules_id = '.$this->_table.'.webmodules_id','left');
        $this->_database->join('webthemesmenu','webthemesmenu.webthemesmenu_id = '.$this->_table.'.webthemesmenu_id','left');
        $this->_database->join('webthemes','webthemes.webthemes_id = webthemesmenu.webthemes_id','left');
        $this->_database->where($this->_table.'.status','1');
        $this->_database->order_by($this->_table.'.webmenu_parent_id ','asc');
        $this->_database->order_by($this->_table.'.webmenu_order','asc');

        return $this->get_all();
	}
}


/* End of file Webmenu_model.php */
/* Location: private/apps/models/Webmenu_model.php */


