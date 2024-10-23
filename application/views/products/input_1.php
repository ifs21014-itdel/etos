<div style="padding: 1px;">
    <form id="products_input_form" method="post" novalidate enctype="multipart/form-data" class="table_form">
        <table width="100%" border="0">
            <tr>
                <td width="25%"><strong>RND Code</strong></td>
                <td width="75%">
                    <input type="text" 
                           autocomplete="off" 
                           name="rnd_code" 
                           class="easyui-validatebox" required="true" style="width: 80%"/></td>
            </tr>
            <tr>
                <td><strong>Code</strong></td>
                <td><input type="text" autocomplete="off" name="code" class="easyui-validatebox" required="true" style="width: 80%"/></td>
            </tr>
            <tr>
                <td><strong>Name</strong></td>
                <td><input type="text" autocomplete="off" name="name" class="easyui-textbox" required="true" style="width: 100%" /></td>
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
                           style="width: 80%" 
                           required="true"/>
                    <script type="text/javascript">
                        function ProductMaterialFormat(row) {
                            return '<span style="font-weight:bold;">' + row.code + '</span><br/>' +
                                    '<span style="color:#888">Desc: ' + row.description + '</span>';
                        }
                    </script>
                </td>
            </tr>
<!--            <tr>
                <td><strong>Fabric</strong></td>
                <td>
                    <input class="easyui-combobox" id="prd_fab_id" name="fabric_id" data-options="
                           url: '<?php echo site_url('fabric/get') ?>',
                           method: 'post',
                           valueField: 'id',
                           textField: 'description',
                           panelHeight: '200',
                           formatter: ProductFabricFormat,
                           onSelect:function(row){
                           $('#prd_comp_code').val(row.code);
                           $('#prd_comp_desc').val(row.description);
                           }"
                           style="width: 80%"
                           mode="remote"
                           ><a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fabric_add()"></a>
                    <script type="text/javascript">
                        function ProductFabricFormat(row){
                            return '<span style="font-weight:bold;">' + row.code +'</span><br/>' +
                                '<span style="color:#888">Desc: ' + row.description + 
                                '<br/>Vendor: '+row.vendor_name+'('+row.vendor_code+')'+
                                '<br/>Price: '+row.currency_code+' '+formatPrice(row.price,null)+'</span>';
                        }
                    </script>
                    <strong>COM</strong><input type="text" class="easyui-numberbox" name=""
                </td>
            </tr>-->
            <tr>
                <td><strong>Type</strong></td>
                <td>
                    <input class="easyui-combobox" 
                           name="product_type_id"
                           style="width: 200px"
                           panelHeight="200"
                           required="true"
                           url="<?php echo site_url('product_type/get') ?>"
                           method="post"
                           valueField="id"
                           textField="code"
                           data-options="formatter: ProductTypeFormat" />
                    <script type="text/javascript">
                        function ProductTypeFormat(row) {
                            return '<span style="font-weight:bold">' + row.code + '</span><br/>' +
                                    '<span style="color:#888">Desc: ' + row.description + '</span>';
                        }
                    </script>
                </td>
            </tr>

            <tr>
                <td><strong>Dimension (W x D x H)</strong></td>
                <td>
                    <input type="text" autocomplete="off" placeholder="Width" name="width" class="easyui-numberbox" size="9" style="text-align: center;width: 50px" required="true"/>
                    <strong style="padding-right: 10px">x</strong>
                    <input type="text" autocomplete="off" placeholder="Depth" name="depth" class="easyui-numberbox" size="9" style="text-align: center;width: 50px"  required="true"/>
                    <strong style="padding-right: 10px">x</strong>
                    <input type="text" autocomplete="off" placeholder="Height" name="height" class="easyui-numberbox" size="9" style="text-align: center;width: 50px" />
                </td>
            </tr>
            <tr>
                <td><strong>Weight (Gross x Nett)</strong></td>
                <td>
                    <input type="text" autocomplete="off" name="gross" class="easyui-numberbox" size="9" style="text-align: center;width: 50px"/>
                    <strong style="padding-right: 10px">x</strong>
                    <input type="text" autocomplete="off" name="nett" class="easyui-numberbox" size="9" style="text-align: center;width: 50px" />
                </td>
            </tr>
            <tr>
                <td><strong>MSRP (USD)</strong></td>
                <td>
                    <input type="text" autocomplete="off" name="price" class="easyui-numberbox" style="width: 120px" min="0" precision="3" decimalSeparator="." groupSeparator=","/>
                </td>
            </tr>
            <tr id="product_tr_component">
                <td><strong>Base / Base+Top <br/>&nbsp;&nbsp;(Vendor)</strong></td>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong><i>Type</i></strong></td>
                            <td>
                                <select name="component_type_id" required="true" class="easyui-combobox" panelHeight="auto" style="width: 100px">
                                    <option value="1">BASE</option>
                                    <option value="2">BASE+TOP</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%"><strong><i>Vendor</i></strong></td>
                            <td width="80%">
                                <input class="easyui-combobox" name="base_vendor_id" data-options="
                                       url: '<?php echo site_url('vendor/get') ?>',
                                       method: 'post',
                                       valueField: 'id',
                                       textField: 'name',
                                       panelHeight: '200',
                                       onSelect:function(row){
                                       $('#base_vendor_currency_id').combobox('setValue',row.currency_id);
                                       },
                                       formatter: ProductVendorFormat"
                                       style="width: 100%" 
                                       mode="remote">
                                <script type="text/javascript">
                                    function ProductVendorFormat(row) {
                                        return '<span style="font-weight:bold;">' + row.name + ' (' + row.code + ')</span><br/>' +
                                                '<span style="color:#888">Desc: ' + row.address + '</span>';
                                    }
                                </script> 
                            </td>
                        </tr>
                        <tr>
                            <td><strong><i>Vendor Code</i></strong></td>
                            <td><input type="text" autocomplete="off" name="base_vendor_product_code" class="easyui-validatebox" style="width: 98%"/></td>
                        </tr>
                        <tr valign="top">
                            <td><strong><i>Price</i></strong></td>
                            <td>
                                <input type="text" 
                                       autocomplete="off" 
                                       name="base_vendor_product_price" 
                                       class="easyui-numberbox" size="10" 
                                       min="0" 
                                       min="0" precision="3" decimalSeparator="." groupSeparator=","
                                       style="width: 200px" />
                                <input class="easyui-combobox"  name="base_vendor_currency_id" id="base_vendor_currency_id" data-options="
                                       url: '<?php echo site_url('currency/get') ?>',
                                       method: 'post',
                                       valueField: 'id',
                                       textField: 'code',
                                       panelHeight: 'auto'">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><strong>Description</strong></td>
                <td>
                    <textarea name="description" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
            <tr>
                <td><strong>Image</strong></td>
                <td>                   
                    <input class="easyui-filebox" name="product_image" data-options="prompt:'Choose a file...'" style="width:100%">                    
                </td>
            </tr>
        </table>
    </form>
</div>