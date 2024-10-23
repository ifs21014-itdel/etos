<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rate
 *
 * @author operational
 */
class rate extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_rate');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 81));
        $this->load->view('rate/index', $data);
    }

    function get() {
        echo $this->model_rate->get();
    }

    function input() {
        $this->load->view('rate/input');
    }

    function save($id) {
        $data = array(
            "date" => $this->input->post('date'),
            "currency_id" => $this->input->post('currency_id'),
            "exchange_rate" => $this->input->post('exchange_rate'),
            "user_inserted" => $this->session->userdata('id')
        );

        if ($id == 0) {
            $data['user_inserted'] = $this->session->userdata('id');
            if ($this->model_rate->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['time_updated'] = "now()";
            if ($this->model_rate->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        $id = $this->input->post('id');
        if ($this->model_rate->delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function convert_nominal() {
        $from_id = $this->input->post('from_id');
        $to_id = $this->input->post('to_id');
        $nominal = $this->input->post('nominal');

        $val = 0;
        if ($from_id == '1') {
            $dt = $this->db->query("select exchange_rate from rate where currency_id=$to_id order by id desc limit 1")->row()->exchange_rate;
            if (!empty($dt)) {
                $val = $nominal / $dt;
            }
        } else {
            $dt = $this->db->query("select exchange_rate from rate where currency_id=$from_id order by id desc limit 1")->row()->exchange_rate;
            if (!empty($dt)) {
                $val = $nominal * $dt;
            }
        }

        echo $val;
    }

}
