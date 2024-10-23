/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function unit_cari() {
    var code = $('#unit_code_t').val();
    var description = $('#desc_unit_t').val();

    $('#unit').datagrid('reload', {
        code: code,
        description: description
    });
}

function unit_tambah() {
    $('#unit-form').dialog('open').dialog('setTitle', 'New Fabric');
    $('#unit-input').form('clear');
    url = base_url + 'unit/save';
}

function unit_simpan() {
    $('#unit-input').form('submit', {
        url: url,
        onSubmit: function() {
            return $(this).form('validate');
        },
        success: function(content) {
            //            alert(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#unit-form').dialog('close');
                $('#unit').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function unit_ubah() {
    var row = $('#unit').datagrid('getSelected');
    if (row !== null) {
        $('#unit-form').dialog('open').dialog('setTitle', 'Edit unit');
        $('#unit-input').form('load', row);
        url = base_url + 'unit/update/' + row.id;
    } else {
        $.messager.alert('unit not selected', 'Select unit', 'warning');
    }
}

function unit_hapus() {
    var row = $('#unit').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Anda Yakin?', function(r) {
            if (r) {
                $.post(base_url + 'unit/delete', {
                    id: row.id
                }, function(result) {
                    if (result.success) {
                        $('#unit').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Fabric not selected', 'Select unit', 'warning');
    }
}

