/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function accessories_cari() {
    var code = $('#accessories_code_t').val();
    var description = $('#desc_accessories_t').val();

    $('#accessories').datagrid('reload', {
        code: code,
        description: description
    });
}

function accessories_tambah() {
    $('#accessories-form').dialog('open').dialog('setTitle', 'New Fabric');
    $('#accessories-input').form('clear');
    url = base_url + 'accessories/save';
}

function accessories_simpan() {
    $('#accessories-input').form('submit', {
        url: url,
        onSubmit: function() {
            return $(this).form('validate');
        },
        success: function(content) {
            //            alert(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#accessories-form').dialog('close');
                $('#accessories').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function accessories_ubah() {
    var row = $('#accessories').datagrid('getSelected');
    if (row !== null) {
        $('#accessories-form').dialog('open').dialog('setTitle', 'Edit accessories');
        $('#accessories-input').form('load', row);
        url = base_url + 'accessories/update/' + row.id;
    } else {
        $.messager.alert('accessories not selected', 'Select accessories', 'warning');
    }
}

function accessories_hapus() {
    var row = $('#accessories').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Anda Yakin?', function(r) {
            if (r) {
                $.post(base_url + 'accessories/delete', {
                    id: row.id
                }, function(result) {
                    if (result.success) {
                        $('#accessories').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Fabric not selected', 'Select accessories', 'warning');
    }
}

