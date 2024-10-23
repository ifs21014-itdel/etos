/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var country_url = '';

function country_search() {
    $('#country').datagrid('reload', $('#country_search_form').serializeObject());
}

function country_input_form(type, title, row) {
    if ($('#country_dialog')) {
        $('#bodydata').append("<div id='country_dialog'></div>");
    }

    $('#country_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'country/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    country_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#country_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#country_input_form').form('load', row);
            } else {
                $('#country_input_form').form('clear');
            }
        }
    });
}

function country_add() {
    country_input_form('add', 'ADD COUNTRY', null);
    country_url = base_url + 'country/save';
}

function country_edit() {
    var row = $('#country').datagrid('getSelected');
    if (row !== null) {
        country_input_form('edit', 'EDIT COUNTRY', row);
        country_url = base_url + 'country/update/' + row.id;
    } else {
        $.messager.alert('No Country Selected', 'Please Select Country', 'warning');
    }
}

function country_save() {
    $('#country_input_form').form('submit', {
        url: country_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#country').datagrid('reload');
                $('#country_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function country_delete() {
    var row = $('#country').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'country/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#country').datagrid('reload');
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