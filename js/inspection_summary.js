/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var inspection_summary_url = '';

function inspection_summary_search() {
    $('#inspection_summary').datagrid('reload', $('#inspection_summary_search_form').serializeObject());
}

function inspection_summary_input_form(type, title, row) {
    if ($('#inspection_summary_dialog')) {
        $('#bodydata').append("<div id='inspection_summary_dialog'></div>");
    }

    $('#inspection_summary_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'inspection_summary/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    inspection_summary_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#inspection_summary_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#inspection_summary_input_form').form('load', row);
            } else {
                $('#inspection_summary_input_form').form('clear');
            }
        }
    });
}

function inspection_summary_add() {
    inspection_summary_input_form('add', 'ADD Image Category', null);
    inspection_summary_url = base_url + 'inspection_summary/save';
}

function inspection_summary_edit() {
    var row = $('#inspection_summary').datagrid('getSelected');
    if (row !== null) {
        inspection_summary_input_form('edit', 'EDIT Image Category', row);
        inspection_summary_url = base_url + 'inspection_summary/update/' + row.id;
    } else {
        $.messager.alert('No Currency Selected', 'Please Select Currency', 'warning');
    }
}

function inspection_summary_save() {
    $('#inspection_summary_input_form').form('submit', {
        url: inspection_summary_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#inspection_summary').datagrid('reload');
                $('#inspection_summary_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function inspection_summary_delete() {
    var row = $('#inspection_summary').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'inspection_summary/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#inspection_summary').datagrid('reload');
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
function print_inspection2(type) {
    var row = $('#inspection_summary').datagrid('getSelected');
    if (row !== null) {
        if (type === 'single')
            open_target('POST', base_url + 'inspection/prints', {id: row.id}, '_blank');
        else
            open_target('POST', base_url + 'inspection/print_summary', {id: row.id}, '_blank');
    } else {
        $.messager.alert('No Inspection List Selected', 'Please Select Inspection List', 'warning');
    }
}