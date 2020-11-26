<?php
/* Database config */

$ini =  parse_ini_file("../../../tools/functions/setting.ini", true);

$db_host		= $ini['DATABASE']['HOST'];
$db_user		= $ini['DATABASE']['USER'];
$db_pass		= $ini['DATABASE']['PASS'];
$db_database	=  $ini['DATABASE']['NAME'];


// $db_host		= '127.0.0.1';
// $db_user		= 'clinic';
// $db_pass		= 'clin_pik27';
// $db_database	= 'u723643070_apt';

/* End config */


$db = new PDO('mysql:host='.$db_host.';dbname='.$db_database, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
