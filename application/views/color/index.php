<div id="color_toolbar" style="padding-bottom: 2px;">   
    <form id="color_search_form" onsubmit="return false;">
        Code/Name: 
        <input type="text" 
               size="20" 
               class="easyui-validatebox" 
               name="q"
               onkeypress="if (event.keyCode === 13) {
                       color_search();
                   }" />
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="color_search()">Search</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="color_add()">Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="color_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="color_delete()"> Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="color" data-options="
       url:'<?php echo site_url('color/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       title:'Color',
       fit:true,
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#color_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="code" width="20%" halign="center" sortable="true">Code</th>            
            <th field="name" width="80%" halign="center" sortable="true">Name</th>
        </tr>
    </thead>
</table>
<script color="text/javascript">
    $(function () {
        $('#color').datagrid({
            onDblClickRow: function (rowIndex, row) {
                color_edit();
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/color.js"></script>