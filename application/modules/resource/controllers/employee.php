<?php

class employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_employee');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 44));
        $this->load->view('resource/employee/index', $data);
    }

    function input() {
        $this->load->view('resource/employee/input');
    }

    function get() {
        echo $this->model_employee->get();
    }

    function save($id) {
        $data = array(
            'employee_id' => $this->input->post("employee_id"),
            'employee_name' => $this->input->post("employee_name"),
            'gender' => $this->input->post("gender"),
            'birth_place' => $this->input->post("birth_place"),
            'dob' => $this->input->post("dob"),
            'identity_number' => $this->input->post("identity_number"),
            'marital_status' => $this->input->post("marital_status"),
            'dependent' => $this->input->post("dependent"),
            'address' => $this->input->post("address"),
            'city' => $this->input->post("city"),
            'state' => $this->input->post("state"),
            'zip_code' => $this->input->post("zip_code"),
            'country' => $this->input->post("country"),
            'phone_number' => $this->input->post("phone_number"),
            'email' => $this->input->post("email"),
            'education' => $this->input->post("education"),
            'status' => $this->input->post("status"),
            'start_date' => empty_to_null($this->input->post("start_date")),
            'end_date' => empty_to_null($this->input->post("end_date")),
            'department_id' => $this->input->post("department_id"),
            'job_title_id' => $this->input->post("job_title_id"),
            'basic_salary' => $this->input->post("basic_salary"),
            'bank_name' => $this->input->post("bank_name"),
            'bank_branch' => $this->input->post("bank_branch"),
            'bank_account_no' => $this->input->post("bank_account_no"),
            'bank_account_holder' => $this->input->post("bank_account_holder"),
            'jamsostek_no' => $this->input->post("jamsostek_no"),
            'bpjs_kesehatan_number' => $this->input->post("bpjs_kesehatan_number"),
            'kelas_bpjs' => $this->input->post("kelas_bpjs")
        );
        if ($id == 0) {
            $this->model_employee->insert($data);
        } else {
            $this->model_employee->update($data, array("id" => $id));
        }
    }

    function delete() {
        $this->model_employee->delete();
    }

    /* function show list department */

    function departmentlist() {
        echo json_encode($this->model_employee->getDeptList());
    }

}
