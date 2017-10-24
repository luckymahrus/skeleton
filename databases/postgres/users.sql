/**************************************** DROP TABLE IF EXISTS ****************************************/

DROP TABLE IF EXISTS users;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE users (
    "users_id" serial PRIMARY KEY NOT NULL,
    "users_ip_address" character varying(15),
    "users_username" character varying(100),
    "users_password" character varying(255),
    "users_password_ori" character varying(255),
    "users_otp" character varying(255),
    "users_otp_login_code" character varying(40),
    "users_otp_backup_codes" text,
    "users_salt" character varying(255),
    "users_email" character varying(255),
    "users_activation_code" character varying(40),
    "forgotten_password_code" character varying(40),
    "forgotten_password_time" integer,
    "remember_code" character varying(40),
    "users_last_login" integer,
    "users_first_name" character varying(100),
    "users_last_name" character varying(100),
    "users_avatar" character varying(100),
    "added_by" integer,
    "updated_by" integer,
    "deleted_by" integer,
    "added_time" integer,
    "updated_time" integer,
    "deleted_time" integer,
    "ts_time" timestamp without time zone DEFAULT now(),
    "status" integer DEFAULT 1,
    "deleted" boolean DEFAULT FALSE,
    unique ("users_username"),
    unique ("users_salt"),
    unique ("users_email"),
    unique ("users_activation_code"),
    unique ("forgotten_password_code"),
    unique ("remember_code")    
);


/**************************************** ALTER TABLE ****************************************/

ALTER TABLE public.users OWNER TO postgres;


/**************************************** INSERT INTO ****************************************/

INSERT INTO users ("users_ip_address", "users_username", "users_password", "users_password_ori", "users_otp", "users_otp_login_code", "users_otp_backup_codes", "users_salt", "users_email", "users_activation_code", "forgotten_password_code", "forgotten_password_time", "remember_code", "users_last_login", "users_first_name", "users_last_name", "users_avatar", "added_by", "updated_by", "deleted_by", "added_time", "updated_time", "deleted_time", "ts_time", status, deleted)
    VALUES
    ('127.0.0.1', 'superadmin', '$2y$08$M0cQHtwa1r9Y4KBGFnuEKunk8WTKVC2WAhdrVs3S6XQXL7le7QiyS', NULL, NULL, NULL, NULL, 'OrI/QmHT23w7V8e/qgwHJe', 'superadmin@admin.com', NULL, NULL, NULL, NULL, int4(abstime(now())), 'Super', 'Admin', NULL, 0, NULL, NULL, int4(abstime(now())), NULL, NULL, now(), 1, FALSE)
    ;
    
ALTER TABLE users RENAME COLUMN added_by TO _created_by;
ALTER TABLE users RENAME COLUMN added_time TO _created_at;
ALTER TABLE users RENAME COLUMN updated_time TO _updated_at;
ALTER TABLE users RENAME COLUMN updated_by TO _updated_by;
ALTER TABLE users ALTER COLUMN status TYPE smallint;

ALTER TABLE users ADD COLUMN is_deleted smallint NOT NULL DEFAULT 0;
UPDATE users SET is_deleted=1 WHERE deleted=TRUE;
UPDATE users SET is_deleted=0 WHERE deleted=FALSE;

ALTER TABLE users DROP COLUMN IF EXISTS deleted;
ALTER TABLE users DROP COLUMN IF EXISTS deleted_by;
ALTER TABLE users DROP COLUMN IF EXISTS deleted_time;
ALTER TABLE users DROP COLUMN IF EXISTS ts_time;
