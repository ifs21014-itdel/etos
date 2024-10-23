<table id="critical_product_progress" data-options="
       url:'<?php echo site_url('purchaseorder/get_critical_product_progress') ?>',
       method:'post',
       border:false,       
       singleSelect:true,
       fit:true,
       autoRowHeight:false,
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       pagination:true,
       pageSize:10,
       pageList: [10],
       idField:'id',
       striped:true,
       nowrap:false">
    <thead>
        <tr>
            <th field="products_code" width="20%" halign="center" data-options="formatter:function(val,row){return '<b>' + val + '</b> # '+row.products_name}">Product</th>
            <th field="qty" width="5%" align="center">Qty</th>
            <th field="po_no" width="15%" halign="center">P.O</th>
            <th field="vendor" width="20%" halign="center">Vendor</th>
            <th field="target_ship_date" width="15%" align="center">Target Shipment</th>
            <th field="date_diff" width="10%" align="center">Diff</th>
            <th field="progress" width="15%" halign="center" data-options="formatter:function(val,row){return val + '%'}">Progress</th>
        </tr>
    </thead>
</table>

<script>
    $(function () {
        $('#critical_product_progress').datagrid({});
    });
</script>