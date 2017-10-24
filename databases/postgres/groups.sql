/**************************************** DROP TABLE IF EXISTS ****************************************/

DROP TABLE IF EXISTS groups;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE groups (
    "groups_id" serial PRIMARY KEY NOT NULL,
    "groups_name" character varying(20),
    "groups_description" character varying(100),
    "groups_level" integer,
    "groups_internal" integer,
    "added_by" integer,
    "updated_by" integer,
    "deleted_by" integer,
    "added_time" integer,
    "updated_time" integer,
    "deleted_time" integer,
    "ts_time" timestamp without time zone DEFAULT now(),
    "status" integer DEFAULT 1,
    "deleted" boolean DEFAULT FALSE,
    unique ("groups_name")
);


/**************************************** ALTER TABLE ****************************************/

ALTER TABLE public.groups OWNER TO postgres;


/**************************************** INSERT INTO ****************************************/
   
INSERT INTO groups ("groups_name", "groups_description", "groups_level", "groups_internal", "added_by", "updated_by", "deleted_by", "added_time", "updated_time", "deleted_time", "ts_time", status, deleted)
    VALUES
    ('superadmin', 'Super Administrator', 10, 1, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE),
    ('admin', 'Administrator', 9, 1, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE);

ALTER TABLE groups RENAME COLUMN added_by TO _created_by;
ALTER TABLE groups RENAME COLUMN added_time TO _created_at;
ALTER TABLE groups RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE groups RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE groups ALTER COLUMN status TYPE smallint;

ALTER TABLE groups ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE groups SET is_deleted=1 WHERE deleted=TRUE;
UPDATE groups SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE groups DROP COLUMN IF EXISTS deleted;
ALTER TABLE groups DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE groups DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE groups DROP COLUMN IF EXISTS ts_time;
