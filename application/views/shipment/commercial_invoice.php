<?php

$my_pdf = new Pdf();
$my_pdf->setPageOrientation('P', true, 2);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(false);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(2, 2, 2);
$my_pdf->SetFont('', '', 7);
$my_pdf->AddPage();

$tbl = '    <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="80%" style="border-bottom-width: 2px;border-bottom-color:black;border-bottom-style:double;">
                <div style="font-size:28px;"><b>' . $shipment->company_name . '</b></div>
                <span>' . nl2br($shipment->company_address) . ', Telp: ' . $shipment->company_telp . ', Fax: ' . $shipment->company_fax . '</span>    
                </td>
                <td width="20%" style="border-bottom-width: 2px;border-bottom-color:black;border-bottom-style:solid;">
                &nbsp;
                </td>
            </tr>
    </table>';

$my_pdf->writeHTML($tbl, true, false, true, false, '');

$tbl = ' <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="80%" style="border: .1px solid black;"><br/><br/>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="1%" style="line-height:4px;">&nbsp;</td>
                            <td width="18%" style="line-height:4px;"><b>ID</b></td>
                            <td width="1%" style="line-height:4px;"><b>:</b></td>
                            <td width="80%" style="line-height:4px;">' . $shipment->order_id . '</td>
                        </tr>
                        <tr>
                            <td style="line-height:4px;">&nbsp;</td>
                            <td style="line-height:4px;"><b>COMPANY NAME</b></td>
                            <td style="line-height:4px;"><b>:</b></td>
                            <td style="line-height:4px;">' . $shipment->client_company_name . '</td>
                        </tr>
                        <tr>
                            <td style="line-height:4px;">&nbsp;</td>
                            <td style="line-height:4px;"><b>ADDRESS</b></td>
                            <td style="line-height:4px;"><b>:</b></td>
                            <td style="line-height:4px;">' . nl2br($shipment->client_address) . '</td>
                        </tr>
                        <tr>
                            <td style="line-height:4px;">&nbsp;</td>
                            <td style="line-height:4px;"><b>COUNTRY</b></td>
                            <td style="line-height:4px;"><b>:</b></td>
                            <td style="line-height:4px;">' . $shipment->client_country . '</td>
                        </tr>
                        <tr>
                            <td style="line-height:4px;">&nbsp;</td>
                            <td style="line-height:4px;"><b>PHONE / FAX</b></td>
                            <td style="line-height:4px;"><b>:</b></td>
                            <td style="line-height:4px;">' . $shipment->client_phone_fax . '</td>
                        </tr>
                        <tr>
                            <td style="line-height:4px;">&nbsp;</td>
                            <td style="line-height:4px;"><b>EMAIL</b></td>
                            <td style="line-height:4px;"><b>:</b></td>
                            <td style="line-height:4px;">' . $shipment->client_email . '</td>
                        </tr>
                    </table>
                    <br/>
                </td>
                <td width="20%" style="border: .1px solid black;" align="center"><br/><br/>
                    <span style="font-size:84px;"><b>C.I.</b></span><br/>
                    <span style="font-size:30px;"><b>Commercial Invoice</b></span>
                </td>
            </tr>
    </table>';

$my_pdf->writeHTML($tbl, true, false, true, false, '');

$tbl = '    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="2%" rowspan="2" align="center" valign="middle" style="border: .1px solid black;line-height:7px;"><b>No</b></td>
                <td width="23%" rowspan="2" align="center" style="border: .1px solid black;line-height:7px;"><b>PRODUCT ID</b></td>
                <td width="27%" rowspan="2" align="center" style="border: .1px solid black;line-height:7px;"><b>PRODUCT NAME</b></td>
                <td width="12%" colspan="3" align="center" align="center" style="border: .1px solid black;"><b>DIMENSION (mm)</b></td>
                <td width="3%" rowspan="2" align="center" style="border: .1px solid black;line-height:7px;"><b>QTY</b></td>
                <td width="10%" rowspan="2" align="center" style="border: .1px solid black;"><b>Vol<br>(m3)</b></td>
                <td width="11%" rowspan="2" align="center" style="border: .1px solid black;"><b>PRICE<br/>(' . $shipment->currency_code . ')</b></td>
                <td width="12%" rowspan="2" align="center" style="border: .1px solid black;"><b>LINE TOTAL<br/>(' . $shipment->currency_code . ')</b></td>
            </tr>
            <tr>
                <td width="4%" align="center" style="border: .1px solid black;"><b>W</b></td>
                <td width="4%" align="center" style="border: .1px solid black;"><b>D</b></td>
                <td width="4%" align="center" style="border: .1px solid black;"><b>H</b></td>
            </tr>
        </thead>';
$counter = 10;
$no = 1;
$total_qty = 0;
$total_box = 0;
$total_volume = 0;
$total_net_weight = 0;
$total_gross_weight = 0;
$line_total = 0;
foreach ($shipment_item as $result) {
    $tbl .= '<tr>
        <td width="2%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;line-height:5px;">' . $no++ . '</td>
        <td width="23%" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">&nbsp;' . $result->product_code . '</td>
        <td width="27%" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">&nbsp;' . $result->product_name . '</td>
        <td width="4%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->width . '</td>
        <td width="4%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->depth . '</td>
        <td width="4%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->height . '</td>
        <td width="3%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->qty . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . number_format($result->volume * $result->qty, 2) . '</td>
        <td width="11%" align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . number_format($result->price, 2) . '&nbsp;&nbsp;</td>
        <td width="12%" align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . number_format(($result->price * $result->qty), 2) . '&nbsp;&nbsp;</td>
    </tr>';
    $total_qty += $result->qty;
    $total_box += ($result->qty * $result->box);
    $total_volume += ($result->volume * $result->qty);
    $total_net_weight += ($result->weight_net * $result->qty);
    $total_gross_weight += ($result->weight_gross * $result->qty);
    $line_total += ($result->price * $result->qty);
    $counter--;
}


for ($i = 0; $i < $counter; $i++) {
    $tbl .= '<tr>
        <td  align="center" style="border-right-color:#000000;border-right-width:0.1px;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
    </tr>';
}

$tbl .= '<tr>
        <td colspan="6" align="center" style="border-width: 0.1px 0.1px 0.1px 0.1px;border-color:#000000;border-style:solid;line-height:5px;"><b>Total</b></td>
        <td align="center" style="border-width: 0.1px 0.1px 0.1px 0.1px;border-color:#000000;border-style:solid;line-height:5px;"><b>' . $total_qty . '</b></td>
        <td align="center" style="border-width: 0.1px 0.1px 0.1px 0.1px;border-color:#000000;border-style:solid;line-height:5px;"><b>' . number_format($total_volume, 2) . '</b></td>
        <td align="center" style="border-width: 0.1px 0.1px 0.1px 0.1px;border-color:#000000;border-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td align="right" style="border-width: 0.1px 0.1px 0.1px 0.1px;border-color:#000000;border-style:solid;line-height:5px;"><b>' . number_format($line_total, 2) . '&nbsp;&nbsp;</b></td>
    </tr></table>';

$my_pdf->writeHTML($tbl, true, false, true, false, '');



$tbl = '
<table cellpadding="0" width="100%" cellspacing="0" nobr="true">
 <tr>
  <td width="25%" style="border:0.1px solid #000000;line-height:5px" align="center"><b>PPIC</b></td>
  <td width="25%" style="border:0.1px solid #000000;line-height:5px" align="center"><b>GENERAL MANAGER</b></td>
  <td width="25%" style="border:0.1px solid #000000;line-height:5px" align="center"><b>FINANCE</b></td>
  <td width="25%" style="border:0.1px solid #000000;line-height:5px" align="center"><b>DIRECTOR</b></td>
 </tr>
 <tr>
  <td width="25%" style="border:0.1px solid #000000;line-height:25px">&nbsp;</td>
  <td width="25%" style="border:0.1px solid #000000;line-height:25px">&nbsp;</td>
  <td width="25%" style="border:0.1px solid #000000;line-height:25px">&nbsp;</td>
  <td width="25%" style="border:0.1px solid #000000;line-height:25px">&nbsp;</td>
 </tr>
</table>
';

$my_pdf->writeHTML($tbl, true, false, true, false, '');
$file_name = 'CI-'.$shipment->shipment_no . '.pdf';
$my_pdf->Output($file_name, 'D');


