<td style="border:0px solid #000000;">
                    <table cellpadding="0"  cellspacing="0">
                        <tr>
                            <td width="30%">Customer</td>
                            <td width="2%">:</td>
                            <td>' . $result->client_name . '</td>
                        </tr>
                        <tr>
                            <td>PO Number</td>
                            <td>:</td>
                            <td>' . $result->po_no . '</td>
                        </tr>
                        <tr>
                            <td>PO date</td>
                            <td>:</td>
                            <td>' . date('d-m-Y', strtotime($result->po_date)) . '</td>
                        </tr>
                        <tr>
                            <td>SERIAL NUMBER</td>
                            <td>:</td>
                            <td>' . $result->serial_number . '</td>
                        </tr>
                        <tr>
                            <td>Ebako Code</td>
                            <td>:</td>
                            <td>' . $result->ebako_code . '</td>
                        </tr>
                        <tr>
                            <td>Customer Code</td>
                            <td>:</td>
                            <td>' . $result->customer_code . '</td>
                        </tr>
                        <tr>
                            <td>Finishing</td>
                            <td>:</td>
                            <td>' . $result->finishing . '</td>
                        </tr>
                        <tr>
                            <td>Qty Order</td>
                            <td>:</td>
                            <td>' . $result->qty . '</td>
                        </tr>
                    </table>
                </td>