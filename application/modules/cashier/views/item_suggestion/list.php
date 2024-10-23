<div id="toolbar_list_item">
    Item Name : <input type="text" size="12" class="easyui-validatebox" id="item_name" onkeypress="if(event.keyCode==13){}"/>    
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="seacrhItem()"> Search</a>
</div>
<table id="sales"
       data-options="
       url:'<?php echo site_url('master/sales/get_sales') ?>',
       method:'post',
       border:true,       
       title:'List Sales',
       singleSelect:false,
       selectOnCheck:true,
       checkOnSelect:false,
       fit:true,
       pageSize:30,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       pageList: [30, 50, 70, 90, 110],
       toolbar:'#toolbar_list_item'">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th field="item_id" hidden="true"></th>
            <th field="item_barcode_id" width="200" halign="center">Barcode No.</th>
            <th field="item_name" width="200" halign="center">Item Name</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function() {
        $('#sales').datagrid({
            onCheck: function(index,row){
            },
            onSelect: function(index,row){
            },
            onUnselect: function(index,row){
            },
            onSelectAll : function(row){
            },
            onUnselectAll : function(row){
            }
        });
    });
</script>
