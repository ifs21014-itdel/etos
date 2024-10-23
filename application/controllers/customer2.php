<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class customer extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('model_customer');
  }

  function index() {
    $data = array();
    $this->load->view('customer/view', $data);
  }

  function get() {
    // echo $query;
    echo $this->model_customer->get();
  }

  function simpan($id) {

//        $nomor = $this->input->post('nomor');
    $cust_code = $this->input->post('cust_code');
    $cust_name = $this->input->post('cust_name');
    $address = $this->input->post('address');
    $country_id = $this->input->post('country_id');
    $contact_person = $this->input->post('contact_person');
    $email = $this->input->post('email');
    $phone = $this->input->post('phone');
    $phone_2 = $this->input->post('phone_2');
    $data = array(
        'cust_name' => $cust_name,
        'cust_code' => $cust_code,
        'address' => $address,
        'country_id' => $country_id,
        'contact_person' => $contact_person,
        'email' => $email,
        'phone' => $phone,
        'phone_2' => $phone_2
    );

    if ($id == 0) {
      if ($this->model_customer->insert($data)) {
        echo json_encode(array('success' => true));
      }
      else {
        echo json_encode(array('msg' => $this->db->_error_message()));
      }
    }
    else {
      if ($this->model_customer->update($data, array("id" => $id))) {
        echo json_encode(array('success' => true));
      }
      else {
        echo json_encode(array('msg' => $this->db->_error_message()));
      }
    }
  }

  function hapus() {
    $id = $this->input->post('id');
    if ($this->model_customer->delete(array("id" => $id))) {
      echo json_encode(array('success' => true));
    }
    else {
      echo json_encode(array('msg' => $this->db->_error_message()));
    }
  }

  function cetak($id, $flag) {
    //$this->load->model('model_profil');
    $this->load->library("pdf");
    //  $data['profil'] = $this->model_profil->select();
    $data['customer'] = $this->model_customer->selectById($id);
    $data['bidbond'] = $this->model_customer->selectBidbondById($id);
    $data['performancebond'] = $this->model_customer->selectPerformancebondById($id);
    $data['flag'] = $flag;
//        $this->load->view('customer/cetak', $data, FALSE);
    $html = $this->load->view('customer/cetak', $data, TRUE);
    $this->pdf->pdf_create($html, "file", "", "P", "legal");
  }

  function get_combo_grid() {
    $name = $this->input->post('q');
    $query = "select cst.*,c.country from ref_customer as cst INNER JOIN country as c ON cst.country_id=c.id where true ";
    if ($name != "") {
      $query .= " and cst.cust_name ilike '%$name%' or cst.cust_code ilike '%$name%'";
    }
    // echo $query;
    echo $this->model_customer->get_combo_grid($query);
  }

  //--------------------- cust_files

  function get_doc_bycust() {
    $page = $this->input->post('page');
    $rows = $this->input->post('rows');
    $cust_id = $this->input->post('customer_id');
    if (empty($cust_id)) {
      $cust_id = "0";
    }
    $sort = $this->input->post('sort');
    $order = $this->input->post('order');
    $query = "select cf.*,c.cust_name from cust_files as cf INNER JOIN ref_customer as c ON cf.customer_id=c.id  
                 where cf.customer_id='" . $cust_id . "' ";
    if (!empty($sort)) {
      $arr_sort = explode(',', $sort);
      $arr_order = explode(',', $order);
      if (count($arr_sort) == 1) {
        $order_specification = " $arr_sort[0] $arr_order[0] ";
      }
      else {
        $order_specification = " $arr_sort[0] $arr_order[0] ";
        for ($i = 1; $i < count($arr_sort); $i++) {
          $order_specification .=", $arr_sort[$i] $arr_order[$i] ";
        }
      }
    }
    else {
      $order_specification = " cf.doc_number asc";
    }
    $query .= "  order by $order_specification";
    // echo $query;
    echo $this->model_customer->get_doc_bycust($page, $rows, $query);
  }

  function hapus_cust_files() {
    $id = $this->input->post('id');
    $filename = $this->input->post('filename');
    $this->load->helper("file");
    $file_path = "files/cust_files/" . $filename;
    //echo $file_path;
    if (unlink($file_path)) {
      if ($this->model_customer->delete_cust_files(array("id" => $id))) {
        echo json_encode(array('success' => true));
      }
      else {
        echo json_encode(array('msg' => $this->db->_error_message()));
      }
    }
    else {
      echo json_encode(array('msg' => 'Error Delete File'));
    }
  }

  function save_cust_files($customer_id) {
    $doc_number = $this->input->post('doc_number');
    $revision = $this->input->post('revision');
    $notes = $this->input->post('notes');
    $username = $this->session->userdata("username");
    $data_files = array(
        'customer_id' => $customer_id,
        'doc_number' => $doc_number,
        'revision' => $revision,
        'notes' => $notes,
        'user_input' => $username
    );
    if ($this->model_customer->insert_cust_files($data_files)) {
      $lastid = $this->model_customer->get_cust_files_lastid();
      $file_name = "";
      $upload = $_FILES['attach1']['name'];
      $ext = pathinfo($upload, PATHINFO_EXTENSION);
      $file_name = "cust_files" . $lastid . "." . $ext;
      $config['upload_path'] = './files/cust_files/';
      $config['allowed_types'] = 'ppt|pptx|pdf|xls|doc|xlsx|jpeg|jpg|png|docx|odt|ocx|tif';
      $config['max_size'] = 1024 * 50;
      $config['file_name'] = $file_name;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('attach1')) {
        $this->model_customer->update_cust_files(array("file_name" => $file_name), array("id" => $lastid));
        echo json_encode(array('success' => true));
      }
      else {
        $this->model_customer->delete_cust_files(array("id" => $lastid));
        echo json_encode(array('msg' => $this->upload->display_errors('', '')));
      }
    }
    else {
      echo json_encode(array('msg' => $this->db->_error_message()));
    }
  }

  function update_cust_files($id, $attachment) {

    $doc_number = $this->input->post('doc_number');
    $revision = $this->input->post('revision');
    $notes = $this->input->post('notes');
    $username = $this->session->userdata("username");
    $data_files = array(
        'doc_number' => $doc_number,
        'revision' => $revision,
        'notes' => $notes,
        'user_input' => $username
    );

    if ($this->model_customer->update_cust_files($data_files, array("id" => $id))) {
      if ($attachment != "") {
        $file_name = "";
        $upload = $_FILES['attach1']['name'];
        if (!empty($upload)) {
          unlink('./files/cust_files/' . $attachment);
          $ext = pathinfo($upload, PATHINFO_EXTENSION);
          $file_name = "cust_files" . $id . "." . $ext;
          $config['upload_path'] = './files/cust_files/';
          $config['allowed_types'] = 'ppt|pptx|pdf|xls|doc|xlsx|jpeg|jpg|png|docx|odt|ocx|tif';
          $config['max_size'] = 1024 * 50;
          $config['file_name'] = $file_name;
          $this->load->library('upload', $config);
          if ($this->upload->do_upload('attach1')) {
            $this->model_customer->update_cust_files(array("file_name" => $file_name), array("id" => $id));
            echo json_encode(array('success' => true));
          }
        }
        else {
          echo json_encode(array('success' => true));
        }
      }
    }
    else {
      echo json_encode(array('msg' => $this->db->_error_message()));
    }
  }

  //------------------ for customer contact person 
  function get_cp_bycust() {
    $page = $this->input->post('page');
    $rows = $this->input->post('rows');
    $cust_id = $this->input->post('customer_id');
    if (empty($cust_id)) {
      $cust_id = "0";
    }
    $sort = $this->input->post('sort');
    $order = $this->input->post('order');
    $query = "select cp.*,c.cust_name from cust_cp as cp INNER JOIN ref_customer as c ON cp.customer_id=c.id  
                 where cp.customer_id='" . $cust_id . "' ";
    if (!empty($sort)) {
      $arr_sort = explode(',', $sort);
      $arr_order = explode(',', $order);
      if (count($arr_sort) == 1) {
        $order_specification = " $arr_sort[0] $arr_order[0] ";
      }
      else {
        $order_specification = " $arr_sort[0] $arr_order[0] ";
        for ($i = 1; $i < count($arr_sort); $i++) {
          $order_specification .=", $arr_sort[$i] $arr_order[$i] ";
        }
      }
    }
    else {
      $order_specification = " cp.id asc";
    }
    $query .= "  order by $order_specification";
    // echo $query;
    echo $this->model_customer->get_cp_bycust($page, $rows, $query);
  }

  function cust_cp_save($customer_id, $id) {
    $name = $this->input->post('name');
    $email = $this->input->post('email');
    $notes = $this->input->post('notes');
    $work_number = $this->input->post('work_number');
    $ext = $this->input->post('ext');
    $mobile = $this->input->post('mobile');
    $data_cp = array(
        'customer_id' => $customer_id,
        'name' => $name,
        'work_number' => $work_number,
        'ext' => $ext,
        'mobile' => $mobile,
        'email' => $email,
        'notes' => $notes
    );

    if ($id == 0) {
      if ($this->model_customer->insert_cust_cp($data_cp)) {
        echo json_encode(array('success' => true));
      }
      else {
        echo json_encode(array('msg' => $this->db->_error_message()));
      }
    }
    else {
      if ($this->model_customer->update_cust_cp($data_cp, array("id" => $id))) {
        echo json_encode(array('success' => true));
      }
      else {
        echo json_encode(array('msg' => $this->db->_error_message()));
      }
    }
  }

  function cust_cp_delete() {
    $id = $this->input->post('id');
    if ($this->model_customer->delete_cust_cp(array("id" => $id))) {
      echo json_encode(array('success' => true));
    }
    else {
      echo json_encode(array('msg' => $this->db->_error_message()));
    }
  }

}
