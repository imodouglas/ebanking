<?php 
    include 'includes/env.inc.php';
    
    /** User Controller Data */
    $controller = new UserController();
    
    /** User View Data */
    $view = new UserView();
    $user = $view->getUser($userSession);
    $account = $view->getAccount($userSession);

    function profileRow($title, $val){
        $data = "<div class='row m0 bottom-line'>";
        $data .= "<div class='col-sm-3 p10'> <strong> ".$title." </strong> </div>";
        $data .= "<div class='col-sm-9 p10'> ".$val." </div> </div>";

        return $data;
    }

    if(isset($_POST['changePassword'])){
        if($_POST['newPassword1'] == $_POST['newPassword2']){
            if($controller->getCheckPassword($userSession, $_POST['currentPassword']) == true){
                if($controller->getChangePassword($userSession, $_POST['newPassword1']) == true){
                    echo "<script> alert('Password changed successfully!'); </script>";
                } else {
                    echo "<script> alert('An error occured!'); </script>";
                }
            } else {
                echo "<script> alert('An error occured!'); </script>";
            }
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
            <div class="col-md-6">
                <div class="card-box">
                    <div class="card-box-heading" align="center"> ACCOUNT INFORMATION </div>
                    <div class="card-box-body">
                        <?php 
                            echo profileRow("Full Name", $user['fname']." ".$user['mname']." ".$user['lname']);
                            echo profileRow("Account No.", $user['acctNo']);     
                            echo profileRow("Address", $user['address']);
                            echo profileRow("Phone No.", $user['phone']);
                            echo profileRow("Email", $user['email']);
                            // echo profileRow("Designation", ucfirst($user['designation']));
                        ?>                        
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-box">
                    <div class="card-box-heading" align="center"> CHANGE PASSWORD </div>
                    <div class="card-box-body">
                        <form action="" method="post">
                            <p>
                                <input type="password" name="currentPassword" id="currentPassword" class="form-control" placeholder="Current Password" required>
                            </p>
                            <p>
                                <input type="password" name="newPassword1" id="newPassword1" class="form-control" placeholder="New Password" required>
                            </p>
                            <p>
                                <input type="password" name="newPassword2" id="newPassword2" class="form-control" placeholder="Re-enter New Password" required>
                            </p>
                            <p>
                                <input type="submit" value="Change Password" name="changePassword" class="btn btn-success form-control">
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top:10px"></div>
        </div>
    </div>
</div>