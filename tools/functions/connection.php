<?php
// Database Constants
define("DRIVER", "mysql");
define("DB_HOST", "localhost");
// define("DB_NAME", "clinic");
// define("DB_USER", "clinic");
// define("DB_PASS", "clin_pik27");
define("DB_NAME", "u723643070_clinic");
define("DB_USER", "u723643070_clinic");
define("DB_PASS", "u723643070_Clinic_pik27");
define("CHARSET", "utf8");
$DNS = DRIVER.":host=".DB_HOST.";dbname=".DB_NAME.";charset=".CHARSET;

// print_r(PDO::getAvailableDrivers());
try {
    $db = new PDO($DNS, DB_USER, DB_PASS);
    $db->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
} catch (\PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
}
/*
    foreach($db->query('SELECT * from users') as $row) {
        print code..
    };
*/
?>
