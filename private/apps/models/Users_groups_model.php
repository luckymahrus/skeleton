<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Users_groups_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Users_groups_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Users_groups_model extends APP_Model
{
    protected $_table   = 'users_groups';

	protected $primary_key	= 'users_groups_id';

    protected $soft_delete = FALSE;

    public $protected_attributes = array( 'users_groups_id' );

    public $belongs_to = array(
    							'users'		=> array(
	    											'model' 		=> 'users_model',
	    											'primary_key' 	=> 'users_id'
    											),
    							'groups'	=> array(
	    											'model' 		=> 'groups_model',
	    											'primary_key' 	=> 'groups_id'
    											)
    						);

	public function __construct()
	{
        parent::__construct();
	}
}


/* End of file Users_groups_model.php */
/* Location: private/apps/models/Users_groups_model.php */


