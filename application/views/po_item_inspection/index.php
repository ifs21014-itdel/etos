<div id="po_item_inspection_toolbar" style="padding-bottom: 2px;">   
    <form id="po_item_inspection_search_form" onsubmit="return false" style="margin: 0">
        Search : 
        Ebako Code <input type="text" size="20" class="easyui-validatebox" name="ebako_code" onkeypress="if (event.keyCode === 13) {
                    po_item_inspection_search();

                }"/>
        Customer Code <input type="text" size="20" class="easyui-validatebox" name="customer_code" onkeypress="if (event.keyCode === 13) {
                    po_item_inspection_search();

                }"/>
        PO No<input type="text" size="20" class="easyui-validatebox" name="po_client_no" onkeypress="if (event.keyCode === 13) {
                    po_item_inspection_search();

                }"/>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="po_item_inspection_search()">Find</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="po_item_inspection_add()"> Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="po_item_inspection_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-terminate" plain="true" onclick="po_item_inspection_delete()"> Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="po_item_inspection" data-options="
       url:'<?php echo site_url('po_item_inspection/get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       title:'PO ITEM',
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       multiSort:true,
       pagination:true,
       clientPaging: false,
       remoteFilter: true,
       nowrap:false,
       toolbar:'#po_item_inspection_toolbar'">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th field ="detail" formatter="formatDetail" styler="cellStyler" valign="center">Actions</th>
            <th  field="ebako_code" halign="center">Ebako Code</th>
            <th  field="customer_code" width="150" halign="center">Customer Code</th>
            <th  field="client_name" width="150" halign="center">Client</th>
            <th  field="po_client_no" width="150" halign="center">Po No</th>
            <th field="qty" width="50" align="center">Qty</th>
            <!--<th field="material"  width="350"  halign="center">Material</th>-->
            <th field="description" halign="center">Description</th>
        </tr>
    </thead>
</table>
<script po_item_inspection="text/javascript">
    $(function () {
        $('#po_item_inspection').datagrid({
            rowStyler: function (index, row) {
                if ((row.id % 2) == 1) {
                    return 'background-color:silver;';
                }
            },
            onSelect: function (index, row) {
                //alert(row.id);
                $("input[type=button]").attr("disabled", "disabled");
                    $('#inspect'+row.id).removeAttr('disabled');
            }
        });
        
        var dg2 = $('#po_item_inspection').datagrid();
        dg2.datagrid('enableFilter', [{
                options: {
                    panelHeight: 'auto',
                    data: [{value: '', text: 'All'}, {value: 'P', text: 'P'}, {value: 'N', text: 'N'}],
                    onChange: function (value) {
                        if (value == '') {
                            dg2.datagrid('removeFilterRule', 'status');
                        } else {
                            dg2.datagrid('addFilterRule', {
                                field: 'status',
                                op: 'equal',
                                value: value
                            });
                        }
                        dg2.datagrid('doFilter');
                    }
                }
            }]);
    });
    function formatDetail(value, row) {
        var idrow = row.id;
        var temp = '';
        var temp = "<input type=button value='INSPECT' id='inspect"+row.id+"' disabled=true onclick='po_item_inspection_add(" + idrow + ")'> ";
        return temp;
    }
    function cellStyler(value, row) {
        if ((row.id % 2) == 1) {
            return 'color:blue;';
        }
    }
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/po_item_inspection.js"></script>

