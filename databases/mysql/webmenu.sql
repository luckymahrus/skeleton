/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS webmenu;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webmenu (
    `webmenu_id` INT(11) NOT NULL AUTO_INCREMENT,
    `webthemesmenu_id` INT(11),
    `webmenu_name` VARCHAR(255),
    `webmenu_title` text,
    `webmenu_description` text,
    `webmenu_icon` VARCHAR(50),
    `webmodules_id` INT(11),
    `webmenu_uri` VARCHAR(255),
    `webmenu_parent_id` INT(11),
    `webmenu_order` INT(11),
    `need_login` TINYINT(1) DEFAULT 1,
    `groups_access` text,
    `removeable` TINYINT(1) DEFAULT 0,
    `editable` TINYINT(1) DEFAULT 0,
    `_created_by` INT(11) NULL DEFAULT NULL,
    `_updated_by` INT(11) NULL DEFAULT NULL,
    `_created_at` INT(11) NULL DEFAULT NULL,
    `_updated_at` INT(11) NULL DEFAULT NULL,
    `status` TINYINT(2) DEFAULT 1,
    `is_deleted` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`webmenu_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;


/**************************************** INSERT INTO ****************************************/

INSERT INTO webmenu(
            `webthemesmenu_id`, `webmenu_name`, `webmenu_title`, `webmenu_description`, 
            `webmenu_icon`, `webmodules_id`, `webmenu_uri`, `webmenu_parent_id`, 
            `webmenu_order`, `need_login`, `groups_access`, `removeable`, `editable`, 
            `_created_by`, `_updated_by`, `_created_at`, 
            `_updated_at`, `status`, `is_deleted`)
    VALUES 
    (1, 'dashboard', 'Home', NULL, 'fa fa-lg fa-fw fa-home', 1, NULL, 0, 0, 1, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'users', 'Users', NULL, 'fa fa-lg fa-fw fa-user', 15, NULL, 0, 1, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'groups', 'Groups & Permission', NULL, 'fa fa-lg fa-fw fa-group', 25, NULL, 0, 2, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'core_control', 'Core Control', NULL, 'fa fa-lg fa-fw fa-cogs', 79, NULL, 0, 3, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'groups_list', 'Groups', NULL, ' ', 25, NULL, 3, 1, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'acl', 'ACL Management', NULL, ' ', 88, NULL, 3, 2, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'webconfig', 'Web Config', NULL, 'fa fa-lg fa-fw fa-cogs', 79, NULL, 4, 1, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'webmodules', 'Modules', NULL, 'fa fa-lg fa-fw fa-cogs', 34, NULL, 4, 2, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'webroutes', 'Routes', NULL, 'fa fa-lg fa-fw fa-cogs', 43, NULL, 4, 3, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'webthemes', 'Themes', NULL, 'fa fa-lg fa-fw fa-cogs', 61, NULL, 4, 4, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'webthemesmenu', 'Themes Menus', NULL, 'fa fa-lg fa-fw fa-cogs', 70, NULL, 4, 5, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'webmenu', 'Web Menu', NULL, 'fa fa-lg fa-fw fa-cogs', 52, NULL, 4, 6, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    (1, 'document_index', 'Document Management', NULL, 'fa fa-lg fa-fw fa-file-text', 93, NULL, 0, 5, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0)
    ;
