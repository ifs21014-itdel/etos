<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of invoice
 *
 * @author Bernovan Munte <bernovanmunte@gmail.com>
 */
class invoice extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_invoice');
    }

    public function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 815));
        $this->load->view("invoice/index", $data);
    }

    public function get() {
        echo $this->model_invoice->get();
    }

    function input($type) {
//        if ($type == "dp") {
//            $this->load->view("invoice/input_dp");
//        } else if ($type == "sp") {
//            $this->load->view("invoice/input_sp");
//        } else {
//            $this->load->view("invoice/input_fp");
//        }
        $this->load->view("invoice/input");
    }

    function save($id = 0) {
        $data = array(
            "date" => $this->input->post("date"),
            "proforma_invoice_id" => $this->input->post("proforma_invoice_id"),
            "po_no" => $this->input->post("po_no"),
            "contact_name" => $this->input->post("contact_name"),
            "ship_to" => $this->input->post("ship_to"),
            "bank_account_id" => $this->input->post("bank_account_id"),
            "description" => $this->input->post("description"),
            "order_amount" => $this->input->post("order_amount"),
            "down_payment" => $this->input->post("down_payment"),
            "amount" => $this->input->post("amount"),
            "tax" => empty_to_null($this->input->post("tax")),
            "amount_percent" => $this->input->post("amount_percent"),
            "amount_due" => $this->input->post("amount_due"),
            "order_description" => empty_to_null($this->input->post("order_description")),
            "order_amount_percentage" => empty_to_null($this->input->post("order_amount_percentage")),
            "total_order" => empty_to_null($this->input->post("total_order")),
            "dp_receive_description" => empty_to_null($this->input->post("dp_receive_description")),
            "dp_receive_amount" => empty_to_null($this->input->post("dp_receive_amount")),
            "ppn_flag" => empty_to_null($this->input->post("ppn_flag")),
            "type" => $this->input->post("type"),
        );
//        exit;
        if ($id == 0) {
            $data["type"] = $this->input->post("type");
            if ($this->model_invoice->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            if ($this->model_invoice->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        $id = $this->input->post("id");
        if ($this->model_invoice->delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function prints() {
        $this->load->model('model_proformainvoice');
        $id = $this->input->post("id");
        $pi_id = $this->input->post("pi_id");
        $type = $this->input->post("type");
        $this->load->library('pdf');
        $data['invoice'] = $this->model_invoice->select_by_id($id);
        $data['products'] = $this->model_proformainvoice->product_select_by_proformainvoice_id($pi_id);
//        if ($type == "sp") {
//            $this->load->view("invoice/print_sp", $data);
//        } else {
        $this->load->view("invoice/print2", $data);
//        }
    }

}
