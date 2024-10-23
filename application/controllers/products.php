<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_products');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 42));
        $this->load->view('products/index', $data);
    }

    function get($flag = "") {
        echo $this->model_products->get($flag);
    }

    function input() {
        $this->load->view('products/input');
    }

    function save($id) {
        $last_file_name = $this->input->post('last_file_name');
        $data_product = array(
            "remarks" => $this->input->post('remarks'),
            "ebako_code" => $this->input->post('ebako_code'),
            "customer_code" => $this->input->post('customer_code'),
            "finishing" => $this->input->post('finishing'),
            "material" => $this->input->post('material'),
            "description" => $this->input->post('description'),
            "packing_configuration" => (int) $this->input->post('packing_configuration'),
            "remarks" => $this->input->post('remarks'),
            "client_id" => $this->input->post('client_id')
        );
//        print_r($data_product);

        if ($id == 0) {
            $file_upload_msg = "";
            if ($_FILES['product_image']['name'] !== '') {
                $config = array();
                $config['upload_path'] = './files/products_image/';
                $config['allowed_types'] = "gif|jpg|jpeg|png";
                $config['remove_spaces'] = true;
                $image = $_FILES['product_image']['name'];
                $ext = pathinfo($image, PATHINFO_EXTENSION);
                $config['file_name'] = date('Ymd_his') . "." . $ext;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('product_image')) {
//                    echo $this->upload->display_errors();
                    $data = $this->upload->data();
                    $data_product['image'] = $data['file_name'];
                } else {
                    $data_product['image'] = "no-image.jpg";
                    $file_upload_msg = $this->upload->display_errors("", "");
                    //unlink($data['full_path']);
//                    echo $file_upload_msg;
                }
            } else {
                $data_product['image'] = "no-image.jpg";
                $file_upload_msg = "No Image uploaded";
            }
//            exit();
            $data_product['user_inserted'] = $this->session->userdata('id');
            if ($this->model_products->insert($data_product)) {
                echo json_encode(array('success' => true, 'msg' => $file_upload_msg));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {

            $file_upload_msg = "";
            if ($_FILES['product_image']['name'] !== '') {
                $config = array();
                $config['upload_path'] = './files/products_image/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $image = $_FILES['product_image']['name'];
                $ext = pathinfo($image, PATHINFO_EXTENSION);
                $config['file_name'] = date('Ymd_his') . "." . $ext;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('product_image')) {
                    $data = $this->upload->data();
                    $data_product['image'] = $data['file_name'];
                } else {
//                    $data_product['image'] = "no-image.jpg";
                    $file_upload_msg = $this->upload->display_errors("", "");
//                    unlink($data['full_path']);
                }
            } else {
//                $data_product['image'] = "no-image.jpg";
                $file_upload_msg = "No Image uploaded";
            }


            $data_product['user_updated'] = $this->session->userdata('id');
            $data_product['time_updated'] = "now()";
            if ($this->model_products->update($data_product, array("id" => $id))) {
//                if ($last_file_name != 'no-image.jpg') {
//                    //@unlink('./files/products_image/' . $last_file_name);
//                }
                echo json_encode(array('success' => true, "msg" => $file_upload_msg));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function update_status() {
        if ($this->model_products->update(array("status" => $this->input->post("status")), array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update_price() {
        $this->load->view('products/update_price');
    }

    function do_update_price($id) {
        $data = array(
            "price" => (double) $this->input->post('price'),
            "price_house" => (double) $this->input->post('price_house'),
            "price_designer" => (double) $this->input->post('price_designer'),
            "currency_id" => $this->input->post('currency_id')
        );
        if ($this->model_products->update($data, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        $id = $this->input->post('id');
        if ($this->model_products->delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function copy() {
        $this->load->view('products/copy');
    }

    function do_copy($id) {
        $rnd_code = $this->input->post('rnd_code');
        $code = $this->input->post('code');
        $name = $this->input->post('name');
        $user_inserted = $this->session->userdata('id');
        if ($this->db->query("select products_do_copy($id,'$rnd_code','$code','$name',$user_inserted)")) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function load_image($image) {
        echo "<img src='files/products_image/" . $image . "' style='padding-top: 20px; max-width: 150px;max-height: 150px;'/>";
    }

    //------------------ for products box

    function box_index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 42));
        $this->load->view('products/box/index', $data);
    }

    function box_input() {
        $this->load->view('products/box/input');
    }

    function box_get() {
        echo $this->model_products->box_get();
    }

    function box_save($products_id, $id) {
        $data_box = array(
            'products_id' => $products_id,
            'code' => $this->input->post('code'),
            'description' => $this->input->post('description'),
            'width' => (double) $this->input->post('width'),
            'depth' => (double) $this->input->post('depth'),
            'height' => (double) $this->input->post('height')
        );

        if ($id == 0) {
            $data['user_added'] = $this->session->userdata('id');
            if ($this->model_products->box_insert($data_box)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['updated_time'] = date("Y-m-d H:i:s");
            if ($this->model_products->box_update($data_box, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function box_delete() {
        $id = $this->input->post('id');
        if ($this->model_products->box_delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }
    function download() {
        $data['products'] = $this->model_products->getall();
        
        //--------- UNtuk EXCEL ----
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"products.xls\"");
            header("Pragma: no-cache");
            header("Expires: 0");
        
            //$this->load->view('purchaseorder/generate_serial_number_excel', $data);
        //------------ END OF EXCEL
        $this->load->view('products/download', $data);
        //$this->load->view('purchaseorder/generate_serial_number2', $data);
    }


}
