<div class="card-box">
  <div class='card-box-heading' align="left"> :: QUICK LINKS </div>
  <?php if ($user['privilege'] == "user"){ ?>
    <div align="left">
      <a href="<?php echo $rootURL; ?>home"><div style="padding:10px; border-bottom:#777 thin solid">ACCOUNT SUMMARY </div></a>
      <a href="<?php echo $rootURL; ?>profile"><div style="padding:10px; border-bottom:#777 thin solid">PERSONAL INFORMATION </div></a>
      <a href="<?php echo $rootURL; ?>transactions"><div style="padding:10px; border-bottom:#777 thin solid">MY TRANSACTIONS </div></a>
      <!-- <a href="make-withdrawal.php"><div style="padding:10px; border-bottom:#333 thin solid">MAKE WITHDRAWAL </div></a>
      <a href="myloans.php"><div style="padding:10px; border-bottom:#333 thin solid">MY LOANS </div></a> -->
      <a href="<?php echo $rootURL; ?>logout"><div style="padding:10px"> LOGOUT </div></a>
    </div>
  <?php } else if ($user['privilege'] == "admin"){ ?>
    <div align="left">
      <a href="<?php echo $rootURL; ?>admin"><div style="padding:10px; border-bottom:#777 thin solid">HOME </div></a>
      <a href="<?php echo $rootURL; ?>admin/users"><div style="padding:10px; border-bottom:#777 thin solid"> MANAGE ACCOUNTS </div></a>
      <a href="<?php echo $rootURL; ?>admin/transactions"><div style="padding:10px; border-bottom:#777 thin solid"> MANAGE TRANSACTIONS </div></a>
      <a href="<?php echo $rootURL; ?>profile"><div style="padding:10px; border-bottom:#777 thin solid"> ADMIN PROFILE </div></a>
      <!-- <a href="make-withdrawal.php"><div style="padding:10px; border-bottom:#333 thin solid">MAKE WITHDRAWAL </div></a>
      <a href="myloans.php"><div style="padding:10px; border-bottom:#333 thin solid">MY LOANS </div></a> -->
      <a href="<?php echo $rootURL; ?>logout"><div style="padding:10px"> LOGOUT </div></a>
    </div>
  <?php } ?>
</div>