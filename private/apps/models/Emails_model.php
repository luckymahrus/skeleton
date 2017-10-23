<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Emails_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Emails_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Emails_model extends APP_Model
{
    protected $_table   = 'emails';

	protected $primary_key	= 'emails_id';

    public $protected_attributes = array( 'emails_id' );

	public function __construct()
	{
        parent::__construct();
	}
}


/* End of file Emails_model.php */
/* Location: private/apps/models/Emails_model.php */


