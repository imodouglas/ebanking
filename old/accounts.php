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
  <title>eBanking solutions - Admin Accounts </title>
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

        <div class="col-sm-9">
            <ul class="nav nav-tabs" style="border:none; padding-bottom:20px">
              <li class="active"> <a data-toggle="tab" href="#add-account" style="padding:15px; margin-right:5px; border:#39C thin solid; border-radius:5px"> Add Account </a> </li>
              <li> <a data-toggle="tab" href="#all-accounts" style="padding:15px; margin-right:5px; border:#39C thin solid; border-radius:5px"> All Accounts </a> </li>
              <!-- <li> <a data-toggle="tab" href="#all-suspended" style="padding:15px; margin-right:5px; border:#39C thin solid; border-radius:5px"> Suspended Accounts </a> </li> -->
            </ul>
          <div class="clearfix"></div>
          <div class="tab-content">
            <div id="all-accounts" class="tab-pane active"> <?php include 'classes/acctable.php'; ?> </div>
            <div id="add-account" class="tab-pane fade in"><?php include 'classes/addacct.php'; ?> </div>
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
