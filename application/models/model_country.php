<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_country
 *
 * @author hp
 */
class model_country extends CI_Model {

    //put your common_name here
    public function __construct() {
        parent::__construct();
    }

    function select_result() {
        $this->db->order_by("id", 'asc');
        return $this->db->get('country')->result();
    }

    function get() {
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $sort = $this->input->post('sort');
        $order = $this->input->post('order');
        $common_name = $this->input->post('common_name');
        $formal_name = $this->input->post('formal_name');
        $capital = $this->input->post('capital');
        if (!empty($sort)) {
            $arr_sort = explode(',', $sort);
            $arr_order = explode(',', $order);
            if (count($arr_sort) == 1) {
                $order_specification = " $arr_sort[0] $arr_order[0] ";
            } else {
                $order_specification = " $arr_sort[0] $arr_order[0] ";
                for ($i = 1; $i < count($arr_sort); $i++) {
                    $order_specification .=", $arr_sort[$i] $arr_order[$i] ";
                }
            }
        } else {
            $order_specification = " common_name asc";
        }
        $query = "select * from country where true ";


        //----------- search parameter for grid ----------------------
        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (common_name ilike '%$q%' or formal_name ilike '%$q%' or capital ilike '%$q%')";
        }
        //----------------------
        $query .= " order by $order_specification";
        //echo $query;
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
        return $this->db->get('country')->result();
    }

    function select_by_id($id) {
        return $this->db->get_where('country', array('id' => $id))->row();
    }

    function insert() {

        $data = array(
            "common_name" => $this->input->post('common_name'),
            "formal_name" => $this->input->post('formal_name'),
            "capital" => $this->input->post('capital')
        );
        if ($this->db->insert('country', $data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update($id) {

        $data = array(
            "common_name" => $this->input->post('common_name'),
            "formal_name" => $this->input->post('formal_name'),
            "capital" => $this->input->post('capital')
        );

        if ($this->db->update('country', $data, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        //return $this->db->delete('country', $where);
        $id = $this->input->post('id');
        $where = array("id" => $id);
        if ($this->db->delete('country', $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}

?>