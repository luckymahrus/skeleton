/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS loginattempts;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE loginattempts (
    `loginattempts_id` INT(11) NOT NULL AUTO_INCREMENT,
    `ip_address` VARCHAR(15) NOT NULL,
    `login` VARCHAR(255) NULL DEFAULT NULL,
    `time` INT(11) NULL DEFAULT NULL,
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`loginattempts_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;
