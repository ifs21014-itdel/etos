<?php

/**
 * @author Rizal.Gurning
 */
class Template extends CI_Controller{

	public function __construct(){
		parent::__construct();
	}

	function Index(){
	}

	function customer_list_template(){
		$this -> load -> view('cashier/template/customer_list_template');
	}
	
	function customer_list_template_data(){
		$filterByBarcode = $this->input->post("searchCustomerKey");
		$filterByName = $this->input->post("searchCustomerKey");
		$this -> load -> model("master/Model_customer");
		$data = $this -> Model_customer -> get_customer($filterByBarcode, $filterByName);
		echo json_encode($data);
	}
	
	
	
}
