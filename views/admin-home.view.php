<?php 
    include 'includes/env.inc.php';
    
    /** User Controller Data */
    $controller = new UserController();
    
    /** User View Data */
    $view = new UserView();
    $transactionsView = new TransactionsView();
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
                        <div class='card-box-heading' align="center"> TOTAL USERS </div>
                        <div class='card-box-body' align="center">
                            <h4> <?php echo $view->getTotalUsers(); ?> </h4>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card-box">
                        <div class='card-box-heading' align="center"> TRANSACTIONS IN <?php echo strtoupper(date("M")); ?> </div>
                        <div class='card-box-body' align="right">
                            <h6 class="complete-color"> <?php echo "+ N".number_format($transactionsView->getMonthTotal("CR")['totalSum'],2); ?> </h6>
                            <h6 class="pending-color"> <?php echo "- N".number_format($transactionsView->getMonthTotal("DR")['totalSum'],2); ?> </h6>
                            <h5> <?php echo "= N".number_format(($transactionsView->getMonthTotal("CR")['totalSum'] - $transactionsView->getMonthTotal("DR")['totalSum']),2); ?> </h5>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card-box">
                    <div class='card-box-heading' align="center"> TRANSACTIONS IN <?php echo strtoupper(date("Y")); ?> </div>
                        <div class='card-box-body' align="right">
                            <h6 class="complete-color"> <?php echo "+ N".number_format($transactionsView->getYearTotal("CR")['totalSum'],2); ?> </h6>
                            <h6 class="pending-color"> <?php echo "- N".number_format($transactionsView->getYearTotal("DR")['totalSum'],2); ?> </h6>
                            <h5> <?php echo "= N".number_format(($transactionsView->getYearTotal("CR")['totalSum'] - $transactionsView->getYearTotal("DR")['totalSum']),2); ?> </h5>
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