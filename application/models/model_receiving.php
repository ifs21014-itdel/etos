<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class model_receiving extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get() {

        $query = "select receiving.*,vendor.code vendor_code,vendor.name vendor_name,users.name received_name,v.code store_warehouse_code,v.name store_warehouse_name
                from receiving
                left join vendor on receiving.vendor_id=vendor.id
                left join users on receiving.received_by = users.id
                join vendor v on receiving.wareouse_storeid=v.id where true ";
        $q = $this->input->post('q');
        if(!empty($q)){
            $query .= " and (receiving.number ilike '%$q%' "
                    . " or vendor.code ilike '%$q%' or vendor.name ilike '%$q%')";
        }
        
        $query .= " order by receiving.id desc ";
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

    function insert($data) {
        return $this->db->insert('receiving', $data);
    }

    function update($data, $where) {
        return $this->db->update('receiving', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('receiving', $where);
    }

    function detail_get() {

        $receivingid = $this->input->post('receivingid');

        if (empty($receivingid)) {
            $receivingid = 0;
        }

        $query_temp = "
            select 
            rd.*,
            pi.order_id,
            p.code product_code,
            p.name product_name,
            p.image product_image,
            pip.width,
            pip.depth,
            pip.height,
            pip.volume,
            fabric.code fabric_code,
            fabric.description fabric_description,
            (select string_agg(code,',') from materials where id = ANY(pip.material_id)) material,
            (select string_agg(name,',') from color where id = ANY(pip.color_id)) color,
            po.po_no,
            po.date po_date,
            v.name vendor_name,
            poi.component_type_id,
            ct.name comp_type_name
            from receiving_detail rd
            left join product_order_detail pod on rd.serial_number=pod.serial_number
            left join purchaseorder_item poi on pod.purchaseorder_item_id=poi.id
            join products p on poi.products_id=p.id
            join purchaseorder po on poi.purchaseorder_id=po.id
            join vendor v on po.vendor_id=v.id
            left join proformainvoice_product_component pip_c on poi.ppc_id=pip_c.id
            left join proformainvoice_product pip on pip_c.proformainvoice_product_id=pip.id
            left join proformainvoice pi on pip.proformainvoice_id=pi.id
            left join fabric on pip.fabric_id=fabric.id
            left join component_type ct on poi.component_type_id=ct.id
            where rd.receivingid=$receivingid
        ";
        $product_id_or_name = $this->input->post("product_id_or_name");
        if (!empty($product_id_or_name)) {
            $query_temp .= " and (p.code ilike '%$product_id_or_name%' or p.name ilike '%$product_id_or_name%')";
        }

        $serial_number = $this->input->post("serial_number");
        if (!empty($serial_number)) {
            $query_temp .= " and rd.serial_number ilike '%$serial_number%' ";
        }


        $query = "
          with t as (
            $query_temp
          ) select t.* from t where true
        ";

        $query .= " order by t.id desc ";
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

    function detail_insert_batch($data) {
        return $this->db->insert_batch('receiving_detail', $data);
    }

    function detail_delete_batch_by_ids($id) {
        $this->db->where_in('id', $id);
        return $this->db->delete('receiving_detail');
    }

    function get_vendor_unfinish_delivery() {
        $query = "
          with t as
            (
            select
            distinct purchaseorder.vendor_id id
            from product_order_detail
            join purchaseorder_item on product_order_detail.purchaseorder_item_id=purchaseorder_item.id
            left join purchaseorder on purchaseorder_item.purchaseorder_id=purchaseorder.id
            left join vendor on purchaseorder.vendor_id=vendor.id
            where product_order_detail.receiveid=0 and product_order_detail.shippingid=0
            ) select t.*,vendor.code,vendor.name,vendor.address 
              from t join vendor on t.id=vendor.id
              order by vendor.name asc  
        ";

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

}
