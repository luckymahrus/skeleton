<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Uploads_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Uploads_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Uploads_model extends APP_Model
{
    protected $_table   = 'uploads';

	protected $primary_key	= 'uploads_id';

    public $protected_attributes = array( 'uploads_id' );

	public function __construct()
	{
        parent::__construct();

		$this->soft_delete	= $this->config->item('uploads')['soft_delete'];
	}
}


/* End of file Uploads_model.php */
/* Location: private/apps/models/Uploads_model.php */


