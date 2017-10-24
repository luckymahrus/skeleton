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

