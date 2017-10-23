/**************************************** DROP TABLE ****************************************/

DROP TABLE webmodules;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webmodules (
    "webmodules_id" serial PRIMARY KEY NOT NULL,
    "webmodules_name" character varying(255),
    "webmodules_title" text,
    "webmodules_description" text,
    "webmodules_icon" character varying(50),
    "webmodules_class" character varying(100),
    "webmodules_method" character varying(100),
    "webmodules_method_type" character varying(10) DEFAULT 'public',
    "webmodules_uri_routes" character varying(255),
    "webmodules_parent_id" integer,
    "need_login" boolean,
    "groups_access" text,
    "removeable" boolean DEFAULT FALSE,
    "editable" boolean DEFAULT FALSE,
    "added_by" integer,
    "updated_by" integer,
    "deleted_by" integer,
    "added_time" integer,
    "updated_time" integer,
    "deleted_time" integer,
    "ts_time" timestamp without time zone DEFAULT now(),
    "status" integer DEFAULT 1,
    "deleted" boolean DEFAULT FALSE,
    unique ("webmodules_class","webmodules_method")
);


/**************************************** ALTER TABLE ****************************************/

ALTER TABLE public.webmodules OWNER TO postgres;


/**************************************** INSERT INTO ****************************************/

INSERT INTO webmodules(
            "webmodules_name", "webmodules_title", "webmodules_description", 
            "webmodules_icon", "webmodules_class", "webmodules_method", "webmodules_uri_routes", 
            "webmodules_parent_id", "need_login", "groups_access", "removeable", "editable",
            "added_by", "updated_by", "deleted_by", "added_time", "updated_time", "deleted_time", "ts_time", "status", "deleted")
    VALUES
    ('dashboard_index', 'Dashboard', NULL, NULL, 'dashboard', 'index', 'dashboard', 0, TRUE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('auth_index', 'Authentication', NULL, NULL, 'auth', 'index', 'auth', 0, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_login_deve', 'Login Developer', NULL, NULL, 'auth', 'login_dev', 'login-dev', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_register', 'Register', NULL, NULL, 'auth', 'register', 'register', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_activate', 'Activate Account', NULL, NULL, 'auth', 'activate', 'activate', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_deactivate', 'Dectivate Account', NULL, NULL, 'auth', 'deactivate', 'deactivate', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_login', 'Login', NULL, NULL, 'auth', 'login', 'login', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_login_otp', '2-step Auth', NULL, NULL, 'auth', 'login_otp', 'login-otp', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_forgot_password', 'Forgot Password', NULL, NULL, 'auth', 'forgot_password', 'forgot-password', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_reset_password', 'Reset Password', NULL, NULL, 'auth', 'reset_password', 'reset-password', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_locking', 'Locking Session', NULL, NULL, 'auth', 'locking', 'locking', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_locked', 'Session Locked', NULL, NULL, 'auth', 'locked', 'locked', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_unlock', 'Unlock Session', NULL, NULL, 'auth', 'unlock', 'unlock', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('auth_logout', 'Logout', NULL, NULL, 'auth', 'logout', 'logout', 2, FALSE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('users_index', 'Users Management', NULL, NULL, 'users', 'index', 'users', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('users_get', 'Get Users Data', NULL, NULL, 'users', 'get', 'users/get', 15, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('users_detail', 'User Detail', NULL, NULL, 'users', 'detail', 'users/detail', 15, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('users_get_detail', 'Get User Detail', NULL, NULL, 'users', 'get_detail', 'users/get-detail', 15, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('users_add', 'Add User', NULL, NULL, 'users', 'add', 'users/add', 15, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('users_edit', 'Edit User', NULL, NULL, 'users', 'edit', 'users/edit', 15, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('users_delete', 'Delete User', NULL, NULL, 'users', 'delete', 'users/delete', 15, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('users_activate', 'Activate User', NULL, NULL, 'users', 'activate', 'users/activate', 15, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('users_deactivate', 'Deactivate User', NULL, NULL, 'users', 'deactivate', 'users/deactivate', 15, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('users_reset_password', 'Reset User Password', NULL, NULL, 'users', 'reset_password', 'users/reset-password', 15, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('groups_index', 'Groups Management', NULL, NULL, 'groups', 'index', 'groups', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('groups_get', 'Get Groups Data', NULL, NULL, 'groups', 'get', 'groups/get', 25, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('groups_detail', 'Group Detail', NULL, NULL, 'groups', 'detail', 'groups/detail', 25, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('groups_get_detail', 'Get Group Detail', NULL, NULL, 'groups', 'get_detail', 'groups/get-detail', 25, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('groups_add', 'Add Group', NULL, NULL, 'groups', 'add', 'groups/add', 25, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('groups_edit', 'Edit Group', NULL, NULL, 'groups', 'edit', 'groups/edit', 25, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('groups_delete', 'Delete Group', NULL, NULL, 'groups', 'delete', 'groups/delete', 25, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('groups_activate', 'Activate Group', NULL, NULL, 'groups', 'activate', 'groups/activate', 25, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('groups_deactivate', 'Deactivate Group', NULL, NULL, 'groups', 'deactivate', 'groups/deactivate', 25, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('webmodules_index', 'Web Modules Management', NULL, NULL, 'webmodules', 'index', 'webmodules', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmodules_get', 'Get Web Modules Data', NULL, NULL, 'webmodules', 'get', 'webmodules/get', 34, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmodules_detail', 'Web Module Detail', NULL, NULL, 'webmodules', 'detail', 'webmodules/detail', 34, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmodules_get_detail', 'Get Web Module Detail', NULL, NULL, 'webmodules', 'get_detail', 'webmodules/get-detail', 34, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmodules_add', 'Add Web Module', NULL, NULL, 'webmodules', 'add', 'webmodules/add', 34, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmodules_edit', 'Edit Web Module', NULL, NULL, 'webmodules', 'edit', 'webmodules/edit', 34, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmodules_delete', 'Delete Web Module', NULL, NULL, 'webmodules', 'delete', 'webmodules/delete', 34, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmodules_activate', 'Activate Web Module', NULL, NULL, 'webmodules', 'activate', 'webmodules/activate', 34, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmodules_deactivate', 'Deactivate Web Module', NULL, NULL, 'webmodules', 'deactivate', 'webmodules/deactivate', 34, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('webroutes_index', 'Web Routes Management', NULL, NULL, 'webroutes', 'index', 'webroutes', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webroutes_get', 'Get Web Routes Data', NULL, NULL, 'webroutes', 'get', 'webroutes/get', 43, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webroutes_detail', 'Web Route Detail', NULL, NULL, 'webroutes', 'detail', 'webroutes/detail', 43, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webroutes_get_detail', 'Get Web Route Detail', NULL, NULL, 'webroutes', 'get_detail', 'webroutes/get-detail', 43, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webroutes_add', 'Add Web Route', NULL, NULL, 'webroutes', 'add', 'webroutes/add', 43, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webroutes_edit', 'Edit Web Route', NULL, NULL, 'webroutes', 'edit', 'webroutes/edit', 43, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webroutes_delete', 'Delete Web Route', NULL, NULL, 'webroutes', 'delete', 'webroutes/delete', 43, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webroutes_activate', 'Activate Web Route', NULL, NULL, 'webroutes', 'activate', 'webroutes/activate', 43, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webroutes_deactivate', 'Deactivate Web Route', NULL, NULL, 'webroutes', 'deactivate', 'webroutes/deactivate', 43, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('webmenu_index', 'Web Menus Management', NULL, NULL, 'webmenu', 'index', 'webmenu', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmenu_get', 'Get Web Menus Data', NULL, NULL, 'webmenu', 'get', 'webmenu/get', 52, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmenu_detail', 'Web Menu Detail', NULL, NULL, 'webmenu', 'detail', 'webmenu/detail', 52, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmenu_get_detail', 'Get Web Menu Detail', NULL, NULL, 'webmenu', 'get_detail', 'webmenu/get-detail', 52, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmenu_add', 'Add Web Menu', NULL, NULL, 'webmenu', 'add', 'webmenu/add', 52, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmenu_edit', 'Edit Web Menu', NULL, NULL, 'webmenu', 'edit', 'webmenu/edit', 52, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmenu_delete', 'Delete Web Menu', NULL, NULL, 'webmenu', 'delete', 'webmenu/delete', 52, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmenu_activate', 'Activate Web Menu', NULL, NULL, 'webmenu', 'activate', 'webmenu/activate', 52, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webmenu_deactivate', 'Deactivate Web Menu', NULL, NULL, 'webmenu', 'deactivate', 'webmenu/deactivate', 52, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('webthemes_index', 'Web Themes Management', NULL, NULL, 'webthemes', 'index', 'webthemes', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemes_get', 'Get Web Themes Data', NULL, NULL, 'webthemes', 'get', 'webthemes/get', 61, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemes_detail', 'Web Theme Detail', NULL, NULL, 'webthemes', 'detail', 'webthemes/detail', 61, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemes_get_detail', 'Get Web Theme Detail', NULL, NULL, 'webthemes', 'get_detail', 'webthemes/get-detail', 61, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemes_add', 'Add Web Theme', NULL, NULL, 'webthemes', 'add', 'webthemes/add', 61, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemes_edit', 'Edit Web Theme', NULL, NULL, 'webthemes', 'edit', 'webthemes/edit', 61, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemes_delete', 'Delete Web Theme', NULL, NULL, 'webthemes', 'delete', 'webthemes/delete', 61, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemes_activate', 'Activate Web Theme', NULL, NULL, 'webthemes', 'activate', 'webthemes/activate', 61, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemes_deactivate', 'Deactivate Web Theme', NULL, NULL, 'webthemes', 'deactivate', 'webthemes/deactivate', 61, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('webthemesmenu_index', 'Web Theme Menus Management', NULL, NULL, 'webthemesmenu', 'index', 'webthemesmenu', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemesmenu_get', 'Get Web Theme Menus Data', NULL, NULL, 'webthemesmenu', 'get', 'webthemesmenu/get', 70, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemesmenu_detail', 'Web Theme Menu Detail', NULL, NULL, 'webthemesmenu', 'detail', 'webthemesmenu/detail', 70, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemesmenu_get_detail', 'Get Web Theme Menu Detail', NULL, NULL, 'webthemesmenu', 'get_detail', 'webthemesmenu/get-detail', 70, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemesmenu_add', 'Add Web Theme Menu', NULL, NULL, 'webthemesmenu', 'add', 'webthemesmenu/add', 70, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemesmenu_edit', 'Edit Web Theme Menu', NULL, NULL, 'webthemesmenu', 'edit', 'webthemesmenu/edit', 70, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemesmenu_delete', 'Delete Web Theme Menu', NULL, NULL, 'webthemesmenu', 'delete', 'webthemesmenu/delete', 70, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemesmenu_activate', 'Activate Web Theme Menu', NULL, NULL, 'webthemesmenu', 'activate', 'webthemesmenu/activate', 70, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webthemesmenu_deactivate', 'Deactivate Web Theme Menu', NULL, NULL, 'webthemesmenu', 'deactivate', 'webthemesmenu/deactivate', 70, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('webconfig_index', 'Web Configs Management', NULL, NULL, 'webconfig', 'index', 'webconfig', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webconfig_get', 'Get Web Configs Data', NULL, NULL, 'webconfig', 'get', 'webconfig/get', 79, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webconfig_detail', 'Web Config Detail', NULL, NULL, 'webconfig', 'detail', 'webconfig/detail', 79, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webconfig_get_detail', 'Get Web Config Detail', NULL, NULL, 'webconfig', 'get_detail', 'webconfig/get-detail', 79, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webconfig_add', 'Add Web Config', NULL, NULL, 'webconfig', 'add', 'webconfig/add', 79, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webconfig_edit', 'Edit Web Config', NULL, NULL, 'webconfig', 'edit', 'webconfig/edit', 79, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webconfig_delete', 'Delete Web Config', NULL, NULL, 'webconfig', 'delete', 'webconfig/delete', 79, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webconfig_activate', 'Activate Web Config', NULL, NULL, 'webconfig', 'activate', 'webconfig/activate', 79, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('webconfig_deactivate', 'Deactivate Web Config', NULL, NULL, 'webconfig', 'deactivate', 'webconfig/deactivate', 79, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('acl_index', 'ACL Management', NULL, NULL, 'acl', 'index', 'acl', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('acl_get', 'Get ACL Data', NULL, NULL, 'acl', 'get', 'acl/get', 88, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('acl_detail', 'ACL Detail', NULL, NULL, 'acl', 'detail', 'acl/detail', 88, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('acl_get_detail', 'Get ACL Detail', NULL, NULL, 'acl', 'get_detail', 'acl/get-detail', 88, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('acl_edit', 'Edit ACL', NULL, NULL, 'acl', 'edit', 'acl/edit', 88, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('document_index', 'Web Configs Management', NULL, NULL, 'document', 'index', 'document', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('document_get', 'Get Web Configs Data', NULL, NULL, 'document', 'get', 'document/get', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('document_detail', 'Web Config Detail', NULL, NULL, 'document', 'detail', 'document/detail', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('document_get_detail', 'Get Web Config Detail', NULL, NULL, 'document', 'get_detail', 'document/get-detail', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('document_add', 'Add Web Config', NULL, NULL, 'document', 'add', 'document/add', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('document_edit', 'Edit Web Config', NULL, NULL, 'document', 'edit', 'document/edit', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('document_delete', 'Delete Web Config', NULL, NULL, 'document', 'delete', 'document/delete', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('document_activate', 'Activate Web Config', NULL, NULL, 'document', 'activate', 'document/activate', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('document_deactivate', 'Deactivate Web Config', NULL, NULL, 'document', 'deactivate', 'document/deactivate', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('parameters_index', 'Parameters Management', NULL, NULL, 'parameters', 'index', 'parameters', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('parameters_get', 'Get Parameters Data', NULL, NULL, 'parameters', 'get', 'parameters/get', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('parameters_detail', 'Web Config Detail', NULL, NULL, 'parameters', 'detail', 'parameters/detail', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('parameters_get_detail', 'Get Web Config Detail', NULL, NULL, 'parameters', 'get_detail', 'parameters/get-detail', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('parameters_add', 'Add Web Config', NULL, NULL, 'parameters', 'add', 'parameters/add', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('parameters_edit', 'Edit Web Config', NULL, NULL, 'parameters', 'edit', 'parameters/edit', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('parameters_delete', 'Delete Web Config', NULL, NULL, 'parameters', 'delete', 'parameters/delete', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('parameters_activate', 'Activate Web Config', NULL, NULL, 'parameters', 'activate', 'parameters/activate', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('parameters_deactivate', 'Deactivate Web Config', NULL, NULL, 'parameters', 'deactivate', 'parameters/deactivate', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),

    ('products_index', 'Products Management', NULL, NULL, 'products', 'index', 'products', 0, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('products_get', 'Get Products Data', NULL, NULL, 'products', 'get', 'products/get', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('products_detail', 'Web Config Detail', NULL, NULL, 'products', 'detail', 'products/detail', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('products_get_detail', 'Get Web Config Detail', NULL, NULL, 'products', 'get_detail', 'products/get-detail', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('products_add', 'Add Web Config', NULL, NULL, 'products', 'add', 'products/add', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('products_edit', 'Edit Web Config', NULL, NULL, 'products', 'edit', 'products/edit', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('products_delete', 'Delete Web Config', NULL, NULL, 'products', 'delete', 'products/delete', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('products_activate', 'Activate Web Config', NULL, NULL, 'products', 'activate', 'products/activate', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('products_deactivate', 'Deactivate Web Config', NULL, NULL, 'products', 'deactivate', 'products/deactivate', 93, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE)
    ;
    
ALTER TABLE webmodules RENAME COLUMN added_by TO _created_by;
ALTER TABLE webmodules RENAME COLUMN added_time TO _created_at;
ALTER TABLE webmodules RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE webmodules RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE webmodules ALTER COLUMN status TYPE smallint;

ALTER TABLE webmodules ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE webmodules SET is_deleted=1 WHERE deleted=TRUE;
UPDATE webmodules SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE webmodules DROP COLUMN IF EXISTS deleted;
ALTER TABLE webmodules DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE webmodules DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE webmodules DROP COLUMN IF EXISTS ts_time;

ALTER TABLE webmodules ALTER need_login SET DEFAULT NULL;
ALTER TABLE webmodules ADD COLUMN need_login1 smallint NOT NULL DEFAULT 0;
UPDATE webmodules SET need_login1=1 WHERE need_login=TRUE;
UPDATE webmodules SET need_login1=0 WHERE need_login=FALSE;
UPDATE webmodules SET need_login=NULL;
ALTER TABLE webmodules ALTER need_login TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE webmodules SET need_login=1 WHERE need_login1=1;
UPDATE webmodules SET need_login=0 WHERE need_login1=0;
ALTER TABLE webmodules ALTER need_login SET DEFAULT 0;
ALTER TABLE webmodules DROP COLUMN need_login1;

ALTER TABLE webmodules ALTER removeable SET DEFAULT NULL;
ALTER TABLE webmodules ADD COLUMN removeable1 smallint NOT NULL DEFAULT 0;
UPDATE webmodules SET removeable1=1 WHERE removeable=TRUE;
UPDATE webmodules SET removeable1=0 WHERE removeable=FALSE;
UPDATE webmodules SET removeable=NULL;
ALTER TABLE webmodules ALTER removeable TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE webmodules SET removeable=1 WHERE removeable1=1;
UPDATE webmodules SET removeable=0 WHERE removeable1=0;
ALTER TABLE webmodules ALTER removeable SET DEFAULT 0;
ALTER TABLE webmodules DROP COLUMN removeable1;

ALTER TABLE webmodules ALTER editable SET DEFAULT NULL;
ALTER TABLE webmodules ADD COLUMN editable1 smallint NOT NULL DEFAULT 0;
UPDATE webmodules SET editable1=1 WHERE editable=TRUE;
UPDATE webmodules SET editable1=0 WHERE editable=FALSE;
UPDATE webmodules SET editable=NULL;
ALTER TABLE webmodules ALTER editable TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE webmodules SET editable=1 WHERE editable1=1;
UPDATE webmodules SET editable=0 WHERE editable1=0;
ALTER TABLE webmodules ALTER editable SET DEFAULT 0;
ALTER TABLE webmodules DROP COLUMN editable1;


