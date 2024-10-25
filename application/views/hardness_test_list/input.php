<div style="padding: 1px;">
    <form id="hardness_test_list_input_form" method="post" novalidate class="table_form" enctype="multipart/form-data">
        <table width="100%" border="0">

            <tr>
                <td width='30%'><strong>Hardness Test Type</strong></td>
                <td>
                    <input class="easyui-combobox" 
                        id="hardness_test_protocol_id"
                        name="protocol_test_id"
                        url="<?php echo site_url('protocol_test/get/hardness') ?>"
                        method="post"
                        mode="remote"
                        valueField="id"
                        textField="protocol_name"
                        data-options="formatter: hardness_test_protocol_format"
                        style="width: 100%" 
                        />
                    <script type="text/javascript">
                        function hardness_test_protocol_format(row) {
                            return '<span style="font-weight:bold;">' + row.protocol_name + ' - ' + row.test_name + '</span>';
                        }
                    </script>
                </td>
            </tr>
            
            <tr>
                <td><strong>Client</strong></td>
                <td>

                    <input type="text" name="client_id" id="hardness_test_client_id" mode="remote" class="easyui-combogrid" style="width: 100%" required="true"/>
                    <script type="text/javascript">
                        $('#hardness_test_client_id').combogrid({
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


                    <input type="text" name="product_id" id="hardness_test_product_id" mode="remote" class="easyui-combogrid" style="width: 100%" required="true"/>
                    <script type="text/javascript">
                        $('#hardness_test_product_id').combogrid({
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
                    <input type="text" name="vendor_id" required="true" id="hardness_test_vendor_id" class="easyui-combogrid" style="width:100%;"/>
                    <script>

                        $('#hardness_test_vendor_id').combogrid({
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
                                    row.hardness_test_vendor_text = 'Vendor ID:' + row.id + ':Vendor Name:' + row.name;
                                    row.hardness_test_vendor_val = row.id + '#' + row.name;
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
                <td><input name="test_date" class="easyui-datebox" id="hardness_test_date" style="width: 50%;" data-options="formatter:myformatter,parser:myparser" style="width: 69%;"></td>
            </tr>                 

            <tr>
                <td><strong>Report Date</strong></td>
                <td><input name="report_date" class="easyui-datebox" id="hardness_report_date" style="width: 50%;" data-options="formatter:myformatter,parser:myparser" style="width: 69%;"></td>
            </tr>  

            <tr>
                <td><strong>Report Number</strong></td>
                <td><input name="report_no" id="hardness_report_no" class="easyui-validatebox" style="width: 58%;"/></td>
            </tr> 

            <tr>
                <td><strong>Notes</strong></td>
                <td>
                    <textarea name="notes" id="hardness_test_notes" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
            
            <tr>
                <td><strong>Corrective Action Plan</strong></td>
                <td>
                    <textarea id="hardness_test_corrective_action_plan_image" name="corrective_action_plan_image" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>

            <tr>
                <td width="25%"><strong>Product Photo</strong></td>
                <td width="75%"><input type="file" name="product_image" id="hardness_product_image" data-options="prompt:'Pilih File...'" style="width:90%"> </td>
            </tr>
        </table>
    </form>
</div>
