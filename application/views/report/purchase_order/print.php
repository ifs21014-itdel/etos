<html>
    <head>
        <title>P.O REPORT</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/report.css') ?>">
    </head>
    <body>
        <div style="margin: 5px;min-width: 1220px;font-size: 12px;">
            <!--<img src="<?php echo base_url("files/bl_logo.png") ?>" style="border: none;max-height: 70px;max-width: 70px;margin-bottom: 10px;"/>-->
            <table>
                <tr>
                    <td style="width: 50%;font-size: 18px;font-weight: bold;">PURCHASE ORDER REPORT</td>
                    <td style="width: 50%;font-size: 18px;text-align: right;font-weight: bold;">P.O REPORT</td>
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
                        <th align="center"  rowspan="2"  width="100">No</th>
                        <th align="center"  rowspan="2"  width="100">Client PO No</th>
                        <th align="center"  rowspan="2"  width="100">Ebako P.O NO</th>
                        <th align="center"  rowspan="2"  width="80">DATE</th>
                        <th align="center"  rowspan="2"  width="150">Client</th>
                        <th align="center"  rowspan="2"  width="50">TARGET SHIPMENT</th>
                        <th align="center"  rowspan="2"  width="150">SHIPTO</th>
                        <th align="center" rowspan="2" width="100" halign="center">Ebako Code</th>
                        <th  align="center" rowspan="2" width="100" halign="center">Customer Code</th>
                        <th  align="center" rowspan="2" width="50" align="center">Qty</th>
                        <th  align="center" rowspan="2" width="120" halign="center">Packing Conf.</th>
                        <th  align="center" colspan="3">SERIAL</th>
                        <th  align="center" rowspan="2" width="120" halign="center">Finishing</th>
                        <th  align="center" rowspan="2" width="120" halign="center">Material</th>
                        <th  align="center" rowspan="2" width="120" halign="center">Promise Date</th>
                        <th  align="center" rowspan="2" width="100" halign="center">Line</th>
                        <th  align="center" rowspan="2" width="100" halign="center">Release No</th>
                        <th  align="center" rowspan="2" width="100" halign="center">Tag For</th>
                        <th  align="center" rowspan="2" width="100" halign="center">Remarks</td>
                        <th  align="center" rowspan="2" width="100" halign="center">Description</th>
                    </tr>
                    <tr>
                        <th align="center" width="120" halign="center" align="center">Qty</th>
                        <th align="center" width="120" halign="center" align="center">Shiped</th>
                        <th align="center" align="center">Outstanding</th>
                    </tr>
                </thead>
                <?php
                if (!empty($order)) {
                    $no = 1;
                    foreach ($order as $result) {

                        $query = "select p.ebako_code,p.customer_code,p.packing_configuration,p.description,p.remarks,poi.finishing,p.material,"
                                . "(select count(*) from product_order_detail where ship_date is not null and purchaseorder_item_id=poi.id) as total_shiped, "
                                . "poi.* from purchaseorder_item poi LEFT JOIN products p ON p.id=poi.product_id where poi.purchaseorder_id='" . $result->id . "'";
                        $data = $this->db->query($query)->result();
                        ?>

                        <?php
                        $i = 0;
                        foreach ($data as $result2) {
                            ?>
                            <tr>
                                <td style="text-align: right;"><?php echo $no++; ?></td>
                                <td><?php echo $result->po_client_no ?></td>
                                <td><?php echo $result->po_no ?></td>
                                <td><?php echo date_format(date_create($result->po_date), 'd-m-Y') ?></td>
                                <td><?php echo $result->vendor_name ?></td>
                                <td><?php echo $result->target_ship_date ?></td>
                                <td><?php echo $result->ship_to ?></td>
                                <td><?php echo $result2->ebako_code ?></td>
                                <td><?php echo $result2->customer_code ?></td>
                                <td><?php echo $result2->qty ?></td>
                                <td><?php echo $result2->packing_configuration ?></td>
                                <td><?php echo $result2->label_qty ?></td>
                                <td><?php echo $result2->total_shiped ?></td>
                                <td><?php echo ($result2->label_qty - $result2->total_shiped) ?></td>
                                <td><?php echo $result2->finishing ?></td>
                                <td><?php echo $result2->material ?></td>
                                <td><?php echo date_format(date_create($result2->promise_date), 'd-m-Y') ?></td>
                                <td><?php echo $result2->line ?></td>
                                <td><?php echo $result2->release_no ?></td>
                                <td><?php echo $result2->tagfor ?></td>
                                <td><?php echo $result2->remarks ?></td>
                                <td><?php echo $result2->description ?></td>
                            </tr>
                            <?php
                        }
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