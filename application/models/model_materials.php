<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_materials
 *
 * @author hp
 */
class model_materials extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_result() {
        $this->db->order_by("id", 'asc');
        return $this->db->get('materials')->result();
    }

    function get() {
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        $code = $this->input->post('code');

        $query = "select * from materials where true ";
        if (!empty($code)) {
            $query .= " and (code ilike '%$code%' or description ilike '%$code%')";
        }


        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (code ilike '%$q%' or description ilike '%$q%') ";
        }


        //echo $query;
        $result = array();
        $data = "";
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " order by id desc limit $rows offset $offset";
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $query .= " order by code asc ";
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function selectAllResult() {
        return $this->db->get('materials')->result();
    }

    function select_by_id($id) {
        return $this->db->get_where('materials', array('id' => $id))->row();
    }

    function insert() {
        //return $this->db->insert('materials', $data);
        $code = $this->input->post('code');
        $description = $this->input->post('description');

        $data = array(
            "code" => $code,
            "description" => $description
        );
        if ($this->db->insert('materials', $data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update($id) {
        $code = $this->input->post('code');
        $description = $this->input->post('description');
        $data = array(
            "code" => $code,
            "description" => $description
        );
        $where = array("id" => $id);
        if ($this->db->update('materials', $data, $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        //return $this->db->delete('materials', $where);
        $id = $this->input->post('id');
        $where = array("id" => $id);
        if ($this->db->delete('materials', $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}

?>