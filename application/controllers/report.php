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
        $data["category"] = $category;

        if ($category == "pi" || $category == "shipment") {
            $query = "
          select t.*,c.code client_code,c.name client_name,ctry.id country_id,ctry.common_name country_common_name from (
            select 
            sum(pi_p.qty) total_qty,
            sum(pi_p.line_total) total_value,
            pi.client_id,pi.order_id,
            pi.id
            from proformainvoice_product pi_p
            left join proformainvoice pi on pi_p.proformainvoice_id=pi.id
            where pi.order_confirm_date between '$date_from' and '$date_to' 
            group by pi.client_id,pi.order_id,pi.id 
            ) t join client c on t.client_id=c.id
                join country ctry on c.country_id=ctry.id
                where ctry.id=77  
        ";
        } else if ($category == "client") {
            $query = "
          select t.*,c.code client_code,c.name client_name,ctry.id country_id,ctry.common_name country_common_name from (
            select 
            sum(pi_p.qty) total_qty,
            sum(pi_p.line_total) total_value,
            pi.client_id 
            from proformainvoice_product pi_p
            left join proformainvoice pi on pi_p.proformainvoice_id=pi.id
            where pi.order_confirm_date between '$date_from' and '$date_to' 
            group by pi.client_id 
            ) t join client c on t.client_id=c.id
                join country ctry on c.country_id=ctry.id
                where ctry.id=77  
        ";
        }

        // echo $query;
        $data["order"] = $this->db->query($query)->result();
        if ($flag == 'excel') {
            $this->load->library('excel');
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"rekap.xls\"");
            header("Pragma: no-cache");
            header("Expires: 0");
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
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"rekap.xls\"");
            header("Pragma: no-cache");
            header("Expires: 0");
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
        $companyid = $this->input->post("client_id");
        $query = "select sh.*,cl.code as client_code,cl.name as client_name,cl.company as client_company "
                . "from shipment sh "
                . "JOIN client cl ON sh.client_id=cl.id  where true  and sh.date between '$date_from' and '$date_to'";
        $data["company"] = $companyid;
        if (!empty($companyid))
            $query .= " and po.client_id='" . $companyid . "' ";
        //echo $query;
        $data["order"] = $this->db->query($query)->result();
        if ($flag == 'excel') {
            // $this->load->library('excel');

            $this->load->library('excel');
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"rekap.xls\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('report/sales/client_sales_print', $data);
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
        $jenis_report = $this->input->post("jenis_report_s");
        // echo $jenis_report;
        $data["date_from"] = $date_from;
        $data["date_to"] = $date_to;
        $data["jenis_report"] = $jenis_report;
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
        if ($jenis_report == "topten") {
            $query = "select p.code,p.name,pt.description, sum(pr.qty) as total,sum(pr.line_total) as total_price,c.code currency_code
                from products as p 
                LEFT JOIN proformainvoice_product as pr ON p.id=pr.products_id 
                LEFT JOIN proformainvoice as pi ON pi.id=pr.proformainvoice_id 
                LEFT JOIN currency c ON p.currency_id=c.id 
                LEFT join product_type pt on p.product_type_id=pt.id
                where pi.order_confirm_date between '$date_from' and '$date_to'
                group by pr.products_id,p.code,p.name,pt.description,c.code order by total desc
        ";
        }
        //echo $query;
        $data["order"] = $this->db->query($query)->result();
        if ($flag == 'excel') {
            $this->load->library('excel');
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"rekap.xls\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('report/sales/product_sales_excel', $data);
            //$this->load->view('report/sales/product_sales_print', $data);
        } else {
            $this->load->view('report/sales/product_sales_print', $data);
        }
    }

    function poreport() {
        $this->load->View('report/purchase_order/poreport');
    }

    function podetail_report() {
        $this->load->View('report/purchase_order/podetail_report');
    }

    function purchase_order() {
        $this->load->view("report/purchase_order/index");
    }

    function purchase_order_generate($flag) {
        $datefrom = $this->input->post("date_from");
        $dateto = $this->input->post("date_to");
        $companyid = $this->input->post("client_id");
        $currencyid = $this->input->post("currency_id");
        $data["date_from"] = $datefrom;
        $data["date_to"] = $dateto;
        $data["company"] = $companyid;
        $query = "
             select  po.*,v.name as vendor_name from purchaseorder po 
                        left join client v on po.client_id=v.id 
                        where true  and po.po_date between '$datefrom' and '$dateto'";
        if (!empty($companyid))
            $query .= " and po.client_id='" . $companyid . "' ";
        $query .= " order by po.po_date";
        // echo $query;
        //   var_dump($query);

        $data["order"] = $this->db->query($query)->result();
        //   var_dump($data);
        if ($flag == 'excel') {
            $this->load->library('excel');
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"rekap.xls\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('report/purchase_order/print', $data);
        } else {
            $this->load->view('report/purchase_order/print', $data);
        }
    }

    function purchase_order_detail_generate($flag) {
        $datefrom = $this->input->post("date_from");
        $dateto = $this->input->post("date_to");
        $companyid = $this->input->post("client_id");
        $currencyid = $this->input->post("currency_id");
        $data["date_from"] = $datefrom;
        $data["date_to"] = $dateto;
        $data["company"] = $companyid;
        $data["currency"] = $currencyid;
        $query = "
                        select  
                        products.id products_id,
                        products.code product_code,
                        products.name product_name,
                        purchaseorder.id purchaseorder_id,
                        purchaseorder.*,
                        purchaseorder.date po_date,
                        vendor.name vendor_name,
                        purchaseorder_item.*,
                        pi.order_id,
                        currency.code as curr_code
                        from purchaseorder 
                        left join vendor on purchaseorder.vendor_id=vendor.id
                        left join proformainvoice as pi on purchaseorder.pi_id=pi.id 
                        left join purchaseorder_item on  purchaseorder_item.purchaseorder_id=purchaseorder.id
                        left join currency on  purchaseorder.currency_id=currency.id
                        left join products on  purchaseorder_item.products_id=products.id 
                        where true  and purchaseorder.date between '$datefrom' and '$dateto' ";
        // var_dump($query);
        if (!empty($companyid))
            $query .= " and purchaseorder.vendor_id='" . $companyid . "' ";
        if (!empty($currencyid))
            $query .= " and purchaseorder.currency_id='$currencyid' ";
        //var_dump($query);

        $data["order"] = $this->db->query($query)->result();
        //   var_dump($data);
        if ($flag == 'excel') {
            $this->load->library('excel');
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"rekap.xls\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('report/purchase_order/excel_detail', $data);
        } else {
            $this->load->view('report/purchase_order/print_detail', $data);
        }
    }

}
