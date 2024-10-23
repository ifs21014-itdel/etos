<?php

/**
 * Copyright (C) 2013 BOX Living
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * 		http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author eq
 * @copyright Copyright (c) 2013 BOX Living Pte, Ltd.
 * @package
 * @filesource mod_pdf_label.php
 */
//if (!defined('EXEC')) exit('No direct script access allowed');

class model_label_pdf extends CI_Model {

    private $filenames = array();
    private $names = array();
    private $path = "";
    private $pdf = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('tcpdf/tcpdf');
        $this->load->helper('date');
        $this->load->helper('download');

        $this->path = ROOT . 'temp' . DS;
    }

    public function initialize() {
        $this->pdf->SetCompression(true);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->setPageOrientation('P', true, 4);
        $this->pdf->SetMargins(4, 4, 4);
        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->pdf->AddPage();
    }

    public function set_path($path) {
        $this->path = $path;
    }

    public function generate_label($products) {
        $bx = ROOT . "files/bx-suqare-small.png";
        $bf = ROOT . "files/bf-wide-small.png";

        foreach ($products as $p) {
            $this->pdf = new TCPDF();
            $this->initialize();

            $imagePath = ROOT . "files/products_image" . DS . $p->image;
            $boxes = $this->model_products->box_select_by_product_id($p->products_id);


            $border = array('TRBL' => array('width' => 0.50));
            $line = array('width' => 0.20, 'color' => array(64, 64, 64));
            $line2 = array('width' => 0.50);
            $line_dash = array('color' => array(64, 64, 64), 'width' => 0.25, 'dash' => '5,2.5,5,2.5');
            $txtLeft = 60;
            $txtTop = 8.3;
            $imgTop = 4.3;
            $dashTop = 73.9;
            $vertTop = 4.1;

            if (count($boxes) > 0) {
                foreach ($boxes as $m => $n) {
                    $this->pdf->Rect(4.3, $vertTop, 201.4, $vertTop + 61.9, 'DF', $border, array(255, 255, 255));
                    if (file_exists($imagePath) && is_file($imagePath)) {
                        $image = $this->pdf->Image(
                                $imagePath, 4.6, $imgTop, 51, 50.7, '', '', 'M', true, 300, '', false, false, 0, true, false, false, false);
                    }

                    $image = $this->pdf->Image(
                            $bf, 4.6, $imgTop + 51.7, 50.5, 14, '', '', 'M', true, 300, '', false, false, 0, true, false, false, false);

                    $image = $this->pdf->Image(
                            $bx, 155.2, $imgTop, 50.3, 60, '', '', 'M', true, 300, '', false, false, 0, true, false, false, false);


                    $imgTop += 79.2;
                    $this->pdf->Line(55.1, $vertTop, 55.1, 70, $line);

                    $texts = array(
                        array('ORDER ID.', $p->order_id),
                        array('PRODUCT ID.', $p->product_code),
                        array('PRODUCT NAME', $p->product_name),
                        array('COLOR', $p->color),
                        array('FABRIC', $p->fabric),
                        array('SIZE', number_format($p->width, 0, '.', '.') . ' x ' . number_format($p->depth, 0, '.', '.') . ' x ' . number_format($p->height, 0, '.', '.') . ' mm'),
                        array('REMARKS', ''),
                        array('NETT WEIGHT', ($p->nett ? $p->nett : 0) . ($p->nett > 1 ? ' Kgs' : ' Kg')),
                        array('GROSS WEIGHT', ($p->gross ? $p->gross : 0) . ($p->gross > 1 ? ' Kgs' : ' Kg')),
                        array('BOX', ($m + 1) . ' OF ' . count($boxes))
                    );

                    foreach ($texts as $t => $x) {
                        $this->pdf->SetFont('', 'B', 9);
                        $this->pdf->Text($txtLeft, $txtTop, $x[0]);
                        $this->pdf->Text(90, $txtTop, ':');
                        $this->pdf->SetFont('', '', 9);
                        $this->pdf->Text(95, $txtTop, $x[1]);
                        $txtTop += 5.9;
                    }

                    $this->pdf->Line(154.4, $vertTop, 154.4, $vertTop + 65.9, $line2);
                    $this->pdf->Line(0, $dashTop, 210, $dashTop, $line_dash);
                    $vertTop += $dashTop;
                    $dashTop += 73.9;
                }
            } else {
                $this->pdf->Rect(4.3, $vertTop, 201.4, $vertTop + 61.9, 'DF', $border, array(255, 255, 255));
                if (file_exists($imagePath) && is_file($imagePath)) {
                    $image = $this->pdf->Image(
                            $imagePath, 4.6, $imgTop, 51, 50.7, '', '', 'M', true, 300, '', false, false, 0, true, false, false, false);
                }

                $image = $this->pdf->Image(
                        $bf, 4.6, $imgTop + 51.7, 50.5, 14, '', '', 'M', true, 300, '', false, false, 0, true, false, false, false);
                $image = $this->pdf->Image(
                        $bx, 158, $imgTop, 46, 70, '', '', 'M', true, 300, '', false, false, 0, true, false, false, false);

                $imgTop += 79.2;
                $this->pdf->Line(55.1, 4.1, 55.1, 70, $line);

                $texts = array(
                    array('ORDER ID.', $p->order_id),
                    array('PRODUCT ID.', $p->product_code),
                    array('PRODUCT NAME', $p->product_name),
                    array('COLOR', $p->color),
                    array('FABRIC', $p->fabric),
                    array('SIZE', number_format($p->width, 0, '.', '.') . ' x ' . number_format($p->depth, 0, '.', '.') . ' x ' . number_format($p->height, 0, '.', '.') . ' mm'),
                    array('REMARKS', ''),
                    array('NETT WEIGHT', ($p->nett ? $p->nett : 0) . ($p->nett > 1 ? ' Kgs' : ' Kg')),
                    array('GROSS WEIGHT', ($p->gross ? $p->gross : 0) . ($p->gross > 1 ? ' Kgs' : ' Kg')),
                    array('BOX', '1 OF 1')
                );

                foreach ($texts as $t => $x) {
                    $this->pdf->SetFont('', 'B', 9);
                    $this->pdf->Text($txtLeft, $txtTop, $x[0]);
                    $this->pdf->Text(90, $txtTop, ':');
                    $this->pdf->SetFont('', '', 9);
                    $this->pdf->Text(95, $txtTop, $x[1]);
                    $txtTop += 5.9;
                }

                $this->pdf->Line(154.4, $vertTop, 154.4, $vertTop + 65.9, $line2);
                $this->pdf->Line(0, $dashTop, 210, $dashTop, $line_dash);
                $vertTop += $dashTop;
                $dashTop += 73.9;
            }

            $old = umask();
            umask(0);
            if (!is_dir($this->path . 'labels'))
                mkdir($this->path . 'labels', 0777);
            umask($old);

            $this->filenames[] = $this->path . 'labels' . DS . 'LABEL-' . $p->product_code . '.pdf';
            $this->names[] = 'LABEL-' . $p->product_code . '.pdf';
            $this->pdf->Output($this->path . 'labels' . DS . 'LABEL-' . $p->product_code . '.pdf', 'F');
            $this->pdf->Close();
        }
    }

    public function get_filenames() {
        return $this->filenames;
    }

    public function get_names() {
        return $this->names;
    }

    public function path() {
        return $this->path;
    }

    public function download() {
        //** get the content of the file
        $content = file_get_contents($this->path . $this->filename);
        //** delete the original file before downloading
        unlink($this->path . $this->filename);

        force_download($this->filename, $content);
    }

}
