<div id="cust_cp-form" class="easyui-dialog" 
     data-options="iconCls:'icon-save',resizable:true,modal:true"
     style="width:460px; padding: 5px 5px" closed="true" buttons="#cust_cp-button">
  <form id="cust_cp-input" method="post" novalidate enctype="multipart/form-data">
    <table width="100%" border="0">
      <tr>
        <td align="right"><label for="name">Name</label></td>
        <td>
          <input type="hidden" id="flag_status" value=""/>
          <input type="text" name="name"  class="easyui-validatebox" size="15" value=""/>
        </td>
      </tr>
      <tr>
        <td align="right"><label for="work_number">Work Number</label></td>
        <td><input class="easyui-validatebox" type="text" name="work_number"></td>
      </tr>
      <tr>
        <td align="right"><label for="ext">Ext</label></td>
        <td><input class="easyui-validatebox" type="text" name="ext"></td>
      </tr>
      <tr>
        <td align="right"><label for="mobile">Mobile</label></td>
        <td><input class="easyui-validatebox" type="text" name="mobile"></td>
      </tr>
      <tr>
        <td align="right"><label for="email">Email</label></td>
        <td><input class="easyui-validatebox" type="text" name="email" data-options="validType:'email'"></td>
      </tr>
      <tr>
        <td align="right"><label for="notes">Notes :</label></td>
        <td>
          <textarea name="notes" id="notes" class="easyui-validatebox"  style="width: 90%;height: 25px"></textarea>
        </td>
      </tr>
    </table>        
  </form>
</div>
<div id="cust_cp-button">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="cust_cp_save()">Save</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#cust_cp-form').dialog('close')">Cancel</a>
</div>
