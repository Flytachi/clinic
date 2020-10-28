<?php
// Database Constants
define("DRIVER", "pgsql");
define("DB_HOST", "localhost");
define("DB_NAME", "clinic");
define("DB_USER", "clinic");
define("DB_PASS", "clin_pik27");
$DNS = "".DRIVER.":host=".DB_HOST.";dbname=".DB_NAME.";user=".DB_USER.";password=".DB_PASS."";

// print_r(PDO::getAvailableDrivers()); 
try {
    $db = new PDO($DNS);
    $db->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

// foreach($db->query('SELECT * from users') as $row) {
//  print code..
// }
?>