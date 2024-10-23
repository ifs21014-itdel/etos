<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_stock
 *
 * @author operational
 */
class model_stock extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get() {
        $query = "
            with t as (
                        select 
                        product_order_detail.*,
                        proformainvoice.order_id,
                        products.id products_id,
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
                        (select production_process_id from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) production_process_id,
                        (select date from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) date,
                        purchaseorder.id purchaseorder_id,
                        purchaseorder.po_no,
                        purchaseorder.date po_date,
                        vendor.name vendor_name
                        from product_order_detail
                        join purchaseorder_item on product_order_detail.purchaseorder_item_id=purchaseorder_item.id
                        left join purchaseorder on purchaseorder_item.purchaseorder_id=purchaseorder.id
                        left join vendor on purchaseorder.vendor_id=vendor.id
                        left join products on  purchaseorder_item.products_id=products.id
                        left join proformainvoice_product_component on purchaseorder_item.ppc_id=proformainvoice_product_component.id
                        left join proformainvoice_product on proformainvoice_product_component.proformainvoice_product_id=proformainvoice_product.id
                        left join proformainvoice on proformainvoice_product.proformainvoice_id=proformainvoice.id
                        left join fabric on proformainvoice_product.fabric_id=fabric.id
                        where true order by product_order_detail.id asc
                ) select t.*,production_process.name production_process_name,production_process.percent production_process_percent
                  from t
                  left join production_process on t.production_process_id=production_process.id
                  where t.receiveid != 0 and t.shippingid = 0 
        ";

        $product_id = $this->input->post('product_id');

        if (!empty($product_id)) {
            $query .= " and t.products_id=$product_id";
        }

        $width = $this->input->post('width');
        if (!empty($width)) {
            $query .= " and t.width=$width";
        }

        $depth = $this->input->post('depth');
        if (!empty($depth)) {
            $query .= " and t.depth=$depth";
        }

        $height = $this->input->post('height');
        if (!empty($height)) {
            $query .= " and t.height=$height";
        }

        $filter_allocated = $this->input->post('filter_allocated');

        if (!empty($filter_allocated)) {
            $query .= " and t.serial_number not in (select serial_number from proformainvoice_product_stock_allocated)";
        }

        $query .= " order by t.id asc";

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

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

    function get_available_to_shipment($vendor_id) {
        $proformainvoice_id = $this->input->post('proformainvoice_id');

//        $embed_query = "";
//        $embed_query_status_finish = "";
//
//        if ($vendor_id != 0) {
//            $embed_query = " and purchaseorder.vendor_id=$vendor_id ";
//            $embed_query_status_finish = "and production_process.percent=100 and t.receiveid = 0";
//        } else {
//            $embed_query_status_finish = "and t.receiveid != 0";
//        }

        $query = "
            with t as (
                        select 
                        product_order_detail.*,
                        proformainvoice.order_id,
                        products.id products_id,
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
                        (select production_process_id from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) production_process_id,
                        (select date from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) date,
                        purchaseorder.id purchaseorder_id,
                        purchaseorder.po_no,
                        purchaseorder.date po_date,
                        vendor.name vendor_name
                        from product_order_detail
                        join purchaseorder_item on product_order_detail.purchaseorder_item_id=purchaseorder_item.id
                        left join purchaseorder on purchaseorder_item.purchaseorder_id=purchaseorder.id
                        left join vendor on purchaseorder.vendor_id=vendor.id
                        left join products on  purchaseorder_item.products_id=products.id
                        left join proformainvoice_product_component on purchaseorder_item.ppc_id=proformainvoice_product_component.id
                        left join proformainvoice_product on proformainvoice_product_component.proformainvoice_product_id=proformainvoice_product.id
                        left join proformainvoice on proformainvoice_product.proformainvoice_id=proformainvoice.id
                        left join fabric on proformainvoice_product.fabric_id=fabric.id
                        where true and proformainvoice.id=$proformainvoice_id  and product_order_detail.receiveid != 0 order by product_order_detail.id asc
                ) select t.*,production_process.name production_process_name,production_process.percent production_process_percent
                  from t
                  left join production_process on t.production_process_id=production_process.id
                  where t.shippingid = 0 $embed_query_status_finish
        ";

//        echo $query;

        $product_id_or_name = $this->input->post('product_id_or_name');
        if (!empty($product_id_or_name)) {
            $query .= " and (t.product_code ilike '%$product_id_or_name%' or t.product_name ilike '%$product_id_or_name%')";
        }

        $width = $this->input->post('width');
        if (!empty($width)) {
            $query .= " and t.width=$width";
        }

        $depth = $this->input->post('depth');
        if (!empty($depth)) {
            $query .= " and t.depth=$depth";
        }

        $height = $this->input->post('height');
        if (!empty($height)) {
            $query .= " and t.height=$height";
        }

        $filter_allocated = $this->input->post('filter_allocated');

        if (!empty($filter_allocated)) {
            $query .= " and t.serial_number not in (select serial_number from proformainvoice_product_stock_allocated)";
        }

        $query .= " order by t.id asc";

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

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
