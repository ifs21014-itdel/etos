<div style="width: 99%;padding: 2px;">
    <form id="hardness_test_list_hardness_test_list_detail_input" method="post" novalidate enctype="multipart/form-data">
        <table width="100%" border="0" class="table_form">
            <tr>
                <td width="35%"><strong>Evaluation</strong></td>
                <td width="75%">
                    <textarea name="evaluation" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
            <!-- <tr>
                <td width="35%"><strong>Method</strong></td>
                <td width="75%">
                    <textarea name="method" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr> -->
            <tr>
                <td><strong>Data Type</strong></td>
                <td>
                    <select name="var_type" required="ture">
                        <option value="Description">Descripion</option>
                        <option value="Photo">Photo </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="35%"><strong>Notes</strong></td>
                <td width="75%">
                    <textarea name="notes" class="easyui-validatebox" style="width: 98%;height: 35px"></textarea>
                </td>
            </tr>
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

            <tr>
                <td colspan='2'>


                    <fieldset class="app-fieldset" style="margin-bottom: 5px;">
                        <legend class="app-legend">Upload Photo</legend>
                        <table width="100%" border="0">
                            <tr>
                                <td width="25%"><strong>Photo 1</strong></td>
                                <td width="75%"><input type="file" name="image_file" data-options="prompt:'Pilih File...'" style="width:90%"> </td>
                            </tr>
                            <!-- <tr>
                                <td width="25%"><strong>Photo 3</strong></td>
                                <td width="75%"><input type="file" name="image2_file" data-options="prompt:'Pilih File...'" style="width:90%"> </td>
                            </tr>
                            <tr>
                                <td width="25%"><strong>Photo 4</strong></td>
                                <td width="75%"><input type="file" name="image3_file" data-options="prompt:'Pilih File...'" style="width:90%"> </td>
                            </tr> -->
<!--                            <tr>
                                <td width="25%"><strong>Photo 2</strong></td>
                                <td width="75%"><input type="file" name="image_file2" data-options="prompt:'Pilih File...'" style="width:90%"> </td>
                            </tr>-->
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>        
    </form>
</div>