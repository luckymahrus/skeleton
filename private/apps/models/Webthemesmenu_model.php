<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Webthemesmenu_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Webthemesmenu_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Webthemesmenu_model extends APP_Model
{
    protected $_table   = 'webthemesmenu';

	protected $primary_key	= 'webthemesmenu_id';

    public $protected_attributes = array( 'webthemesmenu_id' );

    protected $soft_delete = FALSE;

	public function __construct()
	{
        parent::__construct();
	}
	
    public function datatables_customize_all()
    {
        $this->db->select(array($this->_table.'.*','webthemes.webthemes_name','webthemes.webthemes_title','webthemes.webthemes_description'));
        $this->_database->join('webthemes','webthemes.webthemes_id='.$this->_table.'.webthemes_id','left');
        $this->_database->where('webthemes.is_deleted',0);
    }

    public function datatables_customize_filtered()
    {
    	$this->datatables_customize_all();
    }
}


/* End of file Webthemesmenu_model.php */
/* Location: private/apps/models/Webthemesmenu_model.php */


