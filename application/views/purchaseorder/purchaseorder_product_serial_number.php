<table id="po_product_serial_number" class="easyui-datagrid" data-options="
       url:'<?php echo site_url('purchaseorder/product_get_serial_number') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:true,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       idFeild:'id',
       toolbar:'#po_product_serial_number_toolbar',
       onSelect:function(index,row){
            var row_header = $('#purchaseorder').datagrid('getSelected');
            if(row_header.flag === '1'){
                $('#purchaseorder_product_edit').linkbutton('enable');                
            }else{
                if(row.component_type_id === '4'){
                    $('#purchaseorder_product_edit').linkbutton('enable');
                }else{
                    $('#purchaseorder_product_edit').linkbutton('enable');
                }
            }
       }">
    <thead>
        <tr>
            <th field="serial_number" width="100" halign="center">Serial Number</th>
            <th field="ship_date" width="100" halign="center">Ship Date</th>
        </tr>
    </thead>
</table>