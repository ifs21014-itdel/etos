<div id="shipment_detail_product_available_toolbar" style="padding-bottom: 2px;">
    <form id='shipment_detail_product_available_search_form' onsubmit="return false" style="margin: 0;">
        <span style="display: inline-block">
            Product 
            <input type="text" name="product_id_or_name" class="easyui-validatebox" style="width: 100px"/>
            <script>
                $("#shipment_detail_product_available_search_form input[name=product_id_or_name]").keypress(function (event) {
                    if (event.which === 13) {
                        $('#shipment_detail_product_available').datagrid('reload', $('#shipment_detail_product_available_search_form').serializeObject());
                    }
                });
            </script>
        </span>
        <span style="display: inline-block">
            S.N
            <input type="text" name='serial_number' class="easyui-validatebox" style="width: 100px"/>
            <script>
                $("#shipment_detail_product_available input[name=serial_number]").keypress(function (event) {
                    if (event.which === 13) {
                        $('#shipment_detail_product_available').datagrid('reload', $('#shipment_detail_product_available_search_form').serializeObject());
                    }
                });
            </script>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="$('#shipment_detail_product_available').datagrid('reload', $('#shipment_detail_product_available_search_form').serializeObject());"></a>
        </span>
    </form>
</div>
<?php // echo 'clientid='.$client_id.' dan shipmentid='.$shipment_id   ;?>
<table id="shipment_detail_product_available" data-options="
       url:'<?php echo site_url('stock/get_available_to_shipment/'.$client_id) ?>',
       method:'post',
       border:true,
       singleSelect:false,
       fit:true,
       autoRowHeight:false,
       rownumbers:true,
       fitColumns:false,
       remoteSort:true,
       multiSort:true,
       pagination:true,
       nowrap:false,
       toolbar:'#shipment_detail_product_available_toolbar'">
    <thead>
        <tr>
            <th field="pi_chck_88" checkbox='true'></th>
            <th field="product_image" width="60" align="center" formatter="shipment_detail_product_available_image_load">Image</th>
            <!--<th field="ebako_code" width="200" halign="center" formatter="shipment_detail_product_available_detail_product">Product Detail</th>-->
            <th field="ebako_code" width="150" halign="center">Ebako Code</th>
            <th field="customer_code" width="150" halign="center">Customer Code</th>
            <th field="material" width="150" halign="center">Material</th>
            <th field="finishing" width="150" halign="center">Finishing</th>
            <th field="serial_number" width="150" halign="center">Serial Number</th>
            <th field="po_no" width="150" halign="center">Po No</th>
            <!--<th field="po_no" width="200" halign="center" formatter="shipment_detail_product_available_po_detail">History P.O</th>-->
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#shipment_detail_product_available').datagrid({
            onBeforeLoad: function (param) {
                param.client_id = <?php echo $client_id ?>;
            }
        });
    });
    function shipment_detail_product_available_image_load(value, row) {
        return '<img src="files/products_image/' + value + '" style="max-width:50px;max-height:60px;padding:1px;">';
    }

    function shipment_detail_product_available_detail_product(value, row) {
        return 'SN : ' + row.serial_number + '<br/>' +
                'Ebako COde : ' + row.ebako_code + ' <b>' 
                'Customer Code: ' + row.customer_code + '<br/>';
    }

//    function shipment_detail_product_available_po_detail(value, row) {
//        return '<b>' + row.po_no + '</b>, ' + row.client_name + '<br/>' + 'Date: ' + myFormatDate(row.po_date, null) + '<br/>';
//    }
</script>

