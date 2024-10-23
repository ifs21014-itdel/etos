<div class="easyui-layout" data-options="fit:true">        
  <div region="center" border='false'>
    <?php $this->load->view('customer/list') ?>
  </div>
  <div data-options="region:'south',split:true" style="height:250px;">
    <div id="tt-model" class="easyui-tabs"  data-options="fit:true,tabHeight:23,tabPosition:'top'">
      <div id="custdetil" title='Customer Detail'>
      </div>
      <div title="Contact Person + ">
        <?php $this->load->view('customer/cp/view') ?>
      </div>
      <div title="Document List">
        <?php $this->load->view('customer/document/view') ?>
      </div>
      <div title="PO History">
        <?php //$this->load->view('customer/tender_history') ?>
      </div>
    </div>
  </div>
</div>
