<?php

$my_pdf = new Pdf();
$my_pdf->setPageOrientation('L', true, 2);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(false);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(2, 2, 2);
$my_pdf->SetFont('', '', 7);
$my_pdf->AddPage();

//print_r($po);

$tbl = '
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="padding:10px 4px 10px 4px">
    <tr>     
        <td width="50%" style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;">
            <table>
                <tr>
                    <td><span style="font-size:12.5pt;"><b>' . $company->name . '</b></span></td>
                </tr>
                <tr>
                    <td><span>' . nl2br($company->address) . '</span></td>
                </tr>
            </table>
        </td>
        <td width="50%" style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;" align="right">
            <span style="font-size:20pt"><b>P.O</b>&nbsp;</span><br/>
            <span style="font-size:10pt;"><b>PURCHASE ORDER</b>&nbsp;&nbsp;</span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="border: 1px solid black;" colspan=2>
            <br/><br/>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr valign="top">
                    <td width="40%">
                        <table width="100%">
                            <tr>
                                <td width="50%"><b>P.O. NUMBER</b></td>
                                <td width="2%">:</td>                                            
                                <td width="48%">' . $po->po_no . '</td>
                            </tr>
                            <tr>
                                <td><b>ORDER DATE</b></td>
                                <td>:</td>
                                <td>' . date("d-m-Y", strtotime($po->date)) . '</td>
                            </tr>
                            <tr>
                                <td><b>ORDER DATE REVISION</b></td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>TARGET SHIPDATE</b></td>
                                <td>:</td>
                                <td>' . (($po->target_ship_date != "") ? date("d-m-Y", strtotime($po->target_ship_date)) : "") . '</td>
                            </tr>
                        </table>
                    </td>
                    <td width="60%">
                        <table width="100%">
                            <tr>
                                <td width="28%"><b>VENDOR</b></td>
                                <td width="2%">:</td>                                            
                                <td width="70%">' . nl2br($po->vendor_name) . '</td>
                            </tr>
                            <tr>
                                <td><b>ADDRESS</b></td>
                                <td>:</td>
                                <td>' . $po->vendor_address . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br/>
        </td> 
    </tr>
</table>';

//EOD;
//
$my_pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------
// Table with rowspans and THEAD
$tbl = '
<table border="0" cellspacing="0" cellspacing="0" width="100%" style="border-collapse:collapse">
    <thead>
        <tr>
            <td width="2%"  align="center" rowspan="2" style="border: 1px solid black;"><b>NO</b></td>
            <td width="9%" valign="middle" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>PRODUCT ID</b></td>
            <td width="8%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>VENDOR CODE</b></td>
            <td width="7%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>TYPE</b></td>
            <td width="13%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>PRODUCT NAME</b></td>
            <td width="9%" align="center" colspan="3" style="border: 1px solid black;line-height:5px;"><b>DIMENSION</b></td>
            <td width="3%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>QTY</b></td>
            <td width="3%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>UoM</b></td>
            <td width="13%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>MATERIAL</b></td>
            <td width="7%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>COLOR</b></td>
            <td width="7%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>FABRIC</b></td>
            <td width="7%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>UNIT PRICE</b></td>
            <td width="5%" align="center" rowspan="2" style="border: 1px solid black;line-height:5px;"><b>DISC<BR>(%)</b></td>
            <td width="10%" align="center" rowspan="2" style="border: 1px solid black;line-height:10px;"><b>LINE TOTAL</b></td>
        </tr>
        <tr valign="center">
            <td width="3%" align="center" style="border: 1px solid black;line-height:5px;"><b>W</b></td>
            <td width="3%" align="center" style="border: 1px solid black;line-height:5px;"><b>D</b></td>
            <td width="3%" align="center" style="border: 1px solid black;line-height:5px;"><b>H</b></td>
        </tr>
    </thead>';
$counter = 10;
$no = 1;

$border = 0.1;
foreach ($po_item as $result) {
    if ($result->special_instruction != '') {
        $border = 1;
    }
    $tbl .= '<tr>
        <td width="2%" align="right" style="border-right-color:#000000;border-right-width:'.$border.'px;border-left-color:#000000;border-left-width:'.$border.'px;border-left-style:solid;line-height:5px;">' . $no++ . '</td>
        <td width="9%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->item_code . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->vendor_item_code . '</td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->component_type . '</td>
        <td width="13%" align="left" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->item_description . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->width . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->depth . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->height . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->qty . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->uom . '</td>
        <td width="13%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->material . '</td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->color . '</td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->fabric . '</td>
        <td width="7%" align="right" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . number_format($result->price, 2) . '</td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . $result->discount . '</td>
        <td width="10%" align="right" style="border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;border-right-color:#000000;border-right-width:'.$border.'px;border-right-style:solid;line-height:5px;">' . number_format($result->total, 2) . '</td>
    </tr>';
    if ($result->special_instruction != '') {
        $tbl .= '<tr>
        <td width="19%" colspan=3 align="right"  style="border:'.$border.'px solid #000000;line-height:5px"><b>Special Instruction</b></td>        
        <td width="81%" colspan=13  style="border:'.$border.'px solid #000000;line-height:5px"><i>' . $result->special_instruction . '</i></td>
    </tr>';
    }
    $counter--;
}

for ($i = 0; $i < $counter; $i++) {
    $tbl .= '<tr>
        <td width="2%" align="center" style="border-left-color:#000000;border-left-width:0.1px;left-bottom-style:solid;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="9%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="13%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="13%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
    </tr>';
}

$tbl .= '<tr>
        <td width="2%" align="center" style="border-left-color:#000000;border-left-width:0.1px;border-left-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="9%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="13%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="13%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="7%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
    </tr>';

$tbl .= '</table>';

$my_pdf->writeHTML($tbl, true, false, false, false, '');
//
//// -----------------------------------------------------------------------------
//// NON-BREAKING TABLE (nobr="true")
//

$tbl = '
<table border="0" cellspacing="0" cellspacing="0" width="100%" style="border-collapse:collapse" nobr="true">
    <tr>
        <td width="15%" colspan="3" rowspan="4" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-left-color:#000000;border-left-width:0.1px;border-left-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>PPIC</b></td>        
        <td width="50%" colspan="7" rowspan="4" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>REMARK : ' . $po->remark . '</b></td>        
        <td width="20%" colspan="3" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>&nbsp;&nbsp;TOTAL</b></td>        
        <td width="15%" colspan="2" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . number_format($po->total, 2) . '</b></td>
    </tr>
    <tr>
        <td width="10%" colspan="2" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>&nbsp;&nbsp;VAT.</b></td>
        <td width="10%" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b> ( ' . $po->vat . ' % )</b></td>
        <td width="15%" colspan="2" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . number_format($po->vat_nominal, 2) . '</b></td>
    </tr>
    <tr>
        <td width="10%" colspan=2 style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>&nbsp;&nbsp;DOWN PAYMENT</b></td>        
        <td width="10%" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . (($po->down_payment_date != "") ? date("d-m-Y", strtotime($po->down_payment_date)) : "") . '&nbsp;&nbsp;&nbsp;( ' . $po->down_payment . ' % )</b></td>
        <td width="15%"colspan="2" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . number_format($po->down_payment_nominal, 2) . '</b></td>
    </tr>
    <tr>
        <td width="20%" colspan=3 style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>&nbsp;&nbsp;BALANCE DUE</b></td>
        <td width="15%" colspan="2" align="right" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:5px;"><b>' . number_format($po->balance_due, 2) . '</b></td>
    </tr>
</table>';

$my_pdf->writeHTML($tbl, true, false, false, false, '');

//$tbl = '
//<table cellpadding="0" width="100%" cellspacing="0" nobr="true">
// <tr>
//  <td width="25%" style="border:0.1px solid #000000;line-height:5px" align="center">PPIC</td>
//  <td width="25%" style="border:0.1px solid #000000;line-height:5px" align="center">GENERAL MANAGER</td>
//  <td width="25%" style="border:0.1px solid #000000;line-height:5px" align="center">FINANCE</td>
//  <td width="25%" style="border:0.1px solid #000000;line-height:5px" align="center">DIRECTOR</td>
// </tr>
// <tr>
//  <td width="25%" style="border:0.1px solid #000000;line-height:25px">&nbsp;</td>
//  <td width="25%" style="border:0.1px solid #000000;line-height:25px">&nbsp;</td>
//  <td width="25%" style="border:0.1px solid #000000;line-height:25px">&nbsp;</td>
//  <td width="25%" style="border:0.1px solid #000000;line-height:25px">&nbsp;</td>
// </tr>
//</table>
//';
//// -----------------------------------------------------------------------------
////Close and output PDF document
//$my_pdf->writeHTML($tbl, true, false, true, false, '');
$file_name = 'PO-' . $po->po_no . '.pdf';
if ($path == '#') {
    $my_pdf->Output($file_name, 'D');
} else {
    $my_pdf->Output($path . DS . $file_name, 'F');
}

//============================================================+
// END OF FILE
//============================================================+
