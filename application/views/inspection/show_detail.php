<?php
//echo phpinfo();
//echo 'inspectionid='.$inspection_id.' dan idinspection detal='.$id;
//var_dump($ins_detail);
?>

<form id="inspection_product_input_detail_form"  method="post" novalidate class="table_form" enctype="multipart/form-data">
    <table width="100%" border="0" style="font-size: 10pt;font-family: verdana;">
        <tr><td>Ebako Code</td><td><?php echo $ins_detail[0]->ebako_code; ?></td></tr>
        <tr><td>Customer Code</td><td><?php echo $ins_detail[0]->customer_code; ?></td></tr>
        <tr><td>Client</td><td><?php echo $ins_detail[0]->client_name; ?></td></tr>
        <tr><td>PO No</td><td><?php echo $ins_detail[0]->po_client_no; ?></td></tr>
        <tr><td>Position</td><td><?php echo $ins_detail[0]->view_position; ?></td></tr>
        <tr><td>Description</td><td><?php echo $ins_detail[0]->description; ?></td></tr>
        <tr><td colspan="2" align="center">
                <?php
                $image = $_SERVER["HTTP_REFERER"] . 'files/inspection/' . $ins_detail[0]->isnpection_id . "/" . $ins_detail[0]->filename;
                echo "<img src='" . $image . "' width='100%'>";
                ?>
            </td>
        </tr>

    </table>        
</form>
