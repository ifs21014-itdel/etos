<div id="unit-form" class="easyui-dialog" 
     data-options="iconCls:'icon-save',resizable:true,modal:true"
     style="width:300px; padding: 5px 5px" closed="true" buttons="#dialog-button">
  <form id="unit-input" method="post" novalidate>
    <table width="100%" border="0">
      <tr valign="top">
        <td align="right"><label for="deskripsi">Code/Name :</label></td>
        <td><input type="text" name='code' class="easyui-validatebox" required="true"/></td>
      </tr>
      <tr valign="top">
        <td align="right"><label for="description">Description :</label></td>
        <td><input type="text" name='description' class="easyui-validatebox"/></td>
      </tr>
    </table>        
  </form>
</div>
<div id="dialog-button">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="unit_simpan()">Save</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#unit-form').dialog('close')">Cancel</a>
</div>