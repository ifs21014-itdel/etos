<div id="shipment_summarize_toolbar" style="padding-bottom: 2px;">
    <form id='shipment_summarize_search_form' onsubmit="return false" style="margin: 0;">
        Product Id / Name 
        <input type="text" name="product_id_or_name" class="easyui-validatebox" style="width: 120px"/>
        <script>
            $("#shipment_summarize_search_form input[name=product_id_or_name]").keypress(function (event) {
                if (event.which === 13) {
                    shipment_summarize_search();
                }
            });
        </script>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="shipment_summarize_search()"></a>
    </form>
</div>
<table id="shipment_summarize" data-options="
       url:'<?php echo site_url('shipment/summarize_get') ?>',
       method:'post',
       border:false,
       singleSelect:false,
       fit:true,
       title:'Product Detail',
       pageSize:30,
       autoRowHeight:false,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       nowrap:false,
       toolbar:'#shipment_summarize_toolbar'">
    <thead>
        <tr>
            <th field="shipment_detail_chck88" checkbox='true' ></th>
            <th field="product_image" width="70" align="center"  formatter="shipment_summarize_image_load">Image</th>
            <th field="po_client_no" width="150" halign="center" >Client PO No</th>
            <th field="ebako_code" width="150" halign="center">Ebako Code</th>
            <th field="customer_code" width="150" halign="center">Customer Code</th>
            <th field="pcs_qty" width="150" halign="center">Total Item</th>
            <th field="box_qty" width="150" halign="center">Total Box</th>
            <th field="finishing" width="120" halign="center">Finishing</th>
            <th field="material" width="120" halign="center">Material</th>
            <th field="remarks" width="150" halign="center">Remark</th>
            <th field="description" width="150" halign="center">Description</th>
            <th field="tagfor" width="150" halign="center">Tagfor</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#shipment_summarize').datagrid();
    });

    function shipment_summarize_image_load(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:30px;max-height:30px;padding:2px;">';
    }
</script>

