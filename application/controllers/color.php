<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of color
 *
 * @author hp
 */
class color extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_color');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 44));
        $this->load->view('color/index', $data);
    }

    function input() {
        $this->load->view('color/input');
    }

    function get() {
        echo $this->model_color->get();
    }

    function save($id) {
        if ($id == 0) {
            $this->model_color->insert();
        } else {
            $this->model_color->update($id);
        }
    }

    function delete() {
        $this->model_color->delete();
    }

}

?>
