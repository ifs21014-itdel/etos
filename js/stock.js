/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function stock_search() {
    $('#stock').datagrid('reload', $('#stock_search_form').serializeObject());
}

function stock_summary_search() {
    $('#stock_summary').datagrid('reload', $('#stock_summary_search_form').serializeObject());
}

function stock_summary_export_to_excel() {
    open_target('POST', base_url + 'stock/summary_export_to_excel', $('#stock_summary_search_form').serializeObject(), '_blank');
}

function stock_export_to_excel() {
    open_target('POST', base_url + 'stock/export_to_excel', $('#stock_search_form').serializeObject(), '_blank');
}