<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class print_mark_test_list extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_print_mark_test_list');
    }

    function index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 42));
        $this->load->view('print_mark_test_list/index', $data);
    }

    function get($flag = "") {
        echo $this->model_print_mark_test_list->get($flag);
    }

    function input() {
        $this->load->view('print_mark_test_list/input');
    }

    function compress_image($tempPath, $originalPath, $imageType) {
        $compressed = false;
        $imageType = strtolower($imageType);
    
        if ($imageType === 'jpg' || $imageType === 'jpeg') {
            $image = imagecreatefromjpeg($tempPath);
            $compressed = imagejpeg($image, $originalPath, 40); // Quality 40
        } elseif ($imageType === 'png') {
            $image = imagecreatefrompng($tempPath);
            $compressed = imagepng($image, $originalPath, 2); // Compression level 2
        }
    
        if (isset($image)) {
            imagedestroy($image); // Free up memory
        }
    
        return $compressed;
    }

    function save($id) {
    $data_print_mark_test_list_detail = array(
        "protocol_test_id" => $this->input->post('protocol_test_id'),
        "client_id" => $this->input->post('client_id'),
        "vendor_id" =>  $this->input->post('vendor_id'),
        "product_id" =>  $this->input->post('product_id'),
        "submited" => 'f',
        "test_date" => $this->input->post('test_date') ? $this->input->post('test_date'): NULL,
        "carton_dimension" => $this->input->post('carton_dimension'),
        "gross_weight" => $this->input->post('gross_weight') ? $this->input->post('gross_weight'): 0,
        "nett_weight" => $this->input->post('nett_weight') ? $this->input->post('nett_weight'): 0,
        "brand" => $this->input->post('brand'),
        "report_date" => $this->input->post('report_date') ? $this->input->post('report_date'): NULL,
        "product_dimension" => $this->input->post('product_dimension'),
        "report_no" => $this->input->post('report_no'),
        "corrective_action_plan_image" => $this->input->post('corrective_action_plan_image'),
        "notes" => $this->input->post('notes')
    );

    $nametemp_product = 'product_image';
    $id_dir = $id;

    if ($id == 0) {
        $maxid = $this->model_print_mark_test_list->get_print_mark_test_list_max_id();
        $id_dir = 1 + $maxid[0]->max_id;
    }

    if (isset($_FILES[$nametemp_product]['name'])) {
        $directory = 'files/printmarktest/' . $id_dir;

        if (!file_exists($directory)) {
            $oldumask = umask(0);
            mkdir($directory, 0777);
            umask($oldumask);
        }

        $allowedImageType = array('jpg', 'png', 'jpeg', 'JPG', 'JPEG', 'PNG');
        $imageName = $_FILES[$nametemp_product]['name'];
        $tempPath = $_FILES[$nametemp_product]["tmp_name"];
        $imageType = pathinfo($imageName, PATHINFO_EXTENSION);
        $basename = 'product_image-' . $id_dir . '.' . $imageType;
        $originalPath = $directory . '/' . $basename;

        if (in_array(strtolower($imageType), $allowedImageType)) {
            if (file_exists($originalPath)) {
                unlink($originalPath); // Hapus file lama jika ada
            }

            // Kompres dan simpan gambar menggunakan compress_image
            $compressed = $this->compress_image($tempPath, $originalPath, $imageType);

            if ($compressed) {
                $data_print_mark_test_list_detail['product_image'] = $basename;
            } else {
                echo 'Image not uploaded! Try again.';
                exit();
            }
        }
    }

    if ($id == 0) {
        $data_print_mark_test_list_detail['created_by'] = $this->session->userdata('id');
        if ($this->model_print_mark_test_list->insert($data_print_mark_test_list_detail)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    } else {
        $data_print_mark_test_list_detail['updated_by'] = $this->session->userdata('id');
        $data_print_mark_test_list_detail['updated_at'] = "now()";
        if ($this->model_print_mark_test_list->update($data_print_mark_test_list_detail, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }
}


    function update_status() {
        if ($this->model_print_mark_test_list->update(array("status" => $this->input->post("status")), array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update_price() {
        $this->load->view('print_mark_test_list/update_price');
    }

    function do_update_price($id) {
        $data = array(
            "price" => (double) $this->input->post('price'),
            "price_house" => (double) $this->input->post('price_house'),
            "price_designer" => (double) $this->input->post('price_designer'),
            "currency_id" => $this->input->post('currency_id')
        );
        if ($this->model_print_mark_test_list->update($data, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        $id = $this->input->post('id');
        if ($this->model_print_mark_test_list->delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function copy() {
        $this->load->view('print_mark_test_list/copy');
    }

    function do_copy($id) {
        $rnd_code = $this->input->post('rnd_code');
        $code = $this->input->post('code');
        $name = $this->input->post('name');
        $user_inserted = $this->session->userdata('id');
        if ($this->db->query("select print_mark_test_list_do_copy($id,'$rnd_code','$code','$name',$user_inserted)")) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function load_image($image) {
        echo "<img src='files/print_mark_test_list_image/" . $image . "' style='padding-top: 20px; max-width: 150px;max-height: 150px;'/>";
    }

    //------------------ for print_mark_test_list box

    function print_mark_test_list_detail_index() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 42));
        $this->load->view('print_mark_test_list/variabel_test/index', $data);
    }

    function print_mark_test_list_detail_input() {
        $this->load->view('print_mark_test_list/variabel_test/input');
    }

    function print_mark_test_list_detail_get() {
        echo $this->model_print_mark_test_list->print_mark_test_list_detail_get();
    }

    function print_mark_test_list_detail_save($print_mark_test_list_id, $id) {
        $data_box = array(
            'print_mark_test_list_id' => $print_mark_test_list_id,
            'evaluation' => $this->input->post('evaluation'),
            'method' => $this->input->post('method'),
            'notes' => $this->input->post('notes'),
            'result_test_var' => $this->input->post('result_test_var'),
            'mandatory' => 't',
            'var_type' => $this->input->post('var_type')
        );
        $nametemp = 'image_file';
    
        if (isset($_FILES[$nametemp]['name'])) {
            $directory = 'files/printmarktest/' . $print_mark_test_list_id;
    
            if (!file_exists($directory)) {
                $oldumask = umask(0);
                mkdir($directory, 0777); 
                umask($oldumask);
            }
    
            $allowedImageType = array('jpg', 'png', 'jpeg', 'JPG', 'JPEG', 'PNG');
            $imageName = $_FILES[$nametemp]['name'];
            $tempPath = $_FILES[$nametemp]["tmp_name"];
            $imageType = pathinfo($imageName, PATHINFO_EXTENSION);
            $basename = 'dt-' . $id . '-vt-' . $print_mark_test_list_id . '-image-1.' . $imageType;
            $originalPath = $directory . '/' . $basename;
    
            if (in_array(strtolower($imageType), $allowedImageType)) {
                // Kompres dan upload gambar menggunakan compress_image
                $compressed = $this->compress_image($tempPath, $originalPath, $imageType);
    
                if ($compressed) {
                    $data_box['image_file'] = $basename;
    
                    if ($id == 0) {
                        $data_box['created_by'] = $this->session->userdata('id');
                        if ($this->model_print_mark_test_list->print_mark_test_list_detail_insert($data_box)) {
                            echo json_encode(array('success' => true));
                        } else {
                            echo json_encode(array('msg' => $this->db->_error_message()));
                        }
                    } else {
                        $data_box['updated_by'] = $this->session->userdata('id');
                        $data_box['updated_at'] = date("Y-m-d H:i:s");
                        if ($this->model_print_mark_test_list->print_mark_test_list_detail_update($data_box, array("id" => $id))) {
                            echo json_encode(array('success' => true));
                        } else {
                            echo json_encode(array('msg' => $this->db->_error_message()));
                        }
                    }
                } else {
                    echo 'Image not uploaded! Try again.';
                }
            } else {
                if ($id == 0) {
                    $data_box['created_by'] = $this->session->userdata('id');
                    if ($this->model_print_mark_test_list->print_mark_test_list_detail_insert($data_box)) {
                        echo json_encode(array('success' => true));
                    } else {
                        echo json_encode(array('msg' => $this->db->_error_message()));
                    }
                } else {
                    $data_box['updated_by'] = $this->session->userdata('id');
                    $data_box['updated_at'] = date("Y-m-d H:i:s");
                    if ($this->model_print_mark_test_list->print_mark_test_list_detail_update($data_box, array("id" => $id))) {
                        echo json_encode(array('success' => true));
                    } else {
                        echo json_encode(array('msg' => $this->db->_error_message()));
                    }
                }
            }
        }
    }

    function print_mark_test_list_detail_delete() {
        $id = $this->input->post('id');
        if ($this->model_print_mark_test_list->print_mark_test_list_detail_delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function download() {
        $data['print_mark_test_list'] = $this->model_print_mark_test_list->getall();

        //--------- UNtuk EXCEL ----
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"print_mark_test_list.xls\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        //$this->load->view('purchaseorder/generate_serial_number_excel', $data);
        //------------ END OF EXCEL
        $this->load->view('print_mark_test_list/download', $data);
        //$this->load->view('purchaseorder/generate_serial_number2', $data);
    }

    function get_item_po() {
        echo $this->model_print_mark_test_list->get_item_po();
    }

    //================================================== variabel test upload photo

    function variabel_test_input($id, $type_form) {
        $data['type_form'] = $type_form;
        $this->load->view('print_mark_test_list/variabel_test/input_image', $data);
    }

    function variabel_test_save($print_mark_test_list_id, $id) {
        $data_box = array(
            'result_test_var' => $this->input->post('result_test_var'),
            'notes' => $this->input->post('notes')
        );
        $nametemp = 'image_file';
    
        if (isset($_FILES[$nametemp]['name'])) {
            $directory = 'files/printmarktest/' . $print_mark_test_list_id;
    
            if (!file_exists($directory)) {
                $oldumask = umask(0);
                mkdir($directory, 0777);
                umask($oldumask);
            }
    
            $allowedImageType = array('jpg', 'png', 'jpeg', 'JPG', 'JPEG', 'PNG');
            $imageName = $_FILES[$nametemp]['name'];
            $tempPath = $_FILES[$nametemp]["tmp_name"];
            $imageType = pathinfo($imageName, PATHINFO_EXTENSION);
            $basename = 'dt-' . $id . '-vt-' . $print_mark_test_list_id . '-image-1.' . $imageType;
            $originalPath = $directory . '/' . $basename;
    
            if (in_array(strtolower($imageType), $allowedImageType)) {
                // Hapus file lama jika ada
                if (file_exists($originalPath)) {
                    unlink($originalPath);
                }
    
                // Kompres dan upload gambar menggunakan compress_image
                $compressed = $this->compress_image($tempPath, $originalPath, $imageType);
    
                if ($compressed) {
                    $data_box['image_file'] = $basename;
                    $data_box['updated_by'] = $this->session->userdata('id');
                    $data_box['updated_at'] = date("Y-m-d H:i:s");
                    
                    if ($this->model_print_mark_test_list->print_mark_test_list_detail_update($data_box, array("id" => $id))) {
                        echo json_encode(array('success' => true));
                    } else {
                        echo json_encode(array('msg' => $this->db->_error_message()));
                    }
                } else {
                    echo 'Image not uploaded! Try again.';
                }
            }
        } else {
            // Update tanpa mengunggah gambar
            $data_box['updated_by'] = $this->session->userdata('id');
            $data_box['updated_at'] = date("Y-m-d H:i:s");
            
            if ($this->model_print_mark_test_list->print_mark_test_list_detail_update($data_box, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }
    

    function prints() {
        $jenis_laporan = $this->input->post('jenis_laporan');
        $id = $this->input->post('id');
        $this->load->library('pdf');
        $data['print_mark_test_list'] = $this->model_print_mark_test_list->select_by_id($id);
        $data['print_mark_test_list_detail'] = $this->model_print_mark_test_list->print_mark_test_list_detail_select_by_print_mark_test_list_detail_id($id);
        //--------- UNtuk EXCEL ----
        /*
          header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
          header("Content-Disposition: inline; filename=\"print_mark_test_list.xls\"");
          header("Pragma: no-cache");
          header("Expires: 0");
         */

        //--------- UNtuk WORD ----
        //    header("Content-Type: application/vnd.ms-word; charset=UTF-8");
        //   header("Content-Disposition: inline; filename=\"print_mark_test_list.doc\"");
        //    header("Pragma: no-cache");
        //    header("Expires: 0");
        if ($jenis_laporan == 'excel') {

            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"print_mark_test_list.xls\"");
            header("Pragma: no-cache");
            header("Expires: 0");
        }
        $this->load->view('print_mark_test_list/print', $data);
    }

    function generate_pdf() {
        $jenis_laporan = $this->input->post('jenis_laporan');
        $id = $this->input->post('id');
        $this->load->library('pdf');
        $data['print_mark_test_list'] = $this->model_print_mark_test_list->select_by_id($id);
        $data['print_mark_test_list_detail'] = $this->model_print_mark_test_list->print_mark_test_list_detail_select_by_print_mark_test_list_detail_id($id);
        $html=$this->load->view('print_mark_test_list/print_pdf', $data, TRUE);
        $this->pdf->print_test_to_pdf($html, 'print_mark_test');
    }


    function excel() {
        $this->load->model('model_print_mark_test_list_excel');
        
        $id = $this->input->post('id'); 
        
        $data['print_mark_test_list'] = $this->model_print_mark_test_list->select_by_id($id); 
        $data['print_mark_test_list_detail'] = $this->model_print_mark_test_list->print_mark_test_list_detail_select_by_print_mark_test_list_detail_id($id);
      
        $this->load->model('model_print_mark_test_list_excel'); 
        $this->model_print_mark_test_list_excel->initialize($data['print_mark_test_list'], $data['print_mark_test_list_detail']);
       
        $this->model_print_mark_test_list_excel->download(); 
    }

    function print_summary() {
        $id = $this->input->post('id');
        $this->load->library('pdf');
        $data['shipment'] = $this->model_print_mark_test_list->select_by_id($id);
        $data['shipment_item'] = $this->model_print_mark_test_list->select_summarize_by_shipment_id($id);
        $this->load->view('shipment/print_summary', $data);
    }

    function product_image_detail($id) {
        $data['dt_detail'] = $this->model_print_mark_test_list->print_mark_test_list_detil_get_byid($id);
        // var_dump($data);
        $this->load->view('print_mark_test_list/variabel_test/show_detail', $data);
    }

    function submit() {
        $id = $this->input->post('id');
        $resulst_status = $this->input->post('result_s');

        $data = array(
        );
        $data['updated_by'] = $this->session->userdata('id');
        $data['updated_at'] = date("Y-m-d H:i:s");
        $data['submited'] = 'TRUE';
        $data['rating'] = $resulst_status;
        $data['report_date'] = date('Y-m-d');

        $error_message = "";
        if ($this->model_print_mark_test_list->update($data, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            $error_message = $this->db->_error_message();
            echo json_encode(array('msg' => $error_message));
        }
    }

    function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    function isPC() {
        return preg_match("/(windows|linux|)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

}