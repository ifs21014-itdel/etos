<html>
    <head>
        <title>P.O DETAIL REPORT</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/report.css') ?>">
    </head>
    <body>
        <div style="margin: 5px;min-width: 1220px;font-size: 12px;">
            <!--<img src="<?php echo base_url("files/bl_logo.png") ?>" style="border: none;max-height: 70px;max-width: 70px;margin-bottom: 10px;"/>-->
            <table>
                <tr>
                    <td style="width: 50%;font-size: 18px;font-weight: bold;">PURCHASE ORDER DETAIL REPOT</td>
                    <td style="width: 50%;font-size: 18px;text-align: right;font-weight: bold;">P.O DETAIL REPORT</td>
                </tr>
                <tr>
                    <td style="background: #085" colspan="2">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="2" style="font-size: 12px;"><strong>PERIOD</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td style="width: 100px;font-size: 11px;"><strong>FROM</strong></td>
                                <td style="width: 2px;text-align: center;font-size: 11px;"><strong>:</strong></td>
                                <td style="width: 100px;padding-left: 5px;font-size: 11px;"><?php echo date('d-M-Y', strtotime($date_from)) ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><strong>TO</strong></td>
                                <td style="text-align: center;font-size: 11px;"><strong>:</strong></td>
                                <td style="padding-left: 5px;font-size: 11px;"><?php echo date('d-M-Y', strtotime($date_to)) ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br/>
            <table class="report">
                <thead>
                    <tr>
                        <th width="20">NO</th>
                        <th width="150">ORDER ID</th>
                        <th width="150">P.O NO</th>
                        <th width="80">DATE</th>
                        <th width="150">VENDOR</th>
                        <th width="100">PRODUCT ID</th>
                        <th width="150">PRODUCT NAME</th>
                        <th width="80">WIDTH</th>
                        <th width="80">DEPTH</th>
                        <th width="80">HEIGHT</th>
                        <th width="80">VOLUME</th>
                        <th width="50">QTY</th>
                        <th width="150">PRICE</th>
                        <th width="50">CURRENCY</th>
                        <th width="150">DISCOUNT</th>
                        <th width="150">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($order)) {
                        $no = 1;
                        foreach ($order as $result) {
                            ?>
                            <tr>
                                <td style="text-align: right;"><?php echo $no++; ?></td>
                                <td><?php echo $result->order_id ?></td>
                                <td><?php echo $result->po_no ?></td>
                                <td><?php echo $result->po_date ?></td>
                                <td><?php echo $result->vendor_name ?></td>
                                <td><?php echo $result->product_code ?></td>
                                <td><?php echo $result->product_name ?></td>
                                <td><?php echo $result->width ?></td>
                                <td><?php echo $result->depth ?></td>
                                <td><?php echo $result->height ?></td>
                                <td><?php echo $result->volume ?></td>
                                <td><?php echo $result->qty ?></td>
                                <td align="right"><?php echo number_format($result->price) ?></td>
                                <td><?php echo $result->curr_code ?></td>
                                <td align="right"><?php echo number_format($result->discount_nominal) ?></td>
                                <td align="right"><?php echo number_format($result->total) ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="20">No Data...</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>