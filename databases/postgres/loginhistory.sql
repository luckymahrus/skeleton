/**************************************** DROP TABLE ****************************************/

DROP TABLE loginhistory;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE loginhistory (
    "loginhistory_id" serial PRIMARY KEY NOT NULL,
    "sessions_id" character varying(128) NOT NULL,
    "users_id" integer NULL DEFAULT NULL,
    "ip_address" VARCHAR(15) NOT NULL,
    "useragent" text NULL,
    "platform" character varying(255) NULL DEFAULT NULL,
    "browser" character varying(255) NULL DEFAULT NULL,
    "remember_login" boolean,
    "time_login" integer NULL DEFAULT NULL,
    "time_logout" integer NULL DEFAULT NULL,
    "added_by" integer,
    "updated_by" integer,
    "deleted_by" integer,
    "added_time" integer,
    "updated_time" integer,
    "deleted_time" integer,
    "ts_time" timestamp without time zone DEFAULT now(),
    "status" integer DEFAULT 1,
    "deleted" boolean DEFAULT FALSE,
    unique ("sessions_id")
);


/**************************************** ALTER TABLE ****************************************/

ALTER TABLE public.loginhistory OWNER TO postgres;

ALTER TABLE loginhistory RENAME COLUMN added_by TO _created_by;
ALTER TABLE loginhistory RENAME COLUMN added_time TO _created_at;
ALTER TABLE loginhistory RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE loginhistory RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE loginhistory ALTER COLUMN status TYPE smallint;

ALTER TABLE loginhistory ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE loginhistory SET is_deleted=1 WHERE deleted=TRUE;
UPDATE loginhistory SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE loginhistory DROP COLUMN IF EXISTS deleted;
ALTER TABLE loginhistory DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE loginhistory DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE loginhistory DROP COLUMN IF EXISTS ts_time;

ALTER TABLE loginhistory ALTER remember_login SET DEFAULT NULL;
ALTER TABLE loginhistory ADD COLUMN remember_login1 smallint NOT NULL DEFAULT 0;
UPDATE loginhistory SET remember_login1=1 WHERE remember_login=TRUE;
UPDATE loginhistory SET remember_login1=0 WHERE remember_login=FALSE;
UPDATE loginhistory SET remember_login=NULL;
ALTER TABLE loginhistory ALTER remember_login TYPE smallint USING CASE WHEN TRUE THEN 1 ELSE 0 END;
UPDATE loginhistory SET remember_login=1 WHERE remember_login1=1;
UPDATE loginhistory SET remember_login=0 WHERE remember_login1=0;
ALTER TABLE loginhistory ALTER remember_login SET DEFAULT 0;
ALTER TABLE loginhistory DROP COLUMN remember_login1;


