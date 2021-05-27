<?php

/** This system was built by EasyWebsite Nigeria - https://easywebsite.com.ng */

$companyName = "Sample Bank";
$companyPhone = "08012345678";
$companyEmail = "info@samplebank.ew";
$rootURL = "http://ebanking.ew/";
$minWithdrawal = 1000;

if(isset($_SESSION['eb_user_session'])){
    $userSession = $_SESSION['eb_user_session'];
} else if(isset($_SESSION['eb_admin_session'])){
    $userSession = $_SESSION['eb_admin_session'];
}