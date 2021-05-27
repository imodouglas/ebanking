<?php 
    include 'includes/env.inc.php';
    
    /** Initialize Classes */
    $userController = new UserController;
    $userView = new UserView;
    $transactionView = new TransactionsView;
    
    /** View & Controllers */   
    $view = new UserView();
    $transactionsView = new TransactionsView();
    $user = $userView->getUser($userSession);
    $users = $userView->getAllUsers();
    $account = $userView->getAccount($userSession);
    $transactions = $transactionsView->getMonthTransactions($userSession);

    if(isset($_POST['suspendUser'])){
        $userController->getUpdateStatus($_POST['acctNo'], 'suspended');
        echo "<script> window.location = '".$rootURL."admin/users'; </script>";
    } else if(isset($_POST['activateUser'])){
        $userController->getUpdateStatus($_POST['acctNo'], 'active');
        echo "<script> window.location = '".$rootURL."admin/users'; </script>";
    } else if(isset($_POST['deleteUser'])){
        if($userController->doFlushDocuments($userView->getUser($_POST['acctNo'])['id']) == true && $userController->doFlushTransactions($_POST['acctNo'])){
            if($userController->doDeleteUser($_POST['acctNo']) == true){
                echo "<script> alert('Account deleted successfully'); window.location = '".$rootURL."admin/users'; </script>";
            } else {
                echo "<script> alert('An error occured!'); window.location = '".$rootURL."admin/users'; </script>";
            }
        } else {
            echo "<script> alert('An error occured!'); window.location = '".$rootURL."admin/users'; </script>";
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

            <div class="card-box">
                <div class="card-box-heading" align="center"> 
                    ALL ACCOUNTS HOLDERS &nbsp;
                    <a href="<?php echo $rootURL.'admin/users/add'; ?>"> <button class="btn btn-dark btn-padding"> <i class="fas fa-plus"></i> </button> </a>
                </div>
            </div>
                
            <table class="responsive" style="width:100%">
                <tr>
                    <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Number </th>
                    <th style="width:35%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Name </th>
                    <th style="width:20%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;"> Account Balance </th>
                    <th style="width:25%; padding:10px; background:#333; color:#ccc; border-left:#ccc thin solid;" align="right"> Quick Links </th>
                </tr>

                <?php
                    foreach ($users as $acctInfo) {
                ?>
                <tr style="border-bottom:#ccc thin solid">
                    <td style="padding:10px; border-right:#ccc thin solid"> 
                        <a href="<?php echo $rootURL ?>admin/user/<?php echo $acctInfo['acctNo']; ?>"> <?php echo $acctInfo['acctNo']; ?>  </a>
                    </td>
                    <td style="padding:10px; border-right:#ccc thin solid"> <?php echo $acctInfo['fname']." ".$acctInfo['lname']; ?>  </td>
                    <td style="padding:10px; border-right:#ccc thin solid"> <?php echo "N".number_format($acctInfo['balance'],2); ?>  </td>
                    <td style="padding:10px" align="right"> 
                        <form action="" method="post">
                            <input type="hidden" name="acctNo" value="<?php echo $acctInfo['acctNo']; ?>" />
                            <?php 
                                if ($acctInfo['acctStatus'] == "active"){
                                    echo "<span class='complete-color'> Active </span>";
                                } else if ($acctInfo['acctStatus'] == "suspended"){
                                    echo "<span class='pending-color'> Suspended </span>";
                                } else if ($acctInfo['acctStatus'] == "pending"){
                                    echo "<span class='pending-color'> Pending </span>";
                                }
                            ?> &nbsp;
                            <a href="<?php echo $rootURL ?>admin/user/<?php echo $acctInfo['acctNo']; ?>" title="Manage User"> <i class="fas fa-cog complete-color"></i></a> 
                            <?php 
                                if ($acctInfo['acctStatus'] == "active"){
                            ?>
                                    <button type="submit" name="suspendUser" style="background:none; border:none; padding:0" title="Suspend User"> <i class='fas fa-pause-circle pending-color'></i>  </button>
                            <?php 
                                } else if ($acctInfo['acctStatus'] == "suspended" || $acctInfo['acctStatus'] == "pending"){
                            ?>
                                    <button type="submit" name="activateUser" style="background:none; border:none; padding:0"  title="Activate User"> <i class='fas fa-play-circle complete-color'></i>  </button>
                            <?php } ?>
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');" name="deleteUser" style="background:none; border:none; padding:0" title="Delete User"> <i class='fas fa-times pending-color'></i>  </button>
                        </form>
                    </td>
                </tr>
                <?php } ?>

            </table>

                <div class="row" style="margin-top:10px">

                </div>
            </div>

        </div>
    </div>
</div>