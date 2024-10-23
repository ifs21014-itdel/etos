<div id="customer-form" class="easyui-dialog" 
     data-options="iconCls:'icon-save',resizable:true,modal:true"
     style="width:600px; padding: 5px 5px" closed="true" buttons="#customer-button">
  <form id="customer-input" method="post" novalidate>
    <table width="100%" border="0">
      <tr>
        <td><label for="cust_name">Customer Code</label></td>
        <td>:</td>
        <td><input type="text" autocomplete="off" name="cust_code" class="easyui-validatebox" required="true" size="20" /></td>
      </tr>
      <tr>
        <td><label for="cust_name">Customer Name</label></td>
        <td>:</td>
        <td><input type="text" autocomplete="off" name="cust_name" class="easyui-validatebox" required="true" size="30" /></td>
      </tr>
      <tr valign="top">
        <td align="lef"><label for="address">Address :</label></td>
        <td>:</td>
        <td>
          <textarea name="address" class="easyui-validatebox" style="width: 270px;height: 30px"></textarea>
        </td>
      </tr>
      <tr>
        <td><label for="country_id">Country</span></td>
        <td>:</td>
        <td>
          <input type="text" name="country_id" id="country_id" mode="remote" style="width: 150px" required="true"/>
          <script type="text/javascript">
            $('#country_id').combogrid({
              panelWidth: 300,
              mode: 'remote',
              idField: 'id',
              textField: 'common_name',
              url: '<?php echo site_url('country/get') ?>',
              columns: [[
                  {field: 'common_name', title: 'Common Name', width: 80, halign: 'center'},
                  {field: 'formal_name', title: 'Formal Name', width: 80, halign: 'center'},
                  {field: 'capital', title: 'Capital', width: 80, halign: 'center'},
                ]]
            });
          </script>
        </td>
      </tr>
      <tr valign="top">
        <td align="lef"><label for="address">Contact Person :</label></td>
        <td>:</td>
        <td><input type="text" autocomplete="off" name="contact_person" class="easyui-validatebox" size="30" /></td>
      </tr>
      <tr valign="top">
        <td align="lef"><label for="address">Email :</label></td>
        <td>:</td>
        <td><input type="text" autocomplete="off" name="email" class="easyui-validatebox" size="30" /></td>
      </tr>
      <tr valign="top">
        <td align="lef"><label for="address">Phone :</label></td>
        <td>:</td>
        <td><input type="text" autocomplete="off" name="phone" class="easyui-validatebox" size="30" /></td>
      </tr>
      <tr valign="top">
        <td align="lef"><label for="address">Phone 2 :</label></td>
        <td>:</td>
        <td><input type="text" autocomplete="off" name="phone_2" class="easyui-validatebox" size="30" /></td>
      </tr>
    </table>
  </form>
</div>
<div id="customer-button">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="customer_simpan()">Simpan</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#customer-form').dialog('close')">Batal</a>
</div>
