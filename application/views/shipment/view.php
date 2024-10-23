<div id="shipment_toolbar" style="padding-bottom: 2px;">
    <form id="shipment_search_form" onsubmit="return false" novalidate="">
        Search <input type="text" name="q" onkeyup="if (event.keyCode === 13) {
                    shipment_search();
                }"/>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="shipment_search()">Find</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="shipment_add()">Add</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="shipment_edit()" id="shipment_edit_id" >Edit</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="shipment_delete()" id="shipment_delete_id" >Delete</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-submit" plain="true" id="shipment_submit_id" onclick="shipment_submit()">Submit</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="shipment_print('detail')">Print Detail</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="shipment_print('summary')">Print Summary</a>
    </form>
</div>
<table id="shipment" data-options="
       url:'<?php echo site_url('shipment/get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       multiSort:true,         
       pagination: true,
       clientPaging: false,
       remoteFilter: true,
       toolbar:'#shipment_toolbar'">
    <thead>
        <tr>
            <th field="shipment_no"  align="center">Packing List No</th>            
            <th field="date" align="center" formatter="myFormatDate">Date</th>
            <th field="client_name" width="170" halign="center">Client</th>
            <th field="client_company" width="150" halign="center" sortable="true">Shipment To</th>
            <th field="container_no" width="110" halign="center">Container No.</th>
            <th field="seal_no" width="110" halign="center">Seal No.</th>
            <th field="loadibility" width="100" halign="center" sortable="true">Loadibility</th>
            <th field="description_of_goods" width="200" halign="center">Description of goods</th>
            <th field="tally_user" width="200" halign="center">Tally User</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#shipment').datagrid({
            rowStyler: function (index, row) {
                if (row.submited !== 't') {
                    return 'background-color:#ffcece;';
                }
            },
            onSelect: function (index, row) {
                $('#shipment_detail').datagrid('reload', {shipmentid: row.id});
                $('#shipment_summarize').datagrid('reload', {shipmentid: row.id});

                if (row.submited === 't') {
                    $('#shipment_submit_id').linkbutton('disable');
                    $('#shipment_edit_id').linkbutton('disable');
                    $('#shipment_delete_id').linkbutton('disable');
                    $('#shipment_detail_add_barcode_id').linkbutton('disable');
                    $('#shipment_detail_add_id').linkbutton('disable');
                    $('#shipment_detail_add_delete_id').linkbutton('disable');
                    $('#shipment_detail_add_import_id').linkbutton('disable');
                } else {
                    $('#shipment_submit_id').linkbutton('enable');
                    $('#shipment_edit_id').linkbutton('enable');
                    $('#shipment_delete_id').linkbutton('enable');
                    $('#shipment_detail_add_barcode_id').linkbutton('enable');
                    $('#shipment_detail_add_id').linkbutton('enable');
                    $('#shipment_detail_add_delete_id').linkbutton('enable');
                    $('#shipment_detail_add_import_id').linkbutton('enable');
                }
            }
        });

        var dg_shipment = $('#shipment').datagrid();
        dg_shipment.datagrid('enableFilter', [{
                options: {
                    panelHeight: 'auto',
                    data: [{value: '', text: 'All'}, {value: 'P', text: 'P'}, {value: 'N', text: 'N'}],
                    onChange: function (value) {
                        if (value == '') {
                            dg_shipment.datagrid('removeFilterRule', 'status');
                        } else {
                            dg_shipment.datagrid('addFilterRule', {
                                field: 'status',
                                op: 'equal',
                                value: value
                            });
                        }
                        dg_shipment.datagrid('doFilter');
                    }
                }
            }]);

    });
</script>