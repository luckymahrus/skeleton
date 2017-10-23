/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS webthemesmenu;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webthemesmenu (
    `webthemesmenu_id` INT(11) NOT NULL AUTO_INCREMENT,
    `webthemes_id` INT(11),
    `webthemesmenu_name` VARCHAR(255),
    `webthemesmenu_title` text,
    `webthemesmenu_description` text,
    `webthemesmenu_config` text,
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`webthemesmenu_id`),
    UNIQUE INDEX `idx_webthemesmenu_all` (`webthemes_id`,`webthemesmenu_name`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;


/**************************************** INSERT INTO ****************************************/

INSERT INTO webthemesmenu(
            `webthemes_id`, `webthemesmenu_name`, `webthemesmenu_title`, 
            `webthemesmenu_description`, `webthemesmenu_config`, `_created_by`, `_updated_by`, `_created_at`, 
            `_updated_at`, `status`, `is_deleted`)
    VALUES 
    (1, 'main_navigation', 'Main Navigation', NULL, NULL, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'shortcut', 'Shortcut', NULL, NULL, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0)
    ;
