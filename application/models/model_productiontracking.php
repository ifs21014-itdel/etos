<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_productiontracking
 *
 * @author operational
 */
class model_productiontracking extends CI_Model {

//put your code here
    public function __construct() {
        parent::__construct();
    }

    function product_list_get($type = "") {

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        $query = "
                with t as (
                        select 
                        product_order_detail.*,
                        proformainvoice.order_id,
                        products.code product_code,
                        products.name product_name,
                        products.image product_image,
                        fabric.code fabric_code,
                        fabric.description fabric_description,
                        (select string_agg(code,',') from materials where id = ANY(proformainvoice_product.material_id)) material,
                        (select string_agg(name,',') from color where id = ANY(proformainvoice_product.color_id)) color,
                        proformainvoice_product.width,
                        proformainvoice_product.depth,
                        proformainvoice_product.height,
                        proformainvoice_product.volume,
                        (select pp.percent from order_tracking ot LEFT JOIN production_process pp ON ot.production_process_id=pp.id 
                        where ot.serial_number=product_order_detail.serial_number 
                        and ot.id<(select max(id) from order_tracking where serial_number=product_order_detail.serial_number) 
                        order by ot.id desc limit 1) percent_before,
                        (select date from order_tracking where serial_number=product_order_detail.serial_number 
                        and id<(select max(id) from order_tracking where serial_number=product_order_detail.serial_number) order by id desc limit 1) date_before,
                        (select production_process_id from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) production_process_id,
                        (select date from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) date,
                        (select notes from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) notes,
                        purchaseorder.id purchaseorder_id,
                        purchaseorder.po_no,
                        purchaseorder.vendor_id,
                        purchaseorder.date po_date,
                        purchaseorder.down_payment_date,
                        purchaseorder.target_ship_date,
                        purchaseorder_item.component_type_id,
                        component_type.name component_category,
                        vendor.name vendor_name
                        from product_order_detail
                        join purchaseorder_item on product_order_detail.purchaseorder_item_id=purchaseorder_item.id
                        left join purchaseorder on purchaseorder_item.purchaseorder_id=purchaseorder.id
                        left join component_type on purchaseorder_item.component_type_id=component_type.id
                        left join vendor on purchaseorder.vendor_id=vendor.id
                        left join products on  purchaseorder_item.products_id=products.id
                        left join proformainvoice_product_component on purchaseorder_item.ppc_id=proformainvoice_product_component.id
                        left join proformainvoice_product on proformainvoice_product_component.proformainvoice_product_id=proformainvoice_product.id
                        left join proformainvoice on proformainvoice_product.proformainvoice_id=proformainvoice.id
                        left join fabric on proformainvoice_product.fabric_id=fabric.id
                        where true and product_order_detail.receiveid=0 order by product_order_detail.id asc
                ) select t.*,production_process.name production_process_name,production_process.percent production_process_percent,
			((now()::date - t.down_payment_date)/7) production_week
                  from t
                  left join production_process on t.production_process_id=production_process.id
                  where true
        ";

        $vendor_id = $this->input->post('vendor_id');
        if (!empty($vendor_id)) {
            $query .= " and t.vendor_id = $vendor_id ";
        }

        $purchaseorderid = $this->input->post('purchaseorderid');
        if (!empty($purchaseorderid)) {
            $query .= " and t.purchaseorder_id = $purchaseorderid";
        }

        $product_id_or_name = $this->input->post('product_id_or_name');
        if (!empty($product_id_or_name)) {
            $query .= " and (t.product_code ilike '%$product_id_or_name%' or t.product_name ilike '%$product_id_or_name%')";
        }

        $serial_number = $this->input->post('serial_number');
        if (!empty($serial_number)) {
            $query .= " and t.serial_number similar to '%($serial_number)%'";
        }

        $production_process_id = $this->input->post('production_process_id');
        if (!empty($production_process_id)) {
            $query .= " and t.production_process_id = $production_process_id";
        }

        $status = $this->input->post('status');
        if (!empty($status)) {
            if ($status === 'finish') {
                $query .= " and t.production_process_id = 11";
            } else {
                $query .= " and t.production_process_id != 11";
            }
        }

        $query .= " order by t.id asc";
        //echo $query;
        if ($type == "result") {
            return $this->db->query($query)->result();
        } else {
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

    function is_valid_to_upload($production_process_id, $serial_number) {
        $query = "select order_tracking_isvalid_to_upload_serial_number($production_process_id, '$serial_number') ct";
//        echo $query;
        $dt = $this->db->query($query)->row();
        return ($dt->ct == 't');
    }

}
