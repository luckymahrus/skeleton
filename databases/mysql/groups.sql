/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS groups;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE groups (
    `groups_id` INT(11) NOT NULL AUTO_INCREMENT,
    `groups_name` VARCHAR(20),
    `groups_description` VARCHAR(100),
    `groups_level` TINYINT(2),
    `groups_internal` TINYINT(1),
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`groups_id`),
    UNIQUE INDEX `idx_groups_groups_name` (`groups_name`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;


/**************************************** INSERT INTO ****************************************/
   
INSERT INTO groups (`groups_name`, `groups_description`, `groups_level`, `groups_internal`, `_created_by`, `_updated_by`, `_created_at`, `_updated_at`, `status`, `is_deleted`)
    VALUES
    ('superadmin', 'Super Administrator', 10, 1, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, FALSE),
    ('admin', 'Administrator', 9, 1, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, FALSE)
    ;
