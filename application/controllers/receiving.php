<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of receiving
 *
 * @author operational
 */
class receiving extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_receiving');
    }

    function index() {
        $this->load->view('receiving/index');
    }

    function view() {
        $this->load->view('receiving/view');
    }

    function get() {
        echo $this->model_receiving->get();
    }

    function input() {
        $this->load->view('receiving/input');
    }

    function save($id) {

        $do_date = $this->input->post('do_date');

        $data = array(
            "date" => $this->input->post('date'),
            "vendor_id" => $this->input->post('vendor_id'),
            "do_number" => $this->input->post('do_number'),
            "do_date" => (empty($do_date) ? null : $do_date),
            "wareouse_storeid" => $this->input->post('wareouse_storeid'),
            "remark" => $this->input->post('remark'),
        );

        if ($id == 0) {
            if ($this->model_receiving->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            if ($this->model_receiving->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        if ($this->model_receiving->delete(array("id" => $this->input->post("id")))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function detail_view() {
        $this->load->view('receiving/detail_view');
    }

    function detail_get() {
        echo $this->model_receiving->detail_get();
    }

    function detail_input() {
        $this->load->view('receiving/detail_input');
    }

    function detail_add_multi($vendor_id) {
        $this->load->view('receiving/detail_add_multi', array('vendor_id' => $vendor_id));
    }

    function detail_save_multi() {
        $receiveid = $this->input->post('receiveid');
        $serial_number = $this->input->post('serial_number');
        $data = array();
        for ($i = 0; $i < count($serial_number); $i++) {
            $data[] = array(
                "receivingid" => $receiveid,
                "serial_number" => $serial_number[$i]
            );
        }

        if ($this->model_receiving->detail_insert_batch($data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function detail_delete() {
        $id = $this->input->post('id');
        if ($this->model_receiving->detail_delete_batch_by_ids($id)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function get_vendor_unfinish_delivery() {
        echo $this->model_receiving->get_vendor_unfinish_delivery();
    }

    function detail_import() {
        $this->load->view('receiving/detail_import');
    }

    function detail_do_import($receivingid) {

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
                                "receivingid" => $receivingid,
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
                        "receivingid" => $receivingid,
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
                if ($this->db->insert_batch('receiving_detail', $row)) {
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

}
