<div id="cust_files-form" class="easyui-dialog" 
     data-options="iconCls:'icon-save',resizable:true,modal:true"
     style="width:460px; padding: 5px 5px" closed="true" buttons="#cust_files-button">
  <form id="cust_files-input" method="post" novalidate enctype="multipart/form-data">
    <table width="100%" border="0">
      <tr>
        <td align="right"><label for="name">Doc Number</label></td>
        <td>
          <input type="hidden" id="flag_status" value=""/>
          <input type="text" name="doc_number"  class="easyui-validatebox" size="15" value=""/>
        </td>
      </tr>
      <tr>
        <td align="right"><label for="name">Revisi</label></td>
        <td><input type="text" name="revision"  class="easyui-numberbox" size="15" value=""/></td>
      </tr>
      <tr>
        <td align="right"><label for="notes">Notes :</label></td>
        <td>
          <textarea name="notes" id="notes" class="easyui-validatebox"  style="width: 90%;height: 25px"></textarea>
        </td>
      </tr>
      <tr>
        <td align="right">Attach :</td>
        <td>
          <input type='file' name='attach1' id='attach1' />
        </td>
      </tr>
    </table>        
  </form>
</div>
<div id="cust_files-button">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="cust_files_save()">Save</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#cust_files-form').dialog('close')">Cancel</a>
</div>
