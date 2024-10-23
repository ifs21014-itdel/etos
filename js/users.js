/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global base_url */

function users_search() {
    $('#users').datagrid('reload', {
        id_name: $('#users_name_s').val()
    });
}

function users_add() {

    if ($('#user_dialog')) {
        $('#bodydata').append("<div id='user_dialog'></div>");
    }

    $('#user_dialog').dialog({
        title: 'ADD USER',
        width: 400,
        height: 'auto',
        href: base_url + 'users/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    $('#users_input_form').form('submit', {
                        url: base_url + 'users/save/0',
                        onSubmit: function () {
                            return $(this).form('validate');
                        },
                        success: function (content) {
                            var result = eval('(' + content + ')');
                            if (result.success) {
                                $('#users').datagrid('reload');
                                $('#user_dialog').dialog('close');
                            } else {
                                $.messager.alert('Error', result.msg, 'error');
                            }
                        }
                    });
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#user_dialog').dialog("close");
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            $('#users_input_form').form('clear');
        }
    });
}

function users_edit() {

    var row = $('#users').datagrid('getSelected');
    if (row !== null) {

        if ($('#user_dialog')) {
            $('#bodydata').append("<div id='user_dialog'></div>");
        }

        $('#user_dialog').empty();

        $('#user_dialog').dialog({
            title: 'ADD USER',
            width: 400,
            height: 'auto',
            href: base_url + 'users/input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#users_input_form').form('submit', {
                            url: base_url + 'users/save/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#users').datagrid('reload');
                                    $('#user_dialog').dialog('close');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            }
                        });
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#user_dialog').dialog("close");
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
                $('#u-password').parent().parent().remove();
                $('#u-re-password').parent().parent().remove();
                $('#users_input_form').form('load', row);
            }
        });
    } else {
        $.messager.alert('No User Selected', 'Please Select User', 'warning');
    }
}

function users_save() {
    if ($('#users-input').form('validate')) {
        var password = $('#u-password').val();
        var re_password = $('#u-re-password').val();
        if (password !== re_password) {
            $.messager.alert('Password not match', 'Please type correct password', 'error');
        } else {
            $('#users-input').form('submit', {
                url: url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (content) {
                    //            alert(content);
                    var result = eval('(' + content + ')');
                    if (result.success) {
                        $('#users-form').dialog('close');
                        $('#users').datagrid('reload');
                        $.messager.show({
                            title: 'Notification',
                            msg: 'Add new user successfull!!',
                            timeout: 5000,
                            showType: 'slide'
                        });
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }
            });
        }
    }
}

function users_change_password_by_admin(id) {
    if ($('#user_dialog')) {
        $('#bodydata').append("<div id='user_dialog'></div>");
    }

    $('#user_dialog').empty();
    $('#user_dialog').dialog({
        title: 'CHANGE PASSWORD',
        width: 350,
        height: 'auto',
        closed: false,
        cache: false,
        href: base_url + 'users/change_password',
        modal: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-ok',
                handler: function () {
                    $('#users_change_password').form('submit', {
                        url: base_url + 'users/update_password/' + id,
                        onSubmit: function () {
                            return $(this).form('validate');
                        },
                        success: function (content) {
                            var result = eval('(' + content + ')');
                            if (result.success) {
                                $('#users').datagrid('reload');
                                $('#user_dialog').dialog('close');
                            } else {
                                $.messager.alert('Error', result.msg, 'error');
                            }
                        }
                    });
                }
            }, {
                text: 'Cancel',
                iconCls: 'icon-cancel',
                handler: function () {
                    $('#user_dialog').dialog('close');
                }
            }]
    });
}

function users_disable(id) {
    $.messager.confirm('Confirm', 'Are you sure you want to disable this user?', function (r) {
        if (r) {
            $.post(base_url + 'users/disable', {
                id: id
            }, function (result) {
                if (result.success) {
                    $('#users').datagrid('reload');
                    $.messager.show({
                        title: 'Notification',
                        msg: 'User has been disabled',
                        timeout: 5000,
                        showType: 'slide'
                    });
                } else {
                    $.messager.alert('Error', result.msg, 'error');
                }
            }, 'json');
        }
    });
}

function users_enable(id) {
    $.messager.confirm('Confirm', 'Are you sure you want to enable this user?', function (r) {
        if (r) {
            $.post(base_url + 'users/enable', {
                id: id
            }, function (result) {
                if (result.success) {
                    $('#users').datagrid('reload');
                    $.messager.show({
                        title: 'Notification',
                        msg: 'User has been enable',
                        timeout: 5000,
                        showType: 'slide'
                    });
                } else {
                    $.messager.alert('Error', result.msg, 'error');
                }
            }, 'json');
        }
    });
}

function users_delete(id) {
    $.messager.confirm('Confirm', 'Are you sure you want to Delete this user?', function (r) {
        if (r) {
            $.post(base_url + 'users/delete', {
                id: id
            }, function (result) {
                if (result.success) {
                    $('#users').datagrid('reload');
                    $.messager.show({
                        title: 'Notification',
                        msg: 'User has been Deleted',
                        timeout: 5000,
                        showType: 'slide'
                    });
                } else {
                    $.messager.alert('Error', result.msg, 'error');
                }
            }, 'json');
        }
    });
}

function users_edit_privilege(id, departmentid) {

    if ($('#user_dialog')) {
        $('#bodydata').append("<div id='user_dialog'></div>");
    }
    $('#user_dialog').empty();

    $('#user_dialog').dialog({
        title: 'Edit Privilege',
        width: 600,
        height: 600,
        href: base_url + 'users/edit_privilege/' + id,
        modal: true,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#user_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
        }
    });
}

function user_privilege_click_menu(element, number_subaction) {
    var userid = $('#privilege_user_id').val();
    var menuid = $("#" + element).val();
    if ($("#" + element).is(":checked")) {
        for (var i = 0; i < number_subaction; i++) {

            $('#menuaction' + menuid + i).prop("disabled", false);
        }
        $.post(base_url + 'users/action_set_menu', {
            type: 1,
            userid: userid,
            menuid: menuid
        }, function (content) {
            console.log(content);
        });

    } else {
        for (var i = 0; i < number_subaction; i++) {
            $('#menuaction' + menuid + i).attr('checked', false);
            $('#menuaction' + menuid + i).prop("disabled", true);
        }

        $.post(base_url + 'users/action_set_menu', {
            type: 2,
            userid: userid,
            menuid: menuid
        }, function (content) {
            console.log(content);
        });
    }
}

function user_action_set(element, menuid) {
    var user_id = $('#privilege_user_id').val();
    var action = $(element).val();
    if ($(element).is(":checked")) {
        $.post(base_url + 'users/action_set', {
            type: 1,
            userid: user_id,
            menuid: menuid,
            action: action
        }, function (content) {
            console.log(content);
        });
    } else {
        $.post(base_url + 'users/action_set', {
            type: 2,
            userid: user_id,
            menuid: menuid,
            action: action
        }, function (content) {
            console.log(content);
        });
    }
}

function user_privilege_option_view(element, scriptview) {
    var user_id = $('#privilege_user_id').val();
    var action = $(element).val();

    $.post(base_url + 'users/privilege_option_view', {
        userid: user_id,
        scriptview: scriptview,
        value: action
    }, function () {

    });
}