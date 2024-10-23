<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_vendor
 *
 * @author hp
 */
class model_vendor extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get($flag = '') {

        $query = "
            select vendor.*,country.common_name country,currency.code currency_code,
            (case when vendor.flag = 0 then 'Supplier' else 'Internal Warehouse' end) vendor_type from vendor 
            join country on vendor.country_id=country.id join currency on vendor.currency_id=currency.id where true 
        ";

        $q = $this->input->post('q');
        if (!empty($q)) {
            $query .= " and (vendor.code ilike '%$q%' or vendor.name ilike '%$q%') ";
        } if ($flag == 'iw') {
            $query .= " and vendor.flag = 1";
        }
        
        /*else {
            $query .= " and vendor.flag = 0";
        }*/

        $query .= " order by id desc ";

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

    function selectAllResult() {
        return $this->db->get('vendor')->result();
    }

    function insert($data) {
        return $this->db->insert('vendor', $data);
    }

    function update($data, $where) {
        return $this->db->update('vendor', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('vendor', $where);
    }

}

?>
