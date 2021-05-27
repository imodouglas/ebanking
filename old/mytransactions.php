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
          <div class="tab-content">
            <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid; margin-bottom:10px" align="center"> ALL TRASACTIONS FOR <?php echo strtoupper(date("M")) ?> </div>

            <table class="responsive" style="width:100%">
              <tr>
                <th style="width:15%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Date </th>
                <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Type </th>
                <th style="width:15%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Amount </th>
                <th style="width:45%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Description </th>
                <th style="width:15%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Status </th>

              </tr>

              <?php
                $allAccq = $conn->prepare("SELECT * FROM transactions a JOIN accounts b USING(acctNo) WHERE acctNo = ? AND MONTH(FROM_UNIXTIME(transDate)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(transDate)) = YEAR(CURRENT_DATE())");
                $allAccq->execute(array($_SESSION['ascosUser']));
                $allAccount = $allAccq->fetchAll();
                $countAcct = $allAccq->rowCount();

                if($countAcct == 0){
                  $sysfailure = "You do not have any account yet.";
                } else {
                  foreach ($allAccount as $acctInfo) {
              ?>
              <form method="post" action="">
                <input type="hidden" name="transID" value="<?php echo $acctInfo['transID']; ?>" />
                <tr style="border-bottom:#ccc thin solid">
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo date("d/m/Y", $acctInfo['transDate']); ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['transType']; ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo "N".number_format($acctInfo['transAmount'],2); ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['transDesc']; ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['transStatus']; ?>  </td>

                </tr>
              </form>
              <?php } } ?>

            </table>
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
