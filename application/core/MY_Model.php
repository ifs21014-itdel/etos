<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Model
 *
 * @author Bernovan Munte <bernovanmunte@gmail.com>
 */
class MY_Model extends CI_Model {

    //put your code here
    public $table_name = "";
    public $table_alias = "";
    public $queryString = "";
    public $fieldMap = array();
    public $fieldKeyWordSearch = array();
    public $total = 0;

    public function __construct() {
        parent::__construct();
    }

    function get() {
        $this->filter();
        $this->order($this->table_alias);
//        print_query($this->queryString);
        $this->paging();
        return result_json_encode_parse($this->total, $this->execute_query_as_result($this->queryString));
    }

    public function filter() {

        $q = $this->input->post("q");
        $filterRules = $this->input->post('filterRules');
        if (!empty($q)) {
            if (count($this->fieldKeyWordSearch) > 0) {
                $query = " and (";
                for ($i = 0; $i < count($this->fieldKeyWordSearch); $i++) {
                    if ($i == 0) {
                        $query .= " lower(" . $this->fieldKeyWordSearch[$i] . ") like '" . strtolower($q) . "%' ";
                    } else {
                        $query .= " or lower(" . $this->fieldKeyWordSearch[$i] . ") like '" . strtolower($q) . "%' ";
                    }
                }
                $query .= ")";
                $this->queryString .= $query;
            }
        }
        if (!empty($filterRules)) {
            $filterRules = json_decode($filterRules);
            foreach ($filterRules as $filterRule) {
                $this->queryString .= create_filter($this->fieldMap, $filterRule->field, $filterRule->op, $filterRule->value);
            }
        }
    }

    public function order($alias) {
        $sort = $this->input->post('sort');
        $order = $this->input->post('order');
        if (!empty($sort) && !empty($order)) {
            $this->queryString .= create_sort($this->fieldMap, $sort, $order);
        } else {
            $this->queryString .= " order by $alias.id desc";
        }
    }

    public function paging() {
        $pg = $this->input->post('page');
        $rows = $this->input->post('rows');
        if (!empty($pg) || !empty($rows)) {
            $page = ($pg == 0 ? 1 : $pg);
            $offset = ($page - 1) * $rows;
            $this->total = $this->get_num_rows();
            $this->queryString .= " limit " . $rows . " offset $offset";
        }
    }

    public function insert($data) {
        $data["created_by"] = $this->session->userdata('id');
        return $this->db->insert($this->table_name, $data);
    }

    public function insert2($data) {
        return $this->db->insert($this->table_name, $data);
    }

    public function insert_with_return_id($data) {
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function insert_batch($data) {
        return $this->db->insert_batch($this->table_name, $data);
    }

    public function update($data, $where) {
        $data["updated_by"] = $this->session->userdata('id');
        $data["updated_at"] = date('Y-m-d h:i:s');
        return $this->db->update($this->table_name, $data, $where);
    }

    public function delete($where) {
        return $this->db->delete($this->table_name, $where);
    }

    public function deletes($ids) {
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $where = array(
                    "id" => $id
                );
                $this->delete($where);
            }
        } else {
            $where = array(
                "id" => $ids
            );
            $this->delete($where);
        }
        return true;
    }

    public function select_by_id($id) {
        $this->queryString .= " and " . $this->table_alias . ".id=" . $id;
        return $this->db->query($this->queryString)->row();
    }

    public function get_num_rows() {
        return $this->db->query($this->queryString)->num_rows();
    }

    public function execute_query($query) {
        return $this->db->query($query);
    }

    public function execute_query_as_row($query) {
        return $this->db->query($query)->row();
    }

    public function execute_query_as_result($query) {
        return $this->db->query($query)->result();
    }

}
