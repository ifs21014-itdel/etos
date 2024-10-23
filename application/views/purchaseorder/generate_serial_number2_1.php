<!--<html>
    <head>
        <style>
            table.wrapper-whitespace, div.wrapper-whitespace-with-inline {
                white-space: nowrap;
            }

            table.wrapper-whitespace-with-inline > div.item {
                display: inline;
            }
            table.wrapper-flex {
                display: flex;
                flex-wrap: nowrap; /* this is default */
            }
            td.item {
                display: flex;
                height: 143.62px;
                width: 253.22px;
            }
            td.space{
                width:3.78px;
            }
            tr.space2{
                height:11.33x;
                background-color: blue;
            }
        </style>
    </head>
</html>-->
<?php
$my_pdf = new Pdf($orientation = 'P', $unit = 'cm', array(21, 30));
//$my_pdf->setPageOrientation('P', true, 1);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(false);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(3, 5, 1);
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
    'align' => 'C',
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
$x = 1;
$tbl2 = '<table class="wrapper-flex" border=0>';
$tbl = "";
//print_r($serial_number);
foreach ($serial_number as $result) {
    $params = $my_pdf->serializeTCPDFtagParameters(array($result->serial_number, 'QRCODE,C', '', '', '18', '18', $style, 'C', 'FALSE'));
    if (($x % 3) == 1) {
        $tbl2 .= '<tr>';
    }
    $tbl2 .= '<td  class="item"> '
            . '<table border=0><tr><td width=40%><tcpdf method="write2DBarcode" params="' . $params . '"/></td>'
            . '<td width=60% style="font-size:7pt;">'
            . '<b>' . $result->serial_number . '</b><br/>'
            . 'C &nbsp; &nbsp;&nbsp;:&nbsp;' . $result->client_name . '<br />'
            . 'PO &nbsp;&nbsp;:&nbsp;' . $result->po_client_no . '<br />'
            . 'EC &nbsp;&nbsp;:&nbsp;' . $result->ebako_code . '<br />'
            . 'CC &nbsp;&nbsp;:&nbsp;' . $result->customer_code . '<br />'
            . 'F &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;' . $result->finishing . '<br />'
            . 'OQ &nbsp;&nbsp;:&nbsp;' . $result->item_order_seq_no . " of " . $result->qty . '<br />'
            . 'BQ &nbsp;&nbsp;:&nbsp;' . $result->item_order_seq_no . "" . $result->packing_code . " of " . $result->qty . "" . $result->packing_code . '<br />'
            . '</td></tr></table>';
    $tbl2 .= '</td>';

//    $tbl2 .= '<td  class="item" style="font-size:5pt;"> '
//            . '<tcpdf method="write2DBarcode" params="' . $params . '"/><br>'
//            . '<b>' . $result->serial_number . '</b><br/>'
//            . 'C &nbsp; &nbsp;&nbsp;:&nbsp;' . $result->client_name . '<br />'
//            . 'PO &nbsp;&nbsp;:&nbsp;' . $result->po_client_no . '<br />'
//            . 'EC &nbsp;&nbsp;:&nbsp;' . $result->ebako_code . '<br />'
//            . 'CC &nbsp;&nbsp;:&nbsp;' . $result->customer_code . '<br />'
//            . 'F &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;' . $result->finishing . '<br />'
//            . 'OQ &nbsp;&nbsp;:&nbsp;' . $result->item_order_seq_no . " of " . $result->qty . '<br />'
//            . 'BQ &nbsp;&nbsp;:&nbsp;' . $result->item_order_seq_no . "" . $result->packing_code . " of " . $result->qty . "" . $result->packing_code . '<br />';
//    $tbl2 .= '</td>';
    $tbl2 .= '<td class=space></td>';
    // echo $x.'='.count($serial_number).' dan x % 3='.($x % 3).'<br>';
    if ($x == count($serial_number)) {
        if ($x % 3 == 1) {
            $tbl2 .= "<td>empty</td>";
            $tbl2 .= '<td></td>';
            $tbl2 .= "<td>empty</td><td class=space></td></tr>";
        } elseif ($x % 3 == 2) {
//            $tbl2 .= '<td class=space></td>';
            $tbl2 .= "<td></td><td class=space></td></tr>";
        }
    }
    $x++;
    if (($x % 3) == 1) {
        $tbl2 .= '</tr><tr><td colspan=6 class=space2></td></tr>';
    }
}
$tbl .= '</table>';
$my_pdf->writeHTML($tbl2, true, false, true, false, 'center');
$file_name = $po->po_no . "_label.pdf";
//echo $tbl2;
$my_pdf->Output($file_name, 'D');
?>