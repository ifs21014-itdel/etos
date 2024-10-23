<div id="toolbar_list_item">
	<div style="height: 100px;"></div>
	Item Name : <input type="text" size="12" class="easyui-validatebox" id="item_name" onkeypress="if(event.keyCode==13){}" />
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="seacrhItem()"> Search</a>
</div>
<table id="sales"></table>

<style>
.datagrid-header .datagrid-cell span {
  font-size: 14px;
  color: #000000;
}
.datagrid-header-row, .datagrid-row {
  height: 36px;
}
</style>

<script type="text/javascript">
$(function() {
	var data = [
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	            {"item_id":"001","item_barcode_id":"1234567890","item_name":"Aqua"},
	        ];
	 $('#sales').datagrid({
	       url:'<?php echo site_url('master/sales/get_sales') ?>',
	       method:'post',
	       border:false,
	       data : data,       
	       title:'List Orders',
	       singleSelect:false,
	       selectOnCheck:true,
	       checkOnSelect:false,
	       fit:false,
	       height:'600',
	       pageSize:30,
	       rownumbers:true,
	       fitColumns:false,
	       pagination:false,
	       pageList: [30, 50, 70, 90, 110],
	       toolbar:'#toolbar_list_item',
	   	   columns:[[
	   			{field:'id',checkbox:true},
	   			{field:'item_id',hidden:true},
	   			{field:'item_barcode_id',title:'Barcode Id', width:'150',halign:'center','styler':cellStylerBarcode},
	   			{field:'item_name',title:'Item Name', width:'180',halign:'center',align:"left",'styler':cellStylerItemName},
	   		]],
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

function cellStylerItemName(value,row,index){
	return 'background-color:#ffee00;color:red;font-weight:bold;height:35px;font-size:14px;';
}

function cellStylerBarcode(value,row,index){
	return 'color:#000;font-weight:bold;height:35px;font-size:14px;';
}

</script>
