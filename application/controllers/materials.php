<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of materials
 *
 * @author hp
 */
class materials extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_materials');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 46));
        $this->load->view('materials/index',$data);
    }

    function input() {
        $this->load->view('materials/input');
    }

    function get() {
        echo $this->model_materials->get();
    }

    function save() {
        $this->model_materials->insert();
    }

    function update($id) {
        $this->model_materials->update($id);
    }

    function delete() {
        $this->model_materials->delete();
    }

}

?>
