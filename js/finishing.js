/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function finishing_cari() {
    var code = $('#finishing_code_t').val();
    var description = $('#desc_finishing_t').val();

    $('#finishing').datagrid('reload', {
        code: code,
        description: description
    });
}

function finishing_tambah() {
    $('#finishing-form').dialog('open').dialog('setTitle', 'New Fabric');
    $('#finishing-input').form('clear');
    url = base_url + 'finishing/save';
}

function finishing_simpan() {
    $('#finishing-input').form('submit', {
        url: url,
        onSubmit: function() {
            return $(this).form('validate');
        },
        success: function(content) {
            //            alert(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#finishing-form').dialog('close');
                $('#finishing').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function finishing_ubah() {
    var row = $('#finishing').datagrid('getSelected');
    if (row !== null) {
        $('#finishing-form').dialog('open').dialog('setTitle', 'Edit finishing');
        $('#finishing-input').form('load', row);
        url = base_url + 'finishing/update/' + row.id;
    } else {
        $.messager.alert('finishing not selected', 'Select finishing', 'warning');
    }
}

function finishing_hapus() {
    var row = $('#finishing').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Anda Yakin?', function(r) {
            if (r) {
                $.post(base_url + 'finishing/delete', {
                    id: row.id
                }, function(result) {
                    if (result.success) {
                        $('#finishing').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Fabric not selected', 'Select finishing', 'warning');
    }
}

