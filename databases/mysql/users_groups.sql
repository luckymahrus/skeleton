/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS users_groups;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE users_groups (
    `users_groups_id` INT(11) NOT NULL AUTO_INCREMENT,
    `users_id` INT(11),
    `groups_id` INT(11),
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`users_groups_id`),
    UNIQUE INDEX `idx_users_groups_all` (`users_id`,`groups_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;


/**************************************** INSERT INTO ****************************************/

INSERT INTO users_groups (`users_id`, `groups_id`, `_created_by`, `_updated_by`, `_created_at`, 
            `_updated_at`, `status`, `is_deleted`)
    VALUES
    (1, 1, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0)
    ;
