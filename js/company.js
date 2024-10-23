/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var company_url = '';

function company_search() {
    $('#company').datagrid('reload', $('#company_search_form').serializeObject());
}

function company_input_form(type, title, row) {
    if ($('#company_dialog')) {
        $('#bodydata').append("<div id='company_dialog'></div>");
    }

    $('#company_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'company/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    company_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#company_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#company_input_form').form('load', row);
            } else {
                $('#company_input_form').form('clear');
            }
        }
    });
}

function company_add() {
    company_input_form('add', 'ADD COUNTRY', null);
    company_url = base_url + 'company/save';
}

function company_edit() {
    var row = $('#company').datagrid('getSelected');
    if (row !== null) {
        company_input_form('edit', 'EDIT COMPANY', row);
        company_url = base_url + 'company/update/' + row.id;
    } else {
        $.messager.alert('No Country Selected', 'Please Select Company', 'warning');
    }
}

function company_save() {
    $('#company_input_form').form('submit', {
        url: company_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#company').datagrid('reload');
                $('#company_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function company_delete() {
    var row = $('#company').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'company/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#company').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Country Selected', 'Please Select Country', 'warning');
    }
}