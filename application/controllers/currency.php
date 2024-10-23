<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of currency
 *
 * @author hp
 */
class currency extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_currency');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 80));
        $this->load->view('currency/index', $data);
    }

    function get() {
        echo $this->model_currency->get();
    }

    function input() {
        $this->load->view('currency/input');
    }

    function save() {
        $this->model_currency->insert();
    }

    function update($id) {
        $this->model_currency->update($id);
    }

    function delete() {
        $this->model_currency->delete();
    }

}

?>
