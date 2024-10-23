<table id="purchaseorder_ots_release" data-options="
       url:'<?php echo site_url('purchaseorder/get_outstanding_release') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       idField:'id'">
    <thead>
        <tr>
            <th field="po_no" width="33%" halign="center">P.O Number</th>
            <th field="date" width="30%" align="center" formatter="myFormatDate">P.O Date</th>
            <th field="vendor_name" width="37%" halign="center">Vendor</th>
        </tr>
    </thead>
</table>

<script>
    $(function () {
        $('#purchaseorder_ots_release').datagrid({});
    });
</script>