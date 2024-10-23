<table id="cust_visit_hist" data-options="
       url:'<?php echo site_url('cust_visit/get_bycust') ?>',
       method:'post',
       border:true,       
       singleSelect:true,
       fit:true,
       pageSize:30,
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true">
  <thead>
    <tr>
      <th field="id" hidden="true"></th>           
      <th field="visit_date" width="70" align="center" sortable="true">Date</th>
      <th field="visit_time" width="30" halign="center" sortable="true">Time</th>
      <th field="place" width="100" halign="center" sortable="true">Place</th>
      <th field="cust_name" width="150" halign="center" sortable="true">Customer</th>
      <th field="pros_value" width="150" halign="center" sortable="true">Pros. value</th>
      <th field="price_unit" width="50" halign="center" sortable="true">Currency</th>
      <th field="description" width="200" align="center" sortable="true">Description</th> 
      <th field="pic" width="200" align="center" sortable="true">PIC</th> 
      <th field="date_input" width="70" align="center" sortable="true">Entry Date</th>
  <!--    <th field="date_input" width="90" align="center">Date Input</th> -->

    </tr>
  </thead>
</table>
<script type="text/javascript">
  $(function() {
    var currentdate = new Date().toISOString().substr(0, 10);
    $('#cust_visit_hist').datagrid({
      view: detailview,
      detailFormatter: function(rowIndex, rowData) {
        return '<div class="ddv_cvh" style="padding:10px"></div>';
      },
      onExpandRow: function(index, row) {
        $('#cust_visit_hist').datagrid('selectRow', index);
        ddv_cvh = $(this).datagrid('getRowDetail', index).find('div.ddv_cvh');
        ddv_cvh.datagrid({
          id: 'sub-datagrid' + row.id,
          url: '<?php echo site_url('cust_visit_action/get_history') ?>',
          queryParams: {
            cust_visit_id: row.id
          },
          fitColumns: true,
          singleSelect: true,
          rownumbers: true,
          loadMsg: 'Customer Visit Followup',
          width: 700,
          columns: [[
              {field: 'action_date', title: 'Date', width: 100, editor: 'date'},
              {field: 'action_time', title: 'Time', width: 50, halign: 'center', editor: 'text'},
              {field: 'place', title: 'Place', width: 150, halign: 'center', editor: 'text'},
              {field: 'subject', title: 'Subject.', width: 250, align: 'center', editor: 'numberbox'},
              {field: 'description', title: 'Desc', width: 350, align: 'center', editor: 'text'},
              {field: 'status', title: 'Status', width: 150, align: 'center', editor: 'text'}
            ]],
          onResize: function() {
            $('#cust_visit_hist').datagrid('fixDetailRowHeight', index);
          },
          onLoadSuccess: function() {
            setTimeout(function() {
              $('#cust_visit_hist').datagrid('fixDetailRowHeight', index);
            }, 0);
          }
        });
        $('#cust_visit_hist').datagrid('fixDetailRowHeight', index);
      },
      onSelect: function(value, row, index) {
       $('#cust_visit_action_detail').empty();
        $('#cust_visit_action_detail').append('<table border=1 width=100%><tr><td>Date </td><td width=85%>' + row.action_date + ','+row.action_time+'</td></tr><tr><td>Place</td><td>' + row.place+'</td></tr><tr><td>Subject</td><td>' + row.subject +'</td></tr><tr><td>Description</td><td>' + row.description + '</td></tr><tr><td>status</td><td>' + row.status + '</td></tr><tr><td>Date Input</td><td>' + row.date_input + '</td></tr><tr><td>User_Input</td><td>' + row.user_input+'</td></tr></table>');
        $('#cust_visit_action_document').datagrid('load', {
          cust_visit_action_id: row.id
        });
        $('#cust_visit_action_questionnaire').datagrid('load', {
          cust_visit_action_id: row.id
        });
      }
      
    }).datagrid('getPager').pagination({
      pageList: [30, 50, 70, 90, 110]
    });
  });
</script>
