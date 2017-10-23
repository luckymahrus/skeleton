<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Loginhistory_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Loginhistory_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Loginhistory_model extends APP_Model
{
    protected $_table   = 'loginhistory';

	protected $primary_key	= 'loginhistory_id';

    public $protected_attributes = array( 'loginhistory_id' );

	public function __construct()
	{
        parent::__construct();
	}
}


/* End of file Loginhistory_model.php */
/* Location: private/apps/models/Loginhistory_model.php */


