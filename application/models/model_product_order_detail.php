<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_product_order_detail
 *
 * @author operational
 */
class model_product_order_detail extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function select_all_by_po_id($po_id) {
        $query = "
                select pod.*,po.po_date,po.po_no,po.po_client_no,po.target_ship_date, cli.code client_code,cli.name client_name, 
                poi.qty,p.packing_configuration,p.ebako_code,p.customer_code,p.remarks,poi.finishing,p.material 
                from product_order_detail pod left join purchaseorder_item poi on pod.purchaseorder_item_id=poi.id 
                left join purchaseorder po on poi.purchaseorder_id=po.id 
                LEFT JOIN products p on poi.product_id=p.id
                left join client cli on po.client_id=cli.id
                where po.id=$po_id order by pod.id asc
        ";
      //  echo $query;
        return $this->db->query($query)->result();
    }

}
