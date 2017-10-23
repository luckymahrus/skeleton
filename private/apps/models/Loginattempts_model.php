<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Loginattempts_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Loginattempts_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Loginattempts_model extends APP_Model
{
    protected $_table   = 'loginattempts';

	protected $primary_key	= 'loginattempts_id';

    public $protected_attributes = array( 'loginattempts_id' );

	public function __construct()
	{
        parent::__construct();
	}
}


/* End of file Loginattempts_model.php */
/* Location: private/apps/models/Loginattempts_model.php */


