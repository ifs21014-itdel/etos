/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var color_url = '';

function color_search() {
    $('#color').datagrid('reload', $('#color_search_form').serializeObject());
}


function color_input_form(type, title, row) {
    if ($('#color_dialog')) {
        $('#bodydata').append("<div id='color_dialog'></div>");
    }
    $('#color_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'color/input',
        modal: false,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    color_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#color_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#color_form').form('load', row);
            } else {
                $('#color_form').form('clear');
            }

        }
    });
}

function color_save() {
    $('#color_form').form('submit', {
        url: color_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#color_dialog').dialog('close');
                $('#color').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function color_add() {
    color_input_form('add', 'ADD COLOR', null);
    color_url = base_url + 'color/save/0';
}

function color_edit() {
    var row = $('#color').datagrid('getSelected');
    if (row !== null) {
        color_input_form('edit', 'ADD COLOR', row);
        color_url = base_url + 'color/save/' + row.id;
    } else {
        $.messager.alert('Color not Selected', 'Please Select color', 'warning');
    }
}

function color_delete() {
    var row = $('#color').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'color/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#color').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Color not Selected', 'Select color', 'warning');
    }
}

