/**************************************** DROP TABLE IF EXISTS ****************************************/

DROP TABLE IF EXISTS loginattempts;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE loginattempts (
    "loginattempts_id" serial PRIMARY KEY NOT NULL,
    "ip_address" VARCHAR(15) NOT NULL,
    "login" character varying(255) NULL DEFAULT NULL,
    "time" integer NULL DEFAULT NULL,
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

ALTER TABLE public.loginattempts OWNER TO postgres;

ALTER TABLE loginattempts RENAME COLUMN added_by TO _created_by;
ALTER TABLE loginattempts RENAME COLUMN added_time TO _created_at;
ALTER TABLE loginattempts RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE loginattempts RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE loginattempts ALTER COLUMN status TYPE smallint;

ALTER TABLE loginattempts ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE loginattempts SET is_deleted=1 WHERE deleted=TRUE;
UPDATE loginattempts SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE loginattempts DROP COLUMN IF EXISTS deleted;
ALTER TABLE loginattempts DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE loginattempts DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE loginattempts DROP COLUMN IF EXISTS ts_time;
