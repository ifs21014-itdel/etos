<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of paymentterm
 *
 * @author operational
 */
class paymentterm extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_paymentterm');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 83));
        $this->load->view('paymentterm/index', $data);
    }

    function input() {
        $this->load->view('paymentterm/input');
    }

    function get() {
        echo $this->model_paymentterm->get();
    }

    function save($id) {
        if ($id == 0) {
            $this->model_paymentterm->insert();
        } else {
            $this->model_paymentterm->update($id);
        }
    }

    function delete() {
        $this->model_paymentterm->delete();
    }

}
