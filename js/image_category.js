/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var image_category_url = '';

function image_category_search() {
    $('#image_category').datagrid('reload', $('#image_category_search_form').serializeObject());
}

function image_category_input_form(type, title, row) {
    if ($('#image_category_dialog')) {
        $('#bodydata').append("<div id='image_category_dialog'></div>");
    }

    $('#image_category_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'image_category/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    image_category_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#image_category_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#image_category_input_form').form('load', row);
            } else {
                $('#image_category_input_form').form('clear');
            }
        }
    });
}

function image_category_add() {
    image_category_input_form('add', 'ADD Image Category', null);
    image_category_url = base_url + 'image_category/save';
}

function image_category_edit() {
    var row = $('#image_category').datagrid('getSelected');
    if (row !== null) {
        image_category_input_form('edit', 'EDIT Image Category', row);
        image_category_url = base_url + 'image_category/update/' + row.id;
    } else {
        $.messager.alert('No Currency Selected', 'Please Select Currency', 'warning');
    }
}

function image_category_save() {
    $('#image_category_input_form').form('submit', {
        url: image_category_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#image_category').datagrid('reload');
                $('#image_category_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function image_category_delete() {
    var row = $('#image_category').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'image_category/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#image_category').datagrid('reload');
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