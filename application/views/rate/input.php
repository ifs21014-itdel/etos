<form id="rate_input_form" onsubmit="return false;" class="table_form" method="POST">
    <table width="100%">
        <tr valign="top">
            <td width="25%"><strong>Date</strong></td>
            <td width="75%">
                <input type="text" name="date" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" required="true" style="width: 120px"/>
            </td>
        </tr>
        <tr>
            <td><strong>Currency</strong></td>
            <td>
                <input class="easyui-combobox" id='rate_currency_i'  name="currency_id"  data-options="
                       url: '<?php echo site_url('currency/get') ?>',
                       method: 'post',
                       valueField: 'id',
                       textField: 'code',
                       panelHeight: 'auto'"
                       style="width: 120px" 
                       required="true">  
            </td>
        </tr>
        <tr>
            <td><strong>Exchange Rate</strong></td>
            <td><input type="text" name="exchange_rate" style="width: 100%;text-align: right" required="true" class="easyui-numberbox" precision='2' decimalSeparator='.' groupSeparator=","/></td>
        </tr>
    </table>
</form>