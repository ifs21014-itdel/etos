<div style="padding: 1px;">
    <!--<form id="protocol_test_input_form" method="post" novalidate enctype="multipart/form-data" class="table_form">-->
    <form id="protocol_test_input_form" method="post" novalidate class="table_form" enctype="multipart/form-data" >
        <table width="100%" border="0">

            <tr>
                <td><strong>Client</strong></td>
                <td>
                    <input class="easyui-combobox" 
                           id="protocol_client_id"
                           name="client_id"
                           url="<?php echo site_url('client/get') ?>"
                           method="post"
                           mode="remote"
                           valueField="id"
                           textField="name"
                           data-options="formatter: protocol_client_id_format"
                           style="width: 100%" 
                          />
                    <script type="text/javascript">
                        function protocol_client_id_format(row) {
                            return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span>';
                        }
                    </script>
                </td>
            </tr>
            <tr>
                <td><strong>Test Name</strong></td>
                <td><input name="test_name"  class="easyui-validatebox" style="width: 98%;"/></td>
            </tr>    
            <tr>
                <td><strong>Protocol Name</strong></td>
                <td><input name="protocol_name"  class="easyui-validatebox" style="width: 98%;"/></td>
            </tr>    
            <tr>
                <td><strong>Description</strong></td>
                <td>
                    <textarea name="description" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
        </table>
    </form>
</div>