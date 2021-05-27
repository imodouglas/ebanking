<!DOCTYPE html>

<?php
include 'classes/conn.php';
include 'classes/classes.php';

$page = "admin";
include 'classes/session-verification.php';
?>


<html >
<head>
  <!-- Site made with Mobirise Website Builder v4.5.1, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="description" content="">
  <title>eBanking solutions - Admin Home </title>
  <?php include 'classes/headtags.php'; ?>
</head>
<body>
<?php include 'classes/header.php'; ?>
<section class="mbr-section form3 cid-qRQhBErkzv" id="form3-5" data-rv-view="75" style="padding-top:20px">
    <div class="container">
      <div class="row" style="padding:10px">
        <div class="col-sm-3">
          <?php include 'classes/navigate.php'; ?>
        </div>
        <div class="col-sm-3">
          <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> TOTAL ACCOUNTS </div>
          <div style="color:#333; border:#333 thin solid; padding:20px" align="center">
            <h4> <?php echo $allCount; ?> </h4>
          </div>
        </div>

        <div class="col-sm-3">
          <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> TOTAL CREDITS FOR <?php echo strtoupper(date("M")); ?> </div>
          <div style="color:#333; border:#333 thin solid; padding:20px" align="center">
            <h4> <?php echo "N".number_format($adminmCredit['sumCredit'],2); ?> </h4>
          </div>
        </div>

        <div class="col-sm-3">
          <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> TOTAL DEBITS FOR <?php echo strtoupper(date("M")); ?> </div>
          <div style="color:#333; border:#333 thin solid; padding:20px" align="center">
            <h4> <?php echo "N".number_format($adminmDebit['sumDebit'],2); ?> </h4>
          </div>
        </div>
      </div>
    </div>
</section>

<?php include('classes/footer.php'); ?>


  <script src="assets/web/assets/jquery/jquery.min.js"></script>
  <script src="assets/popper/popper.min.js"></script>
  <script src="assets/tether/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/smoothscroll/smooth-scroll.js"></script>
  <script src="assets/theme/js/script.js"></script>
  <script src="assets/formoid/formoid.min.js"></script>


</body>
</html>
