<div id="toolbar_list_customer" style="padding-bottom: 1px;">     
  <div>
    Code :
    <input type="text" id="code_t" class="easyui-validatebox" size="10" onkeyup="if (event.keyCode === 13) {
          customer_cari()
        }"/>
    Name :
    <input type="text" id="c_name_t" class="easyui-validatebox" size="10" onkeyup="if (event.keyCode === 13) {
          customer_cari()
        }"/>
    Country :
    <input name="country_cust_1" id="country_cust_1" style="width: 150px"/>
    <script type="text/javascript">
      $('#country_cust_1').combogrid({
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
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="customer_cari()"> Search</a>    
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="customer_tambah()"> Add</a>     
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="customer_ubah()"> Edit</a>     
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="customer_hapus()"> Delete</a>   
  </div>
</div>
<table id="list_customer" data-options="
       url:'<?php echo site_url('customer/get') ?>',
       method:'post',
       border:true,       
       singleSelect:true,
       fit:true,
       pageSize:30,
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pageList: [30, 50, 70, 90, 110],
       pagination:true,
       toolbar:'#toolbar_list_customer'">
  <thead>
    <tr>
      <th field="id" hidden="true"></th>
      <th field="chk" checkbox="true"></th>            
      <th field="cust_code" align="center" sortable="true">CustCode</th>
      <th field="cust_name" halign="center" sortable="true">Cust Name</th>
      <th field="address" halign="center" sortable="true">Adress</th>
      <th field="common_name" halign="center" sortable="true">Country</th>
      <th field="contact_person" halign="center" sortable="true">Contact Person</th>
      <th field="email" halign="center" sortable="true">Email</th>
      <th field="phone" align="center" sortable="true">Phone 1</th> 
      <th field="phone_2" align="center" sortable="true">Phone2</th>
  <!--    <th field="date_input" width="90" align="center">Date Input</th> -->

    </tr>
  </thead>
</table>
<script type="text/javascript">
  var customer_id = 0
  $(function() {
    var currentdate = new Date().toISOString().substr(0, 10);
    //var cdate=currentdate.getTime()/86400000;
    var datediff = 0;
    var miliday = 24 * 60 * 60 * 1000;
    $('#list_customer').datagrid({
      onSelect: function(value, row, index) {
        row.address = row.address.replace(/\n/g, "<br />");
        $('#custdetil').empty();
        $('#custdetil').append('Cust Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ' + row.cust_name + '<br>Cust Code  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ' + row.cust_code + '<br>Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ' + row.address + '<br> Country &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ' + row.country + '<br> Phone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ' + row.phone + '<br> Phone2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ' + row.phone_2);
        $('#tender_hist').datagrid('load', {
          customer_id: row.id
        });
        $('#cust_visit_hist').datagrid('load', {
          customer_id: row.id
        });
        $('#cust_cp').datagrid('load', {
          customer_id: row.id
        });
        $('#cust_files').datagrid('load', {
          customer_id: row.id
        });
      },
      onDblClickRow: function(rowIndex, row) {
        customer_ubah();
      }
    }, 'fixColumnSize', 'reloadFooter').datagrid('getPager').pagination({
      buttons: [
        {
          id: 'cetak_customer',
          handler: function() {
//                        customer_cetak();
          }
        }
      ],
      beforePageText: 'Page',
      afterPageText: 'of {pages}',
      displayMsg: 'Displaying {from} to {to} of {total} items'
    });
  });
  $('#cetak_customer').menubutton({
    text: 'Print',
    iconCls: 'icon-print',
    menu: '#mm1'
  });</script>
<div id="mm1" style="width:100px;">
  <div data-options="iconCls:'icon-print'" onclick="customer_cetak(1)">Summary</div>
  <div data-options="iconCls:'icon-print'" onclick="customer_cetak(0)">Detail</div>
</div>
<?php
$this->load->view('customer/buat_baru');
