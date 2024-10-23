<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of image_category
 *
 * @author hp
 */
class image_category extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_image_category');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 80));
        $this->load->view('image_category/index', $data);
    }

    function get() {
        echo $this->model_image_category->get();
    }
    function selectall() {
        echo $this->model_image_category->selectAllResult();
    }

    function input() {
        $this->load->view('image_category/input');
    }

    function save() {
        $this->model_image_category->insert();
    }

    function update($id) {
        $this->model_image_category->update($id);
    }

    function delete() {
        $this->model_image_category->delete();
    }

}

?>
