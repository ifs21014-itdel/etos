<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_purchaseorder
 *
 * @author user
 */
class model_purchaseorder extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get_outstanding_release() {
        $query = "
            with t as (
            select 
            po.*,
            pi.order_id,
            ven.code vendor_code,
            currency.code currency_code,
            ven.name vendor_name,
            (select count(*) from purchaseorder_item where purchaseorder_id=po.id and component_type_id in (1,2,3)) count_base
            from purchaseorder po
            left join proformainvoice pi on po.pi_id=pi.id
            join vendor ven on po.vendor_id=ven.id
            join currency on po.currency_id=currency.id  
            ) select t.* from t where t.release=false order by t.date asc 
        ";

        $result = array();
        $data = "";
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

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

    function get() {
        $query = "
            with t as (
            select 
            po.*,
            cli.code client_code,
            cli.name client_name,
            (select count(*) from purchaseorder_item where purchaseorder_id=po.id) count_base
            from purchaseorder po 
            LEFT join client cli on po.client_id=cli.id
            ) select t.* from t where true
        ";
        // echo $query;


        $x = $this->input->post('x');
        if (!empty($x)) {
            $query .= " and t.count_base > 0 and t.release=true and t.id in (select purchaseorder_id from purchaseorder_item where id in (select purchaseorder_item_id from product_order_detail where receiveid=0))  ";
        }

        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (t.client_name ilike '%$q%' or t.client_name ilike '%$q%'  or t.po_no ilike '%$q%' or t.po_client_no ilike '%$q%')";
        }

        $query .= " order by t.id desc ";
        // echo $query;
        $result = array();
        $data = "";

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

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

    function create_from_po_editorial() {
        $id = $this->input->post('id');
        $query = "select purchaseordereditorial_crate_po($id)";
        if ($this->db->query($query)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function select_all_po_by_order_id($pi_id) {
        $query = "
            select 
            po.*,
            pi.order_id,
            pi.company_id,
            ven.code vendor_code,
            currency.code currency_code,
            ven.name vendor_name,
            ven.address vendor_address,
            (select count(*) from purchaseorder_item where purchaseorder_id=po.id and component_type_id in (1,2,3)) count_base
            from purchaseorder po
            left join proformainvoice pi on po.pi_id=pi.id
            join vendor ven on po.vendor_id=ven.id
            join currency on po.currency_id=currency.id 
            where po.pi_id=$pi_id
            order by po.id desc
        ";
//        echo $query;
        return $this->db->query($query)->result();
    }

    function select_by_id($id) {
        $query = " select 
            po.*,
            cli.code client_code,
            cli.name client_name,
            (select count(*) from purchaseorder_item where purchaseorder_id=po.id) count_base
            from purchaseorder po 
            join client cli on po.client_id=cli.id 
            where po.id=$id";
        //echo $query;
        return $this->db->query($query)->row();
    }

    function product_get() {
        $purchaseorderid = $this->input->post('purchaseorderid');
        if (empty($purchaseorderid)) {
            $purchaseorderid = 0;
        }

        $query = "select p.ebako_code,p.customer_code,p.packing_configuration,p.description,p.remarks,poi.finishing,p.material,"
                . "(select count(*) from product_order_detail where ship_date is not null and purchaseorder_item_id=poi.id) as total_shiped, "
                . "poi.* from purchaseorder_item poi LEFT JOIN products p ON p.id=poi.product_id where poi.purchaseorder_id='$purchaseorderid'";

        $q = $this->input->post('q');
        //echo $query;
        $result = array();

        $data = "";

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
            //echo $query;
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function product_select_by_po_id($po_id) {
        $query = "
             select pod.*,po.po_date,po.po_no,po.target_ship_date,
                cli.code client_code,cli.name client_name,
                poi.qty,poi.ebako_code,poi.customer_code,poi.remarks,poi.finishing,poi.material,poi.line,poi.description,poi.remarks,poi.tagfor 
                from product_order_detail pod
                left join purchaseorder_item poi on pod.purchaseorder_item_id=poi.id
                left join purchaseorder po on poi.purchaseorder_id=po.id
                left join client cli on po.client_id=cli.id
                where po.id=$po_id order by pod.id asc
        ";
//        echo $query;
        return $this->db->query($query)->result();
    }

    function product_select_top_base_by_po_id($po_id) {
        $query = "
          select t.*,
            component_type.name component_type,
            proformainvoice_product.special_instruction,
            products.image
            from purchaseorder_get_item_by_po_id($po_id)  
            t 
            left join component_type on t.component_type_id=component_type.id
            left join products on t.products_id=products.id
            left join proformainvoice_product_component on t.ppc_id=proformainvoice_product_component.id
            left join proformainvoice_product on proformainvoice_product_component.proformainvoice_product_id=proformainvoice_product.id
            where true and component_type.id in (1,2,3)  
        ";
        return $this->db->query($query)->result();
    }

    function product_select_by_po_id_and_component_type($po_id, $type) {
        $query = "
            select t.*,
            t.item_code product_code,
            t.item_description product_name,
            '' notes,
            proformainvoice.order_id,
            products.image,
            products.weight_net nett,
            products.weight_gross gross
            from purchaseorder_get_item_by_po_id($po_id) t 
            left join products on t.products_id = products.id 
            left join purchaseordereditorial on t.po_editorial_id=purchaseordereditorial.id
            left join proformainvoice on purchaseordereditorial.proformainvoice_id=proformainvoice.id
            where t.component_type_id=$type
        ";
//        echo $query . "<br/>";
        return $this->db->query($query)->result();
    }

    function select_top_released() {
        $query = " 
            with t as (
            select 
            po.*,
            pi.order_id,
            ven.code vendor_code,
            currency.code currency_code,
            ven.name vendor_name,
            (select count(*) from purchaseorder_item where purchaseorder_id=po.id and component_type_id in (1,2,3)) count_base
            from purchaseorder po
            left join proformainvoice pi on po.pi_id=pi.id
            join vendor ven on po.vendor_id=ven.id
            join currency on po.currency_id=currency.id  
            ) select t.* from t where count_base > 0 and release=true and close=false order by id asc limit 1
           ";
        return $this->db->query($query)->row();
    }

    function product_get_serial_number() {
        $purchaseorder_item_id = $this->input->post('purchaseorder_item_id');
        if ($purchaseorder_item_id > 0)
            $query = "select pod.* from product_order_detail pod where pod.purchaseorder_item_id=" . $purchaseorder_item_id . "";
        else {
            $purchaseorder_id = $this->input->post('purchaseorderid');
            $query = "select pod.* from product_order_detail pod "
                    . "LEFT JOIN purchaseorder_item poi ON pod.purchaseorder_item_id=poi.id "
                    . "LEFT JOIN purchaseorder po ON poi.purchaseorder_id=po.id "
                    . " where po.id=" . $purchaseorder_id . "";
        }

        $query .= " order by pod.id asc";
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

    function insert($data) {
        return $this->db->insert('purchaseorder', $data);
    }

    function update($data, $where) {
        return $this->db->update('purchaseorder', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('purchaseorder', $where);
    }

    function product_insert($data) {
        return $this->db->insert('purchaseorder_item', $data);
    }

    function product_update($data, $where) {
        return $this->db->update('purchaseorder_item', $data, $where);
    }

    function product_delete($where) {
        return $this->db->delete('purchaseorder_item', $where);
    }

}

?>
