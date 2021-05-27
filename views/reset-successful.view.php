<?php 
    include 'includes/env.inc.php'; 
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12" style="padding:20px; min-height: 600px" align='center'>
            <div class="card-title"> Password Reset Successful! </div>
            <div style="padding:20px">
                <i class='fas fa-check-circle' style="color:green; font-size:80px"></i>
            </div>
            <p>
                A new password has been sent to your email. If you can't find it in your inbox, please check the promotions (Gmail) or spam/junk folder.
            </p>
            <p>
                If you don't receive the new password in 5 minutes (NOT BEFORE), please retry the process.
            </p>
            <p>
                <a href="<?php echo $rootURL; ?>" class="btn btn-success" style="color:#fff"> Login </a>
            </p>
        </div>
    </div>
</div>