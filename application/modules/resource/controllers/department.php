<?php

class department extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_department');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 813));
        $this->load->view('resource/department/index', $data);
    }

    function input() {
        $this->load->view('resource/department/input');
    }

    function get() {
        echo $this->model_department->get();
    }

    function save($id) {
        $data = array(
            'code' => $this->input->post("code"),
            'name' => $this->input->post("name"),
            'remark' => $this->input->post("remark")
        );
        if ($id == 0) {
            $this->model_department->insert($data);
        } else {
            $this->model_department->update($data, array("id" => $id));
        }
    }

    function delete() {
        $this->model_department->delete();
    }

}
