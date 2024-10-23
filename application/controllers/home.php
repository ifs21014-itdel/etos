<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->userdata('id')) {
            $data['menu_group'] = $this->model_user->selectMenuGroup($this->session->userdata('id'));
            $this->load->view('home2', $data);
        } else {
            $this->load->view('login');
        }
    }

    function login() {
        $this->load->model('model_user');
        $username = trim($this->input->post('username'));
        $password = md5(trim($this->input->post('password')));
        $user = $this->model_user->login($username, $password);

        if (!empty($user)) {
            $this->session->set_userdata('id', $user->id);
            $this->session->set_userdata('name', $user->name);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('user_name', $user->username);
            redirect(base_url());
        } else {
            $msg = "User and Password Faild!";
            $this->session->set_userdata('msg', $msg);
            redirect(base_url());
        }
    }

    function logout() {
        $this->session->unset_userdata('id');
        redirect(base_url());
    }

    function check_session() {
        if ($this->session->userdata('id')) {
            echo "0";
        } else {
            echo "1";
        }
    }

    function check_session2() {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        //$time = date('r');
        $check = "0";
        if ($this->session->userdata('id')) {
            $check = 1;
        }
        echo "data:{$check}\n\n";
        flush();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */