<?php 
setcookie('second1',"", time() - 3600);
setcookie('minute1',"", time() - 3600);
setcookie('hour1',"", time() - 3600);
setcookie('sessionTime',"", time() - 3600);
session_start();
unset($_SESSION['session_id']);
session_destroy();
header("location:login.php");
?>