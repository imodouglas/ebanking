<?php 
    include 'includes/env.inc.php';
    
    /** Initialize Classes */
    $userView = new UserView();
    $transactionView = new TransactionsView;
    
    /** View & Controllers */   
    $view = new UserView();
    $transactionsView = new TransactionsView();
    $user = $userView->getUser($userSession);
    $account = $userView->getAccount($userSession);
    $transactions = $transactionsView->getMonthTransactions($userSession);


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
                    <div class="card-box-heading" align="center"> 
                        ALL TRANSACTIONS FOR <?php echo strtoupper(date("F")) ?> &nbsp;
                        <a href="<?php echo $rootURL.'admin/transactions/add'; ?>"> <button class="btn btn-dark btn-padding"> <i class="fas fa-cog"></i> </button> </a>
                    </div>
                </div>

                <?php 
                    if($transactions == false){
                        echo "<div align='center'> <h3> No transaction for this month yet! </h3> </div>";
                    } else { 
                ?>
                    <div class="row m0 bottom-line" style="margin-bottom:10px; background: #ccc">
                        <div class="col-sm-4 p10 white-border-right" align="right">
                            <b> Total Credit: </b> <?php echo "+ N".number_format($transactionView->getMonthTotal("CR")['totalSum'],2); ?>
                        </div>
                        <div class="col-sm-4 p10 white-border-right" align="right">
                            <b> Total Debits: </b> <?php echo "+ N".number_format($transactionView->getMonthTotal("DR")['totalSum'],2); ?>
                        </div>
                        <div class="col-sm-4 p10 white-border-right" align="right">
                            <b> Balance: </b> <?php echo "+ N".number_format(($transactionView->getMonthTotal("CR")['totalSum'] - $transactionView->getMonthTotal("DR")['totalSum']),2); ?>
                        </div>
                    </div>
                <?php 
                        foreach ($transactions AS $trans){
                            if($trans['transType'] == "CR"){ $symbol = "+"; $color = "complete"; } else { $symbol = "-"; $color = "pending"; }
                ?>
                
                <div class="row m0 bottom-line" style="margin-bottom:10px">
                    <div class="col-sm-8 p10">
                        <div class="trans-desc"> <?php echo $trans['transDesc']; ?> </div>
                        <div class="trans-date"> <?php echo date("d F, Y", $trans['transDate']); ?> &nbsp; <span class="trans-status-<?php echo $trans['transStatus']; ?>"> <?php echo $trans['acctNo']; ?> </span> </div>
                    </div>
                    <div class="col-sm-4 p10" align="right">
                        <div class="trans-amount">
                            <span class="<?php echo $color; ?>-color"><?php echo $symbol; ?> N<?php echo number_format($trans['transAmount'],2); ?></span>
                        </div>
                        <div class="trans-balance gray-color"> <b> Balance: </b> N<?php echo number_format($trans['acctBalance'],2); ?> </div>
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