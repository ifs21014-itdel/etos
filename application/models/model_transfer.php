<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_transfer
 *
 * @author operational
 */
class model_transfer extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    function get() {
        $query = "select t.*,vs.name source_name,vt.name target_name,ui.name user_inserted_name,
                uu.name user_updated_name 
                from transfer t 
                join vendor vs on t.source_id=vs.id
                join vendor vt on t.target_id=vt.id
                join users ui on t.user_inserted=ui.id
                left join users uu on t.user_updated=uu.id
                where true ";
        $q = $this->input->post('q');
        if(!empty($q)){
            $query .= " and (t.transfer_no ilike '%$q%' or vt.name ilike '%$q%' or vs.name ilike '%$q%' or t.description ilike '%$q%') ";
        }
        
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

    function insert($data) {
        return $this->db->insert('transfer', $data);
    }

    function update($data, $where) {
        return $this->db->update('transfer', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('transfer', $where);
    }

    function detail_get() {

        $transferid = $this->input->post('transferid');

        if (empty($transferid)) {
            $transferid = 0;
        }

        $query_temp = "select td.*,pi.order_id,p.code product_code,p.name product_name,p.image product_image,
            pip.width,pip.depth,pip.height,pip.volume,fabric.code fabric_code,fabric.description fabric_description,
            (select string_agg(code,',') from materials where id = ANY(pip.material_id)) material,
            (select string_agg(name,',') from color where id = ANY(pip.color_id)) color,po.po_no,
            po.date po_date,v.name vendor_name,ct.name component_type_name 
            from transfer_detail td left join product_order_detail pod on td.serial_number=pod.serial_number
            left join purchaseorder_item poi on pod.purchaseorder_item_id=poi.id join products p on poi.products_id=p.id
            join purchaseorder po on poi.purchaseorder_id=po.id join vendor v on po.vendor_id=v.id
            left join proformainvoice_product_component pip_c on poi.ppc_id=pip_c.id
            left join proformainvoice_product pip on pip_c.proformainvoice_product_id=pip.id
            left join proformainvoice pi on pip.proformainvoice_id=pi.id
            left join fabric on pip.fabric_id=fabric.id
            left join component_type ct on poi.component_type_id=ct.id
            where td.transfer_id=$transferid
        ";
        
        

        $query = "
          with t as (
            $query_temp
          ) select t.* from t where true
        ";
        
        $q = $this->input->post('q');
        if(!empty($q)){
            $query .= " and (t.product_name ilike '%$q%' or t.product_code ilike '%$q%' or t.serial_number ilike '%$q%' or t.vendor_name ilike '%$q%') ";
        }

        $query .= " order by t.id desc ";
//        echo "<pre>".$query."</pre>";
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
        return $this->db->insert_batch('transfer_detail', $data);
    }

    function detail_delete_batch_by_ids($id) {
        $this->db->where_in('id', $id);
        return $this->db->delete('transfer_detail');
    }

}
