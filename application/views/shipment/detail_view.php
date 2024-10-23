<div id="shipment_detail_toolbar" style="padding-bottom: 2px;">
    <form id='shipment_detail_search_form' onsubmit="return false" style="margin: 0;">
        Search Serial/EbakoCode/CostomerCode
        <input type="text" name="q" onkeyup="if (event.keyCode === 13) {
                    shipment_detail_search();
                }"/>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="shipment_detail_search()"></a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" id="shipment_detail_add_barcode_id" onclick="shipment_detail_add_barcode()">Scan Barcode</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" id="shipment_detail_add_id"  onclick="shipment_detail_add()">Add Multiple</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" id="shipment_detail_add_delete_id"  onclick="shipment_detail_delete()">Delete</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-import" plain="true"  id="shipment_detail_add_import_id" onclick="shipment_detail_import()">Import</a>
    </form>
</div>
<table id="shipment_detail" data-options="
       url:'<?php echo site_url('shipment/detail_get') ?>',
       method:'post',
       border:false,
       singleSelect:false,
       fit:true,
       title:'Product Detail',
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       clientPaging: false,
       nowrap:false,
       toolbar:'#shipment_detail_toolbar'">
    <thead>
        <tr>
            <th field="shipment_detail_chck88" checkbox='true' ></th>
            <th field="product_image" width="70" align="center"  formatter="shipment_detail_image_load">Image</th>
            <th field="po_client_no" width="150" halign="center" >Client PO No</th>
            <th field="serial_number" width="250" halign="center" >Serial Number</th>
            <th field="ebako_code" width="150" halign="center">Ebako Code</th>
            <th field="customer_code" width="150" halign="center">Customer Code</th>
            <th field="finishing" width="120" halign="center">Finishing</th>
            <th field="material" width="120" halign="center">Material</th>
            <th field="remarks" width="150" halign="center">Remark</th>
            <th field="description" width="150" halign="center">Description</th>
            <th field="tagfor" width="150" halign="center">Tagfor</th>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#shipment_detail').datagrid();

        var dg_shipment_detail = $('#shipment_detail').datagrid();
        dg_shipment_detail.datagrid('enableFilter', [{
                options: {
                    panelHeight: 'auto',
                    data: [{value: '', text: 'All'}, {value: 'P', text: 'P'}, {value: 'N', text: 'N'}],
                    onChange: function (value) {
                        if (value == '') {
                            dg_shipment_detail.datagrid('removeFilterRule', 'status');
                        } else {
                            dg_shipment_detail.datagrid('addFilterRule', {
                                field: 'status',
                                op: 'equal',
                                value: value
                            });
                        }
                        dg_shipment_detail.datagrid('doFilter');
                    }
                }
            }]);
    });

    function shipment_detail_image_load(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:30px;max-height:30px;padding:2px;">';
    }
</script>

