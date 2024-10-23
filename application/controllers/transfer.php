<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transfer
 *
 * @author operational
 */
class transfer extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_transfer');
    }

    function index() {
        $this->load->view('transfer/index');
    }

    function header() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 63));
        $this->load->view('transfer/header', $data);
    }

    function get() {
        echo $this->model_transfer->get();
    }

    function input() {
        $this->load->view('transfer/input');
    }

    function save($id) {

        $data = array(
            "date" => $this->input->post('date'),
            "source_id" => $this->input->post('source_id'),
            "target_id" => $this->input->post('target_id'),
            "description" => $this->input->post('description'),
            "user_inserted" => $this->session->userdata('id')
        );

        if ($data["source_id"] == $data["target_id"]) {
            echo json_encode(array('msg' => 'Source and target must be different'));
            exit();
        }

        if ($id == 0) {
            if ($this->model_transfer->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            if ($this->model_transfer->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        if ($this->model_transfer->delete(array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function detail() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 63));
        $this->load->view('transfer/detail',$data);
    }

    function detail_get() {
        echo $this->model_transfer->detail_get();
    }

    function detail_add($source_id) {
        $this->load->view('transfer/detail_input', array(
            'source_id' => $source_id
        ));
    }

    function detail_save() {
        $transfer_id = $this->input->post('transfer_id');
        $serial_number = $this->input->post('serial_number');
        $data = array();
        for ($i = 0; $i < count($serial_number); $i++) {
            $data[] = array(
                "transfer_id" => $transfer_id,
                "serial_number" => $serial_number[$i]
            );
        }

        if ($this->model_transfer->detail_insert_batch($data)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function detail_import() {
        $this->load->view('transfer/detail_import');
    }

    function detail_do_import($transferid) {

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
                                "transfer_id" => $transferid,
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
                        "transfer_id" => $transferid,
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
                if ($this->db->insert_batch('transfer_detail', $row)) {
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

    function detail_delete() {
        $id = $this->input->post('id');
        if ($this->model_transfer->detail_delete_batch_by_ids($id)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}
