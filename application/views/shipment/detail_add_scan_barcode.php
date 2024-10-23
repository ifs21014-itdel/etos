<form id="shipment_input_detail_scan_barcode_form" method="post" novalidate class="table_form">
    <table width="100%" border="0" bgcolor="green">
        <caption><h1>SCAN BARCODE</h1></caption>
        <tr bgcolor="red">
            <td>
                <input type="text" name="serial_number_scan" name="serial_number_scan_id"  id="serial_number_scan_id" style="height:80px; width:100%;font-size: 25pt;text-align: center;" onkeypress="if (event.keyCode === 13) {
                            // alert(document.getElementById('button-save-id').value);
                            event.preventDefault();
                            document.getElementById('button-save-id').click();
                        }"/>
                <!--<input type="text" name="serial_number_scan" name="serial_number_scan_id"  id="serial_number_scan_id" style="height:80px; width:100%;font-size: 25pt;text-align: center;" />-->
<!--                <script>
//                    $("#serial_number_scan_id").keyup(function (event) {
//                        if (event.keyCode === 13) {
//                            $("#button-save-id").click();
//                        }
//                    });
                    document.getElementById("serial_number_scan_id")
                            .addEventListener("keyup", function (event) {
                                event.preventDefault();
                                if (event.keyCode === 13) {
                                    alert(document.getElementById("button-save-id").value);
                                    document.getElementById("button-save-id").click();
                                }
                            });
                </script>-->
            </td>
        </tr>

    </table>        
</form>