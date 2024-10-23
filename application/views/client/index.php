<div id="client_toolbar" style="padding-bottom: 0px;">
    <form id="client_search_form" style="margin: 0px" onsubmit="client_search();
            return false;">
        <span style="display: inline-block;">
            Search
            <input type="text" 
                   name="q"
                   class="easyui-validatebox"
                   /> 
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-search" onclick="client_search()">Find</a>
        </span>
        <?php
        if (in_array("Add", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-add" onclick="client_add()">Add</a> 
            <?php
        }if (in_array("Edit", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-edit" onclick="client_edit()">Edit</a> 
            <?php
        }if (in_array("Delete", $action)) {
            ?>
            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-remove" onclick="client_delete()">Delete</a>
            <?php
        }
        ?>
    </form>
</div>
<table id="client" data-options="
       url:'<?php echo site_url('client/get') ?>',
       method:'post',
       border:true,
       title:'Client',
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       clientPaging: false,
       remoteFilter: true,
       striped:true,
       autoRowHeight:true,
       toolbar:'#client_toolbar'">
    <thead>
        <tr>
            <th field="id" hidden="true"></th>
            <th field="code" halign="center" data-options="editor:'textbox'">Code</th>
            <th field="name" halign="center" data-options="editor:'textbox'">Name</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $('#client').datagrid({
        onDblClickRow: function (rowIndex, row) {
            client_edit();
        }
    });

    var dg_client = $('#client').datagrid();
    dg_client.datagrid('enableFilter', [{
            options: {
                panelHeight: 'auto',
                data: [{value: '', text: 'All'}, {value: 'P', text: 'P'}, {value: 'N', text: 'N'}],
                onChange: function (value) {
                    if (value == '') {
                        dg_client.datagrid('removeFilterRule', 'status');
                    } else {
                        dg_client.datagrid('addFilterRule', {
                            field: 'status',
                            op: 'equal',
                            value: value
                        });
                    }
                    dg_client.datagrid('doFilter');
                }
            }
        }]);
</script>
</div>


<script type="text/javascript" src="<?php echo base_url() ?>js/client.js"></script>