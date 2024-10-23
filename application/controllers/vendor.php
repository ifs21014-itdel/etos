<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vendor
 *
 * @author user
 */
class vendor extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_vendor');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 23));
        $this->load->view('vendor/index', $data);
    }

    function get($flag = '') {
        echo $this->model_vendor->get($flag);
    }

    function input() {
        $this->load->view('vendor/input');
    }

    function save($id) {

        $data = array(
            "code" => $this->input->post('code'),
            "name" => $this->input->post('name'),
            "currency_id" => $this->input->post('currency_id'),
            "address" => $this->input->post('address'),
            "country_id" => $this->input->post('country_id'),
            "state" => $this->input->post('state'),
            "city" => $this->input->post('city'),
            "email" => $this->input->post('email'),
            "phone" => $this->input->post('phone'),
            "fax" => $this->input->post('fax'),
            "flag" => $this->input->post('flag')
        );
        if ($id == 0) {
            $data['user_added'] = $this->session->userdata('id');
            if ($this->model_vendor->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['updated_time'] = date("Y-m-d H:i:s");
            if ($this->model_vendor->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        $id = $this->input->post('id');
        if ($this->model_vendor->delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function get_internal_warehouse() {
        echo $this->model_vendor->get("iw");
    }

}
