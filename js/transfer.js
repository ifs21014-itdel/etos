/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

function transfer_search() {
    $('#transfer').datagrid('reload', $('#transfer_search_form').serializeObject());
}

function transfer_add() {
    if ($('#transfer_dialog')) {
        $('#bodydata').append("<div id='transfer_dialog'></div>");
    }
    $('#transfer_dialog').dialog({
        title: 'NEW TRANSFER',
        width: '400',
        height: 'auto',
        href: base_url + 'transfer/input',
        modal: true,
        resizable: false,
        shadow: false,
        maximizable: true,
        collapsible: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    $('#transfer_input_form').form('submit', {
                        url: base_url + 'transfer/save/0',
                        onSubmit: function () {
                            return $(this).form('validate');
                        },
                        success: function (content) {
                            var result = eval('(' + content + ')');
                            if (result.success) {
                                $('#transfer_dialog').dialog('close');
                                $('#transfer').datagrid('reload');
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
                    $('#transfer_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
        }
    });
}

function transfer_edit() {
    var row = $('#transfer').datagrid('getSelected');
    if (row !== null) {
        if ($('#transfer_dialog')) {
            $('#bodydata').append("<div id='transfer_dialog'></div>");
        }
        $('#transfer_dialog').dialog({
            title: 'EDIT TRANSFER',
            width: '500',
            height: 'auto',
            href: base_url + 'transfer/input',
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#transfer_input_form').form('submit', {
                            url: base_url + 'transfer/save/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#transfer_dialog').dialog('close');
                                    $('#transfer').datagrid('reload');
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
                        $('#transfer_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#transfer_input_form').form('load', row);
                if (row.transfer_source === "1") {
                    $('#transfer_vendor_id').combobox('clear');
                }
                var rows_detail = $('#transfer_detail').datagrid('getRows');
                console.log(rows_detail.length);
                if (rows_detail.length > 0) {
                    $('#transfer_source').combobox('readonly', true);
                    $('#transfer_proformainvoice_id').combogrid('readonly', true);
                }
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No Shipment List Selected', 'Please Select Shipment List', 'warning');
    }
}

function transfer_delete() {
    var row = $('#transfer').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'These data will be permanently deleted and cannot be recovered.<br/>Are you sure?', function (r) {
            if (r) {
                $.post(base_url + 'transfer/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#transfer').datagrid('reload');
                        $('#transfer_detail').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Shipment List Selected', 'Please Select Shipment List', 'warning');
    }
}

function transfer_detail_search() {
    var data = $('#transfer_detail_search_form').serializeObject();
    $.extend(data, {transferid: $('#transfer').datagrid('getSelected').id});
    $('#transfer_detail').datagrid('reload', data);
}

function transfer_detail_add() {
    var row = $('#transfer').datagrid('getSelected');
    if (row !== null) {
        if ($('#transfer_dialog')) {
            $('#bodydata').append("<div id='transfer_dialog'></div>");
        }
        $('#transfer_dialog').dialog({
            title: 'Product List',
            width: '70%',
            height: '90%',
            href: base_url + 'transfer/detail_add/' + row.source_id,
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        var rows = $('#transfer_detail_product_available').datagrid('getSelections');
                        if (rows.length > 0) {
                            var serial_number = new Array();
                            for (var i = 0; i < rows.length; i++) {
                                serial_number.push(rows[i].serial_number);
                            }
                            $.post(base_url + 'transfer/detail_save', {
                                transfer_id: row.id,
                                serial_number: serial_number
                            }, function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#transfer_dialog').dialog('close');
                                    $('#transfer_detail').datagrid('reload');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            });
                        } else {
                            $.messager.alert('No Products Selected', 'Please Select Products', 'warning');
                        }
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#transfer_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No transfer List Selected', 'Please Select transfer List', 'warning');
    }
}

function transfer_detail_import() {
    var row = $('#transfer').datagrid('getSelected');
    if (row !== null) {
        if ($('#transfer_dialog')) {
            $('#bodydata').append("<div id='transfer_dialog'></div>");
        }
        $('#transfer_dialog').dialog({
            title: 'Import',
            width: 400,
            height: 'auto',
            href: base_url + 'transfer/detail_import',
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        if ($('#transfer_detail_import_form').form('validate')) {
                            $('#transfer_detail_import_form').form('submit', {
                                url: base_url + 'transfer/detail_do_import/' + row.id,
                                success: function (content) {
                                    console.log(content);
                                    var result = eval('(' + content + ')');
                                    if (result.status === 'success' || result.status === 'warning') {
                                        $('#transfer_detail').datagrid('reload');
                                        $('#transfer_dialog').dialog('close');
                                        if (result.status === 'success') {
                                            $.messager.show({
                                                title: 'Server Notify',
                                                msg: result.msg,
                                                timeout: 5000,
                                                showType: 'slide'
                                            });
                                        } else {
                                            $.messager.show({
                                                title: 'Server Notify',
                                                msg: '<span style="color:red">' + result.msg + '</span>',
                                                timeout: 5000,
                                                showType: 'slide'
                                            });
                                        }
                                    } else {
                                        $.messager.alert('Error', result.msg, 'error');
                                    }
                                }
                            });
                        }
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#transfer_dialog').dialog('close');
                    }
                }]
        });
    } else {
        $.messager.alert('No Shipment List Selected', 'Please Select Shipment List', 'warning');
    }
}


function transfer_detail_delete() {
    var rows = $('#transfer_detail').datagrid('getSelections');
    if (rows.length > 0) {
        var ids = new Array();
        for (var i = 0; i < rows.length; i++) {
            ids.push(rows[i].id);
        }
        $.messager.confirm('Confirm', 'Are you sure to remove selections data?', function (r) {
            if (r) {
                $.post(base_url + 'transfer/detail_delete', {
                    id: ids
                }, function (result) {
                    console.log(result);
                    if (result.success) {
                        $('#transfer_detail').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Product selected', 'Please Select Product', 'warning');
    }
}

function transfer_print() {
    var row = $('#transfer').datagrid('getSelected');
    if (row !== null) {
        open_target('POST', base_url + 'transfer/prints', {id: row.id}, '_blank');
    } else {
        $.messager.alert('No Shipment List Selected', 'Please Select Shipment List', 'warning');
    }
}

function transfer_commercial_invoice() {
    var row = $('#transfer').datagrid('getSelected');
    if (row !== null) {
        open_target('POST', base_url + 'transfer/commercial_invoice', {id: row.id}, '_blank');
    } else {
        $.messager.alert('No Shipment List Selected', 'Please Select Shipment List', 'warning');
    }
}