update fabric set code=(select code from fabric as f2 where fabric.id=f2.id)


ALTER TABLE public.purchaseorder_item ADD COLUMN line character varying;
ALTER TABLE public.shipment ADD COLUMN loadibility character varying;
ALTER TABLE public.products ADD COLUMN client_id integer;


ALTER TABLE public.purchaseorder ADD COLUMN po_client_no character varying;
ALTER TABLE public.purchaseorder ADD COLUMN ship_to text;
ALTER TABLE public.shipment ADD COLUMN tally_user character varying;

-- Alter SQL pada hot hot_cold_test_list
ALTER TABLE public.hot_cold_test_list
ADD COLUMN corrective_action_plan_image character varying,
ADD COLUMN condition_a_temp double precision,
ADD COLUMN condition_a_duration integer,
ADD COLUMN room_temp_rest_a_duration integer,
ADD COLUMN condition_b_temp double precision,
ADD COLUMN condition_b_duration integer,
ADD COLUMN room_temp_rest_b_duration integer,
ADD COLUMN cycles integer;

--alter table pada drop test list
ALTER TABLE public.drop_test_list
ADD COLUMN corrective_action_plan_image character varying;

--alter table pada hardness test list
ALTER TABLE public.hardness_test_list
ADD COLUMN corrective_action_plan_image character varying;

--alter table pada product test list
ALTER TABLE public.product_test_list
ADD COLUMN corrective_action_plan_image character varying;

--alter table pada print mark test list
ALTER TABLE public.print_mark_test_list
ADD COLUMN corrective_action_plan_image character varying;

--Daftar Protocol Hardness Test
INSERT INTO public.variabel_test (protocol_test_id, evaluation, method, description, client_id, created_by, created_at, updated_by, updated_at, mandatory, var_type)
VALUES
  (18, 'B', 'B', 'B', NULL, NULL, now(), NULL, NULL, true, 'Photo'),
  (18, 'HB', 'HB', 'HB', NULL, NULL, now(), NULL, NULL, true, 'Photo'),
  (18, 'H', 'H', 'H', NULL, NULL, now(), NULL, NULL, true, 'Photo'),
  (18, '2H', '2H', '2H', NULL, NULL, now(), NULL, NULL, true, 'Photo'),
  (18, '3H', '3H', '3H', NULL, NULL, now(), NULL, NULL, true, 'Photo');

--Daftar Test Protocol ,Print Mark Test
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
