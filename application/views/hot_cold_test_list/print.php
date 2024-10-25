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
//var_dump($hot_cold_test_list);
?>
<head>
    <style>
        .sample-image {
            width: 150px;
            height: auto;
            display: block;
            margin: 10px auto;
        }

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
                        <td width='58%'><?php echo $hot_cold_test_list->report_no; ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Test date</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo date('d M Y', strtotime($hot_cold_test_list->test_date)); ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Report Date</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo date('d M Y', strtotime($hot_cold_test_list->report_date)); ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Type of Report</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo $hot_cold_test_list->protocol_name; ?></td>
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
                            if ($hot_cold_test_list->rating == 'Passed')
                                echo '<b>X</b>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='50%'>FAIL</td>
                        <td width='2%' align='center'>:</td>
                        <td width='48%'>
                            <?php
                            if ($hot_cold_test_list->rating == 'Failed')
                                echo '<b>X</b>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='50%'>CAR</td>
                        <td width='2%' align='center'>:</td>
                        <td width='48%'>
                            <?php
                            if ($hot_cold_test_list->rating == 'Car')
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
                            if (trim($hot_cold_test_list->product_image) != "") {
                                $image = $_SERVER["HTTP_REFERER"] . 'files/hotcoldtest/' . $hot_cold_test_list->id . "/" . $hot_cold_test_list->product_image;
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
                            echo $hot_cold_test_list->corrective_action_plan_image;
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
                    foreach ($hot_cold_test_list_detail as $result) {
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
                        <th bgcolor='#ffff99' colspan="3" align="left">PRODUCT</th>
                    </tr>
                    <tr>
                        <td width='40%'>Customer</td>
                        <td width='2%' align='center'>:</td>

                        <td width='58%'><?php echo $hot_cold_test_list->client_name; ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Ebako Code</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo $hot_cold_test_list->ebako_code; ?></td>
                    </tr>
                    <tr>
                        <td width='40%'>Vendor</td>
                        <td width='2%' align='center'>:</td>
                        <td width='58%'><?php echo $hot_cold_test_list->vendor_name; ?></td>
                    </tr>
                   

                </table>
            </td>
            <td width="4%"></td>
        </tr>

        <tr>
            <td colspan="7" width="100%">
                <table class="table-border-luar-dalam" width="100%">
                    <tr>
                        <th bgcolor='#ffff99' colspan="3" align="left">Testing Conditions (1 Cycle) = Total 10 Cycles</th>
                    </tr>
                    <tr>
                        <td width='33%' align="left"><b>Condition A</b></td>
                        <td width='33%' align="left">Temperature <?php echo $hot_cold_test_list->condition_a_temp; ?>°C (oven)</td>
                        <td width='33%' align="left">Duration <?php echo $hot_cold_test_list->condition_a_duration; ?> hour</td>
                    </tr>
                    <tr>
                        <td align="left">Room Temperature </td>
                        <td colspan="2" align="left">Rest <?php echo $hot_cold_test_list->room_temp_rest_a_duration; ?> minutes </td>
                    </tr>
                    <tr>
                        <td width='33%' align="left"><b>Condition B</b></td>
                        <td width='33%' align="left">Temperature <?php echo $hot_cold_test_list->condition_b_temp; ?>°C (freezer)</td>
                        <td width='33%' align="left">Duration <?php echo $hot_cold_test_list->condition_b_duration; ?> hour</td>
                    </tr>
                    <tr>
                        <td align="left">Room Temperature </td>
                        <td colspan="2" align="left">Rest <?php echo $hot_cold_test_list->room_temp_rest_b_duration; ?> minutes </td>
                    </tr>
                </table>
            </td>
               
            
        </tr>

         <tr>
            <td colspan="7" width="100%">
                <table class="table-border-luar-dalam" width="100%">
                <tr><th bgcolor='#ffff99' colspan="11">Testing Progress</th></tr>
                        <tr>
                            <td>Cycle</td>
                            <?php for ($i = 1; $i <= 10; $i++) { echo "<td>$i</td>"; } ?>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <?php for ($i = 1; $i <= $hot_cold_test_list->cycles; $i++) { echo "<td>√</td>"; } ?>
                            <?php for ($i = $hot_cold_test_list->cycles + 1; $i <= 10; $i++) { echo "<td>-</td>"; } ?>
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
                    <?php foreach ($hot_cold_test_list_detail as $result) { ?>
                        <tr>
                            <!-- Tampilkan gambar pertama -->
                            <td colspan="3" align="center">
                                <?php if (trim($result->image_file) != "") {
                                    $image = $_SERVER["HTTP_REFERER"] . 'files/hotcoldtest/' . $result->hot_cold_test_list_id . "/" . $result->image_file;
                                    echo "<img src='" . $image . "' class='sample-image' alt='Sample Image 1' />";
                                    echo "<br><span style='font-size: 12px;'>" . $result->method . "</span>";
                                } ?>
                            </td>

                            <!-- Tampilkan gambar kedua -->
                            <td colspan="3" align="center">
                                <?php if (trim($result->image2_file) != "") {
                                    $image2 = $_SERVER["HTTP_REFERER"] . 'files/hotcoldtest/' . $result->hot_cold_test_list_id . "/" . $result->image2_file;
                                    echo "<img src='" . $image2 . "' class='sample-image' alt='Sample Image 2' />";
                                    echo "<br><span style='font-size: 12px;'>" . $result->method . "</span>";
                                } ?>
                            </td>
                        </tr>

                        <!-- Tampilkan evaluation dan result_test_var -->
                        <tr>
                            <td colspan="3" style="text-align: center; font-weight: bold;"><?php echo $result->evaluation; ?></td>
                            <td colspan="3" style="text-align: center; font-weight: bold;"><?php echo $result->result_test_var; ?></td>
                        </tr>
                    <?php } ?>
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
