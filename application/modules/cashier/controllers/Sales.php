<?php

/**
 * @author Rizal.Gurning
 */
class Sales extends CI_Controller{

	public $languange_source = "cashier";
	
	public function __construct(){
		parent::__construct();
	}

	function Index(){
//		Authority::validateUserAuthorization(Permission::CASHIER_VIEW_CART);
		$this -> load -> view('cashier/sales/index');
	}

	function index2(){
		$this -> load -> view('cashier/sales/order2');
	}

	function printReceive(){
		$this -> load -> model("system/Model_settings");
		$COMPANY_NAME = $this->Model_settings->get_setting_value('COMPANY_NAME');
		$COMPANY_ADDRESS = $this->Model_settings->get_setting_value('COMPANY_ADDRESS');
		$COMPANY_TELEPHONE = $this->Model_settings->get_setting_value('COMPANY_TELEPHONE');
		$STORE_NPWP = $this->Model_settings->get_setting_value('STORE_NPWP');
		$settings = array(
			"COMPANY_NAME" => $COMPANY_NAME,
			"COMPANY_ADDRESS" => $COMPANY_ADDRESS,
			"COMPANY_TELEPHONE" => $COMPANY_TELEPHONE,
			"STORE_NPWP" => $STORE_NPWP	
		);
		$data['settings'] = $settings;
		$this -> load -> view('cashier/sales/printReceive',$data);
	}
	
	function printData(){
		$this -> load -> model("system/Model_settings");
		$data['settings'] = $this -> Model_settings -> getSettings();
		print_r($data);
	}
	
	function time(){
		print date('Y.m.d.His');
	}

	function list_order(){
		$this -> load -> view('cashier/order/list');
	}
	
	function getCustomer(){
		$searchCustomerKey = $this->input->post("searchCustomerKey");
		$searchCustomerKey == null ? "" : $searchCustomerKey;
		$this -> load -> model("cashier/model_sales");
		$data = $this -> model_sales -> getCustomer($searchCustomerKey);
		echo json_encode($data);
	}
	
	function getCustomers(){
		$searchCustomerKey = $this->input->post("searchCustomerKey");
		$searchCustomerKey == null ? "" : $searchCustomerKey;
		$this -> load -> model("cashier/Model_sales");
		$data = $this -> Model_sales -> getCustomers($searchCustomerKey);
		echo json_encode($data);
	}
	
	function getItem(){
		$searchKey = $this->input->post("searchKey");
		$searchKey == null ? "" : $searchKey;
		$this -> load -> model("cashier/model_sales");
		$data = $this -> model_sales -> getItem($searchKey);
		echo json_encode($data);
	}
	
	function getItems(){
		$searchKey = $this->input->post("searchKey");
		$searchKey == null ? "" : $searchKey;
		$this -> load -> model("cashier/model_sales");
		$data = $this -> model_sales -> getItems($searchKey);
		echo json_encode($data);
	}

	function saveOrder(){
		$order = json_decode($_POST["order"]);
		$customer = $order -> customer;
		$items = $order -> items;
		$payment = $order -> payment;
		$this -> load -> model("cashier/Model_sales");
		$data = "";
		$orderData = $this -> Model_sales ->saveOrder($customer, $items, $payment);
		if($orderData != null && $orderData != false){
			$data = array(
					"success" => true,
					"data" => $orderData
			);
		} else {
			$data = array(
					"success" => false
			);
		}
		echo json_encode($data);
	}
	
	function checkUserPermissionToUpdateDiscount(){
		$isAuthorzedToChangeDiscount = false;
		$message = array();
		$user_data = $this -> session -> userdata( Permission::CASHIER_UPDATE_DISCOUNT );
		if( !empty( $user_data ) ){
			$isAuthorzedToChangeDiscount = true;
		} else {
			$isAuthorzedToChangeDiscount = Authority::hasPermission(Permission::CASHIER_UPDATE_DISCOUNT);
		}
		if($isAuthorzedToChangeDiscount){
			$message = array ('success' => true );
		}else{
			$message = array ('success' => false );
		}
		echo json_encode($message);
	}
	
	function rePrintReceived(){
		$this -> load -> model("system/Model_settings");
		$COMPANY_NAME = $this->Model_settings->get_setting_value('COMPANY_NAME');
		$COMPANY_ADDRESS = $this->Model_settings->get_setting_value('COMPANY_ADDRESS');
		$COMPANY_TELEPHONE = $this->Model_settings->get_setting_value('COMPANY_TELEPHONE');
		$STORE_NPWP = $this->Model_settings->get_setting_value('STORE_NPWP');
		$settings = array(
				"COMPANY_NAME" => $COMPANY_NAME,
				"COMPANY_ADDRESS" => $COMPANY_ADDRESS,
				"COMPANY_TELEPHONE" => $COMPANY_TELEPHONE,
				"STORE_NPWP" => $STORE_NPWP
		);
		$data['settings'] = $settings;
		
		$this -> load -> view('cashier/sales/rePrintReceive',$data);
	}
	
	function getReceivedData(){
		$salesId = $this->input->post("salesId");
		$this -> load -> model("cashier/model_sales");
		$data = [];
		$orderData = $this -> model_sales ->getReceivedData($salesId);
		if($orderData != null && $orderData != false){
			$data = array(
					"success" => true,
					"data" => $orderData
			);
		} else {
			$data = array(
					"success" => false
			);
		}
		echo json_encode($data);
	}
	
}
