<?php
////echo phpinfo();
////exit();
//$my_pdf = new Pdf();
//$my_pdf->setPageOrientation('P', true, 2);
//$my_pdf->SetCompression(true);
//$my_pdf->setPrintHeader(true);
//$my_pdf->setPrintFooter(false);
//$my_pdf->SetMargins(2, 2, 2);
//$my_pdf->SetFont('', '', 7);
//$my_pdf->AddPage();
?>
<?php
//var_dump($hardness_test_list);
?>
<head>
    <style>

        /* Tabel dengan border hanya di luar */
        .table-border-luar {
            border-collapse: collapse;
            /*width: 100%;*/
            border: 1px solid black; /* Border hanya di luar */
        }

        .table-border-luar th, .table-border-luar td {
            padding: 8px;
            /*text-align: left;*/
            border: none; /* Tidak ada border di dalam */
        }

        .table-border-luar-dalam {
            border-collapse: collapse;
            /*width: 100%;*/
            border: 1px solid black; /* Border luar */
        }

        .table-border-luar-dalam th, .table-border-luar-dalam td {
            padding: 8px;
            border: 1px solid black; /* Border dalam */
        }
    </style>
</head>
<!--<table border="1" align="center" class="table-border-luar-dalam" width="1000">-->
<table border="1" align="center" class="table-border-luar" width="1000">
    <thead>
        <tr>
            <td  align='center' width="34%">
                <?php
                $image = $_SERVER["HTTP_REFERER"] . 'files/logo.png';
                echo "<img src='" . $image . "' width='100'>";
                ?>
            </td>
            <td colspan="5" align="center"  width="33%"><h3>TEST REPORT</h3></td>
            <td  align='center' width="34%"><b>Quality Assurance Department</b></td>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td colspan="3" width="48%">
                <table  class="table-border-luar-dalam">
                    <tr>
                        <td width='40%'>Report Number</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo $hardness_test_list->report_no; ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Test date</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo date('d M Y', strtotime($hardness_test_list->test_date)); ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Report Date</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo date('d M Y', strtotime($hardness_test_list->report_date)); ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Type of Report</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo $hardness_test_list->protocol_name; ?></td>
                    </tr>
                </table>
            </td>
            <td width="4%"></td>
            <td colspan="3" width="48%">
                <table  class="table-border-luar-dalam">
                    <tr>
                        <th bgcolor='#ffff99' colspan="3">RESULT</th>
                    </tr>
                    <tr>
                        <td width='50%'>PASS</td>
                        <td width='2%' align='center'>:</td>
                        <td width='480%' align='center'>
                            <?php
                            if ($hardness_test_list->rating == 'Passed')
                                echo '<b>X</b>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='50%'>FAIL</td>
                        <td width='2%' align='center'>:</td>
                        <td width='48%'>
                            <?php
                            if ($hardness_test_list->rating == 'Failed')
                                echo '<b>X</b>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='50%'>CAR</td>
                        <td width='2%' align='center'>:</td>
                        <td width='48%'>
                            <?php
                            if ($hardness_test_list->rating == 'Car')
                                echo '<b>X</b>';
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--==================================================>-->
        <tr>
            <td colspan="3" width="48%">
                <table  class="table-border-luar-dalam"  width='100%'>
                    <tr>
                        <th bgcolor='#ffff99' colspan="3">Sample Test Picture</th>
                    </tr>
                    <tr>
                        <td height="100" width="500" align="center">

                            <?php
                            if (trim($hardness_test_list->product_image) != "") {
                                $image = $_SERVER["HTTP_REFERER"] . 'files/hardnesstest/' . $hardness_test_list->id . "/" . $hardness_test_list->product_image;
                               // echo $image;
                                echo "<img src='" . $image . "' width='105' heigth='100'>";
                            }
                            ?>
                        </td>
                    </tr>

                </table>
            </td>
            <td width="4%"></td>
            <td colspan="3" width="48%">
                <table  class="table-border-luar-dalam" width='100%'>
                    <tr>
                        <th bgcolor='#ffff99' colspan="3">Corrective Action Item</th>
                    </tr>
                    <tr>
                        
                        <td height="100" width="500" align="center">
                            <?php
                            echo $hardness_test_list->corrective_action_plan_image;
                            ?>
                            </td>
                        
                    </tr>

                </table>
            </td>
        </tr>
        <!--==============================================================-->
        <tr>
            <td colspan="7">
                <table celpadding="0" celspacing="0" width="100%" class="table-border-luar-dalam">
                    <?php
                    $x = 0;
                    foreach ($hardness_test_list_detail as $result) {
                        if ($result->var_type == 'Description') {
                            ?>
                            <tr>
                                <td width="50%">
                                    <?php echo $result->method; ?>
                                </td>
                                <td width="50%">
                                    <?php echo $result->notes; ?>
                                </td>
                            </tr>
                            <?php
                        } else {
                            continue;
                        }

                        $x++;
                    }
                    ?>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="7" width="48%">
            <table  class="table-border-luar-dalam">
                    <tr>
                        <th bgcolor='#ffff99' colspan="7" align='left'>PRODUCT</th>
                    </tr>
                    <tr>
                        <td width='40%'>Customer</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo $hardness_test_list->client_name; ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Customer Code</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo $hardness_test_list->customer_code; ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Vendor</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo $hardness_test_list->vendor_name; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th bgcolor='#ffff99' colspan="7" align="center">TEST RESULT SUMMARY</th>
        </tr>
        <tr>
    <td colspan="7">
        <table cellpadding="0" cellspacing="0" width="100%" class="table-border-luar-dalam">
            <!-- Add table headers -->
            <thead>
                <tr>
                    <th width="33%" align="left">Pencil Hardness</th>
                    <th width="33%" align="center">Result</th>
                    <th width="33%" align="center">Picture</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 0;
                foreach ($hardness_test_list_detail as $result) {
                    if ($result->var_type == 'Description') {
                        continue; // Skip if the type is Description
                    } else {
                        ?>
                        <tr>
                            <!-- Pencil Hardness -->
                            <td width="33%" align="left">
                                <?php echo $result->method; ?>
                            </td>

                            <!-- Result (we'll assume there's a 'result' field or similar) -->
                            <td width="33%" align="center">
                                <?php
                                if (isset($result->result_test_var) && !empty($result->result_test_var)) {
                                    echo $result->result_test_var;  // Display the result
                                } else {
                                }
                                ?>
                            </td>

                            <!-- Picture -->
                            <td width="33%" align="center">
                                <?php
                                if (trim($result->image_file) != "") {
                                    $image = $_SERVER["HTTP_REFERER"] . 'files/hardnesstest/' . $result->hardness_test_list_id . "/" . $result->image_file;
                                    echo "<img src='" . $image . "' width='175'>";
                                } else {
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }

                    $x++;
                }
                ?>
            </tbody>
        </table>
    </td>
</tr>

    </tbody>
</table>
<?php
//$my_pdf->writeHTML($tbl, true, false, true, false, '');
//$file_name = $shipment->shipment_no . '.pdf';
//$my_pdf->Output($file_name, 'D');
?>
