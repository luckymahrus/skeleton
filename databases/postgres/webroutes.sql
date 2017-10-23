/**************************************** DROP TABLE ****************************************/

DROP TABLE webroutes;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webroutes (
    "webroutes_id" serial PRIMARY KEY NOT NULL,
    "webroutes_name" character varying(255),
    "webroutes_title" text,
    "webroutes_description" text,
    "webroutes_params" character varying(255),
    "webroutes_value" character varying(255),
    "webmodules_id" integer,
    "webroutes_order" integer,
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

ALTER TABLE public.webroutes OWNER TO postgres;


/**************************************** INSERT INTO ****************************************/

INSERT INTO webroutes(
            "webroutes_name", "webroutes_title", "webroutes_description", 
            "webroutes_params", "webroutes_value", "webmodules_id", "webroutes_order", 
            "removeable", "editable", "added_by", "updated_by", "deleted_by", "added_time", 
            "updated_time", "deleted_time", "ts_time", "status", "deleted")
    VALUES
    ('default_controller', 'Default Controller', NULL, 'default_controller', 'dashboard', 1, 0, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('404_override', 'Override 404 Page', NULL, '404_override', NULL, NULL, 1, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('translate_uri_dashes', 'Translate URI Dash', NULL, 'translate_uri_dashes', 'TRUE', NULL, 2, FALSE, FALSE,0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('login_developer', 'Developers Login', NULL, NULL, NULL, 3, 3, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('register', 'Register', NULL, NULL, NULL, 4, 4, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('activate', 'Activate', NULL, '(:any)/(:any)', '$1/$2', 5, 5, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('activate', 'Activate', NULL, '(:any)', '$1', 5, 6, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('activate', 'Activate', NULL, NULL, NULL, 5, 7, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('deactivate', 'Deactivate', NULL, NULL, NULL, 6, 8, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('login', 'Login', NULL, NULL, NULL, 7, 9, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('login_otp', 'Login OTP', NULL, NULL, NULL, 8, 10, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('forgot_password', 'Forgot Password', NULL, NULL, NULL, 9, 11, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('reset_password', 'Reset Password', NULL, '(:any)', '$1', 10, 12, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('locking', 'Locking Session', NULL, NULL, NULL, 11, 13, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('locked', 'Session Locked', NULL, NULL, NULL, 12, 14, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('unlock', 'Unlock Session', NULL, NULL, NULL, 13, 15, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('logout', 'Logout', NULL, NULL, NULL, 14, 16, FALSE, FALSE, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE)
    ;
    
ALTER TABLE webroutes RENAME COLUMN added_by TO _created_by;
ALTER TABLE webroutes RENAME COLUMN added_time TO _created_at;
ALTER TABLE webroutes RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE webroutes RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE webroutes ALTER COLUMN status TYPE smallint;

ALTER TABLE webroutes ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE webroutes SET is_deleted=1 WHERE deleted=TRUE;
UPDATE webroutes SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE webroutes DROP COLUMN IF EXISTS deleted;
ALTER TABLE webroutes DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE webroutes DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE webroutes DROP COLUMN IF EXISTS ts_time;

ALTER TABLE webroutes ALTER removeable SET DEFAULT NULL;
ALTER TABLE webroutes ADD COLUMN removeable1 smallint NOT NULL DEFAULT 0;
UPDATE webroutes SET removeable1=1 WHERE removeable=TRUE;
UPDATE webroutes SET removeable1=0 WHERE removeable=FALSE;
UPDATE webroutes SET removeable=NULL;
ALTER TABLE webroutes ALTER removeable TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE webroutes SET removeable=1 WHERE removeable1=1;
UPDATE webroutes SET removeable=0 WHERE removeable1=0;
ALTER TABLE webroutes ALTER removeable SET DEFAULT 0;
ALTER TABLE webroutes DROP COLUMN removeable1;

ALTER TABLE webroutes ALTER editable SET DEFAULT NULL;
ALTER TABLE webroutes ADD COLUMN editable1 smallint NOT NULL DEFAULT 0;
UPDATE webroutes SET editable1=1 WHERE editable=TRUE;
UPDATE webroutes SET editable1=0 WHERE editable=FALSE;
UPDATE webroutes SET editable=NULL;
ALTER TABLE webroutes ALTER editable TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE webroutes SET editable=1 WHERE editable1=1;
UPDATE webroutes SET editable=0 WHERE editable1=0;
ALTER TABLE webroutes ALTER editable SET DEFAULT 0;
ALTER TABLE webroutes DROP COLUMN editable1;

