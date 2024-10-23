<form id="drop_test_list_detail_image_form"  method="post" novalidate class="table_form" enctype="multipart/form-data">
    <table width="100%" border="0" style="font-size: 10pt;font-family: verdana;">
         <tr><td>Test Type</td><td><?php echo $dt_detail->method; ?></td></tr>
        <tr><td>Notes</td><td><?php echo $dt_detail->notes; ?></td></tr>
        <tr><td colspan="2" align="center">
                <?php
               // var_dump($dt_detail);
                $image = $_SERVER["HTTP_REFERER"] . 'files/droptest/' . $dt_detail->drop_test_list_id . "/" . $dt_detail->image_file;
                //echo "asdasdasdasd". $image;
                echo "<img src='" . $image . "' width='100%'>";
                ?>
            </td>
        </tr>

    </table>        
</form>
