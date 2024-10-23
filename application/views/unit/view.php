<div id="unit_toolbar" style="padding-bottom: 2px;">   
  Code : <input type="text" size="20" class="easyui-validatebox" id="unit_code_t" onkeypress="if (event.keyCode === 13) {
        unit_cari();

      }"/>  
  Description : <input type="text" size="20" class="easyui-validatebox" id="desc_unit_t" onkeypress="if (event.keyCode === 13) {
        unit_cari();
      }"/>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="unit_cari()"> Search</a>
  <?php
  /// if ($this->session->userdata('group') == '1') {
  ?>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="unit_tambah()"> Add</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="unit_ubah()"> Edit</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="unit_hapus()"> Delete</a>
  <?php
  // }
  ?>

</div>
<table id="unit" data-options="
       url:'<?php echo site_url('unit/get') ?>',
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
       toolbar:'#unit_toolbar'">
  <thead>
    <tr>
      <th field="id" hidden="true"></th>
      <th field="code" width="200" halign="center" sortable="true">Code</th>            
      <th field="description" width="200" halign="center" sortable="true">Description</th>
    </tr>
  </thead>
</table>
<script unit="text/javascript">
  $(function() {
    $('#unit').datagrid({
      onDblClickRow: function(rowIndex, row) {
        unit_ubah();
      }
    }, 'fixColumnSize', 'reloadFooter', [
      {name: 'unit'},
      {name: 'description'}]).datagrid('getPager').pagination({
      beforePageText: 'Page',
      afterPageText: 'From {pages}',
      displayMsg: 'Displaying {from} to {to} of {total} items'
    });
  });
</script>
<?php
$this->load->view('unit/add');

