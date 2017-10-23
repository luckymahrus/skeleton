/**************************************** DROP TABLE ****************************************/

DROP TABLE IF EXISTS webmodules;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webmodules (
    `webmodules_id` INT(11) NOT NULL AUTO_INCREMENT,
    `webmodules_name` VARCHAR(255),
    `webmodules_title` text,
    `webmodules_description` text,
    `webmodules_icon` VARCHAR(50),
    `webmodules_class` VARCHAR(100),
    `webmodules_method` VARCHAR(100),
    `webmodules_method_type` VARCHAR(10) DEFAULT 'public',
    `webmodules_uri_routes` VARCHAR(255),
    `webmodules_parent_id` INT(11),
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
    PRIMARY KEY (`webmodules_id`),
    UNIQUE INDEX `idx_webmodules_all` (`webmodules_class`,`webmodules_method`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;

/**************************************** INSERT INTO ****************************************/

INSERT INTO webmodules(
            `webmodules_name`, `webmodules_title`, `webmodules_description`, 
            `webmodules_icon`, `webmodules_class`, `webmodules_method`, `webmodules_uri_routes`, 
            `webmodules_parent_id`, `need_login`, `groups_access`, `removeable`, `editable`,
            `_created_by`, `_updated_by`, `_created_at`, 
            `_updated_at`, `status`, `is_deleted`)
    VALUES
    ('dashboard_index', 'Dashboard', NULL, NULL, 'dashboard', 'index', 'dashboard', 0, 1, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('auth_index', 'Authentication', NULL, NULL, 'auth', 'index', 'auth', 0, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_login_deve', 'Login Developer', NULL, NULL, 'auth', 'login_dev', 'login-dev', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_register', 'Register', NULL, NULL, 'auth', 'register', 'register', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_activate', 'Activate Account', NULL, NULL, 'auth', 'activate', 'activate', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_deactivate', 'Dectivate Account', NULL, NULL, 'auth', 'deactivate', 'deactivate', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_login', 'Login', NULL, NULL, 'auth', 'login', 'login', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_login_otp', '2-step Auth', NULL, NULL, 'auth', 'login_otp', 'login-otp', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_forgot_password', 'Forgot Password', NULL, NULL, 'auth', 'forgot_password', 'forgot-password', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_reset_password', 'Reset Password', NULL, NULL, 'auth', 'reset_password', 'reset-password', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_locking', 'Locking Session', NULL, NULL, 'auth', 'locking', 'locking', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_locked', 'Session Locked', NULL, NULL, 'auth', 'locked', 'locked', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_unlock', 'Unlock Session', NULL, NULL, 'auth', 'unlock', 'unlock', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('auth_logout', 'Logout', NULL, NULL, 'auth', 'logout', 'logout', 2, 0, NULL, 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('users_index', 'Users Management', NULL, NULL, 'users', 'index', 'users', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('users_get', 'Get Users Data', NULL, NULL, 'users', 'get', 'users/get', 15, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('users_detail', 'User Detail', NULL, NULL, 'users', 'detail', 'users/detail', 15, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('users_get_detail', 'Get User Detail', NULL, NULL, 'users', 'get_detail', 'users/get-detail', 15, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('users_add', 'Add User', NULL, NULL, 'users', 'add', 'users/add', 15, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('users_edit', 'Edit User', NULL, NULL, 'users', 'edit', 'users/edit', 15, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('users_delete', 'Delete User', NULL, NULL, 'users', 'delete', 'users/delete', 15, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('users_activate', 'Activate User', NULL, NULL, 'users', 'activate', 'users/activate', 15, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('users_deactivate', 'Deactivate User', NULL, NULL, 'users', 'deactivate', 'users/deactivate', 15, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('users_reset_password', 'Reset User Password', NULL, NULL, 'users', 'reset_password', 'users/reset-password', 15, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('groups_index', 'Groups Management', NULL, NULL, 'groups', 'index', 'groups', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('groups_get', 'Get Groups Data', NULL, NULL, 'groups', 'get', 'groups/get', 25, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('groups_detail', 'Group Detail', NULL, NULL, 'groups', 'detail', 'groups/detail', 25, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('groups_get_detail', 'Get Group Detail', NULL, NULL, 'groups', 'get_detail', 'groups/get-detail', 25, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('groups_add', 'Add Group', NULL, NULL, 'groups', 'add', 'groups/add', 25, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('groups_edit', 'Edit Group', NULL, NULL, 'groups', 'edit', 'groups/edit', 25, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('groups_delete', 'Delete Group', NULL, NULL, 'groups', 'delete', 'groups/delete', 25, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('groups_activate', 'Activate Group', NULL, NULL, 'groups', 'activate', 'groups/activate', 25, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('groups_deactivate', 'Deactivate Group', NULL, NULL, 'groups', 'deactivate', 'groups/deactivate', 25, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('webmodules_index', 'Web Modules Management', NULL, NULL, 'webmodules', 'index', 'webmodules', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmodules_get', 'Get Web Modules Data', NULL, NULL, 'webmodules', 'get', 'webmodules/get', 34, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmodules_detail', 'Web Module Detail', NULL, NULL, 'webmodules', 'detail', 'webmodules/detail', 34, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmodules_get_detail', 'Get Web Module Detail', NULL, NULL, 'webmodules', 'get_detail', 'webmodules/get-detail', 34, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmodules_add', 'Add Web Module', NULL, NULL, 'webmodules', 'add', 'webmodules/add', 34, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmodules_edit', 'Edit Web Module', NULL, NULL, 'webmodules', 'edit', 'webmodules/edit', 34, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmodules_delete', 'Delete Web Module', NULL, NULL, 'webmodules', 'delete', 'webmodules/delete', 34, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmodules_activate', 'Activate Web Module', NULL, NULL, 'webmodules', 'activate', 'webmodules/activate', 34, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmodules_deactivate', 'Deactivate Web Module', NULL, NULL, 'webmodules', 'deactivate', 'webmodules/deactivate', 34, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('webroutes_index', 'Web Routes Management', NULL, NULL, 'webroutes', 'index', 'webroutes', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webroutes_get', 'Get Web Routes Data', NULL, NULL, 'webroutes', 'get', 'webroutes/get', 43, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webroutes_detail', 'Web Route Detail', NULL, NULL, 'webroutes', 'detail', 'webroutes/detail', 43, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webroutes_get_detail', 'Get Web Route Detail', NULL, NULL, 'webroutes', 'get_detail', 'webroutes/get-detail', 43, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webroutes_add', 'Add Web Route', NULL, NULL, 'webroutes', 'add', 'webroutes/add', 43, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webroutes_edit', 'Edit Web Route', NULL, NULL, 'webroutes', 'edit', 'webroutes/edit', 43, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webroutes_delete', 'Delete Web Route', NULL, NULL, 'webroutes', 'delete', 'webroutes/delete', 43, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webroutes_activate', 'Activate Web Route', NULL, NULL, 'webroutes', 'activate', 'webroutes/activate', 43, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webroutes_deactivate', 'Deactivate Web Route', NULL, NULL, 'webroutes', 'deactivate', 'webroutes/deactivate', 43, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('webmenu_index', 'Web Menus Management', NULL, NULL, 'webmenu', 'index', 'webmenu', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmenu_get', 'Get Web Menus Data', NULL, NULL, 'webmenu', 'get', 'webmenu/get', 52, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmenu_detail', 'Web Menu Detail', NULL, NULL, 'webmenu', 'detail', 'webmenu/detail', 52, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmenu_get_detail', 'Get Web Menu Detail', NULL, NULL, 'webmenu', 'get_detail', 'webmenu/get-detail', 52, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmenu_add', 'Add Web Menu', NULL, NULL, 'webmenu', 'add', 'webmenu/add', 52, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmenu_edit', 'Edit Web Menu', NULL, NULL, 'webmenu', 'edit', 'webmenu/edit', 52, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmenu_delete', 'Delete Web Menu', NULL, NULL, 'webmenu', 'delete', 'webmenu/delete', 52, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmenu_activate', 'Activate Web Menu', NULL, NULL, 'webmenu', 'activate', 'webmenu/activate', 52, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webmenu_deactivate', 'Deactivate Web Menu', NULL, NULL, 'webmenu', 'deactivate', 'webmenu/deactivate', 52, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('webthemes_index', 'Web Themes Management', NULL, NULL, 'webthemes', 'index', 'webthemes', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemes_get', 'Get Web Themes Data', NULL, NULL, 'webthemes', 'get', 'webthemes/get', 61, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemes_detail', 'Web Theme Detail', NULL, NULL, 'webthemes', 'detail', 'webthemes/detail', 61, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemes_get_detail', 'Get Web Theme Detail', NULL, NULL, 'webthemes', 'get_detail', 'webthemes/get-detail', 61, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemes_add', 'Add Web Theme', NULL, NULL, 'webthemes', 'add', 'webthemes/add', 61, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemes_edit', 'Edit Web Theme', NULL, NULL, 'webthemes', 'edit', 'webthemes/edit', 61, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemes_delete', 'Delete Web Theme', NULL, NULL, 'webthemes', 'delete', 'webthemes/delete', 61, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemes_activate', 'Activate Web Theme', NULL, NULL, 'webthemes', 'activate', 'webthemes/activate', 61, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemes_deactivate', 'Deactivate Web Theme', NULL, NULL, 'webthemes', 'deactivate', 'webthemes/deactivate', 61, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('webthemesmenu_index', 'Web Theme Menus Management', NULL, NULL, 'webthemesmenu', 'index', 'webthemesmenu', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemesmenu_get', 'Get Web Theme Menus Data', NULL, NULL, 'webthemesmenu', 'get', 'webthemesmenu/get', 70, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemesmenu_detail', 'Web Theme Menu Detail', NULL, NULL, 'webthemesmenu', 'detail', 'webthemesmenu/detail', 70, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemesmenu_get_detail', 'Get Web Theme Menu Detail', NULL, NULL, 'webthemesmenu', 'get_detail', 'webthemesmenu/get-detail', 70, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemesmenu_add', 'Add Web Theme Menu', NULL, NULL, 'webthemesmenu', 'add', 'webthemesmenu/add', 70, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemesmenu_edit', 'Edit Web Theme Menu', NULL, NULL, 'webthemesmenu', 'edit', 'webthemesmenu/edit', 70, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemesmenu_delete', 'Delete Web Theme Menu', NULL, NULL, 'webthemesmenu', 'delete', 'webthemesmenu/delete', 70, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemesmenu_activate', 'Activate Web Theme Menu', NULL, NULL, 'webthemesmenu', 'activate', 'webthemesmenu/activate', 70, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webthemesmenu_deactivate', 'Deactivate Web Theme Menu', NULL, NULL, 'webthemesmenu', 'deactivate', 'webthemesmenu/deactivate', 70, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('webconfig_index', 'Web Configs Management', NULL, NULL, 'webconfig', 'index', 'webconfig', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webconfig_get', 'Get Web Configs Data', NULL, NULL, 'webconfig', 'get', 'webconfig/get', 79, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webconfig_detail', 'Web Config Detail', NULL, NULL, 'webconfig', 'detail', 'webconfig/detail', 79, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webconfig_get_detail', 'Get Web Config Detail', NULL, NULL, 'webconfig', 'get_detail', 'webconfig/get-detail', 79, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webconfig_add', 'Add Web Config', NULL, NULL, 'webconfig', 'add', 'webconfig/add', 79, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webconfig_edit', 'Edit Web Config', NULL, NULL, 'webconfig', 'edit', 'webconfig/edit', 79, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webconfig_delete', 'Delete Web Config', NULL, NULL, 'webconfig', 'delete', 'webconfig/delete', 79, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webconfig_activate', 'Activate Web Config', NULL, NULL, 'webconfig', 'activate', 'webconfig/activate', 79, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('webconfig_deactivate', 'Deactivate Web Config', NULL, NULL, 'webconfig', 'deactivate', 'webconfig/deactivate', 79, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('acl_index', 'ACL Management', NULL, NULL, 'acl', 'index', 'acl', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('acl_get', 'Get ACL Data', NULL, NULL, 'acl', 'get', 'acl/get', 88, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('acl_detail', 'ACL Detail', NULL, NULL, 'acl', 'detail', 'acl/detail', 88, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('acl_get_detail', 'Get ACL Detail', NULL, NULL, 'acl', 'get_detail', 'acl/get-detail', 88, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('acl_edit', 'Edit ACL', NULL, NULL, 'acl', 'edit', 'acl/edit', 88, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),

    ('document_index', 'Web Configs Management', NULL, NULL, 'document', 'index', 'document', 0, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('document_get', 'Get Web Configs Data', NULL, NULL, 'document', 'get', 'document/get', 93, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('document_detail', 'Web Config Detail', NULL, NULL, 'document', 'detail', 'document/detail', 93, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('document_get_detail', 'Get Web Config Detail', NULL, NULL, 'document', 'get_detail', 'document/get-detail', 93, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('document_add', 'Add Web Config', NULL, NULL, 'document', 'add', 'document/add', 93, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('document_edit', 'Edit Web Config', NULL, NULL, 'document', 'edit', 'document/edit', 93, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('document_delete', 'Delete Web Config', NULL, NULL, 'document', 'delete', 'document/delete', 93, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('document_activate', 'Activate Web Config', NULL, NULL, 'document', 'activate', 'document/activate', 93, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0),
    ('document_deactivate', 'Deactivate Web Config', NULL, NULL, 'document', 'deactivate', 'document/deactivate', 93, 1, 'a:1:{i:1;i:1;}', 0, 0, 0, NULL, UNIX_TIMESTAMP(), NULL, 1, 0)
    ;
