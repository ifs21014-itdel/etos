/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var fabric_url = '';

function fabric_search() {
    $('#fabric').datagrid('reload', $('#fabric_search_form').serializeObject());
}


function fabric_input_form(type, title, row) {
    if ($('#fabric_dialog')) {
        $('#bodydata').append("<div id='fabric_dialog'></div>");
    }
    $('#fabric_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'fabric/input',
        modal: true,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    fabric_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#fabric_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#fabric_form').form('load', row);
            } else {
                $('#fabric_form').form('clear');
            }

        }
    });
}

function fabric_save() {
    $('#fabric_form').form('submit', {
        url: fabric_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#fabric_dialog').dialog('close');
                $('#fabric').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function fabric_add() {
    fabric_input_form('add', 'ADD FABRIC', null);
    fabric_url = base_url + 'fabric/save/0';
}

function fabric_edit() {
    var row = $('#fabric').datagrid('getSelected');
    if (row !== null) {
        fabric_input_form('edit', 'EDIT FABRIC', row);
        fabric_url = base_url + 'fabric/save/' + row.id;
    } else {
        $.messager.alert('No Fabric Selected', 'Please Select Fabric', 'warning');
    }
}

function fabric_delete() {
    var row = $('#fabric').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'fabric/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#fabric').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Fabric Selected', 'Please Select Fabric', 'warning');
    }
}

