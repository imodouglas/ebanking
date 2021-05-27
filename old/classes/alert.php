<?php
  if(isset($syssuccess)){
    echo "<div style='padding: 5px; margin-bottom: 10px; font-size:12px; background:#9BFF9B; color:#006600' align='center'> ".$syssuccess." </div>";
  } else if(isset($sysfailure)){
    echo "<div style='padding: 5px; margin-bottom: 10px; font-size:12px; background:#FFB0B3; color:#FF0000' align='center'> ".$sysfailure." </div>";
  }
?>
