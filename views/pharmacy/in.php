<?php
/* Database config */
$db_host		= '127.0.0.1';
$db_user		= 'clinic';
$db_pass		= 'clin_pik27';
$db_database	= 'u723643070_apt'; 

/* End config */


$db1 = new PDO('mysql:host='.$db_host.';dbname='.$db_database, $db_user, $db_pass);
$db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>