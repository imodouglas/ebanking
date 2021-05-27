<?php 
    include 'includes/env.inc.php';
    
    /** Initialize Classes */
    $userView = new UserView();
    $transactionView = new TransactionsView;
    $tController = new TransactionsController;
    $mailer = new Mailer;
    
    /** View & Controllers */   
    $transactionsView = new TransactionsView();
    $user = $userView->getUser($userSession);
    $account = $userView->getAccount($userSession);
    $transactions = $transactionsView->getMonthTransactions($userSession);

    function doAlert($alert){
        echo "<script> alert('".$alert."'); window.location = '".$_SERVER['REQUEST_URI']."'; </script>";
    }

    if(isset($_POST['makeTransaction'])){
        $balance = $userView->getAccount($_POST['acctNo'])['balance'];
        if($_POST['type'] == "CR" || ($_POST['type'] == "DR" && ($_POST['amount'] <= $balance && ($balance - $_POST['amount']) >= $minWithdrawal))){
            $data = $tController->getMakeTransaction($_POST['acctNo'], $_POST['type'], $_POST['amount'], $_POST['description']);
            if($data == true){
                $acctData = $userView->getUser($_POST['acctNo']);
                if($_POST['type'] == "DR"){
                    $balance = $balance - $_POST['amount'];
                    $type1 = "Debit";
                    $type2 = "debited";
                } else if($_POST['type'] == "CR"){
                    $balance = $balance + $_POST['amount'];
                    $type1 = "Credit";
                    $type2 = "credited";
                }
                $msg = "Hello ".$acctData['fname'].", \r\n\r\nYour account have been ".$type2.". See details below: \r\n\r\nAmount: N".number_format($_POST['amount'],2)."\r\nDesc: ".$_POST['description']." \r\nDate: ".date("d-m-Y")."\r\nTime: ".date("h:i:sa")."\r\nBalance: N".number_format($balance,2)."\r\n\r\nBest regards,\r\n\r\n".$companyName;
                $mail = $mailer->sendMail($companyEmail, $acctData['email'], $type1.' Alert!', $msg, $companyName);
                // $mail = true;
                if($mail == true){
                    doAlert("Transaction successful");
                }
            } else {
                doAlert("An error occured!");
            }
        } else {
            doAlert("Amount is above withdrawal limit");
        }
    }

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
            <div class="col-md-5">
                <div class="card-box">
                    <div class="card-box-heading" align="center"> 
                        MAKE A TRANSACTION &nbsp;
                        <a href="<?php echo $rootURL.'admin/transactions'; ?>"> 
                            <button class="btn btn-dark btn-padding"> <i class="fas fa-eye"></i> </button> 
                        </a>
                    </div>
                    <div class="card-box-body">
                        <form action="" method="post">
                            <p>
                                <input type="number" name="acctNo" class="form-control" placeholder="Account No." required />
                            </p>
                            <p>
                                <textarea name="description" class="form-control" placeholder="Description" required></textarea>
                            </p>
                            <p>
                                <input type="number" name="amount" class="form-control" placeholder="Amount" required />
                            </p>
                            <p>
                                <b> Transaction Type: </b> <br>
                                <input type="radio" name="type" value="CR" checked> Credit &nbsp; &nbsp;
                                <input type="radio" name="type" value="DR"> Debit
                            </p>
                            <p>
                                <input type="submit" name="makeTransaction" value="Submit" class="btn btn-success form-control">
                            </p>
                        </form>
                    </div>
                </div>


                <div class="row" style="margin-top:10px">

                </div>
            </div>

        </div>
    </div>
</div>