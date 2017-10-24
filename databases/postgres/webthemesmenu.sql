/**************************************** DROP TABLE IF EXISTS ****************************************/

DROP TABLE IF EXISTS webthemesmenu;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webthemesmenu (
    "webthemesmenu_id" serial PRIMARY KEY NOT NULL,
    "webthemes_id" integer,
    "webthemesmenu_name" character varying(255),
    "webthemesmenu_title" text,
    "webthemesmenu_description" text,
    "webthemesmenu_config" text,
    "added_by" integer,
    "updated_by" integer,
    "deleted_by" integer,
    "added_time" integer,
    "updated_time" integer,
    "deleted_time" integer,
    "ts_time" timestamp without time zone DEFAULT now(),
    "status" integer DEFAULT 1,
    "deleted" boolean DEFAULT FALSE,
    unique ("webthemes_id","webthemesmenu_name")
);


/**************************************** ALTER TABLE ****************************************/

ALTER TABLE public.webthemesmenu OWNER TO postgres;


/**************************************** INSERT INTO ****************************************/

INSERT INTO webthemesmenu(
            "webthemes_id", "webthemesmenu_name", "webthemesmenu_title", 
            "webthemesmenu_description", "webthemesmenu_config", "added_by", "updated_by", "deleted_by", "added_time", 
            "updated_time", "deleted_time", "ts_time", "status", "deleted")
    VALUES 
    (1, 'main_navigation', 'Main Navigation', NULL, NULL, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    (1, 'shortcut', 'Shortcut', NULL, NULL, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE)
    ;
    
ALTER TABLE webthemesmenu RENAME COLUMN added_by TO _created_by;
ALTER TABLE webthemesmenu RENAME COLUMN added_time TO _created_at;
ALTER TABLE webthemesmenu RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE webthemesmenu RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE webthemesmenu ALTER COLUMN status TYPE smallint;

ALTER TABLE webthemesmenu ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE webthemesmenu SET is_deleted=1 WHERE deleted=TRUE;
UPDATE webthemesmenu SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE webthemesmenu DROP COLUMN IF EXISTS deleted;
ALTER TABLE webthemesmenu DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE webthemesmenu DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE webthemesmenu DROP COLUMN IF EXISTS ts_time;
