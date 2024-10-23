/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/* global base_url */

var requestforsample_url = '';

function requestforsample_input_form(type, title, row) {
    if ($('#requestforsample_dialog')) {
        $('#bodydata').append("<div id='requestforsample_dialog'></div>");
    }

    $('#requestforsample_dialog').dialog({
        title: title,
        width: 400,
        height: 'auto',
        href: base_url + 'requestforsample/input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    requestforsample_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#requestforsample_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#requestforsample_input_form').form('load', row);
            } else {
                $('#requestforsample_input_form').form('clear');
            }
        }
    });
}

function requestforsample_add() {
    requestforsample_input_form('add', 'ADD REQUEST FOR SAMPLE', null)
    requestforsample_url = base_url + 'requestforsample/save/0';
}

function requestforsample_edit() {
    var row = $('#requestforsample').datagrid('getSelected');
    if (row !== null) {
        requestforsample_input_form('edit', 'EDIT REQUEST FOR SAMPLE', row);
        requestforsample_url = base_url + 'requestforsample/save/' + row.id;
    } else {
        $.messager.alert('No Request Selected', 'Please Select Request', 'warning');
    }
}

function requestforsample_save() {
    $('#requestforsample_input_form').form('submit', {
        url: requestforsample_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#requestforsample').datagrid('reload');
                $('#requestforsample_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function requestforsample_delete() {
    var row = $('#requestforsample').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'requestforsample/delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#requestforsample').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Request Selected', 'Please Select Request', 'warning');
    }
}





function requestforsample_detail_input_form(type, title, row) {
    if ($('#requestforsample_dialog')) {
        $('#bodydata').append("<div id='requestforsample_dialog'></div>");
    }

    $('#requestforsample_dialog').dialog({
        title: title,
        width: 500,
        height: 'auto',
        href: base_url + 'requestforsample/detail_input',
        modal: true,
        resizable: true,
        top: 60,
        buttons: [{
                text: 'Save',
                iconCls: 'icon-save',
                handler: function () {
                    requestforsample_detail_save();
                }
            }, {
                text: 'Close',
                iconCls: 'icon-remove',
                handler: function () {
                    $('#requestforsample_dialog').dialog('close');
                }
            }],
        onLoad: function () {
            $(this).dialog('center');
            if (type === 'edit') {
                $('#requestforsample_detail_input_form').form('load', row);
                var material_temp = row.material_id.replace(/[({}]/g, "");
                var material = material_temp.split(',');
                $('#rfsd_material_id').combobox('setValues', material);

                if (row.color_id !== null) {
                    var color_temp = row.color_id.replace(/[({}]/g, "");
                    var color = color_temp.split(',');

                    $('#rfsd_color_id').combobox('setValues', color);
                }

            } else {
                $('#requestforsample_detail_input_form').form('clear');
            }
        }
    });
}


function requestforsample_detail_add() {
    var row = $('#requestforsample').datagrid('getSelected');
    if (row !== null) {
        requestforsample_detail_input_form('add', 'ADD ITEM', null);
        requestforsample_url = base_url + 'requestforsample/detail_save/0/' + row.id;
    } else {
        $.messager.alert('No Request Selected', 'Please Select Request', 'warning');
    }
}

function requestforsample_detail_edit() {
    var row = $('#requestforsample_detail').datagrid('getSelected');
    if (row !== null) {
        requestforsample_detail_input_form('edit', 'EDIT ITEM', row);
        requestforsample_url = base_url + 'requestforsample/detail_save/' + row.id + '/' + row.requestforsample_id;
    } else {
        $.messager.alert('No Item Selected', 'Please Select Item', 'warning');
    }
}

function requestforsample_detail_save() {
    $('#requestforsample_detail_input_form').form('submit', {
        url: requestforsample_url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (content) {
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#requestforsample_detail').datagrid('reload');
                $('#requestforsample_dialog').dialog('close');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function requestforsample_detail_delete() {
    var row = $('#requestforsample_detail').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure to remove this data?', function (r) {
            if (r) {
                $.post(base_url + 'requestforsample/detail_delete', {
                    id: row.id
                }, function (result) {
                    if (result.success) {
                        $('#requestforsample_detail').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('No Item Selected', 'Please Select Item', 'warning');
    }
}

function requestforsample_print() {
    var row = $('#requestforsample').datagrid('getSelected');
    if (row !== null) {
        window.open(base_url + 'requestforsample/prints/' + row.id, 'Stock Opname',
                'width=1000,toolbar=no,directories=no,status=no,linemenubar=no,scrollbars=yes,resizable=no ,modal=yes');
        //open_target('POST', base_url + 'requestforsample/download', {id: row.id}, '_blank');
    } else {
        $.messager.alert('No Request Selected', 'Please Select Request', 'warning');
    }
}