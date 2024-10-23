<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_client
 *
 * @author hp
 */
class model_client extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get() {
        $code = $this->input->post('code');
        $query = "
            with t as (
                select 
                client.* 
                from client 
            ) select t.* from t where true 
            ";

        if (!empty($code)) {
            $query .= " and t.code ilike '%$code%' ";
        }

        $q = $this->input->post('q');

        if (!empty($q)) {
            $query .= " and (t.code ilike '%$q%' or t.name ilike '%$q%' or t.company ilike '%$q%')";
        }

        $query .= " order by t.id desc ";
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
        return $this->db->get('client')->result();
    }

    function insert($data) {
        return $this->db->insert('client', $data);
    }

    function update($data, $where) {
        return $this->db->update('client', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('client', $where);
    }

}

?>
