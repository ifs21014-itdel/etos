<?php

class model_product_test_list_excel extends CI_Model {
    private $product_test_list = null;
    private $product_test_list_detail = null;
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
        $this->load->model('model_product_test_list');

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

    public function initialize($product_test_list,$product_test_list_detail) {
        // Simpan data product_test_list yang diterima
        $this->product_test_list = $product_test_list;
        $this->product_test_list_detail = $product_test_list_detail;
    

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
        $imagePath = FCPATH . 'files/logo.png'; // Assuming 'files' folder is in the root directory of your project
        if (file_exists($imagePath)) {
            $logo = new PHPExcel_Worksheet_Drawing();
            $logo->setPath($imagePath); 
            $this->sheet->mergeCells('B2:B5'); 
            $logo->setCoordinates('B2'); // Place the image starting at cell B2
            
            // Adjust the image size
            $logo->setHeight(80); // Set the image height (you can adjust this as needed)
            
            // Center the image by adjusting the offsets
            $logo->setOffsetX(25); // Adjust the horizontal offset to center the image (try different values if needed)
            $logo->setOffsetY(10); // Adjust the vertical offset to center the image (try different values if needed)
        
            // Add the logo to the worksheet
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
        $this->sheet->setCellValue('B7', "Report Number")->setCellValue('C7', $this->product_test_list->report_no);
        $this->sheet->setCellValue('B8', "Testing Date")->setCellValue('C8', $this->product_test_list->test_date);
        $this->sheet->setCellValue('B9', "Report Date")->setCellValue('C9', $this->product_test_list->report_date);
        $this->sheet->setCellValue('B10', "Type of Report")->setCellValue('C10',$this->product_test_list->protocol_name);

        // Apply borders to all cells in report information section (B7:C10)
        $this->sheet->getStyle('B7:C10')->applyFromArray($this->border['allBorders']);

        // Mengatur teks agar rata kiri dan vertikal tengah
        $this->sheet->getStyle('B7:C10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('B7:C10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Untuk RESULT
        $this->sheet->setCellValue('E7','RESULT')->mergeCells('E7:F7');
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
        if ($this->product_test_list->rating == 'Passed') {
            $this->sheet->setCellValue('E8', "PASS")->setCellValue('F8', "X");
        } else {
            $this->sheet->setCellValue('E8', "PASS")->setCellValue('F8', "");
        }

        if ($this->product_test_list->rating == 'Failed') {
            $this->sheet->setCellValue('E9', "FAIL")->setCellValue('F9', "X");
        } else {
            $this->sheet->setCellValue('E9', "FAIL")->setCellValue('F9', "");
        }

        if ($this->product_test_list->rating == 'Car') {
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
       // Bagian Product
        $this->sheet->setCellValue('B22', 'Product')->mergeCells('B22:C22');
        $this->sheet->getStyle('B22:C22')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('B22:C22')->applyFromArray(
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

        $this->sheet->setCellValue('B23', "Customer")->setCellValue('C23', $this->product_test_list->client_name);
        $this->sheet->setCellValue('B24', "Ebako Code")->setCellValue('C24', $this->product_test_list->ebako_code);
        $this->sheet->setCellValue('B25', "Customer Code")->setCellValue('C25', $this->product_test_list->customer_code);
        $this->sheet->setCellValue('B26', "Item Description")->setCellValue('C26', $this->product_test_list->item_description);
        $this->sheet->getStyle('C26')->getAlignment()->setWrapText(true);
        $this->sheet->getRowDimension(26)->setRowHeight(-1); // -1 memungkinkan tinggi baris otomatis sesuai konten
        $this->sheet->getStyle('B23:C26')->applyFromArray($this->border['allBorders']);

        // Bagian Product Specification
        $this->sheet->setCellValue('E22', 'PRODUCT SPECIFICATION')->mergeCells('E22:F22');
        $this->sheet->getStyle('E22:F22')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('E22:F22')->applyFromArray(
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

        $this->sheet->setCellValue('E23', "Product Dimension (Inches)")->setCellValue('F23', $this->product_test_list->product_dimension);
        $this->sheet->setCellValue('E24', "Carton Dimension (Inches)")->setCellValue('F24', $this->product_test_list->carton_dimension);
        $this->sheet->setCellValue('E25', "Gross Weight (Lbs)")->setCellValue('F25', $this->product_test_list->gross_weight);
        $this->sheet->setCellValue('E26', "Nett Weight (Lbs)")->setCellValue('F26', $this->product_test_list->nett_weight);
        $this->sheet->getStyle('E23:F26')->applyFromArray($this->border['allBorders']);
        $this->sheet->getStyle('E23:F26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                
        // Bagian untuk Sample Test Picture
        $this->sheet->setCellValue('B12', 'Sample Test Picture')->mergeCells('B12:C12');
        $this->sheet->getStyle('B12:C12')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('B12:C12')->applyFromArray(
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

        // Cek apakah gambar tersedia
        $imagePath = FCPATH . 'files/producttest/' . $this->product_test_list->id . '/' . $this->product_test_list->product_image;
        if (file_exists($imagePath) && !empty($this->product_test_list->product_image)) {
            $sampleImage = new PHPExcel_Worksheet_Drawing();
            $sampleImage->setPath($imagePath);
            $sampleImage->setCoordinates('B13');
            $sampleImage->setHeight(150); 
            $sampleImage->setOffsetX(20); // Offset X to center image horizontally
            $sampleImage->setOffsetY(20); // Offset Y to center image vertically
            $sampleImage->setWorksheet($this->sheet); // Add image to worksheet
        } else {
            // Jika gambar tidak ada, tampilkan teks "No Image"
            $this->sheet->setCellValue('B13', 'No Image');
            $this->sheet->getStyle('B13')->getFont()->setItalic(true);
        }
        $this->sheet->mergeCells('B13:C20');
        $this->sheet->getStyle('B13:C20')->applyFromArray($this->border['allBorders']);

        // Bagian untuk Corrective Action Item
        $this->sheet->setCellValue('E12', 'Corrective Action Item')->mergeCells('E12:F12');
        $this->sheet->getStyle('E12:F12')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('E12:F12')->applyFromArray(
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

        // Cek apakah gambar Corrective Action tersedia
        $correctiveImagePath = FCPATH . 'files/producttest/' . $this->product_test_list->id . '/' . $this->product_test_list->corrective_action_plan_image;
        if (file_exists($correctiveImagePath) && !empty($this->product_test_list->corrective_action_plan_image)) {
            $correctiveImage = new PHPExcel_Worksheet_Drawing();
            $correctiveImage->setPath($correctiveImagePath);
            $correctiveImage->setCoordinates('E13');
            $correctiveImage->setHeight(150); // Increase image size
            $correctiveImage->setOffsetX(20); // Offset X to center image horizontally
            $correctiveImage->setOffsetY(20); // Offset Y to center image vertically
            $correctiveImage->setWorksheet($this->sheet); // Add image to worksheet
        } else {
            // Jika gambar tidak ada, tampilkan teks "No Image"
            $this->sheet->setCellValue('E13', 'No Image');
            $this->sheet->getStyle('E13')->getFont()->setItalic(true);
        }
        $this->sheet->mergeCells('E13:F20');
        $this->sheet->getStyle('E13:F20')->applyFromArray($this->border['allBorders']);

        

        //summary
        $this->sheet->setCellValue('B28','Summary')->mergeCells('B28:F28');
        $this->sheet->getStyle('B28:F28')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('B28:F28')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('B28:F28')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCFFCC'), // Warna hijau muda
                )
            )
        );

        $row = 29;
        $this->sheet->setCellValue('B' . $row, 'Evaluation');
        $this->sheet->setCellValue('C' . $row, 'Method/Criteria');
        $this->sheet->setCellValue('D' . $row, 'Result');
        $this->sheet->setCellValue('E' . $row, 'Image')->mergeCells('E'.$row.':F'.$row);
        $this->sheet->getStyle('B' . $row . ':F' . $row)->getFont()->setBold(true);
        $this->sheet->getStyle('B' . $row . ':F' . $row)->applyFromArray($this->border['allBorders']);

        $row++;
foreach ($this->product_test_list_detail as $detail) {
    // Jika var_type adalah 'Description'
    if ($detail->var_type == 'Description') {
        $this->sheet->setCellValue('B' . $row, $detail->evaluation);
        $this->sheet->getStyle('B' . $row)->getAlignment()->setWrapText(true);
        $this->sheet->getRowDimension($row)->setRowHeight(-1);

        // Kolom "Method"
        $this->sheet->setCellValue('C' . $row, $detail->method);
        $this->sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
        $this->sheet->getRowDimension($row)->setRowHeight(-1);

        // Kolom "Result"
        $this->sheet->setCellValue('D' . $row, $detail->result_test_var);

        // Kolom Notes, tulis "No Image"
        $this->sheet->setCellValue('E' . $row, $detail->notes);
        $this->sheet->mergeCells('E' . $row . ':F' . $row);
        $this->sheet->getStyle('E' . $row)->getFont()->setItalic(true);

        // Tambahkan border ke setiap cell
        $this->sheet->getStyle('B' . $row . ':F' . $row)->applyFromArray($this->border['allBorders']);

        // Pindah ke baris berikutnya
        $row++;
    } else {
        // Jika var_type bukan 'Description', tambahkan gambar
        $this->sheet->setCellValue('B' . $row, $detail->evaluation);
        $this->sheet->getStyle('B' . $row)->getAlignment()->setWrapText(true);
        $this->sheet->getRowDimension($row)->setRowHeight(-1);

        $this->sheet->setCellValue('C' . $row, $detail->method);
        $this->sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
        $this->sheet->getRowDimension($row)->setRowHeight(-1);

        $this->sheet->setCellValue('D' . $row, $detail->result_test_var);

        // Inisialisasi variabel untuk offset Y dan total tinggi gambar
        $offsetY = 0;
        $totalHeight = 0;
        $imageHeight = 150; // Tinggi gambar lebih besar
        $imageSpacing = 30; // Jarak antar gambar

        // Flag untuk menandai apakah ada gambar yang berhasil dimasukkan
        $hasImage = false;

        // Menambahkan gambar pertama
        if (trim($detail->image_file) != "") {
            $imagePath = FCPATH . 'files/producttest/' . $detail->product_test_list_id . '/' . $detail->image_file;
            if (file_exists($imagePath)) {
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setPath($imagePath);
                $this->sheet->mergeCells('E' . $row . ':F' . $row);
                $objDrawing->setCoordinates('E' . $row);
                $objDrawing->setHeight($imageHeight);
                $objDrawing->setOffsetY($offsetY);
                $objDrawing->setWorksheet($this->sheet);
                $offsetY += $imageHeight + $imageSpacing;
                $totalHeight += $imageHeight + $imageSpacing;
                $hasImage = true;
            }
        }

        // Menambahkan gambar kedua
        if (trim($detail->image2_file) != "") {
            $image2Path = FCPATH . 'files/producttest/' . $detail->product_test_list_id . '/' . $detail->image2_file;
            if (file_exists($image2Path)) {
                $objDrawing2 = new PHPExcel_Worksheet_Drawing();
                $objDrawing2->setPath($image2Path);
                $this->sheet->mergeCells('E' . $row . ':F' . $row);
                $objDrawing2->setCoordinates('E' . $row);
                $objDrawing2->setHeight($imageHeight);
                $objDrawing2->setOffsetY($offsetY);
                $objDrawing2->setWorksheet($this->sheet);
                $offsetY += $imageHeight + $imageSpacing;
                $totalHeight += $imageHeight + $imageSpacing;
                $hasImage = true;
            }
        }

        // Menambahkan gambar ketiga
        if (trim($detail->image3_file) != "") {
            $image3Path = FCPATH . 'files/producttest/' . $detail->product_test_list_id . '/' . $detail->image3_file;
            if (file_exists($image3Path)) {
                $objDrawing3 = new PHPExcel_Worksheet_Drawing();
                $objDrawing3->setPath($image3Path);
                $this->sheet->mergeCells('E' . $row . ':F' . $row);
                $objDrawing3->setCoordinates('E' . $row);
                $objDrawing3->setHeight($imageHeight);
                $objDrawing3->setOffsetY($offsetY);
                $objDrawing3->setWorksheet($this->sheet);
                $totalHeight += $imageHeight + $imageSpacing;
                $hasImage = true;
            }
        }

        // Jika tidak ada gambar, masukkan teks "No Image"
        if (!$hasImage) {
            $this->sheet->setCellValue('E' . $row, 'No Image');
            $this->sheet->mergeCells('E' . $row . ':F' . $row);
            $this->sheet->getStyle('E' . $row)->getFont()->setItalic(true);
            $totalHeight = -1; // Atur agar tinggi menyesuaikan teks
        }

        // Jika ada teks yang panjang, wrapping teks dan menyesuaikan tinggi
        $this->sheet->getStyle('B' . $row . ':F' . $row)->getAlignment()->setWrapText(true);

        // Jika ada teks panjang, atur tinggi baris otomatis
        $this->sheet->getRowDimension($row)->setRowHeight(-1); 

        // Tambahkan border ke setiap cell
        $this->sheet->getStyle('B' . $row . ':F' . $row)->applyFromArray($this->border['allBorders']);

        // Pindah ke baris berikutnya
        $row++;
    }
}

       


        

    }

    



    public function download($filename = 'Product_Test_List.xlsx') {
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
