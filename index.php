<!DOCTYPE html>

<?php
  include('classes/conn.php');
  include('classes/classes.php');

  if(isset($_SESSION['ascosUser']) && $_SESSION['ascosUser'] == "admin"){
    header("Location: admin-home.php");
  } else if(isset($_SESSION['ascosUser']) && $_SESSION['ascosUser'] !== "admin"){
    header("Location: home.php");
  }
?>


<html >
<head>
  <!-- Site made with Mobirise Website Builder v4.5.1, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="description" content="">
  <title>eBanking solutions - <?php echo $companyName; ?> </title>
  <?php include 'classes/headtags.php'; ?>
</head>
<body>
<section class="mbr-section form3 cid-qRQhBErkzv" id="form3-5" data-rv-view="75">





    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">eBanking Solution</h2>
                <h3 class="mbr-section-subtitle align-center pb-5 mbr-light mbr-fonts-style display-5">Login to access</h3>
            </div>
        </div>

        <div class="row py-2 justify-content-center">
            <div class="col-12 col-lg-6  col-md-8">
                <?php include('classes/alert.php'); ?>

                <form class="mbr-form" action="" method="post" align="center">
                    <div class="mbr-subscribe">
                        <input class="form-control" type="text" name="acctno" placeholder="Account Number" data-form-field="Account Number" required="" id="email-form3-5" style="border-radius: 30px; margin-bottom: 10px">
                        <input class="form-control" type="password" name="pword" placeholder="Password" data-form-field="Password" required="" style="border-radius: 30px; margin-bottom: 10px">
                        <span class="input-group-btn">
                            <button name="ulogin" type="submit" class="btn btn-primary  display-4">LOGIN</button>
                        </span>
                    </div>
                </form>
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
