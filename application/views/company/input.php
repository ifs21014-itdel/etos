<form id="company_input_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="25%"><strong>Code</strong></td>
            <td width="75%"><input type="text" name='code' class="easyui-validatebox" required="true" style="width: 98%"/></td>
        </tr>
        <tr>
            <td><strong>Name</strong></td>
            <td><input type="text" name='name' class="easyui-validatebox" style="width: 98%"/></td>
        </tr>
        <tr>
            <td><strong>Address</strong></td>
            <td>
                <textarea name="address" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
            </td>
        </tr>
        <tr>
            <td><strong>Telp</strong></td>
            <td><input type="text" name='telp' class="easyui-validatebox" style="width: 98%"/></td>
        </tr>
        <tr>
            <td><strong>Fax</strong></td>
            <td><input type="text" name='fax' class="easyui-validatebox" style="width: 98%"/></td>
        </tr>
        <tr>
            <td align="lef"><label for="tax_type">Tax Type</label></td>
            <td>
                <select class="easyui-combo" name='type'>
                    <option value="Non Ppn">Non Ppn</option>
                    <option value="Ppn">Ppn</option>
                </select>
            </td>
        </tr>
    </table>        
</form>