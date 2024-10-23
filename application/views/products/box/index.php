<div id="products_box_toolbar" style="padding-bottom: 2px;">
    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="products_box_add()"> Add</a>
        <?php
    }
    if (in_array("Edit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="products_box_edit()"> Edit</a>
        <?php
    }
    if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="products_box_delete()">Delete</a>
        <?php
    }
    ?>
</div>
<table id="products_box" data-options="
       url:'<?php echo site_url('products/box_get') ?>',
       method:'post',
       border:true,
       title:'Box',
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       toolbar:'#products_box_toolbar'">
    <thead>
        <tr>
            <th field="box_no" halign="center" width="100">Packing Num</th>
            <th field="code" halign="center" width="100">Code</th>
            <th field="description" halign="center" width="100">Description</th>
            <th field="width" halign="center" width="100">Width</th>
            <th field="depth" halign="center" width="100">Depth</th>
            <th field="height" halign="center" width="100">Height</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#products_box').datagrid({
            onDblClickRow: function (rowIndex, row) {
                products_box_edit();
            }
        });
    });
</script>
