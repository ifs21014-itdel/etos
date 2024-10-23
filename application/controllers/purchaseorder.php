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
class purchaseorder extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('model_purchaseorder');
         $this->load->model('model_products');
    }

    function index() {
        $this->load->view('purchaseorder/index');
    }

    function create_from_po_editorial() {
        $this->model_purchaseorder->create_from_po_editorial();
    }

    function input() {
        $this->load->view('purchaseorder/input');
    }

    function get() {
        echo $this->model_purchaseorder->get();
    }

    function view() {
        $data['action'] = explode('|', $this->model_user->get_action($this->session->userdata('id'), 22));
        $this->load->view('purchaseorder/purchaseorder', $data);
    }

    function save($id) {
        $order_target_ship_date = $this->input->post('target_ship_date');
        $client_id=$this->input->post('client_id');
        $q_cientid="select code from client where id=".$client_id;
       // echo $q_cientid;
        $po_no=$this->db->query("select po_get_nex_number_new(($q_cientid))")->result();
       // var_dump($po_no);
        $po_no=$po_no[0]->po_get_nex_number_new;
        $data = array(
            "client_id" => $client_id,
            "po_date" => $this->input->post('po_date'),
            "po_client_no" => $this->input->post('po_client_no'),
            "ship_to" => $this->input->post('ship_to'),
            "target_ship_date" => (empty($order_target_ship_date) ? null : $order_target_ship_date),
            "remark" => $this->input->post('remark'),
            "salesman_id" => $this->input->post('salesman_id')
        );

        if ($id == 0) {
            $data['user_added'] = $this->session->userdata('id');
            $data['po_no'] = $po_no;
            $data['added_time'] = date("Y-m-d H:i:s");
            //var_dump($data);
            if ($this->model_purchaseorder->insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['updated_time'] = date("Y-m-d H:i:s");
            if ($this->model_purchaseorder->update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function outstanding_release() {
        $this->load->view('purchaseorder/outstanding_release');
    }

    function get_outstanding_release() {
        echo $this->model_purchaseorder->get_outstanding_release();
    }

    function product_view() {
        $this->load->view('purchaseorder/purchaseorder_product');
    }

    function product_edit() {
        $this->load->view('purchaseorder/product_edit');
    }

    function product_update($id) {
        $data = array(
            "price" => $this->input->post('price'),
            "discount" => (double) $this->input->post('discount')
        );
        if ($this->db->update('purchaseorder_item', $data, array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function product_get() {
        echo $this->model_purchaseorder->product_get();
    }

    function get_serial_number() {
        $this->load->view('purchaseorder/purchaseorder_product_serial_number');
    }
    function product_get_serial_number() {
        echo $this->model_purchaseorder->product_get_serial_number();
    }
    function product_get_available_to_receive($vendor_id) {
        echo $this->model_purchaseorder->product_get_available_to_receive($vendor_id);
    }

    function release() {
        $id = $this->input->post('id');
        $error_message = "";
        $this->db->trans_start();
        if ($this->model_purchaseorder->update(array("release" => 'TRUE'), array("id" => $id))) {
            //if (!$this->db->query("select po_generate_serial_number_new($id)")) {
            if (!$this->db->query("select po_generate_serial_number_new_2($id)")) {
                $error_message = $this->db->_error_message();
            }
        } else {
            $error_message = $this->db->_error_message();
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $error_message));
        }
    }

    function download() {
        $this->load->model('model_company');
        $this->load->library('pdf');
        $id = $this->input->post('id');
        $po = $this->model_purchaseorder->select_by_id($id);
        $po_item = $this->model_purchaseorder->product_select_by_po_id($id);
        $company = $this->model_company->select_by_id($po->company_id);
        $this->load->model('model_proformainvoice');
        $this->load->view('purchaseorder/po_pdf', array('po' => $po, 'po_item' => $po_item, 'path' => '#', 'company' => $company));
    }

    function download_all_by_order_id() {

        $path = ROOT . 'temp';
        $this->load->helper("file"); // load the helper
        delete_files($path, true);

        $this->load->library('pdf');

        $pi_id = $this->input->post('pi_id');

        $this->load->model('model_proformainvoice');
        $this->load->model('model_company');
        $pi = $this->model_proformainvoice->select_by_id($pi_id);

        $all_po = $this->model_purchaseorder->select_all_po_by_order_id($pi_id);
        $dirname = $this->session->userdata('session_id');

        $path = ROOT . 'temp' . DS . $dirname;

        if (!is_dir($path)) {
            mkdir($path, 0777);
        }

        foreach ($all_po as $po) {
            $vendor_path_dir = $path . DS . $po->vendor_code;

            if (!is_dir($vendor_path_dir)) {
                mkdir($vendor_path_dir, 0777);
            }

            $company = $this->model_company->select_by_id($po->company_id);
            $po_item = $this->model_purchaseorder->product_select_by_po_id($po->id);

            $this->load->view('purchaseorder/po_pdf', array('po' => $po, 'po_item' => $po_item, 'path' => $vendor_path_dir, 'company' => $company));

            if ($po->count_base > 0) {

                $po_item_base_top = $this->model_purchaseorder->product_select_top_base_by_po_id($po->id);

                $this->load->view('purchaseorder/os_pdf', array('path' => $vendor_path_dir, 'pi' => $pi, 'po' => $po, 'po_item' => $po_item_base_top, 'company' => $company));

                $label_path = $vendor_path_dir . DS . 'labels';

                if (!is_dir($label_path)) {
                    mkdir($label_path, 0777);
                }
            }
        }
        $this->load->library('zip');
        $this->zip->read_dir($path . '/', false, $path . '/');
        $file_name = $pi->order_id . '.zip';
        $this->zip->download($file_name);
    }

    function download_serial_number() {
//        require_once('../../libraries/tcpdf/tcpdf_barcodes_2d_include.php');
        require_once dirname(__FILE__) . '/../libraries/tcpdf/2dbarcodes.php';
        require_once dirname(__FILE__) . '/../libraries/tcpdf/barcodes.php';
        $id = $this->input->post('id');
        $this->load->model('model_product_order_detail');
        $this->load->library('pdf');
        $data['serial_number'] = $this->model_product_order_detail->select_all_by_po_id($id);
        $data['po'] = $this->model_purchaseorder->select_by_id($id);
        
        //--------- UNtuk EXCEL ----
//            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
//            header("Content-Disposition: inline; filename=\"rekap.xls\"");
//            header("Pragma: no-cache");
//            header("Expires: 0");
        
            //$this->load->view('purchaseorder/generate_serial_number_excel', $data);
        //------------ END OF EXCEL
        //--------- UNtuk WORD ----
       //     header("Content-Type: application/vnd.ms-word; charset=UTF-8");
       //     header("Content-Disposition: inline; filename=\"rekap.doc\"");
       //     header("Pragma: no-cache");
       //     header("Expires: 0");
       // $this->load->view('purchaseorder/generate_serial_number_word', $data);
        //------------ END OF WORD
        
        $this->load->view('purchaseorder/generate_serial_number', $data);
        //$this->load->view('purchaseorder/generate_serial_number2', $data);
    }

    function critical_product_progress() {
        $this->load->view('purchaseorder/critical_product_progress');
    }

    function get_critical_product_progress() {
        echo $this->model_purchaseorder->get_critical_product_progress();
    }

    function delete() {
       // $this->db->query("delete from product_order_detail where purchaseorder_item_id in (select id from purchaseorder_item where purchaseorder_id=$id)");
        //$this->db->query("delete from purchaseorder_item where purchaseorder_id=$id");
        if ($this->db->delete('purchaseorder', array("id" => $this->input->post('id')))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    //----------

    function product_input($client_id) {
        $data=array();
        $data['client_id']=$client_id;
        $this->load->view('purchaseorder/product_input',$data);
    }

    function product_save($purchaseorderid, $id) {
        $qty = $this->input->post('qty');
        $productid = $this->input->post('product_id');
        $packing_conf=$this->model_products->getbyid($productid);
        $packing_conf_val=$packing_conf->packing_configuration;
        //echo "packing conf=".$packing_conf_val;

        //$q1 = "select packing_configuration from products where id='" . $productid . "'";
        //echo $q1;
/*
        if ($this->db->query($q1)) {
            $eks2 = array();
            $eks2 = $this->db->query($q1)->row();
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
        $packing_conf_val = $eks2->packing_configuration;
 * 
 */
        $label_qty = (double) ($qty * $packing_conf_val);
        //var_dump($eks2);
        $data = array(
            "qty" => $qty,
            "product_id" => $productid,
            "label_qty" => $label_qty,
            "promise_date" => $this->input->post('promise_date'),
            "line" => $this->input->post('line'),
            "release_no" => $this->input->post('release_no'),
            "tagfor" => $this->input->post('tagfor'),
            "remarks" => $this->input->post('remarks'),
            "finishing" => $this->input->post('finishing'),
            "description" => $this->input->post('description')
        );
        if ($id == 0) {
            $data['purchaseorder_id'] = $purchaseorderid;
            $data['user_added'] = $this->session->userdata('id');
            $data['added_time'] = date("Y-m-d H:i:s");
            if ($this->model_purchaseorder->product_insert($data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        } else {
            $data['user_updated'] = $this->session->userdata('id');
            $data['updated_time'] = date("Y-m-d H:i:s");

            if ($this->model_purchaseorder->product_update($data, array("id" => $id))) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('msg' => $this->db->_error_message()));
            }
        }
    }

    function product_delete() {
        $id = $this->input->post('id');
        if ($this->model_purchaseorder->product_delete(array("id" => $id))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}

?>
