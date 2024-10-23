<?php

/**
 * Controller Item_suggestion
 *
 * @author Rizal.Gurning
 */
class Item_suggestion extends CI_Controller{

	public function __construct(){
		parent::__construct();
	}

	function Index(){
		$this->load->view('cashier/item_suggestion/view');
	}
}
