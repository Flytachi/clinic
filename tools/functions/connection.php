<?php
// Database Constants
$ini =  parse_ini_file("setting.ini", true);
$DNS = $ini['GLOBAL_SETTING']['DRIVER'].":host=".$ini['DATABASE']['HOST'].";dbname=".$ini['DATABASE']['NAME'].";charset=".$ini['GLOBAL_SETTING']['CHARSET'];
// Site Constants
date_default_timezone_set($ini['GLOBAL_SETTING']['TIME_ZONE']);
// print_r(PDO::getAvailableDrivers());
try {
    $db = new PDO($DNS, $ini['DATABASE']['USER'], $ini['DATABASE']['PASS']);
    $db->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
} catch (\PDOException $e) {
    die(include "error_db_connect.php");
    // Класический Вывод ошибок
    // die(include "error_db_connect.php");
}
?>
