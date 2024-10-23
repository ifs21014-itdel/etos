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
 * @filesource model_checksheet_pdf.php
 */
//if (!defined('EXEC')) exit('No direct script access allowed');

class model_checksheet_pdf extends CI_Model {

    private $total_box = 0;
    private $total_volume = 0;
    private $total_price = 0;
    private $total_quantity = 0;
    private $current_page = 1;
    private $current_line = 0;
    private $current_row = 1;
    private $margin_top = 37.3;
    private $pages = 1;
    private $total_pages = 0;
    private $filename = "";
    private $path = "";
    private $pdf = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('tcpdf/tcpdf');
        $this->load->model('model_products');
        $this->load->helper('date');
        $this->load->helper('download');

        $this->path = ROOT . 'temp' . DS;
        $this->pdf = new TCPDF();
    }

    public function initialize() {
        $this->pdf->setPageOrientation('L', true, 4);
        $this->pdf->SetCompression(true);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->SetMargins(4, 4, 4);
        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->pdf->AddPage();
    }

    public function set_path($path) {
        $this->path = $path;
    }

    private function content_header($first_page = true) {
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->MultiCell(19, 6, "PRODUCT ID\n\n", array('BR' => array('width' => 0.25), 'LT' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(28, 6, "PRODUCT NAME\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(21, 6, "IMAGE\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10, 6, "QTY\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(32, 6, "DIMENSION\n(mm)\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(11, 6, "VOL\n(m3)\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(20, 6, "MATERIAL\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(20, 6, "FABRICS\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(15, 6, "COLOR", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(90, 6, "\n\n", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(23, 3, "STATUS", array('TR' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->Ln();

        if ($first_page == true) {
            $this->pdf->SetXY(180, 33.9);
        } else {
            $this->pdf->SetXY(180, 7);
        }

        for ($o = 1; $o <= 12; $o++)
            $this->pdf->MultiCell(7.5, 3, "$o", array('TBR' => array('width' => 0.25)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);

        $this->pdf->MultiCell(11.5, 3, "PASS", array('TBR' => array('width' => 0.25)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(11.5, 3, "FAIL", array('TB' => array('width' => 0.25), 'R' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->Ln();
    }

    public function create_header($order) {
        $this->pdf->SetCellPadding(2);
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(50, 5, "PT. GENERASI PRODUK INDONESIA", array('LT' => array('width' => 0.50), 'B' => array('width' => 0.25)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 5, "Jl. Putri Tunggal Gg. Bungur II No. 78 - Kp. Pedurenan, Harjamukti, Cimanggis +6221 727 9246", array('TR' => array('width' => 0.50), 'B' => array('width' => 0.25)), '', 'R');
        $this->pdf->Ln();

        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(25, 0, "", array('L' => array('width' => 0.50)));
        $this->pdf->Cell(220, 0, "", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(25, 0, "P.O.", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(220, 0, ": " . $order->id . 'sementara', array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(25, 0, " ", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(220, 0, " ", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(25, 0, " ", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(220, 0, " ", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->SetFont('', 'B', 28);
        $this->pdf->Text(248, 11, "C.S.");
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(25, 0, "", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(220, 0, "", array('R' => array('width' => 0.25)));
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(0, 0, "CHECK SHEET", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->Cell(25, 0, "", array('LB' => array('width' => 0.50)));
        $this->pdf->Cell(220, 0, "", array('R' => array('width' => 0.25), 'B' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('RB' => array('width' => 0.50)));
        $this->pdf->Ln(4.5);
    }

    private function add_empty_row($row, $max, $bottombold = FALSE) {
        $lines = array('R' => array('width' => 0.25));
        $left = array('L' => array('width' => 0.50), 'R' => array('width' => 0.25));

        if ($row == $max) {
            $lines['B'] = array('width' => ($bottombold ? 0.50 : 0.25));
            $left['B'] = array('width' => ($bottombold ? 0.50 : 0.25));
        }

        $this->pdf->MultiCell(19, 20.5, " ", $left, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(28, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(21, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10.66, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10.66, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(10.66, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(11, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(20, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(20, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(15, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        for ($o = 1; $o <= 12; $o++)
            $this->pdf->MultiCell(7.5, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell(11.5, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $lines['R'] = array('width' => 0.50);
        $this->pdf->MultiCell(11.5, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->Ln();
    }

    public function generate_content($order, $products) {
        $this->content_header();

        $total_product = count($products);
        if ($total_product <= 7) {
            $this->total_pages = 1;
        } else {
            $t = $total_product - 8;
            $pages = 1 + ceil($t / 10) + ($t % 10);
            $this->total_pages = $pages;
        }

        $this->current_row = 1;
        $this->current_line = 0;

        foreach ($products as $p) {
            $boxes = $this->model_products->box_select_by_product_id($p->products_id);

            $box_count = 0;
            $volume = 0;

            //** boxes volume
            foreach ($boxes as $b) {
                $box_count++;
            }


            //** total volume

            $this->total_box += ($box_count * $p->qty);
            $this->total_volume += ($p->volume * $p->qty);

            $this->total_quantity += $p->qty;

            $lines = array();
            $leftLines = array('L' => array('width' => 0.50), 'R' => array('width' => 0.25));

            if ($this->total_pages == 1) {
                if ($this->current_row == 6 && count($products) == 6) {
                    $lines = array('B' => array('width' => 0.25), 'R' => array('width' => 0.25));
                    $leftLines['B'] = array('width' => 0.25);
                } else {
                    $lines = array('R' => array('width' => 0.25));
                }
            } else {
                if ($this->current_page == 1) {
                    if ($this->current_row == 8) {
                        $lines = array('B' => array('width' => 0.50), 'R' => array('width' => 0.25));
                        $leftLines['B'] = array('width' => 0.50);
                    } else {
                        $lines = array('R' => array('width' => 0.25));
                    }
                } else {
                    if ($this->current_row == 9) {
                        $lines = array('B' => array('width' => 0.50), 'R' => array('width' => 0.25));
                        $leftLines['B'] = array('width' => 0.50);
                    } else {
                        $lines = array('R' => array('width' => 0.25));
                    }
                }
            }

            $this->pdf->SetFont('', '', 6);
            $this->pdf->SetCellPadding(0.75);

            $this->pdf->MultiCell(19, 20.5, $p->product_code, $leftLines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(28, 20.5, $p->product_name, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(21, 20.5, "", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(10, 20.5, $p->qty, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(10.66, 20.5, $p->width, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(10.66, 20.5, $p->depth, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(10.66, 20.5, $p->height, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(11, 20.5, number_format(($p->volume * $p->qty), 3, '.', ','), $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(20, 20.5, $p->material, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(20, 20.5, $p->fabric, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->MultiCell(15, 20.5, $p->color, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            if ($this->current_row >= 8) {
                if ($this->total_pages == 1) {
                    $lines['B'] = array('width' => 0.50);
                } else {
                    if ($this->current_page == 1) {
                        if ($this->current_row == 8) {
                            $lines['B'] = array('width' => 0.50);
                        } else {
                            $lines['B'] = array('width' => 0.25);
                        }
                    } else {
                        if ($this->current_row >= 9) {
                            $lines['B'] = array('width' => 0.50);
                        } else {
                            $lines['B'] = array('width' => 0.25);
                        }
                    }
                }
            } else {
                $lines['B'] = array('width' => 0.25);
            }
            for ($o = 1; $o <= 12; $o++) {
                $this->pdf->MultiCell(7.5, 20.5, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            }
            $this->pdf->MultiCell(11.5, 20.5, "", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $lines['R'] = array('width' => 0.50);
            $this->pdf->MultiCell(11.5, 20.5, "", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
            $this->pdf->Ln(20.5);

            $imagePath = ROOT . "assets/media/products" . $p->image;
            $imagePath = $p->image;
            if (file_exists($imagePath) && is_file($imagePath)) {
                $image = $this->pdf->Image(
                        $imagePath, 51.5, $this->margin_top + (20.5 * $this->current_line), 20, 20, '', '', '', true, 300, '', false, false, 0, true, false, false, false);
            }

            $this->current_row++;
            ++$this->current_line;

            if ($this->total_pages == 1) {
                if (count($products) > 6) {
                    if ($this->current_row == 7) {
                        $this->total_pages++;
                        $this->current_page++;
                        $this->current_row = 1;
                        $this->margin_top = 10.5;
                        $this->current_line = 0;
                        $this->add_empty_row(8, 9, TRUE);
                        $this->add_empty_row(9, 9, TRUE);
                        $this->pdf->AddPage();
                        $this->content_header(false);
                    }
                }
            } else {
                if ($this->current_page == 1) {
                    if ($this->current_row == 9) {
                        $this->current_page++;
                        $this->current_row = 1;
                        $this->margin_top = 10.5;
                        $this->current_line = 0;
                        $this->pdf->AddPage();
                        $this->content_header(false);
                    }
                } else {
                    //** count last page first
                    if ($this->current_page == $this->total_pages) {
                        if ($this->current_row == 9) {
                            $this->current_page++;
                            $this->current_row = 1;
                            $this->margin_top = 10.5;
                            $this->current_line = 0;
                            $this->pdf->AddPage();
                            $this->content_header(false);
                        }
                    } else {
                        if ($this->current_row == 10) {
                            $this->current_page++;
                            $this->current_row = 1;
                            $this->margin_top = 10.5;
                            $this->current_line = 0;
                            $this->pdf->AddPage();
                            $this->content_header(false);
                        }
                    }
                }
            }
        }

        if ($this->total_pages == 1) {
            if ($this->current_row <= 6) {
                $max = 7 - $this->current_row;
                for ($i = 0; $i < $max; $i++) {
                    $this->add_empty_row($i + 1, $max);
                }
            } else {
                $max = 7 - $this->current_row;
                for ($i = 0; $i < $max; $i++) {
                    $this->add_empty_row($i + 1, $max);
                }
            }
        } else {
            if ($this->current_page == 1) {
                if ($this->current_row < 10) {
                    $max = 9 - $this->current_row;
                    for ($i = 0; $i < $max; $i++) {
                        $this->add_empty_row($i + 1, $max);
                    }
                }
            } else {
                if ($this->current_row < 10) {
                    $max = 9 - $this->current_row;
                    for ($i = 0; $i < $max; $i++) {
                        $this->add_empty_row($i + 1, $max);
                    }
                }
            }
        }

        $this->pdf->SetCellPadding(0);
        $this->pdf->SetFont('', '0', 2);
        $this->pdf->Cell(0, 0, " ", array('B' => array('width' => 0.25), 'LR' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->setCellPaddings(2.50, 2, 2.50, 0);
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(248, 0, "LOADING DETAILS", array('R' => array('width' => 0.25), 'L' => array('width' => 0.50)));
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(41, 0, "TOTAL QUANTITY :", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(80.5, 0, "TRUCK ID :", array('L' => array('width' => 0.50)));
        $this->pdf->Cell(167.5, 0, "QC ID :", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(41, 0, $this->total_quantity . ' items', array('R' => array('width' => 0.50), 'B' => array('width' => 0.25)), 0, 'R');
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(80.5, 0, "CONTAINER SEAL :", array('L' => array('width' => 0.50)));
        $this->pdf->Cell(167.5, 0, "START :", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(41, 0, "TOTAL VOLUME  :", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->Cell(80.5, 0, "WEATHER :", array('LB' => array('width' => 0.50)));
        $this->pdf->Cell(167.5, 0, "END :", array('R' => array('width' => 0.25), 'B' => array('width' => 0.50)));
        $this->pdf->Cell(41, 0, number_format($this->total_volume, 3, '.', ',') . ' m3', array('RB' => array('width' => 0.50), 'B' => array('width' => 0.25)), 0, 'R');

        $this->pdf->Ln(6);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(0, 0, " ", array('TLR' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->Cell(0, 0, "Product image are for reference only, it is not the illustrations of your final order.", array('LR' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, " ", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(0, 0, "", array('BL' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('BR' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('BR' => array('width' => 0.50)));
        $this->pdf->Ln();

        $old = umask();
        umask(0);
        if (!is_dir($this->path))
            mkdir($this->path, 0777);
        umask($old);

        $this->filename = 'CS-' . $order->id . '.pdf';
        $this->pdf->Output($this->path . $this->filename, 'F');
        $this->pdf->Close();
    }

    public function get_filename() {
        return $this->path . $this->filename;
    }

    public function get_name() {
        return $this->filename;
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
