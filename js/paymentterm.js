/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var paymentterm_url = '';

function paymentterm_search() {
    $('#paymentterm').datagrid('reload', {
        
    });
}


function paymentterm_input_form(type, title, row) {
    if ($('#paymentterm_dialog')) {
        $('#bodydata').append("<div id='paymentterm_dialog'></div>");
    }
    $('#paymentterm_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'paymentterm/input',
        modal: true,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    paymentterm_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#paymentterm_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#paymentterm_form').form('load', row);
            } else {
                $('#paymentterm_form').form('clear');
            }

        }
    });
}

function paymentterm_save() {
    $('#paymentterm_form').form('submit', {
        url: paymentterm_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#paymentterm_dialog').dialog('close');
                $('#paymentterm').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function paymentterm_add() {
    paymentterm_input_form('add', 'ADD PAYMENT TERM', null);
    paymentterm_url = base_url + 'paymentterm/save/0';
}

function paymentterm_edit() {
    var row = $('#paymentterm').datagrid('getSelected');
    if (row !== null) {
        paymentterm_input_form('edit', 'EDIT PAYMENT TERM', row);
        paymentterm_url = base_url + 'paymentterm/save/' + row.id;
    } else {
        $.messager.alert('Payment Term not Selected', 'Please Select Payment Term', 'warning');
    }
}

function paymentterm_delete() {
    var row = $('#paymentterm').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'paymentterm/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#paymentterm').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Payment Term not Selected', 'Select Payment Term', 'warning');
    }
}

