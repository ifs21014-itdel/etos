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

    function get($type = "") {
        $query = "
            with t as (
                    select product_order_detail.*,proformainvoice.order_id,products.id products_id,products.code product_code,products.name product_name,
                    products.image product_image,fabric.code fabric_code,fabric.description fabric_description,
                    (select string_agg(code,',') from materials where id = ANY(proformainvoice_product.material_id)) material,
                    (select string_agg(name,',') from color where id = ANY(proformainvoice_product.color_id)) color,
                    proformainvoice_product.width,proformainvoice_product.depth,proformainvoice_product.height,proformainvoice_product.volume,
                    (select production_process_id from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) production_process_id,
                    (select date from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) date,
                    purchaseorder.id purchaseorder_id,purchaseorder.po_no,purchaseorder.date po_date,vendor.name vendor_name,receiving.wareouse_storeid,receiving.date receive_date,
                    (now()::date - receiving.do_date) aging,ct.name component_type_name,purchaseorder_item.component_type_id,client.id client_id,client.name client_name,
                    v_store2.name store_location_name,receiving_detail.hpp
                    from product_order_detail
                    join purchaseorder_item on product_order_detail.purchaseorder_item_id=purchaseorder_item.id
                    left join purchaseorder on purchaseorder_item.purchaseorder_id=purchaseorder.id
                    left join vendor on purchaseorder.vendor_id=vendor.id
                    left join products on  purchaseorder_item.products_id=products.id
                    left join proformainvoice_product_component on purchaseorder_item.ppc_id=proformainvoice_product_component.id
                    left join proformainvoice_product on proformainvoice_product_component.proformainvoice_product_id=proformainvoice_product.id
                    left join proformainvoice on proformainvoice_product.proformainvoice_id=proformainvoice.id
                    left join fabric on proformainvoice_product.fabric_id=fabric.id
                    left join receiving on product_order_detail.receiveid=receiving.id
                    left join component_type ct on purchaseorder_item.component_type_id=ct.id
                    left join client on proformainvoice.client_id=client.id
                    left join vendor v_store on receiving.wareouse_storeid=v_store.id
                    left join vendor v_store2 on product_order_detail.new_store_id=v_store2.id
                    left join receiving_detail on product_order_detail.serial_number = receiving_detail.serial_number
                    where product_order_detail.receiveid != 0 and product_order_detail.shippingid = 0
                    and product_order_detail.serial_number not in (select serial_number from proformainvoice_product_stock_allocated)
                    and product_order_detail.serial_number not in (select serial_number from proformainvoice_product_stock_allocated)
                    and ct.id in (1,2) order by product_order_detail.id asc
            ) select t.* from t where true
        ";

        $product_id = $this->input->post('product_id');

        $start_date = $this->input->post("start_date");
        $end_date = $this->input->post("end_date");
        if (!empty($start_date) && !empty($end_date)) {
            $query .= " and t.receive_date between '$start_date' and '$end_date'";
        }if (!empty($start_date) && empty($end_date)) {
            $query .= " and t.receive_date>='$start_date'";
        }if (empty($start_date) && !empty($end_date)) {
            $query .= " and t.receive_date<='$end_date'";
        }

        $product_id_or_name = $this->input->post("product_id_or_name");
        if (!empty($product_id_or_name)) {
            $query .= " and (t.product_code ilike '%$product_id_or_name%' or t.product_name ilike '%$product_id_or_name%') ";
        }

        $serial_number = $this->input->post("serial_number");
        if (!empty($serial_number)) {
            $query .= " and t.serial_number ilike '%$serial_number%' ";
        }

        $fabric = $this->input->post("fabric");
        if (!empty($fabric)) {
            $query .= " and t.fabric_description ilike '%$fabric%' ";
        }

        $material = $this->input->post("material");
        if (!empty($material)) {
            $query .= " and t.material ilike '%$material%' ";
        }

        $color = $this->input->post("color");
        if (!empty($color)) {
            $query .= " and t.color ilike '%$color%' ";
        }

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

        $component_type_id = $this->input->post("component_type_id");
        if (!empty($component_type_id) && $component_type_id != 0) {
            $query .= " and t.component_type_id=$component_type_id ";
        }

        $client_id = $this->input->post("client_id");
        if (!empty($client_id)) {
            $query .= " and t.client_id=$client_id";
        }

        $purchaseorderid = $this->input->post("purchaseorderid");
        if (!empty($purchaseorderid)) {
            $query .= " and t.purchaseorder_id=$purchaseorderid";
        }

        $wareouse_storeid = $this->input->post('wareouse_storeid');
        if (!empty($wareouse_storeid)) {
            $query .= " and t.new_store_id=$wareouse_storeid";
        }

        $query .= " order by t.id asc";

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

//        echo $query;
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

    function get_available_to_shipment($client_id) {

        $query = "
            select product_order_detail.*, purchaseorder.po_no, products.id products_id, 
            products.ebako_code, products.customer_code, products.remarks, products.finishing, products.material, 
            products.packing_configuration, products.image product_image, purchaseorder.id purchaseorder_id, 
            purchaseorder.po_no, purchaseorder.target_ship_date, client.name client_name 
            from product_order_detail join purchaseorder_item on product_order_detail.purchaseorder_item_id=purchaseorder_item.id 
            left join purchaseorder on purchaseorder_item.purchaseorder_id=purchaseorder.id 
            left join client on purchaseorder.client_id=client.id 
            left join products on purchaseorder_item.product_id=products.id 
            where true and client.id=$client_id and 
            product_order_detail.serial_number not in (select serial_number 
            from shipment_detail)";
        $product_id_or_name = $this->input->post('product_id_or_name');
        if (!empty($product_id_or_name)) {
            $query .= " and (products.ebako_code ilike '%$product_id_or_name%' or products.customer_code ilike '%$product_id_or_name%')";
        }

        $filter_allocated = $this->input->post('filter_allocated');

        if (!empty($filter_allocated)) {
            $query .= " and product_order_detail.serial_number not in (select serial_number from shipment_detail)";
        }
        $query .= " order by product_order_detail.id asc";
        //echo $query;
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
        //var_dump($data);
        return $data;
    }

    function summary_get($type = "") {
        $query = "
        with t as (
                select p.id products_id,p.code product_code,p.name product_name,po_i.component_type_id,
                pi_p.width,pi_p.depth,pi_p.height,count(*) qty, round(((pi_p.width * pi_p.depth * pi_p.height) / 1000000000)::numeric,3)::double precision volume
                from product_order_detail po_d
                join purchaseorder_item po_i on po_d.purchaseorder_item_id=po_i.id
                left join products p on  po_i.products_id=p.id
                left join proformainvoice_product_component pi_pc on po_i.ppc_id=pi_pc.id
                left join proformainvoice_product pi_p on pi_pc.proformainvoice_product_id=pi_p.id
                where po_d.receiveid != 0 and po_d.shippingid = 0
                and po_d.serial_number not in (select serial_number from proformainvoice_product_stock_allocated)
                group by p.id,pi_p.width,pi_p.depth,pi_p.height,po_i.component_type_id
        )
        select t.*,ct.name component_type_name,(t.qty * t.volume) total_volume
        from t
        join component_type ct on t.component_type_id=ct.id
        where true
        ";

        $product_id_or_name = $this->input->post("product_id_or_name");
        if (!empty($product_id_or_name)) {
            $query .= " and (t.product_code ilike '%$product_id_or_name%' or t.product_name ilike '%$product_id_or_name%') ";
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

        $component_type_id = $this->input->post("component_type_id");
        if (!empty($component_type_id) && $component_type_id != 0) {
            $query .= " and t.component_type_id=$component_type_id ";
        }

        $query .= " order by t.product_name asc";

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

//        echo $query;
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

}
