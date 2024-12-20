<?php

class model_drop_test_list_excel extends CI_Model {

    private $drop_test_list = null;
    private $drop_test_list_detail = null;
    private $phpexcel;
    private $page;
    private $sheet;
    private $default_margin;
    private $border = array();
    private $margins;

    public function __construct() {
        parent::__construct();

        // Load PHPExcel dari third_party directory
        $this->load->library('PHPExcel');
        $this->load->model('model_drop_test_list');

        $this->phpexcel = new PHPExcel(); // Inisialisasi PHPExcel object
        // Border styles untuk outline
        $this->border['outline'] = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        // Border styles untuk allborders
        $this->border['allBorders'] = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000')
                )
            )
        );
    }

    public function initialize($drop_test_list, $drop_test_list_detail) {
        // Simpan data drop_test_list yang diterima
        $this->drop_test_list = $drop_test_list;
        $this->drop_test_list_detail = $drop_test_list_detail;

        // Inisialisasi margin default
        $this->default_margin = 0.5 / 2.54;

        // Setup properti lembar Excel
        $this->phpexcel->getProperties()
                ->setCreator("Quality Assurance Team")
                ->setTitle("Test Report")
                ->setSubject("Hardness Test Report");

        // Page setup
        $this->page = new PHPExcel_Worksheet_PageSetup();
        $this->page->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $this->page->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->phpexcel->getActiveSheet()->setPageSetup($this->page);

        // Setup margins
        $this->sheet = $this->phpexcel->getActiveSheet();
        $this->margins = $this->sheet->getPageMargins();
        $this->margins->setTop($this->default_margin);
        $this->margins->setBottom($this->default_margin);
        $this->margins->setLeft($this->default_margin);
        $this->margins->setRight($this->default_margin);

        // Mengatur lebar kolom
        $this->sheet->getColumnDimension('B')->setWidth(30);
        $this->sheet->getColumnDimension('C')->setWidth(45);
        $this->sheet->getColumnDimension('F')->setWidth(30);
        $this->sheet->getColumnDimension('E')->setWidth(30);

        // Set default font ke Times New Roman, ukuran 14
        $this->sheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(14);

        // Use FCPATH or BASEPATH to get the absolute path
        $imagePath = FCPATH . 'files/logo.png'; // Asumsi folder 'files' ada di direktori root project Anda
        if (file_exists($imagePath)) {
            $logo = new PHPExcel_Worksheet_Drawing();
            $logo->setPath($imagePath);
            $this->sheet->mergeCells('B2:B5');
            $logo->setCoordinates('B2'); // Tempatkan gambar mulai dari sel B2
            // Menyesuaikan ukuran gambar
            $logo->setHeight(80); // Atur tinggi gambar (sesuaikan jika diperlukan)
            // Menggeser gambar lebih jauh ke kanan dengan meningkatkan nilai offset X
            $logo->setOffsetX(80); // Meningkatkan nilai offset horizontal dari 40 ke 60
            $logo->setOffsetY(10); // Offset vertikal tetap sama
            // Menambahkan gambar ke worksheet
            $logo->setWorksheet($this->sheet);
        }



        // Header Content (Title and Department)
        $this->sheet->setCellValue('C2', "TEST REPORT")
                ->mergeCells('C2:E5'); // Merge cells untuk judul
        $this->sheet->getStyle('C2')->getFont()->setSize(14)->setBold(true);
        // Mengatur agar teks di tengah secara horizontal dan vertikal
        $this->sheet->getStyle('C2')->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // Vertikal Tengah

        $this->sheet->setCellValue('F2', "Quality Assurance Department")
                ->mergeCells('F2:F5'); // Merge cells untuk departemen
        $this->sheet->getStyle('F2')->getFont()->setBold(true);
        // Mengatur agar teks di tengah secara horizontal dan vertikal
        $this->sheet->getStyle('F2')->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // Vertikal Tengah
        // Apply border untuk seluruh header
        $this->sheet->getStyle('B2:F5')->applyFromArray($this->border['outline']);

        // Report Information Section (Report Number, Testing Date, etc.)
        $this->sheet->setCellValue('B7', "Report Number")->setCellValue('C7', $this->drop_test_list->report_no);
        $this->sheet->setCellValue('B8', "Testing Date")->setCellValue('C8', $this->drop_test_list->test_date);
        $this->sheet->setCellValue('B9', "Report Date")->setCellValue('C9', $this->drop_test_list->report_date);
        $this->sheet->setCellValue('B10', "Type of Report")->setCellValue('C10', $this->drop_test_list->protocol_name);

        // Apply borders to all cells in report information section (B7:C10)
        $this->sheet->getStyle('B7:C10')->applyFromArray($this->border['allBorders']);

        // Mengatur teks agar rata kiri dan vertikal tengah
        $this->sheet->getStyle('B7:C10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('B7:C10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Untuk RESULT
        $this->sheet->setCellValue('E7', 'RESULT')->mergeCells('E7:F7');
        $this->sheet->getStyle('E7:F7')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);

        // Warna latar hijau untuk bagian RESULT
        $this->sheet->getStyle('E7:F7')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'CCFFCC'), // Warna hijau muda
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                )
        );

        // Untuk teks "PASS", "FAIL", dan "CAR" dalam kotak RESULT
        if ($this->drop_test_list->rating == 'Passed') {
            $this->sheet->setCellValue('E8', "PASS")->setCellValue('F8', "X");
        } else {
            $this->sheet->setCellValue('E8', "PASS")->setCellValue('F8', "");
        }

        if ($this->drop_test_list->rating == 'Failed') {
            $this->sheet->setCellValue('E9', "FAIL")->setCellValue('F9', "X");
        } else {
            $this->sheet->setCellValue('E9', "FAIL")->setCellValue('F9', "");
        }

        if ($this->drop_test_list->rating == 'Car') {
            $this->sheet->setCellValue('E10', "CAR")->setCellValue('F10', "X");
        } else {
            $this->sheet->setCellValue('E10', "CAR")->setCellValue('F10', "");
        }

        // Menerapkan font Times New Roman ukuran 14 pada bagian RESULT
        $this->sheet->getStyle('E8:F10')->getFont()->setName('Times New Roman')->setSize(14);
        $this->sheet->getStyle('E8:F10')->applyFromArray($this->border['allBorders']);

        // Mengatur teks agar rata tengah
        $this->sheet->getStyle('E8:F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('E8:F10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //product
        $this->sheet->setCellValue('B12', 'Product')->mergeCells('B12:C12');
        $this->sheet->getStyle('B12:C12')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('B12:C12')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'CCFFCC'), // Warna hijau muda
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                )
        );

        $this->sheet->setCellValue('B13', "Customer")->setCellValue('C13', $this->drop_test_list->client_name);
        $this->sheet->setCellValue('B14', "Ebako Code")->setCellValue('C14', $this->drop_test_list->ebako_code);
        $this->sheet->setCellValue('B15', "Customer Code")->setCellValue('C15', $this->drop_test_list->customer_code);
        $this->sheet->setCellValue('B16', "Item Description")->setCellValue('C16', $this->drop_test_list->item_description);
        $this->sheet->getStyle('B13:C16')->applyFromArray($this->border['allBorders']);

        //PRODUCT SPECIFICATION
        $this->sheet->setCellValue('E12', 'PRODUCT SPECIFICATION')->mergeCells('E12:F12');
        $this->sheet->getStyle('E12:F12')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('E12:F12')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'CCFFCC'), // Warna hijau muda
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                )
        );

        $this->sheet->setCellValue('E13', "Product Dimension (Inches)")->setCellValue('F13', $this->drop_test_list->product_dimension);
        $this->sheet->setCellValue('E14', "Carton Dimension (Inches)")->setCellValue('F14', $this->drop_test_list->carton_dimension);
        $this->sheet->setCellValue('E15', "Gross Weight (Lbs)")->setCellValue('F15', $this->drop_test_list->gross_weight);
        $this->sheet->setCellValue('E16', "Nett Weight (Lbs)")->setCellValue('F16', $this->drop_test_list->nett_weight);
        $this->sheet->getStyle('E13:F16')->applyFromArray($this->border['allBorders']);
        $this->sheet->getStyle('E13:F16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // Bagian untuk Sample Test Picture
        $this->sheet->setCellValue('B18', 'Sample Test Picture')->mergeCells('B18:C18');
        $this->sheet->getStyle('B18:C18')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('B18:C18')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'CCFFCC'),
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                )
        );

      
        $imagePath = FCPATH . 'files/droptest/' . $this->drop_test_list->id . '/' . $this->drop_test_list->product_image;
        if (file_exists($imagePath) && !empty($this->drop_test_list->product_image)) {
            $sampleImage = new PHPExcel_Worksheet_Drawing();
            $sampleImage->setPath($imagePath);
            $sampleImage->setHeight(150); // Sesuaikan tinggi gambar sesuai keinginan
            $sampleImage->setCoordinates('B19'); // Lokasi sel gambar
            
            // Mengatur posisi gambar di tengah sel
            $sampleImage->setOffsetX(200); // Geser X untuk menempatkan di tengah
            $sampleImage->setOffsetY(10); // Geser Y untuk menempatkan di tengah

            $sampleImage->setWorksheet($this->sheet);
        }
         else {
            // Jika gambar tidak ada, tampilkan teks "No Image"
            $this->sheet->setCellValue('B19', 'No Image');
            $this->sheet->getStyle('B19')->getFont()->setItalic(true);
        }
            $this->sheet->mergeCells('B19:C25');
        $this->sheet->getStyle('B19:C25')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('B19:C25')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->sheet->getStyle('B19:C25')->applyFromArray($this->border['allBorders']);

        // Bagian untuk Corrective Action Item
        $this->sheet->setCellValue('E18', 'Corrective Action Item')->mergeCells('E18:F18');
        $this->sheet->getStyle('E18:F18')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('E18:F18')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'CCFFCC'),
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                        ),
                    ),
                )
        );

        $this->sheet->mergeCells('E19:F25');
        $this->sheet->getStyle('E19:F25')->getFont()->setItalic(true);
        $this->sheet->getStyle('E19:F25')->applyFromArray($this->border['allBorders']);
        $this->sheet->setCellValue('E19' . $row, $this->drop_test_list->corrective_action_plan_image);
        $this->sheet->getStyle('E19' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('E19' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //summary
        $this->sheet->setCellValue('B27', 'Summary')->mergeCells('B27:F27');
        $this->sheet->getStyle('B27:F27')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('B27:F27')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('B27:F27')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'CCFFCC'), // Warna hijau muda
                    )
                )
        );

        $row = 28;
        $this->sheet->setCellValue('B' . $row, 'Method')->mergeCells('B' . $row . ':C' . $row);
        $this->sheet->setCellValue('D' . $row, 'Result');
        $this->sheet->setCellValue('E' . $row, 'Image')->mergeCells('E' . $row . ':F' . $row);
        $this->sheet->getStyle('B' . $row . ':F' . $row)->getFont()->setBold(true);
        $this->sheet->getStyle('B' . $row . ':F' . $row)->applyFromArray($this->border['allBorders']);

        // Loop through the $drop_test_list_detail and insert the data into the table
        // Loop through the $drop_test_list_detail and insert the data into the table
        $row++;
        foreach ($this->drop_test_list_detail as $detail) {
            if ($detail->var_type == 'Description') {
                // Jika var_type adalah 'Description', cetak teks tanpa gambar
                $this->sheet->setCellValue('B' . $row, $detail->method)->mergeCells('B' . $row . ':C' . $row);
                $this->sheet->setCellValue('D' . $row, $detail->result_test_var);
                $this->sheet->setCellValue('E' . $row, $detail->notes)->mergeCells('E' . $row . ':F' . $row);
                $this->sheet->getStyle('E' . $row)->getFont()->setItalic(true); // Font miring untuk note
                // Tambahkan border ke setiap cell
                $this->sheet->getStyle('B' . $row . ':F' . $row)->applyFromArray($this->border['allBorders']);

                // Pindah ke baris berikutnya
                $row++;
            } else {
                // Jika var_type adalah 'Photo', tambahkan gambar atau teks "No Image"
                $this->sheet->setCellValue('B' . $row, $detail->method)->mergeCells('B' . $row . ':C' . $row);
                $this->sheet->setCellValue('D' . $row, $detail->result_test_var);

                // Inisialisasi tinggi default gambar
                $imageHeight = 150;
                $totalHeight = $imageHeight; // Asumsi default bahwa ada gambar
                // Offset Y untuk gambar kedua agar tersusun ke bawah
                $offsetY = 20;

                // Menambahkan gambar pertama (atau No Image)
                if (trim($detail->image_file) != "") {
                    $imagePath = FCPATH . 'files/droptest/' . $detail->drop_test_list_id . '/' . $detail->image_file;
                    if (file_exists($imagePath)) {
                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        $objDrawing->setPath($imagePath);
                        $this->sheet->mergeCells('E' . $row . ':F' . $row);
                        $objDrawing->setCoordinates('E' . $row);
                        $objDrawing->setHeight($imageHeight); // Tinggi gambar
                        $objDrawing->setOffsetY($offsetY); // Mulai dari atas
                        $objDrawing->setOffsetX(200); // Mulai dari atas
                        $objDrawing->setWorksheet($this->sheet);
                        $offsetY += $imageHeight + 10; // Tambahkan jarak antar gambar
                    } else {
                        // Jika gambar tidak ada, cetak teks "No Image"
                        $this->sheet->setCellValue('E' . $row, 'No Image')->mergeCells('E' . $row . ':F' . $row);
                        $this->sheet->getStyle('E' . $row)->getFont()->setItalic(true); // Font miring untuk "No Image"
                        $totalHeight = -1; // Tidak ada gambar, jadi tinggi default teks
                    }
                } else {
                    // Jika tidak ada gambar pertama, tambahkan teks "No Image"
                    $this->sheet->setCellValue('E' . $row, 'No Image')->mergeCells('E' . $row . ':F' . $row);
                    $this->sheet->getStyle('E' . $row)->getFont()->setItalic(true);
                    $totalHeight = -1; // Tidak ada gambar, jadi tinggi default teks
                }

                // Menambahkan gambar kedua (atau No Image)
                if (trim($detail->image2_file) != "") {
                    $image2Path = FCPATH . 'files/droptest/' . $detail->drop_test_list_id . '/' . $detail->image2_file;
                    if (file_exists($image2Path)) {
                        $objDrawing2 = new PHPExcel_Worksheet_Drawing();
                        $objDrawing2->setPath($image2Path);
                        $this->sheet->mergeCells('E' . $row . ':F' . $row);
                        $objDrawing2->setCoordinates('E' . $row);
                        $objDrawing2->setHeight($imageHeight); // Tinggi gambar kedua
                        $objDrawing2->setOffsetY($offsetY); // Geser ke bawah
                        $objDrawing2->setWorksheet($this->sheet);
                        $offsetY += $imageHeight + 10; // Tambahkan jarak
                        $totalHeight = $offsetY; // Update tinggi total dengan gambar kedua
                    } else {
                        // Jika gambar kedua tidak ada, cetak teks "No Image"
                        $this->sheet->setCellValue('E' . $row, 'No Image')->mergeCells('E' . $row . ':F' . $row);
                        $this->sheet->getStyle('E' . $row)->getFont()->setItalic(true);
                    }
                }

                // Menambahkan border ke setiap cell
                $this->sheet->getStyle('B' . $row . ':F' . $row)->applyFromArray($this->border['allBorders']);

                // Atur tinggi baris sesuai dengan total tinggi gambar atau default tinggi
                $this->sheet->getRowDimension($row)->setRowHeight($totalHeight > 0 ? $totalHeight : -1);

                // Pindah ke baris berikutnya
                $row++;
            }
        }
    }

    public function download($filename = 'Drop_Test_List.xlsx') {
        // Clean the output buffer before generating the file
        ob_clean();

        // Set headers for Excel file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        // Output the Excel file
        $writer = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
        $writer->save('php://output');
    }
}
