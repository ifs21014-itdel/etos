<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of country
 *
 * @author hp
 */
class country extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_country');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 817));
        $this->load->view('country/index', $data);
    }

    function get() {
        echo $this->model_country->get();
    }

    function input() {
        $this->load->view('country/input');
    }

    function save() {
        $this->model_country->insert();
    }

    function update($id) {
        $this->model_country->update($id);
    }

    function delete() {
        $this->model_country->delete();
    }

}

?>
