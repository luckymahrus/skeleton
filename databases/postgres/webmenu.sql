/**************************************** DROP TABLE ****************************************/

DROP TABLE webmenu;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webmenu (
    "webmenu_id" serial PRIMARY KEY NOT NULL,
    "webthemesmenu_id" integer,
    "webmenu_name" character varying(255),
    "webmenu_title" text,
    "webmenu_description" text,
    "webmenu_icon" character varying(50),
    "webmodules_id" integer,
    "webmenu_uri" character varying(255),
    "webmenu_parent_id" integer,
    "webmenu_order" integer,
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
    "deleted" boolean DEFAULT FALSE
);


/**************************************** ALTER TABLE ****************************************/

ALTER TABLE public.webmenu OWNER TO postgres;


/**************************************** INSERT INTO ****************************************/

INSERT INTO webmenu(
            "webthemesmenu_id", "webmenu_name", "webmenu_title", "webmenu_description", 
            "webmenu_icon", "webmodules_id", "webmenu_uri", "webmenu_parent_id", 
            "webmenu_order", "need_login", "groups_access", "removeable", "editable", 
            "added_by", "updated_by", "deleted_by", "added_time", 
            "updated_time", "deleted_time", "ts_time", "status", "deleted")
    VALUES 
    (1, 'dashboard', 'Home', NULL, 'fa fa-lg fa-fw fa-home', 1, NULL, 0, 0, TRUE, NULL, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'users', 'Users', NULL, 'fa fa-lg fa-fw fa-user', 15, NULL, 0, 1, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'groups', 'Groups & Permission', NULL, 'fa fa-lg fa-fw fa-group', 25, NULL, 0, 2, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'core_control', 'Core Control', NULL, 'fa fa-lg fa-fw fa-cogs', 79, NULL, 0, 3, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'groups_list', 'Groups', NULL, ' ', 25, NULL, 3, 1, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'acl', 'ACL Management', NULL, ' ', 88, NULL, 3, 2, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'webconfig', 'Web Config', NULL, 'fa fa-lg fa-fw fa-cogs', 79, NULL, 4, 1, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'webmodules', 'Modules', NULL, 'fa fa-lg fa-fw fa-cogs', 34, NULL, 4, 2, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'webroutes', 'Routes', NULL, 'fa fa-lg fa-fw fa-cogs', 43, NULL, 4, 3, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'webthemes', 'Themes', NULL, 'fa fa-lg fa-fw fa-cogs', 61, NULL, 4, 4, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'webthemesmenu', 'Themes Menus', NULL, 'fa fa-lg fa-fw fa-cogs', 70, NULL, 4, 5, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'webmenu', 'Web Menu', NULL, 'fa fa-lg fa-fw fa-cogs', 52, NULL, 4, 6, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'document_index', 'Document Management', NULL, 'fa fa-lg fa-fw fa-file-text', 93, NULL, 0, 5, TRUE, 'a:1:{i:1;i:1;}', FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE)
    ;
    
ALTER TABLE webmenu RENAME COLUMN added_by TO _created_by;
ALTER TABLE webmenu RENAME COLUMN added_time TO _created_at;
ALTER TABLE webmenu RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE webmenu RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE webmenu ALTER COLUMN status TYPE smallint;

ALTER TABLE webmenu ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE webmenu SET is_deleted=1 WHERE deleted=TRUE;
UPDATE webmenu SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE webmenu DROP COLUMN IF EXISTS deleted;
ALTER TABLE webmenu DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE webmenu DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE webmenu DROP COLUMN IF EXISTS ts_time;

ALTER TABLE webmenu ALTER need_login SET DEFAULT NULL;
ALTER TABLE webmenu ADD COLUMN need_login1 smallint NOT NULL DEFAULT 0;
UPDATE webmenu SET need_login1=1 WHERE need_login=TRUE;
UPDATE webmenu SET need_login1=0 WHERE need_login=FALSE;
UPDATE webmenu SET need_login=NULL;
ALTER TABLE webmenu ALTER need_login TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE webmenu SET need_login=1 WHERE need_login1=1;
UPDATE webmenu SET need_login=0 WHERE need_login1=0;
ALTER TABLE webmenu ALTER need_login SET DEFAULT 0;
ALTER TABLE webmenu DROP COLUMN need_login1;

ALTER TABLE webmenu ALTER removeable SET DEFAULT NULL;
ALTER TABLE webmenu ADD COLUMN removeable1 smallint NOT NULL DEFAULT 0;
UPDATE webmenu SET removeable1=1 WHERE removeable=TRUE;
UPDATE webmenu SET removeable1=0 WHERE removeable=FALSE;
UPDATE webmenu SET removeable=NULL;
ALTER TABLE webmenu ALTER removeable TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE webmenu SET removeable=1 WHERE removeable1=1;
UPDATE webmenu SET removeable=0 WHERE removeable1=0;
ALTER TABLE webmenu ALTER removeable SET DEFAULT 0;
ALTER TABLE webmenu DROP COLUMN removeable1;

ALTER TABLE webmenu ALTER editable SET DEFAULT NULL;
ALTER TABLE webmenu ADD COLUMN editable1 smallint NOT NULL DEFAULT 0;
UPDATE webmenu SET editable1=1 WHERE editable=TRUE;
UPDATE webmenu SET editable1=0 WHERE editable=FALSE;
UPDATE webmenu SET editable=NULL;
ALTER TABLE webmenu ALTER editable TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE webmenu SET editable=1 WHERE editable1=1;
UPDATE webmenu SET editable=0 WHERE editable1=0;
ALTER TABLE webmenu ALTER editable SET DEFAULT 0;
ALTER TABLE webmenu DROP COLUMN editable1;
