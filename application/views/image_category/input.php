<form id="image_category_input_form" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="25%"><strong>View Position</strong></td>
            <td width="75%"><input type="text" name='view_position' class="easyui-validatebox" autocomplete="Off" required="true" style="width: 98%"/></td>
        </tr>
        <tr>
            <td><strong>Description</strong></td>
            <td><input type="text" name='description' class="easyui-validatebox" style="width: 98%"/></td>
        </tr>
        <tr>
            <td><strong>Mandatory?</strong></td>
            <td>
                <select name="mandatory">
                <option value="t">Yes</option>
                <option value="f">No</option>
                </select>
            </td>
        </tr>
    </table>        
</form>