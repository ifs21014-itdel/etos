<?php

/**
 * Controller Bill
 *
 * @author Rizal.Gurning
 */
class Bill extends CI_Controller{

	public function __construct(){
		parent::__construct();
	}

	function Index(){
		$this->load->view('cashier/bill/view');
	}
	
}
