<?php

$my_pdf = new Pdf();
$my_pdf->setPageOrientation('P', true, 2);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(true);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(2, 2, 2);
$my_pdf->SetFont('', '', 7);
$my_pdf->AddPage();

$tbl = '    <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="80%" style="border-bottom-width: 2px;border-bottom-color:black;border-bottom-style:double;">
                <div style="font-size:24px;"><b>' . $shipment->client_company . '</b></div>
                <span>' . nl2br($shipment->address) . ', Telp: ' . $shipment->phone . ', Fax: ' . $shipment->fax . '</span>    
                </td>
                <td width="20%" style="border-bottom-width: 2px;border-bottom-color:black;border-bottom-style:solid;">
                <div style="font-size:64px;">S.L</div>
                <span style="font-size:24px;">Shipment List</span>
                </td>
            </tr>
    </table>';

$my_pdf->writeHTML($tbl, true, false, true, false, '');

$tbl = ' <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="50%" style="border: .1px solid black;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="100%" height="50%">
                            <div><b>Consignee: </b></div>
                            ' . $shipment->client_company . '<br/>' . nl2br($shipment->ship_address) . '
                            </td>
                        </tr>
                        <tr>
                            <td width="100%" height="50%">
                            <div><b>Buyer</b></div>
                            ' . $shipment->client_company . '<br/>' . nl2br($shipment->address) .  '
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" style="border: .1px solid black;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="40%" style="border-bottom-width: .1px;border-bottom-color:black;border-bottom-style:solid;line-height:5px;">PL Number :</td>
                            <td width="60%" align="right" style="border-bottom-width: .1px;border-bottom-color:black;border-bottom-style:solid;line-height:5px;">' . $shipment->shipment_no . '&nbsp;&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
    </table>';

$my_pdf->writeHTML($tbl, true, false, true, false, '');

$tbl = '    <table width="100%" border="1" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="2%" align="center"  style="border: .1px solid black;line-height:7px;"><b>No</b></td>
                <td width="10%" align="center" style="border: .1px solid black;line-height:7px;"><b>Client PO No</b></td>
                <td width="10%" align="center" style="border: .1px solid black;line-height:7px;"><b>Ebako Code</b></td>
                <td width="10%" align="center" style="border: .1px solid black;line-height:7px;"><b>Customer Code</b></td>
                <td width="18%" align="center" style="border: .1px solid black;line-height:7px;"><b>Serial Number</b></td>
                <td width="10%" align="center" style="border: .1px solid black;line-height:7px;"><b>Finishing</b></td>
                <td width="10%" align="center" style="border: .1px solid black;line-height:7px;"><b>Material</b></td>
                <td width="10%" align="center" style="border: .1px solid black;line-height:7px;"><b>Remark</b></td>
                <td width="10%" align="center" style="border: .1px solid black;line-height:7px;"><b>Tagfor</b></td>
                <td width="10%" align="center" style="border: .1px solid black;line-height:7px;"><b>Description</b></td>
            </tr>
        </thead>';
$counter = 10;
$no = 1;
$total_qty = 0;
$total_box = 0;
$total_volume = 0;
$total_net_weight = 0;
$total_gross_weight = 0;
foreach ($shipment_item as $result) {
    $tbl .= '<tr>
        <td width="2%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;line-height:5px;">' . $no++ . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->po_client_no . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->ebako_code . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->customer_code . '</td>
        <td width="18%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->serial_number . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->finishing . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->material . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->remarks . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->tagfor . '</td>
        <td width="10%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->description . '</td>
    </tr>';
$counter--;
}


for ($i = 0; $i < $counter; $i++) {
    $tbl .= '<tr>
        <td width="2%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td width="30%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">&nbsp;</td>
        <td width="17%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">&nbsp;</td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">&nbsp;</td>
        <td width="5%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;"><b>&nbsp;</b></td>
    </tr>';
}
$my_pdf->writeHTML($tbl, true, false, true, false, '');
$tbl = '<table width="100%">
            <tr>
                <td width="40%" style="border-width: 0.1px 0.1px 0.1px 0.1px;border-color:#000000;border-style:solid;padding:10px">
                    <br/><br/>
                    <table width="100%">
                        <tr>
                            <td width="1%" height="10">&nbsp;</td>
                            <td width="30%" height="10">Country of Origin</td>
                            <td width="1%" height="10">:</td>
                            <td width="68%" height="10" align="right">Indonesia&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="1%" height="10">&nbsp;</td>
                            <td width="30%" height="10">Container No.</td>
                            <td width="1%" height="10">:</td>
                            <td width="68%" height="10" align="right">' . $shipment->container_no . '&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="1%" height="10">&nbsp;</td>
                            <td width="30%" height="10">Seal No.</td>
                            <td width="1%" height="10">:</td>
                            <td width="68%" height="10" align="right">' . $shipment->seal_no . '&nbsp;&nbsp;</td>
                        </tr>
                    </table>
                    <br/>
                </td>
                <td width="20%" align="center" style="border-width: 0.1px 0.1px 0.1px 0.1px;border-color:#000000;border-style:solid;">
                    <br/><br/><br/><br/><br/><br/>
                    Company Stamp
                </td>
                <td width="40%" align="center" style="border-width: 0.1px 0.1px 0.1px 0.1px;border-color:#000000;border-style:solid;">
                    Jakarta, ' . date('d F Y', strtotime($shipment->date)) . '
                    <br/><br/><br/><br/><br/><br/>
                    PIC
                </td>
            </tr>
         </table>
';
$my_pdf->writeHTML($tbl, true, false, true, false, '');
$file_name = $shipment->shipment_no . '.pdf';
$my_pdf->Output($file_name, 'D');


