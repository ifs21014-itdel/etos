<div id="purchaseorder_toolbar" style="padding-bottom: 0;">
    <form id="po_search_form" onsubmit="purchaseorder_search();
            return false;">
        Search : 
        <input type="text" 
               size="12" 
               name="q"
               class="easyui-validatebox" 
               id="section_code_s"
               />
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="purchaseorder_search()">Find</a>

        <?php
        if (in_array("Release", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="purchaseorder_add()">Add</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id="purchaseorder_edit_id" onclick="purchaseorder_edit()">Edit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-release" plain="true" id="purchaseorder_release" onclick="purchaseorder_release()">Create Label</a>
            <?php
        }if (in_array("Download Label", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-barcode" plain="true" id="purchaseorder_download_label" onclick="purchaseorder_download_label()">Download Label</a>
            <?php
        }if (in_array("Update Down Payment Date", $action)) {
            ?>
            <!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id="purchaseorder_download_label" onclick="purchaseorder_update_down_payment_date()">Update Down Payment Date</a> -->
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="purchaseorder_delete()"><i class="glyphicon glyphicon-remove"></i> Delete</a>
            <?php
        }if (in_array("Download P.O", $action)) {
            ?>
            <a href="#" class="easyui-menubutton" data-options="menu:'#po_mm_1',iconCls:'icon-download'">Download PO</a>
            <?php
        }
        ?>

    </form>
</div>
<?php
if (in_array("Download P.O", $action)) {
    ?>
    <div id="po_mm_1" style="width:150px;">
        <div data-options="iconCls:'icon-download'" onclick="purchaseorder_download()">Selected PO</div>
        <div data-options="iconCls:'icon-download'" onclick="purchaseorder_download_all_by_order_id()">All By Order ID</div>
    </div>
    <?php
}
?>
<table id="purchaseorder" data-options="
       url:'<?php echo site_url('purchaseorder/get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       idField:'id',       
       clientPaging: false,           
       pagination: true,
       clientPaging: false,
       remoteFilter: true,
       toolbar:'#purchaseorder_toolbar'">
    <thead>
        <tr>
            <!-- <th field="order_company_code" width="60" halign="center" >Order Company</th> -->
            <th field="po_client_no" width="170" halign="center">Client P.O Number</th>
            <th field="po_no" width="170" halign="center">Ebako P.O Number</th>
            <th field="po_date" width="100" align="center" formatter="myFormatDate">P.O Date</th>
            <th field="client_name" width="180" halign="center">Client</th>
            <th field="target_ship_date" width="125" align="center" formatter="myFormatDate">Target Shipment</th>
            <th field="remark" width="180" align="center">Remark</th>
            <th field="ship_to" width="180" align="center">Ship TO</th>
        </tr>
    </thead>
</table>
<script>
    $(function () {
        $('#purchaseorder').datagrid({
            rowStyler: function (index, row) {
                if (row.release === 'f') {
                    return 'background-color:#ffcece;';
                }
            },
            onSelect: function (index, row) {
                $('#po_product').datagrid('load', {
                    purchaseorderid: row.id,
                    clientid: row.client_id
                });
                $('#po_product_serial_number').datagrid('load', {
                    purchaseorderid: row.id
                });

                if (row.release === 't') {
                    $('#purchaseorder_release').linkbutton('disable');
                    $('#purchaseorder_edit_id').linkbutton('disable');
                    $('#purchaseorder_product_add').linkbutton('disable');
                    $('#purchaseorder_product_edit_id').linkbutton('disable');
                } else {
                    $('#purchaseorder_release').linkbutton('enable');
                    $('#purchaseorder_edit_id').linkbutton('enable');
                    $('#purchaseorder_product_add').linkbutton('enable');
                    $('#purchaseorder_product_edit_id').linkbutton('enable');
                }

                if (row.flag === '1') {
                    $('#purchaseorder_product_edit').linkbutton('enable');
                } else {
                    $('#purchaseorder_product_edit').linkbutton('disable');
                }
            }
        });
        var dg_po = $('#purchaseorder').datagrid();
        dg_po.datagrid('enableFilter', [{
                options: {
                    panelHeight: 'auto',
                    data: [{value: '', text: 'All'}, {value: 'P', text: 'P'}, {value: 'N', text: 'N'}],
                    onChange: function (value) {
                        if (value == '') {
                            dg_po.datagrid('removeFilterRule', 'status');
                        } else {
                            dg_po.datagrid('addFilterRule', {
                                field: 'status',
                                op: 'equal',
                                value: value
                            });
                        }
                        dg_po.datagrid('doFilter');
                    }
                }
            }]);
    });
</script>
