
-- Function: public.insert_variabel_test_to_drop_test_tabel()

-- DROP FUNCTION public.insert_variabel_test_to_drop_test_tabel();
CREATE OR REPLACE FUNCTION public.insert_variabel_test_to_drop_test_tabel()
  RETURNS trigger AS
$BODY$
declare
	_record record;
	_ebako_code character varying;
	_customer_code character varying;
	_item_description character varying;
	_client_code character varying;
	_client_name character varying;
	_vendor_name character varying;
	
begin
	if TG_OP = 'INSERT' then
		for _record in
			select * from variabel_test vt where vt.protocol_test_id=New.protocol_test_id  order by vt.var_type,vt.id
		loop
			
			insert into drop_test_list_detail(drop_test_list_id,evaluation,method,var_type,mandatory,created_by,created_at) 
			values(New.id,_record.evaluation,_record.method,_record.var_type,_record.mandatory,_record.created_by,now());
		end loop;
		select ebako_code, customer_code,description into  _ebako_code,_customer_code,_item_description from products where id=New.product_id;
		
		    UPDATE drop_test_list 
		    SET ebako_code=_ebako_code, 
			customer_code=_customer_code, 
			item_description=_item_description ,
			vendor_name=(select name from vendor where id=New.vendor_id),
			client_name=(select name from client where id=New.client_id)
		    WHERE id=New.id;
		
		
	elseif TG_OP = 'UPDATE' then
		select ebako_code, customer_code,description into  _ebako_code,_customer_code,_item_description from products where id=New.product_id;
		select name into  _client_name from client where id=New.client_id;
		select name into  _vendor_name from vendor where id=New.vendor_id;
		IF (New.ebako_code IS DISTINCT FROM _ebako_code OR
		    New.customer_code IS DISTINCT FROM _customer_code OR
		    New.item_description IS DISTINCT FROM _item_description OR
		    New.client_name IS DISTINCT FROM _client_name OR
		    New.vendor_name IS DISTINCT FROM _vendor_name) THEN

		    UPDATE drop_test_list 
		    SET ebako_code=_ebako_code, 
			customer_code=_customer_code, 
			item_description=_item_description ,
			vendor_name=(select name from vendor where id=New.vendor_id),
			client_name=(select name from client where id=New.client_id)
		    WHERE id=New.id;
		END IF;
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

-- Trigger: trg_insert_variabel_test on public.drop_test_list

-- DROP TRIGGER trg_insert_variabel_test ON public.drop_test_list;

CREATE TRIGGER trg_insert_variabel_test
  AFTER INSERT OR UPDATE OR DELETE
  ON public.drop_test_list
  FOR EACH ROW
  EXECUTE PROCEDURE public.insert_variabel_test_to_drop_test_tabel();
