<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth
*
* Version: 2.5.2
*
* Author: Ben Edmunds
*		  ben.edmunds@gmail.com
*         @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

/*
| -------------------------------------------------------------------------
| Tables.
| -------------------------------------------------------------------------
| Database table names.
*/
$config['tables']['users']['name']					= 'users';
$config['tables']['users']['primary_key']			= 'users_id';
$config['tables']['groups']['name']					= 'groups';
$config['tables']['groups']['primary_key']			= 'groups_id';
$config['tables']['usersgroups']['name']			= 'usersgroups';
$config['tables']['usersgroups']['primary_key']	= 'usersgroups_id';
$config['tables']['login_attempts']['name']			= 'loginattempts';
$config['tables']['login_attempts']['primary_key']	= 'loginattempts_id';
$config['tables']['login_history']['name']			= 'loginhistory';
$config['tables']['login_history']['primary_key']	= 'loginhistory_id';

/*
 | Users table column and Group table column you want to join WITH.
 |
 | Joins from users.id
 | Joins from groups.id
 */
$config['join']['users']  = 'users_id';
$config['join']['groups'] = 'groups_id';

/*
 | -------------------------------------------------------------------------
 | Hash Method (sha1 or bcrypt)
 | -------------------------------------------------------------------------
 | Bcrypt is available in PHP 5.3+
 |
 | IMPORTANT: Based on the recommendation by many professionals, it is highly recommended to use
 | bcrypt instead of sha1.
 |
 | NOTE: If you use bcrypt you will need to increase your password column character limit to (80)
 |
 | Below there is "default_rounds" setting.  This defines how strong the encryption will be,
 | but remember the more rounds you set the longer it will take to hash (CPU usage) So adjust
 | this based on your server hardware.
 |
 | If you are using Bcrypt the Admin password field also needs to be changed in order to login as admin:
 | $2y$: $2y$08$200Z6ZZbp3RAEXoaWcMA6uJOFicwNZaqk4oDhqTUiFXFe63MG.Daa
 | $2a$: $2a$08$6TTcWD1CJ8pzDy.2U3mdi.tpl.nYOR1pwYXwblZdyQd9SL16B7Cqa
 |
 | Be careful how high you set max_rounds, I would do your own testing on how long it takes
 | to encrypt with x rounds.
 |
 | salt_prefix: Used for bcrypt. Versions of PHP before 5.3.7 only support "$2a$" as the salt prefix
 | Versions 5.3.7 or greater should use the default of "$2y$".
 */
$config['hash_method']    = 'bcrypt';	// sha1 or bcrypt, bcrypt is STRONGLY recommended
$config['default_rounds'] = 8;		// This does not apply if random_rounds is set to true
$config['random_rounds']  = FALSE;
$config['min_rounds']     = 5;
$config['max_rounds']     = 9;
$config['salt_prefix']    = version_compare(PHP_VERSION, '5.3.7', '<') ? '$2a$' : '$2y$';

/*
 | -------------------------------------------------------------------------
 | Authentication options.
 | -------------------------------------------------------------------------
 | maximum_login_attempts: This maximum is not enforced by the library, but is
 | used by $this->ion_auth->is_max_login_attempts_exceeded().
 | The controller should check this function and act
 | appropriately. If this variable set to 0, there is no maximum.
 */
$config['site_title']                 = "ZorgBeuningen.nl";       // Site Title, example.com
$config['admin_email']                = "admin@zorgbeuningen.nl"; // Admin Email, admin@example.com
$config['default_group']              = 'members';           // Default group, use name
$config['superadmin_group']           = 'superadmin';        // Default superadministrators group, use name
$config['admin_group']                = array('superadmin','admin');             // Default administrators group, use name
$config['identity']                   = 'users_email';        // A database column which is used to login with
$config['min_password_length']        = 8;                   // Minimum Required Length of Password
$config['max_password_length']        = 20;                  // Maximum Allowed Length of Password
$config['store_ori_password']         = TRUE;               // Maximum Allowed Length of Password
$config['email_activation']           = FALSE;               // Email Activation for registration
$config['manual_activation']          = FALSE;               // Manual Activation for registration
$config['remember_users']             = TRUE;                // Allow users to be remembered and enable auto-login
$config['user_expire']                = 86500;               // How long to remember the user (seconds). Set to zero for no expiration
$config['user_extend_on_login']       = FALSE;               // Extend the users cookies every time they auto-login
$config['track_login_attempts']       = TRUE;               // Track the number of failed login attempts for each user or ip.
$config['track_login_ip_address']     = TRUE;                // Track login attempts by IP Address, if FALSE will track based on identity. (Default: TRUE)
$config['maximum_login_attempts']     = 5;                   // The maximum number of failed login attempts.
$config['lockout_time']               = 3153600000;          // The number of seconds to lockout an account due to exceeded attempts, default 1 year
$config['forgot_password_expiration'] = 0;                   // The number of milliseconds after which a forgot password request will expire. If set to 0, forgot password requests will not expire.
$config['store_login_history']        = TRUE;                // Store log of successful login
$config['development_mode']			  = FALSE;
$config['email_development']		  = 'lukman@u-digital.nl';

/*
 | -------------------------------------------------------------------------
 | Cookie options.
 | -------------------------------------------------------------------------
 | remember_cookie_name Default: remember_code
 | identity_cookie_name Default: identity
 */
$config['remember_cookie_name'] = 'remember_code';
$config['identity_cookie_name'] = 'identity';

/*
 | -------------------------------------------------------------------------
 | Multi-step authentication options.
 | -------------------------------------------------------------------------
 | 
 | otp->time_step: We RECOMMEND a default time-step size of 30 seconds. 
 | This default value of 30 seconds is selected as a balance between security and usability.
 |
 | The code-length and time-step parameters is ignored by the
 | Google Authenticator implementations. 
 |
 | The "digits", "period" and "algorithm" parameters does not work with Google Authenticator nor Authy
 | For more info regarding uri parameters with Google Authenticator. See http://code.google.com/p/google-authenticator/wiki/KeyUriFormat
 |
 | For more info regarding TOTP. See RFC-6238: http://tools.ietf.org/html/rfc6238
 */
$config['otp']['enabled']				= TRUE;			// If you want to use multi-step authentication
$config['otp']['backup_codes_enabled']	= TRUE; 		// If you want backup codes to be used for logging in. Recommended if the user looses his phone or can't access it
$config['otp']['backup_codes_length']	= 10; 			// Length of backup codes. Should be as long as code_length or greater
$config['otp']['issuer'] 				= "ZorgBeuningen"; 	// A provider/issuer shown as a title on OTP mobile apps
$config['otp']['qr_size']				= 200; 			// This is the generated size in pixels for the Google generated QR code
$config['otp']['secret_length']			= 16; 			// Length of secret key shared between you and client
$config['otp']['discrepancy']			= 2; 			// This is the allowed time drift in interval units (8 means 4 minutes before or after if time-step is 30s)

// The following config is for future-proofing
$config['otp']['code_length']			= 6; 			// The generated token length. Recommended to keep it at 6
$config['otp']['time_step']				= 30; 			// The generated token time step in seconds.



/*
 | -------------------------------------------------------------------------
 | Email options.
 | -------------------------------------------------------------------------
 | email_config:
 | 	  'file' = Use the default CI config or use from a config file
 | 	  array  = Manually set your email config settings
 */
$config['use_ci_email'] = FALSE; // Send Email using the builtin CI email class, if false it will return the code and the identity
$config['email_config'] = array(
	'mailtype' 	=> 'html',
	'newline' 	=> '\r\n',
);

/*
 | -------------------------------------------------------------------------
 | Email templates.
 | -------------------------------------------------------------------------
 | Folder where email templates are stored.
 | Default: auth/
 */
$config['email_templates'] = 'email/';

/*
 | -------------------------------------------------------------------------
 | Activate Account Email Template
 | -------------------------------------------------------------------------
 | Default: activate.tpl.php
 */
$config['email_activate'] = 'activate.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Forgot Password Email Template
 | -------------------------------------------------------------------------
 | Default: forgot_password.tpl.php
 */
$config['email_forgot_password'] = 'forgot_password.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Forgot Password Complete Email Template
 | -------------------------------------------------------------------------
 | Default: new_password.tpl.php
 */
$config['email_forgot_password_complete'] = 'new_password.tpl.php';

/*
 | -------------------------------------------------------------------------
 | New Assigned Document Email Template
 | -------------------------------------------------------------------------
 | Default: new_document.tpl.php
 */
$config['new_assigned_document'] = 'new_document.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Salt options
 | -------------------------------------------------------------------------
 | salt_length Default: 22
 |
 | store_salt: Should the salt be stored in the database?
 | This will change your password encryption algorithm,
 | default password, 'password', changes to
 | fbaa5e216d163a02ae630ab1a43372635dd374c0 with default salt.
 */
$config['salt_length'] = 22;
$config['store_salt']  = TRUE;

/*
 | -------------------------------------------------------------------------
 | Message Delimiters.
 | -------------------------------------------------------------------------
 */
$config['delimiters_source']       = 'config'; 	// "config" = use the settings defined here, "form_validation" = use the settings defined in CI's form validation library
$config['message_start_delimiter'] = '<p>'; 	// Message start delimiter
$config['message_end_delimiter']   = '</p>'; 	// Message end delimiter
$config['error_start_delimiter']   = '<p>';		// Error mesage start delimiter
$config['error_end_delimiter']     = '</p>';	// Error mesage end delimiter

/* End of file ion_auth.php */
/* Location: ./application/config/ion_auth.php */
