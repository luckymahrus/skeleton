/**************************************** DROP TABLE IF EXISTS ****************************************/

DROP TABLE IF EXISTS uploads;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE uploads (
    "uploads_id" serial PRIMARY KEY NOT NULL,
    "uploads_name" character varying(255),
    "uploads_file_name" character varying(255),
    "uploads_raw_name" character varying(255),
    "uploads_orig_name" character varying(255),
    "uploads_client_name" character varying(255),
    "uploads_file_path" TEXT,
    "uploads_full_path" TEXT,
    "uploads_file_type" character varying(255),
    "uploads_image_type" character varying(10),
    "uploads_file_ext" character varying(255),
    "uploads_image_width" integer,
    "uploads_image_height" integer,
    "uploads_image_size_str" character varying(50),
    "uploads_file_size" decimal (6,2),
    "uploads_is_image" boolean,
    "uploads_description" character varying(255),
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

ALTER TABLE public.uploads OWNER TO postgres;

ALTER TABLE uploads RENAME COLUMN added_by TO _created_by;
ALTER TABLE uploads RENAME COLUMN added_time TO _created_at;
ALTER TABLE uploads RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE uploads RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE uploads ALTER COLUMN status TYPE smallint;

ALTER TABLE uploads ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE uploads SET is_deleted=1 WHERE deleted=TRUE;
UPDATE uploads SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE uploads DROP COLUMN IF EXISTS deleted;
ALTER TABLE uploads DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE uploads DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE uploads DROP COLUMN IF EXISTS ts_time;

ALTER TABLE uploads ALTER uploads_is_image SET DEFAULT NULL;
ALTER TABLE uploads ADD COLUMN uploads_is_image1 smallint NOT NULL DEFAULT 0;
UPDATE uploads SET uploads_is_image1=1 WHERE uploads_is_image=TRUE;
UPDATE uploads SET uploads_is_image1=0 WHERE uploads_is_image=FALSE;
UPDATE uploads SET uploads_is_image=NULL;
ALTER TABLE uploads ALTER uploads_is_image TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE uploads SET uploads_is_image=1 WHERE uploads_is_image1=1;
UPDATE uploads SET uploads_is_image=0 WHERE uploads_is_image1=0;
ALTER TABLE uploads ALTER uploads_is_image SET DEFAULT 0;
ALTER TABLE uploads DROP COLUMN uploads_is_image1;


