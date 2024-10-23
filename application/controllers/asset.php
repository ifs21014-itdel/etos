<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of asset
 *
 * @author Bernovan Munte <bernovanmunte@gmail.com>
 */
class asset extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_asset');
    }

    public function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 817));
        $this->load->view("asset/index", $data);
    }

    public function get() {
        echo $this->model_asset->get();
    }

    function input() {
        $this->load->view("asset/input");
    }

    function save($id = 0) {
        $data = array(
            "item_code" => $this->input->post("item_code"),
            "item_description" => $this->input->post("item_description"),
            "class" => $this->input->post("class"),
            "depreciation_percentage" => (double) $this->input->post("depreciation_percentage"),
            "date_of_acquisition" => empty_to_null($this->input->post("date_of_acquisition")),
            "acquisition_cost" => (double) $this->input->post("acquisition_cost"),
            "depreciation_expense" => (double) $this->input->post("acquisition_cost")
        );
        if ($id == 0) {
            if ($this->model_asset->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            if ($this->model_asset->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        $id = $this->input->post("id");
        if ($this->model_asset->delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function prints() {
        $id = $this->input->post("id");
        $data['asset'] = $this->model_asset->select_by_id($id);
        $this->load->view("asset/print", $data);
    }

}
