<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_requestforsample
 *
 * @author operational
 */
class model_requestforsample extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get() {

        $query = "
            select
            rfs.*,
            v.name vendor_name,
            c.name company_name
            from
            requestforsample rfs
            join vendor v on rfs.vendor_id=v.id
            join company c on rfs.company_id=c.id
            where true
            ";
        $query .= " order by rfs.id desc ";

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
        return $this->db->get('requestforsample')->result();
    }

    function select_by_id($id) {
        $query = "
            select
            rfs.*,
            v.name vendor_name,
            v.address vendor_address,
            c.name company_name,
            c.address company_address
            from
            requestforsample rfs
            join vendor v on rfs.vendor_id=v.id
            join company c on rfs.company_id=c.id
            where rfs.id=$id
            ";
        return $this->db->query($query)->row();
    }

    function insert($data) {
        $data["number"] = $this->get_next_number($data['vendor_id']);
        return $this->db->insert('requestforsample', $data);
    }

    function update($data, $where) {
        return $this->db->update('requestforsample', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('requestforsample', $where);
    }

    function detail_get() {

        $requestforsampleid = $this->input->post('requestforsampleid');

        if (empty($requestforsampleid)) {
            $requestforsampleid = 0;
        }
        $query = "
            select
            rfsd.*,
            (select string_agg(code,',') from materials where id = ANY(rfsd.material_id)) material,
            (select string_agg(name,',') from color where id = ANY(rfsd.color_id)) color,
            fabric.code fabric_code
            from 
            requestforsample_detail rfsd
            left join fabric on rfsd.fabric_id=fabric.id
            where rfsd.requestforsample_id=$requestforsampleid
            ";
        $query .= " order by rfsd.id desc ";

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

    function select_detail_by_rfs_id($id) {
        $query = "select rfsd.*,
            (select string_agg(code,',') from materials where id = ANY(rfsd.material_id)) material,
            (select string_agg(name,',') from color where id = ANY(rfsd.color_id)) color,
            fabric.code fabric_code
            from 
            requestforsample_detail rfsd
            left join fabric on rfsd.fabric_id=fabric.id
            where rfsd.requestforsample_id=$id";
        return $this->db->query($query)->result();
    }

    function detail_insert($data) {
        return $this->db->insert('requestforsample_detail', $data);
    }

    function detail_update($data, $where) {
        return $this->db->update('requestforsample_detail', $data, $where);
    }

    function detail_delete($where) {
        return $this->db->delete('requestforsample_detail', $where);
    }

    function get_next_number($vendor_id) {
        return $this->db->query("select requestforsample_next_number($vendor_id) next_no")->row()->next_no;
    }

}
