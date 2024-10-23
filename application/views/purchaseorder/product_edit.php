<form id="po_product_edit_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="30%"><strong>Product Code</strong></td>
            <td width="70%"><input type="text" name='item_code' readonly="" class="easyui-validatebox" required="true" style="width: 98%"/></td>
        </tr>
        <tr>
            <td><strong>Product Name</strong></td>
            <td><input type="text" name='item_description' readonly="" class="easyui-validatebox" style="width: 98%"/></td>
        </tr>
        <tr>
            <td><strong>Dimension (W x D x H)</strong></td>
            <td>
                <input type="text" class="easyui-numberbox" readonly="" style="width: 50px" name='width'/>&nbsp;x
                <input type="text" class="easyui-numberbox" readonly="" style="width: 50px" name='depth'/>&nbsp;x
                <input type="text" class="easyui-numberbox" readonly="" style="width: 50px" name='height'/>
            </td>
        </tr>
        <tr>
            <td><strong>Qty</strong></td>
            <td><input type="text" name='qty' readonly="" class="easyui-numberbox" style="width: 30px"/></td>
        </tr>
        <tr>
            <td><strong>Price</strong></td>
            <td><input type="text" name='price' required="" decimalSeparator='.' groupSeparator=',' class="easyui-numberbox" style="width: 60%"/></td>
        </tr>

        <tr>
            <td><strong>Discount</strong></td>
            <td><input type="text" name='discount' class="easyui-numberbox" style="width: 30px"/>%</td>
        </tr>


    </table>        
</form>