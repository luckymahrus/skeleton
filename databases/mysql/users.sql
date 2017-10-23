/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS users;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE users (
    `users_id` INT(11) NOT NULL AUTO_INCREMENT,
    `users_ip_address` VARCHAR(15),
    `users_username` VARCHAR(100),
    `users_password` VARCHAR(255),
    `users_password_ori` VARCHAR(255),
    `users_otp` VARCHAR(255),
    `users_otp_login_code` VARCHAR(40),
    `users_otp_backup_codes` text,
    `users_salt` VARCHAR(255),
    `users_email` VARCHAR(255),
    `users_activation_code` VARCHAR(40),
    `forgotten_password_code` VARCHAR(40),
    `forgotten_password_time` INT(11),
    `remember_code` VARCHAR(40),
    `users_last_login` INT(11),
    `users_first_name` VARCHAR(100),
    `users_last_name` VARCHAR(100),
    `users_avatar` VARCHAR(100),
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`users_id`),
    UNIQUE INDEX `idx_users_username` (`users_username`),
    UNIQUE INDEX `idx_users_salt` (`users_salt`),
    UNIQUE INDEX `idx_users_email` (`users_email`),
    UNIQUE INDEX `idx_users_activation_code` (`users_activation_code`),
    UNIQUE INDEX `idx_forgotten_password_code` (`forgotten_password_code`),
    UNIQUE INDEX `idx_remember_code` (`remember_code`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;

/**************************************** INSERT INTO ****************************************/

INSERT INTO users (`users_ip_address`, `users_username`, `users_password`, `users_password_ori`, `users_otp`, `users_otp_login_code`, `users_otp_backup_codes`, `users_salt`, `users_email`, `users_activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `users_last_login`, `users_first_name`, `users_last_name`, `users_avatar`, `_created_by`, `_updated_by`, `_created_at`, 
            `_updated_at`, `status`, `is_deleted`)
    VALUES
    ('127.0.0.1', 'superadmin', '$2y$08$M0cQHtwa1r9Y4KBGFnuEKunk8WTKVC2WAhdrVs3S6XQXL7le7QiyS', NULL, NULL, NULL, NULL, 'OrI/QmHT23w7V8e/qgwHJe', 'superadmin@admin.com', NULL, NULL, NULL, NULL, UNIX_TIMESTAMP(), 'Super', 'Admin', NULL, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0)
    ;
