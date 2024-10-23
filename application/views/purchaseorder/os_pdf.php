<?php

$my_pdf = new pdf();

$my_pdf->setPageOrientation('P', true, 2);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(false);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(2, 2, 2);
$my_pdf->SetFont('', '', 6);
$my_pdf->AddPage();

//print_r($po);

$tbl = '
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>     
        <td width="100%" style="border: 0.1px solid black;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="font-size:12.5pt;">
                        <b>' . $company->name . '</b>
                    </td> 
                    <td align="right" style="line-height:10px;padding:10px;">
                        ' . $company->address . '
                  </td>
                </tr>
            </table>        
        </td>
    </tr>
    <tr>
        <td style="border: 0.1px solid black;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr valign="top">
                    <td width="70%" height="40"><br/><br/>
                        <table width="100%">
                            <tr>
                                <td width="20%"><b>ORDER ID</b></td>
                                <td width="2%">:</td>                                            
                                <td width="78%">' . $pi->order_id . '</td>
                            </tr>
                            <tr>
                                <td><b>COMPANY NAME</b></td>
                                <td>:</td>
                                <td>' . $pi->client_company_name . '</td>
                            </tr>
                            <tr>
                                <td><b>ADDRESS</b></td>
                                <td>:</td>
                                <td>' . $pi->client_address . '</td>
                            </tr>
                            <tr>
                                <td><b>COUNTRY</b></td>
                                <td>:</td>
                                <td>' . $pi->client_country . '</td>
                            </tr>
                            <tr>
                                <td><b>PHONE/FAX</b></td>
                                <td>:</td>
                                <td>' . $pi->client_country . '</td>
                            </tr>
                            <tr>
                                <td><b>EMAIL</b></td>
                                <td>:</td>
                                <td>' . $pi->client_email . '</td>
                            </tr>
                            <tr>
                                <td><b>CONTACT NAME</b></td>
                                <td>:</td>
                                <td>' . $pi->client_name . '</td>
                            </tr>
                        </table>
                        <br/>
                    </td>
                    <td width="30%" style="border-left:0.1px solid #000000;padding-bottom:20px">
                        <span style="font-size:20pt"><b>O.S</b></span><br/>
                        <span style="font-size:10pt;">&nbsp;&nbsp;<b>ORDER SPECIFICATION</b></span>
                    </td>
                </tr>
            </table>
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
            <td width="14%" valign="middle" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>&nbsp;PRODUCT ID</b></td>
            <td width="18%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>PRODUCT NAME</b></td>
            <td width="12%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>IMAGE</b></td>
            <td width="5%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>QTY</b></td>
            <td width="15%" align="center" colspan="3" style="border: 0.1px solid black;line-height:5px;"><b>DIMENSION</b></td>
            <td width="8%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>MATERIAL</b></td>
            <td width="8%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>COLOR</b></td>
            <td width="8%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>FABRIC</b></td>
            <td width="12%" align="center" rowspan="2" style="border: 0.1px solid black;line-height:10px;"><b>NOTES</b></td>
        </tr>
        <tr valign="center">
            <td width="5%" align="center" style="border: 0.1px solid black;line-height:7px;"><b>WIDTH</b></td>
            <td width="5%" align="center" style="border: 0.1px solid black;line-height:7px;"><b>DEPTH</b></td>
            <td width="5%" align="center" style="border: 0.1px solid black;line-height:7px;"><b>HEIGHT</b></td>
        </tr>
    </thead>';
$counter = 10;
$total_qty = 0;
$total_volume = 0;
foreach ($po_item as $result) {
    $tbl .= '<tr>
        <td width="14%" style="border-right-color:#000000;border-right-width:0.1px;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;line-height:5px;">' . $result->item_code . '</td>        
        <td width="18%" align="left" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->item_description . '</td>
        <td width="12%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><img src="files/products_image/' . $result->image . '" width="40" height="40" style="margin-top:5px;line-height:5px;"></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->qty . '</td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->width . '</td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->depth . '</td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->height . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->material . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->color . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->fabric . '</td>
        <td width="12%" align="right" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b></b></td>
    </tr>';
    $total_qty += $result->qty;
    $volume = ($result->width * $result->height * $result->depth) / 1000000000;
    $total_volume += $volume;
    $counter--;
}

for ($i = 0; $i < $counter; $i++) {
    $tbl .= '<tr>
        <td width="14%" align="center" style="border-left-color:#000000;border-left-width:0.1px;left-bottom-style:solid;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="18%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="12%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
        <td width="12%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;"><b>&nbsp;</b></td>
    </tr>';
}

$tbl .= '<tr>
        <td width="14%" align="center" style="border-left-color:#000000;border-left-width:0.1px;border-left-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="18%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="12%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
        <td width="12%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>&nbsp;</b></td>
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
        <td width="80%" rowspan="2" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-left-color:#000000;border-left-width:0.1px;border-left-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;"><b>REMARK : ' . $po->remark . '</b></td>        
        <td width="20%" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:10px;"><b>TOTAL QUANTITY :  ' . $total_qty . ' Items</b></td>
    </tr>
    <tr>
        <td width="20%" style="border-top-color:#000000;border-top-width:0.1px;border-top-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-bottom-width:0.1px;border-bottom-style:solid;line-height:10px;"><b>TOTAL VOLUME : ' . round($total_volume, 2) . ' m3</b></td>
    </tr>
</table>';

$my_pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = '
<table cellpadding="0" width="100%" cellspacing="0" nobr="true">
 <tr>
  <td width="100%" style="border:0.1px solid #000000;line-height:10px">&nbsp;Product image are for reference only, it is not the illustrations of your final order.</td>
 </tr>
 
</table>
';
$my_pdf->writeHTML($tbl, true, false, false, false, '');
$my_pdf->lastPage();
$file_name = 'OS-' . $po->po_no . '.pdf';
$my_pdf->Output($path . DS . $file_name, 'F');

//============================================================+
// END OF FILE
//============================================================+
