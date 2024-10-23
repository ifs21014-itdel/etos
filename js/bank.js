/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var bank_url = '';

function bank_search() {
    $('#bank').datagrid('reload', $('#bank_search_form').serializeObject());
}

function bank_input_form(type, title, row) {
    if ($('#bank_dialog')) {
        $('#bodydata').append("<div id='bank_dialog'></div>");
    }

    $('#bank_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'bank/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    bank_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#bank_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#bank_input_form').form('load', row);
            } else {
                $('#bank_input_form').form('clear');
            }
        }
    });
}

function bank_add() {
    bank_input_form('add', 'ADD COUNTRY', null);
    bank_url = base_url + 'bank/save';
}

function bank_edit() {
    var row = $('#bank').datagrid('getSelected');
    if (row !== null) {
        bank_input_form('edit', 'EDIT COUNTRY', row);
        bank_url = base_url + 'bank/update/' + row.id;
    } else {
        $.messager.alert('No Country Selected', 'Please Select Country', 'warning');
    }
}

function bank_save() {
    $('#bank_input_form').form('submit', {
        url: bank_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#bank').datagrid('reload');
                $('#bank_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function bank_delete() {
    var row = $('#bank').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'bank/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#bank').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Country Selected', 'Please Select Country', 'warning');
    }
}