<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of purchase_order
 *
 * @author user
 */
class inspection extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_inspection');
        $this->load->model('model_products');
        $this->load->model('model_image_category');
    }

    function index() {
        $this->load->view('inspection/index');
    }

    function create_from_po_editorial() {
        $this->model_inspection->create_from_po_editorial();
    }

    function input() {
        $this->load->view('inspection/input');
    }

    function get() {

        echo $this->model_inspection->get();
    }

    function get_item_po() {
        echo $this->model_inspection->get_item_po();
    }

    function view() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 51));
        $this->load->view('inspection/inspection', $data);
    }

    function save($id) {
        $id_po_item_inspection = $this->input->post('id_po_item_inspection');
        $datatemp = explode("#", $id_po_item_inspection);

        //var_dump($datatemp);
        //exit;
        $data = array(
            "inspection_date" => date('Y-m-d'),
            "purchaseorder_item_id" => $datatemp[0],
            "po_client_no" => $datatemp[1],
            "ebako_code" => $datatemp[2],
            "customer_code" => $datatemp[3],
            "client_id" => $datatemp[4],
            "client_name" => $datatemp[5]
        );

        if ($id == 0) {
            $data['user_added'] = $this->session->userdata('name');
            $data['added_time'] = date("Y-m-d H:i:s");
            $data['user_updated'] = $this->session->userdata('name');
            $data['updated_time'] = date("Y-m-d H:i:s");
            //var_dump($data);
            if ($this->model_inspection->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('name');
            $data['updated_time'] = date("Y-m-d H:i:s");
            if ($this->model_inspection->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function outstanding_release() {
        $this->load->view('inspection/outstanding_release');
    }

    function get_outstanding_release() {
        echo $this->model_inspection->get_outstanding_release();
    }

    function inspection_detail() {
        $this->load->view('inspection/inspection_detail');
    }

    function product_edit() {
        $this->load->view('inspection/product_edit');
    }

    function product_update($id) {
        $data = array(
            "price" => $this->input->post('price'),
            "discount" => (double) $this->input->post('discount')
        );
        if ($this->db->update('inspection_detail', $data, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function inspection_detail_get() {
        echo $this->model_inspection->inspection_detail_get();
    }

    function delete() {
        // $this->db->query("delete from product_order_detail where inspection_detail_id in (select id from inspection_detail where inspection_id=$id)");
        //$this->db->query("delete from inspection_detail where inspection_id=$id");
        if ($this->db->delete('inspection', array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    //----------

    function product_input($inspection_id, $id, $image_category_id) {

        $useragent = $_SERVER['HTTP_USER_AGENT'];
        // if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
        if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|note|ipad|tablet|up\.browser|up\.link|webos|wos)/i", $useragent)) {
            $data = array();
            $data['inspection_id'] = $inspection_id;
            $data['id'] = $id;
            $data['image_category_id'] = $image_category_id;
            // var_dump($data);
            $this->load->view('inspection/input_file', $data);
        } else {
            // echo "<script>alert('Sorry, inspection only allow mobile device');</script>";
            echo json_encode("Sorry, inspection only allow mobile device");
            // exit;
        }
        /*
          if (preg_match("/(windows|linux|)/i", $_SERVER["HTTP_USER_AGENT"])) {
          echo json_encode("Sorry, inspection only allow mobile device");
          } else {
          $data = array();
          $data['inspection_id'] = $inspection_id;
          $data['id'] = $id;
          $data['image_category_id'] = $image_category_id;
          // var_dump($data);
          $this->load->view('inspection/input_file', $data);
          }
         * 
         */
    }

    function product_save($inspectionid, $id, $image_category_id) {

        $data = array(
        );
        $data['user_added'] = $this->session->userdata('name');
        $data['added_time'] = date("Y-m-d H:i:s");
        $data['user_updated'] = $this->session->userdata('name');
        $data['updated_time'] = date("Y-m-d H:i:s");
        $directory = 'files/inspection/' . $inspectionid;

        if (!file_exists($directory)) {
            $oldumask = umask(0);
            mkdir($directory, 0777); // or even 01777 so you get the sticky bit set
            umask($oldumask);
        }
        $allowedImageType = array('jpg', 'png', 'jpeg', 'JPG', 'JPEG', 'PNG');
        $nametemp = 'image-1';
        $uploadTo = $directory;
        if (isset($_FILES[$nametemp]['name']))
            $imageName = $_FILES[$nametemp]['name'];
        else
            echo 'please upload file';
        $tempPath = $_FILES[$nametemp]["tmp_name"];
        //$basename = basename($imageName);

        $imageType = pathinfo($imageName, PATHINFO_EXTENSION);

        $basename = $id . '-' . $inspectionid . '-' . $image_category_id . "." . $imageType; // 5dab1961e93a7_1571494241.jpg
        $originalPath = $directory . '/' . $basename;
        if (!empty($imageName)) {
            if (in_array($imageType, $allowedImageType)) {
                // Upload file to server 
                if (move_uploaded_file($tempPath, $originalPath)) {
                    // echo $nametemp . " was uploaded successfully";
                    $data['filename'] = $basename;
                    if ($this->model_inspection->product_update($data, array("id" => $id))) {
                        echo json_encode(array('success' => true));
                    } else {
                        echo json_encode(array('msg' => $this->db->_error_message()));
                    }
                } else {
                    echo 'image Not uploaded ! try again';
                }
            } else {
                echo $imageType . " image type not allowed";
            }
        }
    }

    function product_delete() {
        $id = $this->input->post('id');
        if ($this->model_inspection->product_delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function prints() {
        $id = $this->input->post('id');
        $this->load->library('pdf');
        $data['inspection'] = $this->model_inspection->select_by_id($id);
        $data['inspection_detail'] = $this->model_inspection->select_image_category_by_inspection_id($id);
        //--------- UNtuk EXCEL ----
        /*
          header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
          header("Content-Disposition: inline; filename=\"inspection.xls\"");
          header("Pragma: no-cache");
          header("Expires: 0");
         */

        //--------- UNtuk WORD ----
        //    header("Content-Type: application/vnd.ms-word; charset=UTF-8");
        //   header("Content-Disposition: inline; filename=\"inspection.doc\"");
        //    header("Pragma: no-cache");
        //    header("Expires: 0");
        $this->load->view('inspection/print', $data);
    }

    function print_summary() {
        $id = $this->input->post('id');
        $this->load->library('pdf');
        $data['shipment'] = $this->model_inspection->select_by_id($id);
        $data['shipment_item'] = $this->model_inspection->select_summarize_by_shipment_id($id);
        $this->load->view('shipment/print_summary', $data);
    }

    function product_image_detail($inspection_id, $id, $image_category_id) {
        $data['ins_detail'] = $this->model_inspection->inspection_detil_get_byid($inspection_id, $id, $image_category_id);
        // var_dump($data);
        $this->load->view('inspection/show_detail', $data);
    }

    function submit() {
        $id = $this->input->post('id');
        $purchaseorder_item_id = $this->input->post('purchaseorder_item_id');

        $data = array(
        );
        $data['user_added'] = $this->session->userdata('name');
        $data['added_time'] = date("Y-m-d H:i:s");
        $data['user_updated'] = $this->session->userdata('name');
        $data['updated_time'] = date("Y-m-d H:i:s");
        $data['submited'] = 'TRUE';
        $data['purchaseorder_item_id'] = $purchaseorder_item_id;
        $data['inspection_date'] = date('Y-m-d');
        // echo 'inspection id='.$id.' dan po itemid='.$purchaseorder_item_id;
        // exit;
        $error_message = "";
        if ($this->model_inspection->update($data, array("id" => $id))) {
            $this->model_inspection->update_po_item_status($purchaseorder_item_id);
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

?>
