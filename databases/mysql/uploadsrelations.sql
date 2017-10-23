/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS uploadsrelations;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE uploadsrelations (
    `uploadsrelations_id` INT(11) NOT NULL AUTO_INCREMENT,
    `uploads_id` INT(11),
    `relation_table` VARCHAR(255),
    `relation_id` INT(11),
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`uploadsrelations_id`),
    UNIQUE INDEX `idx_uploadsrelations_all` (`uploads_id`,`relation_table`,`relation_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;
