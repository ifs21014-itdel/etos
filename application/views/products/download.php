<table>
    <thead>
        <tr>
            <th width="150" halign="center" >Client</th>
            <th width="150" halign="center">Ebako Code</th>
            <th  width="150" halign="center">Customer Code</th>
            <th width="120" halign="center">Finishing</th>
            <th width="120" halign="center">Material</th>
            <th width="150" halign="center">Remark</th>
            <th width="150" halign="center">Description</th>
            <th width="150" halign="center">Packing Conf</th>
        </tr>
        <?php
        $no=0;
       // var_dump($products);
        $tbl="";
        foreach ($products as $result) {
            $no++;
           // $tbl="";
            $tbl .= '<tr>
        <td width="2%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-left-color:#000000;border-left-width:0.1px;border-left-style:solid;line-height:5px;">' . $no++ . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->name . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->ebako_code . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->customer_code . '</td>
        <td width="20%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->finishing . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->material . '</td>
        <td width="14%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->remarks . '</td>
        <td width="14%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->description . '</td>
        <td width="8%" align="center" style="border-right-color:#000000;border-right-width:0.1px;border-right-style:solid;line-height:5px;">' . $result->packing_configuration . '</td>
    </tr>';
        }
        echo $tbl;
        ?>
    </thead>
</table>

