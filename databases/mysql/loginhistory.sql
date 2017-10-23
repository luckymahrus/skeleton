/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS loginhistory;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE loginhistory (
    `loginhistory_id` INT(11) NOT NULL AUTO_INCREMENT,
    `sessions_id` VARCHAR(128) NOT NULL,
    `users_id` INT(11) NULL DEFAULT NULL,
    `ip_address` VARCHAR(15) NOT NULL,
    `useragent` text NULL,
    `platform` VARCHAR(255) NULL DEFAULT NULL,
    `browser` VARCHAR(255) NULL DEFAULT NULL,
    `remember_login` TINYINT(1) DEFAULT 0,
    `time_login` INT(11) NULL DEFAULT NULL,
    `time_logout` INT(11) NULL DEFAULT NULL,
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`loginhistory_id`),
    UNIQUE INDEX `idx_loginhistory_sessions_id` (`sessions_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;
