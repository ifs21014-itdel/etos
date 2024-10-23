<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<style>
  *{
    font-family: "Arial";
    font-size: 11pt;
  }
</style>
<div style="width: 700px;">
  <table width='100%' border='1' align='center' cellpadding='0' cellspacing='0'>
    <?php
    //  if ($flag == 1) {
    ?>
    <tr>
      <td colspan=3 align=center><b><font size=5>DATA TENDER</font></b></td>
    </tr>
    <tr>
      <td width='20%' valign=top><b>Customer Name</b></td>
      <td width=3>:</td>
      <td width=80% align=left> <?php echo $customer->cust_name ?></td>
    </tr>
    <tr>
      <td width='20%' valign=top><b>Tender Number</b></td>
      <td width=3>:</td>
      <td width=80% align=left> <?php echo $customer->customer_number ?></td>
    </tr>
    <tr>
      <td width='20%' valign=top><b>Title</b></td>
      <td width=3>:</td>
      <td width=80% align=left> <?php echo $customer->title ?></td>
    </tr>
    <tr>
      <td width='20%'><b>Prebid Date</b></td>
      <td width=3>:</td>
      <td width=80% align=left> <?php echo $customer->prebid_date ?></td>
    </tr>
    <tr>
      <td width='20%'><b>Prebid Time</b></td>
      <td width=3>:</td>
      <td width=80% align=left> <?php echo $customer->prebid_time ?></td>
    </tr>
    <tr>
      <td width='20%'><b>Closing Date</b></td>
      <td width=3>:</td>
      <td width=80% align=left> <?php echo $customer->closing_date ?></td>
    </tr>
    <tr>
      <td width='20%'><b>Closing Time</b></td>
      <td width=3>:</td>
      <td width=80% align=left> <?php echo $customer->closing_time ?></td>
    </tr>
    <tr>
      <td width='20%' valign="top"><b>Description</b></td>
      <td width=3>:</td>
      <td width=80% align=left> <?php echo nl2br($customer->description) ?></td>
    </tr>
    <?php
    //  } else {
    if ($flag == 0) {
      ?>
      <tr>
        <td width='20%' valign="top"><b>Status</b></td>
        <td width=3>:</td>
        <td width=80% align=left> <?php echo nl2br($customer->status) ?></td>
      </tr>
      <tr>
        <td width='20%' valign="top"><b>Status Desc</b></td>
        <td width=3>:</td>
        <td width=80% align=left> <?php echo nl2br($customer->status_desc) ?></td>
      </tr>
      <tr>
        <td width='20%' valign="top"><b>Closing Status</b></td>
        <td width=3>:</td>
        <td width=80% align=left> <?php echo nl2br($customer->closing_status) ?></td>
      </tr> 
      <?php
      if (count($bidbond) > 0) {
        ?>
        <tr>
          <td colspan=3 align=center><br><br></td>
        </tr>
        <tr>
          <td colspan=3 align=center><b><font size=5>Data Bidbond</font></b></td>
        </tr>
        <tr>
          <td width='20%'><b>Date Issue</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $bidbond->date_issue ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Due Date</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $bidbond->due_date ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Bidbond Number</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $bidbond->bidbond_number ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Amount</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo number_format($bidbond->amount) ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Expiry</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $bidbond->expiry ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Balance</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo number_format($bidbond->balance) ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Notes</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $bidbond->notes ?></td>
        </tr>
        <?php
      }
      if (count($performancebond) > 0) {
        ?>
        <!-- //********************************** -->
        <tr>
          <td colspan=3 align=center><br><br></td>
        </tr>
        <tr>
          <td colspan=3 align=center><b><font size=5>Data Performancebond</font></b></td>
        </tr>
        <tr>
          <td width='20%'><b>Date Issue</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $performancebond->date_issue ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Due Date</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $performancebond->due_date ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Guarantee Number</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $performancebond->guarantee_number ?></td>
        </tr>
        <tr>
          <td width='20%'><b>PO Number</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $performancebond->po_number ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Amount</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo number_format($performancebond->amount) ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Expiry</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $performancebond->expiry ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Balance</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo number_format($performancebond->balance) ?></td>
        </tr>
        <tr>
          <td width='20%'><b>Notes</b></td>
          <td width=3>:</td><td width=80% align=left> <?php echo $performancebond->notes ?></td>
        </tr>
        <?php
      }
    }
    ?>
  </table>
</div>
