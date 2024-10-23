<table id="tender_hist" data-options="
       url:'<?php echo site_url('tender/get_bycust') ?>',
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
      <th field="chk" checkbox="true"></th>                      
      <th field="tender_number" width="70" align="center" sortable="true">Tender Number</th>
      <th field="title" width="60" halign="center" sortable="true">Title</th>
      <th field="description" width="150" halign="center" sortable="true">Description</th>
      <th field="prebid_date" width="150" halign="center" sortable="true">Prebid Date</th>
      <th field="prebid_time" width="150" halign="center" sortable="true">Prebid Time</th>
      <th field="closing_date" width="80" halign="center" sortable="true">Closing Date</th>
      <th field="closing_time" width="60" align="center" sortable="true">Closing Time</th> 
      <th field="status" width="90" align="center" sortable="true">Status</th>
      <th field="status_desc" width="90" align="center" sortable="true">Status Desc</th>
      <th field="closing_status" width="90" align="center" sortable="true">Status Closing</th>
  <!--    <th field="date_input" width="90" align="center">Date Input</th> -->

    </tr>
  </thead>
</table>
<script type="text/javascript">
  $(function() {
    var currentdate = new Date().toISOString().substr(0, 10);
    $('#tender_hist').datagrid({
      rowStyler: function(index, row) {
        //alert(row.closing_date)
        //  alert (new Date(row.closing_date)-currentdate);
        if (row.closing_date == currentdate || row.prebid_date == currentdate) {
          return 'background-color:#ffba60;color:#fff;'; // return inline style
        }
        else if (row.closing_date < currentdate ) {
          return 'background-color:#ff9292;color:#fff;'; // return inline style
        }
        //alert (datediff);
      }
    },'fixColumnSize','reloadFooter').datagrid('getPager').pagination({
      pageList: [30, 50, 70, 90, 110]
    });
  });
</script>
