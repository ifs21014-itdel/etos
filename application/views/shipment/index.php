<div class="easyui-layout" fit="true">
    <div region="north" 
         title="Packing List"
         style="height:40%;"
         split="true"
         href="<?php echo site_url('shipment/view') ?>">
    </div>
    <div region="center">
        <div id="shipment-tab" class="easyui-tabs" fit="true" tabHeight="20" border="false">
            <div title="Product Detail" href="<?php echo site_url('shipment/detail_view') ?>"></div>
            <div title="Summarize" href="<?php echo site_url('shipment/summarize_view') ?>" data-options="onLoad:function(){var row = $('#shipment').datagrid('getSelected');if(row !== null){$('#shipment_summarize').datagrid('reload', {shipmentid: row.id});}}"></div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>js/shipment.js"></script>
