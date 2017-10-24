<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Model
*
* Version: 2.5.2
*
* Author:  Ben Edmunds
* 		   ben.edmunds@gmail.com
*	  	   @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Last Change: 3.22.13
*
* Changelog:
* * 3-22-13 - Additional entropy added - 52aa456eef8b60ad6754b31fbdcc77bb
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Ion_auth_model extends CI_Model
{
	/**
	 * Holds an array of tables used
	 *
	 * @var array
	 **/
	public $tables = array();

	/**
	 * activation code
	 *
	 * @var string
	 **/
	public $activation_code;

	/**
	 * forgotten password key
	 *
	 * @var string
	 **/
	public $forgotten_password_code;

	/**
	 * new password
	 *
	 * @var string
	 **/
	public $new_password;

	/**
	 * Identity
	 *
	 * @var string
	 **/
	public $identity;

	/**
	 * Where
	 *
	 * @var array
	 **/
	public $_ion_where = array();

	/**
	 * Select
	 *
	 * @var array
	 **/
	public $_ion_select = array();

	/**
	 * Like
	 *
	 * @var array
	 **/
	public $_ion_like = array();

	/**
	 * Limit
	 *
	 * @var string
	 **/
	public $_ion_limit = NULL;

	/**
	 * Offset
	 *
	 * @var string
	 **/
	public $_ion_offset = NULL;

	/**
	 * Order By
	 *
	 * @var string
	 **/
	public $_ion_order_by = NULL;

	/**
	 * Order
	 *
	 * @var string
	 **/
	public $_ion_order = NULL;

	/**
	 * Hooks
	 *
	 * @var object
	 **/
	protected $_ion_hooks;

	/**
	 * Response
	 *
	 * @var string
	 **/
	protected $response = NULL;

	/**
	 * message (uses lang file)
	 *
	 * @var string
	 **/
	protected $messages;

	/**
	 * error message (uses lang file)
	 *
	 * @var string
	 **/
	protected $errors;

	/**
	 * error start delimiter
	 *
	 * @var string
	 **/
	protected $error_start_delimiter;

	/**
	 * error end delimiter
	 *
	 * @var string
	 **/
	protected $error_end_delimiter;

	/**
	 * caching of users and their groups
	 *
	 * @var array
	 **/
	public $_cache_user_in_group = array();

	/**
	 * caching of groups
	 *
	 * @var array
	 **/
	protected $_cache_groups = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->config('ion_auth', TRUE);
		$this->load->helper('cookie');
		$this->load->helper('date');
		$this->load->library('google_authenticator');
		$this->lang->load('ion_auth');

		//initialize db tables data
		$this->tables  = $this->config->item('tables');

		//initialize data
		$this->identity_column 		= (($this->config->item('identity')) ? $this->config->item('identity') : $this->config->item('identity','ion_auth'));
		$this->store_salt      		= (($this->config->item('store_salt')) ? $this->config->item('store_salt') : $this->config->item('store_salt','ion_auth'));
		$this->salt_length     		= (($this->config->item('salt_length')) ? $this->config->item('salt_length') : $this->config->item('salt_length','ion_auth'));
		$this->join			   		= (($this->config->item('join')) ? $this->config->item('join') : $this->config->item('join','ion_auth'));
		$this->otp		   	   		= (($this->config->item('otp')) ? $this->config->item('otp') : $this->config->item('otp','ion_auth'));
		$this->store_login_history	= (($this->config->item('store_login_history')) ? $this->config->item('store_login_history') : $this->config->item('store_login_history','ion_auth'));


		//initialize hash method options (Bcrypt)
		$this->hash_method			= $this->config->item('hash_method');
		$this->default_rounds		= $this->config->item('default_rounds');
		$this->random_rounds		= $this->config->item('random_rounds');
		$this->min_rounds			= $this->config->item('min_rounds');
		$this->max_rounds			= $this->config->item('max_rounds');


		//initialize messages and error
		$this->messages    = array();
		$this->errors      = array();
		$delimiters_source = $this->config->item('delimiters_source');

		//load the error delimeters either from the config file or use what's been supplied to form validation
		if ($delimiters_source === 'form_validation')
		{
			//load in delimiters from form_validation
			//to keep this simple we'll load the value using reflection since these properties are protected
			$this->load->library('form_validation');
			$form_validation_class = new ReflectionClass("CI_Form_validation");

			$error_prefix = $form_validation_class->getProperty("_error_prefix");
			$error_prefix->setAccessible(TRUE);
			$this->error_start_delimiter = $error_prefix->getValue($this->form_validation);
			$this->message_start_delimiter = $this->error_start_delimiter;

			$error_suffix = $form_validation_class->getProperty("_error_suffix");
			$error_suffix->setAccessible(TRUE);
			$this->error_end_delimiter = $error_suffix->getValue($this->form_validation);
			$this->message_end_delimiter = $this->error_end_delimiter;
		}
		else
		{
			//use delimiters from config
			$this->message_start_delimiter = $this->config->item('message_start_delimiter');
			$this->message_end_delimiter   = $this->config->item('message_end_delimiter');
			$this->error_start_delimiter   = $this->config->item('error_start_delimiter');
			$this->error_end_delimiter     = $this->config->item('error_end_delimiter');
		}


		//initialize our hooks object
		$this->_ion_hooks = new stdClass;

		//load the bcrypt class if needed
		if ($this->hash_method == 'bcrypt') {
			if ($this->random_rounds)
			{
				$rand = rand($this->min_rounds,$this->max_rounds);
				$params = array('rounds' => $rand);
			}
			else
			{
				$params = array('rounds' => $this->default_rounds);
			}

			$params['salt_prefix'] = $this->config->item('salt_prefix');
			$this->load->library('bcrypt',$params);
		}

		$this->trigger_events('model_constructor');
	}

	/**
	 * Misc functions
	 *
	 * Hash password : Hashes the password to be stored in the database.
	 * Hash password db : This function takes a password and validates it
	 * against an entry in the users table.
	 * Salt : Generates a random salt value.
	 *
	 * @author Mathew
	 */

	/**
	 * Hashes the password to be stored in the database.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function hash_password($password, $salt=false, $use_sha1_override=FALSE)
	{
		if (empty($password))
		{
			return FALSE;
		}

		//bcrypt
		if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt')
		{
			return $this->bcrypt->hash($password);
		}


		if ($this->store_salt && $salt)
		{
			return  sha1($password . $salt);
		}
		else
		{
			$salt = $this->salt();
			return  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}
	}

	/**
	 * This function takes a password and validates it
	 * against an entry in the users table.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function hash_password_db($id, $password, $use_sha1_override=FALSE)
	{
		if (empty($id) || empty($password))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('users_password, users_salt')
		                  ->where($this->tables['users']['primary_key'], $id)
		                  ->limit(1)
		                  ->order_by($this->tables['users']['primary_key'], 'desc')
		                  ->get($this->tables['users']['name']);

		$hash_password_db = $query->row();

		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}

		// bcrypt
		if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt')
		{
			if ($this->bcrypt->verify($password,$hash_password_db->users_password))
			{
				return TRUE;
			}

			return FALSE;
		}

		// sha1
		if ($this->store_salt)
		{
			$db_password = sha1($password . $hash_password_db->users_salt);
		}
		else
		{
			$salt = substr($hash_password_db->users_password, 0, $this->salt_length);

			$db_password =  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}

		if($db_password == $hash_password_db->users_password)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Generates a random salt value for forgotten passwords or any other keys. Uses SHA1.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function hash_code($password)
	{
		return $this->hash_password($password, FALSE, TRUE);
	}

	/**
	 * Generates a random salt value.
	 *
	 * Salt generation code taken from https://github.com/ircmaxell/password_compat/blob/master/lib/password.php
	 *
	 * @return void
	 * @author Anthony Ferrera
	 **/
	public function salt()
	{

		$raw_salt_len = 16;

 		$buffer = '';
        $buffer_valid = false;

        if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
            $buffer = mcrypt_create_iv($raw_salt_len, MCRYPT_DEV_URANDOM);
            if ($buffer) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
            $buffer = openssl_random_pseudo_bytes($raw_salt_len);
            if ($buffer) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid && @is_readable('/dev/urandom')) {
            $f = fopen('/dev/urandom', 'r');
            $read = strlen($buffer);
            while ($read < $raw_salt_len) {
                $buffer .= fread($f, $raw_salt_len - $read);
                $read = strlen($buffer);
            }
            fclose($f);
            if ($read >= $raw_salt_len) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid || strlen($buffer) < $raw_salt_len) {
            $bl = strlen($buffer);
            for ($i = 0; $i < $raw_salt_len; $i++) {
                if ($i < $bl) {
                    $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
                } else {
                    $buffer .= chr(mt_rand(0, 255));
                }
            }
        }

        $salt = $buffer;

        // encode string with the Base64 variant used by crypt
        $base64_digits   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        $bcrypt64_digits = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $base64_string   = base64_encode($salt);
        $salt = strtr(rtrim($base64_string, '='), $base64_digits, $bcrypt64_digits);

	    $salt = substr($salt, 0, $this->salt_length);


		return $salt;

	}

	/**
	 * Activation functions
	 *
	 * Activate : Validates and removes activation code.
	 * Deactivae : Updates a users row with an activation code.
	 *
	 * @author Mathew
	 */

	/**
	 * activate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function activate($id, $code = false)
	{
		$this->trigger_events('pre_activate');

		if ($code !== FALSE)
		{
			$query = $this->db->select($this->identity_column)
			                  ->where('users_activation_code', $code)
			                  ->where($this->tables['users']['primary_key'], $id)
			                  ->limit(1)
	    				  	  ->order_by($this->tables['users']['primary_key'], 'desc')
			                  ->get($this->tables['users']['name']);

			$result = $query->row();

			if ($query->num_rows() !== 1)
			{
				$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
				$this->set_error('activate_unsuccessful');
				return FALSE;
			}

			$data = array(
			    'users_activation_code' => NULL,
			    'status'          	  => 1
			);

			$this->trigger_events('extra_where');
			$this->db->update($this->tables['users']['name'], $data, array($this->tables['users']['primary_key'] => $id));
		}
		else
		{
			$data = array(
			    'users_activation_code' => NULL,
			    'status'          	  => 1
			);


			$this->trigger_events('extra_where');
			$this->db->update($this->tables['users']['name'], $data, array($this->tables['users']['primary_key'] => $id));
		}


		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->trigger_events(array('post_activate', 'post_activate_successful'));
			$this->set_message('activate_successful');
		}
		else
		{
			$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
			$this->set_error('activate_unsuccessful');
		}


		return $return;
	}


	/**
	 * Deactivate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function deactivate($id = NULL)
	{
		$this->trigger_events('deactivate');

		if (!isset($id))
		{
			$this->set_error('deactivate_unsuccessful');
			return FALSE;
		}

		$activation_code       = sha1(md5(microtime()));
		$this->activation_code = $activation_code;

		$data = array(
		    'users_activation_code' => $activation_code,
		    'status'          	  => 0
		);

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users']['name'], $data, array($this->tables['users']['primary_key'] => $id));

		$return = $this->db->affected_rows() == 1;
		if ($return){
			//$this->set_message('deactivate_successful');
		}
		else{
			$this->set_error('deactivate_unsuccessful');
		}

		return $return;
	}

	public function clear_forgotten_password_code($code) {

		if (empty($code))
		{
			return FALSE;
		}

		$this->db->where('forgotten_password_code', $code);

		if ($this->db->count_all_results($this->tables['users']['name']) > 0)
		{
			$data = array(
			    'forgotten_password_code' => NULL,
			    'forgotten_password_time' => NULL
			);

			$this->db->update($this->tables['users']['name'], $data, array('forgotten_password_code' => $code));

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * reset password
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function reset_password($identity, $new) {
		$this->trigger_events('pre_change_password');

		if (!$this->identity_check($identity)) {
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select($this->tables['users']['primary_key'].', users_password, users_salt')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
	    			  ->order_by($this->tables['users']['primary_key'], 'desc')
		                  ->get($this->tables['users']['name']);

		if ($query->num_rows() !== 1)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$result = $query->row();

		$new = $this->hash_password($new, $result->users_salt);

		//store the new password and reset the remember code so all remembered instances have to re-login
		//also clear the forgotten password code
		$data = array(
		    'users_password' => $new,
		    'remember_code' => NULL,
		    'forgotten_password_code' => NULL,
		    'forgotten_password_time' => NULL,
		);

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users']['name'], $data, array($this->identity_column => $identity));

		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_successful'));
			$this->set_message('password_change_successful');
		}
		else
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
		}

		return $return;
	}

	/**
	 * change password
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function change_password($identity, $old, $new)
	{
		$this->trigger_events('pre_change_password');

		$this->trigger_events('extra_where');

		$query = $this->db->select('id, password, salt')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
		  		  ->order_by('id', 'desc')
		                  ->get($this->tables['users']['name']);

		if ($query->num_rows() !== 1)
		{
			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$user = $query->row();

		$old_password_matches = $this->hash_password_db($user->{$this->tables['users']['primary_key']}, $old);

		if ($old_password_matches === TRUE)
		{
			//store the new password and reset the remember code so all remembered instances have to re-login
			$hashed_new_password  = $this->hash_password($new, $user->salt);
			$data = array(
			    'password' => $hashed_new_password,
			    'remember_code' => NULL,
			);

			$this->trigger_events('extra_where');

			$successfully_changed_password_in_db = $this->db->update($this->tables['users']['name'], $data, array($this->identity_column => $identity));
			if ($successfully_changed_password_in_db)
			{
				$this->trigger_events(array('post_change_password', 'post_change_password_successful'));
				$this->set_message('password_change_successful');
			}
			else
			{
				$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
				$this->set_error('password_change_unsuccessful');
			}

			return $successfully_changed_password_in_db;
		}

		$this->set_error('password_change_unsuccessful');
		return FALSE;
	}

	/**
	 * Checks username
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function username_check($username = '')
	{
		$this->trigger_events('username_check');

		if (empty($username))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		return $this->db->where('users_username', $username)
				->order_by($this->tables['users']['primary_key'], "ASC")
				->limit(1)
		                ->count_all_results($this->tables['users']['name']) > 0;
	}

	/**
	 * Checks email
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function email_check($email = '')
	{
		$this->trigger_events('email_check');

		if (empty($email))
		{
			return FALSE;
		}

		$this->trigger_events('extra_where');

		return $this->db->where('users_email', $email)
				->order_by("id", "ASC")
				->limit(1)
		                ->count_all_results($this->tables['users']['name']) > 0;
	}

	/**
	 * Identity check
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function identity_check($identity = '')
	{
		$this->trigger_events('identity_check');

		if (empty($identity))
		{
			return FALSE;
		}

		return $this->db->where($this->identity_column, $identity)
		                ->count_all_results($this->tables['users']['name']) > 0;
	}

	/**
	 * Insert a otp login activation key.
	 *
	 * @return bool
	 * @author Mathew, Ryan and SpyTec 
	 **/
	public function set_otp_login_activation($identity)
	{
		if (empty($identity) || !$this->otp['enabled'])
		{
			$this->trigger_events(array('post_set_otp_activation', 'post_set_otp_activation_unsuccessful'));
			return FALSE;
		}

		//All some more randomness
		$activation_code_part = "";
		if(function_exists("openssl_random_pseudo_bytes")) {
			$activation_code_part = openssl_random_pseudo_bytes(128);
		}

		for($i=0;$i<1024;$i++) {
			$activation_code_part = sha1($activation_code_part . mt_rand() . microtime());
		}

		$key = $this->hash_code($activation_code_part.$identity);

		$this->forgotten_password_code = $key;

		$this->trigger_events('extra_where');

		//Possibly add an expire for extra security
		$update['users_otp_login_code'] = $key;

		$this->db->update($this->tables['users']['name'], $update, array($this->identity_column => $identity));

		$return = $this->db->affected_rows() == 1;

		if ($return)
			$this->trigger_events(array('post_set_otp_activation', 'post_set_otp_activation_successful'));
		else
			$this->trigger_events(array('post_set_otp_activation', 'post_set_otp_activation_unsuccessful'));

		return $return;
	}

	/**
	 * Insert a otp login activation key.
	 *
	 * @return bool
	 * @author Mathew, Ryan and SpyTec 
	 **/
	public function set_otp_login_activation2($identity)
	{
		if (empty($identity) || !$this->otp['enabled'])
		{
			$this->trigger_events(array('post_set_otp_activation', 'post_set_otp_activation_unsuccessful'));
			return FALSE;
		}

		//All some more randomness
		$activation_code_part = "";
		if(function_exists("openssl_random_pseudo_bytes")) {
			$activation_code_part = openssl_random_pseudo_bytes(128);
		}

		for($i=0;$i<1024;$i++) {
			$activation_code_part = sha1($activation_code_part . mt_rand() . microtime());
		}

		$key = $this->hash_code($activation_code_part.$identity);

		$this->forgotten_password_code = $key;

		$this->trigger_events(array('post_set_otp_activation', 'post_set_otp_activation_successful'));

		return $key;
	}

	/**
	 * Insert a otp login activation key.
	 *
	 * @return bool
	 * @author Mathew, Ryan and SpyTec 
	 **/
	public function get_otp_login_activation($identity)
	{
		if (empty($identity) || !$this->otp['enabled'])
		{
			$this->trigger_events(array('post_get_otp_activation', 'post_get_otp_activation_unsuccessful'));
			return FALSE;
		}

		$this->db->where($this->identity_column, $identity);
		$this->db->select('users_otp_login_code');
		$query = $this->db->get('users');

		$return = $query->row();

		return $return->users_otp_login_code;
	}

	/**
	 * Insert OTP backup codes
	 * Encrypted with CI encrypt library
	 *
	 * @return mixed
	 * @author Mathew, Ryan & SpyTec
	 **/
	public function backup_codes($id)
	{
		if (empty($id) || !$this->otp['enabled'])
		{
			$this->trigger_events(array('post_backup_codes', 'post_backup_codes_unsuccessful'));
			return FALSE;
		}

		//All some more randomness
		$backup_code_part = "";
		if(function_exists("openssl_random_pseudo_bytes")) {
			$backup_code_part = openssl_random_pseudo_bytes(128);
		}

		$backup_codes = array();
		for($n=0;$n<$this->otp['backup_codes_length'];$n++)
		{
			for($i=0;$i<1024;$i++) {
				$backup_code_part = substr(sha1($backup_code_part . mt_rand() . microtime()), 0, 10);
			}
			
			// Only take a specific length from the hash_code function for easier login for users
			$key = substr($this->hash_code($backup_code_part.$id), 0, $this->otp['backup_codes_length']);
			array_push($backup_codes, $key);
		}
		#$this->forgotten_password_code = $key;

		$this->trigger_events('extra_where');

		$this->load->library('encrypt');
		$update = array(
		    'users_otpBackupCodes' => $this->encrypt->encode(serialize($backup_codes))
		);

		$this->db->where($this->tables['users']['primary_key'], $id);
		$this->db->update($this->tables['users']['name'], $update);

		$return = $this->db->affected_rows() == 1;

		if ($return)
		{
			$this->trigger_events(array('post_backup_codes', 'post_backup_codes_successful'));
			return TRUE;
		}
		else
		{
			$this->trigger_events(array('post_backup_codes', 'post_backup_codes_unsuccessful'));
			return FALSE;
		}
	}

	/**
	 * Insert OTP backup codes
	 * Encrypted with CI encrypt library
	 *
	 * @return mixed
	 * @author Mathew, Ryan & SpyTec
	 **/
	public function backup_codes2($id)
	{
		if (empty($id) || !$this->otp['enabled'])
		{
			$this->trigger_events(array('post_backup_codes', 'post_backup_codes_unsuccessful'));
			return FALSE;
		}

		//All some more randomness
		$backup_code_part = "";
		if(function_exists("openssl_random_pseudo_bytes")) {
			$backup_code_part = openssl_random_pseudo_bytes(128);
		}

		$backup_codes = array();
		for($n=0;$n<$this->otp['backup_codes_length'];$n++)
		{
			for($i=0;$i<1024;$i++) {
				$backup_code_part = substr(sha1($backup_code_part . mt_rand() . microtime()), 0, 10);
			}
			
			// Only take a specific length from the hash_code function for easier login for users
			$key = substr($this->hash_code($backup_code_part.$id), 0, $this->otp['backup_codes_length']);
			array_push($backup_codes, $key);
		}
		#$this->forgotten_password_code = $key;

		$this->load->library('encrypt');

		$users_otpBackupCodes = $this->encrypt->encode(serialize($backup_codes));
		$this->trigger_events(array('post_backup_codes', 'post_backup_codes_successful'));
		return $users_otpBackupCodes;
	}

	/**
	 * Get backup codes from database
	 * Returns serialized PHP array
	 * @return string
	 * @author Mathew and SpyTec
	 **/
	public function backup_codes_db($id)
	{
		$this->trigger_events('pre_backup_codes_db');

		if (empty($id))
		{
			$this->trigger_events(array('post_backup_codes_db', 'post_backup_codes_db_unsuccessful'));
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('users_otpBackupCodes')
						  ->where($this->tables['users']['primary_key'], $this->db->escape_str($id))
						  ->limit(1)
						  ->get($this->tables['users']['name'])->row();

		if ($query) {
			$this->load->library('encrypt');
			$serialized_keys = $this->encrypt->decode($query->users_otpBackupCodes);
			$this->trigger_events(array('post_backup_codes_db', 'post_backup_codes_db_successful'));
			return $serialized_keys;
		}

		$this->trigger_events(array('post_backup_codes_db', 'post_backup_codes_db_unsuccessful'));
		return FALSE;
	}

	/**
	 * Get backup codes from database
	 * Returns serialized PHP array
	 * @return string
	 * @author Mathew and SpyTec
	 **/
	public function backup_codes_db2($id,$users_otpBackupCodes)
	{
		$this->trigger_events('pre_backup_codes_db');

		if (empty($id) || empty($users_otpBackupCodes))
		{
			$this->trigger_events(array('post_backup_codes_db', 'post_backup_codes_db_unsuccessful'));
			return FALSE;
		}

		$this->load->library('encrypt');
		$serialized_keys = $this->encrypt->decode($users_otpBackupCodes);
		$this->trigger_events(array('post_backup_codes_db', 'post_backup_codes_db_successful'));
		return $serialized_keys;
	}

	/**
	 * Remove backup code from backup code array
	 *
	 * @return bool
	 * @author SpyTec
	 **/
	public function delete_backup_code($id, $current_backup_codes = array(), $backup_code){
		$this->trigger_events('pre_delete_backup_code');
		if (!$this->otp['enabled'] || empty($id) || empty($current_backup_codes) || empty($backup_code))
		{
			return FALSE;
		}
		foreach ($current_backup_codes as $current_backup_code) {
			if($current_backup_code === $backup_code)
			{
				unset($current_backup_codes[$current_backup_code]);
			}
		}

		if(($key = array_search($backup_code, $current_backup_codes)) !== FALSE) {
		    unset($current_backup_codes[$key]);
		}
		if(empty($current_backup_codes))
		{
			$current_backup_codes = NULL;
		}
		else
		{
			$this->load->library('encrypt');
			$current_backup_codes = $this->encrypt->encode(serialize($current_backup_codes));
		}

		$this->db->select('users_otpBackupCodes');
		$this->db->where($this->tables['users']['primary_key'], $id);
		$data = array(
			"users_otpBackupCodes" => $current_backup_codes
		);
		if($this->db->update($this->tables['users']['name'], $data))
		{
			$this->trigger_events(array('post_delete_backup_code', 'post_delete_backup_code_successful'));
			return TRUE;
		}
		$this->trigger_events(array('post_delete_backup_code', 'post_delete_backup_code_unsuccessful'));
	}

	/**
	 * Checks database for backup codes and deletes if true
	 *
	 * @return bool
	 * @author SpyTec
	 **/
	public function is_backup_code_valid($id, $backup_code, $delete_backup_code = TRUE){
		if (!$this->otp['enabled'] || empty($id) || empty($backup_code))
		{
			return FALSE;
		}
		
		$this->db->select('users_otpBackupCodes');
		$this->db->where($this->tables['users']['primary_key'], $id);
		$query = $this->db->get($this->tables['users']['name']);

		if ($query->num_rows() === 1)
		{
			$user = $query->row();
			if($user->users_otpBackupCodes !== NULL)
			{
				$this->load->library('encrypt');
				$otp_backup_codes = unserialize($this->encrypt->decode($user->users_otpBackupCodes));
				foreach ($otp_backup_codes as $otp_backup_code) {
					if ($otp_backup_code === $backup_code) {
						if($delete_backup_code)
						{
							$this->delete_backup_code($id, $otp_backup_codes, $backup_code);
						}
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}

	/**
	 * Insert a forgotten password key.
	 *
	 * @return bool
	 * @author Mathew
	 * @updated Ryan
	 * @updated 52aa456eef8b60ad6754b31fbdcc77bb
	 **/
	public function forgotten_password($identity)
	{
		if (empty($identity))
		{
			$this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_unsuccessful'));
			return FALSE;
		}

		//All some more randomness
		$activation_code_part = "";
		if(function_exists("openssl_random_pseudo_bytes")) {
			$activation_code_part = openssl_random_pseudo_bytes(128);
		}

		for($i=0;$i<1024;$i++) {
			$activation_code_part = sha1($activation_code_part . mt_rand() . microtime());
		}

		$key = $this->hash_code($activation_code_part.$identity);

		// If enable query strings is set, then we need to replace any unsafe characters so that the code can still work
		if ($key != '' && $this->config->item('permitted_uri_chars') != '' && $this->config->item('enable_query_strings') == FALSE)
		{
			// preg_quote() in PHP 5.3 escapes -, so the str_replace() and addition of - to preg_quote() is to maintain backwards
			// compatibility as many are unaware of how characters in the permitted_uri_chars will be parsed as a regex pattern
			if ( ! preg_match("|^[".str_replace(array('\\-', '\-'), '-', preg_quote($this->config->item('permitted_uri_chars'), '-'))."]+$|i", $key))
			{
				$key = preg_replace("/[^".$this->config->item('permitted_uri_chars')."]+/i", "-", $key);
			}
		}

		$this->forgotten_password_code = $key;

		$this->trigger_events('extra_where');

		$update = array(
		    'forgotten_password_code' => str_replace(array('_','-'), '', $key),
		    'forgotten_password_time' => time()
		);

		$this->db->update($this->tables['users']['name'], $update, array($this->identity_column => $identity));

		$return = $this->db->affected_rows() == 1;

		if ($return)
			$this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_successful'));
		else
			$this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_unsuccessful'));

		return $return;
	}

	/**
	 * Forgotten Password Complete
	 *
	 * @return string
	 * @author Mathew
	 **/
	public function forgotten_password_complete($code, $salt=FALSE)
	{
		$this->trigger_events('pre_forgotten_password_complete');

		if (empty($code))
		{
			$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
			return FALSE;
		}

		$profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

		if ($profile) {

			if ($this->config->item('forgot_password_expiration') > 0) {
				//Make sure it isn't expired
				$expiration = $this->config->item('forgot_password_expiration');
				if (time() - $profile->forgotten_password_time > $expiration) {
					//it has expired
					$this->set_error('forgot_password_expired');
					$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
					return FALSE;
				}
			}

			$password = $this->salt();

			$data = array(
			    'password'                => $this->hash_password($password, $salt),
			    'forgotten_password_code' => NULL,
			 );

			$this->db->update($this->tables['users']['name'], $data, array('forgotten_password_code' => $code));

			$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_successful'));
			return $password;
		}

		$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
		return FALSE;
	}

	/**
	 * register
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function register($username, $password, $email, $additional_data = array(), $groups = array())
	{
		$this->trigger_events('pre_register');

		$manual_activation = $this->config->item('manual_activation');

		if ($this->identity_column == 'users_email' && $this->email_check($email))
		{
			$this->set_error('account_creation_duplicate_email');
			return FALSE;
		}
		elseif ($this->identity_column == 'users_username' && $this->username_check($username))
		{
			$this->set_error('account_creation_duplicate_username');
			return FALSE;
		}
		elseif ( !$this->config->item('default_group') && empty($groups) )
		{
			$this->set_error('account_creation_missing_default_group');
			return FALSE;
		}

		//check if the default set in config exists in database
		$query = $this->db->get_where($this->tables['groups']['name'],array('groups_name' => $this->config->item('default_group')),1)->row();
		if( !isset($query->groups_id) && empty($groups) ) 
		{
			$this->set_error('account_creation_invalid_default_group');
			return FALSE;
		}

		//capture default group details
		$default_group = $query;

		// If username is taken, use username1 or username2, etc.
		if ($this->identity_column != 'users_username')
		{
			$original_username = $username;
			for($i = 0; $this->username_check($username); $i++)
			{
				if($i > 0)
				{
					$username = $original_username . $i;
				}
			}
		}

		if($this->config->item('store_ori_password','ion_auth') == TRUE || ($this->config->item('store_ori_password') && $this->config->item('store_ori_password') == TRUE))
		{
			$data['users_password_ori']	= $password;
		}

		// IP Address
		$ip_address  = $this->_prepare_ip($this->input->ip_address());
		$salt        = $this->store_salt ? $this->salt() : FALSE;
		$password    = $this->hash_password($password, $salt);
		$currentTime = time();
		// Users table.

		$data['users_username']	= $username;
		$data['users_password']	= $password;
		$data['users_email' ]	= $email;
		$data['users_ip_address']	= $ip_address;
		$data['_created_by']		= $this->session->userdata('users_id');
		$data['_created_at']		= $currentTime;
		//$data['updated_by']		= $this->session->userdata('users_id');
		//$data['updated_time']	= $currentTime;
		//$data['users_last_login']	= $currentTime;
		$data['status']			= ($manual_activation === false ? 1 : 0);

		if ($this->store_salt)
		{
			$data['users_salt'] = $salt;
		}

		//filter out any data passed that doesnt have a matching column in the users table
		//and merge the set user data and the additional data
		$user_data = array_merge($this->_filter_data($this->tables['users']['name'], $additional_data), $data);

		$this->trigger_events('extra_set');

		$this->db->insert($this->tables['users']['name'], $user_data);

		$id = $this->db->insert_id();

		//add in groups array if it doesn't exits and stop adding into default group if default group ids are set
		if( isset($default_group->id) && empty($groups) )
		{
			$groups[] = $default_group->groups_id;
		}

		if (!empty($groups))
		{
			//add to groups
			foreach ($groups as $group)
			{
				$this->add_to_group($group, $id);
			}
		}

		$this->trigger_events('post_register');

		return (isset($id)) ? $id : FALSE;
	}

	/**
	 * register
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function register2($username, $password, $email, $additional_data = array(), $groups = array())
	{
		$this->trigger_events('pre_register');

		$manual_activation = $this->config->item('manual_activation');

		if ($this->identity_column == 'users_email' && $this->email_check($email))
		{
			$this->set_error('account_creation_duplicate_email');
			return FALSE;
		}
		elseif ($this->identity_column == 'users_username' && $this->username_check($username))
		{
			$this->set_error('account_creation_duplicate_username');
			return FALSE;
		}
		elseif ( !$this->config->item('default_group') && empty($groups) )
		{
			$this->set_error('account_creation_missing_default_group');
			return FALSE;
		}

		//check if the default set in config exists in database
		$query = $this->db->get_where($this->tables['groups']['name'],array('groups_name' => $this->config->item('default_group')),1)->row();
		if( !isset($query->groups_id) && empty($groups) ) 
		{
			$this->set_error('account_creation_invalid_default_group');
			return FALSE;
		}

		//capture default group details
		$default_group = $query;

		// If username is taken, use username1 or username2, etc.
		if ($this->identity_column != 'users_username')
		{
			$original_username = $username;
			for($i = 0; $this->username_check($username); $i++)
			{
				if($i > 0)
				{
					$username = $original_username . $i;
				}
			}
		}

		if($this->config->item('store_ori_password','ion_auth') == TRUE || ($this->config->item('store_ori_password') && $this->config->item('store_ori_password') == TRUE))
		{
			//$data['users_password_ori']	= $password;
		}

		// IP Address
		$ip_address  = $this->_prepare_ip($this->input->ip_address());
		//$salt        = $this->store_salt ? $this->salt() : FALSE;
		//$password    = $this->hash_password($password, $salt);
		$currentTime = time();
		// Users table.

		$data['users_username']	= $username;
		//$data['users_password']	= $password;
		$data['users_email' ]	= $email;
		$data['users_ip_address']	= $ip_address;
		$data['_created_by']		= $this->session->userdata('users_id');
		$data['_created_at']		= $currentTime;
		//$data['updated_by']		= $this->session->userdata('users_id');
		//$data['updated_time']	= $currentTime;
		//$data['users_last_login']	= $currentTime;
		$data['status']			= 1;

		/*if ($this->store_salt)
		{
			$data['users_salt'] = $salt;
		}*/

		//filter out any data passed that doesnt have a matching column in the users table
		//and merge the set user data and the additional data
		$user_data = array_merge($this->_filter_data($this->tables['users']['name'], $additional_data), $data);

		$this->trigger_events('extra_set');

		$this->db->insert($this->tables['users']['name'], $user_data);

		$id = $this->db->insert_id();

		//add in groups array if it doesn't exits and stop adding into default group if default group ids are set
		if( isset($default_group->id) && empty($groups) )
		{
			$groups[] = $default_group->groups_id;
		}

		if (!empty($groups))
		{
			//add to groups
			foreach ($groups as $group)
			{
				$this->add_to_group($group, $id);
			}
		}

		$this->trigger_events('post_register');

		return (isset($id)) ? $id : FALSE;
	}

	/**
	 * login
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function login($identity, $password, $remember=FALSE)
	{
		$this->trigger_events('pre_login');

		if (empty($identity) || empty($password))
		{
			$this->set_error('login_unsuccessful');
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select($this->identity_column . ', users_username, users_email, '.$this->tables['users']['primary_key'].', users_password, users_otp, users_last_login, users_first_name, users_last_name, users_avatar, status')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
	    			  	  ->order_by($this->tables['users']['primary_key'], 'desc')
		                  ->get($this->tables['users']['name']);

		if($this->is_time_locked_out($identity))
		{
			$this->db->where($this->identity_column, $identity)->update($this->tables['users']['name'], array('status'=>'3'));

			//Hash something anyway, just to take up time
			//$this->hash_password($password);

			$this->trigger_events('post_login_unsuccessful');
			$this->set_error('login_timeout');

			return FALSE;
		}

		if ($query->num_rows() === 1)
		{
			$user = $query->row();

			$password = $this->hash_password_db($user->{$this->tables['users']['primary_key']}, $password);

			if ($password === TRUE)
			{
				if ($user->status == 0)
				{
					$this->trigger_events('post_login_unsuccessful');
					$this->set_error('login_unsuccessful_not_active');

					return FALSE;
				}

				//Check database if multi-factor auth is enabled and if user has it enabled
				if ($user->users_otp === NULL || !$this->otp['enabled'])
				{
					$user->remember = $remember;

					$this->set_session($user);
					if($this->store_login_history)
					{
						$this->store_user_login_history($user);
					}

					$this->update_last_login($user->{$this->tables['users']['primary_key']});

					$this->clear_login_attempts($identity);

					if ($remember && $this->config->item('remember_users'))
					{
						$this->remember_user($user->{$this->tables['users']['primary_key']});
					}

					$this->trigger_events(array('post_login', 'post_login_successful'));
					$this->set_message('login_successful');
				}

				return TRUE;
			}
		}

		//Hash something anyway, just to take up time
		$this->hash_password($password);

		$this->increase_login_attempts($identity);

		$this->trigger_events('post_login_unsuccessful');
		$this->set_error('login_unsuccessful');

		return FALSE;
	}

	/**
	 * login
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function login_dev($identity, $password)
	{
		$this->trigger_events('pre_login_dev');

		if (empty($identity) || empty($password))
		{
			$this->set_error('login_dev_unsuccessful');
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select($this->identity_column . ', users_username, users_email, '.$this->tables['users']['primary_key'].', users_password, users_otp, users_last_login, users_first_name, users_last_name, users_avatar, status')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
	    			  	  ->order_by($this->tables['users']['primary_key'], 'desc')
		                  ->get($this->tables['users']['name']);

		if($this->is_time_locked_out($identity))
		{
			$this->trigger_events('post_login_dev_unsuccessful');
			$this->set_error('login_dev_timeout');

			return FALSE;
		}

		if ($query->num_rows() === 1)
		{
			$user = $query->row();

			$password = $this->hash_password_db($user->{$this->tables['users']['primary_key']}, $password);

			if ($password === TRUE)
			{
				if ($user->status == 0)
				{
					$this->trigger_events('post_login_dev_unsuccessful');
					$this->set_error('login_dev_unsuccessful_not_active');

					return FALSE;
				}

				$users_groups = $this->get_users_groups($user->{$this->tables['users']['primary_key']})->result();
				$groups_array = array();
				foreach ($users_groups as $group)
				{
					$groups_array[$group->groups_id] = $group->groups_name;
				}
				
				foreach ($this->config->item('admin_group') as $key => $value)
				{
					$groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

					if (in_array($value, $groups))
					{
						$this->session->set_userdata('is_maintenance_login',TRUE);
						$this->clear_login_attempts($identity);

						$this->trigger_events(array('post_login_dev', 'post_login_dev_successful'));
						$this->set_message(' Developer/Maintenance Mode Unlocked ');

						return TRUE;
					}
				}

				$this->trigger_events('post_login_dev_unsuccessful');
				$this->set_error('login_dev_unsuccessful');

				return FALSE;
			}
		}
		elseif($identity === $this->config->item('maintenance_mode_email') && $password === $this->config->item('maintenance_mode_password'))
		{
			$this->session->set_userdata('is_maintenance_login',TRUE);

			$this->trigger_events(array('post_login_dev', 'post_login_dev_successful'));
			$this->set_message(' Developer/Maintenance Mode Unlocked ');

			return TRUE;
		}

		$this->trigger_events('post_login_dev_unsuccessful');
		$this->set_error('login_dev_unsuccessful');

		return FALSE;
	}


	/**
	 * validate_user
	 *
	 * @return bool
	 * @author Lucky Mahrus
	 **/
	public function validate_user($identity, $password)
	{
		$this->trigger_events('pre_validate_user');

		if (empty($identity) || empty($password))
		{
			$this->set_error('validate_user_unsuccessful');
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select($this->identity_column . ', users_username, users_email, users_id, users_password, status')
		                  ->where($this->identity_column, $identity)
		                  ->limit(1)
	    			  	  ->order_by('users_id', 'desc')
		                  ->get($this->tables['users']['name']);

		if($this->is_time_locked_out($identity))
		{
			//Hash something anyway, just to take up time
			//$this->hash_password($password);

			$this->trigger_events('post_validate_user_unsuccessful');
			$this->set_error('validate_user_timeout');

			return FALSE;
		}

		if ($query->num_rows() === 1)
		{
			$user = $query->row();

			$password = $this->hash_password_db($user->users_id, $password);

			if ($password === TRUE)
			{
				if ($user->status == 0)
				{
					$this->trigger_events('post_validate_user_unsuccessful');
					$this->set_error('validate_user_unsuccessful_not_active');

					return FALSE;
				}

				return TRUE;
			}
		}

		//Hash something anyway, just to take up time
		//$this->hash_password($password);

		$this->trigger_events('post_validate_user_unsuccessful');
		$this->set_error('validate_user_unsuccessful');

		return FALSE;
	}

	/**
	 * Login continuation with two-step authentication
	 *
	 * @return bool
	 * @author Mathew and SpyTec
	 **/
	public function otp_login($identity, $token, $remember=FALSE, $secret_key){
		$this->trigger_events('pre_otp_login');
		
		if (empty($identity) || empty($token) || empty($secret_key))
		{
			$this->trigger_events('post_login_unsuccessful');
			$this->set_error('otp_login_unsuccessful');
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select($this->identity_column . ', users_username, users_email, '.$this->tables['users']['primary_key'].', users_otp, users_otp_login_code, users_last_login, users_password, users_last_login, users_first_name, users_last_name, users_avatar, status')
		                  ->where($this->identity_column, $this->db->escape_str($identity))
		                  ->limit(1)
		                  ->get($this->tables['users']['name']);

		if ($query->num_rows() === 1)
		{
			$user = $query->row();
			if($this->is_otp_secret_code_valid($user->users_otp_login_code, $secret_key))
			{
				if ($this->is_otp_token_valid($user->users_otp, $token))
				{
					$this->set_session($user);
					if($this->store_login_history)
					{
						$this->store_user_login_history($user);
					}

					$this->update_last_login($user->{$this->tables['users']['primary_key']});

					$this->clear_login_attempts($identity);

					if ($remember && $this->config->item('remember_users'))
					{
						$this->remember_user($user->{$this->tables['users']['primary_key']});
					}

					$this->trigger_events(array('post_login', 'post_otp_login_successful', 'post_login_successful'));
					$this->set_message('login_successful');
					return TRUE;
				}
				else if($this->is_backup_code_valid($user->{$this->tables['users']['primary_key']}, $token) && $this->otp['backup_codes_enabled'])
				{
					$this->set_session($user);
					if($this->store_login_history)
					{
						$this->store_user_login_history($user);
					}

					$this->update_last_login($user->{$this->tables['users']['primary_key']});

					$this->clear_login_attempts($identity);

					if ($remember && $this->config->item('remember_users'))
					{
						$this->remember_user($user->{$this->tables['users']['primary_key']});
					}

					$this->trigger_events(array('post_otp_login', 'post_otp_login_successful', 'post_login_successful'));
					$this->set_message('login_successful');
					return TRUE;
				}
			}
		}
		$this->trigger_events('post_login_unsuccessful');
		$this->set_error('otp_login_unsuccessful');

		return FALSE;
	}

	/**
	 * Login continuation with two-step authentication
	 *
	 * @return bool
	 * @author Mathew and SpyTec
	 **/
	public function otp_login2($identity, $token, $users_otp)
	{
		$this->trigger_events('pre_otp_login');
		
		if (empty($identity) || empty($token) || empty($users_otp))
		{
			$this->trigger_events('post_login_unsuccessful');
			$this->set_error('otp_login_unsuccessful');
			return FALSE;
		}

		if ($this->is_otp_token_valid($users_otp, $token))
		{
			$this->trigger_events(array('post_login', 'post_otp_login_successful', 'post_login_successful'));
			$this->set_message('login_successful');
			return TRUE;
		}

		$this->trigger_events('post_login_unsuccessful');
		$this->set_error('otp_login_unsuccessful');

		return FALSE;
	}

	/**
	* Set the secret key for OTP authentication
	*
	* @return bool
	* @author Mathew and SpyTec
	*/
	public function set_otp_secret_key($id)
	{
		$this->trigger_events('pre_set_otp_secret_key');

		if (empty($id))
		{
			$this->trigger_events(array('post_set_otp_secret_key', 'post_set_otp_secret_key_unsuccessful'));
			return FALSE;
		}

		$this->load->library('encrypt');
		$secret_key = $this->encrypt->encode($this->google_authenticator->create_secret());
		
		$update = array(
			'users_otp' => $secret_key
		);

		$query = $this->db->update($this->tables['users']['name'], $update, array($this->tables['users']['primary_key'] => $id));
		if ($query) {
			$this->trigger_events(array('post_set_otp_secret_key', 'post_set_otp_secret_key_successful'));
			return TRUE;
		}

		$this->trigger_events(array('post_set_otp_secret_key', 'post_set_otp_secret_key_unsuccessful'));
		return FALSE;
	}

	/**
	* Set the secret key for OTP authentication
	*
	* @return bool
	* @author Mathew and SpyTec
	*/
	public function set_otp_secret_key2()
	{
		$this->trigger_events('pre_set_otp_secret_key');

		$this->load->library('encrypt');
		$secret_key = $this->encrypt->encode($this->google_authenticator->create_secret());

		$this->trigger_events(array('post_set_otp_secret_key', 'post_set_otp_secret_key_successful'));
		return $secret_key;
	}

	/**
	* Get secret key for OTP authentication
	*
	* @return string
	* @author Mathew and SpyTec
	*/
	public function get_otp_secret_key($id)
	{
		$this->trigger_events('pre_get_otp_secret_key');

		if (empty($id))
		{
			$this->trigger_events(array('post_get_otp_secret_key', 'post_get_otp_secret_key_unsuccessful'));
			return FALSE;
		}

		$this->trigger_events('extra_where');

		$query = $this->db->select('users_otp')
						  ->where($this->tables['users']['primary_key'], (int)$id)
						  ->limit(1)
						  ->get($this->tables['users']['name'])->row();

		if ($query) {
			$this->load->library('encrypt');
			$secret_key = $this->encrypt->decode($query->users_otp);
			$this->trigger_events(array('post_get_otp_secret_key', 'post_get_otp_secret_key_successful'));
			return $secret_key;
		}

		$this->trigger_events(array('post_get_otp_secret_key', 'post_get_otp_secret_key_unsuccessful'));
		return FALSE;
	}

	/**
	* Get secret key for OTP authentication
	*
	* @return string
	* @author Mathew and SpyTec
	*/
	public function get_otp_secret_key2($id,$users_otp)
	{
		$this->trigger_events('pre_get_otp_secret_key');

		if (empty($id) || empty($users_otp))
		{
			$this->trigger_events(array('post_get_otp_secret_key', 'post_get_otp_secret_key_unsuccessful'));
			return FALSE;
		}

		$this->load->library('encrypt');
		$secret_key = $this->encrypt->decode($users_otp);
		$this->trigger_events(array('post_get_otp_secret_key', 'post_get_otp_secret_key_successful'));
		return $secret_key;
	}

	/**
	* Provide secretly generated key from the time being. Should be changed to directly accessing Google_authenticator library
	* 
	* @return string
	* @author SpyTec
	*/
	public function create_otp_secret()
	{
		$this->trigger_events('create_otp_secret');
		return $this->google_authenticator->create_secret();
	}

	public function get_qrcode_googleurl($name, $secret, $issuer = NULL, $digits = FALSE, $period = FALSE)
	{
		$this->trigger_events('get_qrcode_googleurl');
		return $this->google_authenticator->get_qrcode_googleurl($name, $secret, $issuer = NULL, $digits = FALSE, $period = FALSE);
	}

	/**
	 * Check if token is valid
	 *
	 * @return bool
	 * @author Mathew and SpyTec
	 **/
	public function is_otp_token_valid($stored_code, $user_token){
		$this->trigger_events('pre_is_otp_token_valid');
		if (!$this->otp['enabled'] || empty($stored_code) || empty($user_token))
		{
			$this->trigger_events(array('post_is_otp_token_valid', 'post_is_otp_token_valid_unsuccessful'));
			return FALSE;
		}
		$this->load->library('encrypt');
		$stored_code = $this->encrypt->decode($stored_code);

		if($this->google_authenticator->verify_code($stored_code, $user_token))
		{
			$this->trigger_events(array('post_is_otp_token_valid', 'post_is_otp_token_valid_successful'));
			return TRUE;
		}
		$this->trigger_events(array('post_is_otp_token_valid', 'post_is_otp_token_valid_unsuccessful'));
		return FALSE;
	}

	/**
	 * Check if secret login key is valid
	 *
	 * @return bool
	 * @author Mathew and SpyTec
	 **/
	public function is_otp_secret_code_valid($stored_code, $user_code){
		$this->trigger_events('pre_is_otp_secret_code_valid');
		if (!$this->otp['enabled'] || empty($stored_code) || empty($user_code))
		{
			$this->trigger_events(array('post_is_otp_secret_code_valid', 'post_is_otp_secret_code_valid_unsuccessful'));
			return FALSE;
		}

		if($stored_code === $user_code)
		{
			$this->trigger_events(array('post_is_otp_secret_code_valid', 'post_is_otp_secret_code_valid_successful'));
			return TRUE;
		}
		$this->trigger_events(array('post_is_otp_secret_code_valid', 'post_is_otp_secret_code_valid_unsuccessful'));
	}

	/**
	 * Checks if user has two-step authentication enabled
	 *
	 * @return bool
	 * @author SpyTec
	 **/
	public function is_otp_set($identity)
	{
		$this->trigger_events('pre_is_otp_set');
		if(!$this->otp['enabled'] || empty($identity))
		{
			return FALSE;
		}
		$this->db->select('users_otp');
		$this->db->where($this->identity_column , $this->db->escape_str($identity));
		$query = $this->db->get($this->tables['users']['name']);
		if ($query->num_rows() === 1)
		{
			$user = $query->row();
			if($user->users_otp !== NULL)
			{
				$this->trigger_events(array('post_is_otp_set', 'post_is_otp_set_successful'));
				return TRUE;
			}
		}
		$this->trigger_events(array('post_is_otp_set', 'post_is_otp_set_unsuccessful'));
	}

	/**
	* Delete OTP from user
	* @return bool
	* @author Phil Sturgeon and SpyTec
	*/
	public function otp_delete($id)
	{
		$this->trigger_events('pre_delete_otp');

		// Delete OTP settings
		$data = array(
			'users_otp' => NULL,
			'users_otp_login_code' => NULL,
			'users_otpBackupCodes' => NULL	
		);
		$this->db->where($this->tables['users']['primary_key'], $id);
		$this->db->update($this->tables['users']['name'], $data);

		// if user does not exist in database then it returns FALSE
		if ($this->db->affected_rows() == 0)
		{
			$this->trigger_events(array('post_delete_otp', 'post_delete_otp_unsuccessful'));
		    return FALSE;
		}

		$this->trigger_events(array('post_delete_otp', 'post_delete_otp_successful'));
		$this->set_message('delete_successful');
		return TRUE;
	}

	/**
	 * is_max_login_attempts_exceeded
	 * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
	 *
	 * @param string $identity
	 * @return bool
	 **/
	public function is_max_login_attempts_exceeded($identity) {
		if ($this->config->item('track_login_attempts')) {
			$max_attempts = $this->config->item('maximum_login_attempts');
			if ($max_attempts > 0) {
				$attempts = $this->get_attempts_num($identity);
				return $attempts >= $max_attempts;
			}
		}
		return FALSE;
	}

	/**
	 * Get number of attempts to login occured from given IP-address or identity
	 * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
	 *
	 * @param	string $identity
	 * @return	int
	 */
	function get_attempts_num($identity)
	{
        if ($this->config->item('track_login_attempts')) {
            $ip_address = $this->_prepare_ip($this->input->ip_address());
            $this->db->select('1', FALSE);
            if ($this->config->item('track_login_ip_address')) $this->db->where('ip_address', $ip_address);
            else if (strlen($identity) > 0) $this->db->or_where('login', $identity);
            $qres = $this->db->get($this->tables['login_attempts']['name']);
            return $qres->num_rows();
        }
        return 0;
	}

	/**
	 * Get a boolean to determine if an account should be locked out due to
	 * exceeded login attempts within a given period
	 *
	 * @return	boolean
	 */
	public function is_time_locked_out($identity) {

		return $this->is_max_login_attempts_exceeded($identity) && $this->get_last_attempt_time($identity) > time() - $this->config->item('lockout_time');
	}

	/**
	 * Get the time of the last time a login attempt occured from given IP-address or identity
	 *
	 * @param	string $identity
	 * @return	int
	 */
	public function get_last_attempt_time($identity) {
		if ($this->config->item('track_login_attempts')) {
			$ip_address = $this->_prepare_ip($this->input->ip_address());

			$this->db->select_max('time');
            if ($this->config->item('track_login_ip_address')) $this->db->where('ip_address', $ip_address);
			else if (strlen($identity) > 0) $this->db->or_where('login', $identity);
			$qres = $this->db->get($this->tables['login_attempts']['name'], 1);

			if($qres->num_rows() > 0) {
				return $qres->row()->time;
			}
		}

		return 0;
	}

	/**
	 * increase_login_attempts
	 * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
	 *
	 * @param string $identity
	 **/
	public function increase_login_attempts($identity) {
		if ($this->config->item('track_login_attempts')) {
			$ip_address = $this->_prepare_ip($this->input->ip_address());
			return $this->db->insert($this->tables['login_attempts']['name'], array('ip_address' => $ip_address, 'login' => $identity, 'time' => time()));
		}
		return FALSE;
	}

	/**
	 * clear_login_attempts
	 * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
	 *
	 * @param string $identity
	 **/
	public function clear_login_attempts($identity, $expire_period = 86400) {
		if ($this->config->item('track_login_attempts')) {
			$ip_address = $this->_prepare_ip($this->input->ip_address());

			$this->db->where(array('ip_address' => $ip_address, 'login' => $identity));
			// Purge obsolete login attempts
			$this->db->or_where('time <', time() - $expire_period, FALSE);

			return $this->db->delete($this->tables['login_attempts']['name']);
		}
		return FALSE;
	}

	public function limit($limit)
	{
		$this->trigger_events('limit');
		$this->_ion_limit = $limit;

		return $this;
	}

	public function offset($offset)
	{
		$this->trigger_events('offset');
		$this->_ion_offset = $offset;

		return $this;
	}

	public function where($where, $value = NULL)
	{
		$this->trigger_events('where');

		if (!is_array($where))
		{
			$where = array($where => $value);
		}

		array_push($this->_ion_where, $where);

		return $this;
	}

	public function like($like, $value = NULL, $position = 'both')
	{
		$this->trigger_events('like');

		if (!is_array($like))
		{
			$like = array($like => array(
				'value'    => $value,
				'position' => $position,
			));
		}

		array_push($this->_ion_like, $like);

		return $this;
	}

	public function select($select)
	{
		$this->trigger_events('select');

		$this->_ion_select[] = $select;

		return $this;
	}

	public function order_by($by, $order='desc')
	{
		$this->trigger_events('order_by');

		$this->_ion_order_by = $by;
		$this->_ion_order    = $order;

		return $this;
	}

	public function row()
	{
		$this->trigger_events('row');

		$row = $this->response->row();

		return $row;
	}

	public function row_array()
	{
		$this->trigger_events(array('row', 'row_array'));

		$row = $this->response->row_array();

		return $row;
	}

	public function result()
	{
		$this->trigger_events('result');

		$result = $this->response->result();

		return $result;
	}

	public function result_array()
	{
		$this->trigger_events(array('result', 'result_array'));

		$result = $this->response->result_array();

		return $result;
	}

	public function num_rows()
	{
		$this->trigger_events(array('num_rows'));

		$result = $this->response->num_rows();

		return $result;
	}

	/**
	 * users
	 *
	 * @return object Users
	 * @author Ben Edmunds
	 **/
	public function users($groups = NULL)
	{
		$this->trigger_events('users');

		if (isset($this->_ion_select) && !empty($this->_ion_select))
		{
			foreach ($this->_ion_select as $select)
			{
				$this->db->select($select);
			}

			$this->_ion_select = array();
		}
		else
		{
			//default selects
			$this->db->select(array(
			    $this->tables['users']['name'].'.*',
			    $this->tables['users']['name'].'.'.$this->tables['users']['primary_key'].' as id',
			    $this->tables['users']['name'].'.'.$this->tables['users']['primary_key'].' as user_id'
			));
		}

		//filter by group id(s) if passed
		if (isset($groups))
		{
			//build an array if only one group was passed
			if (!is_array($groups))
			{
				$groups = Array($groups);
			}

			//join and then run a where_in against the group ids
			if (isset($groups) && !empty($groups))
			{
				$this->db->distinct();
				$this->db->join(
				    $this->tables['users_groups']['name'],
				    $this->tables['users_groups']['name'].'.'.$this->join['users'].'='.$this->tables['users']['name'].'.'. $this->tables['users']['primary_key'],
				    'inner'
				);
			}
			
			// verify if group name or group id was used and create and put elements in different arrays
			$group_ids = array();
			$group_names = array();
			foreach($groups as $group)
			{
				if(is_numeric($group)) $group_ids[] = $group;
				else $group_names[] = $group;
			}
			$or_where_in = (!empty($group_ids) && !empty($group_names)) ? 'or_where_in' : 'where_in';
			//if group name was used we do one more join with groups
			if(!empty($group_names))
			{
				$this->db->join($this->tables['groups']['name'], $this->tables['users_groups']['name'] . '.' . $this->join['groups'] . ' = ' . $this->tables['groups']['name'] . '.' . $this->tables['groups']['primary_key'], 'inner');
				$this->db->where_in($this->tables['groups']['name'] . '.groups_name', $group_names);
			}
			if(!empty($group_ids))
			{
				$this->db->{$or_where_in}($this->tables['users_groups']['name'].'.'.$this->join['groups'], $group_ids);
			}
		}

		$this->trigger_events('extra_where');

		//run each where that was passed
		if (isset($this->_ion_where) && !empty($this->_ion_where))
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}

			$this->_ion_where = array();
		}

		if (isset($this->_ion_like) && !empty($this->_ion_like))
		{
			foreach ($this->_ion_like as $like)
			{
				$this->db->or_like($like);
			}

			$this->_ion_like = array();
		}

		if (isset($this->_ion_limit) && isset($this->_ion_offset))
		{
			$this->db->limit($this->_ion_limit, $this->_ion_offset);

			$this->_ion_limit  = NULL;
			$this->_ion_offset = NULL;
		}
		else if (isset($this->_ion_limit))
		{
			$this->db->limit($this->_ion_limit);

			$this->_ion_limit  = NULL;
		}

		//set the order
		if (isset($this->_ion_order_by) && isset($this->_ion_order))
		{
			$this->db->order_by($this->_ion_order_by, $this->_ion_order);

			$this->_ion_order    = NULL;
			$this->_ion_order_by = NULL;
		}

		$this->response = $this->db->get($this->tables['users']['name']);

		return $this;
	}

	/**
	 * user
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function user($id = NULL)
	{
		$this->trigger_events('user');

		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('users_id');

		$this->limit(1);
		$this->order_by($this->tables['users']['primary_key'], 'desc');
		$this->where($this->tables['users']['name'].'.'. $this->tables['users']['primary_key'], $id);

		$this->users();

		return $this;
	}

	/**
	 * user
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function reset_user_session()
	{
		$this->trigger_events('reset_user_session');

		$query = $this->db->select($this->identity_column . ', users_username, users_email, '.$this->tables['users']['primary_key'].', users_first_name, users_last_name, users_avatar, users_last_login')
		                  ->where($this->identity_column, $this->session->userdata('identity'))
		                  ->limit(1)
	    			  	  ->order_by($this->tables['users']['primary_key'], 'desc')
		                  ->get($this->tables['users']['name']);

		if ($query->num_rows() === 1)
		{
			$user = $query->row();

			$this->set_session($user);

			return $user->users_id;
		}

		return FALSE;
	}

	/**
	 * get_users_groups
	 *
	 * @return array
	 * @author Ben Edmunds
	 **/
	public function get_users_groups($id=FALSE)
	{
		$this->trigger_events('get_users_group');

		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('users_id');

		return $this->db->select($this->tables['users_groups']['name'].'.'.$this->join['groups'].' as '.$this->tables['groups']['primary_key'].', '.$this->tables['groups']['name'].'.groups_name, '.$this->tables['groups']['name'].'.groups_description')
		                ->where($this->tables['users_groups']['name'].'.'.$this->join['users'], $id)
		                ->join($this->tables['groups']['name'], $this->tables['users_groups']['name'].'.'.$this->join['groups'].'='.$this->tables['groups']['name'].'.'. $this->tables['groups']['primary_key'])
		                ->get($this->tables['users_groups']['name']);
	}

	/**
	 * add_to_group
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function add_to_group($group_ids, $user_id=false)
	{
		$this->trigger_events('add_to_group');

		//if no id was passed use the current users id
		$user_id || $user_id = $this->session->userdata('users_id');

		if(!is_array($group_ids))
		{
			$group_ids = array($group_ids);
		}

		$return = 0;

		// Then insert each into the database
		foreach ($group_ids as $group_id)
		{
			$time = time();
			if ($this->db->insert($this->tables['users_groups']['name'], array( $this->join['groups'] => (int)$group_id, $this->join['users'] => (int)$user_id, '_created_by' => $this->session->userdata('users_id'), '_updated_by' => $this->session->userdata('users_id'), '_created_at' => $time, '_updated_at' => $time)))
			{
				if (isset($this->_cache_groups[$group_id])) {
					$group_name = $this->_cache_groups[$group_id];
				}
				else {
					$group = $this->group($group_id)->result();
					$group_name = $group[0]->groups_name;
					$this->_cache_groups[$group_id] = $group_name;
				}
				$this->_cache_user_in_group[$user_id][$group_id] = $group_name;

				// Return the number of groups added
				$return += 1;
			}
		}

		return $return;
	}

	/**
	 * remove_from_group
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function remove_from_group($group_ids=false, $user_id=false)
	{
		$this->trigger_events('remove_from_group');

		// user id is required
		if(empty($user_id))
		{
			return FALSE;
		}

		// if group id(s) are passed remove user from the group(s)
		if( ! empty($group_ids))
		{
			if(!is_array($group_ids))
			{
				$group_ids = array($group_ids);
			}

			foreach($group_ids as $group_id)
			{
				$this->db->delete($this->tables['users_groups']['name'], array($this->join['groups'] => (int)$group_id, $this->join['users'] => (int)$user_id));
				if (isset($this->_cache_user_in_group[$user_id]) && isset($this->_cache_user_in_group[$user_id][$group_id]))
				{
					unset($this->_cache_user_in_group[$user_id][$group_id]);
				}
			}

			$return = TRUE;
		}
		// otherwise remove user from all groups
		else
		{
			if ($return = $this->db->delete($this->tables['users_groups']['name'], array($this->join['users'] => (int)$user_id))) {
				$this->_cache_user_in_group[$user_id] = array();
			}
		}
		return $return;
	}

	/**
	 * groups
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function groups()
	{
		$this->trigger_events('groups');

		//run each where that was passed
		if (isset($this->_ion_where) && !empty($this->_ion_where))
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}
			$this->_ion_where = array();
		}

		if (isset($this->_ion_limit) && isset($this->_ion_offset))
		{
			$this->db->limit($this->_ion_limit, $this->_ion_offset);

			$this->_ion_limit  = NULL;
			$this->_ion_offset = NULL;
		}
		else if (isset($this->_ion_limit))
		{
			$this->db->limit($this->_ion_limit);

			$this->_ion_limit  = NULL;
		}

		//set the order
		if (isset($this->_ion_order_by) && isset($this->_ion_order))
		{
			$this->db->order_by($this->_ion_order_by, $this->_ion_order);
		}

		$this->response = $this->db->get($this->tables['groups']['name']);

		return $this;
	}

	/**
	 * group
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function group($id = NULL)
	{
		$this->trigger_events('group');

		if (isset($id))
		{
			$this->where($this->tables['groups']['name'].'.'. $this->tables['groups']['primary_key'], $id);
		}

		$this->limit(1);
		$this->order_by($this->tables['groups']['primary_key'], 'desc');

		return $this->groups();
	}


	/**
	 * get_group_id
	 *
	 * @return object
	 * @author Lucky Mahrus
	 **/
	public function get_group_id($name = NULL)
	{
		$this->trigger_events('group');

		if (isset($name))
		{
			$this->db->where($this->tables['groups']['name'].'.groups_name', $name);
		}

		$this->db->limit(1);
		$this->db->order_by($this->tables['groups']['primary_key'], 'desc');
//		$this->response = $this->db->get($this->tables['groups']['name']);


		return $this->db->get($this->tables['groups']['name']);
	}

	/**
	 * update
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function update($id, array $data)
	{
		$this->trigger_events('pre_update_user');

		$user = $this->user($id)->row();

		$this->db->trans_begin();

		if (array_key_exists($this->identity_column, $data) && $this->identity_check($data[$this->identity_column]) && $user->{$this->identity_column} !== $data[$this->identity_column])
		{
			$this->db->trans_rollback();
			$this->set_error('account_creation_duplicate_'.$this->identity_column);

			$this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
			$this->set_error('update_unsuccessful');

			return FALSE;
		}

		// Filter the data passed
		$data = $this->_filter_data($this->tables['users']['name'], $data);

		if (array_key_exists('users_username', $data) || array_key_exists('users_password', $data) || array_key_exists('users_email', $data))
		{
			if (array_key_exists('users_password', $data))
			{
				if( ! empty($data['users_password']))
				{
					$data['users_password'] = $this->hash_password($data['users_password'], $user->users_salt);
				}
				else
				{
					// unset password so it doesn't effect database entry if no password passed
					unset($data['users_password']);
				}
			}
		}

		$this->trigger_events('extra_where');
		$this->db->update($this->tables['users']['name'], $data, array($this->tables['users']['primary_key'] => $user->{$this->tables['users']['primary_key']}));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			$this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
			$this->set_error('update_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->trigger_events(array('post_update_user', 'post_update_user_successful'));
		$this->set_message('update_successful');
		return TRUE;
	}

	/**
	* delete_user
	*
	* @return bool
	* @author Phil Sturgeon
	**/
	public function delete_user($id)
	{
		$this->trigger_events('pre_delete_user');

		$this->db->trans_begin();

		// remove user from groups
		$this->remove_from_group(NULL, $id);

		// delete user from users table should be placed after remove from group
		$this->db->delete($this->tables['users']['name'], array($this->tables['users']['primary_key'] => $id));

		// if user does not exist in database then it returns FALSE else removes the user from groups
		if ($this->db->affected_rows() == 0)
		{
		    return FALSE;
		}

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->trigger_events(array('post_delete_user', 'post_delete_user_unsuccessful'));
			$this->set_error('delete_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->trigger_events(array('post_delete_user', 'post_delete_user_successful'));
		$this->set_message('delete_successful');
		return TRUE;
	}

	/**
	 * update_last_login
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function update_last_login($id)
	{
		$this->trigger_events('update_last_login');

		$this->load->helper('date');

		$this->trigger_events('extra_where');

		$this->db->update($this->tables['users']['name'], array('users_last_login' => time()), array($this->tables['users']['primary_key'] => $id));

		return $this->db->affected_rows() == 1;
	}

	/**
	 * set_lang
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function set_lang($lang = 'en')
	{
		$this->trigger_events('set_lang');

		// if the user_expire is set to zero we'll set the expiration two years from now.
		if($this->config->item('user_expire') === 0)
		{
			$expire = (60*60*24*365*2);
		}
		// otherwise use what is set
		else
		{
			$expire = $this->config->item('user_expire');
		}

		set_cookie(array(
			'name'   => 'lang_code',
			'value'  => $lang,
			'expire' => $expire
		));

		return TRUE;
	}

	/**
	 * set_session
	 *
	 * @return bool
	 * @author jrmadsen67
	 **/
	public function set_session($user)
	{
		$this->trigger_events('pre_set_session');

		$session_data = array(
		    'identity'			=> $user->{$this->identity_column},
		    'users_id'			=> $user->{$this->tables['users']['primary_key']}, //everyone likes to overwrite id so we'll use user_id
		    'users_username'		=> $user->users_username,
		    'users_fullname'		=> $user->users_first_name.' '.$user->users_last_name,
		    'users_first_name'	=> $user->users_first_name,
		    'users_last_name'		=> $user->users_last_name,
		    'users_email'		=> $user->users_email,
		    'users_avatars'		=> ((isset($user->users_avatar) && !empty($user->users_avatar) && !is_null($user->users_avatar)) ? $user->users_avatar : 'default.jpg'),
		    'old_last_login'	=> $user->users_last_login
		);

		$this->session->set_userdata($session_data);

		$this->trigger_events('post_set_session');

		return TRUE;
	}

	public function store_user_login_history($user=NULL)
	{
		if(!is_null($user))
		{
			$this->load->library('user_agent');
			$this->load->model('loginhistory_model','loginhistory');

			$history 	= array(
								$this->tables['users']['primary_key']	=> $user->{$this->tables['users']['primary_key']},
								'ip_address'		=> $this->input->ip_address(),
								'useragent'		=> $this->agent->agent_string(),
								'platform'		=> $this->agent->platform(),
								'browser'		=> $this->agent->browser(),
								'remember_login'	=> ((isset($user->remember)) ? $user->remember : NULL),
							);

			$sessId 	= session_id();
			$session 	= $this->loginhistory->get_by('sessions_id',$sessId);
			if(!$session)
			{
				$history['sessions_id'] = ((isset($sessId) && !is_null($sessId) && !empty($sessId)) ? $sessId : session_id());
				$history['time_login'] = time();

				$this->loginhistory->insert($history);
			}
			else
			{
				$this->loginhistory->update($sessId,$history);
			}
		}
	}

	/**
	 * remember_user
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function remember_user($id)
	{
		$this->trigger_events('pre_remember_user');

		if (!$id)
		{
			return FALSE;
		}

		$user = $this->user($id)->row();

		$salt = $this->salt();

		$this->db->update($this->tables['users']['name'], array('remember_code' => $salt), array($this->tables['users']['primary_key'] => $id));

		if ($this->db->affected_rows() > -1)
		{
			// if the user_expire is set to zero we'll set the expiration two years from now.
			if($this->config->item('user_expire') === 0)
			{
				$expire = (60*60*24*365*2);
			}
			// otherwise use what is set
			else
			{
				$expire = $this->config->item('user_expire');
			}

			set_cookie(array(
			    'name'   => $this->config->item('identity_cookie_name'),
			    'value'  => $user->{$this->identity_column},
			    'expire' => $expire
			));

			set_cookie(array(
			    'name'   => $this->config->item('remember_cookie_name'),
			    'value'  => $salt,
			    'expire' => $expire
			));

			$this->trigger_events(array('post_remember_user', 'remember_user_successful'));
			return TRUE;
		}

		$this->trigger_events(array('post_remember_user', 'remember_user_unsuccessful'));
		return FALSE;
	}

	/**
	 * login_remembed_user
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function login_remembered_user()
	{
		$this->trigger_events('pre_login_remembered_user');

		//check for valid data
		if (!get_cookie($this->config->item('identity_cookie_name'))
			|| !get_cookie($this->config->item('remember_cookie_name'))
			|| !$this->identity_check(get_cookie($this->config->item('identity_cookie_name'))))
		{
			$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
			return FALSE;
		}

		//get the user
		$this->trigger_events('extra_where');
		$query = $this->db->select($this->identity_column . ', users_username, users_email, '.$this->tables['users']['primary_key'].', users_password, users_otp, users_last_login, users_first_name, users_last_name, users_avatar, status')
		                  ->where($this->identity_column, get_cookie($this->config->item('identity_cookie_name')))
		                  ->where('remember_code', get_cookie($this->config->item('remember_cookie_name')))
		                  ->limit(1)
	    			  	  ->order_by($this->tables['users']['primary_key'], 'desc')
		                  ->get($this->tables['users']['name']);

		//if the user was found, sign them in
		if ($query->num_rows() == 1)
		{
			$user = $query->row();

			$this->update_last_login($user->{$this->tables['users']['primary_key']});

			$this->set_session($user);
			if($this->store_login_history)
			{
				$this->store_user_login_history($user);
			}

			//extend the users cookies if the option is enabled
			if ($this->config->item('user_extend_on_login'))
			{
				$this->remember_user($user->{$this->tables['users']['primary_key']});
			}

			$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_successful'));
			return TRUE;
		}

		$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
		return FALSE;
	}

	/**
	 * create_group
	 *
	 * @author aditya menon
	*/
	public function create_group($group_name = FALSE, $group_description = '', $additional_data = array())
	{
		// bail if the group name was not passed
		if(!$group_name)
		{
			$this->set_error('group_name_required');
			return FALSE;
		}

		// bail if the group name already exists
		$existing_group = $this->db->get_where($this->tables['groups']['name'], array('groups_name' => $group_name))->num_rows();
		if($existing_group !== 0)
		{
			$this->set_error('group_already_exists');
			return FALSE;
		}

		$data = array('groups_name'=>$group_name,'groups_description'=>$group_description,'groups_level'=>$additional_data['groups_level']);

		//filter out any data passed that doesnt have a matching column in the groups table
		//and merge the set group data and the additional data
		if (!empty($additional_data)) $data = array_merge($this->_filter_data($this->tables['groups']['name'], $additional_data), $data);

		$this->trigger_events('extra_group_set');

		// insert the new group
		$this->db->insert($this->tables['groups']['name'], $data);
		$group_id = $this->db->insert_id();

		// report success
		$this->set_message('group_creation_successful');
		// return the brand new group id
		return $group_id;
	}

	/**
	 * update_group
	 *
	 * @return bool
	 * @author aditya menon
	 **/
	public function update_group($group_id = FALSE, $group_name = FALSE, $additional_data = array())
	{
		if (empty($group_id)) return FALSE;

		$data = array();

		if (!empty($group_name))
		{
			// we are changing the name, so do some checks

			// bail if the group name already exists
			$existing_group = $this->db->get_where($this->tables['groups']['name'], array('groups_name' => $group_name))->row();
			if(isset($existing_group->id) && $existing_group->id != $group_id)
			{
				$this->set_error('group_already_exists');
				return FALSE;
			}

			$data['groups_name'] = $group_name;
		}


		// IMPORTANT!! Third parameter was string type $description; this following code is to maintain backward compatibility
		// New projects should work with 3rd param as array
		if (is_string($additional_data)) $additional_data = array('groups_description' => $additional_data);


		//filter out any data passed that doesnt have a matching column in the groups table
		//and merge the set group data and the additional data
		if (!empty($additional_data)) $data = array_merge($this->_filter_data($this->tables['groups']['name'], $additional_data), $data);


		$this->db->update($this->tables['groups']['name'], $data, array($this->tables['groups']['primary_key'] => $group_id));

		$this->set_message('group_update_successful');

		return TRUE;
	}

	/**
	* delete_group
	*
	* @return bool
	* @author aditya menon
	**/
	public function delete_group($group_id = FALSE)
	{
		// bail if mandatory param not set
		if(!$group_id || empty($group_id))
		{
			return FALSE;
		}
		$group = $this->group($group_id)->row();
		if(isset($group->groups_name) && $group->groups_name == $this->config->item('admin_group'))
		{
			$this->trigger_events(array('post_delete_group', 'post_delete_group_notallowed'));
			$this->set_error('group_delete_notallowed');
			return FALSE;
		}

		$this->trigger_events('pre_delete_group');

		$this->db->trans_begin();

		// remove all users from this group
		$this->db->delete($this->tables['users_groups']['name'], array($this->join['groups'] => $group_id));
		// remove the group itself
		$this->db->delete($this->tables['groups']['name'], array($this->tables['groups']['primary_key'] => $group_id));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->trigger_events(array('post_delete_group', 'post_delete_group_unsuccessful'));
			$this->set_error('group_delete_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->trigger_events(array('post_delete_group', 'post_delete_group_successful'));
		$this->set_message('group_delete_successful');
		return TRUE;
	}

	public function set_hook($event, $name, $class, $method, $arguments)
	{
		$this->_ion_hooks->{$event}[$name] = new stdClass;
		$this->_ion_hooks->{$event}[$name]->class     = $class;
		$this->_ion_hooks->{$event}[$name]->method    = $method;
		$this->_ion_hooks->{$event}[$name]->arguments = $arguments;
	}

	public function remove_hook($event, $name)
	{
		if (isset($this->_ion_hooks->{$event}[$name]))
		{
			unset($this->_ion_hooks->{$event}[$name]);
		}
	}

	public function remove_hooks($event)
	{
		if (isset($this->_ion_hooks->$event))
		{
			unset($this->_ion_hooks->$event);
		}
	}

	protected function _call_hook($event, $name)
	{
		if (isset($this->_ion_hooks->{$event}[$name]) && method_exists($this->_ion_hooks->{$event}[$name]->class, $this->_ion_hooks->{$event}[$name]->method))
		{
			$hook = $this->_ion_hooks->{$event}[$name];

			return call_user_func_array(array($hook->class, $hook->method), $hook->arguments);
		}

		return FALSE;
	}

	public function trigger_events($events)
	{
		if (is_array($events) && !empty($events))
		{
			foreach ($events as $event)
			{
				$this->trigger_events($event);
			}
		}
		else
		{
			if (isset($this->_ion_hooks->$events) && !empty($this->_ion_hooks->$events))
			{
				foreach ($this->_ion_hooks->$events as $name => $hook)
				{
					$this->_call_hook($events, $name);
				}
			}
		}
	}

	/**
	 * set_message_delimiters
	 *
	 * Set the message delimiters
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function set_message_delimiters($start_delimiter, $end_delimiter)
	{
		$this->message_start_delimiter = $start_delimiter;
		$this->message_end_delimiter   = $end_delimiter;

		return TRUE;
	}

	/**
	 * set_error_delimiters
	 *
	 * Set the error delimiters
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function set_error_delimiters($start_delimiter, $end_delimiter)
	{
		$this->error_start_delimiter = $start_delimiter;
		$this->error_end_delimiter   = $end_delimiter;

		return TRUE;
	}

	/**
	 * set_message
	 *
	 * Set a message
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function set_message($message)
	{
		$this->messages[] = $message;

		return $message;
	}

	/**
	 * messages
	 *
	 * Get the messages
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function messages()
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
			$_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
		}

		return $_output;
	}

	/**
	 * messages as array
	 *
	 * Get the messages as an array
	 *
	 * @return array
	 * @author Raul Baldner Junior
	 **/
	public function messages_array($langify = TRUE)
	{
		if ($langify)
		{
			$_output = array();
			foreach ($this->messages as $message)
			{
				$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
				$_output[] = $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
			}
			return $_output;
		}
		else
		{
			return $this->messages;
		}
	}

	/**
	 * set_error
	 *
	 * Set an error message
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function set_error($error)
	{
		$this->errors[] = $error;

		return $error;
	}

	/**
	 * errors
	 *
	 * Get the error message
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function errors()
	{
		$_output = '';
		foreach ($this->errors as $error)
		{
			$errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
			$_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
		}

		return $_output;
	}

	/**
	 * errors as array
	 *
	 * Get the error messages as an array
	 *
	 * @return array
	 * @author Raul Baldner Junior
	 **/
	public function errors_array($langify = TRUE)
	{
		if ($langify)
		{
			$_output = array();
			foreach ($this->errors as $error)
			{
				$errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
				$_output[] = $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
			}
			return $_output;
		}
		else
		{
			return $this->errors;
		}
	}

	protected function _filter_data($table, $data)
	{
		$filtered_data = array();
		$columns = $this->db->list_fields($table);

		if (is_array($data))
		{
			foreach ($columns as $column)
			{
				if (array_key_exists($column, $data))
					$filtered_data[$column] = $data[$column];
			}
		}

		return $filtered_data;
	}

	protected function _prepare_ip($ip_address) {
		//just return the string IP address now for better compatibility
		return $ip_address;
	}	
}
 