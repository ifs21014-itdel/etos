<form id="shipment_input_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="30%"><strong>Date</strong></td>
            <td width="70%">
                <input type="text" 
                       name='date' 
                       class="easyui-datebox" 
                       required="true" 
                       data-options="formatter:myformatter,parser:myparser"
                       style="width:120px"/>
            </td>
        </tr>
        <tr>
            <td><strong>Container No.</strong></td>
            <td><input type="text" name="container_no" style="width: 99%;" class="easyui-validatebox"/></td>
        </tr>
        <tr>
            <td><strong>Seal No</strong></td>
            <td><input type="text" name="seal_no" style="width: 99%;" class="easyui-validatebox"/></td>
        </tr>
        <tr>
            <td><strong>Loadibility</strong></td>
            <td><input type="text" name="loadibility" style="width: 99%;" class="easyui-validatebox"/></td>
        </tr>
        <tr>
            <td><strong>Description</strong></td>
            <td><textarea name="description_of_goods" style="width: 99%;height: 50px" class="easyui-validatebox"></textarea></td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="0" class="table_form" cellspacing="0" cellpadding="0">
                    <caption><span style="font-weight: bold;">Shipping Details</span></caption>
                    <tr>
                        <td width="30%"><strong>Client </strong></td>
                        <td width="70%">                                    
                            <input class="easyui-combobox" 
                                   id="sh_client_id"
                                   name="client_id"
                                   url="<?php echo site_url('client/get') ?>"
                                   method="post"
                                   mode="remote"
                                   valueField="id"
                                   textField="company"
                                   data-options="formatter: PI_Client_Format"
                                   style="width: 80%" 
                                   required="true"/>
                            <script type="text/javascript">
                                function PI_Client_Format(row) {
                                    return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span><br/>';
                                }
//                                    $('#ship_to').combobox({
//                                        onSelect: function (row) {
//                                            $('#ship_phone_fax').val(row.phone + '/' + row.fax);
//                                            $('#ship_address').val(row.address);
//                                            $('#ship_email').val(row.email);
//                                            $('#pi_ship_port_of_destination').val(row.country);
//                                        }
//                                    });
                            </script>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><strong>Tally User</strong></td>
            <td><input type="text" name="tally_user" style="width: 99%;" class="easyui-validatebox"/></td>
        </tr>
    </table>        
</form>