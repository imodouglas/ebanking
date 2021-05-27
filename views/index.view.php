<?php 
    include 'includes/env.inc.php';

    $controller = new UserController();
    $userView = new UserView();
    $mailer = new Mailer;

    if(isset($_POST['acctNo'], $_POST['password'])){
        $result = $controller->doLogin($_POST['acctNo'], $_POST['password']);
        if($result !== false){
            if($result['privilege'] == 'admin'){
                $_SESSION['eb_admin_session'] = $result['acctNo'];
                echo "<script> window.location = '".$rootURL."admin'; </script>";
            } else if($result['privilege'] == 'user'){
                $_SESSION['eb_user_session'] = $result['acctNo'];
                echo "<script> window.location = '".$rootURL."home'; </script>";
            }
        } else {

        }
    }

    if(isset($_POST['addAccount'])){ 
        $data = $controller->doCreateUser($_POST['phone'], $_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['address'], $_POST['phone'], $_POST['email']);
        if($data !== false){
            // $_SESSION['eb_user_session'] = $data;
            // echo "<script> window.location = '".$rootURL."home'; </script>";
            
            $msg = "Hello ".$_POST['fname'].", \r\n\r\nIt is our pleasure to inform you that your account with ".$companyName." has been created successfully, and your Account Number is ".$data.". \r\n\r\nYou can login to your account on our ebanking platform through this link ".$rootURL."ebanking. Your login details are as follow:\r\n\r\nAccount Number: ".$data."\r\nPassword: ".$_POST['phone']." \r\n\r\nNOTE: You can change your password in the PERSONAL INFORMATION section of your dashboard. \r\n\r\nFeel free to contact us via any of our contact channels if your need clarification on any of the above information. \r\n\r\nBest regards,\r\n\r\n".$companyName;
            $mail = $mailer->sendMail($companyEmail, $_POST['email'], 'Welcome to '.$companyName, $msg, $companyName);
            if($mail == true){
                $_SESSION['eb_user_session'] = $data;
                echo "<script> window.location = '".$rootURL."home'; </script>";
            }
        } else {
            return $data;   
        }
    }

    if(isset($_POST['reset'])){
        $user = $userView->getUser($_POST['acctNo']);
        if($user['acctNo'] == $_POST['acctNo'] && $user['email'] == $_POST['email']){
            $rand = rand(111111,999999);
            if($controller->getChangePassword($_POST['acctNo'], $rand == true)){
                // echo "<script> window.location = '".$rootURL."reset-successful'; </script>";
                $msg = "Hello ".$user['fname'].", \r\n\r\nYour password reset was successful. Your new password is ".$rand."\r\n\r\nYou can login to your account on our ebanking platform through this link ".$rootURL."ebanking. Your login details are as follow:\r\n\r\nAccount Number: ".$_POST['acctNo']."\r\nPassword: ".$rand." \r\n\r\nNOTE: You can change your password in the PERSONAL INFORMATION section of your dashboard. \r\n\r\nFeel free to contact us via any of our contact channels if your need clarification on any of the above information. \r\n\r\nBest regards,\r\n\r\n".$companyName ;
                $mail = $mailer->sendMail($companyEmail, $user['email'], 'Password Reset Successful', $msg, $companyName);
                if($mail == true){
                    echo "<script> window.location = '".$rootURL."reset-successful'; </script>";
                }
            }
        }
    }

?>

<div class="header">
    <div class="overlay"></div>
    <div class="flexBox center-center">
        <div class="container">
            <div class="row" style="padding-top:80px; padding-bottom:80px">
                <div class="col-sm-7">
                    <div class="header-title">
                        <?php echo $companyName; ?> Online Banking System!
                    </div>
                    <div class="header-sub-title">
                        Banking made easy!
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card-box">
                        <div class="card-box-body" align="center">
                            <div id="login">
                                <div class="card-title"> Login to your account </div>
                                <form method="post" action="">
                                    <p>
                                        <label> Account Number: </label>
                                        <input type="number" name="acctNo" class="form-control" required />
                                    </p>
                                    <p>
                                        <label> Password: </label>
                                        <input type="password" name="password" class="form-control" required />
                                    </p>
                                    <p>
                                        <input type="submit" name="login" value="Login" class="btn btn-success form-control" required />
                                    </p>
                                    <p>
                                        Forgot password? <a href="#" onclick="modal.reset()"> Reset Password </a>
                                    </p>
                                    <p>
                                        Don't have an account? <a href="#" onclick="modal.signup()"> Create One </a>
                                    </p>
                                </form>
                            </div>

                            <div id="signup" style="display:none">
                                <div class="card-title"> Create an Account </div>
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
                                    <p>
                                        Already have an account? <a href="#" onclick="modal.login()"> Signin Now </a>
                                    </p>
                                </form> 
                            </div>

                            <div id="reset" style="display:none">
                                <div class="card-title"> Reset your password </div>
                                <form method="post" action="">
                                    <p>
                                        <label> Account Number: </label>
                                        <input type="number" name="acctNo" class="form-control" required />
                                    </p>
                                    <p>
                                        <label> Email: </label>
                                        <input type="email" name="email" class="form-control" required />
                                    </p>
                                    <p>
                                        <input type="submit" name="reset" value="Reset Password" class="btn btn-success form-control" required />
                                    </p>
                                    <p>
                                        Remembered password? <a href="#" onclick="modal.login()"> Login </a>
                                    </p>
                                    <p>
                                        Don't have an account? <a href="#" onclick="modal.signup()"> Create One </a>
                                    </p>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // function showSignup(){
    //     console.log('done!');
    // }
    const modal = {
        signup() {
            $("#login").hide();
            $("#reset").hide();
            $("#signup").fadeToggle("slow");
        },

        login() {
            $("#signup").hide();
            $("#reset").hide();
            $("#login").fadeToggle("slow");
        },

        reset() {
            $("#signup").hide();
            $("#login").hide();
            $("#reset").fadeToggle("slow");
        }

    };
</script>