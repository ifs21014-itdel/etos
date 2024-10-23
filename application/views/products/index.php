<div class="easyui-layout" data-options="fit:true">
    <div region="center" border='false'>
        <div id="products_toolbar" style="padding-bottom: 0px;">
            <form id="products_form_search" onsubmit="return false;" style="margin-bottom: 0px;">
                Search :
                <input type="text"
                       name="code_name"
                       class="easyui-validatebox"
                       size="10"
                       onkeyup="if (event.keyCode === 13) {
                                   products_search()
                               }"/>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="products_search()">Find</a>
                <?php
//                print_r($action);
                if (in_array("Add", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="products_add()">Add</a>
                    <?php
                }
                if (in_array("Edit", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="products_edit()">Edit</a>
                    <?php
                }
                if (in_array("Delete", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="products_delete()">Delete</a>
                    <?php
                }
                if (in_array("Update MSRP", $action)) {
                    ?>
                    <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit-price" plain="true" onclick="products_update_price()">Update MSRP</a>-->
                    <?php
                }
                if (in_array("Release", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-release" plain="true" id="products_release" onclick="products_update_status(1)">Release Product</a>
                    <?php
                }
                if (in_array("Disable", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-disable" plain="true" id="products_disable" onclick="products_update_status(0)">Disable Product</a>
                    <?php
                }
//                if (in_array("Copy", $action)) {
                ?>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-copy" plain="true" id="products_copy" onclick="products_copy()">Copy</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="product_download('detail')">Download</a>
                <?php
//                }
                ?>
            </form>
        </div>
        <table id="products" data-options="
               url:'<?php echo site_url('products/get') ?>',
               method:'post',
               border:true,
               singleSelect:true,
               fit:true,
               title:'Product',
               autoRowHeight:false,
               rownumbers:true,
               fitColumns:false,
               multiSort:false,
               pagination:true,
               idField:'id',
               sortName:'id',
               sortOrder:'desc',
               striped:true,
               nowrap:false,
               clientPaging: false,
               remoteFilter: true,
               toolbar:'#products_toolbar'">
            <thead>
                <tr>
                    <th field="image" sortable="true" width="60" align="center" formatter="product_image_load">Image</th>
                    <th field="client_name" width="180" halign="center">Client</th>
                    <th field="ebako_code" width="100" halign="center">Ebako Code</th>
                    <th field="customer_code" width="100" halign="center">Customer Code</th>
                    <th field="packing_configuration" width="100" align="center">Packing Conf.</th>
                    <!--<th field="finishing" width="120" halign="center">Finishing</th>-->
                    <th field="material" width="120" halign="center">Material</th>
                    <th field="remarks" width="100" halign="center">Remark</th>
                    <th field="description" width="100" halign="center">Description</th>
                </tr>
            </thead>
        </table>
        <script type="text/javascript">
            $(function () {
                $('#products').datagrid({
                    rowStyler: function (index, row) {
                        var temp = '';
                        if (row.status === '0') {
                            temp = 'background-color:#ffcece;';
                        } else {
                            temp = 'background-color:#FFFFFF;';
                        }
                        return temp;
                    },
                    onSelect: function (value, row, index) {
//                        $('#products_component').datagrid('load', {
//                            products_id: row.id
//                        });
                        $('#products_box').datagrid('load', {
                            products_id: row.id
                        });

                        if (row.status === '1') {
                            $('#products_disable').linkbutton('enable');
                            $('#products_release').linkbutton('disable');
                        } else {
                            $('#products_disable').linkbutton('disable');
                            $('#products_release').linkbutton('enable');
                        }
                    }
                });
            });
            var dg_product = $('#products').datagrid();
            dg_product.datagrid('enableFilter', [{
                    options: {
                        panelHeight: 'auto',
                        data: [{value: '', text: 'All'}, {value: 'P', text: 'P'}, {value: 'N', text: 'N'}],
                        onChange: function (value) {
                            if (value == '') {
                                dg_product.datagrid('removeFilterRule', 'status');
                            } else {
                                dg_product.datagrid('addFilterRule', {
                                    field: 'status',
                                    op: 'equal',
                                    value: value
                                });
                            }
                            dg_product.datagrid('doFilter');
                        }
                    }
                }]);

            function product_image_load(value, row) {
                return '<img src="files/products_image/' + value + '" style="max-width:40px;max-height:40px;padding:1px;">';
            }
        </script>
    </div>

    <div region="south" 
         style="height:45%;"
         split="true"
         href="<?php echo site_url('products/box_index') ?>">
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>js/products.js"></script>