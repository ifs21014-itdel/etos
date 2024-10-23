<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of company
 *
 * @author hp
 */
class company extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_company');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 818));
        $this->load->view('company/index', $data);
    }

    function get() {
        echo $this->model_company->get();
    }

    function input() {
        $this->load->view('company/input');
    }

    function save() {
        $this->model_company->insert();
    }

    function update($id) {
        $this->model_company->update($id);
    }

    function delete() {
        $this->model_company->delete();
    }

}

?>
