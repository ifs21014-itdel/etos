<div class="easyui-panel" title="Purchase Order Report" border="true" style="width: auto;height: auto;">
    <div style="width: 100%">
        <form id="purchase_order_form" class="table_form">
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
                               data-options="formatter: Report_Vendor_Format"
                               style="width: 150px" />
                        <script type="text/javascript">
                            function Report_Vendor_Format(row) {
                                return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span><br/>' ;
//                                        '<span style="font-weight:bold;">Company : ' + row.company + '</span><br/>' ;
//                                        '<span style="color:#888">Address: ' + row.address + '</span>';
                            }
                        </script>
<!--                        <strong style="padding-right: 5px;">Currency </strong>
                        <input class="easyui-combobox" id='pi_currency_i'  name="currency_id"  data-options="
                               url: '<?php echo site_url('currency/get') ?>',
                               method: 'post',
                               valueField: 'id',
                               textField: 'code',
                               panelHeight: 'auto'"
                               style="width: 60px" >-->
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-preview" id="report_purchase_order_preview">Preview</a>
                        <script>
                            $('#report_purchase_order_preview').click(function () {
//                                alert('test');
                                if ($('#purchase_order_form').form('validate')) {
                                    $.post(base_url + 'report/purchase_order_generate/preview', $('#purchase_order_form').serializeObject(), function (content) {
                                        $('#report_purchase_order_content').empty();
                                        $('#report_purchase_order_content').append(content);
                                    });
                                }
                            });
                        </script>
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" id="report_purchase_order_print">Print</a>
                        <script>
                            $('#report_purchase_order_print').click(function () {
//                                alert('test');
                                if ($('#purchase_order_form').form('validate')) {
                                    open_target('POST', base_url + 'report/purchase_order_generate/print', $('#purchase_order_form').serializeObject(), '_blank');
                                }
                            });
                        </script>
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-excel" id="report_purchase_order_excel">Excel</a>
                        <script>
                            $('#report_purchase_order_excel').click(function () {
//                                alert('test');
                                if ($('#purchase_order_form').form('validate')) {
                                    open_target('POST', base_url + 'report/purchase_order_generate/excel', $('#purchase_order_form').serializeObject(), '_blank');
                                }
                            });
                        </script>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="easyui-panel" id="report_purchase_order_content"  title="Preview">
    </div>
</div>