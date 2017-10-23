<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Webroutes_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Webroutes_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Webroutes_model extends APP_Model
{
    protected $_table   = 'webroutes';

	protected $primary_key	= 'webroutes_id';

    public $protected_attributes = array( 'webroutes_id' );

    protected $soft_delete = FALSE;

	public function __construct()
	{
        parent::__construct();
	}

    public function datatables_customize_filtered()
    {
        $this->db->select(array($this->table().'.*','webmodules.webmodules_title','webmodules.webmodules_uri_routes'));
        $this->db->join('webmodules','webmodules.webmodules_id = webroutes.webmodules_id','left');
    }

    public function datatables_customize_all()
    {
        $this->datatables_customize_filtered();
    }

    public function datatables_order($columns,$orders)
    {
        $this->_database->order_by($this->table().'.webroutes_order', 'asc');

        if($orders)
        {
            foreach ($orders as $idxOrd => $order)
            {
                if($columns[$order['column']]['orderable'] == "true")
                {
                    $this->_database->order_by($columns[$order['column']]['data'], $order['dir']);
                }
            }
        }
    }
}


/* End of file Webroutes_model.php */
/* Location: private/apps/models/Webroutes_model.php */


