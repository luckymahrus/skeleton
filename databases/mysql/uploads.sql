/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS uploads;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE uploads (
    `uploads_id` INT(11) NOT NULL AUTO_INCREMENT,
    `uploads_name` VARCHAR(255),
    `uploads_file_name` VARCHAR(255),
    `uploads_raw_name` VARCHAR(255),
    `uploads_orig_name` VARCHAR(255),
    `uploads_client_name` VARCHAR(255),
    `uploads_file_path` TEXT,
    `uploads_full_path` TEXT,
    `uploads_file_type` VARCHAR(255),
    `uploads_image_type` VARCHAR(10),
    `uploads_file_ext` VARCHAR(255),
    `uploads_image_width` INT(11),
    `uploads_image_height` INT(11),
    `uploads_image_size_str` VARCHAR(50),
    `uploads_file_size` decimal (10,2),
    `uploads_is_image` TINYINT(1) DEFAULT 0,
    `uploads_description` VARCHAR(255),
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`uploads_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;
