/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var po_item_inspection_url = '';

function po_item_inspection_search() {
    $('#po_item_inspection').datagrid('reload', $('#po_item_inspection_search_form').serializeObject());
}

function po_item_inspection_input_form(type, title, row) {
    if ($('#po_item_inspection_dialog')) {
        $('#bodydata').append("<div id='po_item_inspection_dialog'></div>");
    }
    $('#po_item_inspection_dialog').dialog({
        title: title,
        width: 350,
        height: '500',
        href: base_url + 'po_item_inspection/input',
        modal: true,
        resizable: true,
        overflow: 'auto',
        modal: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    po_item_inspection_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#po_item_inspection_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            $('#po_item_inspection_input_form').form('load', row);
        }
    });
}

function po_item_inspection_add(idrow) {
    var row = $('#po_item_inspection').datagrid('getSelected');
    // alert(idrow+'='+row.customer_code);
    if (row !== null) {
        po_item_inspection_input_form('add', 'ITEM INSPECTION', row);
        po_item_inspection_url = base_url + 'po_item_inspection/save/' + row.id;
    } else {
        $.messager.alert('No Currency Selected', 'Please Select Item neet to inspec', 'warning');
    }
}

function po_item_inspection_edit() {
    var row = $('#po_item_inspection').datagrid('getSelected');
    if (row !== null) {
        po_item_inspection_input_form('edit', 'EDIT CURRENCY', row);
        po_item_inspection_url = base_url + 'po_item_inspection/update/' + row.id;
    } else {
        $.messager.alert('No Currency Selected', 'Please Select Currency', 'warning');
    }
}

function po_item_inspection_save() {
    $('#po_item_inspection_input_form').form('submit', {
        url: po_item_inspection_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#po_item_inspection').datagrid('reload');
                $('#po_item_inspection_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function po_item_inspection_delete() {
    var row = $('#po_item_inspection').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'po_item_inspection/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#po_item_inspection').datagrid('reload');
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