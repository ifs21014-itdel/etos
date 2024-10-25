<div style="width: 99%;padding: 2px;">
    <form id="print_mark_test_list_print_mark_test_list_detail_input_image" method="post" novalidate enctype="multipart/form-data">
        <table width="100%" border="0" class="table_form">
            <?php
            //echo $type_form;
            if ($type_form == 'notes') {
                ?>
                <tr>
                    <td width="35%"><strong>Notes</strong></td>
                    <td width="75%">
                        <textarea name="notes" class="easyui-validatebox" style="width:100%;height: 45px"></textarea>
                    </td>
                </tr>
                <?php
            } else {
                ?>

                <tr>
                    <td width="25%"><strong>Photo 1</strong></td>
                    <td width="75%"><input type="file" name="image_file" data-options="prompt:'Pilih File...'" style="width:90%"> </td>
                </tr>
    <!--                            <tr>
    <td width="25%"><strong>Photo 2</strong></td>
    <td width="75%"><input type="file" name="image_file2" data-options="prompt:'Pilih File...'" style="width:90%"> </td>
    </tr>-->

    <?php
}
?>
            <tr>
                <td><strong>Result</strong></td>
                <td>
                    <select name="result_test_var" required="ture">
                        <option value=""></option>
                        <option value="Passed">Passed</option>
                        <option value="Failed">Failed </option>
                        <option value="N/A">N/A </option>
                    </select>
                </td>
            </tr>
        </table>        
    </form>
</div>