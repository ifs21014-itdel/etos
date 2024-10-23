<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_products
 *
 * @author hp
 */
class model_products extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_query($query) {
        return $this->db->query($query)->result();
    }
    
    function get_top_ten_sales(){
        $query = "
                select pro.id,pro.code,pro.name,pro.width,pro.height,pro.depth,count(pro.id) total,pro.volume
                from product_order_detail prod
                join purchaseorder_item poi on prod.purchaseorder_item_id=poi.id
                join products pro on poi.products_id=pro.id
                where prod.shippingid != 0
                group by pro.id 
                order by count(pro.id) desc limit 10
        ";
        
        $result = array();
        $data = "";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
//        echo "<pre>$query</pre>";
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " offset $offset";
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }
    
    function get($flag = "") {
        $query = "
            select t.*,
            cli.code client_code,
            cli.name client_name from products t 
            left join client cli on t.client_id=cli.id where true 
        ";
        //echo $query

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $products_name = $this->input->post('name');
        $products_code = $this->input->post('code');
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
                    $order_specification .=", $arr_sort[$i] $arr_order[$i] ";
                }
            }
        } else {
            $order_specification = " t.ebako_code asc";
        }
        if (!empty($products_name)) {
            $query .= " and t.description ilike '%$products_name%' ";
        }if (!empty($products_code)) {
            $query .= " and t.ebako_code ilike '%$products_code%' ";
        }

        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (t.description ilike '%$q%' or t.ebako_code ilike '%$q%')";
        }

        $code_name = $this->input->post('code_name');
        if (!empty($code_name)) {
            $query .= " and (t.description ilike '%$code_name%' or t.ebako_code ilike '%$code_name%')";
        }
        
        if($flag == "released"){
            $query .= " and t.status = 1 ";
        }
        elseif($flag>0){
            $query .= " and t.client_id = $flag ";
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
        return $this->db->insert('products', $data);
    }

    function update($data, $where) {
        return $this->db->update('products', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('products', $where);
    }

    function get_last_id() {
        return $this->db->query('select id from products order by id desc limit 1')->row()->id;
    }
    function getbyid($id) {
        $query="select * from products where id=".$id;
      //  echo $query;
        return $this->db->query($query)->row();
    }

    function get_information($no_identitas) {
        $this->db->where('no_identitas', $no_identitas);
        $this->db->limit(1);
        return $this->db->get('products')->row();
    }

    function get_rows($where, $dari_tanggal, $ke_tanggal) {
        $this->db->where($where);
        $this->db->where('tanggal >= ', $dari_tanggal);
        $this->db->where('tanggal <= ', $ke_tanggal);
        return $this->db->count_all_results('products');
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

    //------------------------------- products box

    function box_select_by_product_id($products_id) {
        $query = "select box.* from products_box as box JOIN products as c ON box.products_id=c.id  
                 where box.products_id='" . $products_id . "' ";
        //echo $query;
        return $this->db->query($query)->result();
    }

    function box_get() {

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        $products_id = $this->input->post('products_id');
        if (empty($products_id)) {
            $products_id = "0";
        }

        $query = "select box.* from products_box as box JOIN products as c ON box.products_id=c.id  
                 where box.products_id='" . $products_id . "' ";

        $order_specification = " box.id asc";
        $query .= "  order by $order_specification";
        $offset = ($page - 1) * $rows;
        $result = array();
       // echo $query;
        $result['total'] = $this->db->query($query)->num_rows();
        $query .= " limit $rows offset $offset";
      //  echo $query;
        $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
        return json_encode($result);
    }

    function box_delete($where) {
        return $this->db->delete('products_box', $where);
    }

    function box_insert($data) {
        return $this->db->insert('products_box', $data);
    }

    function box_update($data, $where) {
        return $this->db->update('products_box', $data, $where);
    }
    function getall(){
        
        $query = " select p.id,p.ebako_code, p.customer_code, p.packing_configuration,p.description,p.remarks, p.finishing, p.material,c.name "
                . " from products p LEFT JOIN client c ON p.client_id=c.id where true  ";
        //echo $query;
        return $this->db->query($query)->result();
    }


}
