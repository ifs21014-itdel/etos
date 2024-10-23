/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */


function client_search(){
    $('#client').datagrid('reload',$('#client_search_form').serializeObject());
}

function client_add() {
    $('#global_dialog').dialog({
        title: 'New Client',
        width: 500,
        height: 'auto',
        href: base_url + 'client/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
            text: 'Save',
            iconCls: 'icon-save',
            handler: function () {
                client_save();
            }
        }, {
            text: 'Close',
            iconCls: 'icon-remove',
            handler: function () {
                $('#global_dialog').dialog('close');
            }
        }],
        onLoad: function () {
            $('#client_input_form').form('clear');
        }
    });
    url = base_url + 'client/save/0';
}

function client_edit() {
    var row = $('#client').datagrid('getSelected');
    if (row !== null) {
        $('#global_dialog').dialog({
            title: 'Edit Client',
            width: 500,
            height: 'auto',
            href: base_url + 'client/input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    client_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#global_dialog').dialog('close');
                }
            }],
            onLoad: function () {
                $('#client_input_form').form('load', row);
            }
        });
        url = base_url + 'client/save/' + row.id;
    } else {
        $.messager.alert('No Client Selected', 'Please Select Client', 'warning');
    }
}

function client_save() {
    $('#client_input_form').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#client').datagrid('reload');
                $('#global_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function client_delete() {
    var row = $('#client').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data', function (r) {
            if (r) {
                $.post(base_url + 'client/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#client').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Client Selected', 'Please Select Client', 'warning');
    }
}