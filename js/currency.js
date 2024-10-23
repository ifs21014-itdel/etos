/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var currency_url = '';

function currency_search() {
    $('#currency').datagrid('reload', $('#currency_search_form').serializeObject());
}

function currency_input_form(type, title, row) {
    if ($('#currency_dialog')) {
        $('#bodydata').append("<div id='currency_dialog'></div>");
    }

    $('#currency_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'currency/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    currency_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#currency_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#currency_input_form').form('load', row);
            } else {
                $('#currency_input_form').form('clear');
            }
        }
    });
}

function currency_add() {
    currency_input_form('add', 'ADD CURRENCY', null);
    currency_url = base_url + 'currency/save';
}

function currency_edit() {
    var row = $('#currency').datagrid('getSelected');
    if (row !== null) {
        currency_input_form('edit', 'EDIT CURRENCY', row);
        currency_url = base_url + 'currency/update/' + row.id;
    } else {
        $.messager.alert('No Currency Selected', 'Please Select Currency', 'warning');
    }
}

function currency_save() {
    $('#currency_input_form').form('submit', {
        url: currency_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#currency').datagrid('reload');
                $('#currency_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function currency_delete() {
    var row = $('#currency').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'currency/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#currency').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Currency Selected', 'Please Select Currency', 'warning');
    }
}