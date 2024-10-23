<div id="product_type_toolbar" style="padding-bottom: 2px;">   
    <form id="product_type_search_form" onsubmit="return false">
        Search : 
        <input type="text" 
               size="20" 
               name="code"
               class="easyui-validatebox"
               onkeypress="if (event.keyCode === 13) {
                           product_type_search();
                       }"
               /> 
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="product_type_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="product_type_add()"> Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="product_type_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="product_type_delete()"> Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="product_type" data-options="
       url:'<?php echo site_url('product_type/get') ?>',
       method:'post',
       border:true,
       title:'Product Type',
       singleSelect:true,
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#product_type_toolbar'">
    <thead>
        <tr>
            <th field="code" width="10%" halign="center" sortable="true">Code</th>            
            <th field="description" width="90%" halign="center" sortable="true">Description</th>
        </tr>
    </thead>
</table>
<script product_type="text/javascript">
    $(function () {
        $('#product_type').datagrid({
            onDblClickRow: function (rowIndex, row) {
                product_type_edit();
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/product_type.js"></script>

