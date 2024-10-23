<div id="vendor_toolbar" style="padding-bottom: 0px;">
    <form id="vendor_search_form" style="margin-bottom: 0px" onsubmit="vendor_search();
            return false;">
        <span style="display: inline-block;">
            Search
            <input type="text" 
                   name="q"
                   class="easyui-validatebox"
                   /> 
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-search" onclick="vendor_search()">Find</a>
        </span>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-add" onclick="vendor_add()">Add</a> 
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-edit" onclick="vendor_edit()">Edit</a> 
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-remove" onclick="vendor_delete()">Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="vendor" data-options="
       url:'<?php echo site_url('vendor/get') ?>',
       method:'post',
       border:true,
       title:'Vendor',
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       autoRowHeight:true,
       toolbar:'#vendor_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="code" width="50" halign="center">Code</th>
            <th field="name" width="150" halign="center">Name</th>
            <th field="address" width="200" halign="center">Address</th> 
            <th field="vendor_type" width="100" halign="center">Type</th>
            <th field="currency_code" width="60" align="center">Currency</th>
            <th field="country" width="100" halign="center">Country</th>
            <th field="state" width="50" align="center">State</th>
            <th field="city" width="100" halign="center">City</th>
            <th field="email" width="150" halign="center">Email</th>
            <th field="phone" width="120" halign="center">Phone</th>
            <th field="fax" width="120" halign="center">Fax</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#vendor').datagrid();
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/vendor.js"></script>

