<?php
//echo phpinfo();
//exit();
$my_pdf = new Pdf();
$my_pdf->setPageOrientation('P', true, 2);
$my_pdf->SetCompression(true);
$my_pdf->setPrintHeader(true);
$my_pdf->setPrintFooter(false);
$my_pdf->SetMargins(2, 2, 2);
$my_pdf->SetFont('', '', 7);
$my_pdf->AddPage();
?>
<head>
    <style>
        table {
            page-break-inside: auto;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        thead {
            display: table-header-group;
        }
        tfoot {
            display: table-footer-group;
        }
    </style>
</head>
<table border="1" cellpadding="0" cellspacing="0" > REPORT ONLINE  (EIRO)</h2></th>
</tr>
<tr>
<thead>
<th bgcolor='#ffffcc' colspan="6"><h2>EBAKO INSPECTION
        <tr>
            <th bgcolor='#ffff99' colspan="6">END FINAL AREA</th>
        </tr>
        <tr>
            <td colspan="3"><font face='courier' size='2'>
                PT EBAKO NUSANTARA <br>
                Jl. Terboyo Industri Barat Dalam II Blok N/3C<br>
                Kawasan Industri Terboyo Park - Semarang <br>
                Jawa Tengah - Indonesia</font>
            </td>
            <td colspan="3" align='center' width='50%'>
                <?php
                $image = $_SERVER["HTTP_REFERER"] . 'files/logo.png';
                echo "<img src='" . $image . "' width='100'>";
                ?>
            </td>
        </tr>
        </thead>

        <tbody>
            <tr>
                <td width='20%'>Customer</td>
                <td width='2%' align='center'>:</td>
                <td width='30%'><?php echo $inspection->client_name; ?></td>
                <td width='20%'>Po Client No</td>
                <td width='2%' align='center'>:</td>
                <td width='30%'><?php echo $inspection->po_client_no; ?></td>
            </tr>
            <tr>
                <td width='20%'>Cust. Code</td>
                <td width='2%' align='center'>:</td>
                <td width='20%'><?php echo $inspection->customer_code; ?></td>
                <td width='20%'>Inspection Date</td>
                <td width='2%' align='center'>:</td>
                <td width='20%'><?php echo date('d F Y', strtotime($inspection->inspection_date)); ?></td>
            </tr>
            <tr>
                <td width='20%'>Ebako Code</td>
                <td width='2%' align='center'>:</td>
                <td width='20%'><?php echo $inspection->ebako_code; ?></td>
                <td width='20%'>Inspector</td>
                <td width='2%' align='center'>:</td>
                <td width='20%'><?php echo $inspection->user_added; ?></td>
            </tr>
            <tr>
                <th bgcolor='#ffff99' colspan="6">INSPECTION DOCUMENTATION</th>
            </tr>
            <?php
            $x = 0;
            foreach ($inspection_detail as $result) {
                if($result->filename==null)
                    continue;

                $x++;
                //echo $result->view_position . "<br>";
                //echo 'x='.$x.' dan '.$x.'%2='.($x%2)."<br>";
                if (($x % 2) == 1) {
                    echo "<tr align=center>";
                }
                ?>
            <td colspan="3" valign="top">
                <?php echo $result->view_position; ?><br>
                <?php
                $image = $_SERVER["HTTP_REFERER"] . 'files/inspection/' . $result->isnpection_id . "/" . $result->filename;
                echo "<img src='" . $image . "' width='175'>";
                ?>
            </td>
            <?php
            if ($x % 2 == 0) {
                echo "</tr>";
            }
        }
        ?>
        </tbody>
</table>
<?php
//$my_pdf->writeHTML($tbl, true, false, true, false, '');
//$file_name = $shipment->shipment_no . '.pdf';
//$my_pdf->Output($file_name, 'D');
?>

