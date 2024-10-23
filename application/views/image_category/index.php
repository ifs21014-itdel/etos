<div id="image_category_toolbar" style="padding-bottom: 2px;">   
    <form id="image_category_search_form" onsubmit="return false" style="margin: 0">
        Search : 
        <input type="text" size="20" class="easyui-validatebox" name="q" onkeypress="if (event.keyCode === 13) {
                    image_category_search();

                }"/>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="image_category_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="image_category_add()"> Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="image_category_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="image_category_delete()"> Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="image_category" data-options="
       url:'<?php echo site_url('image_category/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       title:'Image Category',
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#image_category_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="view_position" width="200" halign="center" sortable="true">Position</th>            
            <th field="description" halign="center" sortable="true">Description</th>        
            <th field="mandatory" width="100" halign="center" sortable="true">Mandatory</th>
        </tr>
    </thead>
</table>
<script image_category="text/javascript">
    $(function () {
        $('#image_category').datagrid({
            rowStyler: function(index, row) {
                if (row.mandatory === 'f') {
                    return 'background-color:#ffff00;';
                }
            },
            onSelect: function(index, row) {
                //---
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/image_category.js"></script>

