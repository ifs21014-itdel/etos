
ALTER TABLE public.menu ADD COLUMN apps_type character varying;
ALTER TABLE public.menugroup ADD COLUMN apps_type character varying;
-- Table: public.protocol_test

-- DROP TABLE public.protocol_test;

CREATE TABLE public.protocol_test
(
  id serial,
  test_name character varying,
  protocol_name character varying,
  description text,
  client_id integer,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  CONSTRAINT protocol_test_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.protocol_test
  OWNER TO postgres;

CREATE TABLE public.drop_test_list_detail
(
  id serial,
  drop_test_list_id integer,
  evaluation text,
  method text,
  var_type character varying,
  mandatory boolean DEFAULT false,
  notes text,
  image_file character varying,
  image2_file character varying,
  result_test_var character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  CONSTRAINT drop_test_list_detail_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.drop_test_list_detail
  OWNER TO postgres;

-- select variabel_test_copy(1,4); query untuk copy variabel test
--delete from variabel_test where protocol_test_id=19;
-- select variabel_test_copy(20,19);

-- Table: public.drop_test_list

-- DROP TABLE public.drop_test_list;

CREATE TABLE public.drop_test_list
(
  id serial,
  purchaseorder_item_id integer,
  protocol_test_id integer,
  po_client_no character varying,
  vendor_id integer,
  test_date date,
  carton_dimension character varying,
  gross_weight double precision,
  rating character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  brand character varying,
  report_date date,
  product_dimension character varying,
  notes text,
  client_id integer,
  client_name character varying,
  ebako_code character varying,
  customer_code character varying,
  vendor_name character varying,
  report_no character varying,
  submited boolean DEFAULT false,
  product_id integer,
  nett_weight double precision,
  product_image character varying,
  CONSTRAINT drop_test_list_pkey PRIMARY KEY (id),
  CONSTRAINT drop_test_list_purchaseorder_id_fkey FOREIGN KEY (purchaseorder_item_id)
      REFERENCES public.purchaseorder_item (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.drop_test_list
  OWNER TO postgres;
-- Table: public.drop_test_list_detail

-- DROP TABLE public.drop_test_list_detail;

CREATE TABLE public.drop_test_list_detail
(
  id serial,
  drop_test_list_id integer,
  variabel_test_id integer,
  description text,
  image_file character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  CONSTRAINT drop_test_list_detail_pkey PRIMARY KEY (id),
  CONSTRAINT drop_test_list_detail_purchaseorder_id_fkey FOREIGN KEY (drop_test_list_id)
      REFERENCES public.drop_test_list (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.drop_test_list_detail
  OWNER TO postgres;



CREATE OR REPLACE FUNCTION public.variabel_test_copy(
    _protocol_test_source_id bigint,
    _protocol_test_dest_id bigint)
  RETURNS void AS
$BODY$
declare
	_record record;
begin

	for _record in 
		select * from variabel_test where protocol_test_id=_protocol_test_source_id
	loop
		insert into variabel_test(protocol_test_id,evaluation,method,description,client_id,created_by,created_at,updated_by,updated_at,mandatory)
		values (_protocol_test_dest_id,_record.evaluation,_record.method,_record.description,_record.client_id,_record.created_by,now(),_record.updated_by,now(),_record.mandatory);
	end loop;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.variabel_test_copy(bigint, bigint)
  OWNER TO postgres;


-- Function: public.insert_variabel_test_to_drop_test_tabel()

-- DROP FUNCTION public.insert_variabel_test_to_drop_test_tabel();

CREATE OR REPLACE FUNCTION public.insert_variabel_test_to_drop_test_tabel()
  RETURNS trigger AS
$BODY$
declare
	_record record;
	
begin
	if TG_OP = 'INSERT' then
		for _record in
			select * from variabel_test vt where vt.protocol_test_id=New.protocol_test_id  order by vt.var_type,vt.id
		loop
			
			insert into drop_test_list_detail(drop_test_list_id,evaluation,method,var_type,mandatory,user_added,added_time) 
			values(New.id,_record.evaluation,_record.method,_record.var_type,_record.mandatory,_record.user_added,now());
		end loop;
		
	elseif TG_OP = 'DELETE' then
		delete from variabel_test where protocol_test_id=Old.id;
	end if;
	return null;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.insert_variabel_test_to_drop_test_tabel()
  OWNER TO postgres;


--=======================
-- Table: public.product_test_list

-- product TABLE public.product_test_list;

CREATE TABLE public.product_test_list
(
  id serial,
  purchaseorder_item_id integer,
  protocol_test_id integer,
  po_client_no character varying,
  vendor_id integer,
  test_date date,
  carton_dimension character varying,
  gross_weight double precision,
  rating character varying,
  brand character varying,
  report_date date,
  product_dimension character varying,
  notes text,
  client_id integer,
  client_name character varying,
  ebako_code character varying,
  customer_code character varying,
  vendor_name character varying,
  report_no character varying,
  submited boolean,
  product_id integer,
  nett_weight double precision,
  product_image character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  CONSTRAINT product_test_list_pkey PRIMARY KEY (id),
  CONSTRAINT product_test_list_purchaseorder_item_id_fkey FOREIGN KEY (purchaseorder_item_id)
      REFERENCES public.purchaseorder_item (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.product_test_list
  OWNER TO postgres;

-- Table: public.product_test_list_detail

-- product TABLE public.product_test_list_detail;

CREATE TABLE public.product_test_list_detail
(
  id serial,
  product_test_list_id integer,
  evaluation text,
  method text,
  var_type character varying,
  mandatory boolean DEFAULT false,
  notes text,
  image_file character varying,
  image2_file character varying,
  image3_file character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  result_test_var character varying,
  CONSTRAINT product_test_list_detail_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.product_test_list_detail
  OWNER TO postgres;


--=======================
-- Table: public.hot_cold_test_list

-- product TABLE public.hot_cold_test_list;

CREATE TABLE public.hot_cold_test_list
(
  id serial,
  purchaseorder_item_id integer,
  protocol_test_id integer,
  po_client_no character varying,
  vendor_id integer,
  test_date date,
  carton_dimension character varying,
  gross_weight double precision,
  rating character varying,
  brand character varying,
  report_date date,
  product_dimension character varying,
  notes text,
  client_id integer,
  client_name character varying,
  ebako_code character varying,
  customer_code character varying,
  vendor_name character varying,
  report_no character varying,
  submited boolean,
  product_id integer,
  nett_weight double precision,
  product_image character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  CONSTRAINT hot_cold_test_list_pkey PRIMARY KEY (id),
  CONSTRAINT hot_cold_test_list_purchaseorder_item_id_fkey FOREIGN KEY (purchaseorder_item_id)
      REFERENCES public.purchaseorder_item (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.hot_cold_test_list
  OWNER TO postgres;


-- Table: public.hot_cold_test_list_detail

-- product TABLE public.hot_cold_test_list_detail;

CREATE TABLE public.hot_cold_test_list_detail
(
  id serial,
  hot_cold_test_list_id integer,
  evaluation text,
  method text,
  var_type character varying,
  mandatory boolean DEFAULT false,
  notes text,
  image_file character varying,
  image2_file character varying,
  image3_file character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  result_test_var character varying,
  CONSTRAINT hot_cold_test_list_detail_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.hot_cold_test_list_detail
  OWNER TO postgres;


--=======================
-- Table: public.print_mark_test_list

-- product TABLE public.print_mark_test_list;

CREATE TABLE public.print_mark_test_list
(
  id serial,
  purchaseorder_item_id integer,
  protocol_test_id integer,
  po_client_no character varying,
  vendor_id integer,
  test_date date,
  carton_dimension character varying,
  gross_weight double precision,
  rating character varying,
  brand character varying,
  report_date date,
  product_dimension character varying,
  notes text,
  client_id integer,
  client_name character varying,
  ebako_code character varying,
  customer_code character varying,
  vendor_name character varying,
  report_no character varying,
  submited boolean,
  product_id integer,
  nett_weight double precision,
  product_image character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  CONSTRAINT print_mark_test_list_pkey PRIMARY KEY (id),
  CONSTRAINT print_mark_test_list_purchaseorder_item_id_fkey FOREIGN KEY (purchaseorder_item_id)
      REFERENCES public.purchaseorder_item (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.print_mark_test_list
  OWNER TO postgres;


-- Table: public.print_mark_test_list_detail

-- product TABLE public.print_mark_test_list_detail;

CREATE TABLE public.print_mark_test_list_detail
(
  id serial,
  print_mark_test_list_id integer,
  evaluation text,
  method text,
  var_type character varying,
  mandatory boolean DEFAULT false,
  notes text,
  image_file character varying,
  image2_file character varying,
  image3_file character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  result_test_var character varying,
  CONSTRAINT print_mark_test_list_detail_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.print_mark_test_list_detail
  OWNER TO postgres;


--=======================
-- Table: public.hardness_test_list

-- product TABLE public.hardness_test_list;

CREATE TABLE public.hardness_test_list
(
  id serial,
  purchaseorder_item_id integer,
  protocol_test_id integer,
  po_client_no character varying,
  vendor_id integer,
  test_date date,
  carton_dimension character varying,
  gross_weight double precision,
  rating character varying,
  brand character varying,
  report_date date,
  product_dimension character varying,
  notes text,
  client_id integer,
  client_name character varying,
  ebako_code character varying,
  customer_code character varying,
  vendor_name character varying,
  report_no character varying,
  submited boolean,
  product_id integer,
  nett_weight double precision,
  product_image character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  CONSTRAINT hardness_test_list_pkey PRIMARY KEY (id),
  CONSTRAINT hardness_test_list_purchaseorder_item_id_fkey FOREIGN KEY (purchaseorder_item_id)
      REFERENCES public.purchaseorder_item (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.hardness_test_list
  OWNER TO postgres;


-- Table: public.hardness_test_list_detail

-- product TABLE public.hardness_test_list_detail;

CREATE TABLE public.hardness_test_list_detail
(
  id serial,
  hardness_test_list_id integer,
  evaluation text,
  method text,
  var_type character varying,
  mandatory boolean DEFAULT false,
  notes text,
  image_file character varying,
  image2_file character varying,
  image3_file character varying,
  created_by bigint,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  updated_by bigint,
  updated_at timestamp without time zone,
  result_test_var character varying,
  CONSTRAINT hardness_test_list_detail_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.hardness_test_list_detail
  OWNER TO postgres;



--script add variable test pada print mark test
INSERT INTO public.variabel_test (protocol_test_id, evaluation, method, description, client_id, created_by, created_at, updated_by, updated_at, mandatory, var_type)
VALUES
  (17, 
   'Place a soft cloth over the surface of the sample then place foam sheet on it. Apply a load of 1.8 kg, 1.1 kg, and 4.56 kg on the surface over the test sample with 4 pressure area 1 inch square in overnight. Use a room temperature of 35°C.',
   'Place a soft cloth over the surface of the sample than place foam sheet on it. Apply a load of 1.8 kg, 1.1 kg, and 4.56 kg on the surface over the test sample with 4 pressure area 1 inch square in overnight. Use a room temperature of 35°C. ', 
   'Place a soft cloth over the surface of the sample then place foam sheet on it. Apply a load of 1.8 kg, 1.1 kg, and 4.56 kg on the surface over the test sample with 4 pressure area 1 inch square in overnight. Use a room temperature of 35°C.',
   NULL, 
   NULL, 
   now(), 
   NULL, 
   NULL, 
   true, 
   'Photo'),
  
  (17, 
   'Place a soft cloth over the surface of the sample then place foam sheet on it. Apply a load of 2.4 kg on the surface over the test sample with 4 pressure area 1 inch square in overnight. Use a room temperature of 35°C.',
   'Place a soft cloth over the surface of the sample than place foam sheet on it. Apply a load of 2.4 kg on the surface over the test sample with 4 pressure area 1 inch square in overnight. Use a room temperature of 35°C. ', 
   'Place a soft cloth over the surface of the sample then place foam sheet on it. Apply a load of 2.4 kg on the surface over the test sample with 4 pressure area 1 inch square in overnight. Use a room temperature of 35°C.',
   NULL, 
   NULL, 
   now(), 
   NULL, 
   NULL, 
   true, 
   'Photo');


