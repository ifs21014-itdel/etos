<div class="easyui-layout" data-options="fit:true">
    <div region="center" border='false'>
        <div id="product_test_list_toolbar" style="padding-bottom: 0px;">
            <form id="product_test_list_form_search" onsubmit="return false;" style="margin-bottom: 0px;">
                Search :
                <input type="text"
                       name="product_test_list_q"
                       class="easyui-validatebox"
                       size="10"
                       onkeyup="if (event.keyCode === 13) {
                                   product_test_list_search()
                               }"/>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="product_test_list_search()">Find</a>
                <?php
//                print_r($action);
                if (in_array("Add", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="product_test_list_add()" >Add</a>
                    <?php
                }
                if (in_array("Edit", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="product_test_list_edit()" id="product_test_list_edit_id" >Edit</a>
                    <?php
                }
                if (in_array("Delete", $action)) {
                    ?>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="product_test_list_delete()" id="product_test_list_delete_id" >Delete</a>
                    <?php
                }
                ?>
                <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-redo" plain="true" id="product_test_list_submit_id" onclick="product_test_list_submit()">Submit</a>-->

                <a href="#" id="product_test_list_submit_id" class="easyui-menubutton" data-options="menu:'#product_test_result_mm_2',iconCls:'icon-redo'">Submit</a>
                <div id="product_test_result_mm_2" style="width:150px;">
                    <div style="background-color: greenyellow;"onclick="product_test_list_submit('Passed')">PASSED</div>
                    <div  style="background-color: #f67c63;" onclick="product_test_list_submit('Failed')">FAILED</div>
                    <div  style="background-color: #ffed55;" onclick="product_test_list_submit('Car')">CAR</div>
                </div>

                <a href="#" id="product_test_list_print_id" class="easyui-menubutton" data-options="menu:'#product_test_list_mm_print',iconCls:'icon-print'">Print</a>
                <div id="product_test_list_mm_print" style="width:150px;">
                    <div data-options="iconCls:'icon-view'"  onclick="print_product_test_list('single', 'view')">View</div>
                    <div data-options="iconCls:'icon-pdf'"  onclick="print_product_test_list('single', 'pdf')">PDF</div>
                    <div data-options="iconCls:'icon-xls'"  onclick="product_test_list_excel()">Excel</div>
                </div>
            </form>
        </div>
        <table id="product_test_list" data-options="
               url:'<?php echo site_url('product_test_list/get') ?>',
               method:'post',
               border:true,
               singleSelect:true,
               fit:true,
               title:'PRODUCT TEST LIST',
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
               toolbar:'#product_test_list_toolbar'">
            <thead>
                <tr>
                    <th field="protocol_name" halign="center">Product Test Type</th>
                    <!-- <th field="brand" halign="center">Brand</th> -->
                    <th field="client_name"  halign="center">Client</th>
                    <th field="vendor_name"  halign="center">Vendor</th>
                    <th field="ebako_code" halign="center">Ebako Code</th>
                    <th field="customer_code" halign="center">customer_code</th>
                    <th field="carton_dimension" halign="center">Carton Dimension</th>
                    <th field="product_dimension" halign="center">Product Dimension</th>
                    <th field="gross_weight" halign="center">Gross Weight</th>
                    <th field="report_no" halign="center">Report No</th>
                    <th field="test_date" halign="center">Test date</th>
                    <th field="report_date" halign="center">Report Date</th>
                    <th field="rating" halign="center">Rating/Status</th>
                    <th field="submited" halign="center">Submited</th>
            <th  field="product_image"  valign="center" align=center formatter="showimage_product_test_product_image">Image 3</th>
            <!-- <th  field="corrective_action_plan_image"  valign="center" align=center formatter="showimage_product_test_corrective_action_plan">Corrective Action Plan</th> -->
                </tr>
            </thead>
        </table>
        <script type="text/javascript">
            $(function () {
                $('#product_test_list').datagrid({
                    rowStyler: function (index, row) {
                        if (row.submited === 'f') {
                            return 'background-color:#ffcece;';
                        }
                        if (row.rating === 'Failed') {
                            return 'background-color:#f69480;';
                        }
                    },
                    onSelect: function (value, row, index) {
//                        $('#product_test_list_component').datagrid('load', {
//                            product_test_list_id: row.id
//                        });
                        $('#product_test_list_product_test_list_detail').datagrid('load', {
                            product_test_list_id: row.id
                        });
                        if (row.submited == 't') {

                            $('#product_test_list_submit_id').linkbutton('disable');
                            $('#product_test_list_edit_id').linkbutton('disable');
                            $('#product_test_list_delete_id').linkbutton('disable');
                        } else {

                            $('#product_test_list_submit_id').linkbutton('enable');
                            $('#product_test_list_edit_id').linkbutton('enable');
                            $('#product_test_list_delete_id').linkbutton('enable');
                        }
//
//                        if (row.status === '1') {
//                            $('#product_test_list_disable').linkbutton('enable');
//                            $('#product_test_list_release').linkbutton('disable');
//                        } else {
//                            $('#product_test_list_disable').linkbutton('disable');
//                            $('#product_test_list_release').linkbutton('enable');
//                        }
                    }
                });
            });

            function showimage_product_test_product_image(value, row) {
                var idrow = row.id;
                var temp = '';
                //alert(row.product_test_list_id);
                if (row.product_image == null)
                    var temp = '';
                else {
                    //var temp=row.image_file;
                    var temp = "<img src='files/producttest/" + row.id + "/" + row.product_image + "' width=90 height=90 onclick='product_test_list_variabel_test_view_detail(" + idrow + ")'>";
                    //var temp = "<img src='files/producttest/" + row.product_test_list_id + "/" + row.image_file + "' width=50>" + row.image_file;
                }
                return temp;
            }
            // function showimage_product_test_corrective_action_plan(value, row) {
            //     var idrow = row.id;
            //     var temp = '';
            //     // Periksa apakah `corrective_action_plan_image` ada dan tidak kosong
            //     if (row.corrective_action_plan_image == null || row.corrective_action_plan_image === '') {
            //         temp = ''; // Tidak menampilkan apa-apa jika tidak ada gambar
            //     } else {
            //         // Sesuaikan direktori penyimpanan untuk gambar corrective action plan
            //         temp = "<img src='files/producttest/" + row.id +"/" + row.corrective_action_plan_image + "' width=90 height=90 onclick='print_mark_test_list_variabel_test_view_detail(" + idrow + ")'>";
            //     }
            //     return temp;
            // }
        </script>
    </div>

    <div region="south" 
         style="height:45%;"
         split="true"
         href="<?php echo site_url('product_test_list/product_test_list_detail_index') ?>">
    </div>

    <!--    <div region="east" 
             style="width:40%;"
             split="true"
             href="<?php echo site_url('product_test_list/product_test_list_detail_index') ?>">
        </div>-->
</div>
<script type="text/javascript" src="<?php echo base_url() ?>js/product_test_list.js"></script>