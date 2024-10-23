<div id="warehouse_toolbar" style="padding-bottom: 2px;">   
  Code : <input type="text" size="20" class="easyui-validatebox" id="warehouse_code_t" onkeypress="if (event.keyCode === 13) {
        warehouse_cari();

      }"/>  
  Description : <input type="text" size="20" class="easyui-validatebox" id="desc_warehouse_t" onkeypress="if (event.keyCode === 13) {
        warehouse_cari();
      }"/>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="warehouse_cari()"> Search</a>
  <?php
  /// if ($this->session->userdata('group') == '1') {
  ?>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="warehouse_tambah()"> Add</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="warehouse_ubah()"> Edit</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="warehouse_hapus()"> Delete</a>
  <?php
  // }
  ?>

</div>
<table id="warehouse" data-options="
       url:'<?php echo site_url('warehouse/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#warehouse_toolbar'">
  <thead>
    <tr>
      <th field="id" hidden="true"></th>
      <th field="code" width="200" halign="center" sortable="true">Code</th>            
      <th field="name" width="200" halign="center" sortable="true">Warehouse</th>            
      <th field="description" width="200" halign="center" sortable="true">Description</th>
    </tr>
  </thead>
</table>
<script warehouse="text/javascript">
  $(function() {
    $('#warehouse').datagrid({
      onDblClickRow: function(rowIndex, row) {
        warehouse_ubah();
      }
    }, 'fixColumnSize', 'reloadFooter', [
      {name: 'warehouse'},
      {name: 'description'}]).datagrid('getPager').pagination({
      beforePageText: 'Page',
      afterPageText: 'From {pages}',
      displayMsg: 'Displaying {from} to {to} of {total} items'
    });
  });
</script>
<?php
$this->load->view('warehouse/add');

