/**************************************** DROP TABLE IF EXISTS ****************************************/

DROP TABLE IF EXISTS IF EXISTS usersgroups;
DROP TABLE IF EXISTS IF EXISTS users_groups;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE users_groups (
    "users_groups_id" serial PRIMARY KEY NOT NULL,
    "users_id" integer,
    "groups_id" integer,
    "added_by" integer,
    "updated_by" integer,
    "deleted_by" integer,
    "added_time" integer,
    "updated_time" integer,
    "deleted_time" integer,
    "ts_time" timestamp without time zone DEFAULT now(),
    "status" integer DEFAULT 1,
    "deleted" boolean DEFAULT FALSE,
    unique ("users_id","groups_id")
);


/**************************************** ALTER TABLE ****************************************/

ALTER TABLE public.users_groups OWNER TO postgres;


/**************************************** INSERT INTO ****************************************/

INSERT INTO users_groups ("users_id", "groups_id", "added_by", "updated_by", "deleted_by", "added_time", "updated_time", "deleted_time", "ts_time", status, deleted)
    VALUES
    (1, 1, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE)
    ;
    
ALTER TABLE users_groups RENAME COLUMN added_by TO _created_by;
ALTER TABLE users_groups RENAME COLUMN added_time TO _created_at;
ALTER TABLE users_groups RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE users_groups RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE users_groups ALTER COLUMN status TYPE smallint;

ALTER TABLE users_groups ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE users_groups SET is_deleted=1 WHERE deleted=TRUE;
UPDATE users_groups SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE users_groups DROP COLUMN IF EXISTS deleted;
ALTER TABLE users_groups DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE users_groups DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE users_groups DROP COLUMN IF EXISTS ts_time;
