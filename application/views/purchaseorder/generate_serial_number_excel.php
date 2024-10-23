
<style type="text/css">
    table.sample2 {
        border-width: 0px 0px 0px 0px;
        border-spacing: 0px;
        border-style: solid solid solid solid;
        border-color: black black black black;
        border-collapse: collapse;
        background-color: white;
    }
    table.sample2 th {
        border-width: 0px 0px 0px 0px;
        padding: 1px 1px 1px 1px;
        border-style: inset inset inset inset;
        border-color: black black black black;
        background-color: white;
        -moz-border-radius: 0px 0px 0px 0px;
    }
    table.sample2 td {
        border-width: 0px 0px 0px 0px;
        padding: 1px 1px 1px 1px;
        border-style: inset inset inset inset;
        border-color: black black black black;
        background-color: white;
        -moz-border-radius: 0px 0px 0px 0px;
        font-size: 4pt;
    }
</style>
<?php
//library phpqrcode
include "phpqrcode/qrlib.php";
//direktory tempat menyimpan hasil generate qrcode jika folder belum dibuat maka secara otomatis akan membuat terlebih dahulu
$tempdir = "temp/";
if (!file_exists($tempdir))
    mkdir($tempdir);
?>
<html>
    <head>
    </head>
    <body>
        <div align="center" style="margin-top: 50px;">

            <!--<a href="download-pdf.php"><p>Download PDF</p></a>-->

            <table border="0" class="sample2" width="100%">
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($serial_number as $result) {
                        $teks = $result->serial_number;

                        //Isi dari QRCode Saat discan
                        $isi_teks1 = $teks;
                        //Nama file yang akan disimpan pada folder temp 
                        $namafile1 = $teks . ".png";
                        //Kualitas dari QRCode 
                        $quality1 = 'H';
                        //Ukuran besar QRCode
                        $ukuran1 = 3;
                        $padding1 = 0;
                        QRCode::png($isi_teks1, $tempdir . $namafile1, $quality1, $ukuran1, $padding1);

                        if (($no % 3) == 1) {
                            echo '<tr><td>&nbsp</td></tr><tr>';
                        }
                        ?>
                            <!--<td valign="center"><?php echo $no++; ?></td>-->
                    <td valign="center" align="center"><img src="<?php echo base_url() . "/temp/" . $namafile1; ?>" width="35px"></td>
                    <td>
                        <table class="sample2" >
                            <tr><td>Customer</td><td><?php echo $result->client_name; ?></td></tr>
                            <tr><td>No Po</td><td><?php echo $result->po_no; ?></td></tr>
                            <tr><td>Ebk Code</td><td><?php echo $result->ebako_code; ?></td></tr>
                            <tr><td>Cust Code</td><td><?php echo $result->customer_code; ?></td></tr>
                            <tr><td>Finishing</td><td><?php echo $result->finishing; ?></td></tr>
                            <tr><td>Order Qty</td><td><?php echo $result->item_order_seq_no . " of " . $result->qty; ?></td></tr>
                            <tr><td>Box Qty</td><td><?php echo $result->item_order_seq_no . "" . $result->packing_code . " of " . $result->qty . "" . $result->packing_code; ?></td></tr>
                        </table>
                    </td>
                    <?php
                    if ($no == count($serial_number) && (($no % 3) == 1)) {
                        echo "<td colspan=2></td></tr>";
                    }
                    // $x++;
                    if (($no % 3) == 1) {
                        echo '</tr>';
                    }
                    //$tempname=
                    //unlink("temp/" . $namafile1);
                }
                ?>
                </tbody>
            </table>

    </body>
</html>