<div id="po_product_toolbar" style="padding-bottom: 2px;">
    <form id="po_product_search_form" onsubmit="po_product_search();
            return false" style="margin: 0;">
        Search 
        <input type="text" name="q" class="easyui-validatebox" />
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="po_product_search()">Find</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" id='purchaseorder_product_add' onclick="purchaseorder_product_add()"> Add</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id='purchaseorder_product_edit_id' onclick="purchaseorder_product_edit()"> Edit</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" id='purchaseorder_product_delete_id' onclick="purchaseorder_product_delete()"> Delete</a>
    </form>

</div>
<table id="po_product" class="easyui-datagrid" data-options="
       url:'<?php echo site_url('purchaseorder/product_get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       nowrap:false,
       idFeild:'id',
       toolbar:'#po_product_toolbar'">
    <thead>
        <tr>
            <th  rowspan="2" field="ebako_code" width="100" halign="center">Ebako Code</th>
            <th  rowspan="2" field="customer_code" width="100" halign="center">Customer Code</th>
            <th rowspan="2" field="qty" width="50" align="center">Qty</th>
            <th rowspan="2" field="packing_configuration" width="120" halign="center">Packing Conf.</th>
            <th colspan="3">SERIAL</th>
            <th rowspan="2" field="finishing" width="120" halign="center">Finishing</th>
            <th rowspan="2" field="material" width="120" halign="center">Material</th>
            <th rowspan="2" field="promise_date" width="120" halign="center">Promise Date</th>
            <th rowspan="2" field="line" width="100" halign="center">Line</th>
            <th rowspan="2" field="release_no" width="100" halign="center">Release No</th>
            <th rowspan="2" field="tagfor" width="100" halign="center">Tag For</th>
            <th rowspan="2" field="remarks" width="100" halign="center">Remarks</th>
            <th rowspan="2" field="description" width="100" halign="center">Description</th>
        </tr>
        <tr>
            <th field="label_qty" width="120" halign="center" align="center">Qty</th>
            <th field="total_shiped" width="120" halign="center" align="center">Shiped</th>
            <th field="product_id" formatter="ots_format" align="center">Outstanding</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#po_product').datagrid({
            rowStyler: function (index, row) {
                if (row.ship_date === null) {
                    return 'background-color:#ffcece;';
                }
            },
            onSelect: function (index, row) {
                $('#po_product_serial_number').datagrid('load', {
                    purchaseorder_item_id: row.id
                });
            }
        });
        
        var dg_po_product = $('#po_product').datagrid();
        dg_po_product.datagrid('enableFilter', [{
                options: {
                    panelHeight: 'auto',
                    data: [{value: '', text: 'All'}, {value: 'P', text: 'P'}, {value: 'N', text: 'N'}],
                    onChange: function (value) {
                        if (value == '') {
                            dg_po_product.datagrid('removeFilterRule', 'status');
                        } else {
                            dg_po_product.datagrid('addFilterRule', {
                                field: 'status',
                                op: 'equal',
                                value: value
                            });
                        }
                        dg_po_product.datagrid('doFilter');
                    }
                }
            }]);
        
    });
    function ots_format(value, row) {
        var ots = (row.label_qty-row.total_shiped);
        var data_return;
        data_return=ots;
        return  data_return;
    }
</script>