<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_hot_cold_test_list
 *
 * @author hp
 */
class model_hot_cold_test_list extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_query($query) {
        return $this->db->query($query)->result();
    }

    function get($flag = "") {
//        $query = "
//            select t.*,
//            cli.code client_code,
//            cli.name client_name from hot_cold_test_list t 
//            left join client cli on t.client_id=cli.id where true 
//        ";
        $query = "
            select t.*,p.test_name,p.protocol_name from hot_cold_test_list t 
            left join protocol_test p on t.protocol_test_id=p.id where true 
        ";
        //echo $query

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $q = $this->input->post('hot_cold_test_list_q');
        $sort = $this->input->post('sort');
        $order = $this->input->post('order');

        if (!empty($sort)) {
            $arr_sort = explode(',', $sort);
            $arr_order = explode(',', $order);
            if (count($arr_sort) == 1) {
                $order_specification = " $arr_sort[0] $arr_order[0] ";
            } else {
                $order_specification = " $arr_sort[0] $arr_order[0] ";
                for ($i = 1; $i < count($arr_sort); $i++) {
                    $order_specification .= ", $arr_sort[$i] $arr_order[$i] ";
                }
            }
        } else {
            $order_specification = " t.id asc";
        }
        if (!empty($q)) {
            $query .= " and (p.test_name ilike '%$q%' or p.protocol_name ilike '%$q%')";
        }
        $query .= "  order by $order_specification";
        // echo $query;
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
        return $this->db->insert('hot_cold_test_list', $data);
    }

    function update($data, $where) {
        return $this->db->update('hot_cold_test_list', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('hot_cold_test_list', $where);
    }

    function get_last_id() {
        return $this->db->query('select id from hot_cold_test_list order by id desc limit 1')->row()->id;
    }

    function getbyid($id) {
        $query = "select * from hot_cold_test_list where id=" . $id;
        //  echo $query;
        return $this->db->query($query)->row();
    }

    function get_information($no_identitas) {
        $this->db->where('no_identitas', $no_identitas);
        $this->db->limit(1);
        return $this->db->get('hot_cold_test_list')->row();
    }

    function get_rows($where, $dari_tanggal, $ke_tanggal) {
        $this->db->where($where);
        $this->db->where('tanggal >= ', $dari_tanggal);
        $this->db->where('tanggal <= ', $ke_tanggal);
        return $this->db->count_all_results('hot_cold_test_list');
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

    //------------------------------- hot_cold_test_list box

    function hot_cold_test_list_detail_select_by_hot_cold_test_list_detail_id($hot_cold_test_list_id) {
        $query = "select dt1.* from hot_cold_test_list_detail dt1 JOIN hot_cold_test_list as c ON dt1.hot_cold_test_list_id=c.id  
                 where dt1.hot_cold_test_list_id='" . $hot_cold_test_list_id . "' order by dt1.var_type, dt1.id asc";
        //echo $query;
        return $this->db->query($query)->result();
    }

    function hot_cold_test_list_detail_get() {

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        $hot_cold_test_list_id = $this->input->post('hot_cold_test_list_id');
        if (empty($hot_cold_test_list_id)) {
            $hot_cold_test_list_id = "0";
        }

        $query = "select d.submited,dt.* from hot_cold_test_list_detail dt JOIN hot_cold_test_list d ON d.id=dt.hot_cold_test_list_id where dt.hot_cold_test_list_id='" . $hot_cold_test_list_id . "' ";

        $order_specification = " dt.var_type,dt.id asc";
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

    function hot_cold_test_list_detail_delete($where) {
        return $this->db->delete('hot_cold_test_list_detail', $where);
    }

    function hot_cold_test_list_detail_insert($data) {
        return $this->db->insert('hot_cold_test_list_detail', $data);
    }

    function hot_cold_test_list_detail_update($data, $where) {
        return $this->db->update('hot_cold_test_list_detail', $data, $where);
    }

    function getall() {

        $query = " select p.id,p.ebako_code, p.customer_code, p.packing_configuration,p.description,p.remarks, p.finishing, p.material,c.name "
                . " from hot_cold_test_list p LEFT JOIN client c ON p.client_id=c.id where true  ";
        //echo $query;
        return $this->db->query($query)->result();
    }

    function get_item_po() {
        $query = "SELECT poi.*, c.name AS client_name, po.po_client_no, p.ebako_code, 
                         p.customer_code, c.id AS client_id, p.description, p.material, p.finishing 
                  FROM purchaseorder_item poi
                  JOIN purchaseorder po ON po.id = poi.purchaseorder_id 
                  JOIN products p ON poi.product_id = p.id 
                  JOIN client c ON c.id = po.client_id 
                  WHERE poi.id NOT IN (SELECT purchaseorder_item_id FROM hot_cold_test_list) 
                  OR poi.id = ANY (SELECT purchaseorder_item_id FROM hot_cold_test_list)";
    
        //----------- search parameter for grid ----------------------
        $q = strtolower($this->input->post('q'));
        if (!empty($q)) {
            $query .= " AND (LOWER(p.ebako_code) LIKE '%" . $q . "%' 
                            OR LOWER(p.customer_code) LIKE '%" . $q . "%' 
                            OR po.po_client_no LIKE '%" . $q . "%')";
        }
        //----------------------
        $query .= " ORDER BY poi.id";
    
        // Eksekusi query
        $data = $this->db->query($query)->result();
        return json_encode($data);
    }
    
    function select_by_id($id) {
        $query = " select t.*,p.test_name,p.protocol_name,pr.description as item_description from hot_cold_test_list t 
            left join protocol_test p on t.protocol_test_id=p.id 
            LEFT JOIN products pr ON t.product_id=pr.id  
            where t.id=$id ";
       // echo $query;
        return $this->db->query($query)->row();
    }
    function hot_cold_test_list_detil_get_byid($id) {
        $query = "select dt1.* from hot_cold_test_list_detail dt1 JOIN hot_cold_test_list as c ON dt1.hot_cold_test_list_id=c.id  
                 where dt1.id='" . $id . "' ";
        //echo $query;
        return $this->db->query($query)->row();
    }
    
    function get_hot_cold_test_list_max_id()
    {
        $query = "select max(id) as max_id from hot_cold_test_list";
        // echo $query.'<br>';
        // var_dump($query);
        return $this->db->query($query)->result();
    }

}
