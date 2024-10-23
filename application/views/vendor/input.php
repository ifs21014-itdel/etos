<form id="vendor_input_form" method="post" novalidate>
    <table width="99%" border="0" class="table_form" cellspacing="0" cellpadding="0">
        <tr>
            <td><strong>Type</strong></td>
            <td>
                <select name="flag" class="easyui-combobox" style="width: 200px" panelHeight="auto">
                    <option value="0">External</option>
                    <option value="1">Internal</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="25%"><strong>Code</strong></td>
            <td><input type="text" name="code" class="easyui-validatebox" required="true" data-options="validType:'maxLength[3]'"/></td>
        </tr>
        <tr>
            <td><strong>Name</strong></td>
            <td><input type="text" name="name" class="easyui-validatebox" style="width: 98%" required value=""/></td>
        </tr>
        <tr>
            <td><strong>Currency</strong></td>
            <td>
                <input class="easyui-combobox"  name="currency_id"  data-options="
                       url: '<?php echo site_url('currency/get') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'code',
                       panelHeight: 'auto'"
                       style="width: 100px" 
                       required="true">                    
            </td>
        </tr>
        <tr>
            <td><strong>Address</strong></td>
            <td><textarea name="address" class="easyui-validatebox" style="width: 98%;height: 50px;" required ></textarea></td>
        </tr>
        <tr>
            <td><strong>Country</strong></td>
            <td>
                <input class="easyui-combobox" 
                       name="country_id" 
                       id="vendor_country_id" 
                       required="true" 
                       data-options="
                       url:'<?php echo site_url('country/get') ?>',
                       mode: 'remote',
                       valueField: 'id',
                       textField: 'common_name',
                       formatter: vendor_country_format"
                       style="width: 99%;">
                <script type="text/javascript">
                    function vendor_country_format(row) {
                        var s = '<span style=font-weight:bold;>' + row.common_name + '</span><br/>' +
                                '<span>(' + row.formal_name + ')</span><br/>' +
                                '<span style="color:#888">Capital: ' + row.capital + '</span>';
                        return s;
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td><strong>Stage</strong></td>
            <td><input name="state" class="easyui-textbox" style="width: 69%;"></td>
        </tr>
        <tr>
            <td><strong>City</strong></td>
            <td><input name="city" class="easyui-textbox" style="width: 50%;"></td>
        </tr>
        <tr>
            <td><strong>E-mail</strong></td>
            <td><input class="easyui-validatebox textbox" name="email" data-options="validType:'email'" style="width: 69%;"></td>
        </tr>
        <tr>
            <td><strong>Phone</strong></td>
            <td><input name="phone" class="easyui-textbox" style="width: 50%;"></td>
        </tr>
        <tr>
            <td><strong>Fax</strong></td>
            <td><input name="fax" class="easyui-textbox" style="width: 50%;"></td>
        </tr>
    </table>
</form>