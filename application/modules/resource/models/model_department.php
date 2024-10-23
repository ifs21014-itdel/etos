<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_department
 *
 * @author hp
 */
class model_department extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_result() {
        $this->db->order_by("id", 'asc');
        return $this->db->get('department')->result();
    }

    function get() {
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        $code = $this->input->post('code');
        $name = $this->input->post('remark');
        $description = $this->input->post('description');

        $query = "
                    select
                    t.*
                    from department t
                    where true
        ";
        if (!empty($code)) {
            $query .= " and t.code ilike '%$code%' ";
        }if (!empty($description)) {
            $query .= " and t.description ilike '%$description%' ";
        }

        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (t.code ilike '%$q%' or
                             t.name ilike '%$q%' or
                             t.remark ilike '%$q%')";
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
        return $this->db->get('department')->result();
    }

    function select_by_id($id) {
        return $this->db->get_where('department', array('id' => $id))->row();
    }

    function insert($data) {
        $data['created_by'] = $this->session->userdata("id");
        if ($this->db->insert('department', $data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update($data, $where) {
        $data['updated_by'] = $this->session->userdata("id");
        $data['created_at'] = "now()";
        if ($this->db->update('department', $data, $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete($where) {
        if ($this->db->delete('department', $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}

?>