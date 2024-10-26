<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengujian</title>
    <style>
        .table-border-luar {
            border-collapse: collapse;
            border: 1px solid black;
        }

        .table-border-luar th, .table-border-luar td {
            padding: 8px;
            border: none;
        }

        .table-border-luar-dalam {
            border-collapse: collapse;
            border: 1px solid black;
        }

        .table-border-luar-dalam th, .table-border-luar-dalam td {
            padding: 8px;
            border: 1px solid black;
        }

        h3 {
            margin: 0;
            padding: 0;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <table border="1" align="center" class="table-border-luar" width="1000">
        <thead>
            <tr>
                <td class="center" width="34%">
                    <img src="<?php echo $_SERVER['HTTP_REFERER'] . 'files/logo.png'; ?>" width="100">
                </td>
                <td colspan="5" class="center" width="33%"><h3>TEST REPORT</h3></td>
                <td class="center" width="34%"><b>Quality Assurance Department</b></td>
            </tr>
        </thead>

        <tbody>
            <!-- Informasi Report -->
            <tr>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam">
                        <tr>
                            <td width="40%">Report Number</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->report_no; ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Test Date</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo date('d M Y', strtotime($drop_test_list->test_date)); ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Report Date</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo date('d M Y', strtotime($drop_test_list->report_date)); ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Type of Report</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->protocol_name; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam">
                        <tr>
                            <th colspan="3">RESULT</th>
                        </tr>
                        <tr>
                            <td width="50%">PASS</td>
                            <td width="2%" align="center">:</td>
                            <td width="48%" class="center">
                                <?php if ($drop_test_list->rating == 'Passed') echo '<b>X</b>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">FAIL</td>
                            <td width="2%" align="center">:</td>
                            <td width="48%" class="center">
                                <?php if ($drop_test_list->rating == 'Failed') echo '<b>X</b>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">CAR</td>
                            <td width="2%" align="center">:</td>
                            <td width="48%" class="center">
                                <?php if ($drop_test_list->rating == 'Car') echo '<b>X</b>'; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Informasi Produk -->
            <tr>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam">
                        <tr>
                            <th colspan="3">PRODUCT</th>
                        </tr>
                        <tr>
                            <td width="40%">Customer</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->client_name; ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Ebako Code</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->ebako_code; ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Customer Code</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->customer_code; ?></td>
                        </tr>
                        <tr>
                            <td width="40%">Item Description</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->item_description; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam">
                        <tr>
                            <th colspan="3">PRODUCT SPECIFICATION</th>
                        </tr>
                        <tr>
                            <td width="50%">Product Dimension (Inches)</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->product_dimension; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Carton Dimension (Inches)</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->carton_dimension; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Gross Weight (Lbs)</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->gross_weight; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Nett Weight (Lbs)</td>
                            <td width="2%" align="center">:</td>
                            <td width="58%"><?php echo $drop_test_list->nett_weight; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Gambar Produk dan Corrective Action -->
            <tr>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam" width="100%">
                        <tr>
                            <th colspan="3">Sample Test Picture</th>
                        </tr>
                        <tr>
                            <td height="100" width="500" align="center">
                                <?php if (trim($drop_test_list->product_image) != ""): ?>
                                    <img src="<?php echo $_SERVER["HTTP_REFERER"] . 'files/droptest/' . $drop_test_list->id . "/" . $drop_test_list->product_image; ?>" width="105" height="100">
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam" width="100%">
                        <tr>
                            <th colspan="3">Corrective Action Item</th>
                        </tr>
                        <tr>
                            <td height="100" width="500" align="center">
                                <?php echo $drop_test_list->corrective_action_plan_image; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Test Result Summary -->
            <tr>
                <th bgcolor="#ffff99" colspan="7" class="center">TEST RESULT SUMMARY</th>
            </tr>
            <tr>
                <td colspan="7">
                    <table width="100%" class="table-border-luar-dalam">
                        <?php foreach ($drop_test_list_detail as $result): ?>
                            <?php if ($result->var_type != 'Description'): ?>
                                <tr>
                                    <td width="40%"><?php echo $result->method; ?></td>
                                    <td width="10%"><?php echo $result->result_test_var; ?></td>
                                    <td class="center" width="50%">
                                        <?php if (trim($result->image_file) != ""): ?>
                                            <img src="<?php echo $_SERVER["HTTP_REFERER"] . 'files/droptest/' . $result->drop_test_list_id . "/" . $result->image_file; ?>" width="175">
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
