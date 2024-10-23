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
 * @filesource mod_pdf_purchase_order.php
 */
class model_purchaseorder_pdf extends CI_Model {

    private $total_box = 0;
    private $total_volume = 0;
    private $total_price = 0;
    private $current_page = 1;
    private $current_line = 0;
    private $current_row = 1;
    private $margin_top = 83.7;
    private $pages = 1;
    private $total_pages = 0;
    private $filename = "";
    private $filenames = array();
    private $names = array();
    private $path = "";
    private $pdf = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('tcpdf/tcpdf');
        $this->load->model('model_products');
        $this->load->model('model_proformainvoice');
        $this->load->model('model_proformainvoice_os_pdf');
        $this->load->model('model_checksheet_pdf');
        $this->load->model('model_label_pdf');
        $this->load->helper('date');
        $this->load->helper('download');
    }

    public function initialize() {
        $this->pdf->setPageOrientation('L', true, 4);
        $this->pdf->SetCompression(true);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->SetMargins(4, 4, 4);
        $this->pdf->AddPage();
    }

    public function set_path($path) {
        $this->path = ROOT . 'temp' . DS . $path;
    }

    private function content_header($vendor, $has_fabric) {
        $this->pdf->SetFont('', 'B', 6);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->MultiCell((!$has_fabric ? 23 : 47), 6, "PRODUCT ID", array('BR' => array('width' => 0.25), 'LT' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(24, 6, "VENDOR CODE", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell((!$has_fabric ? 39 : 129), 6, "PRODUCT NAME", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(33, 6, "SERIAL NUMBER", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(31.98, 6, "DIMENSION", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell((!$has_fabric ? 10 : 20), 6, "QTY", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(20, 6, "MATERIAL", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(22, 6, "COLOR", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(23, 6, "FABRIC", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell((!$has_fabric ? 24 : 34), 6, "UNIT PRICE\n(" . $vendor->currency_code . ")", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell((!$has_fabric ? 15 : 25), 6, "DISC (%)", array('BR' => array('width' => 0.25), 'T' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell((!$has_fabric ? 24 : 34), 6, "LINE TOTAL\n(" . $vendor->currency_code . ")", array('B' => array('width' => 0.25), 'TR' => array('width' => 0.50)), 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->Ln();
    }

    private function create_header($po) {
        $this->pdf->SetCellPadding(2);
        $this->pdf->SetFont('', 'B', 7);
        $this->pdf->Cell(50, 5, "PT. GENERASI PRODUK INDONESIA", array('LT' => array('width' => 0.50), 'B' => array('width' => 0.25)));
        $this->pdf->SetFont('', '', 7);
        $this->pdf->Cell(0, 5, "Jl. Putri Tunggal Gg. Bungur II No. 78 - Kp. Pedurenan, Harjamukti, Cimanggis +6221 727 9246", array('TR' => array('width' => 0.50), 'B' => array('width' => 0.25)), '', 'R');
        $this->pdf->Ln();

        $this->pdf->SetFont('Helvetica', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(107, 0, "", array('L' => array('width' => 0.50)));
        $this->pdf->Cell(130, 0, "", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "P.O. NUMBER", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('Helvetica', '', 7);
        $this->pdf->Cell(70, 0, ": " . $po->po_no);
        $this->pdf->SetFont('Helvetica', 'B', 7);
        $this->pdf->Cell(33, 0, "VENDOR");
        $this->pdf->SetFont('Helvetica', '', 7);
        $this->pdf->Cell(101, 0, ": " . $po->vendor_name, array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->SetFont('Helvetica', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "ORDER DATE", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('Helvetica', '', 7);
        $this->pdf->Cell(70, 0, ": " . date('d M Y', strtotime($po->date)));
        $this->pdf->SetFont('Helvetica', 'B', 7);
        $this->pdf->Cell(33, 0, "ADDRESS");
        $this->pdf->SetFont('Helvetica', '', 7);
        $this->pdf->Cell(101, 0, ": " . $po->vendor_address, array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();

        $this->pdf->SetFont('Helvetica', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "ORDER DATE REVISION", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('Helvetica', '', 7);
        $this->pdf->Cell(204, 0, ": " . date('d M Y'), array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('Helvetica', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "TARGET SHIP DATE", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('Helvetica', '', 7);
        $this->pdf->Cell(204, 0, ": " . (!empty($po->target_ship_date) ? date('d M Y', strtotime($po->target_ship_date)) : ''), array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->Ln();
        $this->pdf->SetFont('Helvetica', 'B', 7);
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "", array('L' => array('width' => 0.50)));
        $this->pdf->SetFont('Helvetica', '', 7);
        $this->pdf->Cell(204, 0, "", array('R' => array('width' => 0.25)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50)));
        $this->pdf->SetFont('Helvetica', 'B', 28);
        $this->pdf->Text(241.7, 15, "P.O.");
        $this->pdf->Ln();
        $this->pdf->SetFont('Helvetica', 'B', 9);
        $this->pdf->Text(242, 25.8, "PURCHASE ORDER");
        $this->pdf->Ln();
        $this->pdf->setCellPaddings(2.50, 0, 2.50, 0);
        $this->pdf->Cell(33, 0, "", array('L' => array('width' => 0.50), 'B' => array('width' => 0.50)));
        $this->pdf->Cell(204, 0, "", array('R' => array('width' => 0.25), 'B' => array('width' => 0.50)));
        $this->pdf->Cell(0, 0, "", array('R' => array('width' => 0.50), 'B' => array('width' => 0.50)));
        $this->pdf->Ln(6);
    }

    private function add_empty_row($row, $max, $has_fabric) {
        $lines = array('R' => array('width' => 0.25));
        $left = array('L' => array('width' => 0.50), 'R' => array('width' => 0.25));

        if ($row == $max) {
            $lines['B'] = array('width' => 0.25);
            $left['B'] = array('width' => 0.25);
        }

        $this->pdf->SetFont('', '', 6);
        $this->pdf->SetCellPadding(0.75);

        $this->pdf->MultiCell((!$has_fabric ? 23 : 47), 0, " ", $left, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(24, 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell((!$has_fabric ? 39 : 129), 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(33, 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(10.66, 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(10.66, 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(10.66, 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell((!$has_fabric ? 10 : 20), 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(20, 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(22, 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        if (!$has_fabric)
            $this->pdf->MultiCell(23, 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell((!$has_fabric ? 24 : 34), 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->MultiCell((!$has_fabric ? 15 : 25), 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $lines['R'] = array('width' => 0.50);
        $this->pdf->MultiCell((!$has_fabric ? 24 : 34), 0, " ", $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->pdf->Ln();
    }

    public function generate_content($po) {
        //print "<pre>";
        //print_r($vendor);
        //print "</pre>";

        $has_fabric = false;

        foreach ($po as $po) {
            $content_header = false;
            $this->pdf = new TCPDF();
            $this->initialize();
            $this->create_header($po);

            $total_product = count($po->item);
            if ($total_product <= 21) {
                $this->total_pages = 1;
            } else {
                $t = $total_product - 21;
                $pages = 1 + ceil($t / 21) + ($t % 21);
                $this->total_pages = $pages;
            }

            $this->total_box = 0;
            $this->total_volume = 0;
            $this->total_price = 0;
            $this->current_row = 1;
            $this->current_line = 0;


            foreach ($po->item as $p) {

                if (!$content_header) {
                    $this->content_header($po, false);
                    $content_header = true;
                }

                $boxes = $this->model_products->box_select_by_product_id($p->products_id);

                $box_count = 0;
                $volume = 0;

                //** boxes volume
                foreach ($boxes as $b) {
                    $volume += ($b->width * $b->height * $b->depth) / 1000000000;
                    $box_count++;
                }

                //** total volume
                $this->total_volume += $volume;

                $this->total_box += ($box_count * $p->qty);

                $lines = array();
                $leftLines = array('L' => array('width' => 0.50), 'R' => array('width' => 0.25));

                if ($this->total_pages == 1) {
                    if ($this->current_row == 21 && $total_product > 10) {
                        $lines = array('B' => array('width' => 0.50), 'R' => array('width' => 0.25));
                        $leftLines['B'] = array('width' => 0.50);
                    } else {
                        $lines = array('R' => array('width' => 0.25));
                    }
                } else {
                    if ($this->current_page == 1) {
                        if ($this->current_row == 29) {
                            $lines = array('B' => array('width' => 0.50), 'R' => array('width' => 0.25));
                            $leftLines['B'] = array('width' => 0.50);
                        } else {
                            $lines = array('R' => array('width' => 0.25));
                        }
                    } else {
                        if ($this->current_row == 29) {
                            $lines = array('B' => array('width' => 0.50), 'R' => array('width' => 0.25));
                            $leftLines['B'] = array('width' => 0.50);
                        } else {
                            $lines = array('R' => array('width' => 0.25));
                        }
                    }
                }

                $this->pdf->SetFont('', '', 6);
                $this->pdf->SetCellPadding(1.50);
                $this->pdf->MultiCell(23, 0, $p->item_code, $leftLines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(24, 0, $p->vendor_item_code, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(39, 0, $p->item_description, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(33, 0, '', $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(10.66, 0, $p->width, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(10.66, 0, $p->depth, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(10.66, 0, $p->height, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(10, 0, $p->qty, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(20, 0, $p->material, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(22, 0, $p->color, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(23, 0, $p->fabric, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(24, 0, number_format($p->price, 2, ',', '.'), $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->MultiCell(15, 0, $p->discount, $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $lines['R'] = array('width' => 0.50);
                $this->pdf->MultiCell(24, 0, number_format($p->total, 2, ',', '.'), $lines, 'C', false, 0, '', '', true, 0, false, true, 0, 'M', false);
                $this->pdf->Ln();

                $this->current_row++;
                ++$this->current_line;

                if ($this->total_pages == 1) {
                    if ($total_product > 21) {
                        if ($this->current_row == 30) {
                            $this->current_page++;
                            $this->current_row = 1;
                            $this->margin_top = 13;
                            $this->current_line = 0;
                            $this->pdf->AddPage();
                            $this->content_header($v, $has_fabric);
                        }
                    }
                } else {
                    if ($this->current_page == 1) {
                        if ($this->current_row == 30) {
                            $this->current_page++;
                            $this->current_row = 1;
                            $this->margin_top = 13;
                            $this->current_line = 0;
                            $this->pdf->AddPage();
                            $this->content_header($v, $has_fabric);
                        }
                    } else {
                        //** count last page first
                        if ($this->current_page == $this->total_pages) {
                            if ($this->current_row == 25) {
                                $this->current_page++;
                                $this->current_row = 1;
                                $this->margin_top = 13;
                                $this->current_line = 0;
                                $this->pdf->AddPage();
                                $this->content_header($v, $has_fabric);
                            }
                        } else {
                            if ($this->current_row == 30) {
                                $this->current_page++;
                                $this->current_row = 1;
                                $this->margin_top = 13;
                                $this->current_line = 0;
                                $this->pdf->AddPage();
                                $this->content_header($v, $has_fabric);
                            }
                        }
                    }
                }
            }

            if ($this->total_pages == 1) {
                if ($total_product <= 21) {
                    if ($this->current_row <= 21) {
                        $max = 21 - $this->current_row;
                        for ($i = 0; $i < $max; $i++) {
                            $this->add_empty_row($i + 1, $max, $has_fabric);
                        }
                    }
                } else {
                    if ($this->current_row < 30) {
                        $max = 30 - $this->current_row;
                        for ($i = 0; $i < $max; $i++) {
                            $this->add_empty_row($i + 1, $max, $has_fabric);
                        }
                    }
                }
            } else {
                if ($this->current_row < 29) {
                    $max = 29 - $this->current_row;
                    for ($i = 0; $i < $max; $i++) {
                        $this->add_empty_row($i + 1, $max, $has_fabric);
                    }
                }
            }

            $this->pdf->SetFont('Helvetica', '0', 2);
            $this->pdf->SetCellPadding(0);
            $this->pdf->Cell(0, 0, "", array('B' => array('width' => 0.25), 'LR' => array('width' => 0.50)));
            $this->pdf->Ln();


            $this->pdf->SetFont('Helvetica', 'B', 6);
            $this->pdf->setCellPaddings(2.50, 2.50, 2.50, 0);
            $this->pdf->Cell(190, 0, "REMARKS :", array('R' => array('width' => 0.25), 'L' => array('width' => 0.50)));
            $this->pdf->Cell(75, 0, "TOTAL :", array('BR' => array('width' => 0.25)));
            $this->pdf->Cell(24, 0, number_format($po->total, 2, '.', '.'), array('B' => array('width' => 0.25), 'R' => array('width' => 0.50)), 0, 'R');
            $this->pdf->Ln();
            $this->pdf->setCellPaddings(2.50, 1.50, 2.50, 0);
            $this->pdf->Cell(190, 0, $po->remark, array('R' => array('width' => 0.25), 'L' => array('width' => 0.50)));
            $this->pdf->Cell(42, 0, "VAT.", array('RB' => array('width' => 0.25)));
            $this->pdf->Cell(33, 0, $po->vat . ' %', array('RB' => array('width' => 0.25)));
            $this->pdf->Cell(24, 0, number_format($po->vat_nominal, 2, '.', '.'), array('B' => array('width' => 0.25), 'R' => array('width' => 0.50)), 0, 'R');
            $this->pdf->Ln();
            $this->pdf->setCellPaddings(2.50, 1.50, 2.50, 0);
            $this->pdf->Cell(190, 0, "", array('R' => array('width' => 0.25), 'L' => array('width' => 0.50)));
            $this->pdf->Cell(42, 0, "DOWN PAYMENT", array('RB' => array('width' => 0.25)));
            $this->pdf->Cell(18, 0, date('d M Y', strtotime($po->down_payment_date)), array('RB' => array('width' => 0.25)));
            $this->pdf->Cell(15, 0, $po->down_payment . " %", array('RB' => array('width' => 0.25)));
            $this->pdf->Cell(24, 0, number_format($po->down_payment_nominal, 2, '.', '.'), array('B' => array('width' => 0.25), 'R' => array('width' => 0.50)), 0, 'R');
            $this->pdf->Ln();
            $this->pdf->setCellPaddings(2.50, 1.50, 2.50, 0);
            $this->pdf->Cell(190, 0, "", array('R' => array('width' => 0.25), 'LB' => array('width' => 0.50)));
            $this->pdf->Cell(75, 0, "BALANCE DUE", array('R' => array('width' => 0.25), 'B' => array('width' => 0.50)));
            $this->pdf->Cell(24, 0, number_format($po->balance_due, 2, '.', '.'), array('RB' => array('width' => 0.50)), 0, 'R');
            $this->pdf->Ln(6);

            $this->pdf->Cell(57.8, 0, "PREPARED BY", array('LB' => array('width' => 0.25), 'LT' => array('width' => 0.50)), 0, 'C');
            $this->pdf->Cell(57.8, 0, "PPIC", array('LB' => array('width' => 0.25), 'T' => array('width' => 0.50)), 0, 'C');
            $this->pdf->Cell(57.8, 0, "GENERAL MANAGER", array('LB' => array('width' => 0.25), 'T' => array('width' => 0.50)), 0, 'C');
            $this->pdf->Cell(57.8, 0, "FINANCE", array('LB' => array('width' => 0.25), 'T' => array('width' => 0.50)), 0, 'C');
            $this->pdf->Cell(57.8, 0, "DIRECTOR", array('LB' => array('width' => 0.25), 'RT' => array('width' => 0.50)), 0, 'C');
            $this->pdf->Ln();
            $this->pdf->Cell(57.8, 20, "", array('LB' => array('width' => 0.50)));
            $this->pdf->Cell(57.8, 20, "", array('LR' => array('width' => 0.25), 'B' => array('width' => 0.50)));
            $this->pdf->Cell(57.8, 20, "", array('LR' => array('width' => 0.25), 'B' => array('width' => 0.50)));
            $this->pdf->Cell(57.8, 20, "", array('LR' => array('width' => 0.25), 'B' => array('width' => 0.50)));
            $this->pdf->Cell(57.8, 20, "", array('R' => array('width' => 0.25), 'RB' => array('width' => 0.50)));

            $old = umask();
            umask(0);
            if (!is_dir($this->path))
                mkdir($this->path, 0777);
            if (!is_dir($this->path . $po->vendor_code))
                mkdir($this->path . $po->vendor_code . DS, 0777);
            umask($old);

            $name = 'PO-' . $po->id . '.pdf';

            $this->filenames[$po->vendor_code . DS . $name] = $this->path . $po->vendor_code . DS . 'PO-' . $po->id . '.pdf';

            $this->filename = 'PO-' . $po->id . '.pdf';
            $this->pdf->Output($this->path . $po->vendor_code . DS . $this->filename, 'F');
            $this->pdf->Close();

            if ($po->count_base > 0) {
                //** order specification
                $order_specification = new model_proformainvoice_os_pdf();
                $order_specification->set_path($this->path . $po->vendor_code . DS);
                $order_specification->initialize();

                $products = $this->model_purchaseorder->product_select_by_po_id_and_component_type($po->id, 1);
                $proformainvoice = $this->model_proformainvoice->select_by_id($po->pi_id);

                $order_specification->create_header($proformainvoice);
                $order_specification->generate_content($proformainvoice, $products);
                $name = $order_specification->get_name();
                $this->filenames[$po->vendor_code . DS . $name] = $order_specification->get_filename();

                //** checksheet
                $checksheet = new model_checksheet_pdf();
                $checksheet->set_path($this->path . $po->vendor_code . DS);
                $checksheet->initialize();
                $checksheet->create_header($po);
                $checksheet->generate_content($po, $products);
                $name = $checksheet->get_name();
                $this->filenames[$po->vendor_code . DS . $name] = $checksheet->get_filename();

                //** labels
                $label = new model_label_pdf();
                $label->set_path($this->path . $po->vendor_code . DS);
                $label->generate_label($products);
                $names = $label->get_names();
                foreach ($label->get_filenames() as $i => $f) {
                    $this->filenames[$po->vendor_code . DS . 'labels' . DS . $names[$i]] = $f;
                }
            }
        }
    }

    public function get_filenames() {
        return $this->filenames;
    }

    public function get_names() {
        return $this->names;
    }

}
