<?php

/**
 * Model Sales
 *
 * @author Rizal.Gurning
 */
class Model_sales extends CI_Controller{
	public $table_name = "sales";

	function index(){}

	function generateNotaBon(){
		$dateTime = date('Y.m.d.His');
		return $dateTime;
	}

	function getCustomer($searchKey){
		$sql = "select c.id,c.barcode,c.name,c.address, c.discount, ct.name as customerType FROM customer c 
				join customer_type ct on ct.id = c.customer_type_id where c.barcode = ? limit 1 ";
		return $this -> db -> query($sql, array($searchKey)) -> row();
	}

	function getCustomers($searchKey){
		$sql = "select c.id,c.barcode,c.name,c.address, c.discount, ct.name as customerType FROM customer c 
				join customer_type ct on ct.id = c.customer_type_id where c.barcode ilike '%" . $searchKey . "%' or c.name ilike '%" . $searchKey . "%' limit 10 ";
		return $this -> db -> query($sql) -> result();
	}
	
	function getItem($searchKey){
		//$sql = "select id, barcode, name, retail_price as price, '0' as discount, '' as UOM  from item where barcode =? limit 1 ";
		$sql = "select i.id,i.taxed, i.barcode, i.name, i.retail_price as price,i.trading_price,i.cost, coalesce(u.code,'') as uom, coalesce(promotion.discount_type,'') as discount_type, 
				coalesce(promotion.value,'0') as discount 
				from item i
				left join (
					select item_id,value,discount_type from promotion p where
				    ((p.discount_type='PROMO_REGULER' and start_date <=current_date and end_date >= current_date) 
					     or (p.discount_type is null or end_date is null or end_date is null))
					order by p.discount_type asc limit 1
				) as promotion on promotion.item_id = i.id
				left join uom u on u.id = i.uom_id
			     where barcode =?  AND (status_sku='ACTIVE' OR status_sku='INACTIVE') order by promotion.discount_type asc limit 1 ";
		return $this -> db -> query($sql,array($searchKey)) -> result();
	}

	function getItems($searchKey){
		/*$sql = "select id, barcode, name, retail_price as price, '0' as discount, '' as uom  from item
                where sku ilike '%" . $searchKey . "%' or barcode ilike '%" . $searchKey . "%' or name ilike '%" . $searchKey . "%' limit 10 ";*/
		
		$sql = "select i.id,i.taxed, i.barcode, i.name, i.retail_price as price,i.trading_price,i.cost, coalesce(u.code,'') as uom, coalesce(promotion.discount_type,'') as discount_type,
				coalesce(promotion.value,'0') as discount
				from item i
				left join (
					select item_id,value,discount_type from promotion p where
				    ((p.discount_type='PROMO_REGULER' and start_date <=current_date and end_date >= current_date)
					     or (p.discount_type is null or end_date is null or end_date is null))
					order by p.discount_type asc limit 1
				) as promotion on promotion.item_id = i.id
				left join uom u on u.id = i.uom_id
				where (i.sku ilike '%" . $searchKey . "%' or i.barcode ilike '%" . $searchKey . "%' or i.name ilike '%" . $searchKey . "%') AND (status_sku='ACTIVE' OR status_sku='INACTIVE') limit 10 ";
		return $this -> db -> query($sql) -> result();
	}

	function unsetNullValueInArray($arrayKeyValue){
		foreach($arrayKeyValue as $key => $value){
			if($arrayKeyValue[$key] == ""){
				unset($arrayKeyValue[$key]);
			}
		}
		return $arrayKeyValue;
	}

	function getTotalQuantityItem($items){
		$total = 0;
		foreach($items as $item){
			$total += property_exists($item, "quantity") ? $item -> quantity : 0;
		}
		return $total;
	}
	
	function saveOrder($customer, $items, $payment){
		$this->load->model ( 'master/Model_store' );
		$store_id = $this->Model_store->get_store_id_by_code($this->config->item ('STORE_CODE'));
		
		$dataSales = array (
			"reference" => $this -> generateNotaBon(), 
			"cashier_id" => Authority::getUserId(), 
			"customer_id" => property_exists($customer, "id") ? $customer -> id : "", 
			
                        "total_price" => $payment -> totalPrice, 
			"total_cash" => property_exists($payment, "totalCash") ? $payment -> totalCash : 0, 
				
			"store_id" => ( $store_id == null || $store_id == "" ? "" : $store_id ),
				
			"amount_pay_cash" => property_exists($payment, "amountPayByCash") ? $payment -> amountPayByCash : 0, 
			"credit_card_number" => property_exists($payment, "creditCardNumber") ? $payment -> creditCardNumber : "", 
			
			"amount_pay_cash_credit_card" => property_exists($payment, "amountPayByCreditCard") ? $payment -> amountPayByCreditCard : 0, 
			
			"debit_card_number" => property_exists($payment, "debitCardNumber") ? $payment -> debitCardNumber : null, 
			
			"amount_pay_cash_debit_card" => property_exists($payment, "amountPayByDebitCard") ? $payment -> amountPayByDebitCard : 0, 
			
			"voucher_number" => property_exists($payment, "voucherNumber") ? $payment -> voucherNumber : null, 
			
			"amount_pay_cash_voucher" => property_exists($payment, "amountPayByVoucher") ? $payment -> amountPayByVoucher : 0, 
			
			"credit_card_type" => property_exists($payment, "creditCardType") ? $payment -> creditCardType : null, 
			"debit_card_type" => property_exists($payment, "debitCardType") ? $payment -> debitCardType : null, 
			"total_quantity" => $this->getTotalQuantityItem($items)
		);
		
		$dataSales = $this -> unsetNullValueInArray($dataSales);
		$this -> db -> trans_start();
		$this -> db -> insert('sales', $dataSales);
		$inserted_sales_id = $this -> last_sequence_id("sales");
		$dataSalesDetails = array ();
		
// 		print_r($items);
		$totalDiscount = 0;
		
		foreach($items as $item){
			$dataSalesDetail = array (
					"sales_id" => $inserted_sales_id,
					"item_id" => $item -> id,
					"quantity" =>  $item -> quantity,
					"price" =>  $item -> price,
					"discount" => $item -> discount,
					"initial_discount" =>  $item -> initialDiscount,
					"sub_total_price" =>  $item -> totalPrice
			);
			if ($item->discount!=$item->initialDiscount) {
				$update_by = $item -> discountUpdatedBy;
				if($update_by != ""){
					$dataSalesDetail["discount_update_by"] = $item -> discountUpdatedBy;
				}
			} 
			$totalDiscount += $item -> discount;
// 			print_r($dataSalesDetail);
			
			$this -> db -> insert('sales_item', $dataSalesDetail);
			array_push($dataSalesDetails, $dataSalesDetail);
		}
		$this -> db -> trans_complete();

		$dataSales['totalDiscount'] = $totalDiscount;
		date_default_timezone_set("Asia/Bangkok");
		$dataSales["sales_date"] = date('Y-m-d H:i:s');
		
		$order = array (
			"sales" => $dataSales, 
			"salesDetails" => $dataSalesDetails 
		);
		return $order;
	}
	
	function getReceivedData($salesId){
		//get sales
		$sql_sales = " SELECT s.id, 
						s.reference, 
						s.total_price, 
						s.total_cash, 
						s.amount_pay_cash, 
				        (coalesce(s.total_cash,0) - coalesce(s.amount_pay_cash,0)) as cash_retun,
						coalesce(s.credit_card_number,'') as credit_card_number, 
						coalesce(s.amount_pay_cash_credit_card,0) as amount_pay_cash_credit_card,
						coalesce(s.debit_card_number,'') as debit_card_number, 
						coalesce(s.amount_pay_cash_debit_card,0) as amount_pay_cash_debit_card, 
						coalesce(s.voucher_number,'') as voucher_number, coalesce(s.amount_pay_cash_voucher,0) as amount_pay_cash_voucher, 
						coalesce(s.credit_card_type,0) as credit_card_type, coalesce(s.debit_card_type,0) as debit_card_type, 
						coalesce(s.total_quantity,0) as total_quantity, 
						to_char(s.sales_date, 'dd-MM-yyyy HH:mm:ss') as sales_date, 
						u.first_name, 
						coalesce((select sum(si.discount) from sales_item si where si.sales_id = s.id),0) as total_discount
						FROM sales s
						join kds_user u on u.id = s.cashier_id
					where s.id = ? ";
		$param_sales = array($salesId);
		$dataSales = $this -> execute_query_as_result ($sql_sales, $param_sales);
		
		//get sales Detail
		$sql_sales_detail = " SELECT 
							si.id as sales_item_id, si.sales_id, i.name as item_name, si.quantity, si.discount, si.initial_discount, 
							si.sub_total_price, si.created_date, si.price
							FROM sales_item si
							join item i on i.id = si.item_id
							where sales_id = ? ";
		$param_sales_detail = array($salesId);
		$dataSalesDetails = $this -> execute_query_as_result($sql_sales_detail, $param_sales_detail);
		
		$sql_customer = "select c.id,c.barcode,c.name,c.address, c.discount, ct.name as customerType
							FROM customer c
							join sales s on s.customer_id = c.id
							join customer_type ct on ct.id = c.customer_type_id 
							where s.id =? limit 1 ";
		$customer_sql_param = array($salesId);
		$dataCustomer = $this -> execute_query_as_result($sql_customer, $customer_sql_param);
		
		$data = array(
			"sales" => $dataSales,
			"salesDetails" => $dataSalesDetails,
			"customer" => $dataCustomer
		);
		
		return $data;
	}
}

?>