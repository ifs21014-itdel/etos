<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of component_type
 *
 * @author user
 */
class component_type extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_component_type');
    }

    function get() {
        echo $this->model_component_type->get();
    }

}

?>
