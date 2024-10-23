/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* global base_url */

var materials_url = '';

function materials_search() {
    $('#materials').datagrid('reload', $('#materials_search_form').serializeObject());
}

function materials_input_form(type, title, row) {
    if ($('#materials_dialog')) {
        $('#bodydata').append("<div id='materials_dialog'></div>");
    }

    $('#materials_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'materials/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    materials_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#materials_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#materials_input_form').form('load', row);
            } else {
                $('#materials_input_form').form('clear');
            }
        }
    });
}


function materials_add() {
    materials_input_form('add', 'ADD MATERIAL', null);
    materials_url = base_url + 'materials/save';
}

function materials_edit() {
    var row = $('#materials').datagrid('getSelected');
    if (row !== null) {
        materials_input_form('edit', 'EDIT MATERIAL', row);
        materials_url = base_url + 'materials/update/' + row.id;
    } else {
        $.messager.alert('Material not selected', 'Please Select material', 'warning');
    }
}

function materials_save() {
    $('#materials_input_form').form('submit', {
        url: materials_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            //            alert(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#materials_dialog').dialog('close');
                $('#materials').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}



function materials_delete() {
    var row = $('#materials').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'materials/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#materials').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Materials not selected', 'Select materials', 'warning');
    }
}

