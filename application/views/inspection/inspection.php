<div id="inspection_toolbar" style="padding-bottom: 0;">
    <form id="po_search_form" onsubmit="inspection_search();
            return false;">
        Search : 
        <input type="text" 
               size="12" 
               name="inspection_code_s"
               class="easyui-validatebox" 
               id="inspection_code_s" 
               oninput="inspection_search()" />
<!--        Status
        
        <select name="status_inspection_id" onchange='inspection_search()'>
            <option value=''>All</option>
            <option value='t'>Submited</option>
            <option value='f'>Draft</option>
        </select>-->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="inspection_search()"></a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="inspection.enableFilter()"><span class="glyphicon glyphicon-filter"></span></a>

        <?php
       // if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="inspection_add()"></a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id="inspection_edit_id" onclick="inspection_edit()"></a>
            <?php
      //  }
        //if (in_array("Delete", $action)) {
            ?>

            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="print_inspection('single')"></a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-redo" plain="true" id="inspection_submit_id" onclick="inspection_submit()">Submit</a>
            <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="print_inspection('detail')">Print Summary</a>-->
            <?php
       // }
        if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="inspection_delete()" id="inspection_delete_id"  iconCls="icon-cancel" alt='delete'></a>
            <?php
        }
        ?>

    </form>
</div>
<table id="inspection" data-options="
       url:'<?php echo site_url('inspection/get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       idField:'id',
       toolbar:'#inspection_toolbar'">
    <thead>
        <tr>
            <!-- <th field="order_company_code" width="60" halign="center" >Order Company</th> -->
            <th field="submited" width="40" align="center">Submited</th>
            <th field="po_client_no" width="100" halign="center">Client P.O Number</th>
            <th field="inspection_date" width="100" align="center" formatter="myFormatDate">Inspection Date</th>
            <th field="client_name" width="100" halign="center">Client</th>
            <th field="ebako_code" width="130" align="center">Ebako Code</th>
            <th field="customer_code" width="130" align="center">Client Code</th>
            <th field="user_updated" width="100" align="center">Inspector</th>
        </tr>
    </thead>
</table>
<script>
    $(function () {
        $('#inspection').datagrid({
            rowStyler: function (index, row) {
                if (row.submited === 'f') {
                    return 'background-color:#ffcece;';
                }
                else {
                    return 'background-color:#66ff99;';
                }
            },
            onSelect: function (index, row) {
                $('#inspection_detail').datagrid('load', {
                    inspectionid: row.id,
                    clientid: row.client_id
                });

                if (row.submited === 't') {
                    $('#inspection_submit_id').linkbutton('disable');
                    $('#inspection_edit_id').linkbutton('disable');
                    $('#inspection_product_add').linkbutton('disable');
                    $('#inspection_product_edit_id').linkbutton('disable');
                } else {
                    $('#inspection_submit_id').linkbutton('enable');
                    $('#inspection_edit_id').linkbutton('enable');
                    $('#inspection_product_add').linkbutton('enable');
                    $('#inspection_product_edit_id').linkbutton('enable');
                }

                if (row.flag === '1') {
                    $('#inspection_product_edit').linkbutton('enable');
                } else {
                    $('#inspection_product_edit').linkbutton('disable');
                }
            }
        });
//        var dgins = $('#inspection').datagrid();
//        dgins.datagrid('enableFilter', [{
//                options: {
//                    panelHeight: 'auto',
//                    data: [{value: '', text: 'All'}, {value: 'P', text: 'P'}, {value: 'N', text: 'N'}],
//                    onChange: function (value) {
//                        if (value == '') {
//                            dgins.datagrid('removeFilterRule', 'status');
//                        } else {
//                            dgins.datagrid('addFilterRule', {
//                                field: 'status',
//                                op: 'equal',
//                                value: value
//                            });
//                        }
//                        dgins.datagrid('doFilter');
//                    }
//                }
//            }]);
    });
</script>
