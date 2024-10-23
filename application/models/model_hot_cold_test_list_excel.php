<?php

class model_hot_cold_test_list_excel extends CI_Model {
    private $hot_cold_test_list = null;
    private $hot_cold_test_list_detail = null;
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
        $this->load->model('model_hot_cold_test_list');

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

    public function initialize($hot_cold_test_list,$hot_cold_test_list_detail) {
        // Simpan data hot_cold_test_list yang diterima
        $this->hot_cold_test_list = $hot_cold_test_list;
        $this->hot_cold_test_list_detail = $hot_cold_test_list_detail;
    
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
    
        // Mengatur lebar kolom sesuai kebutuhan
        $this->sheet->getColumnDimension('B')->setWidth(20);
        $this->sheet->getColumnDimension('C')->setWidth(10);
        $this->sheet->getColumnDimension('D')->setWidth(10);
        $this->sheet->getColumnDimension('E')->setWidth(10);
        $this->sheet->getColumnDimension('F')->setWidth(10);
        $this->sheet->getColumnDimension('G')->setWidth(10);
        $this->sheet->getColumnDimension('H')->setWidth(10);
        $this->sheet->getColumnDimension('I')->setWidth(10);
        $this->sheet->getColumnDimension('J')->setWidth(10);
        $this->sheet->getColumnDimension('K')->setWidth(10);
        $this->sheet->getColumnDimension('L')->setWidth(10);
    
        // Set default font ke Times New Roman, ukuran 14
        $this->sheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(14);
    
        // Add Logo in B
        $imagePath = FCPATH . 'files/logo.png'; // Assuming 'files' folder is in the root directory of your project
        if (file_exists($imagePath)) {
            $logo = new PHPExcel_Worksheet_Drawing();
            $logo->setPath($imagePath); 
            $this->sheet->mergeCells('B2:B5'); // Adjusted merge range for the logo
            $logo->setCoordinates('B2'); // Place the image starting at cell B2
            
            // Adjust the image size and offsets
            $logo->setHeight(80); // Set the image height
            $logo->setOffsetX(10); // Adjust horizontal offset
            $logo->setOffsetY(10); // Adjust vertical offset
            
            // Add the logo to the worksheet
            $logo->setWorksheet($this->sheet);
        }
    
        // Title "TEST REPORT" in C to I
        $this->sheet->setCellValue('C2', "TEST REPORT")
            ->mergeCells('C2:I5'); // Merge cells for the title
        $this->sheet->getStyle('C2')->getFont()->setSize(14)->setBold(true);
        $this->sheet->getStyle('C2')->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
        // Department text in J to L
        $this->sheet->setCellValue('J2', "Quality Assurance Department")
            ->mergeCells('J2:L5'); // Merge cells for the department
        $this->sheet->getStyle('J2')->getFont()->setBold(true);
        $this->sheet->getStyle('J2')->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
        // Apply border untuk seluruh header
        $this->sheet->getStyle('B2:L5')->applyFromArray($this->border['outline']);

        // Report Information Section (Report Number, Testing Date, etc.)
        $this->sheet->setCellValue('B7', "Report Number")->setCellValue('C7', $this->hot_cold_test_list->report_no)->mergeCells('C7:H7');
        $this->sheet->setCellValue('B8', "Testing Date")->setCellValue('C8', $this->hot_cold_test_list->test_date)->mergeCells('C8:H8');
        $this->sheet->setCellValue('B9', "Report Date")->setCellValue('C9', $this->hot_cold_test_list->report_date)->mergeCells('C9:H9');
        $this->sheet->setCellValue('B10', "Type of Report")->setCellValue('C10', $this->hot_cold_test_list->protocol_name)->mergeCells('C10:H10');

        // Apply borders to the whole section (B7:H10)
        $this->sheet->getStyle('B7:H10')->applyFromArray($this->border['allBorders']);

        // Align text within the cells
        $this->sheet->getStyle('B7:H10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 

        // Untuk bagian "RESULT" pada kolom J hingga K
        $this->sheet->setCellValue('J7','RESULT')->mergeCells('J7:L7');
        $this->sheet->getStyle('J7:L7')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);

        // Warna latar hijau untuk bagian "RESULT"
        $this->sheet->getStyle('J7:L7')->applyFromArray(
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

        // Untuk teks "PASS", "FAIL", dan "CAR" dalam kotak RESULT pada kolom J dan K
        $this->sheet->setCellValue('J8', "PASS")->setCellValue('K8', ($this->hot_cold_test_list->rating == 'Passed') ? "X" : "")->mergeCells('K8:L8');
        $this->sheet->setCellValue('J9', "FAIL")->setCellValue('K9', ($this->hot_cold_test_list->rating == 'Failed') ? "X" : "")->mergeCells('K9:L9');
        $this->sheet->setCellValue('J10', "CAR")->setCellValue('K10', ($this->hot_cold_test_list->rating == 'Car') ? "X" : "")->mergeCells('K10:L10');;

        // Menerapkan font Times New Roman ukuran 14 pada bagian "RESULT"
        $this->sheet->getStyle('J8:L10')->getFont()->setName('Times New Roman')->setSize(14);
        $this->sheet->getStyle('J8:L10')->applyFromArray($this->border['allBorders']);

        // Mengatur teks agar rata tengah
        $this->sheet->getStyle('J8:L10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('J8:L10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Bagian untuk Sample Test Picture
        $this->sheet->setCellValue('B12', 'Sample Test Picture')->mergeCells('B12:H12');
        $this->sheet->getStyle('B12:H12')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('B12:H12')->applyFromArray(
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
        $imagePath = FCPATH . 'files/hotcoldtest/' . $this->hot_cold_test_list->id . '/' . $this->hot_cold_test_list->product_image;
        if (file_exists($imagePath) && !empty($this->hot_cold_test_list->product_image)) {
            $sampleImage = new PHPExcel_Worksheet_Drawing();
            $sampleImage->setPath($imagePath);
            $sampleImage->setCoordinates('B13');
            $sampleImage->setHeight(150); 
            $sampleImage->setOffsetX(20); // Offset X untuk menyesuaikan posisi gambar secara horizontal
            $sampleImage->setOffsetY(20); // Offset Y untuk menyesuaikan posisi gambar secara vertikal
            $sampleImage->setWorksheet($this->sheet); // Tambahkan gambar ke worksheet
        } else {
            // Jika gambar tidak ada, tampilkan teks "No Image"
            $this->sheet->setCellValue('B13', 'No Image');
            $this->sheet->getStyle('B13')->getFont()->setItalic(true);
        }
        $this->sheet->mergeCells('B13:H22');
        $this->sheet->getStyle('B13:H22')->applyFromArray($this->border['allBorders']);

        // Bagian untuk Corrective Action Plan
        $this->sheet->setCellValue('J12', 'Corrective Action Plan')->mergeCells('J12:L12');
        $this->sheet->getStyle('J12:L12')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('J12:L12')->applyFromArray(
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
        $correctiveImagePath = FCPATH . 'files/hotcoldtest/' . $this->hot_cold_test_list->id . '/' . $this->hot_cold_test_list->corrective_action_plan_image;
        if (file_exists($correctiveImagePath) && !empty($this->hot_cold_test_list->corrective_action_plan_image)) {
            $correctiveImage = new PHPExcel_Worksheet_Drawing();
            $correctiveImage->setPath($correctiveImagePath);
            $correctiveImage->setCoordinates('J13');
            $correctiveImage->setHeight(150); // Ukuran gambar yang lebih besar
            $correctiveImage->setOffsetX(20); // Offset X untuk menyesuaikan posisi gambar secara horizontal
            $correctiveImage->setOffsetY(20); // Offset Y untuk menyesuaikan posisi gambar secara vertikal
            $correctiveImage->setWorksheet($this->sheet); // Tambahkan gambar ke worksheet
        } else {
            // Jika gambar tidak ada, tampilkan teks "No Image"
            $this->sheet->setCellValue('H13', 'No Image');
            $this->sheet->getStyle('H13')->getFont()->setItalic(true);
        }
        $this->sheet->mergeCells('J13:L22');
        $this->sheet->getStyle('J13:L22')->applyFromArray($this->border['allBorders']);


        // Bagian Header "PRODUCT"
        $this->sheet->setCellValue('B24', 'PRODUCT')->mergeCells('B24:L24');
        $this->sheet->getStyle('B24:L24')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('B24:L24')->applyFromArray(
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

        // Mengatur data untuk "Customer", "Sample Code", dan "Vendor"
        $this->sheet->setCellValue('B25', "Customer")->setCellValue('C25', $this->hot_cold_test_list->client_name)->mergeCells('C25:L25');
        $this->sheet->setCellValue('B26', "Sample Code")->setCellValue('C26', $this->hot_cold_test_list->ebako_code)->mergeCells('C26:L26');;
        $this->sheet->setCellValue('B27', "Vendor")->setCellValue('C27', $this->hot_cold_test_list->vendor_name)->mergeCells('C27:L27');;

        // Menerapkan border ke seluruh tabel dari B20:C22
        $this->sheet->getStyle('B25:L27')->applyFromArray($this->border['allBorders']);

        // Menambah garis untuk teks dalam tabel dan mengatur agar rata tengah secara vertikal
        $this->sheet->getStyle('B25:L27')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('B25:L27')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Bagian Header "Testing Conditions" dimulai dari baris 29
        $this->sheet->setCellValue('B29', 'Testing Conditions (1 Cycle) = Total 10 Cycles')->mergeCells('B29:L29');
        $this->sheet->getStyle('B29:L29')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
        $this->sheet->getStyle('B29:L29')->applyFromArray(
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

        // Bagian Condition A
        $this->sheet->setCellValue('B30', "Condition A")->mergeCells('B30:C31');
        $this->sheet->setCellValue('D30', $this->hot_cold_test_list->condition_a_temp."°C (oven)")->mergeCells('D30:H31');
        $this->sheet->setCellValue('I30', $this->hot_cold_test_list->condition_a_duration." Hour")->mergeCells('I30:L31');

        // Bagian Rest Temperature setelah Condition A
        $this->sheet->setCellValue('B32', "Room Temperature Rest")->mergeCells('B32:C32');
        $this->sheet->setCellValue('D32', $this->hot_cold_test_list->room_temp_rest_a_duration." Minutes")->mergeCells('D32:L32');

        // Bagian Condition B
        $this->sheet->setCellValue('B33', "Condition B")->mergeCells('B33:C34');
        $this->sheet->setCellValue('D33', "Temperature ".$hot_cold_test_list->condition_b_temp."°C (freezer)")->mergeCells('D33:H34');
        $this->sheet->setCellValue('I33', "Duration".$this->hot_cold_test_list->condition_b_duration." hour")->mergeCells('I33:L34');

        // Bagian Rest Temperature setelah Condition B
        $this->sheet->setCellValue('B35', "Room Temperature Rest")->mergeCells('B35:C35');
        $this->sheet->setCellValue('D35', $this->hot_cold_test_list->room_temp_rest_b_duration." minutes")->mergeCells('D35:L35');

        // Menerapkan border ke seluruh bagian Testing Conditions
        $this->sheet->getStyle('B30:L35')->applyFromArray($this->border['allBorders']);

        // Mengatur teks agar rata tengah secara horizontal dan vertikal
        $this->sheet->getStyle('B30:L35')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->sheet->getStyle('B30:L35')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Bagian Header "Testing Progress" dimulai dari baris 37
$this->sheet->setCellValue('B37', 'Testing Progress')->mergeCells('B37:L37');
$this->sheet->getStyle('B37:L37')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
$this->sheet->getStyle('B37:L37')->applyFromArray(
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

// Bagian Cycle (1 sampai 10) dimulai dari kolom B
$this->sheet->setCellValue('B38', 'Cycle');
for ($i = 1; $i <= 10; $i++) {
    $this->sheet->setCellValueByColumnAndRow($i + 1, 38, $i); // Set angka 1-10 di kolom C ke L
}

// Bagian Status dengan tanda ceklis (√) dan strip (-)
$this->sheet->setCellValue('B39', 'Status');
for ($i = 1; $i <= $hot_cold_test_list->cycles; $i++) {
    $this->sheet->setCellValueByColumnAndRow($i + 1, 39, '√'); // Centang (√) untuk cycle yang sudah selesai
}
for ($i = $hot_cold_test_list->cycles + 1; $i <= 10; $i++) {
    $this->sheet->setCellValueByColumnAndRow($i + 1, 39, '-'); // Strip (-) untuk cycle yang belum selesai
}

// Menerapkan border ke seluruh bagian Testing Progress
$this->sheet->getStyle('B38:L39')->applyFromArray($this->border['allBorders']);

// Mengatur teks agar rata tengah secara horizontal dan vertikal
$this->sheet->getStyle('B38:L39')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->sheet->getStyle('B38:L39')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// Bagian Header "Test Result Summary" dimulai dari baris 41
$this->sheet->setCellValue('B41', 'TEST RESULT SUMMARY')->mergeCells('B41:L41');
$this->sheet->getStyle('B41:L41')->getFont()->setName('Times New Roman')->setSize(14)->setBold(true);
$this->sheet->getStyle('B41:L41')->applyFromArray(
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

// Baris awal untuk gambar
$row = 42;

foreach ($hot_cold_test_list_detail as $result) {
    // Merge cells untuk gambar pertama dari B sampai F
    $this->sheet->mergeCells('B' . $row . ':F' . ($row + 10));
    // Merge cells untuk gambar kedua dari G sampai L
    $this->sheet->mergeCells('G' . $row . ':L' . ($row + 10));
    
    // Tampilkan gambar pertama
    if (trim($result->image_file) != "") {
        $imagePath1 = FCPATH . 'files/hotcoldtest/' . $result->hot_cold_test_list_id . '/' . $result->image_file;
        if (file_exists($imagePath1)) {
            $image1 = new PHPExcel_Worksheet_Drawing();
            $image1->setPath($imagePath1);
            $image1->setCoordinates('B' . $row);
            $image1->setHeight(200); // Set the height of the image (lebih besar)
            $image1->setOffsetX(10); // Adjust offset if necessary
            $image1->setOffsetY(10); 
            $image1->setWorksheet($this->sheet);
        }
    }

    // Tampilkan gambar kedua
    if (trim($result->image2_file) != "") {
        $imagePath2 = FCPATH . 'files/hotcoldtest/' . $result->hot_cold_test_list_id . '/' . $result->image2_file;
        if (file_exists($imagePath2)) {
            $image2 = new PHPExcel_Worksheet_Drawing();
            $image2->setPath($imagePath2);
            $image2->setCoordinates('G' . $row);
            $image2->setHeight(200); // Set the height of the image (lebih besar)
            $image2->setOffsetX(10); // Adjust offset if necessary
            $image2->setOffsetY(10); 
            $image2->setWorksheet($this->sheet);
        }
    }

    // Apply border di sel gambar pertama dan kedua
    $this->sheet->getStyle('B' . $row . ':F' . ($row + 10))->applyFromArray($this->border['allBorders']);
    $this->sheet->getStyle('G' . $row . ':L' . ($row + 10))->applyFromArray($this->border['allBorders']);

    // Tampilkan evaluation dan result_test_var di baris selanjutnya
    $this->sheet->setCellValue('B' . ($row + 11), $result->evaluation)->mergeCells('B' . ($row + 11) . ':F' . ($row + 11));
    $this->sheet->setCellValue('G' . ($row + 11), $result->result_test_var)->mergeCells('G' . ($row + 11) . ':L' . ($row + 11));

    // Menerapkan border di bagian evaluation dan result_test_var
    $this->sheet->getStyle('B' . ($row + 11) . ':L' . ($row + 11))->applyFromArray($this->border['allBorders']);

    // Pindahkan row untuk iterasi berikutnya
    $row += 12;
}

// Mengatur alignment agar teks berada di tengah dan vertikal
$this->sheet->getStyle('B41:L' . ($row - 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->sheet->getStyle('B41:L' . ($row - 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    }
    



    public function download($filename = 'hot_cold_test_list.xlsx') {
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
