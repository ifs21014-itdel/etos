<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of product_type
 *
 * @author hp
 */
class product_type extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_product_type');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 45));
        $this->load->view('product_type/index', $data);
    }

    function input() {
        $this->load->view('product_type/input');
    }

    function get() {
        echo $this->model_product_type->get();
    }

    function save() {
        $this->model_product_type->insert();
    }

    function update($id) {
        $this->model_product_type->update($id);
    }

    function delete() {
        $this->model_product_type->delete();
    }

}

?>
