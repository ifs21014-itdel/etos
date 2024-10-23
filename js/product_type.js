/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* global base_url */

var product_type_url = '';
function product_type_search() {
    $('#product_type').datagrid('reload', $('#product_type_search_form').serializeObject());
}

function product_type_input_form(type, title, row) {
    if ($('#product_type_dialog')) {
        $('#bodydata').append("<div id='product_type_dialog'></div>");
    }

    $('#product_type_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'product_type/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    product_type_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#product_type_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#product_type_input_form').form('load', row);
            } else {
                $('#product_type_input_form').form('clear');
            }
        }
    });
}

function product_type_add() {
    product_type_input_form('add', 'ADD PRODUCT TYPE', null);
    product_type_url = base_url + 'product_type/save/0';
}

function product_type_edit() {
    var row = $('#product_type').datagrid('getSelected');
    if (row !== null) {
        product_type_input_form('edit', 'EDIT PRODUCT TYPE', row);
        product_type_url = base_url + 'product_type/update/' + row.id;
    } else {
        $.messager.alert('Product type not selected', 'Please select product type', 'warning');
    }
}

function product_type_save() {
    $('#product_type_input_form').form('submit', {
        url: product_type_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            //            alert(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#product_type_dialog').dialog('close');
                $('#product_type').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function product_type_delete() {
    var row = $('#product_type').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'product_type/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#product_type').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Product type not selected', 'Please select product type', 'warning');
    }
}

