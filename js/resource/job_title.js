/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var job_title_url = '';

function job_title_search() {
    $('#job_title').datagrid('reload',
            $('#job_title_form').serializeObject());
}

function job_title_input_form(type, title, row) {
    if ($('#job_title_dialog')) {
        $('#bodydata').append("<div id='job_title_dialog'></div>");
    }
    $('#job_title_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'resource/job_title/input',
        modal: false,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    job_title_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#job_title_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#job_title_dialog').form('load', row);

            } else {
                $('#job_title_dialog').form('clear');
            }

        }
    });
}

function job_title_save() {
    $('#job_title_input_form').form('submit', {
        url: job_title_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#job_title_dialog').dialog('close');
                $('#job_title').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function job_title_add() {
    job_title_input_form('add', 'Add New Job Title', null);
    job_title_url = base_url + 'resource/job_title/save/0';
}

function job_title_edit() {
    var row = $('#job_title').datagrid('getSelected');
    if (row !== null) {
        job_title_input_form('edit', 'Edit Job Title', row);
        job_title_url = base_url + 'resource/job_title/save/' + row.id;

    } else {
        $.messager.alert('Data is not Selected', 'Please Select Data First', 'warning');
    }
}

function job_title_delete() {
    var row = $('#job_title').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'resource/job_title/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#job_title').datagrid('reload');
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

