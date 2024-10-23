<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of requestforsample
 *
 * @author operational
 */
class requestforsample extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_requestforsample');
    }

    function index() {
        $this->load->view('requestforsample/index');
    }

    function header() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 21));
        $this->load->view('requestforsample/header',$data);
    }

    function get() {
        echo $this->model_requestforsample->get();
    }

    function input() {
        $this->load->view('requestforsample/input');
    }

    function save($id) {
        $data = array(
            "company_id" => $this->input->post('company_id'),
            "date" => $this->input->post('date'),
            "vendor_id" => $this->input->post('vendor_id'),
            "notes" => $this->input->post('notes'),
        );
        if ($id == 0) {
            $data['user_inserted'] = $this->session->userdata('id');
            if ($this->model_requestforsample->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['time_updated'] = "now()";
            if ($this->model_requestforsample->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        if ($this->model_requestforsample->delete(array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function detail() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 21));
        $this->load->view('requestforsample/detail',$data);
    }

    function detail_get() {
        echo $this->model_requestforsample->detail_get();
    }

    function detail_input() {
        $this->load->view('requestforsample/detail_input');
    }

    function detail_save($id, $rfsid) {
        $data = array(
            "item_code" => $this->input->post('item_code'),
            "item_description" => $this->input->post('item_description'),
            "dimension" => $this->input->post('dimension'),
            "fabric_id" => (int) $this->input->post('fabric_id'),
            "qty" => $this->input->post('qty'),
            "due_date" => $this->input->post('due_date'),
            "notes" => $this->input->post('notes')
        );

        $material_id = $this->input->post('material_id');
        if (!empty($material_id)) {
            $data['material_id'] = "{" . implode(',', $material_id) . "}";
        }
        $color_id = $this->input->post('color_id');
        if (!empty($color_id)) {
            $data['color_id'] = "{" . implode(',', $color_id) . "}";
        }


        if ($id == 0) {
            $data['requestforsample_id'] = $rfsid;
            $data['user_inserted'] = $this->session->userdata('id');
            if ($this->model_requestforsample->detail_insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['time_updated'] = "now()";

            if ($this->model_requestforsample->detail_update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function detail_delete() {
        if ($this->model_requestforsample->detail_delete(array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function download() {
        $this->load->library('pdf');
        $id = $this->input->post('id');
        $data['rfs'] = $this->model_requestforsample->select_by_id($id);
        $data['rfs_detail'] = $this->model_requestforsample->select_detail_by_rfs_id($id);
        $this->load->view('requestforsample/download', $data);
    }

    function prints($id) {
        $data['rfs'] = $this->model_requestforsample->select_by_id($id);
        $data['rfs_detail'] = $this->model_requestforsample->select_detail_by_rfs_id($id);
        $this->load->view('requestforsample/print', $data);
    }

}
