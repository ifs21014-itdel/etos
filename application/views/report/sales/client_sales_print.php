<html>
    <head>
        <title>SHIPMENT REPORT</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/report.css') ?>">
    </head>
    <body>
        <div style="margin: 5px;min-width: 1220px;font-size: 12px;">
            <!--<img src="<?php echo base_url("files/bl_logo.png") ?>" style="border: none;max-height: 70px;max-width: 70px;margin-bottom: 10px;"/>-->
            <table>
                <tr>
                    <td style="width: 50%;font-size: 18px;font-weight: bold;">SHIPMENT REPORT</td>
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
                        <th align="center"  width="100">No</th>
                        <th align="center"  width="100">Shipment No</th>
                        <th align="center"  width="100">Container No</th>
                        <th align="center"  width="100">Serial No</th>
                        <th align="center"  width="100">Client PO No</th>
                        <th align="center"  width="50">Target Shipment</th>
                        <th align="center"  width="80">Date</th>
                        <th align="center"  width="150">Client</th>
                        <th align="center"  width="150">Shipto</th>
                        <th align="center" width="100" halign="center">Ebako Code</th>
                        <th  align="center" width="100" halign="center">Customer Code</th>
                        <th  align="center" width="120" halign="center">Finishing</th>
                        <th  align="center" width="120" halign="center">Material</th>
                        <th  align="center" width="100" halign="center">Line</th>
                        <th  align="center" width="100" halign="center">Release No</th>
                        <th  align="center" width="100" halign="center">Tag For</th>
                        <th  align="center" width="100" halign="center">Seal No</th>
                        <th  align="center" width="100" halign="center">Loadibility</th>
                        <th  align="center" width="100" halign="center">Tally User</th>
                        <th  align="center" width="100" halign="center">Remarks</td>
                        <th  align="center" width="100" halign="center">Description</th>
                    </tr>
                </thead>
                <?php
                if (!empty($order)) {
                    $no = 1;
                    foreach ($order as $result) {
                        $query = "select rd.*,p.ebako_code,p.image product_image,p.customer_code, 
                                        p.remarks, p.finishing, p.material,po.po_no,po.po_client_no,po.target_ship_date,po.ship_to,
                                        poi.finishing,poi.line,p.material,poi.release_no,poi.tagfor ,poi.description 
                                        from shipment_detail rd 
                                        left join product_order_detail pod on rd.serial_number=pod.serial_number 
                                        left join purchaseorder_item poi on pod.purchaseorder_item_id=poi.id 
                                        join products p on poi.product_id=p.id join purchaseorder po on poi.purchaseorder_id=po.id 
                                        join client c on po.client_id=c.id 
                                        where rd.shipmentid=$result->id";
                        $data = $this->db->query($query)->result();
                        ?>

                        <?php
                        $i = 0;
                        foreach ($data as $result2) {
                            ?>
                            <tr>
                                <td style="text-align: right;"><?php echo $no++; ?></td>
                                <td><?php echo $result->shipment_no ?></td>
                                <td><?php echo $result->container_no ?></td>
                                <td><?php echo $result2->serial_number ?></td>
                                <td><?php echo $result2->po_client_no ?></td>
                                <td><?php echo date_format(date_create($result2->target_ship_date), 'd-m-Y') ?></td>
                                <td><?php echo date_format(date_create($result->date), 'd-m-Y') ?></td>
                                <td><?php echo $result->client_name ?></td>
                                <td><?php echo $result2->ship_to ?></td>
                                <td><?php echo $result2->ebako_code ?></td>
                                <td><?php echo $result2->customer_code ?></td>
                                <td><?php echo $result2->finishing ?></td>
                                <td><?php echo $result2->material ?></td>
                                <td><?php echo $result2->line ?></td>
                                <td><?php echo $result2->release_no ?></td>
                                <td><?php echo $result2->tagfor ?></td>
                                <td><?php echo $result->seal_no ?></td>
                                <td><?php echo $result->loadibility ?></td>
                                <td><?php echo $result->tally_user ?></td>
                                <td><?php echo $result2->remarks ?></td>
                                <td><?php echo $result2->description ?></td>
                            </tr>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="21">No Data...</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </body>
</html>