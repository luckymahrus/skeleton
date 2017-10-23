/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS webroutes;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webroutes (
    `webroutes_id` INT(11) NOT NULL AUTO_INCREMENT,
    `webroutes_name` VARCHAR(255),
    `webroutes_title` text,
    `webroutes_description` text,
    `webroutes_params` VARCHAR(255),
    `webroutes_value` VARCHAR(255),
    `webmodules_id` INT(11),
    `webroutes_order` INT(11),
    `removeable` TINYINT(1) DEFAULT 0,
    `editable` TINYINT(1) DEFAULT 0,
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`webroutes_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;


/**************************************** INSERT INTO ****************************************/

INSERT INTO webroutes(
            `webroutes_name`, `webroutes_title`, `webroutes_description`, 
            `webroutes_params`, `webroutes_value`, `webmodules_id`, `webroutes_order`, 
            `removeable`, `editable`, `_created_by`, `_updated_by`, `_created_at`, 
            `_updated_at`, `status`, `is_deleted`)
    VALUES
    ('default_controller', 'Default Controller', NULL, 'default_controller', 'dashboard', 1, 0, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('404_override', 'Override 404 Page', NULL, '404_override', NULL, NULL, 1, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('translate_uri_dashes', 'Translate URI Dash', NULL, 'translate_uri_dashes', 'TRUE', NULL, 2, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('login_developer', 'Developers Login', NULL, NULL, NULL, 3, 3, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('register', 'Register', NULL, NULL, NULL, 4, 4, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('activate', 'Activate', NULL, '(:any)/(:any)', '$1/$2', 5, 5, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('activate', 'Activate', NULL, '(:any)', '$1', 5, 6, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('activate', 'Activate', NULL, NULL, NULL, 5, 7, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('deactivate', 'Deactivate', NULL, NULL, NULL, 6, 8, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('login', 'Login', NULL, NULL, NULL, 7, 9, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('login_otp', 'Login OTP', NULL, NULL, NULL, 8, 10, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('forgot_password', 'Forgot Password', NULL, NULL, NULL, 9, 11, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('reset_password', 'Reset Password', NULL, '(:any)', '$1', 10, 12, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('locking', 'Locking Session', NULL, NULL, NULL, 11, 13, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('locked', 'Session Locked', NULL, NULL, NULL, 12, 14, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('unlock', 'Unlock Session', NULL, NULL, NULL, 13, 15, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('logout', 'Logout', NULL, NULL, NULL, 14, 16, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0)
    ;
