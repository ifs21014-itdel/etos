<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_productionprocess
 *
 * @author operational
 */
class model_productionprocess extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get() {
        $query = "select * from production_process order by id asc ";
        $data = json_encode($this->db->query($query)->result());
        return $data;
    }

}
