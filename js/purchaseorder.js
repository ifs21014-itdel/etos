/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* global base_url */

var po_url = '';

function purchaseorder_search() {
    $('#purchaseorder').datagrid('reload', $('#po_search_form').serializeObject());
}

function po_product_search() {
    var row = $('#purchaseorder').datagrid('getSelected');
    var postData = $('#po_product_search_form').serializeObject();
    $.extend(postData, {purchaseorderid: row.id});
    $('#po_product').datagrid('reload', postData);
}

function purchaseorder_add() {
    purchaseorder_input_form('add', 'New Purchase Order');
    po_url = base_url + 'purchaseorder/save/0';
}
function purchaseorder_edit() {
    var row = $('#purchaseorder').datagrid('getSelected');
    purchaseorder_input_form('edit', 'New Purchase Order',row);
    po_url = base_url + 'purchaseorder/save/'+row.id;
    
}

function purchaseorder_input_form(type, title, row) {
    if ($('#po_dialog')) {
        $('#bodydata').append("<div id='po_dialog'></div>");
    }
    $('#po_dialog').dialog({
        title: title,
        width: 800,
        height: 'auto',
        href: base_url + 'purchaseorder/input',
        modal: true,
        resizable: false,
        shadow: false,
        maximizable: true,
        collapsible: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    purchaseorder_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#po_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#purchaseorder_input_form').form('load', row);
            } else {
                $('#purchaseorder_input_form').form('clear');
            }

        }
    });
}
function purchaseorder_save() {
    if ($('#purchaseorder_input_form').form('validate')) {
        $.post(po_url, $('#purchaseorder_input_form').serializeObject(), function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#purchaseorder').datagrid('reload');
                $('#po_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        });
    }
}

function purchaseorder_release() {
    var row = $('#purchaseorder').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Release P.O', 'With the release PO then the barcode will be automatically created, and you can not change the PO anymore<br/><br/><center>Are you sure?</center>', function (r) {
            if (r) {
                $.post(base_url + 'purchaseorder/release', {id: row.id}, function (result) {
                    if (result.success) {
                        $('#purchaseorder_release').linkbutton('disable');
                        $('#purchaseorder').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}

function purchaseorder_download_label() {
    var row = $('#purchaseorder').datagrid('getSelected');
    if (row !== null) {
        if (row.release === 't') {
            if (row.count_base !== '0') {
                open_target('POST', base_url + 'purchaseorder/download_serial_number', {id: row.id}, '_blank');
            } else {
                $.messager.alert('No Label', 'No Label / Serial Number for Selected P.O', 'warning');
            }
        } else {
            $.messager.alert('Unreleased PO', 'Selected P.O not released yet', 'warning');
        }
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}

function purchaseorder_update_down_payment_date() {
    var row = $('#purchaseorder').datagrid('getSelected');
    if (row !== null) {
        if ($('#po_dialog')) {
            $('#bodydata').append("<div id='po_dialog'></div>");
        }
        $('#po_dialog').dialog({
            title: 'UPDATE DOWN PAYMENT DATE',
            width: 400,
            height: 'auto',
            href: base_url + 'purchaseorder/update_down_payment_date',
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#po_update_down_payment_date_form').form('submit', {
                            url: base_url + 'purchaseorder/do_update_down_payment_date',
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#po_dialog').dialog('close');
                                    $('#purchaseorder').datagrid('reload');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            }
                        });
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#po_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#po_update_down_payment_date_form').form("load", row);
                $(this).dialog('center');

            }
        });
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}

function purchaseorder_download() {
    var row = $('#purchaseorder').datagrid('getSelected');
    if (row !== null) {
        open_target('post', base_url + 'purchaseorder/download', {
            id: row.id
        }, '_blank');
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}

function purchaseorder_download_all_by_order_id() {
    var row = $('#purchaseorder').datagrid('getSelected');
    if (row !== null) {
        open_target('post', base_url + 'purchaseorder/download_all_by_order_id', {
            pi_id: row.pi_id
        }, '_blank');
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}
//-------------------------
function purchaseorder_delete() {
    var row = $('#purchaseorder').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure?', function (r) {
            if (r) {
                $.post(base_url + 'purchaseorder/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#purchaseorder').datagrid('reload');
                        $('#po_editorial_create_real_po').linkbutton('disable');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}

function purchaseorder_product_add() {
    var row = $('#purchaseorder').datagrid('getSelected');
    if (row !== null) {
        purchaseorder_input_product_form('add', 'ADD PRODUCT', null, row.id,row.client_id)
        po_url = base_url + 'purchaseorder/product_save/' + row.id + '/0';
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function purchaseorder_product_edit() {
    var row = $('#po_product').datagrid('getSelected');
    if (row !== null) {
        purchaseorder_input_product_form('edit', 'EDIT PRODUCT', row, row.purchaseorder_id)
        po_url = base_url + 'purchaseorder/product_save/' + row.purchaseorder_id + '/' + row.id;
    } else {
        $.messager.alert('No Proforma Invoice Selected', 'Please Select Proforma Invoice', 'warning');
    }
}

function purchaseorder_product_delete() {
    var row = $('#po_product').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure?', function (r) {
            if (r) {
                $.post(base_url + 'purchaseorder/product_delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#po_product').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Purchase Order Product Selected', 'Please Select Purchase Order', 'warning');
    }
}
function purchaseorder_product_save(po_id) {
    if ($('#purchaseorder_product_input_form').form('validate')) {
        $.post(po_url, $('#purchaseorder_product_input_form').serializeObject(), function (content) {
            var result = eval('(' + content + ')');
           // alert (result);
            if (result.success) {
                $('#po_product').datagrid('reload');
                $('#purchaseorder_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        });
    }
}

function purchaseorder_input_product_form(type, title, row, purchaseorder_id,client_id) {
    if ($('#purchaseorder_dialog')) {
        $('#bodydata').append("<div id='purchaseorder_dialog'></div>");
    }

    $('#purchaseorder_dialog').dialog({
        title: title,
        width: 500,
        height: 'auto',
        href: base_url + 'purchaseorder/product_input/'+client_id,
        modal: true,
        resizable: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    purchaseorder_product_save(purchaseorder_id);
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#purchaseorder_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#purchaseorder_product_input_form').form('load', row);

            } else {
                $('#purchaseorder_product_input_form').form('clear');
            }
        }
    });
}
