/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function customer_cari() {
  var name = $('#t_name_t').val();
  var code = $('#code_t').val();
  var country_id2 = $('#country_cust_1').combobox("getValue");
  $('#list_customer').datagrid('reload', {
    name: name,
    code: code,
    country_id2: country_id2
  });

}

function customer_tambah() {
  $('#customer-form').dialog('open').dialog('setTitle', 'New Customer');
  $('#customer-input').form('clear');
  url = base_url + 'customer/simpan/0';
}

function customer_simpan() {
  $('#customer-input').form('submit', {
    url: url,
    onSubmit: function() {
      return $(this).form('validate');
    },
    success: function(content) {
      alert(content);
      var result = eval('(' + content + ')');
      //alert(result);
      if (result.success) {
        $('#customer-form').dialog('close');
        $('#list_customer').datagrid('reload');
      } else {
        $.messager.alert('Error', result.msg, 'error');
      }
    }
  });
}

function customer_ubah() {
  var row = $('#list_customer').datagrid('getSelected');
  if (row !== null) {
    $('#customer-form').dialog('open').dialog('setTitle', 'Edit customer');
    $('#customer-input').form('load', row);
    url = base_url + 'customer/simpan/' + row.id;
  } else {
    $.messager.alert('Edit Customer', 'Choose customer', 'warning');
  }
}

function customer_hapus() {
  var row = $('#list_customer').datagrid('getSelected');

  if (row !== null) {
    $.messager.confirm('Confirm', 'Anda yakin?', function(r) {
      if (r) {
        $.post(base_url + 'customer/hapus', {
          id: row.id
        }, function(result) {
          if (result.success) {
            $('#list_customer').datagrid('reload');
          } else {
            $.messager.alert('Error', result.msg, 'error');
          }
        }, 'json');
      }
    });
  } else {
    $.messager.alert('customer Belum dipilih', 'Pilih customer yang akan di ubah', 'warning');
  }
}

function customer_cetak(flag) {
  var row = $('#list_customer').datagrid('getSelected');
  if (row !== null) {
    window.open(base_url + 'customer/cetak/' + row.id + '/' + flag, '_blank')
  } else {
    $.messager.alert('Please select any customer', 'Pilih customer yang akan di cetak', 'warning');
  }
}
function laporan_customer_view() {
  var dari_tanggal = $('#lap_dari_tanggal_t').datebox('getValue');
  var ke_tanggal = $('#lap_ke_tanggal_t').datebox('getValue');
  var dari_tanggal_p = $('#lap_dari_tanggal_p').datebox('getValue');
  var ke_tanggal_p = $('#lap_ke_tanggal_p').datebox('getValue');
  var status = $('#status_t').combobox('getValue')
  var closing_status = $('#closing_status_t').combobox('getValue')
  var customer_number = $('#customer_number_t').val();
  var cust_name = $('#cust_name_t').val();
  var title = $('#title_t').val();

  $.post(base_url + 'laporan/cetak/0', {
    dari_tanggal: dari_tanggal,
    ke_tanggal: ke_tanggal,
    dari_tanggal_p: dari_tanggal_p,
    ke_tanggal_p: ke_tanggal_p,
    customer_number: customer_number,
    cust_name: cust_name,
    status: status,
    closing_status: closing_status,
    title: title
  }, function(content) {
    $('#temp_laporan').empty();
    $('#temp_laporan').append(content);
  });
}
function laporan_customer_pdf() {
  $('#laporan-input').form('submit', {
    url: base_url + 'laporan/cetak/1',
    target: '_blank',
    onSubmit: function() {
      return true;
    },
    success: function(content) {

    }
  });
}
/* ********************************* for cust_files ******************/
function cust_files_add() {
  var row = $('#list_customer').datagrid('getSelected');
  if (row !== null) {
    //alert(row.id);
    $('#cust_files-form').dialog('open').dialog('setTitle', 'Customer Files');
    $('#cust_files-input').form('clear');
    $('#flag_status').val('1');
    url = base_url + 'customer/save_cust_files/' + row.id;
  } else {
    $.messager.alert('customer Belum dipilih', 'Pilih customer yang akan di ubah', 'warning');
  }
}

function cust_files_save() {

  var flag = $('#flag_status').val();
  if (flag === '1') {
    var attach1 = $('#attach1').val();
    if (attach1 !== '') {
      $('#cust_files-input').form('submit', {
        url: url,
        onSubmit: function() {
          return $(this).form('validate');
        },
        success: function(content) {
          //alert(content);
          var result = eval('(' + content + ')');
          if (result.success) {
            $('#cust_files-form').dialog('close');
            $('#cust_files').datagrid('reload');
          } else {
            $.messager.alert('Error', result.msg, 'error');
          }
        }
      });
    } else {
      $.messager.alert('No File Choosed', 'Please Choose File', 'error');
    }
  } else {
    $('#cust_files-input').form('submit', {
      url: url,
      onSubmit: function() {
        return $(this).form('validate');
      },
      success: function(content) {
        //alert(content);
        var result = eval('(' + content + ')');
        if (result.success) {
          $('#cust_files-form').dialog('close');
          $('#cust_files').datagrid('reload');
        } else {
          $.messager.alert('Error', result.msg, 'error');
        }
      }
    });
  }

}

function cust_files_edit() {

  var attach1 = $('#attach1').val();

  var row = $('#cust_files').datagrid('getSelected');
  if (row !== null) {
    $('#cust_files-form').dialog('open').dialog('setTitle', 'Edit Document');
    $('#cust_files-input').form('clear');
    $('#cust_files-input').form('load', row);
    url = base_url + 'customer/update_cust_files/' + row.id + '/' + row.file_name;
  } else {
    $.messager.alert('customer Belum dipilih', 'Pilih customer yang akan di ubah', 'warning');
  }
}

function cust_files_delete() {
  var row = $('#cust_files').datagrid('getSelected');

  if (row !== null) {
    $.messager.confirm('Confirm', 'Anda yakin?', function(r) {
      if (r) {
        $.post(base_url + 'customer/hapus_cust_files', {
          id: row.id,
          filename: row.file_name
        }, function(result) {
          if (result.success) {
            $('#cust_files').datagrid('reload');
          } else {
            $.messager.alert('Error', result.msg, 'error');
          }
        }, 'json');
      }
    });
  } else {
    $.messager.alert('customer Belum dipilih', 'Pilih customer yang akan di ubah', 'warning');
  }
}
//*************************** customer cp */
function cust_cp_add() {
    var row = $('#list_customer').datagrid('getSelected');
    if (row !== null) {
        $('#cust_cp-form').dialog('open').dialog('setTitle', ' New cust_cp');
        $('#cust_cp-input').form('clear');
       // $('#cust_cp-input').form('load', row);
        url = base_url + 'customer/cust_cp_save/' + row.id + '/0';
    } else {
        $.messager.alert('Warning', 'Choose Customer', 'warning');
    }

}

function cust_cp_save() {
    $('#cust_cp-input').form('submit', {
        url: url,
        onSubmit: function() {
            return $(this).form('validate');
        },
        success: function(content) {
            alert(content);
            var result = eval('(' + content + ')');
            if (result.success) {
                $('#cust_cp-form').dialog('close');
                $('#cust_cp').datagrid('reload');
            } else {
                $.messager.alert('Error', result.msg, 'error');
            }
        }
    });
}

function cust_cp_edit() {
    var row = $('#cust_cp').datagrid('getSelected');
    if (row !== null) {
        $('#cust_cp-form').dialog('open').dialog('setTitle', ' Edit cust_cp / Accessories');
        $('#cust_cp-input').form('load', row);
        url = base_url + 'customer/cust_cp_save/' + row.customer_id + '/' + row.id;
    } else {
        $.messager.alert('Waring', 'Choose Contact Person to edit', 'warning');
    }
}

function cust_cp_delete() {
    var row = $('#cust_cp').datagrid('getSelected');
    if (row !== null) {
        $.messager.confirm('Confirm', 'Are you sure you want to remove this data?', function(r) {
            if (r) {
                $.post(base_url + 'customer/cust_cp_delete', {
                    id: row.id
                }, function(result) {
                    if (result.success) {
                        $('#cust_cp').datagrid('reload');
                    } else {
                        $.messager.alert('Error', result.msg, 'error');
                    }
                }, 'json');
            }
        });
    } else {
        $.messager.alert('Waring', 'Choose cust_cp to delete', 'warning');
    }
}