<?php
$my_pdf = new Pdf($orientation = 'P', $unit = 'cm', array(16, 21.3));
//$my_pdf->setPageOrientation('P', true, 1);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(false);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(15, 5, 5);
$my_pdf->SetFont('', 'R', 5);
$my_pdf->AddPage();

$style = array(
    'border' => true,
    'vpadding' => '1',
    'hpadding' => '1',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

$style2 = array(
    'position' => '',
    'align' => 'L',
    'stretch' => false,
    'fitwidth' => false,
    'cellfitalign' => '',
    'border' => FALSE,
    'hpadding' => '2',
    'vpadding' => '2',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 6,
    'stretchtext' => 4
);

$tbl = '<br/><br/><table cellpadding="0" cellspacing="0" border=1>';
$x = 1;
//print_r($serial_number);
foreach ($serial_number as $result) {
    $params = $my_pdf->serializeTCPDFtagParameters(array($result->serial_number, 'QRCODE,H', '', '', 15, 15, $style, 'N'));
    //  $params2 = $my_pdf->serializeTCPDFtagParameters(array($result->serial_number, 'C128', '', '', 0, 10, 0.4, $style2, 'N'));
    // $barcodeobj = new TCPDFBarcode('123456', 'C128');

  //  $image = "no-image.jpg";
//    if (file_exists("files/products_image/" . $result->product_image)) {
//        $image = $result->product_image;
//    }
    //echo ($x%2);
    if (($x % 2) == 1) {
        $tbl .= '<tr>';
    }
    $tbl .= ' 
                <td align=right width=5%>
                    <tcpdf method="write2DBarcode" params="' . $params . '" /></td>' 
            . '<td width=25%><table style="font-size:11px;">'
            . '<tr width=25%><td>Serial Number</td><td width=3%>:</td><td>'. $result->serial_number . '</td></tr>'
            . '<tr><td>Customer</td><td>:</td><td>'. $result->client_name . '</td></tr>'
            . '<tr> <td>No Po</td><td>:</td><td>' . $result->po_no . '</td></tr>'
            . '<tr> <td>Ebk Code</td><td>:</td><td>' . $result->ebako_code . '</td></tr>'
            . '<tr> <td>Cust Code</td><td>:</td><td>' . $result->customer_code . '</td></tr>'
            . '<tr> <td>Finishing</td><td>:</td><td>' . $result->finishing . '</td></tr>'
            . '<tr> <td>Order Qty</td><td>:</td><td>' . $result->item_order_seq_no." of ".$result->qty . '</td></tr>'
            . '<tr> <td>Box Qty</td><td>:</td><td>' . $result->item_order_seq_no."".$result->packing_code." of ".$result->qty ."".$result->packing_code. '</td></tr>'
            .'</table></td>
            ';
    if($x==count($serial_number) && (($x%2)==1))
    {
        $tbl.="<td colspan=2></td></tr>";
    }
    $x++;
    if (($x % 2) == 1) {
        $tbl.= '</tr>';
    }
}
$tbl.= '</table>';
$my_pdf->writeHTML($tbl, true, false, true, false, '');
$file_name = $po->po_no . "_label.pdf";
$my_pdf->Output($file_name, 'D');