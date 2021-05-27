<?php 
    include 'includes/env.inc.php';

    /** Initialize Classes */
    $userController = new UserController;
    $userView = new UserView;
    $transactionView = new TransactionsView;
    $mailer = new Mailer;
    
    /** View & Controllers */   
    $view = new UserView();
    $transactionsView = new TransactionsView();
    $user = $userView->getUser($userSession);
    $account = $userView->getAccount($userSession);

    if(isset($_POST['addAccount'])){ 
        $data = $userController->doCreateUser($_POST['phone'], $_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['address'], $_POST['phone'], $_POST['email']);
        if($data !== false){
            $msg = "Hello ".$_POST['fname'].", \r\n\r\nIt is our pleasure to inform you that your account with ".$companyName." has been created successfully, and your Account Number is ".$data.". \r\n\r\nYou can login to your account on our ebanking platform through this link ".$rootURL."ebanking. Your login details are as follow:\r\n\r\nAccount Number: ".$data."\r\nPassword: ".$_POST['phone']." \r\n\r\nNOTE: You can change your password in the PERSONAL INFORMATION section of your dashboard. \r\n\r\nFeel free to contact us via any of our contact channels if your need clarification on any of the above information. \r\n\r\nBest regards,\r\n\r\n".$companyName;
            $mail = $mailer->sendMail($companyEmail, $_POST['email'], 'Welcome to '.$companyName, $msg, $companyName);
            if($mail == true){
                echo "<script> window.location = '".$rootURL."admin/user/".$data."'; </script>";
            }
        } else {
            return $data;   
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
            <div class="col-md-9">
                <div class="row m0">
                    <div class="col-sm-8">
                        <div class="card-box">
                            <div class="card-box-heading" align="center"> 
                                ADD A USER &nbsp;
                                <a href="<?php echo $rootURL.'admin/users'; ?>"> 
                                    <button class="btn btn-dark btn-padding"> <i class="fas fa-eye"></i> </button> 
                                </a>
                            </div>
                            <div class="card-box-body">
                                <form method="post" action="" name="add-account">
                                    <p>
                                        <input type="text" name="fname" class="form-control" required="" placeholder="First name" />
                                    </p>
                                    <p>
                                        <input type="text" name="mname" class="form-control" required="" placeholder="Middle name" />
                                    </p>
                                    <p>
                                        <input type="text" name="lname" class="form-control" required="" placeholder="Last name" />
                                    </p>
                                    <p>
                                        <input type="text" name="address" class="form-control" required="" placeholder="Address" />
                                    </p>
                                    <p>
                                        <input type="number" name="phone" class="form-control" required="" placeholder="Phone no." />
                                    </p>
                                    <p>
                                        <input type="email" name="email" class="form-control" required="" placeholder="Email" />
                                    </p>
                                    <p>
                                        <input type="submit" name="addAccount" value="Add Account" class="btn btn-success form-control" />
                                    </p>
                                </form>                    
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