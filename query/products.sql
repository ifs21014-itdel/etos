-- Table: products

-- DROP TABLE products;

CREATE TABLE products
(
  id serial NOT NULL,
  code character varying,
  name character varying,
  custom boolean,
  type_id integer,
  group_id integer,
  width float,
  height float,
  depth float,
  weight_gross float,
  weight_net float,
  price float,
  currency_id integer,
  validity_status character varying(20),
  description text,
  user_added character varying NOT NULL DEFAULT 'admin'::character varying,
  added_time time without time zone NOT NULL DEFAULT now(),
  user_updated character varying,
  updated_time timestamp without time zone,
  CONSTRAINT products_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE products
  OWNER TO postgres;
