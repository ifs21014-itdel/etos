<div id="department_toolbar" style="padding-bottom: 2px;">
    <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="department.enableFilter()"><span class="glyphicon glyphicon-filter"></span> Filter</a>
    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="department_add()">Add</a>
        <?php
    }if (in_array("Edit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="department_edit()"> Edit</a>
        <?php
    }if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="department_delete()"> Delete</a>
        <?php
    }
    ?>
</div>
<table id="department"
       method="post"
       title="Department"
       fit="true"
       singleSelect="true"
       pageSize="30"
       pageList="[30, 50, 70, 90, 110]"
       rownumbers="true"
       fitColumns="true"
       url="<?php echo site_url("resource/department/get") ?>"
       pagination="true"
       toolbar="#department_toolbar"
       striped="true"
       multiSort="true">
    <thead>
        <tr>
            <th field="code" width="150" halign="center" sortable="true">Code</th>
            <th field="name" width="150" halign="center" sortable="true">Name</th>
            <th field="remark" width="400" halign="center" sortable="true">Remark</th>
        </tr>
    </thead>
</table>
<script color="text/javascript">
    $(function () {
        $('#department').datagrid({
            onDblClickRow: function (rowIndex, row) {
                department_edit();
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url('js/resource/department.js') ?>"></script>