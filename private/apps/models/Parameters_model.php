<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Parameters_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Parameters_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Parameters_model extends APP_Model
{

    protected $_table   = 'xbase_params';

	protected $primary_key	= 'id';

    public $protected_attributes = array( 'id' );

	public function __construct()
	{
        parent::__construct();
	}

}


/* End of file Parameters_model.php */
/* Location: private/apps/models/Parameters_model.php */


