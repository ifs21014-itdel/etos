<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Pengujian</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                table-layout: fixed; /* Membuat tabel tidak meluas melebihi halaman */
            }

            th {
                border: 1px solid black;
                padding: 2px;
                /*word-wrap: break-word;  Menghindari teks memanjang melebihi lebar cell */
                text-align: center;    /* Selaraskan teks di tengah */
            }

            td{
                border: 1px solid black;
                padding: 2px;
                /*word-wrap: break-word;  Menghindari teks memanjang melebihi lebar cell */
                /*text-align: center;     Selaraskan teks di tengah */
                font-size: 8pt;
            }

            /*            img {
                            max-width: 100%;  Batasi lebar gambar 
                            height: auto;     Jaga proporsi gambar 
                            display: block;   Pastikan gambar berada dalam konteks block 
                            margin: 0 auto;   Pusatkan gambar 
                        }*/
        </style>
    </head>
    <body>
        <table border="1" align="center"  width="100%">
            <tr>
                <td width="34%">
                    <img src="<?php echo $_SERVER['HTTP_REFERER'] . 'files/logo.png'; ?>" width="100">
                </td>
                <td width="32%"><h3>TEST REPORT</h3></td>
                <td width="34%"><b>Quality Assurance Department</b></td>
            </tr>
        </table><br/>
        <table border="1" align="center"  width="100%">
            <!--Informasi Report--> 
            <tr>
                <td width="48%">
                    <table >
                        <tr>
                            <td width="40%">Report Number</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $print_mark_test_list->report_no; ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Test Date</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo date('d M Y', strtotime($print_mark_test_list->test_date)); ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Report Date</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo date('d M Y', strtotime($print_mark_test_list->report_date)); ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Type of Report</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $print_mark_test_list->protocol_name; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td width="48%">
                    <table >
                        <tr>
                            <th colspan="3">RESULT</th>
                        </tr>
                        <tr>
                            <td width="50%">PASS</td>
                            <td width="2%" align="center">:</td>
                            <td width="48%">
                                <?php if ($print_mark_test_list->rating == 'Passed') echo '<b>X</b>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">FAIL</td>
                            <td width="2%" align="center">:</td>
                            <td width="48%">
                                <?php if ($print_mark_test_list->rating == 'Failed') echo '<b>X</b>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">CAR</td>
                            <td width="2%" align="center">:</td>
                            <td width="48%">
                                <?php if ($print_mark_test_list->rating == 'Car') echo '<b>X</b>'; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table><br/>
        
        <table border="1" align="center"  width="100%">

            <!--Gambar Produk dan Corrective Action--> 
            <tr>
                <td width="48%">
                    <table  width="100%">
                        <tr>
                            <th>Sample Test Picture</th>
                        </tr>
                        <tr>
                            <td height="100"  align="center">
                                <?php if (trim($print_mark_test_list->product_image) != ""): ?>
                                    <img src="<?php echo $_SERVER["HTTP_REFERER"] . 'files/printmarktest/' . $print_mark_test_list->id . "/" . $print_mark_test_list->product_image; ?>" width="105" height="100">
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td width="48%">
                    <table  width="100%">
                        <tr>
                            <th>Corrective Action Item</th>
                        </tr>
                        <tr>
                            <td height="100" align="center">
                                <?php echo $print_mark_test_list->corrective_action_plan_image; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table><br/>

       
        <table border="1" align="center"  width="100%">

            <!--Informasi Produk--> 
            <tr>
                <td width="48%" aligcn="center">
                    <table>
                        <tr>
                            <th colspan="3">PRODUCT</th>
                        </tr>
                        <tr>
                            <td width="40%">Customer</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $print_mark_test_list->client_name; ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Ebako Code</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $print_mark_test_list->ebako_code; ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Customer Code</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $print_mark_test_list->customer_code; ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Item Description</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $print_mark_test_list->item_description; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table><br/>
                <!--Test Result Summary--> 
        <table border="1" align="center"  width="100%">
            <tr>
            <table width="100%" >
                <caption>TEST RESULT SUMMARY</caption>
                <?php
                foreach ($print_mark_test_list_detail as $result) {
                    if ($result->var_type != 'Description') {
                        ?>
                        <tr>
                            <td width="40%"><?php echo $result->method; ?></td>
                            <td width="10%" align="center"><?php echo $result->result_test_var; ?></td>
                            <td style="vertical-align: middle; text-align: center;">
                                <?php if (trim($result->image_file) != "") { ?>
                                    <img src="<?php echo $_SERVER["HTTP_REFERER"] . 'files/printmarktest/' . $result->print_mark_test_list_id . "/" . $result->image_file; ?>" style="max-width:50%; height:auto;">
                                <?php } ?>
                            </td>
                        </tr> 
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td width="40%"><?php echo $result->method; ?></td>
                            <td width="10%"><?php echo $result->result_test_var; ?></td>
                            <td width="50%"><?php echo $result->image_file; ?></td>
                        </tr> 
                        <?php
                    }
                }
                ?>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
