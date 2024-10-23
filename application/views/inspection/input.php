<?php
//echo $_SERVER["HTTP_USER_AGENT"];
//echo preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
?>
<div style="width: 100%">
    <form id="inspection_input_form" method="post" novalidate >
        <table width="99%">    
            <tr valign="top">
                <td width="100%">  
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form">
                        <caption><span style="font-weight: bold;">Order Details</span></caption>    
                        <tr>
                            <td width="15%"><strong>PO Item</strong></td>
                            <td>
                                <input type="text" name="id_po_item_inspection" required="true" id="id_po_item_inspection" class="easyui-combogrid" style="width:100%;"/>
                                <script>

                                    $('#id_po_item_inspection').combogrid({
                                        url: base_url + 'inspection/get_item_po',
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
                                                row.myfield = 'PO No:' + row.po_client_no + ':Ebako Code:' + row.ebako_code + ' Cust Code:' + row.customer_code + ' Clientid:' + row.client_id + ' Client name:' + row.client_name + '';
                                                row.valfield = row.id+'#'+row.po_client_no + '#' + row.ebako_code + '#' + row.customer_code + '#' + row.client_id + '#' + row.client_name;
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
                        
                    </table>
                </td>
            </tr>

        </table>
    </form>
</div>