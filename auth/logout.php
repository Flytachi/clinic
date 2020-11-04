<?php 
session_start();
unset($_SESSION['session_id']);
session_destroy();
header("location:login.php");
?>

<script src="../vendors/js/cookie.js"></script>
<script>
	
	deleteCookie('second1', 0);
	deleteCookie('hour1', hour1);
	deleteCookie('minute1', 0);

</script>