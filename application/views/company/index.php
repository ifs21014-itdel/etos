<div id="company_toolbar" style="padding-bottom: 2px;">   
    <form id="company_search_form" onsubmit="return false" style="margin: 0">
        Search : 
        <input type="text" size="20" class="easyui-validatebox" name="q" onkeypress="if (event.keyCode === 13) {
                    company_search();
                }"/>  

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="company_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="company_add()"> Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="company_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="company_delet()"> Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="company" data-options="
       url:'<?php echo site_url('company/get') ?>',
       method:'post',
       border:true,
       title:'Country',
       singleSelect:true,
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       toolbar:'#company_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="name" width="200" halign="center" sortable="true">Name</th>    
            <th field="code" width="200" halign="center" sortable="true">Code</th>            
            <th field="address" width="200" halign="center" sortable="true">Address</th>
            <th field="telp" width="200" halign="center" sortable="true">Telp</th>
            <th field="fax" width="200" halign="center" sortable="true">Fax</th>
            <th field="type" width="200" halign="center" sortable="true">Type</th>
        </tr>
    </thead>
</table>
<script company="text/javascript">
    $(function () {
        $('#company').datagrid({
            onDblClickRow: function (rowIndex, row) {
                company_edit();
            }
        }, 'fixColumnSize', 'reloadFooter', [
            {name: 'company'},
            {name: 'type'}]).datagrid('getPager').pagination({
            beforePageText: 'Page',
            afterPageText: 'From {pages}',
            displayMsg: 'Displaying {from} to {to} of {total} items'
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/company.js"></script>