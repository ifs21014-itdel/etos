<form id="users_change_password" method="post" novalidate class="table_form">
    <table width="100%" border="0">
        <tr>
            <td width="25%"><strong>Password</strong></td>
            <td width="75%"><input type="password" style="width: 98%" name="password" id="u-newpassword" class="easyui-validatebox" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Re-Password</strong></td>
            <td><input type="password" name="re-newpassword" style="width: 98%" id="u-re-newpassword" validType="equals['#u-newpassword']" class="easyui-validatebox" required="true"/></td>
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