<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of accessories
 *
 * @author hp
 */
class accessories extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_accessories');
    }

    function index() {
        $this->load->view('accessories/view');
    }

    function get() {
        echo $this->model_accessories->get();
    }

    function save() {
        $this->model_accessories->insert();
    }

    function update($id) {
        $this->model_accessories->update($id);
    }

    function delete() {
        $this->model_accessories->delete();
    }

}

?>
