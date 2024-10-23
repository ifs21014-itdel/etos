<div style="width: 99%;padding: 2px;">
    <form id="products_box_input" method="post" novalidate enctype="multipart/form-data">
        <table width="100%" border="0" class="table_form">
            <tr>
                <td width="35%"><strong>Dimension (W x D x H)</strong></td>
                <td width="75%">
                    W<input type="text" autocomplete="off" name="depth" class="easyui-numberbox" style="text-align: center;width: 20%" /> 
                    D<input type="text" autocomplete="off" name="width" class="easyui-numberbox" style="text-align: center;width: 20%"/>
                    H<input type="text" autocomplete="off" name="height" class="easyui-numberbox" style="text-align: center;width: 20%" />
                </td>
            </tr>
            <tr>
                <td width="35%"><strong>Code</strong></td>
                <td width="75%">
                    <input type="text" autocomplete="off" name="code"style="text-align: center;width: 20%" /> 
                </td>
            </tr>
            <tr>
                <td width="35%"><strong>Description</strong></td>
                <td width="75%">
                    <textarea name="description" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
        </table>        
    </form>
</div>