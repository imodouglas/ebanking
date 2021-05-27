<!DOCTYPE html>

<?php
include 'classes/conn.php';
include 'classes/classes.php';

$page = "user";
include 'classes/session-verification.php';
?>


<html >
<head>
  <!-- Site made with Mobirise Website Builder v4.5.1, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="description" content="">
  <title><?php echo $companyName; ?> - eBanking solutions | My Account </title>
  <?php include 'classes/headtags.php'; ?>
</head>
<body>
<?php include 'classes/header.php'; ?>
<section class="mbr-section form3 cid-qRQhBErkzv" id="form3-5" data-rv-view="75" style="padding-top:20px">
    <div class="container">
      <div class="row" style="padding:10px">
        <div class="col-sm-3">
          <?php include 'classes/user-navigate.php'; ?>
        </div>
        <div class="col-sm-4">
          <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> ACCOUNT INFORMATION </div>
          <div style="color:#333; border:#333 thin solid; padding:20px">
            <div style="padding:5px; border-bottom:#ccc thin dashed">
              <strong>Full Name</strong> <br /><?php echo $userData['lname'].", ".$userData['fname']." ".$userData['mname']; ?>
            </div>
            <div style="padding:5px; border-bottom:#ccc thin dashed">
              <strong>Account No.</strong> <br /><?php echo $userData['acctNo']; ?>
            </div>
            <div style="padding:5px; border-bottom:#ccc thin dashed">
              <strong>Address</strong> <br /><?php echo $userData['address']; ?>
            </div>
            <div style="padding:5px; border-bottom:#ccc thin dashed">
              <strong>Phone No.</strong> <br /><?php echo $userData['phone']; ?>
            </div>
            <div style="padding:5px; border-bottom:#ccc thin dashed">
              <strong>Email</strong> <br /><?php echo $userData['email']; ?>
            </div>
            <div style="padding:5px; border-bottom:#ccc thin dashed">
              <strong>Designation</strong> <br /><?php echo ucfirst($userData['designation']); ?>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> MY BENEFICIARIES </div>
          <div style="color:#333; border:#333 thin solid; padding:20px; margin-bottom: 10px;">
            <?php if($getBenct == 0){ echo "You haven't added a beneficiary account yet."; } else { foreach($getBenAll AS $getBen){?>
              <div style="padding:5px; border-bottom:#ccc thin dashed">
                <strong> <?php echo $getBen['benAcctName']; ?> </strong> <br /> <?php echo $getBen['benAcctNo']; ?> <br /><?php echo $getBen['benBank']; ?>
              </div>
            <?php } } ?>
          </div>

          <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> ADD BENEFICIARY </div>
          <div style="color:#333; border:#333 thin solid; padding:20px; margin-bottom: 10px;">
            <form method="post" action="" name="addBeneficiary">
              <div style="padding:5px; border-bottom:#ccc thin dashed">
                <strong>Account Name</strong> <br />
                <input type="text" name="benAcctName" class="form-control" style="min-height:15px !important; padding:10px" placeholder="Enter beneficiary name" required />
              </div>
              <div style="padding:5px; border-bottom:#ccc thin dashed">
                <strong>Account Number</strong> <br />
                <input type="text" name="benAcctNo" class="form-control" style="min-height:15px !important; padding:10px" placeholder="Enter beneficiary number" required />
              </div>
              <div style="padding:5px; border-bottom:#ccc thin dashed">
                <strong>Beneficiary Bank</strong> <br />
                <select name="benBank" class="form-control" style="min-height:15px !important; padding:10px">
                  <?php foreach($banksary AS $bankName){ ?>
                    <option value="<?php echo $bankName; ?>"> <?php echo $bankName; ?> </option>
                  <?php } ?>
                </select>
              </div>
              <div style="padding-top:5px">
                <input type="submit" name="addBen" class="btn btn-primary btn-sm" style="padding:10px" value="Add Beneficiary" />
              </div>
            </form>
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
