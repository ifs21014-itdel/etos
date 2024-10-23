<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of productiontracking
 *
 * @author operational
 */
class productiontracking extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_productiontracking');
    }

    function index() {
        $this->load->view('productiontracking/index');
    }

    function purchaseorder() {
        $this->load->view('productiontracking/purchaseorder');
    }

    function purchaseorder_get() {
        
    }

    function purchaseorder_item() {
        $this->load->view('productiontracking/purchaseorder_item');
    }

    function purchaseorder_item_get() {
        
    }

    function product_list() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 40));
        $this->load->view('productiontracking/product_list', $data);
    }

    function product_list_get() {
        echo $this->model_productiontracking->product_list_get();
    }

    function update_status() {
        $this->load->view('productiontracking/update_status');
    }

    function import() {
        $this->load->view('productiontracking/import');
    }

    function do_import() {
        $production_process_id = $this->input->post('production_process_id');
        $date = $this->input->post('date');
        $notes = $this->input->post('notes');

        $this->load->helper("file");
        if (file_exists('./tempfile/process.csv')) {
            unlink('./tempfile/process.csv');
        }
        if (file_exists('./tempfile/process.txt')) {
            unlink('./tempfile/process.txt');
        }

        $file_element_name = 'inputfile';
        $config['upload_path'] = './tempfile/';
        $config['allowed_types'] = 'txt|csv';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['file_name'] = 'process';
        $this->load->library('upload', $config);

        $status = "";
        $msg = "";

        $row = array();

        if ($this->upload->do_upload($file_element_name)) {
            $file_uploaded = $this->upload->data();
            if ($file_uploaded['file_ext'] == ".csv") {
                $filePath = './tempfile/process.csv';
                if (($file = fopen($filePath, "r")) !== FALSE) {
                    while (($line = fgetcsv($file)) !== FALSE) {
                        //print_r($line)
                        if ($line != "") {
                            if ($this->model_productiontracking->is_valid_to_upload($production_process_id, $line[0])) {
                                //echo 'sa';
                                $row[] = array(
                                    "production_process_id" => $production_process_id,
                                    "serial_number" => $line[0],
                                    "date" => $date,
                                    "notes" => $notes
                                );
                            }
                        } else {
                            $status = "error";
                            $msg = "File contain error format";
                            break;
                        }
                    }
                    fclose($file);
                }
            } else {
                $filePath = './tempfile/process.txt';
                $file_handle = fopen($filePath, "r");
                while (!feof($file_handle)) {
                    $data_line = trim(fgets($file_handle));
                    if ($this->model_productiontracking->is_valid_to_upload($production_process_id, $data_line)) {
                        $row[] = array(
                            "production_process_id" => $production_process_id,
                            "serial_number" => $data_line,
                            "date" => $date,
                            "notes" => $notes
                        );
                    }
                }
                fclose($file_handle);
            }
            //
        } else {
            $status = 'error';
            $msg = $this->upload->display_errors('', '');
        }


        if ($status == "") {
            if (count($row) > 0) {
                $this->db->trans_start();
                if ($this->db->insert_batch('order_tracking', $row)) {
                    $status = "success";
                    $msg = "Import data successfull";
                } else {
                    $status = "error";
                    $msg = $this->db->_error_message();
                }
                $this->db->trans_complete();
            } else {
                $status = "warning";
                $msg = 'No Data to Import or some serial duplicate for selected Production Status';
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    function do_update_status() {
        $date = $this->input->post('date');
        $notes = $this->input->post('notes');
        $production_process_id = $this->input->post('production_process_id');
        $temp_serial_number = $this->input->post('serial_number');
        $serial_number = explode(',', $temp_serial_number);
        $data = array();
        for ($i = 0; $i < count($serial_number); $i++) {
            $data[] = array(
                "serial_number" => $serial_number[$i],
                "date" => $date,
                "production_process_id" => $production_process_id,
                "notes" => $notes
            );
        }

//        print_r($data);
        if ($this->db->insert_batch('order_tracking', $data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function project_progress() {
        $this->load->view('productiontracking/project_progress');
    }

    function load_chart($po_id = 0) {
        $this->load->model('model_purchaseorder');
        if (empty($po_id)) {
            $data['po'] = $this->model_purchaseorder->select_top_released();
        } else {
            $data['po'] = $this->model_purchaseorder->select_by_id($po_id);
        }
        if (empty($data['po'])) {
            echo "<center>Please select P.O</center>";
        } else {
            $this->load->view('productiontracking/load_chart', $data);
        }
    }

    function get_summary_tracking_performance($po_id) {

        $this->load->model('model_purchaseorder');

        $po = $this->model_purchaseorder->select_by_id($po_id);

        $query = "
          select 
          purchaseorder_item.id,
        products.code products_code,
        products.name products_name, 
        purchaseorder_item.purchaseorder_id,
        purchaseorder_item.products_id,
        purchaseorder_item.qty,
        tracking_get_po_item_performance(purchaseorder_item.id) progress
        from purchaseorder_item
        join products on purchaseorder_item.products_id=products.id
        where purchaseorder_item.component_type_id in (1,2,3)  
        and purchaseorder_item.purchaseorder_id=$po_id
        ";

        $rst = $this->db->query($query)->result();
        $data = array();
        $detail = array();
        $category = array();
        foreach ($rst as $result) {
            array_push($category, $result->products_code . '<br/>' . $result->products_name);
            $temp = array(
                "y" => $result->progress,
                "drilldown" => array(
                    "name" => $result->products_code . "<br>" . $result->products_name,
                    "color" => "#4572A7",
                    "categories" => $this->get_category_item_tracking($result->id),
                    "data" => $this->get_data_item_tracking($result->id),
                )
            );
            array_push($data, $temp);
        }

        $temp_data = array(
            "name" => "<b>PO:</b> " . $po->po_no . "<b>, Date: </b>" . date('d F Y', strtotime($po->date)) . ", <b>Vendor: </b>" . $po->vendor_name,
            "colorByPoint" => true,
            "categories" => $category,
            "data" => $data
        );

//        echo json_encode(array("main" => $data, "detail" => $detail), JSON_NUMERIC_CHECK);
        echo json_encode($temp_data, JSON_NUMERIC_CHECK);
    }

    function get_detail_item_tracking($po_detail_id) {
        $query = "
          with t as (
                select 
                product_order_detail.*,
                (select production_process_id from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) production_process_id
                from product_order_detail
                where true order by product_order_detail.id asc
        ) select t.*,production_process.name production_process_name,production_process.percent production_process_percent
          from t
          left join production_process on t.production_process_id=production_process.id
          where t.purchaseorder_item_id=$po_detail_id
        ";

        //echo $query;
        $order_detail = $this->db->query($query)->result();
        $data_detail = array();
        foreach ($order_detail as $result) {
            array_push($data_detail, array($result->serial_number, $result->production_process_percent));
        }
        return $data_detail;
    }

    function get_category_item_tracking($po_detail_id) {
        $query = "
          with t as (
                select 
                product_order_detail.*,
                (select production_process_id from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) production_process_id
                from product_order_detail
                where true order by product_order_detail.id asc
        ) select t.*,production_process.name production_process_name,production_process.percent production_process_percent
          from t
          left join production_process on t.production_process_id=production_process.id
          where t.purchaseorder_item_id=$po_detail_id order by t.id asc;
        ";

        //echo $query;
        $order_detail = $this->db->query($query)->result();
        $data_detail = array();
        foreach ($order_detail as $result) {
            array_push($data_detail, $result->serial_number);
        }
        return $data_detail;
    }

    function get_data_item_tracking($po_detail_id) {
        $query = "
          with t as (
                select 
                product_order_detail.*,
                (select production_process_id from order_tracking where serial_number=product_order_detail.serial_number order by id desc limit 1) production_process_id
                from product_order_detail
                where true order by product_order_detail.id asc
        ) select t.*,production_process.name production_process_name,production_process.percent production_process_percent
          from t
          left join production_process on t.production_process_id=production_process.id
          where t.purchaseorder_item_id=$po_detail_id order by t.id asc;
        ";

        //echo $query;
        $order_detail = $this->db->query($query)->result();
        $data_detail = array();
        foreach ($order_detail as $result) {
            array_push($data_detail, $result->production_process_percent);
        }
        return $data_detail;
    }

    function export_to_excel() {
        $this->load->library('excel');
        $data['data'] = $this->model_productiontracking->product_list_get("result");
        $this->load->view('productiontracking/export_to_excel', $data);
    }

}
