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
          <div class="tab-content">
            <div style="padding:10px; background:#333; color:#ccc; border:#333 thin solid; margin-bottom:10px" align="center"> ALL TRASACTIONS FOR <?php echo strtoupper(date("M")) ?> </div>

            <table class="responsive" style="width:100%">
              <tr>
                <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Date </th>
                <th style="width:15%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account No </th>
                <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Name </th>
                <th style="width:7%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Type </th>
                <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Amount </th>
                <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Description </th>
                <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Status </th>
                <th style="width:10%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Action </th>
              </tr>

              <?php
                $allAccq = $conn->prepare("SELECT * FROM transactions a JOIN accounts b USING(acctNo) ORDER BY a.transDate DESC");
                $allAccq->execute();
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
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['acctNo']; ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['fname']." ".$acctInfo['lname']; ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['transType']; ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo "N".number_format($acctInfo['transAmount'],2); ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['transDesc']; ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid"> <?php echo $acctInfo['transStatus']; ?>  </td>
                  <td style="padding:5px; border-right:#ccc thin solid">
                    <input type="submit" name="transComplete" class="btn btn-primary btn-sm" style="padding:5px; margin:3px" value="c" />
                    <input type="submit" name="transPend" class="btn btn-danger btn-sm" style="padding:5px; margin:3px" value="x" />
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
