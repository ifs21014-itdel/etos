<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of report
 *
 * @author operational
 */
class report extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    function index() {
        
    }

    function sales() {
        $this->load->view("report/sales/index");
    }

    function local_global_sales() {
        $this->load->view("report/sales/local_global_sales");
    }

    function local_global_sales_generate($flag) {

        $date_from = $this->input->post("date_from");
        $date_to = $this->input->post("date_to");
        $category = $this->input->post("report_type");
       // echo "-----------------------".$category;
        $data["date_from"] = $date_from;
        $data["date_to"] = $date_to;
        $query = "
          select t.*,c.code client_code,c.name client_name,ctry.id country_id,ctry.common_name country_common_name from (
            select 
            sum(pi_p.qty) total_qty,
            pi.client_id
            from proformainvoice_product pi_p
            join proformainvoice pi on pi_p.proformainvoice_id=pi.id
            group by pi.client_id
            ) t join client c on t.client_id=c.id
                join country ctry on c.country_id=ctry.id
                where ctry.id=77  
        ";
        $data["order"] = $this->db->query($query)->result();
        if ($flag == 'excel') {
            $this->load->library('excel');
            $this->load->view('report/sales/local_global_sales_excel', $data);
        } else {
            $this->load->view('report/sales/local_global_sales_print', $data);
        }
    }

    function export_global_sales() {
        $this->load->view("report/sales/export_global_sales");
    }

    function export_global_sales_generate($flag) {

        $date_from = $this->input->post("date_from");
        $date_to = $this->input->post("date_to");
        $data["date_from"] = $date_from;
        $data["date_to"] = $date_to;

        $query = "
          select t.*,c.code client_code,c.name client_name,ctry.id country_id,ctry.common_name country_common_name from (
            select 
            sum(pi_p.qty) total_qty,
            pi.client_id
            from proformainvoice_product pi_p
            join proformainvoice pi on pi_p.proformainvoice_id=pi.id
            group by pi.client_id
            ) t join client c on t.client_id=c.id
                join country ctry on c.country_id=ctry.id
                where ctry.id!=77  
        ";
        $data["order"] = $this->db->query($query)->result();
        if ($flag == 'excel') {
            $this->load->library('excel');
            $this->load->view('report/sales/export_global_sales_excel', $data);
        } else {
            $this->load->view('report/sales/export_global_sales_print', $data);
        }
    }

    function global_client_sales() {
        $this->load->View('report/sales/global_client_sales');
    }

    function global_client_sales_generate($flag) {

        $date_from = $this->input->post("date_from");
        $date_to = $this->input->post("date_to");
        $data["date_from"] = $date_from;
        $data["date_to"] = $date_to;

        $query = "
          select t.*,c.code client_code,c.name client_name,ctry.id country_id,ctry.common_name country_common_name from (
            select 
            sum(pi_p.qty) total_qty,
            pi.client_id
            from proformainvoice_product pi_p
            join proformainvoice pi on pi_p.proformainvoice_id=pi.id
            group by pi.client_id
            ) t join client c on t.client_id=c.id
                join country ctry on c.country_id=ctry.id
                where ctry.id!=77  
        ";

        $data["order"] = $this->db->query($query)->result();
        if ($flag == 'excel') {
            $this->load->library('excel');
            $this->load->view('report/sales/global_client_sales_excel', $data);
        } else {
            $this->load->view('report/sales/global_client_sales_print', $data);
        }
    }

    function client_sales() {
        $this->load->View('report/sales/client_sales');
    }

    function client_sales_generate($flag) {

        $date_from = $this->input->post("date_from");
        $date_to = $this->input->post("date_to");
        $data["date_from"] = $date_from;
        $data["date_to"] = $date_to;

        $query = "
          select t.*,c.code client_code,c.name client_name,ctry.id country_id,ctry.common_name country_common_name from (
            select 
            sum(pi_p.qty) total_qty,
            pi.client_id
            from proformainvoice_product pi_p
            join proformainvoice pi on pi_p.proformainvoice_id=pi.id
            group by pi.client_id
            ) t join client c on t.client_id=c.id
                join country ctry on c.country_id=ctry.id
                where ctry.id!=77  
        ";

        $data["order"] = $this->db->query($query)->result();
        if ($flag == 'excel') {
            $this->load->library('excel');
            $this->load->view('report/sales/client_sales_excel', $data);
        } else {
            $this->load->view('report/sales/client_sales_print', $data);
        }
    }

    function product_sales() {
        $this->load->View('report/sales/product_sales');
    }

    function product_sales_generate($flag) {

        $date_from = $this->input->post("date_from");
        $date_to = $this->input->post("date_to");
        $data["date_from"] = $date_from;
        $data["date_to"] = $date_to;

        $query = "
        select p.code product_code,p.name product_name,pt.description product_type_name,t.*,c.code currency_code from (
                select
                pi_p.products_id,
                pi.order_id,
                pi.id pi_id,
                pi.currency_id,
                sum(pi_p.line_total) line_total
                from proformainvoice_product pi_p
                join proformainvoice pi on pi_p.proformainvoice_id=pi.id
                where pi.order_confirm_date between '$date_from' and '$date_to'
                group by pi_p.products_id,pi.id,pi.currency_id
        ) t join products p on t.products_id=p.id
                join product_type pt on p.product_type_id=pt.id
                join currency c on t.currency_id=c.id
        ";

//        echo $query;
        $data["order"] = $this->db->query($query)->result();
        if ($flag == 'excel') {
            $this->load->library('excel');
            $this->load->view('report/sales/product_sales_excel', $data);
        } else {
            $this->load->view('report/sales/product_sales_print', $data);
        }
    }

    function purchase_order() {
        $this->load->view("report/purchase_order/index");
    }

    function purchase_order_generate($flag) {
        $data["date_from"] = $this->input->post("date_from");
        $data["date_to"] = $this->input->post("date_to");
        if ($flag == 'excel') {
            $this->load->library('excel');
            $this->load->view('report/purchase_order/excel', $data);
        } else {
            $this->load->view('report/purchase_order/print', $data);
        }
    }

}
