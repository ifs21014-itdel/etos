<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bank_account
 *
 * @author hp
 */
class bank_account extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_bank_account');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 44));
        $this->load->view('bank_account/index', $data);
    }

    function input() {
        $this->load->view('bank_account/input');
    }

    function get($company_id = 0) {
        echo $this->model_bank_account->get($company_id);
    }

    function save($id) {
        if ($id == 0) {
            $this->model_bank_account->insert();
        } else {
            $this->model_bank_account->update($id);
        }
    }

    function delete() {
        $this->model_bank_account->delete();
    }

}

?>
