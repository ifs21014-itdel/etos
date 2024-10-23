<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fabric
 *
 * @author hp
 */
class fabric extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_fabric');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 43));
        $this->load->view('fabric/index', $data);
    }

    function input() {
        $this->load->view('fabric/input');
    }

    function get() {
        echo $this->model_fabric->get();
    }

    function save($id) {
        if ($id == 0) {
            $this->model_fabric->insert();
        } else {
            $this->model_fabric->update($id);
        }
    }

    function delete() {
        $this->model_fabric->delete();
    }

}
