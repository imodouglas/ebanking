<?php include('classes/alert.php'); ?>

<div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid; margin-bottom:10px" align="center"> ALL ACCOUNTS </div>

<table class="responsive" style="width:100%">
  <tr>
    <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Number </th>
    <th style="width:40%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Name </th>
    <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Balance </th>
    <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Quick Links </th>
  </tr>

  <?php
    $allAccq = $conn->prepare("SELECT * FROM accounts a JOIN balances b USING(acctNo)");
    $allAccq->execute();
    $allAccount = $allAccq->fetchAll();
    $countAcct = $allAccq->rowCount();

    if($countAcct == 0){
      $sysfailure = "You do not have any account yet.";
    } else {
      foreach ($allAccount as $acctInfo) {
  ?>
  <tr style="border-bottom:#ccc thin solid">
    <td style="padding:10px; border-right:#ccc thin solid"> <?php echo $acctInfo['acctNo']; ?>  </td>
    <td style="padding:10px; border-right:#ccc thin solid"> <?php echo $acctInfo['fname']." ".$acctInfo['lname']; ?>  </td>
    <td style="padding:10px; border-right:#ccc thin solid"> <?php echo "N".number_format($acctInfo['acctBalance'],2); ?>  </td>
    <td style="padding:10px"> <i class="fa fa-circle"></i> | Suspend  </td>
  </tr>
  <?php } } ?>

</table>
