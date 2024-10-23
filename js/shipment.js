/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

function shipment_search(){
    $('#shipment').datagrid('reload', $('#shipment_search_form').serializeObject());
}

function shipment_add() {
    if ($('#shipment_dialog')) {
        $('#bodydata').append("<div id='shipment_dialog'></div>");
    }
    $('#shipment_dialog').dialog({
        title: 'NEW SHIPMENT',
        width: '500',
        height: 'auto',
        href: base_url + 'shipment/input',
        modal: true,
        resizable: false,
        shadow: false,
        maximizable: true,
        collapsible: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    $('#shipment_input_form').form('submit', {
                        url: base_url + 'shipment/save/0',
                        onSubmit: function () {
                            return $(this).form('validate');
                        },
                        success: function (content) {
                            var result = eval('(' + content + ')');
                            if (result.success) {
                                $('#shipment_dialog').dialog('close');
                                $('#shipment').datagrid('reload');
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
                    $('#shipment_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
        }
    });
}

function shipment_edit() {
    var row = $('#shipment').datagrid('getSelected');
    if (row !== null) {
        if ($('#shipment_dialog')) {
            $('#bodydata').append("<div id='shipment_dialog'></div>");
        }
        $('#shipment_dialog').dialog({
            title: 'EDIT SHIPMENT',
            width: '500',
            height: 'auto',
            href: base_url + 'shipment/input',
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#shipment_input_form').form('submit', {
                            url: base_url + 'shipment/save/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#shipment_dialog').dialog('close');
                                    $('#shipment').datagrid('reload');
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
                        $('#shipment_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#shipment_input_form').form('load', row);
                if (row.shipment_source === "1") {
                    $('#shipment_vendor_id').combobox('clear');
                }
                var rows_detail = $('#shipment_detail').datagrid('getRows');
                console.log(rows_detail.length);
                if (rows_detail.length > 0) {
                    $('#shipment_source').combobox('readonly', true);
                    $('#shipment_proformainvoice_id').combogrid('readonly', true);
                }
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No Shipment List Selected', 'Please Select Shipment List', 'warning');
    }
}

function shipment_delete() {
    var row = $('#shipment').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'These data will be permanently deleted and cannot be recovered.<br/>Are you sure?', function (r) {
            if (r) {
                $.post(base_url + 'shipment/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#shipment').datagrid('reload');
                        $('#shipment_detail').datagrid('reload');
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

function shipment_detail_add() {
    var row = $('#shipment').datagrid('getSelected');
    if (row !== null) {
        if ($('#shipment_dialog')) {
            $('#bodydata').append("<div id='shipment_dialog'></div>");
        }
        $('#shipment_dialog').dialog({
            title: 'Product List',
            width: '80%',
            height: '80%',
            href: base_url + 'shipment/detail_add/' + row.client_id + '/' + row.id,
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        var rows = $('#shipment_detail_product_available').datagrid('getSelections');
                        if (rows.length > 0) {
                            var serial_number = new Array();
                            for (var i = 0; i < rows.length; i++) {
                                serial_number.push(rows[i].serial_number);
                            }
                            $.post(base_url + 'shipment/detail_save', {
                                shipmentid: row.id,
                                serial_number: serial_number
                            }, function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#shipment_dialog').dialog('close');
                                    $('#shipment_detail').datagrid('reload');
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
                        $('#shipment_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No shipment List Selected', 'Please Select shipment List', 'warning');
    }
}
function shipment_detail_add_barcode() {
    var row = $('#shipment').datagrid('getSelected');
    if ($('#shipment_detail_add_barcode_dialog')) {
        $('#bodydata').append("<div id='shipment_detail_add_barcode_dialog'></div>");
    }
    $('#shipment_detail_add_barcode_dialog').dialog({
        title:'SERIAL NUMBER FORM',
        width: '700',
        height: 'auto',
        href: base_url + 'shipment/detail_add_scan_barcode',
        modal: true,
        resizable: false,
        shadow: false,
        maximizable: true,
        collapsible: true,
        dialogClass: 'scan_barcode',
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                id:'button-save-id',
                handler: function () {
                    $('#shipment_input_detail_scan_barcode_form').form('submit', {
                        url: base_url + 'shipment/save_detail_scan_barcode/'+row.id,
                        onSubmit: function () {
                            return $(this).form('validate');
                        },
                        success: function (content) {
                            var result = eval('(' + content + ')');
                            if (result.success) {
                                //$('#shipment_detail_add_barcode_dialog').dialog('close');
                                $('#shipment_detail').datagrid('reload');
                                document.getElementById('serial_number_scan_id').value=''; 
                            } else {
                                $.messager.alert('Error', result.msg, 'error');
                                document.getElementById('serial_number_scan_id').value=''; 
                            }
                        }
                    });
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#shipment_detail_add_barcode_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
        }
    });
}
function shipment_detail_import() {
    var row = $('#shipment').datagrid('getSelected');
    if (row !== null) {
        if ($('#shipment_dialog')) {
            $('#bodydata').append("<div id='shipment_dialog'></div>");
        }
        $('#shipment_dialog').dialog({
            title: 'Import',
            width: 400,
            height: 'auto',
            href: base_url + 'shipment/detail_import',
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        if ($('#shipment_detail_import_form').form('validate')) {
                            $('#shipment_detail_import_form').form('submit', {
                                url: base_url + 'shipment/detail_do_import/' + row.id,
                                success: function (content) {
                                    console.log(content);
                                    var result = eval('(' + content + ')');
                                    if (result.status === 'success' || result.status === 'warning') {
                                        $('#shipment_detail').datagrid('reload');
                                        $('#shipment_dialog').dialog('close');
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
                        $('#shipment_dialog').dialog('close');
                    }
                }]
        });
    } else {
        $.messager.alert('No Shipment List Selected', 'Please Select Shipment List', 'warning');
    }
}


function shipment_detail_delete() {
    var rows = $('#shipment_detail').datagrid('getSelections');
    if (rows.length > 0) {
        var ids = new Array();
        for (var i = 0; i < rows.length; i++) {
            ids.push(rows[i].id);
        }
        $.messager.confirm('Confirm', 'Are you sure to remove selections data?', function (r) {
            if (r) {
                $.post(base_url + 'shipment/detail_delete', {
                    id: ids
                }, function (result) {
                    console.log(result);
                    if (result.success) {
                        $('#shipment_detail').datagrid('reload');
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

function shipment_print(type) {
    var row = $('#shipment').datagrid('getSelected');
    if (row !== null) {
        if(type==='detail')
            open_target('POST', base_url + 'shipment/prints', {id: row.id}, '_blank');
        else
            open_target('POST', base_url + 'shipment/print_summary', {id: row.id}, '_blank');
    } else {
        $.messager.alert('No Shipment List Selected', 'Please Select Shipment List', 'warning');
    }
}

function shipment_commercial_invoice() {
    var row = $('#shipment').datagrid('getSelected');
    if (row !== null) {
        open_target('POST', base_url + 'shipment/commercial_invoice', {id: row.id}, '_blank');
    } else {
        $.messager.alert('No Shipment List Selected', 'Please Select Shipment List', 'warning');
    }
}

function shipment_detail_search(){
    var row = $('#shipment').datagrid('getSelected');
    var postData = $('#shipment_detail_search_form').serializeObject();
    $.extend(postData, {shipmentid: row.id});
    $('#shipment_detail').datagrid('reload', postData);
//    $('#shipment_detail').datagrid('reload', $('#shipment_detail_search_form').serializeObject());
}


function shipment_submit() {
    var row = $('#shipment').datagrid('getSelected');
    var row_shpment_detail = $('#shipment_detail').datagrid('getRows');
    //alert(arr.length); 
    if ((row !== null) && (row_shpment_detail.length>0)){
        $.messager.confirm('Submit Packing List', 'After submited you can not change the PL anymore<br/><br/><center>Are you sure?</center>', function (r) {
            if (r) {
                $.post(base_url + 'shipment/submit', {id: row.id}, function (result) {
                    if (result.success) {
                    $('#shipment_submit_id').linkbutton('disable');
                    $('#shipment_edit_id').linkbutton('disable');
                    $('#shipment_delete_id').linkbutton('disable');
                        $('#shipment').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Shipment Warning', 'No Purchase Order Selected or no item to be submitted', 'warning');
    }
}