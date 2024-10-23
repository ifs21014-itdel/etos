<div id="country_toolbar" style="padding-bottom: 2px;">   
    <form id="country_search_form" onsubmit="return false" style="margin: 0">
        Search : 
        <input type="text" size="20" class="easyui-validatebox" name="q" onkeypress="if (event.keyCode === 13) {
                    country_search();
                }"/>  

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="country_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="country_add()"> Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="country_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="country_delet()"> Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="country" data-options="
       url:'<?php echo site_url('country/get') ?>',
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
       toolbar:'#country_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="common_name" width="200" halign="center" sortable="true">Common Name</th>            
            <th field="formal_name" width="200" halign="center" sortable="true">Formal Name</th>
            <th field="capital" width="200" halign="center" sortable="true">Capital</th>
        </tr>
    </thead>
</table>
<script country="text/javascript">
    $(function () {
        $('#country').datagrid({
            onDblClickRow: function (rowIndex, row) {
                country_edit();
            }
        }, 'fixColumnSize', 'reloadFooter', [
            {name: 'country'},
            {name: 'formal_name'}]).datagrid('getPager').pagination({
            beforePageText: 'Page',
            afterPageText: 'From {pages}',
            displayMsg: 'Displaying {from} to {to} of {total} items'
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/country.js"></script>