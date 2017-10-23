<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Suppliers_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Suppliers_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Suppliers_model extends APP_Model
{
    protected $_table   = 'xbase_corps';

	protected $primary_key	= 'id';

    protected $soft_delete = FALSE;

    public $protected_attributes = array( 'id' );

	public function __construct()
	{
        parent::__construct();
	}

	
    
}


/* End of file Suppliers_model.php */
/* Location: private/apps/models/Suppliers_model.php */

