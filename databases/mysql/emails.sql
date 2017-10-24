/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS emails;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE emails (
    `emails_id` INT(11) NOT NULL AUTO_INCREMENT,
    `emails_sender_name` VARCHAR(255) NULL DEFAULT NULL,
    `emails_sender_address` VARCHAR(255),
    `emails_to_name` VARCHAR(255) NULL DEFAULT NULL,
    `emails_to_address` VARCHAR(255),
    `emails_send_datetime` INT(11),
    `emails_subject` VARCHAR(255) NULL DEFAULT NULL,
    `emails_message` TEXT NULL,
    `_created_by` INT(11),
    `_updated_by` INT(11),
    `_created_at` INT(11),
    `_updated_at` INT(11),
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`emails_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;

