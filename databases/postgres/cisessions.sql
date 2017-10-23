/**************************************** DROP TABLE ****************************************/

DROP TABLE cisessions;


/**************************************** CREATE TABLE ****************************************/

CREATE TABLE "cisessions" (
        "id" varchar(128) NOT NULL,
        "ip_address" varchar(45) NOT NULL,
        "timestamp" bigint DEFAULT 0 NOT NULL,
        "data" text DEFAULT '' NOT NULL
);

CREATE INDEX "cisessions_timestamp" ON "cisessions" ("timestamp");

ALTER TABLE public.cisessions OWNER TO postgres;
