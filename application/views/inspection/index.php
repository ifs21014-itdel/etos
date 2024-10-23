<div class="easyui-layout" fit="true">
    <div region="center" 
         title="Inspection Detail" 
         href="<?php echo site_url('inspection/inspection_detail') ?>">
    </div>
    <div region="north" 
         title="Inspection List"
         style="height: 50%" 
         split="true"
         href="<?php echo site_url('inspection/view') ?>">
    </div>

</div>
<script type="text/javascript" src="<?php echo base_url() ?>js/inspection.js"></script>