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
          <?php if(isset($_GET['action']) && $_GET['action'] == "add-loan"){ ?>
            <form method="post" action="" name="add-loan">
              <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> ADD NEW LOAN </div>
              <div style="color:#333; border:#333 thin solid; padding:10px">
                <div class="row" align="center">
                  <div class="col-sm-4"> Account No: <br /><input type="number" name="acctNo" class="form-control" required="" placeholder="Enter account number" /> </div>
                  <div class="col-sm-4"> Loan Amount: <br /><input type="number" name="loanAmount" class="form-control" required="" placeholder="Enter loan amount" /> </div>
                  <div class="col-sm-4"> Repay Rate: <br />
                    <select name="repayRate" class="form-control">
                      <option value="weekly"> Weekly </option>
                      <option value="monthly"> Monthly </option>
                      <option value="yearly"> Yearly </option>
                    </select>
                  </div>
                </div>
                <div class="row" align="center" style="margin-top:20px">
                  <div class="col-sm-4"> Reason for loan: <br /><input type="text" name="loanPurpose" class="form-control" required="" placeholder="Enter loan purpose" /> </div>
                  <div class="col-sm-4"> Loan duration(in months): <br /><input type="number" name="loanDuration" class="form-control" required="" placeholder="Enter loan duration" /> </div>
                  <div class="col-sm-4"> Interest rate(in percentage): <br /><input type="number" name="interestRate" class="form-control" required="" placeholder="Enter interest rate" /> </div>

                </div>
                <div class="row" style="margin-top:20px">
                  <div class="col-sm-12" align="center"> <input type="submit" name="addLoan" value="Add Loan" class="btn btn-primary" /> </div>
                </div>
              </div>
            </form>
          <?php } else if(isset($_GET['action']) && $_GET['action'] == "repay-loan"){ ?>
            <form method="post" action="" name="repay-loan">
              <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid" align="center"> REPAY LOAN </div>
              <div style="color:#333; border:#333 thin solid; padding:10px">
                <div class="row" align="center">
                  <div class="col-sm-4"> Loan ID: <br /><input type="number" name="loanID" class="form-control" required="" placeholder="Enter Loan ID" /> </div>
                  <div class="col-sm-4"> Amount: <br /><input type="number" name="repayAmount" class="form-control" required="" placeholder="Enter Amount" /> </div>
                  <div class="col-sm-4"> Repay Method: <br />
                    <select name="repayMethod" class="form-control">
                      <option value="direct"> Direct from account </option>
                      <option value="credit-debit"> Credit and Debit </option>
                    </select>
                  </div>
                </div>
                <div class="row" style="margin-top:20px">
                  <div class="col-sm-12" align="center"> <input type="submit" name="repayLoan" value="Repay Loan" class="btn btn-primary" /> </div>
                </div>
              </div>
            </form>
          <?php } else { ?>
            <div class="tab-content">
              <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid; margin-bottom:10px" align="center">
                ALL LOANS FOR <?php echo strtoupper(date("M")) ?>
                <a href="?action=add-loan" class="btn btn-primary" style="padding:5px; margin:3px"> Add Loan </a>
                <a href="?action=repay-loan" class="btn btn-primary" style="padding:5px; margin:3px"> Repay Loan </a>
              </div>

              <table class="responsive" style="width:100%">
                <tr>
                  <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Date </th>
                  <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Loan ID </th>
                  <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Name </th>
                  <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Loan Amount </th>
                  <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Description </th>
                  <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Loan Duration </th>
                  <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Status </th>
                  <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Action </th>
                </tr>

                <?php
                  $allAccq = $conn->prepare("SELECT * FROM loans a JOIN accounts b USING(acctNo) ORDER BY a.loanDate DESC");
                  $allAccq->execute();
                  $allAccount = $allAccq->fetchAll();
                  $countAcct = $allAccq->rowCount();

                  if($countAcct == 0){
                    $sysfailure = "You do not have any account yet.";
                  } else {
                    foreach ($allAccount as $acctInfo) {
                ?>
                <form method="post" action="">
                  <input type="hidden" name="loanID" value="<?php echo $acctInfo['loanID']; ?>" />
                  <tr style="border-bottom:#ccc thin solid">
                    <td style="padding:5px; border-right:#ccc thin solid"> <?php echo date("d/m/Y", $acctInfo['loanDate']); ?>  </td>
                    <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['loanID']; ?>  </td>
                    <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['fname']." ".$acctInfo['lname']; ?>  </td>
                    <td style="padding:5px; border-right:#ccc thin solid"> <?php echo "N".number_format($acctInfo['loanAmount'],2); ?>  </td>
                    <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['loanPurpose']; ?>  </td>
                    <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['loanDuration']." months"; ?>  </td>
                    <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['loanStatus']; ?>  </td>
                    <td style="padding:5px; border-right:#ccc thin solid">
                      <input type="submit" name="loanApprove" class="btn btn-primary btn-sm" style="padding:5px; margin:3px" value="c" />
                      <input type="submit" name="loanDeny" class="btn btn-danger btn-sm" style="padding:5px; margin:3px" value="x" />
                    </td>
                  </tr>
                </form>
                <?php } } ?>

              </table>
            </div>
          <?php } ?>
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
