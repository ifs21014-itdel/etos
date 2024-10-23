<div id="protocol_test_variabel_test_toolbar" style="padding-bottom: 2px;">
    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="protocol_test_variabel_test_add()"> Add</a>
        <?php
    }
    if (in_array("Edit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="protocol_test_variabel_test_edit()"> Edit</a>
        <?php
    }
    if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="protocol_test_variabel_test_delete()">Delete</a>
        <?php
    }
    ?>
</div>
<table id="protocol_test_variabel_test" data-options="
       url:'<?php echo site_url('protocol_test/variabel_test_get') ?>',
       method:'post',
       border:true,
       title:'Variabel Test',
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       nowrap:false,
       toolbar:'#protocol_test_variabel_test_toolbar'">
    <thead>
        <tr>
            <th field="evaluation" halign="center" width="400" sortable="true">Evaluation</th>
            <th field="method" width="400" halign="center" sortable="true">Method</th>
            <th field="description" halign="center" sortable="true">Description</th>
            <th field="var_type" width="100" halign="center" sortable="true">Data Type</th>
            <th field="mandatory" width="100" halign="center" sortable="true">Mandatory</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#protocol_test_variabel_test').datagrid({
            onDblClickRow: function (rowIndex, row) {
                protocol_test_variabel_test_edit();
            }
        });
    });
</script>
