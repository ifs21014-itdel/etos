<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of stock
 *
 * @author operational
 */
class stock extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_stock');
    }

    function index() {
        $this->load->view('stock/index');
    }

    function detail() {
        $data['component_type'] = $this->db->query("select * from component_type where id in (1,2,3,10) order by id asc")->result();
        $this->load->view('stock/detail', $data);
    }

    function summary() {
        $data['component_type'] = $this->db->query("select * from component_type where id in (1,2,3,10) order by id asc")->result();
        $this->load->view('stock/summary', $data);
    }

    function summary_get() {
        echo $this->model_stock->summary_get();
    }

    function summary_export_to_excel() {
        $this->load->library('excel');
        $data["stock"] = $this->model_stock->summary_get("result");
        $this->load->view('stock/summary_export_to_excel', $data);
    }

    function get() {
        echo $this->model_stock->get();
    }

    function get_available_to_shipment($client_id) {
        echo $this->model_stock->get_available_to_shipment($client_id);
    }

    function export_to_excel() {
        $this->load->library('excel');
        $data["stock"] = $this->model_stock->get("result");
//        var_dump($data["stock"]);
        $this->load->view('stock/export_to_excel', $data);
    }

}
