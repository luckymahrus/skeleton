/**************************************** DROP TABLE ****************************************/

DROP TABLE emails;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE emails (
    "emails_id" serial PRIMARY KEY NOT NULL,
    "emails_sender_name" character varying(255) NULL DEFAULT NULL,
    "emails_sender_addess" character varying(255),
    "emails_to_name" character varying(255) NULL DEFAULT NULL,
    "emails_to_addess" character varying(255),
    "emails_send_datetime" integer,
    "emails_subject" character varying(255) NULL DEFAULT NULL,
    "emails_message" TEXT NULL,
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

ALTER TABLE public.emails OWNER TO postgres;


ALTER TABLE emails RENAME COLUMN added_by TO _created_by;
ALTER TABLE emails RENAME COLUMN added_time TO _created_at;
ALTER TABLE emails RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE emails RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE emails ALTER COLUMN status TYPE smallint;

ALTER TABLE emails ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE emails SET is_deleted=1 WHERE deleted=TRUE;
UPDATE emails SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE emails DROP COLUMN IF EXISTS deleted;
ALTER TABLE emails DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE emails DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE emails DROP COLUMN IF EXISTS ts_time;
