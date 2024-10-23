/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function product_group_cari() {
    var code = $('#product_group_code_t').val();
    var description = $('#desc_product_group').val();

    $('#product_group').datagrid('reload', {
        product_group: product_group,
        description: description
    });
}

function product_group_tambah() {
    $('#product_group-form').dialog('open').dialog('setTitle', 'New Product Group');
    $('#product_group-input').form('clear');
    url = base_url + 'product_group/save';
}

function product_group_simpan() {
    $('#product_group-input').form('submit', {
        url: url,
        onSubmit: function() {
            return $(this).form('validate');
        },
        success: function(content) {
            //            alert(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#product_group-form').dialog('close');
                $('#product_group').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function product_group_ubah() {
    var row = $('#product_group').datagrid('getSelected');
    if (row !== null) {
        $('#product_group-form').dialog('open').dialog('setTitle', 'Edit product_group');
        $('#product_group-input').form('load', row);
        url = base_url + 'product_group/update/' + row.id;
    } else {
        $.messager.alert('product_group not selected', 'Select product_group', 'warning');
    }
}

function product_group_hapus() {
    var row = $('#product_group').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Anda Yakin?', function(r) {
            if (r) {
                $.post(base_url + 'product_group/delete', {
                    id: row.id
                }, function(result) {
                    if (result.success) {
                        $('#product_group').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Product Type not selected', 'Select product_group', 'warning');
    }
}

