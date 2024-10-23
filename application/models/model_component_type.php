<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_component_type
 *
 * @author user
 */
class model_component_type extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get() {
        $query = "select * from component_type order by id asc ";
        $data = json_encode($this->db->query($query)->result());
        return $data;
    }

}

?>
