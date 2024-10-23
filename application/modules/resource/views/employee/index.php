<div id="employee_toolbar" style="padding-bottom: 2px;">
    <form id="employee_search_form" onsubmit="return false;">
        Name
        <input type="text"
               size="20"
               class="easyui-validatebox"
               name="q"
               onkeypress="if (event.keyCode === 13) {
                           employee_search();
                       }" />
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="employee_search()">Search</a>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="employee_add()">Add</a>
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="employee_edit()"> Edit</a>
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="employee_delete()"> Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="employee"
       url="<?php echo site_url('resource/employee/get') ?>"
       title="Employee"
       method="post"
       fit="true"
       singleSelect="true"
       pageSize="30"
       pageList="[30, 50, 70, 90, 110]"
       rownumbers="true"
       fitColumns="false"
       pagination="true"
       toolbar="#employee_toolbar"
       striped="true"
       multiSort="true"
       idField="id"
       remoteFilter="true"
       showFilterBar="true"
       filterBtnIconCls="icon-filter">
    <thead data-options="frozen:true">
        <tr>
            <th field="employee_id" halign="center" width="100">Employee ID</th>
            <th field="employee_name" halign="center" width="120">Employee Name</th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th field="dob" halign="center" width="100" align="center" formatter="myFormatDate">DoB</th>
            <th field="birth_place" halign="center" width="100">Birth Place</th>
            <th field="gender" halign="center" width="100" align="center">Gender</th>
            <th field="identity_number" halign="center" width="100">Identity No</th>
            <th field="marital_status" halign="center" width="100" align="center">Marital Status</th>
            <th field="dependent" halign="center" width="80" align="center">Dependent</th>
            <th field="address" halign="center" width="180">Address</th>
            <th field="status" halign="center" width="100" align="center">Status</th>
            <th field="start_date" halign="center" width="100" align="center" formatter="myFormatDate">Start Date</th>
            <th field="end_date" halign="center" width="100" align="center" formatter="myFormatDate">End Date</th>
            <th field="department_name" halign="center" width="100" halign="center">Department</th>
            <th field="job_title_name" halign="center" width="100" halign="center">Job Title</th>
            <th field="basic_salary" halign="center" width="120" align="right" formatter="formatPrice">Basic Salary</th>
            <th field="bank_name" halign="center" width="100" halign="center">Bank Name</th>
            <th field="bank_branch" halign="center" width="100" halign="center">Bank Branch</th>
            <th field="bank_account_no" halign="center" width="120" halign="center">Bank Account Number</th>
            <th field="bank_account_holder" halign="center" width="120" halign="center">Bank Account Holder</th>
            <th field="jamsostek_no" halign="center" width="100" halign="center">Jamsostek No</th>
            <th field="bpjs_kesehatan_number" halign="center" width="120" halign="center">BPJS Kesehatan No.</th>
            <th field="kelas_bpjs" halign="center" width="100" align="center">Kelas BPJS</th>
        </tr>
    </thead>
</table>
<script color="text/javascript">
    $(function () {
        $('#employee').datagrid({
            onDblClickRow: function (rowIndex, row) {
                employee_edit();
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url() ?>js/resource/employee.js"></script>