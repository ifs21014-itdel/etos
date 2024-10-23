<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of warehouse
 *
 * @author hp
 */
class warehouse extends CI_Controller {

  //put your code here
  public function __construct() {
    parent::__construct();
    $this->load->model('model_warehouse');
  }

  function index() {
    $this->load->view('warehouse/view');
  }

  function get() {
    echo $this->model_warehouse->get();
  }

  function save() {
    $this->model_warehouse->insert();
  }

  function update($id) {
    $this->model_warehouse->update($id);
  }

  function delete() {
    $this->model_warehouse->delete();
  }

}

?>
