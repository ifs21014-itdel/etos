<div style="padding: 1px;">
        <!--<form id="print_mark_test_list_input_form" method="post" novalidate enctype="multipart/form-data" class="table_form">-->
        <form id="print_mark_test_list_input_form" method="post" novalidate class="table_form" enctype="multipart/form-data" >
            <table width="100%" border="0">

                <tr>
                    <td width='30%'><strong>Print Mark Test Type</strong></td>
                    <td>
                        <input class="easyui-combobox" 
                            id="print_mark_test_protocol_id"
                            name="protocol_test_id"
                            url="<?php echo site_url('protocol_test/get/print') ?>"
                            method="post"
                            mode="remote"
                            valueField="id"
                            textField="protocol_name"
                            data-options="formatter: print_mark_test_protocol_format"
                            style="width: 100%" 
                            />
                        <script type="text/javascript">
                            function print_mark_test_protocol_format(row) {
                                return '<span style="font-weight:bold;">' + row.protocol_name + ' - ' + row.test_name + '</span>';
                            }
                        </script>
                    </td>
                </tr>
                <tr>
                    <td width="15%"><strong>PO Item</strong></td>
                    <td>
                        <input type="text" name="purchaseorder_item_id" required="true" id="print_mark_test_list_po_item_id" class="easyui-combogrid" style="width:100%;"/>
                        <script>

                            $('#print_mark_test_list_po_item_id').combogrid({
                                url: base_url + 'print_mark_test_list/get_item_po',
                                idField: 'valfield',
                                textField: 'myfield',
                                mode: 'remote',
                                columns: [[
                                        {field: 'id', title: 'ID', width: 40},
                                        {field: 'ebako_code', title: 'Ebako Code', align: 'left', width: 120},
                                        {field: 'customer_code', title: 'Customer Code', align: 'left', width: 120},
                                        {field: 'client_name', title: 'Client Name', align: 'left', width: 100},
                                        {field: 'po_client_no', title: 'PO No', align: 'left', width: 180},
                                        {field: 'description', title: 'Description', align: 'left', width: 120},
                                    ]],
                                onBeforeLoad: function (param) {
                                    param.page = 1;
                                    param.rows = 30;
                                },
                                loadFilter: function (data) {
                                    // return data.rows;
                                    if ($.isArray(data)) {
                                        data = {total: data.length, rows: data};
                                    }
                                    $.map(data.rows, function (row) {
                                        row.myfield = 'PO No:' + row.po_client_no + ':Ebako Code:' + row.ebako_code + ' Cust Code:' + row.customer_code + ' Clientid:' + row.client_id + ' Client name:' + row.client_name ;
                                        row.valfield = row.id + '#' + row.po_client_no + '#' + row.ebako_code + '#' + row.customer_code + '#' + row.client_id + '#' + row.client_name+ '#' + row.product_id;
                                    });
                                    return data;
                                },
                                onChange: function (data) {
                                    //alert(data);
                                }
                            });
                        </script>
                    </td>
                </tr>  

    <!--            <tr>
                    <td><strong>Client</strong></td>
                    <td>
                        <input class="easyui-combobox" 
                            id="print_mark_test_client_id"
                            name="print_mark_test_client_id"
                            url="<?php echo site_url('client/get') ?>"
                            method="post"
                            mode="remote"
                            valueField="id"
                            textField="name"
                            data-options="formatter: print_mark_test_client_format"
                            style="width: 100%" 
                            />
                    </td>
                </tr>-->
                <tr>
                    <td><strong>Brand</strong></td>
                    <td>
                        <select name="brand">
                            <option value='Frontgate'>Frontgate</option>
                            <option value='Grandinroad'>Grandinroad</option>

                        </select>
                    </td>
                </tr>    

                <tr>
                    <td><strong>Vendor</strong></td>
                    <td>
                        <input type="text" name="vendor_id" required="true" id="print_mark_test_vendor_id" class="easyui-combogrid" style="width:100%;"/>
                        <script>

                            $('#print_mark_test_vendor_id').combogrid({
                                url: base_url + 'vendor/get',
                                idField: 'dt_vendor_val',
                                textField: 'dt_vendor_text',
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
                                        row.dt_vendor_text = 'Vendor ID:' + row.id + ':Vendor Name:' + row.name;
                                        row.dt_vendor_val = row.id + '#' + row.name;
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
                    <td><input name="test_date" class="easyui-datebox" style="width: 50%;" data-options="formatter:myformatter,parser:myparser" style="width: 69%;"></td>
                </tr>                 
                <tr>
                    <td><strong>Report Date</strong></td>
                    <td><input name="report_date" class="easyui-datebox" style="width: 50%;" data-options="formatter:myformatter,parser:myparser" style="width: 69%;"></td>
                </tr>  
                <tr>
                    <td><strong>Report Number</strong></td>
                    <td><input name="report_no"  class="easyui-validatebox" style="width: 58%;"/></td>
                </tr> 
                <tr>
                    <td><strong>Notes</strong></td>
                    <td>
                        <textarea name="notes" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="25%"><strong>Product Photo</strong></td>
                    <td width="75%"><input type="file" name="product_image" data-options="prompt:'Pilih File...'" style="width:90%"> </td>
                </tr>
                <tr>
                <td width="25%"><strong>Corrective Action Plan</strong></td>
                <td width="75%"><input type="file" name="corrective_action_plan_image" data-options="prompt:'Pilih File...'" style="width:90%"> </td>
            </tr>
            </table>
        </form>
    </div>