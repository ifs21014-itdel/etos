<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_rate
 *
 * @author operational
 */
class model_rate extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get() {

        $query = "
            select 
            rate.*,
            currency.code currency_code  
            from rate 
            join currency on rate.currency_id=currency.id
            where true
            ";
        $query .= " order by rate.id desc ";

        //echo $query;

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $result = array();
        $data = "";
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function selectAllResult() {
        return $this->db->get('rate')->result();
    }

    function insert($data) {
        return $this->db->insert('rate', $data);
    }

    function update($data, $where) {
        return $this->db->update('rate', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('rate', $where);
    }

}
