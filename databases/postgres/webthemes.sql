/**************************************** DROP TABLE ****************************************/

DROP TABLE webthemes;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE webthemes (
    "webthemes_id" serial PRIMARY KEY NOT NULL,
    "webthemes_name" character varying(255),
    "webthemes_title" text,
    "webthemes_description" text,
    "webthemes_config" text,
    "added_by" integer,
    "updated_by" integer,
    "deleted_by" integer,
    "added_time" integer,
    "updated_time" integer,
    "deleted_time" integer,
    "ts_time" timestamp without time zone DEFAULT now(),
    "status" integer DEFAULT 1,
    "deleted" boolean DEFAULT FALSE,
    unique ("webthemes_name")
);


/**************************************** ALTER TABLE ****************************************/

ALTER TABLE public.webthemes OWNER TO postgres;


/**************************************** INSERT INTO ****************************************/

INSERT INTO webthemes(
            "webthemes_name", "webthemes_title", "webthemes_description", 
            "webthemes_config", "added_by", "updated_by", "deleted_by", "added_time", 
            "updated_time", "deleted_time", "ts_time", "status", "deleted")
    VALUES
    ('smartadmin', 'SmartAdmin', NULL, NULL, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE);
    
ALTER TABLE webthemes RENAME COLUMN added_by TO _created_by;
ALTER TABLE webthemes RENAME COLUMN added_time TO _created_at;
ALTER TABLE webthemes RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE webthemes RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE webthemes ALTER COLUMN status TYPE smallint;

ALTER TABLE webthemes ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE webthemes SET is_deleted=1 WHERE deleted=TRUE;
UPDATE webthemes SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE webthemes DROP COLUMN IF EXISTS deleted;
ALTER TABLE webthemes DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE webthemes DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE webthemes DROP COLUMN IF EXISTS ts_time;
