<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_protocol_test
 *
 * @author hp
 */
class model_protocol_test extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_query($query) {
        return $this->db->query($query)->result();
    }
    function get($flag = "") {
        $query = "
            select t.*,
            cli.code client_code,
            cli.name client_name from protocol_test t 
            left join client cli on t.client_id=cli.id where true 
        ";
        //echo $query

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $q = $this->input->post('protocol_test_q');
        $sort = $this->input->post('sort');
        $order = $this->input->post('order');
        //echo $sort;
        if($flag!="")
        $query .= "and test_name ilike '$flag%'";
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
            $order_specification = " t.test_name, t.id asc";
        }
        if (!empty($q)) {
            $query .= " and (t.test_name ilike '%$q%' or t.protocol_name ilike '%$q%')";
        }
        $query .= "  order by $order_specification";
       //  echo $query;
        //exit;
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

    function insert($data) {
        // print_r($data);
        return $this->db->insert('protocol_test', $data);
    }

    function update($data, $where) {
        return $this->db->update('protocol_test', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('protocol_test', $where);
    }

    function get_last_id() {
        return $this->db->query('select id from protocol_test order by id desc limit 1')->row()->id;
    }
    function getbyid($id) {
        $query="select * from protocol_test where id=".$id;
      //  echo $query;
        return $this->db->query($query)->row();
    }

    function get_information($no_identitas) {
        $this->db->where('no_identitas', $no_identitas);
        $this->db->limit(1);
        return $this->db->get('protocol_test')->row();
    }

    function get_rows($where, $dari_tanggal, $ke_tanggal) {
        $this->db->where($where);
        $this->db->where('tanggal >= ', $dari_tanggal);
        $this->db->where('tanggal <= ', $ke_tanggal);
        return $this->db->count_all_results('protocol_test');
    }

    function my_date($date) {
        list($yy, $mm, $dd) = explode('-', $date);
        $month = array(
            1 => "Jan",
            2 => "Feb",
            3 => "Mar",
            4 => "Apr",
            5 => "May",
            6 => "Jun",
            7 => "Jul",
            8 => "Aug",
            9 => "Sep",
            10 => "Oct",
            11 => "Nov",
            12 => "Dec");
        return $dd . " " . $month[(int) $mm] . " " . $yy;
    }

    //------------------------------- protocol_test box

    function variabel_test_select_by_variabel_test_id($protocol_test_id) {
        $query = "select variabel_test.* from variabel_test JOIN protocol_test as c ON variabel_test.protocol_test_id=c.id  
                 where variabel_test.protocol_test_id='" . $protocol_test_id . "' ";
        //echo $query;
        return $this->db->query($query)->result();
    }

    function variabel_test_get() {

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        $protocol_test_id = $this->input->post('protocol_test_id');
        if (empty($protocol_test_id)) {
            $protocol_test_id = "0";
        }

        $query = "select variabel_test.* from variabel_test JOIN protocol_test as c ON variabel_test.protocol_test_id=c.id  
                 where variabel_test.protocol_test_id='" . $protocol_test_id . "' ";

        $order_specification = " variabel_test.var_type, variabel_test.id asc";
        $query .= "  order by $order_specification";
        $offset = ($page - 1) * $rows;
        $result = array();
     //   echo $query;
        $result['total'] = $this->db->query($query)->num_rows();
        $query .= " limit $rows offset $offset";
      //  echo $query;
        $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
        return json_encode($result);
    }

    function variabel_test_delete($where) {
        return $this->db->delete('variabel_test', $where);
    }

    function variabel_test_insert($data) {
        return $this->db->insert('variabel_test', $data);
    }

    function variabel_test_update($data, $where) {
        return $this->db->update('variabel_test', $data, $where);
    }
    function getall(){
        
        $query = " select p.id,p.ebako_code, p.customer_code, p.packing_configuration,p.description,p.remarks, p.finishing, p.material,c.name "
                . " from protocol_test p LEFT JOIN client c ON p.client_id=c.id where true  ";
        //echo $query;
        return $this->db->query($query)->result();
    }


}
