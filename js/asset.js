/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var asset_url = '';

function asset_search() {
    $('#asset').datagrid('reload', $('#asset_search_form').serializeObject());
}

function asset_input_form(type, title, row) {
    if ($('#asset_dialog').length === 0) {
        $('#bodydata').append("<div id='asset_dialog'></div>");
    }

    $('#asset_dialog').dialog({
        title: title,
        width: 500,
        height: 'auto',
        href: base_url + 'asset/input/',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    asset_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#asset_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#asset_input_form').form('load', row);
            } else {
                $('#asset_input_form').form('clear');
            }
        }
    });
}

function asset_add(type) {
    asset_input_form('add', 'ADD ASSET', null);
    asset_url = base_url + 'asset/save';
}

function asset_edit() {
    var row = $('#asset').datagrid('getSelected');
    if (row !== null) {
        asset_input_form('edit', 'ASSET', row);
        asset_url = base_url + 'asset/save/' + row.id;
    } else {
        $.messager.alert('No Row Selected', 'Please Select Row', 'warning');
    }
}

function asset_save() {
    if ($('#asset_input_form').form('validate')) {
        $('#asset_input_form').form('submit', {
            url: asset_url,
            onSubmit: function (param) {
            },
            success: function (content) {
                var result = eval('(' + content + ')');
                if (result.success) {
                    $('#asset').datagrid('reload');
                    $('#asset_dialog').dialog('close');
                } else {
                    $.messager.alert('Error', result.msg, 'error');
                }
            }
        });
    }
}

function asset_delete() {
    var row = $('#asset').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'asset/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#asset').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Row Selected', 'Please Select Row', 'warning');
    }
}

function asset_print() {
    var row = $('#asset').datagrid('getSelected');
    if (row !== null) {
        open_target('POST', base_url + 'asset/prints', {id: row.id, pi_id: row.proforma_asset_id, type: row.type}, '_blank')
    } else {
        $.messager.alert('No Row Selected', 'Please Select Row', 'warning');
    }
}