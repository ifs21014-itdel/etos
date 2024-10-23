<div style="width: 100%">
    <form id="purchaseorder_input_form" method="post" novalidate >
        <table width="99%">        
            <tr valign="top">
                <td width="100%">  
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form">
                        <caption><span style="font-weight: bold;">Order Details</span></caption>  
                        <tr>
                            <td><strong>Client PO No</strong></td>
                            <td><input name="po_client_no"  class="easyui-validatebox" style="width: 98%;"/></td>
                        </tr> 
                        <tr>
                            <td><strong>Salesman</strong></td>
                            <td>
                                <input type="text" 
                                       name="salesman_id" 
                                       class="easyui-combobox" 
                                       data-options="
                                       url: '<?php echo site_url('users/get') ?>',
                                       method: 'post',
                                       valueField: 'id',
                                       textField: 'name',
                                       panelHeight: '200'"
                                       style="width: 75%"
                                       required="true"
                                       mode="remote"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>PO Date</strong></td>
                            <td width="70%"><input name="po_date" class="easyui-datebox" style="width: 50%;"  data-options="formatter:myformatter,parser:myparser"></td>
                        </tr>                         
                        <tr>
                            <td><strong>Request Date</strong></td>
                            <td><input name="target_ship_date" class="easyui-datebox" style="width: 50%;" data-options="formatter:myformatter,parser:myparser" style="width: 69%;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr valign="top">
                <td width="100%">
                    <table width="100%" border="0" class="table_form" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="30%"><strong>Client</strong></td>
                            <td width="70%">
                                <input class="easyui-combobox" 
                                       id="client_id"
                                       name="client_id"
                                       url="<?php echo site_url('client/get') ?>"
                                       method="post"
                                       mode="remote"
                                       valueField="id"
                                       textField="name"
                                       data-options="formatter: PI_Client_Format"
                                       style="width: 100%" 
                                       required="true"/>
                                <script type="text/javascript">
                                    function PI_Client_Format(row) {
                                        return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span>';
                                    }
                                </script>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" class="table_form" cellspacing="0" cellpadding="0">
                        <caption><span style="font-weight: bold;">Remarks</span></caption>
                        <tr>
                            <td>
                                <textarea style="width: 99%;height: 60px" name="remark" class="easyui-validatebox"></textarea>

                            </td>
                        </tr>
                    </table>
                    <br/><br/>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" class="table_form" cellspacing="0" cellpadding="0">
                        <caption><span style="font-weight: bold;">Ship TO</span></caption>
                        <tr>
                            <td>
                                <textarea style="width: 99%;height: 60px" name="ship_to" class="easyui-validatebox"></textarea>

                            </td>
                        </tr>
                    </table>
                    <br/><br/>
                </td>
            </tr>
        </table>
    </form>
</div>