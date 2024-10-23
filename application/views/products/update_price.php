<div style="padding: 1px;">
    <form id="products_update_price_form" method="post" novalidate enctype="multipart/form-data" class="table_form">
        <table width="100%" border="0">
<!--            <tr>
                <td><strong>Rnd Code</strong></td>
                <td>
                    <input type="text"
                           autocomplete="off"
                           name="rnd_code"
                           readonly=""
                           class="easyui-textbox" required="true" style="width: 100%"/>
                </td>
            </tr>-->
            <tr>
                <td width="25%"><strong>Code</strong></td>
                <td width="75%"><input type="text" autocomplete="off" name="code" readonly="" class="easyui-textbox" required="true" style="width: 100%"/></td>
            </tr>
            <tr>
                <td><strong>Name</strong></td>
                <td><input type="text" autocomplete="off" name="name" readonly="" class="easyui-textbox" required="true" style="width: 100%" /></td>
            </tr>

            <tr>
                <td><strong>Materials</strong></td>
                <td>
                    <input class="easyui-combobox"
                           name="material_id[]"
                           id="material_id"
                           multiple="true"
                           url="<?php echo site_url('materials/get') ?>"
                           method="post"
                           valueField="id"
                           textField="code"
                           data-options="formatter: ProductMaterialFormat"
                           style="width: 100%"
                           readonly=""/>
                    <script type="text/javascript">
                        function ProductMaterialFormat(row) {
                            return '<span style="font-weight:bold;">' + row.code + '</span><br/>' +
                                    '<span style="color:#888">Desc: ' + row.description + '</span>';
                        }
                    </script>
                </td>
            </tr>
            <tr>
                <td><strong>MSRP COM</strong></td>
                <td>
                    <input type="text" autocomplete="off" name="price" class="easyui-textbox easyui-numberbox" style="width: 50%" min="0" precision="3" decimalSeparator="." groupSeparator=","/>
                </td>
            </tr>
            <tr>
                <td><strong>MSRP HOUSE</strong></td>
                <td>
                    <input type="text" autocomplete="off" name="price_house" class="easyui-textbox easyui-numberbox" style="width: 50%" min="0" precision="3" decimalSeparator="." groupSeparator=","/>
                </td>
            </tr>
            <tr>
                <td><strong>MSRP DESIGNER</strong></td>
                <td>
                    <input type="text" autocomplete="off" name="price_designer" class="easyui-textbox easyui-numberbox" style="width: 50%" min="0" precision="3" decimalSeparator="." groupSeparator=","/>
                </td>
            </tr>
            <tr>
                <td><strong>Currency</strong></td>
                <td>
                    <input class="easyui-combobox"  name="currency_id" data-options="
                           url: '<?php echo site_url('currency/get') ?>',
                           method: 'post',
                           valueField: 'id',
                           textField: 'code',
                           panelHeight: 'auto'"
                           style="width: 50%"
                           required="true">
                </td>
            </tr>
        </table>
    </form>
</div>