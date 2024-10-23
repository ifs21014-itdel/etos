<div class="easyui-panel" title="SHIPMENT REPORT" fit="true" border="false">
    <div style="width: 100%">
        <form id="client_sales_form" class="table_form">
            <table>
                <tr>
                    <td>
                        <strong style="padding-right: 5px;">Date From </strong>
                        <input type="text" 
                               name='date_from' 
                               class="easyui-datebox" 
                               required="true" 
                               data-options="formatter:myformatter,parser:myparser"
                               style="width:120px"/>
                        <strong style="padding-right: 5px;">To </strong>
                        <input type="text" 
                               name='date_to' 
                               class="easyui-datebox" 
                               required="true" 
                               data-options="formatter:myformatter,parser:myparser"
                               style="width:120px"/>
                        <strong style="padding-right: 5px;">Client </strong>
                        <input class="easyui-combobox" 
                               id="client_id"
                               name="client_id"
                               url="<?php echo site_url('client/get') ?>"
                               method="post"
                               mode="remote"
                               valueField="id"
                               textField="name"
                               panelWidth="250"
                               data-options="formatter: Report_Client_Format"
                               style="width: 150px"/>
                        <script type="text/javascript">
                            function Report_Client_Format(row) {
                                return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span>';
                            }
                        </script>

                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-preview" id="report_client_sales_preview">Preview</a>
                        <script>
                            $('#report_client_sales_preview').click(function () {
//                                alert('test');
                                if ($('#client_sales_form').form('validate')) {
                                    $.post(base_url + 'report/client_sales_generate/preview', $('#client_sales_form').serializeObject(), function (content) {
                                        $('#report_client_sales_content').empty();
                                        $('#report_client_sales_content').append(content);
                                    });
                                }
                            });
                        </script>
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" id="report_client_sales_print">Print</a>
                        <script>
                            $('#report_client_sales_print').click(function () {
//                                alert('test');
                                if ($('#client_sales_form').form('validate')) {
                                    open_target('POST', base_url + 'report/client_sales_generate/print', $('#client_sales_form').serializeObject(), '_blank');
                                }
                            });
                        </script>
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-excel" id="report_client_sales_excel">Excel</a>
                        <script>
                            $('#report_client_sales_excel').click(function () {
//                                alert('test');
                                if ($('#client_sales_form').form('validate')) {
                                    open_target('POST', base_url + 'report/client_sales_generate/excel', $('#client_sales_form').serializeObject(), '_blank');
                                }
                            });
                        </script>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="easyui-panel" id="report_client_sales_content" style="border-left: none;border-right: none" title="Preview">
    </div>
</div>