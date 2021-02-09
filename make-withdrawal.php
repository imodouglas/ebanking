<!DOCTYPE html>

<?php
include 'classes/conn.php';
include 'classes/classes.php';

$page = "user";
include 'classes/session-verification.php';

if(isset($_GET['action']) && $_GET['action'] == "confirmation"){
  if(isset($_POST['userWithdraw'])){
    if(isset($_POST['transAmount'], $_POST['beneficiary'])){
      if($_POST['transAmount'] >= $minWithdrawal){
        $getBenq = $conn->prepare("SELECT * FROM beneficiaries WHERE benID = ?");
        $getBenq->execute(array($_POST['beneficiary']));
        $getBenct = $getBenq->rowCount();
        $getBenAll = $getBenq->fetch(PDO::FETCH_ASSOC);

        $transDesc = "Transfer to ".$getBenAll['benAcctName']." (".$getBenAll['benAcctNo'].") - ".$getBenAll['benBank'];
      } else { echo "<script> alert('Sorry you can not withdraw less than N".number_format($minWithdrawal,0)."'); window.location = 'make-withdrawal.php'; </script>"; }
    } else { echo "<script> alert('One or more fields are empty'); </script>"; }
  } else if(isset($_POST['saveNwithdraw'])){
    if(isset($_POST['transAmount'], $_POST['benAcctName'], $_POST['benAcctNo'], $_POST['benBank'])){
      if(isset($_POST['saveBen']) && $_POST['saveBen'] == "save"){
        $addBenq = $conn->prepare("INSERT INTO beneficiaries(acctNo, benAcctName, benAcctNo, benBank, benDate) VALUES (?,?,?,?,?)");
        $addBenq->execute(array($_SESSION['ascosUser'], $_POST['benAcctName'], $_POST['benAcctNo'], $_POST['benBank'], time()));
      }
      if($_POST['transAmount'] >= $minWithdrawal){
        $transDesc = "Transfer to ".$_POST['benAcctName']." (".$_POST['benAcctNo'].") - ".$_POST['benBank'];
      } else { echo "<script> alert('Sorry you can not withdraw less than N".number_format($minWithdrawal,0)."'); window.location = 'make-withdrawal.php'; </script>"; }
    } else { echo "<script> alert('One or more fields are empty'); </script>"; }
  } else {
    header("Location: make-withdrawal.php");
  }
}
?>

<html >
<head>
  <!-- Site made with Mobirise Website Builder v4.5.1, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="description" content="">
  <title><?php echo $companyName; ?> - eBanking solutions | Make a Withdrawal </title>
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
        <div class="col-sm-9" style="padding:0px">
          <div style="padding:10px; margin-bottom:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> MAKE A WITHDRAWAL </div>
          <div class="row">
            <?php if(isset($_GET['action']) && $_GET['action'] == "confirmation"){?>
              <form method="post" action="">
                <div class="col-sm-12">
                  <div style="padding:10px; background:#ccc; color:#333; border:#ccc thin solid" align="center"> CONFIRM YOUR TRANSACTION </div>
                  <div style="color:#333; border:#ccc thin solid; padding:20px" align="center">
                    <div style="padding:10px 0px 10px 0px; border-bottom:#ccc thin solid">
                      <input type="hidden" name="transDesc" value="<?php echo $transDesc; ?>" /><?php echo $transDesc; ?>
                    </div>
                    <div style="padding:10px 0px 10px 0px; border-bottom:#ccc thin solid">
                      <strong>Amount: </strong>
                      <input type="hidden" name="transAmount" value="<?php echo $_POST['transAmount']; ?>" /><?php echo "N".number_format($_POST['transAmount'],2); ?>
                    </div>
                    <div style="padding:10px 0px 10px 0px; border-bottom:#ccc thin solid">
                      <input type="submit" name="transConfirm" class="btn btn-primary btn-sm" value="confirm" />
                      <a href="make-withdrawal.php" class="btn btn-danger btn-sm">Cancel</a>
                    </div>
                  </div>
                </div>
              </form>
            <?php } else { ?>
              <div class="col-sm-6">
                <form method="post" action="?action=confirmation">
                  <div style="padding:10px; background:#ccc; color:#333; border:#ccc thin solid" align="center"> SEND TO SAVED BENEFICIARY </div>
                  <div style="color:#333; border:#ccc thin solid; padding:20px" align="center">
                    <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:#ccc thin dashed">
                      <strong>Enter Amount</strong> <span style="font-size:12px; color:red">(not less than N<?php echo number_format($minWithdrawal,0); ?>)</span>
                      <input type="number" name="transAmount" class="form-control" style="min-height:15px !important; padding:10px" placeholder="Enter Amount to Withdraw" required />
                    </div>
                    <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:#ccc thin dashed">
                      <?php if($getBenct == 0){ echo "You haven't added a beneficiary account yet."; } else { ?>
                        <strong>Select Beneficiary</strong>
                        <select name="beneficiary" class="form-control" style="min-height:15px !important; padding:10px">
                          <?php foreach($getBenAll AS $getBen){ ?>
                            <option value="<?php echo $getBen['benID']; ?>">
                              <?php echo $getBen['benAcctName']." (".$getBen['benAcctNo'].") - ".$getBen['benBank']; ?>
                            </option>
                          <?php } ?>
                        </select>
                      <?php } ?>
                    </div>
                    <input type="submit" name="userWithdraw" class="btn btn-primary" value="Continue" style="padding:5px" />
                  </div>
                </form>
              </div>

              <div class="col-sm-6">
                <form method="post" action="?action=confirmation">
                  <div style="padding:10px; background:#ccc; color:#333; border:#ccc thin solid" align="center"> SEND DIRECT TO AN ACCOUNT </div>
                  <div style="color:#333; border:#ccc thin solid; padding:20px" align="center">
                    <div style="padding:5px; border-bottom:#ccc thin dashed">
                      <strong>Enter Amount</strong> <span style="font-size:12px; color:red">(not less than N<?php echo number_format($minWithdrawal,0); ?>)</span> <br />
                      <input type="number" name="transAmount" class="form-control" style="min-height:15px !important; padding:10px" placeholder="Enter Amount to Withdraw" required />
                    </div>
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
                    <div style="padding:5px; border-bottom:#ccc thin dashed">
                      <strong>Save to you beneficiary list? </strong> <br /><input type="checkbox" name="saveBen" value="save" /> Tick to agree
                    </div>
                    <div style="padding:5px">
                      <input type="submit" name="saveNwithdraw" class="btn btn-primary" value="Continue" style="padding:5px" />
                    </div>

                  </div>
                </form>
              </div>
            <?php } ?>
          </div>
          <div class="row" style="margin-top:10px">

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
