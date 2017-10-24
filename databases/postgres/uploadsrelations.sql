/**************************************** DROP TABLE IF EXISTS ****************************************/

DROP TABLE IF EXISTS uploadsrelations;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE uploadsrelations (
    "uploadsrelations_id" serial PRIMARY KEY NOT NULL,
    "uploads_id" integer,
    "relation_table" character varying(255),
    "relation_id" integer,
    "added_by" integer,
    "updated_by" integer,
    "deleted_by" integer,
    "added_time" integer,
    "updated_time" integer,
    "deleted_time" integer,
    "ts_time" timestamp without time zone DEFAULT now(),
    "status" integer DEFAULT 1,
    "deleted" boolean DEFAULT FALSE,
    unique ("uploads_id","relation_table","relation_id")
);

/**************************************** ALTER TABLE ****************************************/

ALTER TABLE public.uploadsrelations OWNER TO postgres;

ALTER TABLE uploadsrelations RENAME COLUMN added_by TO _created_by;
ALTER TABLE uploadsrelations RENAME COLUMN added_time TO _created_at;
ALTER TABLE uploadsrelations RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE uploadsrelations RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE uploadsrelations ALTER COLUMN status TYPE smallint;

ALTER TABLE uploadsrelations ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE uploadsrelations SET is_deleted=1 WHERE deleted=TRUE;
UPDATE uploadsrelations SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE uploadsrelations DROP COLUMN IF EXISTS deleted;
ALTER TABLE uploadsrelations DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE uploadsrelations DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE uploadsrelations DROP COLUMN IF EXISTS ts_time;
