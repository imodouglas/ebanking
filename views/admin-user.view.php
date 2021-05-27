<?php 
    include 'includes/env.inc.php';

    if(!isset($id)){
        echo "<script> window.location = '".$rootURL."admin/users'; </script>";
    }
    
    /** Initialize Classes */
    $userController = new UserController;
    $userView = new UserView;
    $transactionView = new TransactionsView;
    
    /** View & Controllers */   
    $view = new UserView();
    $transactionsView = new TransactionsView();
    $user = $userView->getUser($userSession);
    $getUser = $userView->getUser($id);
    $account = $userView->getAccount($userSession);
    $transactions = $transactionsView->getUserMonthTransactions($id);

    function profileRow($title, $val){
        $data = "<div class='row m0 bottom-line'>";
        $data .= "<div class='col-sm-5 p10'> <strong> ".$title." </strong> </div>";
        $data .= "<div class='col-sm-7 p10'> ".$val." </div> </div>";

        return $data;
    }


    if(isset($_POST['suspendUser'])){
        $userController->getUpdateStatus($id, 'suspended');
        echo "<script> window.location = '".$rootURL."admin/user/".$id."'; </script>";
    } else if(isset($_POST['activateUser'])){
        $userController->getUpdateStatus($id, 'active');
        echo "<script> window.location = '".$rootURL."admin/user/".$id."'; </script>";
    }

    if(isset($_POST['uploadDoc'])){
        if($_POST['fileType'] == "Others" && $_POST['others'] !== ""){ $docName = $_POST['others']; } else { $docName = $_POST['fileType']; }
        $newName = explode(" ", $docName);
        $newName = implode("-", $newName);

        $temp = explode(".", $_FILES["doc"]["name"]);
        $newfilename = $getUser['acctNo'].'-'.$newName . '.' . end($temp);
        if(move_uploaded_file($_FILES["doc"]["tmp_name"], "assets/images/documents/" . $newfilename)){
            $result = $userController->doAddDocument($getUser['id'], $docName, $newfilename);
            if($result == true){
                echo "<script> alert('Document upload successful'); window.location='".$rootURL."admin/user/".$getUser['acctNo']."' </script>";
            } else {
                echo "<script> alert('An error occured! Try again.'); </script>";
            }
        }
        
    }

    if(isset($_POST['updateProfile'])){
        if($userController->doUpdateUser($getUser['acctNo'], $_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['address'], $_POST['phone'], $_POST['email']) == true){
            echo "<script> alert('Profile upload successful'); window.location='".$rootURL."admin/user/".$getUser['acctNo']."' </script>";
        } else {
            echo "<script> alert('An error occured! Try again.'); </script>";
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
                    <div class="col-sm-6">
                        <div class="card-box">
                            <div class="card-box-heading" align="center"> ACCOUNT INFORMATION <a class="white-color clickable" onclick="editProfile()"> <i class="fas fa-edit"></i> </a> </div>
                            <div class="card-box-body">
                                <div id="account-info">
                                    <?php 
                                        echo profileRow("Full Name", $getUser['fname']." ".$getUser['mname']." ".$getUser['lname']);
                                        echo profileRow("Account No.", $getUser['acctNo']);     
                                        echo profileRow("Address", $getUser['address']);
                                        echo profileRow("Phone No.", $getUser['phone']);
                                        echo profileRow("Email", $getUser['email']);
                                        // echo profileRow("Designation", ucfirst($user['designation']));
                                    ?>                        
                                    <div class='row m0 bottom-line'>
                                        <div class='col-sm-5 p10'> <strong> Status </strong> </div>
                                        <div class='col-sm-7 p10'> 
                                            <form action="" method="post">
                                                <?php echo $getUser['acctStatus']; 
                                                    if ($getUser['acctStatus'] == 'active'){
                                                        echo "&nbsp; <button type='submit' name='suspendUser' style='background:none; border:none; padding:0'> <i class='fas fa-pause-circle pending-color'></i>  </button>";   
                                                    } else if ($getUser['acctStatus'] == 'suspended' || $getUser['acctStatus'] == 'pending'){
                                                        echo "&nbsp; <button type='submit' name='activateUser' style='background:none; border:none; padding:0'> <i class='fas fa-play-circle complete-color'></i>  </button>";
                                                    } 
                                                ?>
                                            </form>
                                        </div> 
                                    </div>
                                </div>
                                <div id="edit-account" style="display:none">
                                    <form action="" method="post">
                                        <?php 
                                            echo profileRow("First Name", "<input type='text' name='fname' class='form-control' value='".$getUser['fname']."' />");
                                            echo profileRow("Middle Name", "<input type='text' name='mname' class='form-control' value='".$getUser['mname']."' />");
                                            echo profileRow("Surname", "<input type='text' name='lname' class='form-control' value='".$getUser['lname']."' />");
                                            echo profileRow("Address", "<textarea name='address' class='form-control'>".$getUser['address']."</textarea>");
                                            echo profileRow("Phone No.", "<input type='number' name='phone' class='form-control' value='".$getUser['phone']."' />");
                                            echo profileRow("Email", "<input type='text' name='email' class='form-control' value='".$getUser['email']."' />");
                                        ?>
                                        <button type='submit' name='updateProfile' class="btn btn-success form-control"> Update Profile </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-box">
                            <div class="card-box-heading" align="center"> USER'S DOCUMENTS &nbsp; <span onclick="addDocument()"> <i class="fas fa-plus-circle white-color clickable"></i> </span> </div>
                            <div class="card-box-body">
                                <div style="border:#ccc thin solid; margin-bottom:20px; padding:10px; display:none" id="uploadDocument">
                                    <form action="" enctype="multipart/form-data" method="post">
                                        <p>
                                            <label> Type of document </label>
                                            <select name="fileType" id="fileType" class="form-control" onchange="uploadFile.checkOthers()" required>
                                                <option value="Passport">Passport</option>
                                                <option value="Identification">Identification</option>
                                                <option value="Application Form">Application Form</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </p>
                                        <p id="others"  style="display:none">
                                            <label> Name of other document </label>
                                            <input type="text" name="others" class="form-control">
                                        </p>
                                        <p>
                                            <label> Select the file </label>
                                            <input type="file" name="doc" id="doc" class="form-control" required>
                                        </p>
                                        <p>
                                            <input type="submit" name="uploadDoc" value="Upload" class="btn btn-success form-control">
                                        </p>
                                    </form>
                                </div>

                                <?php 
                                    if($userController->getUserDocumentsTotal($getUser['id']) == 0) {
                                        echo "<h5> No document uploaded yet! </h5>";
                                     } else { 
                                         foreach ($userController->getUserDocuments($getUser['id']) as $document){
                                ?>
                                    <div style="border-bottom:#ccc thin solid; padding:10px">
                                            <i class="fas fa-caret-right"></i> 
                                            <a href="<?php echo $rootURL.'assets/images/documents/'.$document['file_name']; ?>" target="_blank"> <?php echo $document['type'] ?> </a>
                                    </div>
                                <?php 
                                     } }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card-box">
                            <div class="card-box-heading" align="center"> ALL TRANSACTIONS FOR <?php echo strtoupper(date("F")) ?> </div>
                        </div>

                        <?php 
                            if($transactions == false){
                                echo "<div align='center'> <h5> No transaction for this month yet! </h5> </div>";
                            } else {
                                foreach ($transactions AS $trans){
                                    if($trans['transType'] == "CR"){ $symbol = "+"; $color="complete"; } else { $symbol = "-"; $color="pending"; }
                        ?>
                            <div class="card-box">
                                <div class="card-box-body">
                                    <div class="row m0">
                                        <div class="col-sm-12">
                                            <div class="trans-desc"> <?php echo $trans['transDesc']; ?> </div>
                                            <div class="trans-date"> <?php echo date("d F, Y", $trans['transDate']); ?> &nbsp; <span class="trans-status-<?php echo strtolower($trans['transStatus']); ?>"> <?php echo $trans['transStatus']; ?> </span> </div>
                                            <div class="trans-amount">
                                                <span class="<?php echo $color; ?>-color"><?php echo $symbol; ?> N<?php echo number_format($trans['transAmount'],2); ?></span>
                                            </div>
                                            <div class="trans-balance gray-color"> <b> Balance: </b> N<?php echo number_format($trans['acctBalance'],2); ?> </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } } ?>
                    </div>
                </div>    
            

                <div class="row" style="margin-top:10px">

                </div>
            </div>

        </div>
    </div>
</div>

<script>

    const addDocument = () => {
        $("#uploadDocument").slideToggle("fast");
    }

    const editProfile = () => {
        $("#account-info").slideToggle("fast");
        $("#edit-account").slideToggle("fast");
    }   

    const uploadFile = {
        checkOthers(){
            if($("#fileType").val() == "Others"){
                $("#others").slideToggle("fast");
            } else {
                $("#others").slideUp("fast");
            }
        }
    }
</script>