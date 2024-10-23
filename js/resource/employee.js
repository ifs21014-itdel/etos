/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var employee_url = '';

function employee_search() {
    $('#employee').datagrid('reload',
            $('#employee_form').serializeObject());
}


function employee_input_form(type, title, row) {
    if ($('#employee_dialog')) {
        $('#bodydata').append("<div id='employee_dialog'></div>");
    }
    $('#employee_dialog').dialog({
        title: title,
        width: 1000,
        height: 'auto',
        href: base_url + 'resource/employee/input',
        modal: false,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    employee_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#employee_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#employee_dialog').form('load', row);

            } else {
                $('#employee_dialog').form('clear');
            }

        }
    });
}

function employee_save() {
    $('#employee_form').form('submit', {
        url: employee_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#employee_dialog').dialog('close');
                $('#employee').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function employee_add() {
    employee_input_form('add', 'Add New Employee', null);
    employee_url = base_url + 'resource/employee/save/0';
}

function employee_edit() {
    var row = $('#employee').datagrid('getSelected');
    if (row !== null) {
        employee_input_form('edit', 'Edit Employee', row);
        employee_url = base_url + 'resource/employee/save/' + row.id;

    } else {
        $.messager.alert('Data is not Selected', 'Please Select Data First', 'warning');
    }
}

function employee_delete() {
    var row = $('#employee').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'resource/employee/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#employee').datagrid('reload');
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

