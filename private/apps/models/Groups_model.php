<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Groups_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Groups_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Groups_model extends APP_Model
{
    protected $_table   = 'groups';

	protected $primary_key	= 'groups_id';

    protected $soft_delete = FALSE;

    public $protected_attributes = array( 'groups_id' );

	public function __construct()
	{
        parent::__construct();
	}
}


/* End of file Groups_model.php */
/* Location: private/apps/models/Groups_model.php */


