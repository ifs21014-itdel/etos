<div id="inspection_summary_toolbar" style="padding-bottom: 2px;">   
    <form id="inspection_summary_search_form" onsubmit="return false" style="margin: 0">
        E.Code/C.Code/C.Name/PoNo : 
        <input type="text" size="20" class="easyui-validatebox" name="q" onkeypress="if (event.keyCode === 13) {
                    inspection_summary_search();

                }"/>
        Inspector : 
        <input type="text" size="20" class="easyui-validatebox" name="q2" onkeypress="if (event.keyCode === 13) {
                    inspection_summary_search();

                }"/>
                    Inspection Date : 
                    <input type=text id="date_is_start_id" name="date_is_start" class="easyui-datebox"  data-options="formatter:myformatter,parser:myparser" />    
                    to :<input type=text id="date_is_to_id" name="date_is_to" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" /> 
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="inspection_summary_search()">Find</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="print_inspection2('single')"></a>
        
    </form>
</div>
<table id="inspection_summary" data-options="
       url:'<?php echo site_url('inspection_summary/get') ?>',
       method:'post',
       border:false,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       idField:'id',
       toolbar:'#inspection_summary_toolbar'">
    <thead>
        <tr>
            <!-- <th field="order_company_code" width="60" halign="center" >Order Company</th> -->
            <!--<th field="submited" width="40" align="center">Submited</th>-->
            <th field="po_client_no" width="100" halign="center">Client P.O Number</th>
            <th field="inspection_date" width="120" align="center" formatter="myFormatDate">Inspection Date</th>
            <th field="client_name" width="120" halign="center">Client</th>
            <th field="ebako_code" width="130" align="center">Ebako Code</th>
            <th field="customer_code" width="130" align="center">Client Code</th>
            <th field="user_updated" width="100" align="center">Inspector</th>
        </tr>
    </thead>
</table>
<script inspection_summary="text/javascript">
    $(function () {
        $('#inspection_summary').datagrid({
            rowStyler: function(index, row) {
                
//                if (date1.toDateString() == row.inspection_date.toDateString()) {
//                    return 'background-color:#ffff00;';
//                }
            },
            onSelect: function(index, row) {
                //---
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/inspection_summary.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/inspection.js"></script>

