/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* global base_url */

function products_search() {
    $('#products').datagrid('reload', $('#products_form_search').serializeObject());
}

function products_add() {
    if ($('#product_dialog')) {
        $('#bodydata').append("<div id='product_dialog'></div>");
    }

    $('#product_dialog').dialog({
        title: 'Packing Configuration',
        width: 600,
        height: 'auto',
        href: base_url + 'products/input',
        modal: true,
        resizable: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    products_save('no-image.jpg');
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#product_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
//            $('#products_input_form').form('clear');
        }
    });
    url = base_url + 'products/save/0';
}

function products_save(file_name) {
    if ($('#products_input_form').form('validate')) {
        $('#products_input_form').form('submit', {
            url: url,
            onSubmit: function (param) {
                param.last_file_name = file_name
            },
            success: function (content) {
                console.log(content);
                var result = eval('(' + content + ')');
                if (result.success) {
                    $('#products').datagrid('reload');
                    $('#product_dialog').dialog('close');
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

function products_edit() {
    var row = $('#products').datagrid('getSelected');
    if (row !== null) {
        if ($('#product_dialog')) {
            $('#bodydata').append("<div id='product_dialog'></div>");
        }
        $('#product_dialog').dialog({
            title: 'Edit Product',
            width: 600,
            height: 'auto',
            href: base_url + 'products/input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        products_save(row.image);
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#product_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#product_tr_component').remove();
                $('#products_input_form').form('load', row);
                var material_temp = row.material_id.replace(/[({}]/g, "");
                var material = material_temp.split(',');
                $('#material_id').combobox('setValues', material);
                $(this).dialog('center');
            }
        });
        url = base_url + 'products/save/' + row.id;
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function products_update_price() {
    var row = $('#products').datagrid('getSelected');
    if (row !== null) {
        if ($('#product_dialog')) {
            $('#bodydata').append("<div id='product_dialog'></div>");
        }
        $('#product_dialog').dialog({
            title: 'Update MSRP',
            width: 500,
            height: 'auto',
            href: base_url + 'products/update_price/' + row.id,
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#products_update_price_form').form('submit', {
                            url: base_url + 'products/do_update_price/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#products').datagrid('reload');
                                    $('#product_dialog').dialog('close');
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
                        $('#product_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#products_update_price_form').form('load', row);
                $('#product_dialog').dialog('center');
            }
        });
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function products_delete() {
    var row = $('#products').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'products/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#products').datagrid('reload');
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

function products_update_status(status) {
    var row = $('#products').datagrid('getSelected');
    if (row !== null) {
        if (row.iscomplete === 't') {
            var comment = '';
            if (status === 1) {
                comment = 'Are you sure you want to release this product?';
            } else if (status === 0) {
                comment = 'Are you sure you want to disable this product?';
            }
            $.messager.confirm('Confirm', comment, function (r) {
                if (r) {
                    $.post(base_url + 'products/update_status', {
                        id: row.id,
                        status: status
                    }, function (result) {
                        if (result.success) {
                            $('#products').datagrid('reload');
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

function products_copy() {
    var row = $('#products').datagrid('getSelected');
    if ($('#product_dialog')) {
        $('#bodydata').append("<div id='product_dialog'></div>");
    }
    if (row !== null) {
        $('#product_dialog').dialog({
            title: 'Copy Product',
            width: 400,
            height: 'auto',
            top: 100,
            closed: false,
            cache: false,
            href: base_url + 'products/copy',
            modal: true,
            resizable: true,
            buttons: [
                {
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#products_copy_form').form('submit', {
                            url: base_url + 'products/do_copy/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#product_dialog').dialog('close');
                                    $('#products').datagrid('reload');
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
                        $('#product_dialog').dialog('close');
                    }
                }
            ],
            onLoad: function () {
                $('#products_copy_form').form('load', row);
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

/* ------------------------------------------ Products Component ----------------------------------- */
function products_component_add(component_type_id) {
    //    alert(component_type_id);

    if ($('#product_dialog')) {
        $('#bodydata').append("<div id='product_dialog'></div>");
    }

    var msg_check = products_component_check_duplicate(component_type_id);
    if (msg_check === '') {
        var row = $('#products').datagrid('getSelected');
        if (row !== null) {
            $('#product_dialog').dialog({
                title: 'New Product Component',
                width: 460,
                height: 'auto',
                href: base_url + 'products/component_input/' + component_type_id + '/add',
                modal: true,
                resizable: true,
                top: 60,
                buttons: [{
                        text: 'Save',
                        iconCls: 'icon-save',
                        handler: function () {
                            products_component_save();
                        }
                    }, {
                        text: 'Close',
                        iconCls: 'icon-remove',
                        handler: function () {
                            $('#product_dialog').dialog('close');
                        }
                    }],
                onLoad: function () {
                    $(this).dialog('center');
                    $('#products_component_input').form('clear');
                    $('#products_component_input input[name=component_type_id]').val(component_type_id);
                    if (component_type_id === 3) {
                        $('#products_width_').numberbox('setValue', row.width);
                        $('#products_depth_').numberbox('setValue', row.depth);
                        //                        $('#products_height_').numberbox('setValue',row.height);                        
                    }
                    if (component_type_id === 1 || component_type_id === 2) {
                        $('#products_width_').numberbox('setValue', row.width);
                        $('#products_depth_').numberbox('setValue', row.depth);
                        $('#products_height_').numberbox('setValue', row.height);
                    }
                }
            });
            url = base_url + 'products/component_save/' + row.id + '/0';
        } else {
            $.messager.alert('No Product Material Selected', 'Please Select Product Material', 'warning');
        }
    } else {
        $.messager.alert('System Interupted for Duplicate', msg_check, 'error');
    }
}

function products_component_edit() {
    var row = $('#products_component').datagrid('getSelected');
    if (row !== null) {
        if ($('#product_dialog')) {
            $('#bodydata').append("<div id='product_dialog'></div>");
        }
        $('#product_dialog').dialog({
            title: 'Edit Product Component',
            width: 460,
            height: 'auto',
            href: base_url + 'products/component_input/' + row.component_type_id + '/edit',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        products_component_save()
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#product_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
                $('#products_component_input').form('load', row);

            }
        });
        url = base_url + 'products/component_save/' + row.products_id + '/' + row.id;
    } else {
        $.messager.alert('No Product Component Selected', 'Please Select Product Component', 'warning');
    }
}

function products_component_update_price_and_vendor() {
    var row = $('#products_component').datagrid('getSelected');
    if (row !== null) {
        if ($('#product_dialog')) {
            $('#bodydata').append("<div id='product_dialog'></div>");
        }
        $('#product_dialog').dialog({
            title: 'Update Price & Vendor',
            width: 460,
            height: 'auto',
            href: base_url + 'products/component_update_price_and_vendor/' + row.component_type_id + '/edit/upnv',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#products_component_input').form('submit', {
                            url: base_url + 'products/component_do_update_price_and_vendor/' + row.products_id + '/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#product_dialog').dialog('close');
                                    $('#products_component').datagrid('reload');
                                    $('#products').datagrid('reload');
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
                        $('#product_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $(this).dialog('center');
                $('#products_component_input').form('load', row);

            }
        });
    } else {
        $.messager.alert('No Product Component Selected', 'Please Select Product Component', 'warning');
    }
}

function products_component_save() {
    $('#products_component_input').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#product_dialog').dialog('close');
                $('#products_component').datagrid('reload');
                $('#products').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}



function products_component_delete() {
    var row = $('#products_component').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'products/component_delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#products_component').datagrid('reload');
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

function products_component_check_duplicate(component_type_id) {
    var row = $('#products_component').datagrid('getRows');
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

function products_box_add() {
    var row = $('#products').datagrid('getSelected');
    if (row !== null) {
        if ($('#product_dialog')) {
            $('#bodydata').append("<div id='product_dialog'></div>");
        }
        $('#product_dialog').dialog({
            title: 'Packing Configuration',
            width: 500,
            height: 'auto',
            href: base_url + 'products/box_input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        products_box_save();
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#product_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#products_box_input').form('clear');
                $('#product_dialog').dialog('center');
            }
        });
        url = base_url + 'products/box_save/' + row.id + '/0';
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }

}

function products_box_save() {
    $('#products_box_input').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#product_dialog').dialog('close');
                $('#products_box').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function products_box_edit() {
    var row = $('#products_box').datagrid('getSelected');
    if (row !== null) {
        if ($('#product_dialog')) {
            $('#bodydata').append("<div id='product_dialog'></div>");
        }
        $('#product_dialog').dialog({
            title: 'Edit Product Box',
            width: 500,
            height: 'auto',
            href: base_url + 'products/box_input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        products_box_save();
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#product_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#products_box_input').form('load', row);
            }
        });
        url = base_url + 'products/box_save/' + row.products_id + '/' + row.id;
    } else {
        $.messager.alert('No Product Box Selected', 'Please Select Product Box', 'warning');
    }
}

function products_box_delete() {
    var row = $('#products_box').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'products/box_delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#products_box').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Product Box Selected', 'Please Select Product Box', 'warning');
    }
}
function product_download() {
            open_target('POST', base_url + 'products/download', '', '_blank');
}

