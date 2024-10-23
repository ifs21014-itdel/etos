/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var invoice_url = '';

function invoice_search() {
    $('#invoice').datagrid('reload', $('#invoice_search_form').serializeObject());
}

function invoice_input_form(type, title, row, form_type) {
    if ($('#invoice_dialog').length === 0) {
        $('#bodydata').append("<div id='invoice_dialog'></div>");
    }

    $('#invoice_dialog').dialog({
        title: title,
        width: 500,
        height: 'auto',
        href: base_url + 'invoice/input/' + form_type,
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    invoice_save(form_type);
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#invoice_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#invoice_input_form').form('load', row);
            } else {
                $('#invoice_input_form').form('clear');
            }
            setTimeout(function () {
                $('#invoice_order_amount').numberbox('textbox').css('text-align', 'right');
                $('#invoice_outstanding').numberbox('textbox').css('text-align', 'right');
                $('#invoice_amount').numberbox('textbox').css('text-align', 'right');
                $('#invoice_tax').numberbox('textbox').css('text-align', 'right');
                $('#invoice_amount_due').numberbox('textbox').css('text-align', 'right');
                $('#invoice_amount_percent').numberbox({
                    onChange: function (n, o) {
                        invoice_calculate_amount();
                    }
                });
            }, 1);

        }
    });
}

function invoice_calculate() {
    var invoice_amount_due = parseFloat($('#invoice_amount').numberbox('getValue'));
    $('#invoice_tax').numberbox('setValue', 0);
    if ($('#invoice_input_form_ppn_flag').is(':checked')) {
        $('#invoice_tax').numberbox('setValue', (invoice_amount_due * 0.1));
        invoice_amount_due = invoice_amount_due + (invoice_amount_due * 0.1);
    }
    $('#invoice_amount_due').numberbox('setValue', invoice_amount_due);
}

function invoice_calculate_amount() {
    var invoice_amount_percent = parseFloat($("#invoice_amount_percent").numberbox('getValue'));
    var invoice_order_amount = $('#invoice_order_amount').numberbox('getValue');
    var invoice_amount = (invoice_amount_percent / 100) * invoice_order_amount;
    $('#invoice_amount').numberbox('setValue', invoice_amount);
    invoice_calculate();
}

function invoice_add(type) {
    invoice_input_form('add', 'ADD INVOICE', null, type);
    invoice_url = base_url + 'invoice/save';
}

function invoice_edit() {
    var row = $('#invoice').datagrid('getSelected');
    if (row !== null) {
        invoice_input_form('edit', 'EDIT INVOICE', row, row.type);
        invoice_url = base_url + 'invoice/save/' + row.id;
    } else {
        $.messager.alert('No Row Selected', 'Please Select Row', 'warning');
    }
}

function invoice_save(type) {
    if ($('#invoice_input_form').form('validate')) {
        $('#invoice_input_form').form('submit', {
            url: invoice_url,
            onSubmit: function (param) {
            },
            success: function (content) {
                var result = eval('(' + content + ')');
                if (result.success) {
                    $('#invoice').datagrid('reload');
                    $('#invoice_dialog').dialog('close');
                } else {
                    $.messager.alert('Error', result.msg, 'error');
                }
            }
        });
    }
}

function invoice_delete() {
    var row = $('#invoice').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'invoice/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#invoice').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Row Selected', 'Please Select Row', 'warning');
    }
}

function invoice_print() {
    var row = $('#invoice').datagrid('getSelected');
    if (row !== null) {
        open_target('POST', base_url + 'invoice/prints', {id: row.id, pi_id: row.proforma_invoice_id, type: row.type}, '_blank')
    } else {
        $.messager.alert('No Row Selected', 'Please Select Row', 'warning');
    }
}