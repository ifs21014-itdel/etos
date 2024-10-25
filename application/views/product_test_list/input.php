<div style="padding: 1px;">
    <form id="product_test_list_input_form" method="post" novalidate class="table_form" enctype="multipart/form-data">
        <table width="100%" border="0">
            <tr>
                <td width='30%'><strong>Product Test Type</strong></td>
                <td>
                    <input class="easyui-combobox" 
                           id="product_test_protocol_id"
                           name="protocol_test_id"
                           url="<?php echo site_url('protocol_test/get/product') ?>"
                           method="post"
                           mode="remote"
                           valueField="id"
                           textField="protocol_name"
                           data-options="formatter: product_test_protocol_format"
                           style="width: 100%" 
                           />
                    <script type="text/javascript">
                        function product_test_protocol_format(row) {
                            return '<span style="font-weight:bold;">' + row.protocol_name + ' - ' + row.test_name + '</span>';
                        }
                    </script>
                </td>
            </tr>
            <tr>
                <td><strong>Client</strong></td>
                <td>

                    <input type="text" name="client_id" id="product_test_client_id" mode="remote" class="easyui-combogrid" style="width: 100%" required="true"/>
                    <script type="text/javascript">
                        $('#product_test_client_id').combogrid({
                            panelWidth: 460,
                            idField: 'id',
                            textField: 'name',
                            mode: 'remote',
                            url: '<?php echo site_url('client/get') ?>',
                            columns: [[
                                    {field: 'id', title: 'ID', width: 60},
                                    {field: 'code', title: 'COde', width: 150},
                                    {field: 'name', title: 'Name', width: 180}
                                ]],
                            onBeforeLoad: function (param) {
                                param.page = 1;
                                param.rows = 30;
                            },
                            onChange: function (data) {
                                //alert(data);
                            }
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td width="30%"><strong>Product Code </strong></td>
                <td width="70%">


                    <input type="text" name="product_id" id="product_test_product_id" mode="remote" class="easyui-combogrid" style="width: 100%" required="true"/>
                    <script type="text/javascript">
                        $('#product_test_product_id').combogrid({
                            panelWidth: 460,
                            idField: 'id',
                            mode: 'remote',
                            textField: 'ebako_code',
                            url: '<?php echo site_url('products/get2') ?>',
                            columns: [[
                                    {field: 'id', title: 'ID', width: 60},
                                    {field: 'ebako_code', title: 'Ebako COde', width: 100},
                                    {field: 'customer_code', title: 'Customer Code', width: 50},
                                    {field: 'description', title: 'Desc', width: 200}
                                ]],
                            onBeforeLoad: function (param) {
                                param.page = 1;
                                param.rows = 30;
                            },
                            onChange: function (data) {
                                //alert(data);
                            }
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td><strong>Vendor</strong></td>
                <td>
                    <input type="text" name="vendor_id" required="true" id="product_test_vendor_id" class="easyui-combogrid" style="width:100%;"/>
                    <script>

                        $('#product_test_vendor_id').combogrid({
                            url: base_url + 'vendor/get',
                            idField: 'id',
                            textField: 'name',
                            mode: 'remote',
                            columns: [[
                                    {field: 'id', title: 'ID', width: 40},
                                    {field: 'code', title: 'Vendor Code', align: 'left', width: 120},
                                    {field: 'name', title: 'Vendor Name', align: 'left', width: 120},
                                ]],
                            onBeforeLoad: function (param) {
                                param.page = 1;
                                param.rows = 30;
                            },
                            loadFilter: function (data2) {
                                // return data.rows;
                                if ($.isArray(data2)) {
                                    data2 = {total: data2.length, rows: data2};
                                }
                                $.map(data2.rows, function (row) {
                                    row.pt_vendor_text = 'Vendor ID:' + row.id + ':Vendor Name:' + row.name;
                                    row.pt_vendor_val = row.id + '#' + row.name;
                                });
                                return data2;
                            },
                            onChange: function (data2) {
                                //alert(data);
                            }
                        });
                    </script>
                </td>
            </tr> 
            <tr>
                <td><strong>Test Date</strong></td>
                <td><input id="product_test_date" name="test_date" class="easyui-datebox" style="width: 50%;" data-options="formatter:myformatter,parser:myparser"></td>
            </tr>
            <tr>
                <td><strong>Report Date</strong></td>
                <td><input id="product_test_report_date" name="report_date" class="easyui-datebox" style="width: 50%;" data-options="formatter:myformatter,parser:myparser"></td>
            </tr>
            <tr>
                <td><strong>Report Number</strong></td>
                <td><input id="product_test_report_no" name="report_no" class="easyui-validatebox" style="width: 58%;"/></td>
            </tr>
            <tr>
                <td><strong>Product Dimension (Inches)</strong></td>
                <td><input id="product_test_product_dimension" name="product_dimension" class="easyui-validatebox" style="width: 58%;"/></td>
            </tr>
            <tr>
                <td><strong>Carton Dimension (Inches)</strong></td>
                <td><input id="product_test_carton_dimension" name="carton_dimension" class="easyui-validatebox" style="width: 58%;"/></td>
            </tr>
            <tr>
                <td><strong>Gross Weight (Lbs)</strong></td>
                <td><input id="product_test_gross_weight" name="gross_weight" class="easyui-numberbox" style="width: 38%;"/></td>
            </tr>
            <tr>
                <td><strong>Nett Weight (Lbs)</strong></td>
                <td><input id="product_test_nett_weight" name="nett_weight" class="easyui-numberbox" style="width: 38%;"/></td>
            </tr>
            <tr>
                <td><strong>Notes</strong></td>
                <td>
                    <textarea id="product_test_notes" name="notes" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
            <tr>
                <td><strong>Corrective Action Plan</strong></td>
                <td>
                    <textarea id="product_test_corrective_action_plan_image" name="corrective_action_plan_image" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
            <tr>
                <td width="25%"><strong>Product Photo</strong></td>
                <td width="75%">
                    <input type="file" id="product_image" name="product_image" data-options="prompt:'Pilih File...'" style="width:90%">
                </td>
            </tr>
        </table>
    </form>
</div>
