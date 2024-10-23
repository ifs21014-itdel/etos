<table id="products_top_ten_sales" data-options="
       url:'<?php echo site_url('products/get_top_ten_sales') ?>',
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
            <th field="code" width="15%" halign="center" rowspan="2">Code</th>
            <th field="name" width="25%" halign="center" rowspan="2">Name</th>
            <th width="30%" halign="center" colspan="3">Dimension</th>
            <th field="volume" width="15%" halign="center" rowspan="2" align="right">Volume<br/>(m3)</th>
            <th field="total" width="15%" align="center" rowspan="2">Total</th>
        </tr>
        <tr>
            <th field="width" width="10%" align="center">Width</th>
            <th field="depth" width="10%" align="center">Depth</th>
            <th field="height" width="10%" align="center">Height</th>
        </tr>
    </thead>
</table>

<script>
    $(function () {
        $('#products_top_ten_sales').datagrid({});
    });
</script>