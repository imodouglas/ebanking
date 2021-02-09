<section>
  <div style="height:90px; color:#F0F0F0; background:#369; padding:10px">
    <div class="container"> <?php echo "<span style='font-size:28px;'> ".$companyName." </span> <br />eBanking Solution"; ?> </div>
  </div>
  <?php if(isset($_SESSION['ascosUser'], $_SESSION['ascosPriv']) && $_SESSION['ascosPriv'] !== "Administrator"){ ?>
    <div style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid; width:100%" class="row">
      <div class="col-sm-4" align="center">
        <strong>Account Name: </strong> <?php echo $userData['fname']." ".$userData['lname']; ?>
      </div>
      <div class="col-sm-4" align="center">
        <strong>Account No: </strong> <?php echo $userData['acctNo']; ?>
      </div>
      <div class="col-sm-4" align="center">
        <strong>Balance: </strong> <?php echo "N".number_format($userData['acctBalance'],2); ?>
      </div>
    </div>
  <?php } ?>
</section>
