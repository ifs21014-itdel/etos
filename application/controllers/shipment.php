<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shipment
 *
 * @author operational
 */
class shipment extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_shipment');
    }

    function index() {
        $this->load->view('shipment/index');
    }

    function view() {
        $this->load->view('shipment/view');
    }

    function get() {
        echo $this->model_shipment->get();
    }

    function input() {
        $this->load->view('shipment/input');
    }

    function save($id) {
        $data = array(
            "date" => $this->input->post('date'),
            "shipment_source" => $this->input->post('shipment_source'),
            "client_id" => (int) $this->input->post('client_id'),
            "container_no" => $this->input->post('container_no'),
            "seal_no" => $this->input->post('seal_no'),
            "loadibility" => $this->input->post('loadibility'),
            "description_of_goods" => $this->input->post('description_of_goods'),
            "ship_address" => $this->input->post('ship_address'),
            "ship_phone_fax" => $this->input->post('ship_phone_fax'),
            "ship_email" => $this->input->post('ship_email'),
            "ship_contact_name" => $this->input->post('ship_contact_name'),
            "ship_port_of_loading" => $this->input->post('ship_port_of_loading'),
            "ship_port_of_destination" => $this->input->post('ship_port_of_destination'),
            "tally_user" => $this->input->post('tally_user')
        );

        if ($id == 0) {
            if ($this->model_shipment->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            if ($this->model_shipment->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        if ($this->model_shipment->delete(array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function summarize_view() {
        $this->load->view('shipment/summarize_view');
    }

    function summarize_get() {
        echo $this->model_shipment->summarize_get();
    }

    function detail_view() {
        $this->load->view('shipment/detail_view');
    }

    function detail_get() {
        echo $this->model_shipment->detail_get();
    }

    function detail_add($client_id, $shipment_id) {

        $this->load->view('shipment/detail_add', array(
            'client_id' => $client_id,
            'shipment_id' => $shipment_id)
        );
    }

    function detail_add_scan_barcode() {
        $this->load->view('shipment/detail_add_scan_barcode');
    }

    function submit() {
        $id = $this->input->post('id');
        $error_message = "";
        $status = $this->db->query("select update_product_order_detail_shipdate_new($id)")->result();
        $kelengkapan = $status[0]->update_product_order_detail_shipdate_new;
        //echo 'kelengkapan=' . $kelengkapan;
        if ($kelengkapan == 'BENAR') {
            if ($this->model_shipment->update(array("submited" => 'TRUE'), array("id" => $id))) {
                $this->db->query("select update_product_order_detail_shipdate_new($id)");
                echo json_encode(array('success' => true));
            } else {
                $error_message = $this->db->_error_message();
                echo json_encode(array('msg' => $error_message));
            }
        } else {
            $error_message = $kelengkapan;
            echo json_encode(array('msg' => $error_message));
        }
    }

    function detail_save() {
        $shipmentid = $this->input->post('shipmentid');
        $serial_number = $this->input->post('serial_number');
        $data = array();
        for ($i = 0; $i < count($serial_number); $i++) {
            $data[] = array(
                "shipmentid" => $shipmentid,
                "serial_number" => $serial_number[$i]
            );
        }

        if ($this->model_shipment->detail_insert_batch($data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function save_detail_scan_barcode($id) {
        $shipmentid = $id;
        
        $serial_temp= explode('#-#',$this->input->post('serial_number_scan'));
        $serial_number=$serial_temp[0];
        
        //$serial_number = $this->input->post('serial_number_scan');
        
        //--- check serial number 
        $sql_check = "select s.client_id,pod.serial_number from shipment s 
            JOIN product_order_detail pod ON s.client_id=pod.client_id 
            where pod.serial_number='$serial_number'";

        $eks = $this->db->query($sql_check)->result();
        //echo "total=".count($eks);
        // exit;
        if (count($eks) == 0) {
            echo json_encode(array('msg' => 'Maaf Serial Number yang anda loading tidak sesuai'));
        } else {
            $data = array();
            $data[0] = array(
                "shipmentid" => $shipmentid,
                "serial_number" => $serial_number
            );
            // var_dump($data);
            //  exit;
            if ($this->model_shipment->detail_insert_batch($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function detail_delete() {
        $id = $this->input->post('id');
        if ($this->model_shipment->detail_delete_batch_by_ids($id)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function detail_import() {
        $this->load->view('shipment/detail_import');
    }

    function detail_do_import($shipmentid) {

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
                            $row[] = array(
                                "shipmentid" => $shipmentid,
                                "serial_number" => $line[0]
                            );
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
                    $row[] = array(
                        "shipmentid" => $shipmentid,
                        "serial_number" => $data_line
                    );
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
                if ($this->db->insert_batch('shipment_detail', $row)) {
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

    function prints() {
        $id = $this->input->post('id');
        $this->load->library('pdf');
        $data['shipment'] = $this->model_shipment->select_by_id($id);
        $data['shipment_item'] = $this->model_shipment->select_product_by_shipment_id($id);
        $this->load->view('shipment/print', $data);
    }
    function print_summary() {
        $id = $this->input->post('id');
        $this->load->library('pdf');
        $data['shipment'] = $this->model_shipment->select_by_id($id);
        $data['shipment_item'] = $this->model_shipment->select_summarize_by_shipment_id($id);
        $this->load->view('shipment/print_summary', $data);
    }

    function commercial_invoice() {
        $id = $this->input->post('id');
        $this->load->library('pdf');
        $data['shipment'] = $this->model_shipment->select_by_id($id);
        $data['shipment_item'] = $this->model_shipment->select_summarize_by_shipment_id($id);
        $this->load->view('shipment/commercial_invoice', $data);
    }

}
