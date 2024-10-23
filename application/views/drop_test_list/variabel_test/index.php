<div id="drop_test_list_drop_test_list_detail_toolbar" style="padding-bottom: 2px;">
    <?php
    if (in_array("Add", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="drop_test_list_drop_test_list_detail_add()"> Add</a>
        <?php
    }
    if (in_array("Edit", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="drop_test_list_drop_test_list_detail_edit()"> Edit</a>
        <?php
    }
    if (in_array("Delete", $action)) {
        ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="drop_test_list_drop_test_list_detail_delete()">Delete</a>
        <?php
    }
    ?>
</div>
<table id="drop_test_list_drop_test_list_detail" data-options="
       url:'<?php echo site_url('drop_test_list/drop_test_list_detail_get') ?>',
       method:'post',
       border:true,
       title:'Variabel Test',
       singleSelect:true,
       fit:true,
       rownumbers:true,
       fitColumns:false,
       pagination:true,
       striped:true,
       autoRowHeight:true,
       toolbar:'#drop_test_list_drop_test_list_detail_toolbar'">
    <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th field="evaluation" halign="center" sortable="true">Test Category</th>
            <!--<th field="method" halign="center" sortable="true">Method</th>-->
            <!--<th field="notes" halign="center" width=250 sortable="true" editor="{type:'text'}">Notes</th>-->
            <th field="notes" halign="center" width=250 sortable="true">Notes</th>
            <!--<th field="notes" width="60" halign="center" align="right" editor="{type:'timespinner',options:{showSeconds:true}}">Out</th>-->
            <th field="var_type" halign="center" sortable="true">Data Type</th>
            <th field="mandatory" halign="center" sortable="true">Mandatory</th>
            <th field="result_test_var" halign="center" sortable="true">Result</th>
            <th  field="image_file"  valign="center" align=center formatter="showimage_dt">Image</th>
            <th field ="detail" formatter="formatDetail2_dt" styler="cellStyler2_dt" valign="center">Actions</th>
<!--            <th field="image2_file" halign="center" sortable="true">image2</th>
            <th field="image3_file" halign="center" sortable="true">image3</th>-->
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(function () {
        $('#drop_test_list_drop_test_list_detail').datagrid({

            rowStyler: function (index, row) {
               // alert('mandatory:'+row.mandatory+' vartype:'+row.var_type+' imagename:'+row.image_file+' notes:'+row.notes);
                if ((row.mandatory == 't' && row.image_file==null && row.var_type=='Photo') || (row.mandatory == 't' && row.notes==null && row.var_type=='Description')) {
                    return 'background-color:#f69480;';
                }
                else {
                    return 'background-color:#ffffff;';
                }
            },
            onDblClickRow: function (rowIndex, row) {
              // drop_test_list_drop_test_list_detail_edit();
            }
        });
    });

    function showimage_dt(value, row) {
        var idrow = row.id;
        var temp = '';
        //alert(row.drop_test_list_id);
        if (row.image_file == null)
            var temp = 'no image';
        else {
            //var temp=row.image_file;
            var temp = "<img src='files/droptest/" + row.drop_test_list_id + "/" + row.image_file + "' width=90 height=90 onclick='drop_test_list_variabel_test_view_detail(" + idrow + ")'>";
            //var temp = "<img src='files/droptest/" + row.drop_test_list_id + "/" + row.image_file + "' width=50>" + row.image_file;
        }
        return temp;
    }
    function formatDetail2_dt(value, row) {
        var idrow = row.id;
        //var temp = '';
        if (row.submited == 'f' || row.submited==null) {
            if (row.var_type == 'Photo')
                var temp = "<input type=button value='Upload Photo' id='dtvt" + row.id + "' onclick='drop_test_list_variabel_test_add(\"photo\")'> ";
            else
                var temp = "<input type=button value='Edit Notes' id='dtvt" + row.id + "' onclick='drop_test_list_variabel_test_add(\"notes\")'> ";
        } else
            var temp = 'submited';
        return temp;
    }
    function cellStyler2_dt(value, row) {
        if ((row.id % 2) == 1) {
            return 'color:blue;';
        }
    }
</script>
