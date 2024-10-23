/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* global base_url */

function protocol_test_search() {
    $('#protocol_test').datagrid('reload', $('#protocol_test_form_search').serializeObject());
}

function protocol_test_add() {
    if ($('#variabel_test_dialog')) {
        $('#bodydata').append("<div id='variabel_test_dialog'></div>");
    }

    $('#variabel_test_dialog').dialog({
        title: 'Packing Configuration',
        width: 600,
        height: 'auto',
        href: base_url + 'protocol_test/input',
        modal: true,
        resizable: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    protocol_test_save('no-image.jpg');
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#variabel_test_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
//            $('#protocol_test_input_form').form('clear');
        }
    });
    url = base_url + 'protocol_test/save/0';
}

function protocol_test_save(file_name) {
    if ($('#protocol_test_input_form').form('validate')) {
        $('#protocol_test_input_form').form('submit', {
            url: url,
            onSubmit: function (param) {
                param.last_file_name = file_name
            },
            success: function (content) {
                console.log(content);
                var result = eval('(' + content + ')');
                if (result.success) {
                    $('#protocol_test').datagrid('reload');
                    $('#variabel_test_dialog').dialog('close');
                    if (result.msg !== '') {
                        $.messager.show({
                            title: 'File Upload Message',
                            msg: result.msg,
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

function protocol_test_edit() {
    var row = $('#protocol_test').datagrid('getSelected');
    if (row !== null) {
        if ($('#variabel_test_dialog')) {
            $('#bodydata').append("<div id='variabel_test_dialog'></div>");
        }
        $('#variabel_test_dialog').dialog({
            title: 'Edit Product',
            width: 600,
            height: 'auto',
            href: base_url + 'protocol_test/input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        protocol_test_save(row.image);
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#variabel_test_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#variabel_test_tr_component').remove();
                $('#protocol_test_input_form').form('load', row);
                var material_temp = row.material_id.replace(/[({}]/g, "");
                var material = material_temp.split(',');
                $('#material_id').combobox('setValues', material);
                $(this).dialog('center');
            }
        });
        url = base_url + 'protocol_test/save/' + row.id;
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function protocol_test_update_price() {
    var row = $('#protocol_test').datagrid('getSelected');
    if (row !== null) {
        if ($('#variabel_test_dialog')) {
            $('#bodydata').append("<div id='variabel_test_dialog'></div>");
        }
        $('#variabel_test_dialog').dialog({
            title: 'Update MSRP',
            width: 500,
            height: 'auto',
            href: base_url + 'protocol_test/update_price/' + row.id,
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#protocol_test_update_price_form').form('submit', {
                            url: base_url + 'protocol_test/do_update_price/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#protocol_test').datagrid('reload');
                                    $('#variabel_test_dialog').dialog('close');
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
                        $('#variabel_test_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#protocol_test_update_price_form').form('load', row);
                $('#variabel_test_dialog').dialog('center');
            }
        });
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function protocol_test_delete() {
    var row = $('#protocol_test').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'protocol_test/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#protocol_test').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function protocol_test_update_status(status) {
    var row = $('#protocol_test').datagrid('getSelected');
    if (row !== null) {
        if (row.iscomplete === 't') {
            var comment = '';
            if (status === 1) {
                comment = 'Are you sure you want to release this variabel_test?';
            } else if (status === 0) {
                comment = 'Are you sure you want to disable this variabel_test?';
            }
            $.messager.confirm('Confirm', comment, function (r) {
                if (r) {
                    $.post(base_url + 'protocol_test/update_status', {
                        id: row.id,
                        status: status
                    }, function (result) {
                        if (result.success) {
                            $('#protocol_test').datagrid('reload');
                        } else {
                            $.messager.alert('Error', result.msg, 'error');
                        }
                    }, 'json');
                }
            });
        } else {
            $.messager.alert('Uncomplete Component', 'Please complete the components', 'error');
        }
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function protocol_test_copy() {
    var row = $('#protocol_test').datagrid('getSelected');
    if ($('#variabel_test_dialog')) {
        $('#bodydata').append("<div id='variabel_test_dialog'></div>");
    }
    if (row !== null) {
        $('#variabel_test_dialog').dialog({
            title: 'Copy Product',
            width: 400,
            height: 'auto',
            top: 100,
            closed: false,
            cache: false,
            href: base_url + 'protocol_test/copy',
            modal: true,
            resizable: true,
            buttons: [
                {
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#protocol_test_copy_form').form('submit', {
                            url: base_url + 'protocol_test/do_copy/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#variabel_test_dialog').dialog('close');
                                    $('#protocol_test').datagrid('reload');
                                } else {
                                    $.messager.alert('Error', result.msg, 'error');
                                }
                            }
                        });
                    }
                },
                {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#variabel_test_dialog').dialog('close');
                    }
                }
            ],
            onLoad: function () {
                $('#protocol_test_copy_form').form('load', row);
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

/* ------------------------------------------ Products Component ----------------------------------- */
function protocol_test_component_add(component_type_id) {
    //    alert(component_type_id);

    if ($('#variabel_test_dialog')) {
        $('#bodydata').append("<div id='variabel_test_dialog'></div>");
    }

    var msg_check = protocol_test_component_check_duplicate(component_type_id);
    if (msg_check === '') {
        var row = $('#protocol_test').datagrid('getSelected');
        if (row !== null) {
            $('#variabel_test_dialog').dialog({
                title: 'New Product Component',
                width: 460,
                height: 'auto',
                href: base_url + 'protocol_test/component_input/' + component_type_id + '/add',
                modal: true,
                resizable: true,
                top: 60,
                buttons: [{
                        text: 'Save',
                        iconCls: 'icon-save',
                        handler: function () {
                            protocol_test_component_save();
                        }
                    }, {
                        text: 'Close',
                        iconCls: 'icon-remove',
                        handler: function () {
                            $('#variabel_test_dialog').dialog('close');
                        }
                    }],
                onLoad: function () {
                    $(this).dialog('center');
                    $('#protocol_test_component_input').form('clear');
                    $('#protocol_test_component_input input[name=component_type_id]').val(component_type_id);
                    if (component_type_id === 3) {
                        $('#protocol_test_width_').numberbox('setValue', row.width);
                        $('#protocol_test_depth_').numberbox('setValue', row.depth);
                        //                        $('#protocol_test_height_').numberbox('setValue',row.height);                        
                    }
                    if (component_type_id === 1 || component_type_id === 2) {
                        $('#protocol_test_width_').numberbox('setValue', row.width);
                        $('#protocol_test_depth_').numberbox('setValue', row.depth);
                        $('#protocol_test_height_').numberbox('setValue', row.height);
                    }
                }
            });
            url = base_url + 'protocol_test/component_save/' + row.id + '/0';
        } else {
            $.messager.alert('No Product Material Selected', 'Please Select Product Material', 'warning');
        }
    } else {
        $.messager.alert('System Interupted for Duplicate', msg_check, 'error');
    }
}

function protocol_test_component_edit() {
    var row = $('#protocol_test_component').datagrid('getSelected');
    if (row !== null) {
        if ($('#variabel_test_dialog')) {
            $('#bodydata').append("<div id='variabel_test_dialog'></div>");
        }
        $('#variabel_test_dialog').dialog({
            title: 'Edit Product Component',
            width: 460,
            height: 'auto',
            href: base_url + 'protocol_test/component_input/' + row.component_type_id + '/edit',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        protocol_test_component_save()
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#variabel_test_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
                $('#protocol_test_component_input').form('load', row);

            }
        });
        url = base_url + 'protocol_test/component_save/' + row.protocol_test_id + '/' + row.id;
    } else {
        $.messager.alert('No Product Component Selected', 'Please Select Product Component', 'warning');
    }
}

function protocol_test_component_update_price_and_vendor() {
    var row = $('#protocol_test_component').datagrid('getSelected');
    if (row !== null) {
        if ($('#variabel_test_dialog')) {
            $('#bodydata').append("<div id='variabel_test_dialog'></div>");
        }
        $('#variabel_test_dialog').dialog({
            title: 'Update Price & Vendor',
            width: 460,
            height: 'auto',
            href: base_url + 'protocol_test/component_update_price_and_vendor/' + row.component_type_id + '/edit/upnv',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#protocol_test_component_input').form('submit', {
                            url: base_url + 'protocol_test/component_do_update_price_and_vendor/' + row.protocol_test_id + '/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#variabel_test_dialog').dialog('close');
                                    $('#protocol_test_component').datagrid('reload');
                                    $('#protocol_test').datagrid('reload');
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
                        $('#variabel_test_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
                $('#protocol_test_component_input').form('load', row);

            }
        });
    } else {
        $.messager.alert('No Product Component Selected', 'Please Select Product Component', 'warning');
    }
}

function protocol_test_component_save() {
    $('#protocol_test_component_input').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#variabel_test_dialog').dialog('close');
                $('#protocol_test_component').datagrid('reload');
                $('#protocol_test').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}



function protocol_test_component_delete() {
    var row = $('#protocol_test_component').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'protocol_test/component_delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#protocol_test_component').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Product Component Selected', 'Please Select Product Component', 'warning');
    }
}

function protocol_test_component_check_duplicate(component_type_id) {
    var row = $('#protocol_test_component').datagrid('getRows');
    var arr_reject_duplicate = [1, 2, 3];
    var found = 0;
    if (arr_reject_duplicate.indexOf(component_type_id) !== -1) {
        for (var i = 0; i < row.length; i++) {
            console.log(row[i].component_type_id + '=' + component_type_id);
            if (row[i].component_type_id == '1'
                    || (row[i].component_type_id == component_type_id)
                    || (component_type_id == '1' && row[i].component_type_id === '2')
                    || (component_type_id == '1' && row[i].component_type_id === '3')) {
                found = 1;
                break;
            }

            if (component_type_id == row[i].component_type_id) {
                found = 1;
                break;
            }
        }
    }
    if (component_type_id === 4) {
        for (i = 0; i < row.length; i++) {
            if (row[i].component_type_id === '4') {
                found = 1;
                break;
            }
        }
    }

    return (found === 1 ? 'Selected Component Already Exist' : '');
}

/* ------------------------------------------ Products Box ----------------------------------- */

function protocol_test_variabel_test_add() {
    var row = $('#protocol_test').datagrid('getSelected');
    if (row !== null) {
        if ($('#variabel_test_dialog')) {
            $('#bodydata').append("<div id='variabel_test_dialog'></div>");
        }
        $('#variabel_test_dialog').dialog({
            title: 'Packing Configuration',
            width: 500,
            height: 'auto',
            href: base_url + 'protocol_test/variabel_test_input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        protocol_test_variabel_test_save();
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#variabel_test_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#protocol_test_variabel_test_input').form('clear');
                $('#variabel_test_dialog').dialog('center');
            }
        });
        url = base_url + 'protocol_test/variabel_test_save/' + row.id + '/0';
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }

}

function protocol_test_variabel_test_save() {
    $('#protocol_test_variabel_test_input').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#variabel_test_dialog').dialog('close');
                $('#protocol_test_variabel_test').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function protocol_test_variabel_test_edit() {
    var row = $('#protocol_test_variabel_test').datagrid('getSelected');
    if (row !== null) {
        if ($('#variabel_test_dialog')) {
            $('#bodydata').append("<div id='variabel_test_dialog'></div>");
        }
        $('#variabel_test_dialog').dialog({
            title: 'Edit Variabel Test',
            width: 500,
            height: 'auto',
            href: base_url + 'protocol_test/variabel_test_input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        protocol_test_variabel_test_save();
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#variabel_test_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#protocol_test_variabel_test_input').form('load', row);
            }
        });
        url = base_url + 'protocol_test/variabel_test_save/' + row.protocol_test_id + '/' + row.id;
    } else {
        $.messager.alert('No Variabel Test Selected', 'Please Select Variabel Test', 'warning');
    }
}

function protocol_test_variabel_test_delete() {
    var row = $('#protocol_test_variabel_test').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'protocol_test/variabel_test_delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#protocol_test_variabel_test').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Variabel Test Selected', 'Please Select Variabel Test', 'warning');
    }
}
function variabel_test_download() {
            open_target('POST', base_url + 'protocol_test/download', '', '_blank');
}

