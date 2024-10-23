<form id="purchaseorder_product_input_form" method="post" novalidate style="padding: 2px;">
    <table width="100%" border="0" class="table_form" cellspacing="0" cellpadding="0">     


        <tr>
            <td width="30%"><strong>Product Code </strong></td>
            <td width="70%">


                <input type="text" name="product_id" id="product_id" mode="remote" style="width: 250px" required="true"/>
                <script type="text/javascript">
                    $('#product_id').combogrid({
                        panelWidth: 460,
                        idField: 'id',
                        textField: 'ebako_code',
                        url: '<?php echo site_url('products/get/' . $client_id) ?>',
                        columns: [[
                                {field: 'id', title: 'ID', width: 60},
                                {field: 'ebako_code', title: 'Ebako COde', width: 100},
                                {field: 'customer_code', title: 'Customer Code', width: 50},
                                {field: 'packing_configuration', title: 'Packing Conf', width: 100},
                                {field: 'description', title: 'Desc', width: 200},
                                {field: 'remarks', title: 'Remarks', width: 200},
                                {field: 'finishing', title: 'Finishing', width: 200},
                                {field: 'material', title: 'Materials', width: 200}
                            ]]
                    });
                </script>
            </td>
        </tr>

        <tr>
            <td><strong>Qty</strong></td>
            <td>
                <input type="text" name="qty" id="pi_prod_qty" class="easyui-textbox easyui-numberbox" style="width: 50px;text-align: center;" required='true'/>
            </td>
        </tr>   
        <tr>
            <td width="30%"><strong>Promise Date</strong></td>
            <td width="70%"><input name="promise_date" class="easyui-datebox" style="width: 50%;"  data-options="formatter:myformatter,parser:myparser"></td>
        </tr>
        <tr>
            <td><strong>Line</strong></td>
            <td><input name="line"  class="easyui-validatebox" style="width: 98%;"/></td>
        </tr>        
        <tr>
            <td><strong>Release Number</strong></td>
            <td><input name="release_no"  class="easyui-validatebox" style="width: 98%;"/></td>
        </tr>      
        <tr>
            <td><strong>Finishing</strong></td>
            <td>
                <textarea style="width: 99%;height: 60px" name="finishing" class="easyui-validatebox"></textarea>
            </td>
        </tr>      
        <tr>
            <td><strong>Remarks</strong></td>
            <td>
                <textarea style="width: 99%;height: 60px" name="remarks" class="easyui-validatebox"></textarea>
            </td>
        </tr>        
        <tr>
            <td><strong>Tag For</strong></td>
            <td><input name="tagfor"  class="easyui-validatebox" style="width: 98%;"/></td>
        </tr>           
        <tr>
            <td><strong>Description</strong></td>
            <td><textarea style="width: 99%;height: 60px" name="description" class="easyui-validatebox"></textarea></td>
                
        </tr>   
    </table>
</form>