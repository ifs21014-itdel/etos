<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_unit
 *
 * @author hp
 */
class model_unit extends CI_Model {

  //put your code here
  public function __construct() {
    parent::__construct();
  }

  function select_result() {
    $this->db->order_by("id", 'asc');
    return $this->db->get('unit')->result();
  }

  function get() {
    $page = $this->input->post('page');
    $rows = $this->input->post('rows');
    $sort = $this->input->post('sort');
    $order = $this->input->post('order');
    $code = $this->input->post('code');
    $description = $this->input->post('description');
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
      $order_specification = " code asc";
    }
    $query = "select * from unit where true ";
    if (!empty($code)) {
      $query .= " and code ilike '%$code%' ";
    }if (!empty($description)) {
      $query .= " and description ilike '%$description%' ";
    }
    //----------- search parameter for grid ----------------------
    $q = $this->input->post('q');
    if (!empty($q)) {
      $query .= " and code ilike '%$q%' ";
    }
    //----------------------
    $query .= " order by $order_specification";
    //echo $query;
    $result = array();
    $data = "";
    if (!empty($page) && !empty($rows)) {
      $offset = ($page - 1) * $rows;
      $result['total'] = $this->db->query($query)->num_rows();
      $query .= " limit $rows offset $offset";
      $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
      $data = json_encode($result);
    }
    else {
      $data = json_encode($this->db->query($query)->result());
    }
    return $data;
  }

  function selectAllResult() {
    return $this->db->get('unit')->result();
  }

  function select_by_id($id) {
    return $this->db->get_where('unit', array('id' => $id))->row();
  }

  function insert() {
    //return $this->db->insert('unit', $data);
    $code = $this->input->post('code');
    $description = $this->input->post('description');

    $data = array(
        "code" => $code,
        "description" => $description
    );
    if ($this->db->insert('unit', $data)) {
      echo json_encode(array('success' => true));
    }
    else {
      echo json_encode(array('msg' => $this->db->_error_message()));
    }
  }

  function update($id) {
    $code = $this->input->post('code');
    $description = $this->input->post('description');
    $data = array(
        "code" => $code,
        "description" => $description
    );
    $where = array("id" => $id);
    if ($this->db->update('unit', $data, $where)) {
      echo json_encode(array('success' => true));
    }
    else {
      echo json_encode(array('msg' => $this->db->_error_message()));
    }
  }

  function delete() {
    //return $this->db->delete('unit', $where);
    $id = $this->input->post('id');
    $where = array("id" => $id);
    if ($this->db->delete('unit', $where)) {
      echo json_encode(array('success' => true));
    }
    else {
      echo json_encode(array('msg' => $this->db->_error_message()));
    }
  }

}

?>