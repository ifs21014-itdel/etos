<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * name of model_color
 *
 * @author hp
 */
class model_color extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_result() {
        $this->db->order_by("id", 'asc');
        return $this->db->get('color')->result();
    }

    function get() {
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $sort = $this->input->post('sort');
        $order = $this->input->post('order');
        $code_name = $this->input->post('code_name');

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
            $order_specification = " id desc";
        }
        $query = "select * from color where true ";
        if (!empty($code_name)) {
            $query .= " and (code ilike '%$q%' or name ilike '%$q%') ";
        }

        //----------- search parameter for grid ----------------------
        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (code ilike '%$q%' or name ilike '%$q%') ";
        }
        //----------------------
        $filterRules = $this->input->post('filterRules');
        if(!empty($filterRules)){
            $obj = json_decode($filterRules);
            $query .= match_search('', $obj);
        }
        
        $query .= " order by $order_specification";
//        echo $query;
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
        return $this->db->get('color')->result();
    }

    function select_by_id($id) {
        return $this->db->get_where('color', array('id' => $id))->row();
    }

    function insert() {
        if ($this->db->insert('color', array(
                    "code" => $this->input->post('code'),
                    "name" => $this->input->post('name')
                ))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update($id) {
        if ($this->db->update('color', array(
                    "code" => $this->input->post('code'),
                    "name" => $this->input->post('name')
                        ), array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        if ($this->db->delete('color', array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}

?>