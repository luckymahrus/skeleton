<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Cisessions_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Cisessions_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Cisessions_model extends APP_Model
{
    protected $_table   = 'cisessions';

	protected $primary_key	= 'id';

    public $protected_attributes = array( 'id' );

	public function __construct()
	{
        parent::__construct();
	}
}


/* End of file Cisessions_model.php */
/* Location: private/apps/models/Cisessions_model.php */


