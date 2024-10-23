/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function warehouse_cari() {
    var code = $('#warehouse_code_t').val();
    var description = $('#desc_warehouse_t').val();

    $('#warehouse').datagrid('reload', {
        code: code,
        description: description
    });
}

function warehouse_tambah() {
    $('#warehouse-form').dialog('open').dialog('setTitle', 'New Fabric');
    $('#warehouse-input').form('clear');
    url = base_url + 'warehouse/save';
}

function warehouse_simpan() {
    $('#warehouse-input').form('submit', {
        url: url,
        onSubmit: function() {
            return $(this).form('validate');
        },
        success: function(content) {
            //            alert(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#warehouse-form').dialog('close');
                $('#warehouse').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function warehouse_ubah() {
    var row = $('#warehouse').datagrid('getSelected');
    if (row !== null) {
        $('#warehouse-form').dialog('open').dialog('setTitle', 'Edit warehouse');
        $('#warehouse-input').form('load', row);
        url = base_url + 'warehouse/update/' + row.id;
    } else {
        $.messager.alert('warehouse not selected', 'Select warehouse', 'warning');
    }
}

function warehouse_hapus() {
    var row = $('#warehouse').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Anda Yakin?', function(r) {
            if (r) {
                $.post(base_url + 'warehouse/delete', {
                    id: row.id
                }, function(result) {
                    if (result.success) {
                        $('#warehouse').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Fabric not selected', 'Select warehouse', 'warning');
    }
}

