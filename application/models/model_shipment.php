<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_shipment
 *
 * @author operational
 */
class model_shipment extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_by_id($id) {
         $query = "select sh.*,cl.code as client_code,cl.name as client_name,cl.company as client_company,cl.address,cl.email,cl.phone,cl.fax "
                . "from shipment sh "
                . "JOIN client cl ON sh.client_id=cl.id where sh.id=$id";
        return $this->db->query($query)->row();
    }

    function select_product_by_shipment_id($id) {
       
        $query_temp = "select rd.*,p.ebako_code,p.image product_image,p.customer_code, 
            poi.remarks, poi.finishing, p.material,po.po_no,po.po_client_no,poi.tagfor,poi.description  
            from shipment_detail rd 
            left join product_order_detail pod on rd.serial_number=pod.serial_number 
            left join purchaseorder_item poi on pod.purchaseorder_item_id=poi.id 
            join products p on poi.product_id=p.id join purchaseorder po on poi.purchaseorder_id=po.id 
            join client c on po.client_id=c.id 
            where rd.shipmentid=$id";
        return $this->db->query($query_temp)->result();
    }

    function get() {
        
        $query = "select sh.*,cl.code as client_code,cl.name as client_name,cl.company as client_company "
                . "from shipment sh "
                . "JOIN client cl ON sh.client_id=cl.id";
        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (shipment.shipment_no ilike '%$q%' "
                    . " or client.name ilike '%$q%' "
                    . " or client.code ilike '%$q%')";
        }

        $query .= " order by sh.id desc ";
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

    function insert($data) {
        return $this->db->insert('shipment', $data);
    }

    function update($data, $where) {
        return $this->db->update('shipment', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('shipment', $where);
    }

    function detail_get() {

        $shipmentid = $this->input->post('shipmentid');

        if (empty($shipmentid)) {
            $shipmentid = 0;
        }

        $query_temp = "select rd.*,p.ebako_code,p.image product_image,p.customer_code, 
            p.remarks, poi.finishing, p.material,po.po_no,po.po_client_no,poi.description,poi.tagfor 
            from shipment_detail rd 
            left join product_order_detail pod on rd.serial_number=pod.serial_number 
            left join purchaseorder_item poi on pod.purchaseorder_item_id=poi.id 
            join products p on poi.product_id=p.id join purchaseorder po on poi.purchaseorder_id=po.id 
            join client c on po.client_id=c.id 
            where rd.shipmentid=$shipmentid";
        
        $q = $this->input->post('q');
        if (!empty($q)) {
            $query_temp .= " and (pod.serial_number ilike '%$q%' "
                    . " or p.ebako_code ilike '%$q%' "
                    . " or p.customer_code ilike '%$q%')";
        }

        // echo $query_temp;
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

    function summarize_get() {

        $shipmentid = $this->input->post('shipmentid');

        if (empty($shipmentid)) {
            $shipmentid = 0;
        }

        $query = "select count(ebako_code) as box_qty,ebako_code,customer_code, remarks,finishing, material, po_no, product_image,
            po_client_no,description,tagfor,
            (select count(distinct(item_order_seq_no)) from shipment_view sv2  where shipmentid=$shipmentid and sv2.po_no=sv.po_no and sv2.ebako_code=sv.ebako_code 
            and sv2.customer_code=sv.customer_code and sv2.po_client_no=sv.po_client_no and sv2.remarks=sv.remarks and sv2.finishing=sv.finishing 
            and sv2.material=sv.material and sv2.product_image=sv.product_image) as pcs_qty 
            from shipment_view sv where shipmentid=$shipmentid 
            group by product_id,ebako_code,customer_code,remarks,finishing,material,po_no,po_client_no,product_image,description,tagfor ";
        
        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and ebako_code ilike '%$q%' "
                    . " or customer_code ilike '%$q%')";
        }


        $query .= " order by customer_code desc ";
       // echo $query."<br>";
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
    function select_summarize_by_shipment_id($shipmentid) {
       
        $query_temp = "select count(ebako_code) as box_qty,ebako_code,customer_code, remarks,finishing, material, po_no, product_image,
            po_client_no,description ,tagfor,
            (select count(distinct(item_order_seq_no)) from shipment_view sv2  where shipmentid=$shipmentid and sv2.po_no=sv.po_no and sv2.ebako_code=sv.ebako_code 
            and sv2.customer_code=sv.customer_code and sv2.po_client_no=sv.po_client_no and sv2.remarks=sv.remarks and sv2.finishing=sv.finishing 
            and sv2.material=sv.material and sv2.product_image=sv.product_image) as pcs_qty 
            from shipment_view sv where shipmentid=$shipmentid 
            group by product_id,ebako_code,customer_code,remarks,finishing,material,po_no,po_client_no,product_image,description,tagfor";
        return $this->db->query($query_temp)->result();
    }

    function detail_insert_batch($data) {
        return $this->db->insert_batch('shipment_detail', $data);
    }

    function detail_delete_batch_by_ids($id) {
        $this->db->where_in('id', $id);
        return $this->db->delete('shipment_detail');
    }

}
