/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var vendor_url = '';

function vendor_search() {
    $('#vendor').datagrid('reload', $('#vendor_search_form').serializeObject());
}

function vendor_input_form(type, title, row) {
    if ($('#vendor_dialog')) {
        $('#bodydata').append("<div id='vendor_dialog'></div>");
    }

    $('#vendor_dialog').dialog({
        title: title,
        width: 500,
        height: 'auto',
        href: base_url + 'vendor/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    vendor_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#vendor_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#vendor_input_form').form('load', row);
            } else {
                $('#vendor_input_form').form('clear');
            }
        }
    });
}

function vendor_add() {
    vendor_input_form('add', 'ADD VENDOR', null)
    vendor_url = base_url + 'vendor/save/0';
}

function vendor_edit() {
    var row = $('#vendor').datagrid('getSelected');
    if (row !== null) {
        vendor_input_form('edit', 'EDIT VENDOR', row);
        vendor_url = base_url + 'vendor/save/' + row.id;
    } else {
        $.messager.alert('No Vendor Selected', 'Please Select Vendor', 'warning');
    }
}

function vendor_save() {
    $('#vendor_input_form').form('submit', {
        url: vendor_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#vendor').datagrid('reload');
                $('#vendor_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function vendor_delete() {
    var row = $('#vendor').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'vendor/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#vendor').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Vendor Selected', 'Please Select Vendor', 'warning');
    }
}