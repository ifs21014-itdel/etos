



/* global base_url */

var receiving_url = '';

function receiving_search(){
    $('#receiving').datagrid('reload', $('#receiving_search_form').serializeObject());
}

function receiving_add() {

    if ($('#receiving_dialog')) {
        $('#bodydata').append("<div id='receiving_dialog'></div>");
    }
    $('#receiving_dialog').dialog({
        title: 'NEW DELIVERY RECEIPT',
        width: '400',
        height: 'auto',
        href: base_url + 'receiving/input',
        modal: true,
        resizable: false,
        shadow: false,
        maximizable: true,
        collapsible: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    $('#receive_input_form').form('submit', {
                        url: base_url + 'receiving/save/0',
                        onSubmit: function () {
                            return $(this).form('validate');
                        },
                        success: function (content) {
                            var result = eval('(' + content + ')');
                            if (result.success) {
                                $('#receiving_dialog').dialog('close');
                                $('#receiving').datagrid('reload');
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
                    $('#receiving_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
        }
    });
}

function receiving_edit() {
    var row = $('#receiving').datagrid('getSelected');
    if (row !== null) {
        if ($('#receiving_dialog')) {
            $('#bodydata').append("<div id='receiving_dialog'></div>");
        }
        $('#receiving_dialog').dialog({
            title: 'EDIT DELIVERY RECEIPT',
            width: '400',
            height: 'auto',
            href: base_url + 'receiving/input',
            modal: true,
            resizable: false,
            shadow: false,
//            maximizable: true,
//            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#receive_input_form').form('submit', {
                            url: base_url + 'receiving/save/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#receiving_dialog').dialog('close');
                                    $('#receiving').datagrid('reload');
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
                        $('#receiving_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
                $('#receive_input_form').form('load', row);
                var rows_detail = $('#receiving_detail').datagrid('getRows');
                console.log(rows_detail.length);
                if (rows_detail.length > 0) {
                    $('#receiving_vendor_id').combobox('readonly', true);
                }
            }
        });
    } else {
        $.messager.alert('No Receive List Selected', 'Please Select Receive List', 'warning');
    }
}

function receiving_delete() {
    var row = $('#receiving').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'These data will be permanently deleted and cannot be recovered.<br/>Are you sure?', function (r) {
            if (r) {
                $.post(base_url + 'receiving/delete', {
                    id: row.id
                }, function (result) {
                    console.log(result.success);
                    if (result.success) {
                        $('#receiving').datagrid('reload');
                        $('#receiving_detail').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Receive List Selected', 'Please Select Receive List', 'warning');
    }
}

function receiving_detail_add_multi() {
    var row = $('#receiving').datagrid('getSelected');
    if (row !== null) {
        if ($('#receiving_dialog')) {
            $('#bodydata').append("<div id='receiving_dialog'></div>");
        }
        $('#receiving_dialog').dialog({
            title: 'Product List',
            width: '60%',
            height: '90%',
            href: base_url + 'receiving/detail_add_multi/' + row.vendor_id,
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        var rows = $('#receive_detail_product_available').datagrid('getSelections');
                        if (rows.length > 0) {
                            var serial_number = new Array();
                            for (var i = 0; i < rows.length; i++) {
                                serial_number.push(rows[i].serial_number);
                            }
                            $.post(base_url + 'receiving/detail_save_multi', {
                                receiveid: row.id,
                                serial_number: serial_number
                            }, function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#receiving_dialog').dialog('close');
                                    $('#receiving_detail').datagrid('reload');
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
                        $('#receiving_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No Receive List Selected', 'Please Select Receive List', 'warning');
    }
}

function receiving_detail_add() {
    var row = $('#receiving').datagrid('getSelected');
    if (row !== null) {
        receiving_detail_input_form('add', 'NEW PRODUCT', null);
        receiving_url = base_url + 'receiving/detail_save/0/' + row.id;
    } else {
        $.messager.alert('No Receive List Selected', 'Please Select Receive List', 'warning');
    }
}
function receiving_detail_input_form(type, title, row) {
    if ($('#receiving_dialog')) {
        $('#bodydata').append("<div id='receiving_dialog'></div>");
    }
    $('#receiving_dialog').dialog({
        title: title,
        width: '40%',
        height: 'auto',
        href: base_url + 'receiving/detail_input',
        modal: true,
        resizable: false,
        shadow: false,
        maximizable: true,
        collapsible: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    receiving_detail_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#receiving_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#receiving_detail_form').form('load', row);
            } else {
                $('#receiving_detail_form').form('clear');
            }
        }
    });
}

function receiving_detail_save() {
    $('#ff').form({
        url: receiving_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#color_dialog').dialog('close');
                $('#color').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function receiving_detail_delete() {
    var rows = $('#receiving_detail').datagrid('getSelections');
    if (rows.length > 0) {
        var ids = new Array();
        for (var i = 0; i < rows.length; i++) {
            ids.push(rows[i].id);
        }
        $.messager.confirm('Confirm', 'Are you sure to remove selections data?', function (r) {
            if (r) {
                $.post(base_url + 'receiving/detail_delete', {
                    id: ids
                }, function (result) {
                    console.log(result);
                    if (result.success) {
                        $('#receiving_detail').datagrid('reload');
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

function receiving_detail_import() {
    var row = $('#receiving').datagrid('getSelected');
    if (row !== null) {

        if ($('#receiving_dialog')) {
            $('#bodydata').append("<div id='receiving_dialog'></div>");
        }
        $('#receiving_dialog').dialog({
            title: 'Import',
            width: 400,
            height: 'auto',
            href: base_url + 'receiving/detail_import',
            modal: true,
            resizable: false,
            shadow: false,
            maximizable: true,
            collapsible: true,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        if ($('#receiving_detail_import_form').form('validate')) {
                            $('#receiving_detail_import_form').form('submit', {
                                url: base_url + 'receiving/detail_do_import/' + row.id,
                                success: function (content) {
                                    console.log(content);
                                    var result = eval('(' + content + ')');
                                    if (result.status === 'success' || result.status === 'warning') {
                                        $('#receiving_detail').datagrid('reload');
                                        $('#receiving_dialog').dialog('close');
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
                        $('#receiving_dialog').dialog('close');
                    }
                }]
        });
    } else {
        $.messager.alert('No Receive List Selected', 'Please Select Receive List', 'warning');
    }
}

