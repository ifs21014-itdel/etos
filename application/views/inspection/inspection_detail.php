<div id="inspection_detail_toolbar" style="padding-bottom: 2px;">
    <form id="inspection_detail_search_form" onsubmit="inspection_detail_search();
            return false" style="margin: 0;">
        Search 
        <input type="text" name="q" class="easyui-validatebox" />
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="inspection_detail_search()"></a>
<!--        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" id='inspection_product_add' onclick="inspection_product_add()"></a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id='inspection_product_edit_id' onclick="inspection_product_edit()"></a>-->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" id='inspection_product_delete_id' onclick="inspection_product_delete()"></a>
    </form>

</div>
<table id="inspection_detail" class="easyui-datagrid" data-options="
       url:'<?php echo site_url('inspection/inspection_detail_get') ?>',
       method:'post',
       border:true,
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
        striped:true,
        autoRowHeight:true,
       toolbar:'#inspection_detail_toolbar'">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th field ="detail" formatter="formatDetail2" styler="cellStyler2" valign="center">Actions</th>
            <th  field="filename"  valign="center" align=center formatter="showimage">Image</th>
            <th  field="view_position" valign="center">Image Category</th>
            <th  field="description" valign="center">Description</th>
            <th  field="filename_detail" valign="center">File Name</th>
            <th  field="submited" valign="center">submited</th>
            <!--<th  field="filename" width="100" halign="center">File</th>-->
        </tr>
    </thead>
</table>
<script>
    function showimage(value, row) {
        var idrow = row.id;
        var temp = '';
        if(row.filename==null)
            var temp='no image';
        else
            var temp = "<img src='files/inspection/" + row.isnpection_id + "/" + row.filename + "' width=50 onclick='inspection_product_view_detail(" + idrow + ")'>";
            //var temp = "<img src='files/inspection/" + row.isnpection_id + "/" + row.filename + "' width=50>" + row.filename;
        return temp;
    }
    function formatDetail2(value, row) {
        var idrow = row.id;
        //var temp = '';
        if(row.submited=='f')
            var temp = "<input type=button value='Upload' id='inspect"+row.id+"' onclick='inspection_product_add(" + idrow + ")'> ";
        else
            var temp='submited';
        return temp;
    }
    function cellStyler2(value, row) {
        if ((row.id % 2) == 1) {
            return 'color:blue;';
        }
    }
</script>