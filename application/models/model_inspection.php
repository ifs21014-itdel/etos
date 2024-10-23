<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_inspection
 *
 * @author user
 */
class model_inspection extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get() {
       // $query = "select * from inspection  t where submited=false  ";
        $today=date('Y-m-d');
        $query = "select * from inspection  t where  (inspection_date='$today' or inspection_date is NULL) ";
         //echo $query;

        $q = $this->input->post('inspection_code_s');
        
        if (!empty($q)) {            
            $query .= " and (t.client_name ilike '%$q%' or t.client_name ilike '%$q%' "
                    . "or t.po_client_no ilike '%$q%' or t.ebako_code ilike '%$q%' or t.customer_code ilike '%$q%')";
        }
        $q2 = $this->input->post('status_inspection_id');
        if (!empty($q2)) {            
            $query .= " and t.submited='".$q2."'";
        }

        $query .= " order by t.updated_time desc ";
        //echo $query;
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

    function select_by_id($id) {
        $query = " select ins.* from inspection ins where ins.id=$id";
       // echo $query;
        return $this->db->query($query)->row();
    }

    function inspection_detail_get() {
        $inspectionid = $this->input->post('inspectionid');
        if (empty($inspectionid)) {
            $inspectionid = 0;
        }

        $query = "select id.*,id.filename filename_detail,ic.view_position,ic.description,ic.mandatory,ins.submited from inspection_detail id "
                . " JOIN image_category ic on id.image_category_id=ic.id "
                . " JOIN inspection ins on id.isnpection_id=ins.id "
                . " where id.isnpection_id='$inspectionid'";

        $q = $this->input->post('q');
        //echo $query;
        $result = array();

        $data = "";

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');

        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " order by id limit $rows offset $offset";
            //echo $query;
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function inspection_detil_get_byid($inspection_id,$id,$image_category_id) {
        $query = "select ins.inspection_date,ins.ebako_code,ins.customer_code,ins.client_name,ins.po_client_no,"
                . "id.*,id.filename filename_detail,ic.view_position,ic.description,ic.mandatory from inspection ins "
                . "JOIN inspection_detail id ON ins.id=id.isnpection_id "
                . " JOIN image_category ic on id.image_category_id=ic.id where ins.id='$inspection_id' and id.id=$id";

        return $this->db->query($query)->result();
    }

    function insert($data) {
        return $this->db->insert('inspection', $data);
    }

    function update($data, $where) {
        return $this->db->update('inspection', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('inspection', $where);
    }

    function product_insert($data) {
        return $this->db->insert('inspection_detail', $data);
    }

    function product_update($data, $where) {
        return $this->db->update('inspection_detail', $data, $where);
    }

    function product_delete($where) {
        return $this->db->delete('inspection_detail', $where);
    }

    function select_image_category_by_inspection_id($inspectionid) {
       
        $query = "select id.*,ic.view_position,ic.description,ic.mandatory from inspection_detail id "
                . " JOIN image_category ic on id.image_category_id=ic.id where id.isnpection_id='$inspectionid'";
        return $this->db->query($query)->result();
    }
    function get_item_po() {
        $query = "select poi.*,c.name client_name,po.po_client_no,p.ebako_code,p.customer_code,c.id client_id,p.description,p.material,p.finishing "
                . " from purchaseorder_item poi"
                . " JOIN purchaseorder po on po.id=poi.purchaseorder_id "
                . " JOIN products p on poi.product_id=p.id "
                . " JOIN client c on c.id=po.client_id where poi.inspected='FALSE' and poi.id not in (select purchaseorder_item_id from inspection) ";

        //----------- search parameter for grid ----------------------
        $q = strtolower($this->input->post('q'));
        if (!empty($q)) {
            $query .= " AND (LOWER(p.ebako_code) LIKE '%" . $q . "%' OR LOWER(p.customer_code) LIKE '%" . $q . "%' or po.po_client_no like '%" . $q . "%')";
        }
        //----------------------
        $query .= " order by poi.id";
        //echo $query;
        $result = array();
        $data = "";
            $data = json_encode($this->db->query($query)->result());
        return $data;
    }
    
    function update_po_item_status($po_item_id) {
        $data = array(
            "inspected" => 't'
        );
        $where = array("id" => $po_item_id);
        $this->db->update('purchaseorder_item', $data, $where);
    }
}

?>
