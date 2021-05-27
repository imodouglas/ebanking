<?php 
    include 'includes/env.inc.php';
    
    /** Initialize Classes */
    $controller = new UserController();
    $view = new UserView();
    $transactionView = new TransactionsView;

    /** View & Controllers */   
    $user = $view->getUser($userSession);
    $account = $view->getAccount($userSession);

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
            <div class="row">
                <div class="col-sm-4"> 
                    <div class="card-box">
                        <div class='card-box-heading' align="center"> ACCOUNT BALANCE </div>
                        <div class='card-box-body' align="center">
                            <h4> <?php echo "N".number_format($account['balance'],2); ?> </h4>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card-box">
                        <div class='card-box-heading' align="center"> TOTAL CREDIT IN <?php echo strtoupper(date("M")); ?> </div>
                        <div class='card-box-body' align="center">
                            <h4> <?php echo "N".number_format($transactionView->getUserMonthTotal($userSession, "CR")['totalSum'],2); ?> </h4>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card-box">
                        <div class='card-box-heading' align="center"> TOTAL DEBIT IN <?php echo strtoupper(date("M")); ?> </div>
                        <div class='card-box-body' align="center">
                            <h4> <?php echo "N".number_format($transactionView->getUserMonthTotal($userSession, "DR")['totalSum'],2); ?> </h4>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row" style="margin-top:10px">

            </div>
            </div>

        </div>
    </div>
</div>