<form id="employee_form" method="post" novalidate class="table_form">
    <table width="100%" class="table-no-border">
        <tr>
            <td width="50%">
                <fieldset class="app-fieldset" style="margin-bottom: 5px;">
                    <legend class="app-legend">Employee Information</legend>
                    <table width="100%" border="0">
                        <tr>
                            <td width="30%"><strong>Employee ID</strong></td>
                            <td width="65%"><input type="text" name='employee_id' class="easyui-validatebox" required="true" style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>First Name</strong></td>
                            <td width="65%"><input type="text" name='first_name' class="easyui-validatebox" required="true" style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>Middle Name</strong></td>
                            <td width="65%"><input type="text" name='middle_name' class="easyui-validatebox"  style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>Department</strong></td>
                            <td width="65%">
                                <input class="easyui-combobox" name="department_id"
                                       data-options="
                                       url: '<?php echo site_url('resource/employee/departmentlist') ?>',
                                       method: 'post',
                                       valueField: 'id',
                                       textField: 'name',
                                       panelHeight: '200'"
                                       style="width: 80%"
                                       required="true"
                                       mode="remote"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>ID No.</strong></td>
                            <td width="65%"><input type="text" name='social_security_number' class="easyui-validatebox" required="true" style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>Name in Company</strong></td>
                            <td width="65%"><input type="text" name='name_in_company' class="easyui-validatebox" required="true" style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td><strong>Address 01</strong></td>
                            <td><textarea type="text" name='address_01' class="easyui-validatebox" style="width: 98%;height: 60px"></textarea> </td>
                        </tr>
                        <tr>
                            <td><strong>Address 02</strong></td>
                            <td><textarea type="text" name='address_02' class="easyui-validatebox" style="width: 98%;height: 60px"></textarea> </td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>City</strong></td>
                            <td width="65%"><input type="text" name='city' class="easyui-validatebox" required="true" style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>State</strong></td>
                            <td width="65%"><input type="text" name='state' class="easyui-validatebox" style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>Zip Code</strong></td>
                            <td width="65%"><input type="text" name='zip_code' class="easyui-validatebox"  style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>Telephone</strong></td>
                            <td width="65%"><input type="text" name='telephone' class="easyui-validatebox"  style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>Mobile Phone</strong></td>
                            <td width="65%"><input type="text" name='mobilephone' class="easyui-validatebox" style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td width="35%"><strong>Email</strong></td>
                            <td width="65%"><input type="text" name='email' class="easyui-validatebox" style="width: 98%"/></td>
                        </tr>
                        <tr>
                            <td><strong>Is Active</strong></td>
                            <td>
                                <input type="checkbox" class="easyui-checkbox" name="active" checked="true"  />&nbsp; Yes, Active
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </td>
            <td width="50%"></td>
        </tr>
    </table>
</form>