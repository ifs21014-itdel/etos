<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of client2
 *
 * @author user
 */
class client extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_client');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 3));
        $this->load->view('client/index',$data);
    }

    function get() {
        echo $this->model_client->get();
    }

    function input() {
        $this->load->view('client/input');
    }

    function save($id) {

        $data = array(
            "code" => $this->input->post('code'),
            "name" => $this->input->post('name'),
            "company" => $this->input->post('name')
        );
        if ($id == 0) {
            $data['user_added'] = $this->session->userdata('id');
            if ($this->model_client->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['updated_time'] = date("Y-m-d H:i:s");
            if ($this->model_client->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function delete() {
        $id = $this->input->post('id');
        if ($this->model_client->delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}

?>
