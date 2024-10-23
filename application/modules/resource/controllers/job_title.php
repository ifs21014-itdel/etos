<?php

class job_title extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_job_title');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 813));
        $this->load->view('resource/job_title/index', $data);
    }

    function input() {
        $this->load->view('resource/job_title/input');
    }

    function get() {
        echo $this->model_job_title->get();
    }

    function save($id) {
        $data = array(
            'code' => $this->input->post("code"),
            'name' => $this->input->post("name"),
            'remark' => $this->input->post("remark")
        );
        if ($id == 0) {
            $this->model_job_title->insert($data);
        } else {
            $this->model_job_title->update($data, array("id" => $id));
        }
    }

    function delete() {
        $this->model_job_title->delete();
    }

}
