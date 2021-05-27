<?php 
    include 'includes/env.inc.php';
    
    /** Initialize Classes */
    $userView = new UserView();
    $transactionView = new TransactionsView;
    
    /** View & Controllers */   
    $user = $userView->getUser($userSession);
    $account = $userView->getAccount($userSession);
    $transactions = $transactionView->getUserMonthTransactions($userSession);

?>
<div class="account-info">
    <?php include 'includes/account-info.inc.php'; ?>
</div>
<div class="section">
    <div class="container">
        <div class="row" style="padding:10px">
            <div class="col-md-3">
            <?php include 'includes/sidemenu.inc.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card-box">
                    <div class="card-box-heading" align="center"> ALL TRANSACTIONS FOR <?php echo strtoupper(date("F")) ?> </div>
                </div>

                <?php 
                    if($transactions == false){
                        echo "<div align='center'> <h3> No transaction for this month yet! </h3> </div>";
                    } else {
                        foreach ($transactions AS $trans){
                            if($trans['transType'] == "CR"){ $symbol = "+"; $color = "complete"; } else { $symbol = "-"; $color = "pending"; }
                ?>
                <div class="card-box">
                    <div class="card-box-body">
                        <div class="row m0">
                            <div class="col-sm-8">
                                <div class="trans-desc"> <?php echo $trans['transDesc']; ?> </div>
                                <div class="trans-date"> <?php echo date("d F, Y", $trans['transDate']); ?> &nbsp; <span class="trans-status-<?php echo strtolower($trans['transStatus']); ?>"> <?php echo $trans['transStatus']; ?> </span> </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="trans-amount">
                                    <span class="<?php echo $color; ?>-color"><?php echo $symbol; ?> N<?php echo number_format($trans['transAmount'],2); ?></span>
                                </div>
                                <div class="trans-balance gray-color"> <b> Balance: </b> N<?php echo number_format($trans['acctBalance'],2); ?> </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                        }
                    }                    
                ?>

                <div class="row" style="margin-top:10px">

                </div>
            </div>

        </div>
    </div>
</div>