<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$dirname = $this->session->userdata('session_id');
$this->model_purchaseorder_pdf->set_path($dirname . DS);
$this->model_purchaseorder_pdf->generate_content($po);
$filenames = $this->model_purchaseorder_pdf->get_filenames();


$files = array();

foreach ($filenames as $path => $file) {
    $files[$path] = file_get_contents($file);
    $old = umask();
    umask(0);
    unlink($file);
    umask($old);
}

$old = umask();
umask(0);
foreach ($filenames as $path => $file) {
    if (file_exists(dirname($file) . DS . 'labels')) {
        rmdir(dirname($file) . DS . 'labels');
    }
    if (file_exists(dirname($file))) {
        rmdir(dirname($file));
    }
}

if (file_exists(ROOT . 'temp' . DS . $dirname)) {
    rmdir(ROOT . 'temp' . DS . $dirname);
}
umask($old);

$this->zip->add_data($files);
$this->zip->archive(ROOT . 'temp' . DS . $dirname . '-' . $po[0]->order_id . '.zip');
$data = file_get_contents(ROOT . 'temp' . DS . $dirname . '-' . $po[0]->order_id . '.zip');

$old = umask();
umask(0);
unlink(ROOT . 'temp' . DS . $dirname . '-' . $po[0]->order_id . '.zip');
umask($old);

$name = $po[0]->order_id . '.zip';
$this->zip->download($name, $data);
?>
