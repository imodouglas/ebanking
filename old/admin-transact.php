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
          <div>
            <span style="padding:10px; color:#fff; background:#555"> Quick Transaction</span><br />
          </div>
          <form method="post" action="">
            <div style="margin-bottom:10px; margin-top:10px; width: 100%; padding-bottom:10px; border-bottom:#ccc thin dashed" class="row">
                <div class="col-sm-3">
                  Account No:
                  <input type="text" name="acctNo" class="form-control" style="min-height:15px; padding:10px" required />
                </div>
                <div class="col-sm-3">
                  Transaction Description:
                  <input type="text" name="transDesc" class="form-control" style="min-height:15px; padding:10px" required />
                </div>
                <div class="col-sm-3">
                  Transaction Amount:
                  <input type="number" name="transAmount" class="form-control" style="min-height:15px; padding:10px" required />
                </div>
                <div class="col-sm-3" style="padding-top:20px">
                  <input type="submit" name="acctCreditq" class="btn btn-sm btn-primary" style="padding:5px; margin:3px" value="Credit" />
                  <input type="submit" name="acctDebitq" class="btn btn-sm btn-danger" style="padding:5px; margin:3px" value="Debit" />
                </div>
            </div>
          </form>
          <div class="tab-content">
            <table class="responsive" style="width:100%">
              <tr>
                <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Number </th>
                <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Name </th>
                <th style="width:25%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Description </th>
                <th style="width:15%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Amount </th>
                <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Action </th>
              </tr>

              <?php
                $allAccq = $conn->prepare("SELECT * FROM accounts a JOIN balances b USING(acctNo)");
                $allAccq->execute();
                $allAccount = $allAccq->fetchAll();
                $countAcct = $allAccq->rowCount();

                if($countAcct == 0){
                  $sysfailure = "You do not have any account yet.";
                } else {
                  foreach ($allAccount as $acctInfo) {
              ?>
              <form method="post" action="">
                <tr style="border-bottom:#ccc thin solid">
                  <td style="padding:10px; border-right:#ccc thin solid"> <input type="hidden" name="acctNo" value="<?php echo $acctInfo['acctNo']; ?>" /> <?php echo $acctInfo['acctNo']; ?>  </td>
                  <td style="padding:10px; border-right:#ccc thin solid"> <?php echo $acctInfo['fname']." ".$acctInfo['lname']; ?>  </td>
                  <td style="padding:10px; border-right:#ccc thin solid"> <input type="text" name="transDesc" class="form-control" style="min-height:15px; padding:10px" required /> </td>
                  <td style="padding:10px; border-right:#ccc thin solid"> <input type="number" name="transAmount" class="form-control" style="min-height:15px; padding:10px" required />  </td>
                  <td style="padding:3px">
                    <input type="submit" name="acctCreditq" class="btn btn-sm btn-primary" style="padding:5px; margin:3px" value="Credit" />
                    <input type="submit" name="acctDebitq" class="btn btn-sm btn-danger" style="padding:5px; margin:3px" value="Debit" />
                  </td>
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
