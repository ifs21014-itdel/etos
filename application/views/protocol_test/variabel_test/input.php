<div style="width: 99%;padding: 2px;">
    <form id="protocol_test_variabel_test_input" method="post" novalidate enctype="multipart/form-data">
        <table width="100%" border="0" class="table_form">
            <tr>
                <td width="35%"><strong>Evaluation</strong></td>
                <td width="75%">
                    <textarea name="evaluation" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
            <tr>
                <td width="35%"><strong>Method</strong></td>
                <td width="75%">
                    <textarea name="method" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
            <tr>
                <td width="35%"><strong>Description</strong></td>
                <td width="75%">
                    <textarea name="description" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
            <tr>
                <td><strong>Data Type</strong></td>
                <td>
                    <select name="var_type" required="ture">
                        <option value="Description">Descripion</option>
                        <option value="Photo">Photo </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Mandatory?</strong></td>
                <td>
                    <select name="mandatory"  required="ture">
                        <option value="t">Yes</option>
                        <option value="f">No</option>
                    </select>
                </td>
            </tr>
        </table>        
    </form>
</div>