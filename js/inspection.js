/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* global base_url */

var inspection_url = '';

function inspection_search() {
    $('#inspection').datagrid('reload', $('#po_search_form').serializeObject());
}

function inspection_detail_search() {
    var row = $('#inspection').datagrid('getSelected');
    var postData = $('#inspection_detail_search_form').serializeObject();
    $.extend(postData, {inspectionid: row.id});
    $('#inspection_detail').datagrid('reload', postData);
}

function inspection_add() {
    inspection_input_form('add', 'New Inspection');
    inspection_url = base_url + 'inspection/save/0';
}
function inspection_edit() {
    var row = $('#inspection').datagrid('getSelected');
    inspection_input_form('edit', 'New Inspection', row);
    inspection_url = base_url + 'inspection/save/' + row.id;

}

function inspection_input_form(type, title, row) {
    if ($('#inspection_dialog')) {
        $('#bodydata').append("<div id='inspection_dialog'></div>");
    }
    $('#inspection_dialog').dialog({
        title: title,
        width: 350,
        height: 'auto',
        href: base_url + 'inspection/input',
        modal: true,
        resizable: false,
        shadow: false,
        maximizable: true,
        collapsible: true,
        buttons: [{
                text: '',
                iconCls: 'icon-save',
                handler: function () {
                    inspection_save();
                }
            }, {
                text: '',
                iconCls: 'icon-cancel',
                handler: function () {
                    $('#inspection_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#inspection_input_form').form('load', row);
            } else {
                $('#inspection_input_form').form('clear');
            }

        }
    });
}
function inspection_save() {
    if ($('#inspection_input_form').form('validate')) {
        $.post(inspection_url, $('#inspection_input_form').serializeObject(), function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#inspection').datagrid('reload');
                $('#inspection_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        });
    }
}

function inspection_release() {
    var row = $('#inspection').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Release P.O', 'With the release PO then the barcode will be automatically created, and you can not change the PO anymore<br/><br/><center>Are you sure?</center>', function (r) {
            if (r) {
                $.post(base_url + 'inspection/release', {id: row.id}, function (result) {
                    if (result.success) {
                        $('#inspection_release').linkbutton('disable');
                        $('#inspection').datagrid('reload');
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

function print_inspection(type) {
    var row = $('#inspection').datagrid('getSelected');
    if (row !== null) {
        if (type === 'single')
            open_target('POST', base_url + 'inspection/prints', {id: row.id}, '_blank');
        else
            open_target('POST', base_url + 'inspection/print_summary', {id: row.id}, '_blank');
    } else {
        $.messager.alert('No Inspection List Selected', 'Please Select Inspection List', 'warning');
    }
}

function inspection_download() {
    var row = $('#inspection').datagrid('getSelected');
    if (row !== null) {
        open_target('post', base_url + 'inspection/download', {
            id: row.id
        }, '_blank');
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}

function inspection_download_all_by_order_id() {
    var row = $('#inspection').datagrid('getSelected');
    if (row !== null) {
        open_target('post', base_url + 'inspection/download_all_by_order_id', {
            pi_id: row.pi_id
        }, '_blank');
    } else {
        $.messager.alert('No Purchase Order Selected', 'Please Select Purchase Order', 'warning');
    }
}
//-------------------------
function inspection_delete() {
    var row = $('#inspection').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure?', function (r) {
            if (r) {
                $.post(base_url + 'inspection/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#inspection').datagrid('reload');
                        $('#inspection_detail').datagrid('reload');
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

function inspection_product_add(idrow) {
    var row = $('#inspection_detail').datagrid('getSelected');
    //alert (row.isnpection_id);
    if (row !== null) {
        inspection_input_product_form('add', 'ADD IMAGE', null, row.id, row.isnpection_id,row.image_category_id)
        inspection_url = base_url + 'inspection/product_save/' + row.isnpection_id + '/' + row.id+'/'+row.image_category_id;
    } else {
        $.messager.alert('No Product Selected', 'Please Select Product', 'warning');
    }
}
function inspection_product_delete() {
    var row = $('#inspection_detail').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure?', function (r) {
            if (r) {
                $.post(base_url + 'inspection/product_delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#inspection_detail').datagrid('reload');
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
function inspection_product_save(inspection_id, id,image_category_id) {
    $('#inspection_product_input_form').form('submit', {
        url: inspection_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#inspection_detail').datagrid('reload');
                $('#inspection_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function inspection_input_product_form(type, title, row, id, inspection_id,image_category_id) {
    if ($('#inspection_dialog')) {
        $('#bodydata').append("<div id='inspection_dialog'></div>");
    }
    $('#inspection_dialog').dialog({
        title: title,
        width: 300,
        height: 'auto',
        href: base_url + 'inspection/product_input/' + inspection_id + '/' + id+ '/' + image_category_id,
        modal: true,
        resizable: true,
        overflow: 'auto',
        top: 5,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    inspection_product_save(inspection_id, id,image_category_id);
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#inspection_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            $('#inspection_product_input_form').form('load', row);
        }
    });
}

function inspection_product_view_detail(id) {
    var row = $('#inspection_detail').datagrid('getSelected');
    if ($('#inspection_image_detail_dialog')) {
        $('#bodydata').append("<div id='inspection_image_detail_dialog'></div>");
    }
    $('#inspection_image_detail_dialog').dialog({
        title: 'Detail Description',
        width: 300,
        height: 'auto',
        href: base_url + 'inspection/product_image_detail/' + row.isnpection_id + '/' + id+ '/' + row.image_category_id,
        modal: true,
        resizable: true,
        overflow: 'auto',
        top: 5,
        buttons: [{
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#inspection_image_detail_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            $('#inspection_product_input_detail_form').form('load', row);
        }
    });
}

function inspection_submit() {
    var row = $('#inspection').datagrid('getSelected');
    var row_inspection_detail = $('#inspection_detail').datagrid('getRows');
    //alert(arr.length); 
    if ((row !== null) && (row_inspection_detail.length>0)){
        $.messager.confirm('Submit Inspection', 'After submited you can not change the Inspection anymore<br/><br/><center>Are you sure?</center>', function (r) {
            if (r) {
                $.post(base_url + 'inspection/submit', {id: row.id,purchaseorder_item_id:row.purchaseorder_item_id}, function (result) {
                    if (result.success) {
                    $('#inspection_submit_id').linkbutton('disable');
                    $('#inspection_edit_id').linkbutton('disable');
                    $('#inspection_delete_id').linkbutton('disable');
                        $('#inspection').datagrid('reload');
                        $('#inspection_detail').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Inspection Warning', 'No Inspection or no item to be submitted', 'warning');
    }
}
