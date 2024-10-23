<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author operational
 */
class users extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_user');
    }

    function index() {
        $this->load->view('users/index');
    }

    function get() {
        echo $this->model_user->get();
    }

    function input() {
        $this->load->view('users/input');
    }

    function save($id) {
        $data = array(
            "name" => $this->input->post('name'),
            "user_name" => $this->input->post('user_name'),
            "email" => $this->input->post('email'),
            "phone_no" => $this->input->post('phone_no')
        );

        if ($id == 0) {
            $data["password"] = md5($this->input->post('password'));
            if ($this->db->insert('users', $data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            if ($this->db->update('users', $data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function enable() {
        if ($this->db->update('users', array("enable" => 'true'), array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function disable() {
        if ($this->db->update('users', array("enable" => 'false'), array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function edit_privilege($id) {
        $data['id'] = $id;
        $query = "select 
                    menu.*,
                    menuuser.usersid,
                    menuuser.actions menuuser_actions
                    from menuuser 
                    right join menu on menuuser.menuid=menu.id
                    and menuuser.usersid=$id order by menu.id asc";
        $data['menu'] = $this->db->query($query)->result();
        $this->load->view('users/edit_privilege', $data);
    }

    function action_set_menu() {
        $type = $this->input->post('type');
        $userid = $this->input->post('userid');
        $menuid = $this->input->post('menuid');
        if ($type == 1) {
            if ($this->db->insert('menuuser', array("menuid" => $menuid, "usersid" => $userid))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            if ($this->db->delete('menuuser', array("menuid" => $menuid, "usersid" => $userid))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function action_set() {

        $type = $this->input->post('type');
        $userid = $this->input->post('userid');
        $menuid = $this->input->post('menuid');
        $action = $this->input->post('action');

        $user_action = $this->model_user->get_action($userid, $menuid);

        if ($type == 1) {
            $user_action .= "|" . $action;
            $data = array(
                "actions" => $user_action
            );
            if ($this->db->update("menuuser", $data, array("usersid" => $userid, "menuid" => $menuid))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $array_user_action = explode('|', $user_action);
            $new_array_user_action = array_diff($array_user_action, array($action));
            $new_action = implode('|', $new_array_user_action);
//            echo $new_action;
            $data = array(
                "actions" => $new_action
            );
            if ($this->db->update("menuuser", $data, array("usersid" => $userid, "menuid" => $menuid))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function change_password() {
        $this->load->view('users/change_password');
    }

    function update_password($id) {
        if ($this->db->update('users', array("password" => md5($this->input->post('password'))), array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}
