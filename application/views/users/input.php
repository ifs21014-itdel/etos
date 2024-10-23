<form id="users_input_form" onsubmit="return false;" class="table_form" method="POST" novalidate="true">
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr valign="top">
            <td width="25%"><strong>Name</strong></td>
            <td width="75%">
                <input type="text" name="name" class="easyui-validatebox" style="width: 98%;" required="true" autocomplete="Off"/>
            </td>
        </tr>
        <tr>
            <td><strong>User Name</strong></td>
            <td><input type="text" name="user_name" style="width: 98%;" required="true" class="easyui-validatebox"/></td>
        </tr>
        <tr>
            <td><strong>Email</strong></td>
            <td><input type="text" name="email" style="width: 98%;" required="true" data-options="validType:'email'" class="easyui-validatebox"/></td>
        </tr>
        <tr>
            <td><strong>Phone No</strong></td>
            <td><input type="text" name="phone_no" style="width: 98%;" required="true" class="easyui-validatebox"/></td>
        </tr>
        <tr>
            <td><strong>Password</strong></td>
            <td><input type="password" name="password" style="width: 98%;" id="u-password" class="easyui-validatebox" required="true" value=""/></td>
        </tr>
        <tr>
            <td><strong>Re-Password</strong></td>
            <td><input type="password" name="re-password" style="width: 98%;" validType="equals['#u-password']" id="u-re-password" class="easyui-validatebox" required="true"/></td>
        </tr>
    </table>
</form>
<script>
    $.extend($.fn.validatebox.defaults.rules, {
        equals: {
            validator: function (value, param) {
                return value === $(param[0]).val();
            },
            message: 'Field do not match.'
        }
    });
</script>