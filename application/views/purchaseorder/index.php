<div class="easyui-layout" fit="true">
    <div region="east" 
         style="width: 450px" 
         title="Serial Number Detail" 
         href="<?php echo site_url('purchaseorder/get_serial_number') ?>">
    </div>
    <div region="center">
        <div class="easyui-layout" fit="true">
            <div region="north" 
                 title="Purchase Order"
                 style="height:50%;"
                 split="true"
                 href="<?php echo site_url('purchaseorder/view') ?>">
            </div>
            <div region="center" 
                 title="Product Detail" 
                 href="<?php echo site_url('purchaseorder/product_view') ?>">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>js/purchaseorder.js"></script>