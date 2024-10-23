<form id="employee_form" method="post" novalidate class="table_form">
    <table width="100%" class="table-no-border">
        <tr valign="top">
            <td width="50%" style="border: none !important">
                <fieldset class="app-fieldset" style="margin-bottom: 5px;">
                    <legend class="app-legend">Employee Information</legend>
                    <table width="100%" border="0">
                        <tr>
                            <td width="30%"><strong>Employee ID</strong></td>
                            <td width="70%"><input type='text' style="width: 100%" name='employee_id' class="easyui-textbox" required="true"/></td>
                        </tr>
                        <tr>
                            <td><strong>Employee Name</strong></td>
                            <td><input style="width: 100%" type='text' name='employee_name' class="easyui-textbox" required="true"/></td>
                        </tr>
                        <tr>
                            <td><strong>Gender</strong></td>
                            <td>
                                <select class="easyui-combobox" style="width: 50%" panelHeight="auto" editable="false" name="gender" required="true">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Birth Place</strong></td>
                            <td>
                                <input type='text' name='birth_place' style="width: 100%" class="easyui-textbox"/>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>DOB </strong></td>
                            <td>
                                <input type='text' style="width: 100px" name='dob' id='employee_new_dob' required="true" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"/>
                                <script>
                                    $('#employee_new_dob').datebox();
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Identity No </strong></td>
                            <td><input type='text' name='identity_number' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td><strong>Marital Status</strong></td>
                            <td>
                                <select class="easyui-combobox" style="width: 50%" panelHeight="auto" editable="false" name="marital_status" required="true">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dependent</strong></td>
                            <td>
                                <select name="dependent" class="easyui-combobox" editable="false" required="true" panelHeight="auto" style="width: 50%">
                                    <option value="0">TK/0</option>
                                    <option value="1">K/0</option>
                                    <option value="2">K/1</option>
                                    <option value="3">K/2</option>
                                    <option value="4">K/3</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Address</strong></td>
                            <td><input style="width: 100%;height: 50px" multiline="true" name='address' class="easyui-textbox"></td>
                        </tr>
                        <tr>
                            <td><strong>City</strong></td>
                            <td><input type='text' name='city' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td><strong>State</strong></td>
                            <td><input type='text' name='state' id='state' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td><strong>Zip Code</strong></td>
                            <td><input type='text' name='zip_code' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td><strong>Country</strong></td>
                            <td><input type='text' name='country' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td><strong>Phone Number</strong></td>
                            <td><input type='text' name='phone_number' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td><strong>E-mail</strong></td>
                            <td><input type='text' name='email' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td><strong>Last Education</strong></td>
                            <td>
                                <select name="education" editable="false"  class="easyui-combobox" style="width: 40%" panelHeight="auto">
                                    <option value="S2">S2</option>
                                    <option value="S1">S1</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SD">SD</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </td>
            <td width="50%" style="border: none !important">
                <fieldset class="app-fieldset" style="margin-bottom: 5px;">
                    <legend class="app-legend">Employment Information</legend>
                    <table width="100%" border="0">
                        <tr>
                            <td width="30%"><strong>Employment Status</strong></td>
                            <td width="70%">
                                <select name="status" class="easyui-combobox" style="width: 50%" panelHeight="auto"  editable="false" required="true">
                                    <option value="1">Permanent</option>
                                    <option value="2">Contract</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Start Date</strong></td>
                            <td><input type='text' style="width: 120px" name='start_date' required="true" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"/></td>
                        </tr>
                        <tr>
                            <td><strong>End Date </strong></td>
                            <td><input type='text' style="width: 120px" name='end_date' class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"/></td>
                        </tr>
                        <tr>
                            <td><strong>Department</strong></td>
                            <td>
                                <input style="width: 70%" panelWidth="250" class="easyui-combobox" name="department_id" required="true"
                                       data-options="valueField:'id',textField:'name',url:'<?php echo site_url('resource/department/get') ?>'" mode="remote">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Job Title</strong></td>
                            <td>
                                <input style="width: 70%" class="easyui-combobox" panelWidth="250" name="job_title_id" required="true"
                                       data-options="valueField:'id',textField:'name',url:'<?php echo site_url('resource/job_title/get') ?>'" mode="remote">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Basic Salary</strong></td>
                            <td><input type='text' name='basic_salary' class="easyui-numberbox" decimalSeparator="." groupSeparator="," style="width: 100%"/></td>
                        </tr>
                    </table>
                </fieldset>

                <fieldset class="app-fieldset" style="margin-bottom: 5px;">
                    <legend class="app-legend">Bank Information</legend>
                    <table width="100%" border="0">
                        <tr>
                            <td width="30%"><strong>Bank Name</strong></td>
                            <td width="70%">
                                <select name="bank_id" class="easyui-combobox" style="width: 50%" panelHeight="auto"  editable="false" required="true">
                                    <option value="1">BRI</option>
                                    <option value="2">Mandiri</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Bank Branch</strong></td>
                            <td><input type='text' name='bank_branch' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td><strong>Account Number</strong></td>
                            <td><input type='text' name='bank_account_no' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                        <tr>
                            <td><strong>Account Holder</strong></td>
                            <td><input type='text' name='bank_account_holder' class="easyui-textbox" style="width: 100%"/></td>
                        </tr>
                    </table>
                </fieldset>

                <fieldset class="app-fieldset" style="margin-bottom: 5px;">
                    <legend class="app-legend">Insurance Information</legend>
                    <table width="100%" border="0">
                        <tr>
                            <td width="30%"><strong>Jamsostek No.</strong></td>
                            <td width="70%">
                                <input type='text' name='jamsostek_no' id='npwp' class="easyui-validatebox" style="width: 100%"/>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>BPJS Kesehatan No.</strong></td>
                            <td><input type='text' name='bpjs_kesehatan_number' id='npwp' class="easyui-validatebox" style="width: 150px"/></td>
                        </tr>
                        <tr>
                            <td><strong>Kelas BPJS</strong></td>
                            <td>
                                <select name="kelas_bpjs" editable="false"  class="easyui-combobox" style="width: 50%" panelHeight="auto">
                                    <option value=''></option>
                                    <option value='III'>III</option>
                                    <option value='II'>II</option>
                                    <option value='I'>I</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </td>
        </tr>
    </table>
</form>