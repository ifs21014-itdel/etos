<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of unit
 *
 * @author hp
 */
class unit extends CI_Controller {

  //put your code here
  public function __construct() {
    parent::__construct();
    $this->load->model('model_unit');
  }

  function index() {
    $this->load->view('unit/view');
  }

  function get() {
    echo $this->model_unit->get();
  }

  function save() {
    $this->model_unit->insert();
  }

  function update($id) {
    $this->model_unit->update($id);
  }

  function delete() {
    $this->model_unit->delete();
  }

}

?>
