<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Uploadsrelations_model.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/models/Uploadsrelations_model.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class Uploadsrelations_model extends APP_Model
{
    protected $_table   = 'uploadsrelations';

	protected $primary_key	= 'uploadsrelations_id';

    public $protected_attributes = array( 'uploadsrelations_id' );

	public function __construct()
	{
        parent::__construct();
	}
}


/* End of file Uploadsrelations_model.php */
/* Location: private/apps/models/Uploadsrelations_model.php */


