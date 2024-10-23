<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bank
 *
 * @author hp
 */
class bank extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_bank');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 817));
        $this->load->view('bank/index', $data);
    }

    function get() {
        echo $this->model_bank->get();
    }

    function input() {
        $this->load->view('bank/input');
    }

    function save() {
        $this->model_bank->insert();
    }

    function update($id) {
        $this->model_bank->update($id);
    }

    function delete() {
        $this->model_bank->delete();
    }

}

?>
