<?php

class Pdf
{

    function pdf_create($html, $filename, $stream = TRUE)
    {
        require_once("dompdf/dompdf_config.inc.php");
        spl_autoload_register("DOMPDF_autoload");
        set_time_limit(300);
        $dompdf = new DOMPDF();
        ini_set("memory_limit", "256M");
        $dompdf->load_html($html);
        $dompdf->set_paper("letter", "potrait", "kwitansi", "A4");
        $dompdf->set_paper("kwitansi");
        $dompdf->render();
        $dompdf->stream($filename . '.pdf', array('Attachment' => 0));
        //        if ($stream) {
        //            $dompdf->stream($filename . ".pdf");
        //        } else {
        //            $CI = & get_instance();
        //            $CI->load->helper("file");
        //            write_file($filename, $dompdf->output());
        //        }
    }
    function pdf_generate_detail_anggota($text, $stream = TRUE)
    {
        require_once("vendor/dompdf/dompdf_config.inc.php");
        spl_autoload_register("DOMPDF_autoload");

        $options['paper_orientation'] = "portrait";
        $options['paper_size'] = "a4";

        $paper_size = $options['paper_size'];
        $paper_orientation = $options['paper_orientation'];

        $dompdf = new DOMPDF();
        $dompdf->set_paper($paper_size, $paper_orientation);
        $dompdf->load_html($text);
        //$dompdf->load_html_file($text);
        $dompdf->render();
        $dompdf->stream("Detail_Anggota.pdf", array('Attachment' => 0));
    }
}
