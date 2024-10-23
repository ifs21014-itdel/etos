/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

function productiontracking_search() {
    $('#production_tracking_product_list').datagrid('reload', $('#production_tracking_product_list_search_form').serializeObject());
}

function productiontracking_export_to_excel() {
    open_target('POST', base_url + 'productiontracking/export_to_excel', $('#production_tracking_product_list_search_form').serializeObject(), '_blank');
}

function productiontracking_update_status() {
    var rows = $('#production_tracking_product_list').datagrid('getSelections');
    if (rows.length > 0) {
        var serial_number = new Array();
        for (var i = 0; i < rows.length; i++) {
            serial_number.push(rows[i].serial_number)
        }
        if ($('#productiontracking_dialog')) {
            $('#bodydata').append("<div id='productiontracking_dialog'></div>");
        }
        $('#productiontracking_dialog').dialog({
            title: 'Update Status',
            width: 400,
            height: 'auto',
            href: base_url + 'productiontracking/update_status',
            modal: true,
            resizable: false,
            shadow: false,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        if ($('#production_tracking_update_status_form').form('validate')) {
                            $('#production_tracking_update_status_form').form('submit', {
                                url: base_url + 'productiontracking/do_update_status',
                                onSubmit: function (param) {
                                    param.serial_number = serial_number;
                                },
                                success: function (content) {
                                    var result = eval('(' + content + ')');
                                    if (result.success) {
                                        $("#productiontracking_dialog").dialog('close');
                                        $('#production_tracking_product_list').datagrid('reload');
                                    } else {
                                        display_error_message(result.msg);
                                    }
                                }
                            });
                        }
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#productiontracking_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No Serial Number Selected', 'Please Select Serial Number', 'warning');
    }
}

function productiontracking_import() {
    if ($('#productiontracking_dialog')) {
        $('#bodydata').append("<div id='productiontracking_dialog'></div>");
    }
    $('#productiontracking_dialog').dialog({
        title: 'Import File',
        width: 400,
        height: 'auto',
        href: base_url + 'productiontracking/import',
        modal: true,
        resizable: false,
        shadow: false,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    if ($('#production_tracking_import_form').form('validate')) {
                        $('#production_tracking_import_form').form('submit', {
                            url: base_url + 'productiontracking/do_import',
                            success: function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.status === 'success' || result.status === 'warning') {
                                    $('#production_tracking_product_list').datagrid('reload');
                                    $('#productiontracking_dialog').dialog('close');
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
                    $('#productiontracking_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
        }
    });
}

function productiontracking_reload_chart(po_id) {
    $('#chart_content').panel('open').panel('refresh', base_url + 'productiontracking/load_chart/' + po_id);
}