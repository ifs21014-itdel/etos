<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of productionprocess
 *
 * @author operational
 */
class productionprocess extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_productionprocess');
    }

    function index() {
        
    }

    function get() {
        echo $this->model_productionprocess->get();
    }

}
