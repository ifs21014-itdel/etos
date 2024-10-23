<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inspection_summary
 *
 * @author hp
 */
class inspection_summary extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_inspection_summary');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 80));
        $this->load->view('inspection_summary/index', $data);
    }

    function get() {
        echo $this->model_inspection_summary->get();
    }
    function selectall() {
        echo $this->model_inspection_summary->selectAllResult();
    }
    

}

?>
