<?php
//if ($this->session->userdata('group') == '1') {
?>
<div id="cust_files_toolbar" style="padding-bottom: 2px;">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="cust_files_add()"> Add</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="cust_files_edit()"> Edit</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="cust_files_delete()">Delete</a>
</div>
<?php
//}
?>
<table id="cust_files" data-options="
       url:'<?php echo site_url('customer/get_doc_bycust') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       pageList: [30, 50, 70, 90, 110],
       pageSize:30,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       toolbar:'#cust_files_toolbar'">
  <thead>
    <tr>
      <th field="id" hidden="true"></th>
      <th field ="detail" formatter="format_cust_files"></th>
      <th field="customer_id" halign="center" hidden="true">Customer Id</th>
      <th field="doc_number" halign="center">Doc Number</th>
      <th field="file_name" halign="center" hidden="true">File Name</th>
      <th field="revision" halign="center">Rev</th>
      <th field="notes" halign="center">Description</th>
      <th field="date_input" halign="center">Input Date</th>
      <th field="user_input" halign="center">Input By</th>
    </tr>
  </thead>
</table>
<script type="text/javascript">
  $(function() {
    var currentdate = new Date().toISOString().substr(0, 10);
    $('#cust_files').datagrid({
      rowStyler: function(index, row) {
        //alert(row.closing_date)
        //  alert (new Date(row.closing_date)-currentdate);
        if (row.due_date == currentdate || row.expiry_date == currentdate) {
          return 'background-color:#ffba60;color:#fff;'; // return inline style
        }
        //alert (datediff);
      },
      onDblClickRow: function(rowIndex, row) {
        cust_files_edit();
      }
    }, 'fixColumnSize', 'reloadFooter').datagrid('getPager').pagination({
      pageList: [30, 50, 70, 90, 110]
    });
  });
  function format_cust_files(value, row) {
    var href = 'files/cust_files/' + row.file_name;
    return "<a target='_blank' href='" + href + "'><img src='easyui/themes/icons/download.png'></a>";
  }
</script>
<?php
$this->load->view('customer/document/add');
?>
