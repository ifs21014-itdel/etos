<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Mark Test Report</title>
    <style>
        /* Tabel dengan border hanya di luar */
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
    </style>
</head>

<body>
    <table border="1" align="center" class="table-border-luar" width="1000">
        <thead>
            <tr>
                <td align='center' width="34%">
                    <?php
                    $image = $_SERVER["HTTP_REFERER"] . 'files/logo.png';
                    echo "<img src='" . $image . "' width='100'>";
                    ?>
                </td>
                <td colspan="5" align="center" width="33%"><h3>TEST REPORT</h3></td>
                <td align='center' width="34%"><b>Quality Assurance Department</b></td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam">
                        <tr>
                            <td width='40%'>Report Number</td>
                            <td width='2%' align='center'>:</td>
                            <td width='58%'><?php echo $print_mark_test_list->report_no; ?></td>
                        </tr>
                        <tr>
                            <td width='40%'>Test date</td>
                            <td width='2%' align='center'>:</td>
                            <td width='58%'><?php echo date('d M Y', strtotime($print_mark_test_list->test_date)); ?></td>
                        </tr>
                        <tr>
                            <td width='40%'>Report Date</td>
                            <td width='2%' align='center'>:</td>
                            <td width='58%'><?php echo date('d M Y', strtotime($print_mark_test_list->report_date)); ?></td>
                        </tr>
                        <tr>
                            <td width='40%'>Type of Report</td>
                            <td width='2%' align='center'>:</td>
                            <td width='58%'><?php echo $print_mark_test_list->protocol_name; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam">
                        <tr>
                            <th bgcolor='#ffff99' colspan="3">RESULT</th>
                        </tr>
                        <tr>
                            <td width='50%'>PASS</td>
                            <td width='2%' align='center'>:</td>
                            <td width='48%' align='center'>
                                <?php if ($print_mark_test_list->rating == 'Passed') echo '<b>X</b>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width='50%'>FAIL</td>
                            <td width='2%' align='center'>:</td>
                            <td width='48%' align='center'>
                                <?php if ($print_mark_test_list->rating == 'Failed') echo '<b>X</b>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width='50%'>CAR</td>
                            <td width='2%' align='center'>:</td>
                            <td width='48%' align='center'>
                                <?php if ($print_mark_test_list->rating == 'Car') echo '<b>X</b>'; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam" width='100%'>
                        <tr>
                            <th bgcolor='#ffff99' colspan="3">Sample Test Picture</th>
                        </tr>
                        <tr>
                            <td height="100" width="500" align="center">
                                <?php
                                if (trim($print_mark_test_list->product_image) != "") {
                                    $image = $_SERVER["HTTP_REFERER"] . 'files/printmarktest/' . $print_mark_test_list->id . "/" . $print_mark_test_list->product_image;
                                    echo "<img src='" . $image . "' width='105' height='100'>";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td colspan="3" width="48%">
                    <table class="table-border-luar-dalam" width='100%'>
                        <tr>
                            <th bgcolor='#ffff99' colspan="3">Corrective Action Item</th>
                        </tr>
                        <tr>
                            <td height="100" width="500" align="center">
                                <?php echo $print_mark_test_list->corrective_action_plan_image; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="7">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table-border-luar-dalam">
                        <?php foreach ($print_mark_test_list_detail as $result) {
                            if ($result->var_type == 'Description') { ?>
                                <tr>
                                    <td width="50%"><?php echo $result->method; ?></td>
                                    <td width="50%"><?php echo $result->notes; ?></td>
                                </tr>
                            <?php }
                        } ?>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="7" width="48%">
                    <table class="table-border-luar-dalam">
                        <tr>
                            <th bgcolor='#ffff99' colspan="7" align='left'>PRODUCT</th>
                        </tr>
                        <tr>
                            <td width='40%'>Customer</td>
                            <td width='2%' align='center'>:</td>
                            <td width='58%'><?php echo $print_mark_test_list->client_name; ?></td>
                        </tr>
                        <tr>
                            <td width='40%'>Customer Code</td>
                            <td width='2%' align='center'>:</td>
                            <td width='58%'><?php echo $print_mark_test_list->customer_code; ?></td>
                        </tr>
                        <tr>
                            <td width='40%'>Vendor</td>
                            <td width='2%' align='center'>:</td>
                            <td width='58%'><?php echo $print_mark_test_list->vendor_name; ?></td>
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
                        <thead>
                            <tr>
                                <th width="33%" align="left">Pencil Print Mark</th>
                                <th width="33%" align="center">Result</th>
                                <th width="33%" align="center">Picture</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($print_mark_test_list_detail as $result) {
                                if ($result->var_type != 'Description') { ?>
                                    <tr>
                                        <td width="33%" align="left"><?php echo $result->method; ?></td>
                                        <td width="33%" align="center"><?php echo $result->result_test_var; ?></td>
                                        <td width="33%" align="center">
                                            <?php
                                            if (trim($result->image_file) != "") {
                                                $image = $_SERVER["HTTP_REFERER"] . 'files/printmarktest/' . $result->print_mark_test_list_id . "/" . $result->image_file;
                                                echo "<img src='" . $image . "' width='175'>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
