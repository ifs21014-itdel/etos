<style>
    .datagrid-cell {
            white-space: normal; /* Membuat teks otomatis terbungkus */
            word-wrap: break-word;
            word-break: break-all; /* Membuat teks bisa pecah jika terlalu panjang */
        }
</style>
<div class="easyui-layout" data-options="fit:true">
    <div region="center" border='false'>
        <div id="protocol_test_toolbar" style="padding-bottom: 0px;">
            <form id="protocol_test_form_search" onsubmit="return false;" style="margin-bottom: 0px;">
                Search :
                <input type="text"
                       name="protocol_test_q"
                       class="easyui-validatebox"
                       size="10"
                       onkeyup="if (event.keyCode === 13) {
                                   protocol_test_search()
                               }"/>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="protocol_test_search()">Find</a>
                <?php
//                print_r($action);
                if (in_array("Add", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="protocol_test_add()">Add</a>
                    <?php
                }
                if (in_array("Edit", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="protocol_test_edit()">Edit</a>
                    <?php
                }
                if (in_array("Delete", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="protocol_test_delete()">Delete</a>
                    <?php
                }
                ?>
            </form>
        </div>
        <table id="protocol_test" data-options="
               url:'<?php echo site_url('protocol_test/get') ?>',
               method:'post',
               border:true,
               singleSelect:true,
               fit:true,
               title:'Protocol Test',
               autoRowHeight:false,
               rownumbers:true,
               fitColumns:false,
               multiSort:false,
               pagination:true,
               idField:'id',
               striped:true,
               nowrap:false,
               clientPaging: false,
               remoteFilter: true,
               toolbar:'#protocol_test_toolbar'">
            <thead>
                <tr>
                    <th field="test_name" halign="center">Test Name</th>
                    <th field="protocol_name"  halign="center">Protocol</th>
                    <th field="client_name"  halign="center">Client</th>
                    <th field="description" halign="center">Description</th>
                </tr>
            </thead>
        </table>
        <script type="text/javascript">
            $(function () {
                $('#protocol_test').datagrid({
//                    rowStyler: function (index, row) {
//                        var temp = '';
//                        if (row.status === '0') {
//                            temp = 'background-color:#ffcece;';
//                        } else {
//                            temp = 'background-color:#FFFFFF;';
//                        }
//                        return temp;
//                    },
                    onSelect: function (value, row, index) {
//                        $('#protocol_test_component').datagrid('load', {
//                            protocol_test_id: row.id
//                        });
                        $('#protocol_test_variabel_test').datagrid('load', {
                            protocol_test_id: row.id
                        });
//
//                        if (row.status === '1') {
//                            $('#protocol_test_disable').linkbutton('enable');
//                            $('#protocol_test_release').linkbutton('disable');
//                        } else {
//                            $('#protocol_test_disable').linkbutton('disable');
//                            $('#protocol_test_release').linkbutton('enable');
//                        }
                    }
                });
            });
        </script>
    </div>

    <div region="south" 
         style="height:45%;"
         split="true"
         href="<?php echo site_url('protocol_test/variabel_test_index') ?>">
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>js/protocol_test.js"></script>