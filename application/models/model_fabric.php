<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_fabric
 *
 * @author hp
 */
class model_fabric extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_result() {
        $this->db->order_by("id", 'asc');
        return $this->db->get('fabric')->result();
    }

    function get() {
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        $code = $this->input->post('code');
        $description = $this->input->post('description');

        $query = "
            with t as(
                    select 
                    fabric.*,
                    vendor.code vendor_code,
                    vendor.name vendor_name,
                    currency.code currency_code 
                    from fabric 
                    left join vendor on fabric.vendor_id=vendor.id
                    left join currency on fabric.currency_id=currency.id
            )select t.* from t where true
        ";
        if (!empty($code)) {
            $query .= " and t.code ilike '%$code%' ";
        }if (!empty($description)) {
            $query .= " and t.description ilike '%$description%' ";
        }
        //----------- search parameter for grid ----------------------

        $code_description = $this->input->post('code_description');
        $q = $this->input->post('q');
        if (!empty($code_description)) {
            $query .= " and (t.code ilike '%$code_description%' or 
                             t.description ilike '%$code_description%' or
                             t.vendor_code ilike '%$code_description%' or
                             t.vendor_name ilike '%$code_description%' or
                             t.currency_code ilike '%$code_description%')";
        }

        if (!empty($q)) {
            $query .= " and (t.code ilike '%$q%' or 
                             t.description ilike '%$q%' or
                             t.vendor_code ilike '%$q%' or
                             t.vendor_name ilike '%$q%' or
                             t.currency_code ilike '%$q%')";
        }

        //----------------------
        $query .= " order by t.id desc ";
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
        return $this->db->get('fabric')->result();
    }

    function select_by_id($id) {
        return $this->db->get_where('fabric', array('id' => $id))->row();
    }

    function insert() {
        $data = array(
            "code" => $this->input->post('code'),
            "description" => $this->input->post('description'),
            "vendor_id" => $this->input->post('vendor_id'),
            "price" => $this->input->post('price'),
            "currency_id" => $this->input->post('currency_id'),
            "remark" => $this->input->post('remark')
        );
        if ($this->db->insert('fabric', $data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update($id) {
        $data = array(
            "code" => $this->input->post('code'),
            "description" => $this->input->post('description'),
            "vendor_id" => $this->input->post('vendor_id'),
            "price" => $this->input->post('price'),
            "currency_id" => $this->input->post('currency_id'),
            "remark" => $this->input->post('remark')
        );
        if ($this->db->update('fabric', $data, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        //return $this->db->delete('fabric', $where);
        $id = $this->input->post('id');
        $where = array("id" => $id);
        if ($this->db->delete('fabric', $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}

?>