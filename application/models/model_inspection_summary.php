<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_inspection_summary
 *
 * @author hp
 */
class model_inspection_summary extends CI_Model {

    //put your view_position here
    public function __construct() {
        parent::__construct();
    }

    function select_result() {
        $this->db->order_by("id", 'asc');
        return $this->db->get('inspection_summary')->result();
    }

     function get() {
        $datefrom = $this->input->post('date_is_start');
        $dateto = $this->input->post('date_is_to');
        $query = "select * from inspection  t where submited=true ";
        // echo $query;

        $q = $this->input->post('q');
        $q2 = $this->input->post('q2');
        
        if (!empty($q)) {            
            $query .= " and (t.client_name ilike '%$q%' or t.client_name ilike '%$q%' "
                    . "or t.po_client_no ilike '%$q%' or t.ebako_code ilike '%$q%' or t.customer_code ilike '%$q%')";
        }
        if (!empty($q2)) {            
            $query .= " and t.user_updated ilike'%$q2%'";
        }

        if (!empty($datefrom) && !empty($dateto)) {
            $query .= " and t.inspection_date between '$datefrom' and '$dateto'";
        }if (!empty($datefrom) && empty($dateto)) {
            $query .= " and  t.inspection_date = '$datefrom' ";
        }if (empty($datefrom) && !empty($dateto)) {
            $query .= " and  t.inspection_date = '$dateto' ";
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

    function selectAllResult() {
        return $this->db->get('inspection_summary')->result();
    }

    function select_by_id($id) {
        return $this->db->get_where('inspection_summary', array('id' => $id))->row();
    }

}

?>