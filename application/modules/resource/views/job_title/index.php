<div id="job_title_toolbar" style="padding-bottom: 2px;">
    <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="job_title.enableFilter()"><span class="glyphicon glyphicon-filter"></span> Filter</a>
    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="job_title_add()">Add</a>
        <?php
    }if (in_array("Edit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="job_title_edit()"> Edit</a>
        <?php
    }if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="job_title_delete()"> Delete</a>
        <?php
    }
    ?>
</div>
<table id="job_title"
       method="post"
       title="Job Title"
       fit="true"
       singleSelect="true"
       pageSize="30"
       pageList="[30, 50, 70, 90, 110]"
       rownumbers="true"
       fitColumns="true"
       url="<?php echo site_url("resource/job_title/get") ?>"
       pagination="true"
       toolbar="#job_title_toolbar"
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
        $('#job_title').datagrid({
            onDblClickRow: function (rowIndex, row) {
                job_title_edit();
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url('js/resource/job_title.js') ?>"></script>