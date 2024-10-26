/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* global base_url */

function hot_cold_test_list_search() {
    $('#hot_cold_test_list').datagrid('reload', $('#hot_cold_test_list_form_search').serializeObject());
}

function hot_cold_test_list_add() {
    if ($('#hot_cold_test_list_detail_dialog')) {
        $('#bodydata').append("<div id='hot_cold_test_list_detail_dialog'></div>");
    }

    $('#hot_cold_test_list_detail_dialog').dialog({
        title: 'Packing Configuration',
        width: 700,
        height: 'auto',
        href: base_url + 'hot_cold_test_list/input',
        modal: true,
        resizable: true,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    hot_cold_test_list_save('no-image.jpg');
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#hot_cold_test_list_detail_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
//            $('#hot_cold_test_list_input_form').form('clear');
        }
    });
    url = base_url + 'hot_cold_test_list/save/0';
}

function hot_cold_test_list_save(file_name) {
    if ($('#hot_cold_test_list_input_form').form('validate')) {
        $('#hot_cold_test_list_input_form').form('submit', {
            url: url,
            onSubmit: function (param) {
                param.last_file_name = file_name
            },
            success: function (content) {
                console.log(content);
                var result = eval('(' + content + ')');
                if (result.success) {
                    $('#hot_cold_test_list').datagrid('reload');
                    $('#hot_cold_test_list_detail_dialog').dialog('close');
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

function hot_cold_test_list_edit() {
    var row = $('#hot_cold_test_list').datagrid('getSelected');
    if (row !== null) {
        if ($('#hot_cold_test_list_detail_dialog')) {
            $('#bodydata').append("<div id='hot_cold_test_list_detail_dialog'></div>");
        }
        $('#hot_cold_test_list_detail_dialog').dialog({
            title: 'Edit Product',
            width: 600,
            height: 'auto',
            href: base_url + 'hot_cold_test_list/input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    hot_cold_test_list_save(row.image);
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#hot_cold_test_list_detail_dialog').dialog('close');
                }
            }],
            onLoad: function () {
                // Remove any unnecessary elements
                $('#hot_cold_test_list_detail_tr_component').remove();

                // Set individual form values manually
                $('#hot_cold_test_protocol_id').combobox('setValue', row.protocol_test_id);  
                $('#hot_cold_test_vendor_id').combogrid('setValue', row.vendor_id);  
                $('#hot_cold_test_client_id').combogrid('setValue', row.client_id );  
                $('#hot_cold_test_product_id').combogrid('setValue', row.product_id ); 
                $('#hot_cold_test_date_id').datebox('setValue', row.test_date);
                $('#hot_cold_test_report_date_id').datebox('setValue', row.report_date);
                $('#hot_cold_test_report_no_id').val(row.report_no);
                $('#hot_cold_test_notes_id').val(row.notes);
                
                $('#hot_cold_test_condition_a_temp_id').val(row.condition_a_temp);
                $('#hot_cold_test_condition_a_duration_id').val(row.condition_a_duration);
                $('#hot_cold_test_room_temp_rest_a_duration_id').val(row.room_temp_rest_a_duration);
                
                $('#hot_cold_test_condition_b_temp_id').val(row.condition_b_temp);
                $('#hot_cold_test_condition_b_duration_id').val(row.condition_b_duration);
                $('#hot_cold_test_room_temp_rest_b_duration_id').val(row.room_temp_rest_b_duration);
                $('#hot_cold_test_corrective_action_plan_image').val(row.corrective_action_plan_image);
                
                $('#hot_cold_test_cycles_id').val(row.cycles);

                // Center the dialog
                $(this).dialog('center');
            }
        });

        // Define URL for saving data
        url = base_url + 'hot_cold_test_list/save/' + row.id;
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}


function hot_cold_test_list_update_price() {
    var row = $('#hot_cold_test_list').datagrid('getSelected');
    if (row !== null) {
        if ($('#hot_cold_test_list_detail_dialog')) {
            $('#bodydata').append("<div id='hot_cold_test_list_detail_dialog'></div>");
        }
        $('#hot_cold_test_list_detail_dialog').dialog({
            title: 'Update MSRP',
            width: 500,
            height: 'auto',
            href: base_url + 'hot_cold_test_list/update_price/' + row.id,
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#hot_cold_test_list_update_price_form').form('submit', {
                            url: base_url + 'hot_cold_test_list/do_update_price/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#hot_cold_test_list').datagrid('reload');
                                    $('#hot_cold_test_list_detail_dialog').dialog('close');
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
                        $('#hot_cold_test_list_detail_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#hot_cold_test_list_update_price_form').form('load', row);
                $('#hot_cold_test_list_detail_dialog').dialog('center');
            }
        });
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}

function hot_cold_test_list_delete() {
    var row = $('#hot_cold_test_list').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'hot_cold_test_list/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#hot_cold_test_list').datagrid('reload');
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

function hot_cold_test_list_update_status(status) {
    var row = $('#hot_cold_test_list').datagrid('getSelected');
    if (row !== null) {
        if (row.iscomplete === 't') {
            var comment = '';
            if (status === 1) {
                comment = 'Are you sure you want to release this hot_cold_test_list_detail?';
            } else if (status === 0) {
                comment = 'Are you sure you want to disable this hot_cold_test_list_detail?';
            }
            $.messager.confirm('Confirm', comment, function (r) {
                if (r) {
                    $.post(base_url + 'hot_cold_test_list/update_status', {
                        id: row.id,
                        status: status
                    }, function (result) {
                        if (result.success) {
                            $('#hot_cold_test_list').datagrid('reload');
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

function hot_cold_test_list_copy() {
    var row = $('#hot_cold_test_list').datagrid('getSelected');
    if ($('#hot_cold_test_list_detail_dialog')) {
        $('#bodydata').append("<div id='hot_cold_test_list_detail_dialog'></div>");
    }
    if (row !== null) {
        $('#hot_cold_test_list_detail_dialog').dialog({
            title: 'Copy Product',
            width: 400,
            height: 'auto',
            top: 100,
            closed: false,
            cache: false,
            href: base_url + 'hot_cold_test_list/copy',
            modal: true,
            resizable: true,
            buttons: [
                {
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#hot_cold_test_list_copy_form').form('submit', {
                            url: base_url + 'hot_cold_test_list/do_copy/' + row.id,
                            onSubmit: function () {
                                return $(this).form('validate');
                            },
                            success: function (content) {
                                console.log(content);
                                var result = eval('(' + content + ')');
                                if (result.success) {
                                    $('#hot_cold_test_list_detail_dialog').dialog('close');
                                    $('#hot_cold_test_list').datagrid('reload');
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
                        $('#hot_cold_test_list_detail_dialog').dialog('close');
                    }
                }
            ],
            onLoad: function () {
                $('#hot_cold_test_list_copy_form').form('load', row);
                $(this).dialog('center');
            }
        });
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}



/* ------------------------------------------ Products Box ----------------------------------- */

function hot_cold_test_list_hot_cold_test_list_detail_add() {
    var row = $('#hot_cold_test_list').datagrid('getSelected');
    if (row !== null) {
        if ($('#hot_cold_test_list_detail_dialog')) {
            $('#bodydata').append("<div id='hot_cold_test_list_detail_dialog'></div>");
        }
        $('#hot_cold_test_list_detail_dialog').dialog({
            title: 'Packing Configuration',
            width: 500,
            height: 'auto',
            href: base_url + 'hot_cold_test_list/hot_cold_test_list_detail_input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        hot_cold_test_list_hot_cold_test_list_detail_save();
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#hot_cold_test_list_detail_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#hot_cold_test_list_hot_cold_test_list_detail_input').form('clear');
                $('#hot_cold_test_list_detail_dialog').dialog('center');
            }
        });
        url = base_url + 'hot_cold_test_list/hot_cold_test_list_detail_save/' + row.id + '/0';
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }

}

function hot_cold_test_list_hot_cold_test_list_detail_save() {
    $('#hot_cold_test_list_hot_cold_test_list_detail_input').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#hot_cold_test_list_detail_dialog').dialog('close');
                $('#hot_cold_test_list_hot_cold_test_list_detail').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function hot_cold_test_list_hot_cold_test_list_detail_edit() {
    var row = $('#hot_cold_test_list_hot_cold_test_list_detail').datagrid('getSelected');
    if (row !== null) {
        if ($('#hot_cold_test_list_detail_dialog')) {
            $('#bodydata').append("<div id='hot_cold_test_list_detail_dialog'></div>");
        }
        $('#hot_cold_test_list_detail_dialog').dialog({
            title: 'Edit Variabel Test',
            width: 500,
            height: 'auto',
            href: base_url + 'hot_cold_test_list/hot_cold_test_list_detail_input',
            modal: true,
            resizable: true,
            top: 60,
            buttons: [{
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        hot_cold_test_list_hot_cold_test_list_detail_save();
                    }
                }, {
                    text: 'Close',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#hot_cold_test_list_detail_dialog').dialog('close');
                    }
                }],
            onLoad: function () {
                $('#hot_cold_test_list_hot_cold_test_list_detail_input').form('load', row);
            }
        });
        url = base_url + 'hot_cold_test_list/hot_cold_test_list_detail_save/' + row.hot_cold_test_list_id + '/' + row.id;
    } else {
        $.messager.alert('No Variabel Test Selected', 'Please Select Variabel Test', 'warning');
    }
}

function hot_cold_test_list_hot_cold_test_list_detail_delete() {
    var row = $('#hot_cold_test_list_hot_cold_test_list_detail').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'hot_cold_test_list/hot_cold_test_list_detail_delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#hot_cold_test_list_hot_cold_test_list_detail').datagrid('reload');
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
function hot_cold_test_list_detail_download() {
            open_target('POST', base_url + 'hot_cold_test_list/download', '', '_blank');
}
//======================================================================
function hot_cold_test_list_variabel_test_add(type_form) {
    var row = $('#hot_cold_test_list_hot_cold_test_list_detail').datagrid('getSelected');
    //alert (row.isnpection_id);
    if (row !== null) {
        hot_cold_test_list_variabel_test_form('edit', 'ADD IMAGE', row, row.id,type_form)
        url = base_url + 'hot_cold_test_list/variabel_test_save/'  +row.hot_cold_test_list_id+'/'+ row.id;
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}
function hot_cold_test_list_variabel_test_form(type, title, row, id,type_form) {
    if ($('#hot_cold_test_list_variabel_test_dialog_photo')) {
        $('#bodydata').append("<div id='hot_cold_test_list_variabel_test_dialog_photo'></div>");
    }
    $('#hot_cold_test_list_variabel_test_dialog_photo').dialog({
        title: title,
        width: 500,
        height: 'auto',
        href: base_url + 'hot_cold_test_list/variabel_test_input/' + id+ '/' + type_form,
        modal: true,
        resizable: true,
        overflow: 'auto',
        top: 5,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    hot_cold_test_list_variabel_test_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#hot_cold_test_list_variabel_test_dialog_photo').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            $('#hot_cold_test_list_hot_cold_test_list_detail_input_image').form('load', row);
        }
    });
}
function hot_cold_test_list_variabel_test_save() {
    $('#hot_cold_test_list_hot_cold_test_list_detail_input_image').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            console.log(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#hot_cold_test_list_variabel_test_dialog_photo').dialog('close');
                $('#hot_cold_test_list_hot_cold_test_list_detail').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function hot_cold_test_list_submit(result_status) {
    var row = $('#hot_cold_test_list').datagrid('getSelected');
    var row_hot_cold_test_list_detail = $('#hot_cold_test_list_hot_cold_test_list_detail').datagrid('getRows');
    //alert(arr.length); 
    if ((row !== null) && (row_hot_cold_test_list_detail.length>0)){
        $.messager.confirm('Submit Submited', 'After submited you can not change the droptest item anymore<br/><br/><center>Are you sure?</center>', function (r) {
            if (r) {
                $.post(base_url + 'hot_cold_test_list/submit', {id: row.id,result_s:result_status}, function (result) {
                    if (result.success) {
                    $('#hot_cold_test_list_submit_id').linkbutton('disable');
                    $('#hot_cold_test_list_edit_id').linkbutton('disable');
                    $('#hot_cold_test_list_delete_id').linkbutton('disable');
                        $('#hot_cold_test_list').datagrid('reload');
                        $('#hot_cold_test_list_hot_cold_test_list_detail').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Submitted Drop Test  Warning', 'No Drop Test or no item to be submitted', 'warning');
    }
}
function print_hot_cold_test_list(type,view_type) {
    var row = $('#hot_cold_test_list').datagrid('getSelected');
    if (row !== null) {
        if (view_type === 'view')
            open_target('POST', base_url + 'hot_cold_test_list/prints', {id: row.id,jenis_laporan:view_type}, '_blank');
        else
            open_target('POST', base_url + 'hot_cold_test_list/generate_pdf', {id: row.id,jenis_laporan:view_type}, '_blank');
    } else {
        $.messager.alert('No Inspection List Selected', 'Please Select Inspection List', 'warning');
    }
}
function hot_cold_test_list_variabel_test_view_detail(id) {
    var row = $('#hot_cold_test_list_hot_cold_test_list_detail').datagrid('getSelected');
    if ($('#hot_cold_test_list_image_detail_dialog')) {
        $('#bodydata').append("<div id='hot_cold_test_list_image_detail_dialog'></div>");
    }
    $('#hot_cold_test_list_image_detail_dialog').dialog({
        title: 'Image View',
        width: 300,
        height: 'auto',
        href: base_url + 'hot_cold_test_list/product_image_detail/' + row.id,
        modal: true,
        resizable: true,
        overflow: 'auto',
        top: 5,
        buttons: [{
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#hot_cold_test_list_image_detail_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            $('#hot_cold_test_list_detail_image_form').form('load', row);
        }
    });
}

function hot_cold_test_list_excel() {
    console.log("Excel button clicked");
    var row = $('#hot_cold_test_list').datagrid('getSelected');
    if (row !== null) {
        open_target('post', base_url + 'hot_cold_test_list/excel', {
            id: row.id
        }, 'box_iframe');
    } else {
        $.messager.alert('No Inspection List Selected', 'Please Select Inspection List', 'warning');
    }
}
