<?php
  if(isset($_SESSION['ascosUser'])){
    if($_SESSION['ascosPriv'] == "Administrator"){
      include 'classes/switch-bar.php';
    } else {
      if($page == "admin"){
        header("Location: home.php");
      }
    }
  } else {
    header("Location: index.php");
  }
?>
