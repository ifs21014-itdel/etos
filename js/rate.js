/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var rate_url = '';

function rate_input_form(type, title, row) {
    if ($('#rate_dialog')) {
        $('#bodydata').append("<div id='rate_dialog'></div>");
    }

    $('#rate_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'rate/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    rate_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#rate_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#rate_input_form').form('load', row);
            } else {
                $('#rate_input_form').form('clear');
            }
        }
    });
}

function rate_add() {
    rate_input_form('add', 'ADD RATE', null);
    rate_url = base_url + 'rate/save/0';
}

function rate_edit() {
    var row = $('#rate').datagrid('getSelected');
    if (row !== null) {
        rate_input_form('edit', 'EDIT RATE', row);
        rate_url = base_url + 'rate/save/' + row.id;
    } else {
        $.messager.alert('No Rate Selected', 'Please Select Rate', 'warning');
    }
}

function rate_save() {
    $('#rate_input_form').form('submit', {
        url: rate_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#rate').datagrid('reload');
                $('#rate_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function rate_delete() {
    var row = $('#rate').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'rate/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#rate').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Rate Selected', 'Please Select Rate', 'warning');
    }
}