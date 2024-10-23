<?php
//echo phpinfo();
//var_dump($image_category);
?>
<form id="po_item_inspection_input_form" method="post" novalidate class="table_form" enctype="multipart/form-data">
    <table width="100%" border="0">
        <input type="hidden" name='client_id'/>
        <tr>
            <td><strong>client_name</strong></td>
            <td><input type="text" name='client_name' class="easyui-validatebox" autocomplete="Off" required="true"/></td>
        </tr>
        <tr>
            <td><strong>PO Number</strong></td>
            <td><input type="text" name='po_client_no' class="easyui-validatebox" autocomplete="Off" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Cust. Code</strong></td>
            <td><input type="text" name='customer_code' class="easyui-validatebox" autocomplete="Off" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Insp. Date</strong></td>
            <td>
                <?php
                echo date('d M Y');
                ?></td>
            </td>
        </tr>
        <tr>
            <td><strong>Ebako Code</strong></td>
            <td><input type="text" name='ebako_code' class="easyui-validatebox" autocomplete="Off" required="true"/></td>
        </tr>
        <tr>
            <td><strong>Inspector</strong></td>
            <td><?php
                echo $this->session->userdata('name');
                ?></td>
        </tr>
        <tr><td colspan="2" align="center" bgcolor="silver"><B>INSPECTION DOCUMENTATION</b></td></tr>
        <input type="hidden" name='jlhimage' value='<?php echo count($image_category); ?>'/>
        <?php
        $x = 0;
        foreach ($image_category as $result) {
            $x++;
            //echo $result->view_position . "<br>";
            //echo 'x='.$x.' dan '.$x.'%2='.($x%2)."<br>";
            //if (($x % 2) == 1) {
            echo "<tr align=center>";
            // }
            $bgcolor = "bgcolor='#CCDDDD'";
            if (($x % 3) == 1) {
                $bgcolor = "bgcolor='#FFCCDD'";
            }
            //echo $bgcolor;
            ?>
            <td align="center" colspan="2" <?php echo $bgcolor; ?>>
                <strong><?php echo $x . '.' . $result->view_position; ?></strong><br/>
                <?php
                if ($result->mandatory == 't') {
                        echo "<input type='file' name='image-" . $result->id . "' id='image-" . $result->id . "' accept='image/*' capture='camera' onchange='imagePreview(this," . $result->id . ")'  required> <font color=red>*</font>";
                   // echo "<input class='easyui-filebox' label='File:' labelPosition='top' data-options='prompt:\"Choose file...\"' name='image-" . $result->id . "' id='image-" . $result->id . "' accept='image/*' capture='camera' onchange='imagePreview(this," . $result->id . ")'  required>";
                   
                } else
                    echo "<input type='file' name='image-" . $result->id . "' id='image-" . $result->id . "' accept='image/*' capture='camera' onchange='imagePreview(this," . $result->id . ")'>";
                echo "<div id='preview" . $result->id . "'></div>";
                ?>
            </td>
            <?php
            //if ($x % 2 == 0) {
            echo "</tr>";
            //}
        }
        ?>
    </table>        
</form>


<script>
    function imagePreview(fileInput, no) {
        if (fileInput.files && fileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (event) {
                $('#preview' + no).html('<img src="' + event.target.result + '" width="150" height="auto"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>