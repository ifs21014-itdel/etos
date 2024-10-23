<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model Employee *
 * @author Rony
 */
class model_employee extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_result() {
        $this->db->order_by("employee_id", 'asc');
        return $this->db->get('employee')->result();
    }

    function get() {
        $query = "
            select
            e.*,
            d.name department_name,
            j.name job_title_name
            from employee e
            left join department d on e.department_id=d.id
            left join job_title j on e.job_title_id=j.id
            where true
            ";
        $query .= " order by e.id desc ";

        //echo $query;

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $result = array();
        $data = "";
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
//            echo $query;
//            exit;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
//            echo $query;
//            exit;
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function selectAllResult() {
        return $this->db->get('employee')->result();
    }

    function select_by_id($id) {
        return $this->db->get_where('employee', array('id' => $id))->row();
    }

    function insert($data) {
        if ($this->db->insert('employee', $data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update($data, $where) {
        if ($this->db->update('employee', $data, $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        //return $this->db->delete('currency', $where);
        $id = $this->input->post('id');

        $where = array("id" => $id);
        if ($this->db->delete('employee', $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    /* function get department list */

    function getDeptList() {
        $this->db->order_by("name", "ASC");
        $res = $this->db->get("department");
        return $res->result();
    }

}

?>