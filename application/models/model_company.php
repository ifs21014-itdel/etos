<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class model_company extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get() {

        $query = "
                select 
                company.*
                from company 
                where true 
            ";
        $name = $this->input->post('name');
        if (!empty($name)) {
            $query .= " and company.name ilike '%$name%' ";
        }

        $q = $this->input->post('q');

        if (!empty($q)) {
            $query .= " and (company.name ilike '%$q%' or company.address ilike '%$q%')";
        }

        $query .= " order by company.id desc ";
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

    function select_by_id($id) {
        $this->db->select("*");
        $this->db->from("company");
        $this->db->where(array("id" => $id));
        return $this->db->get()->row();
    }
    function selectAllResult() {
        return $this->db->get('company')->result();
    }

    function insert() {

        $data = array(
            "code" => $this->input->post('code'),
            "name" => $this->input->post('name'),
            "address" => $this->input->post('address'),
            "type" => $this->input->post('type'),
            "telp" => $this->input->post('telp'),
            "code" => $this->input->post('code')
        );
        if ($this->db->insert('company', $data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update($id) {

        $data = array(
            "code" => $this->input->post('code'),
            "name" => $this->input->post('name'),
            "address" => $this->input->post('address'),
            "type" => $this->input->post('type'),
            "telp" => $this->input->post('telp'),
            "code" => $this->input->post('code')
        );

        if ($this->db->update('company', $data, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        //return $this->db->delete('company', $where);
        $id = $this->input->post('id');
        $where = array("id" => $id);
        if ($this->db->delete('company', $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}
