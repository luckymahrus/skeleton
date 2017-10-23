/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS cisessions;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE `cisessions` (
	`id` VARCHAR(128) NOT NULL,
	`ip_address` VARCHAR(45) NOT NULL,
	`timestamp` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`data` BLOB NOT NULL,
	INDEX `ci_sessions_timestamp` (`timestamp`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
;
