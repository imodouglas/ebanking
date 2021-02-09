<!DOCTYPE html>

<?php
include 'classes/conn.php';
include 'classes/classes.php';

$page = "user";
include 'classes/session-verification.php';

$totalLoan = 0;
$allLnq = $conn->prepare("SELECT * FROM loans WHERE acctNo = ? AND loanStatus = ?");
$allLnq->execute(array($_SESSION['ascosUser'], "approved"));
$allLn = $allLnq->fetchAll();
foreach($allLn AS $aLoan){
  $totalLoan = $totalLoan + $aLoan['loanAmount'];
}

$totalPaid = 0;
$allRepay = $conn->prepare("SELECT * FROM repayments WHERE acctNo = ? AND repayStatus = ?");
$allRepay->execute(array($_SESSION['ascosUser'], "complete"));
$allRepay = $allRepay->fetchAll();
foreach($allRepay AS $aRepay){
  $totalPaid = $totalPaid + $aRepay['repayAmount'];
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
                <th style="width:15%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Loan ID </th>
                <th style="width:15%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Amount </th>
                <th style="width:40%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Purpose </th>
                <th style="width:15%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Amount Paid </th>
                <th style="width:15%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Status </th>

              </tr>

              <?php
                $allAccq = $conn->prepare("SELECT * FROM loans a JOIN accounts b USING(acctNo) WHERE acctNo = ?");
                $allAccq->execute(array($_SESSION['ascosUser']));
                $allAccount = $allAccq->fetchAll();
                $countAcct = $allAccq->rowCount();

                if($countAcct == 0){
                  $sysfailure = "You do not have any loan record.";
                } else {
                  foreach ($allAccount as $acctInfo) {
                    $loanRepayq = $conn->prepare("SELECT SUM(repayAmount) AS repay FROM repayments WHERE loanID = ?");
                    $loanRepayq->execute(array($acctInfo['loanID']));
                    $loanRepay = $loanRepayq->fetch(PDO::FETCH_ASSOC);
              ?>
              <form method="post" action="">
                <input type="hidden" name="transID" value="<?php echo $acctInfo['loanID']; ?>" />
                <tr style="border-bottom:#ccc thin solid">
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['loanID']; ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo "N".number_format($acctInfo['loanAmount'],2); ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['loanPurpose']; ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo "N".number_format($loanRepay['repay'],2); ?>   </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['loanStatus']; ?>  </td>

                </tr>
              </form>
              <?php } } ?>
            </table>

            <div style="margin-top:20px; padding:10px; border:#ccc thin solid">
              <strong style="color:#369"> Total Loan Received: </strong> <?php echo "N".number_format($totalLoan,2); ?> <br />
              <strong style="color:#369"> Total Amount Repayed: </strong> <?php echo "N".number_format($totalPaid,2); ?>
            </div>
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
