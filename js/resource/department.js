/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var department_url = '';

function department_search() {
    $('#department').datagrid('reload',
            $('#department_form').serializeObject());
}

function department_input_form(type, title, row) {
    if ($('#department_dialog')) {
        $('#bodydata').append("<div id='department_dialog'></div>");
    }
    $('#department_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'resource/department/input',
        modal: false,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    department_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#department_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#department_dialog').form('load', row);

            } else {
                $('#department_dialog').form('clear');
            }

        }
    });
}

function department_save() {
    $('#department_input_form').form('submit', {
        url: department_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#department_dialog').dialog('close');
                $('#department').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function department_add() {
    department_input_form('add', 'Add New Job Title', null);
    department_url = base_url + 'resource/department/save/0';
}

function department_edit() {
    var row = $('#department').datagrid('getSelected');
    if (row !== null) {
        department_input_form('edit', 'Edit Job Title', row);
        department_url = base_url + 'resource/department/save/' + row.id;

    } else {
        $.messager.alert('Data is not Selected', 'Please Select Data First', 'warning');
    }
}

function department_delete() {
    var row = $('#department').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'resource/department/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#department').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Data is not Selected', 'Select Data First', 'warning');
    }
}

