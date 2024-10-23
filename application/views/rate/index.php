<div id="rate_toolbar" style="padding-bottom: 2px;">
    ID : <input type="text" size="20" class="easyui-validatebox" id="rate_code_t" onkeypress="if (event.keyCode === 13) {
                rate_search();
            }"/>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="rate_search()"> Search</a>
    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="rate_add()">Add</a>
        <?php
    }if (in_array("Edit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="rate_edit()">Edit</a>
        <?php
    }if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="rate_delete()"> Delete</a>
        <?php
    }
    ?>
</div>
<table id="rate" data-options="
       url:'<?php echo site_url('rate/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       title:'Rate',
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       pagination:true,
       toolbar:'#rate_toolbar'">
    <thead>
        <tr>
            <th field="evidence_number" width="100" align="center" sortable="true">ID</th>
            <th field="date" width="100" align="center" sortable="true" formatter="myFormatDate">Effective Date</th>
            <th field="currency_code" width="80" align="center" sortable="true">Currency</th>
            <th field="exchange_rate" width="100" halign="center" align="right" sortable="true" formatter="formatPrice">Exchange Rate</th>
            <!--<th field="input_by" width="120" halign="center" sortable="true">Input By</th>-->
        </tr>
    </thead>
</table>
<script rate="text/javascript">
    $(function () {
        $('#rate').datagrid({
            onDblClickRow: function (rowIndex, row) {
                rate_uedit();
            }
        });
    });
</script>
<script src="<?php echo base_url() ?>js/rate.js"></script>
