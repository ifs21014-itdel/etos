<?php
//if ($this->session->userdata('group') == '1') {
?>
<div id="cust_cp_toolbar" style="padding-bottom: 2px;">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="cust_cp_add()"> Add</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="cust_cp_edit()"> Edit</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="cust_cp_delete()">Delete</a>
</div>
<?php
//}
?>
<table id="cust_cp" data-options="
       url:'<?php echo site_url('customer/get_cp_bycust') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       pageSize:30,
       rownumbers:true,
       pageList: [30, 50, 70, 90, 110],
       fitColumns:false,
       pagination:true,
       striped:true,
       toolbar:'#cust_cp_toolbar'">
  <thead>
    <tr>
      <th field="id" hidden="true"></th>
      <th field="customer_id" halign="center" hidden="true">Customer Id</th>
      <th field="name" halign="center">Name</th>
      <th field="work_number" halign="center">Work Number</th>
      <th field="ext" halign="center">Ext</th>
      <th field="mobile" halign="center">Mobile</th>
      <th field="email" halign="center">Email</th>
      <th field="notes" halign="center">Notes</th>
    </tr>
  </thead>
</table>
<script type="text/javascript">
  $(function() {
    $('#cust_cp').datagrid({
      onDblClickRow: function(rowIndex, row) {
        cust_cp_edit();
      }
    }, 'fixColumnSize', 'reloadFooter').datagrid('getPager').pagination({
      beforePageText: 'Page',
      afterPageText: 'From {pages}',
      displayMsg: 'Displaying {from} to {to} of {total} items'
    });
  });
</script>
<?php
$this->load->view('customer/cp/add');
?>
