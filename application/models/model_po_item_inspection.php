<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_po_item_inspection
 *
 * @author hp
 */
class model_po_item_inspection extends CI_Model {

    //put your view_position here
    public function __construct() {
        parent::__construct();
    }

    function select_result() {
        $this->db->order_by("id", 'asc');
        return $this->db->get('po_item_inspection')->result();
    }

    function get() {
        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $sort = $this->input->post('sort');
        $order = $this->input->post('order');



        if (!empty($sort)) {
            $arr_sort = explode(',', $sort);
            $arr_order = explode(',', $order);
            if (count($arr_sort) == 1) {
                $order_specification = " $arr_sort[0] $arr_order[0] ";
            } else {
                $order_specification = " $arr_sort[0] $arr_order[0] ";
                for ($i = 1; $i < count($arr_sort); $i++) {
                    $order_specification .= ", $arr_sort[$i] $arr_order[$i] ";
                }
            }
        } else {
            $order_specification = " poi.id asc";
        }
        $query = "select poi.*,c.name client_name,po.po_client_no,p.ebako_code,p.customer_code,c.id client_id,p.description,p.material,p.finishing "
                . " from purchaseorder_item poi"
                . " JOIN purchaseorder po on po.id=poi.purchaseorder_id "
                . " JOIN products p on poi.product_id=p.id "
                . " JOIN client c on c.id=po.client_id where poi.inspected='FALSE' ";

        //----------- search parameter for grid ----------------------
        $ebako_code = $this->input->post('ebako_code');
        $customer_code = $this->input->post('customer_code');
        $po_client_no = $this->input->post('po_client_no');
        if (!empty($ebako_code)) {
            $query .= " and p.ebako_code like '$ebako_code%' ";
        }
        if (!empty($customer_code)) {
            $query .= " and p.customer_code like '$customer_code%' ";
        }
        if (!empty($po_client_no)) {
            $query .= " and po.po_client_no like '$po_client_no%' ";
        }
        $q = strtolower($this->input->post('q'));
        if (!empty($q)) {
            $query .= " AND (LOWER(p.ebako_code) LIKE '%" . $q . "%' OR LOWER(p.customer_code) LIKE '%" . $q . "%' or po.po_client_no like '%" . $q . "%')";
        }
        //----------------------
        $query .= " order by $order_specification";
        //var_dump($query);
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

    function selectAllResult() {
        return $this->db->get('po_item_inspection')->result();
    }

    function select_by_id($id) {
        return $this->db->get_where('po_item_inspection', array('id' => $id))->row();
    }

    function get_max_id() {
        return $this->db->query("select max(id) as maks_id from inspection where true")->result();
    }

    function insert($poitemid) {
        $client_id = $this->input->post('client_id');
        $ebako_code = $this->input->post('ebako_code');
        $customer_code = $this->input->post('customer_code');
        $client_name = $this->input->post('client_name');
        $po_client_no = $this->input->post('po_client_no');
        $jlhimage = $this->input->post('jlhimage');
        /*
          $client_id = $_REQUEST['client_id'];
          $ebako_code = $_REQUEST['ebako_code'];
          $customer_code = $_REQUEST['customer_code'];
          $client_name = $_REQUEST['client_name'];
          $po_client_no = $_REQUEST['po_client_no'];
          $jlhimage = $_REQUEST['jlhimage'];
          // exit;
         * 
         */

        $data = array(
            "client_id" => $client_id,
            "ebako_code" => $ebako_code,
            "customer_code" => $customer_code,
            "client_name" => $client_name,
            "po_client_no" => $po_client_no,
            "inspection_date" => date('Y-m-d'),
            "purchaseorder_item_id" => $poitemid,
            "submited" => 't'
        );
        //var_dump($data);
        // exit;
        $data['user_added'] = $this->session->userdata('name');
        $data['added_time'] = date("Y-m-d H:i:s");
        $data['user_updated'] = $this->session->userdata('name');
        $data['updated_time'] = date("Y-m-d H:i:s");
        // var_dump($data);exit;
        if ($this->db->insert('inspection', $data)) {
            //echo json_encode(array('success' => true));

            $maxid = $this->model_po_item_inspection->get_max_id();
            $nomaxid = $maxid[0]->maks_id;
            $directory = 'files/inspection/' . $nomaxid;
            $oldumask = umask(0);
            mkdir($directory, 0777); // or even 01777 so you get the sticky bit set
            umask($oldumask);
            $allowedImageType = array('jpg', 'png', 'jpeg', 'JPG', 'JPEG', 'PNG');
            for ($y = 1; $y <= $jlhimage; $y++) {
                $nametemp = 'image-' . $y;

                $uploadTo = $directory;
                if (isset($_FILES[$nametemp]['name']))
                    $imageName = $_FILES[$nametemp]['name'];
                else
                    continue;
                $tempPath = $_FILES[$nametemp]["tmp_name"];
                //$basename = basename($imageName);

                $imageType = pathinfo($imageName, PATHINFO_EXTENSION);

                $basename = $nomaxid . '' . $nametemp . "." . $imageType; // 5dab1961e93a7_1571494241.jpg
                $originalPath = $directory . '/' . $basename;
                if (!empty($imageName)) {
                    if (in_array($imageType, $allowedImageType)) {
                        // Upload file to server 
                        if (move_uploaded_file($tempPath, $originalPath)) {
                            // echo $nametemp . " was uploaded successfully";
                            $data2 = array(
                                "isnpection_id" => $nomaxid,
                                "image_category_id" => $y,
                                "filename" => $basename
                            );
                            $data2['user_added'] = $this->session->userdata('name');
                            $data2['added_time'] = date("Y-m-d H:i:s");
                            $data2['user_updated'] = $this->session->userdata('name');
                            $data2['updated_time'] = date("Y-m-d H:i:s");
                            $this->db->insert('inspection_detail', $data2);
                        } else {
                            echo 'image Not uploaded ! try again';
                        }
                    } else {
                        echo $imageType . " image type not allowed";
                    }
                }
            }
            //---------
            $data3 = array(
                "inspected" => 't'
            );
            $where = array("id" => $poitemid);
            $this->db->update('purchaseorder_item', $data3, $where);
            //---------
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function update($id) {
        $view_position = $this->input->post('view_position');
        $description = $this->input->post('description');
        $data = array(
            "view_position" => $view_position,
            "description" => $description,
            "mandatory" => $this->input->post('mandatory')
        );
        $where = array("id" => $id);
        if ($this->db->update('po_item_inspection', $data, $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function delete() {
        //return $this->db->delete('po_item_inspection', $where);
        $id = $this->input->post('id');
        $where = array("id" => $id);
        if ($this->db->delete('po_item_inspection', $where)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

}

?>