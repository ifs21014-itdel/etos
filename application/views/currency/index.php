<div id="currency_toolbar" style="padding-bottom: 2px;">   
    <form id="currency_search_form" onsubmit="return false" style="margin: 0">
        Search : 
        <input type="text" size="20" class="easyui-validatebox" name="q" onkeypress="if (event.keyCode === 13) {
                    currency_search();

                }"/>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="currency_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="currency_add()"> Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="currency_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="currency_delete()"> Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="currency" data-options="
       url:'<?php echo site_url('currency/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       title:'Currency',
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#currency_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="code" width="100" halign="center" sortable="true">Code</th>            
            <th field="description" width="300" halign="center" sortable="true">Description</th>
        </tr>
    </thead>
</table>
<script currency="text/javascript">
    $(function () {
        $('#currency').datagrid();
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/currency.js"></script>

