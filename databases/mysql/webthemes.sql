/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS webthemes;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webthemes (
    `webthemes_id` INT(11) NOT NULL AUTO_INCREMENT,
    `webthemes_name` VARCHAR(255),
    `webthemes_title` text,
    `webthemes_description` text,
    `webthemes_config` text,
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`webthemes_id`),
    UNIQUE INDEX `idx_webthemes_webthemes_name` (`webthemes_name`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;


/**************************************** INSERT INTO ****************************************/

INSERT INTO webthemes(
            `webthemes_name`, `webthemes_title`, `webthemes_description`, 
            `webthemes_config`, `_created_by`, `_updated_by`, `_created_at`, 
            `_updated_at`, `status`, `is_deleted`)
    VALUES
    ('smartadmin', 'SmartAdmin', NULL, NULL, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0);
