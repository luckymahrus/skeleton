<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Webthemes_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Webthemes_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Webthemes_model extends APP_Model
{
    protected $_table   = 'webthemes';

	protected $primary_key	= 'webthemes_id';

    public $protected_attributes = array( 'webthemes_id' );

    protected $soft_delete = FALSE;

	public function __construct()
	{
        parent::__construct();
	}
}


/* End of file Webthemes_model.php */
/* Location: private/apps/models/Webthemes_model.php */


