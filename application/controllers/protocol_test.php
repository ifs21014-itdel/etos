<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class protocol_test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_protocol_test');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 42));
        $this->load->view('protocol_test/index', $data);
    }

    function get($flag = "") {
        echo $this->model_protocol_test->get($flag);
    }

    function input() {
        $this->load->view('protocol_test/input');
    }

    function save($id) {
        $last_file_name = $this->input->post('last_file_name');
        $data_variabel_test = array(
            "test_name" => $this->input->post('test_name'),
            "protocol_name" => $this->input->post('protocol_name'),
            "description" => $this->input->post('description'),
            "client_id" => $this->input->post('client_id')?$this->input->post('client_id'):0
        );
//        print_r($data_variabel_test);

        if ($id == 0) {
            $data_variabel_test['created_by'] = $this->session->userdata('id');
            if ($this->model_protocol_test->insert($data_variabel_test)) {
            echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {

            $data_variabel_test['updated_by'] = $this->session->userdata('id');
            $data_variabel_test['updated_at'] = "now()";
            if ($this->model_protocol_test->update($data_variabel_test, array("id" => $id))) {
//                if ($last_file_name != 'no-image.jpg') {
//                    //@unlink('./files/protocol_test_image/' . $last_file_name);
//                }
            echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function update_status() {
        if ($this->model_protocol_test->update(array("status" => $this->input->post("status")), array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update_price() {
        $this->load->view('protocol_test/update_price');
    }

    function do_update_price($id) {
        $data = array(
            "price" => (double) $this->input->post('price'),
            "price_house" => (double) $this->input->post('price_house'),
            "price_designer" => (double) $this->input->post('price_designer'),
            "currency_id" => $this->input->post('currency_id')
        );
        if ($this->model_protocol_test->update($data, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        $id = $this->input->post('id');
        if ($this->model_protocol_test->delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function copy() {
        $this->load->view('protocol_test/copy');
    }

    function do_copy($id) {
        $rnd_code = $this->input->post('rnd_code');
        $code = $this->input->post('code');
        $name = $this->input->post('name');
        $user_inserted = $this->session->userdata('id');
        if ($this->db->query("select protocol_test_do_copy($id,'$rnd_code','$code','$name',$user_inserted)")) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function load_image($image) {
        echo "<img src='files/protocol_test_image/" . $image . "' style='padding-top: 20px; max-width: 150px;max-height: 150px;'/>";
    }

    //------------------ for protocol_test box

    function variabel_test_index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 42));
        $this->load->view('protocol_test/variabel_test/index', $data);
    }

    function variabel_test_input() {
        $this->load->view('protocol_test/variabel_test/input');
    }

    function variabel_test_get() {
        echo $this->model_protocol_test->variabel_test_get();
    }

    function variabel_test_save($protocol_test_id, $id) {
        $data_box = array(
            'protocol_test_id' => $protocol_test_id,
            'evaluation' => $this->input->post('evaluation'),
            'method' => $this->input->post('method'),
            'description' => $this->input->post('description'),
            'mandatory' => $this->input->post('mandatory'),
            'var_type' => $this->input->post('var_type')
        );

        if ($id == 0) {
            $data['created_by'] = $this->session->userdata('id');
            if ($this->model_protocol_test->variabel_test_insert($data_box)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['updated_by'] = $this->session->userdata('id');
            $data['updated_at'] = date("Y-m-d H:i:s");
            if ($this->model_protocol_test->variabel_test_update($data_box, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function variabel_test_delete() {
        $id = $this->input->post('id');
        if ($this->model_protocol_test->variabel_test_delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }
    function download() {
        $data['protocol_test'] = $this->model_protocol_test->getall();
        
        //--------- UNtuk EXCEL ----
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"protocol_test.xls\"");
            header("Pragma: no-cache");
            header("Expires: 0");
        
            //$this->load->view('purchaseorder/generate_serial_number_excel', $data);
        //------------ END OF EXCEL
        $this->load->view('protocol_test/download', $data);
        //$this->load->view('purchaseorder/generate_serial_number2', $data);
    }


}
