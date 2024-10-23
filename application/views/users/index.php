<div id="users_toolbar" style="padding-bottom: 0;">      
    Search : <input type="text" size="12" class="easyui-validatebox" id="users_name_s" onkeypress="if (event.keyCode === 13) {
                users_search();
            }"/>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="users_search()">Find</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="users_add()">Add</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="users_edit()">Edit</a>
</div>
<table id="users" data-options="
       url:'<?php echo site_url('users/get') ?>',
       method:'post',
       border:true,
       title:'Users',
       singleSelect:true,
       fit:true,
       pageSize:30,
       pageList: [30, 50, 70, 90, 110],
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       sortName:'id',
       sortOrder:'desc',
       toolbar:'#users_toolbar'">
    <thead>
        <tr>                       
            <!--<th field="id" width="100" halign="center" sortable="true">ID</th>-->
            <th field="name" width="150" halign="center" sortable="true">Name</th>
            <th field="user_name" width="150" halign="center" sortable="true">User Name</th>
            <th field="email" width="150" halign="center" sortable="true">Email</th>
            <th field="phone_no" width="200" halign="center" sortable="true">Phone No</th>
            <th field="action" width="500" formatter="users_action">Action</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#users').datagrid()
    });
    function users_action(value, row, index) {
        var reference = "<a href=javascript:void(0) class='remove' onclick=users_delete('" + row.id + "')>Delete</a>&nbsp;&nbsp;|&nbsp;&nbsp;";

        if (row.enable === 't') {
            reference = reference + "<a href=javascript:void(0) class='disable' onclick=users_disable('" + row.id + "')>Disable</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
        } else {
            reference = reference + "<a href=javascript:void(0) class='enable' onclick=users_enable('" + row.id + "')>Enable</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
        }

        reference = reference + "<a href=javascript:void(0) class='change-password' onclick=users_change_password_by_admin('" + row.id + "')>Change Password</a>&nbsp;&nbsp;|&nbsp;&nbsp;" +
                "<a href=javascript:void(0) class='privilege' onclick=users_edit_privilege('" + row.id + "'," + row.departmentid + ")>Edit Privilege</a>";
        return reference;
    }
</script>
<script src="<?php echo base_url() ?>js/users.js"></script>