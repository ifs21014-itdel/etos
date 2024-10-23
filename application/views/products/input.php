<div style="padding: 1px;">
    <!--<form id="products_input_form" method="post" novalidate enctype="multipart/form-data" class="table_form">-->
    <form id="products_input_form" method="post" novalidate class="table_form" enctype="multipart/form-data" >
        <table width="100%" border="0">

            <tr>
                <td><strong>Client</strong></td>
                <td>
                    <input class="easyui-combobox" 
                           id="po_client_id"
                           name="client_id"
                           url="<?php echo site_url('client/get') ?>"
                           method="post"
                           mode="remote"
                           valueField="id"
                           textField="name"
                           data-options="formatter: PI_Client_Format2"
                           style="width: 100%" 
                           required="true"/>
                    <script type="text/javascript">
                        function PI_Client_Format2(row) {
                            return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span>';
                        }
                    </script>
                </td>
            </tr>
            <tr>
                <td><strong>Ebako Code</strong></td>
                <td><input name="ebako_code"  class="easyui-validatebox" style="width: 98%;"/></td>
            </tr>    
            <tr>
                <td><strong>Cust Code</strong></td>
                <td><input name="customer_code"  class="easyui-validatebox" style="width: 98%;"/></td>
            </tr>    
            <tr>
                <td><strong>Materials</strong></td>
                <td>
                    <textarea name="material" class="easyui-validatebox" style="width: 98%;height: 40px"></textarea>
                </td>
            </tr>
<!--            <tr>
                <td><strong>Finishing</strong></td>
                <td>
                    <textarea name="finishing" class="easyui-validatebox" style="width: 98%;height: 40px"></textarea>
                </td>
            </tr> -->
            <tr>
                <td><strong>Packing Configuration</strong></td>
                <td>
                    <input type="text" name="packing_configuration" id="packing_configuration_id" class="easyui-textbox easyui-numberbox" style="width: 50px;text-align: center;" required='true'/> (qty box per item)
                </td>
            </tr> 
            <tr>
                <td><strong>Description</strong></td>
                <td>
                    <textarea name="description" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
            <tr>
                <td><strong>Remark</strong></td>
                <td>
                    <textarea name="remarks" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
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