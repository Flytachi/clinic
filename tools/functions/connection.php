<?php
// Database Constants
if (!file_exists(dirname(__DIR__, 2)."/.key")) {
    $_error = "Authenticity check failed!";
    die(include "error_db_connect.php");
}else{
    if (!file_exists(dirname(__DIR__, 2)."/.cfg")) {
        $_error = "Сonfiguration key not found!";
        die(include "error_db_connect.php");
    }
    $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 2)."/.cfg") );
    $key = explode("-", zlib_decode(hex2bin(file(dirname(__DIR__, 2)."/.key")[0])) );
    $ini = json_decode(zlib_decode(hex2bin($cfg)), true);

    if ( empty($ini['SECURITY']['SERIA']) or trim($key[0]) !== trim($ini['SECURITY']['SERIA']) or date_diff( new \DateTime(date('Y-m-d H:i:s', $key[1])), new \DateTime(date('Y-m-d H:i:s')) )->d >= 3 ) {
        $_error = "Authenticity check failed!";
        die(include "error_db_connect.php");
    }
}

$DNS = $ini['GLOBAL_SETTING']['DRIVER'].":host=".$ini['DATABASE']['HOST'].";dbname=".$ini['DATABASE']['NAME'].";charset=".$ini['GLOBAL_SETTING']['CHARSET'];

// Site Constants
date_default_timezone_set($ini['GLOBAL_SETTING']['TIME_ZONE']);
// print_r(PDO::getAvailableDrivers());
// prit($ini);
try {
    $db = new PDO($DNS, $ini['DATABASE']['USER'], $ini['DATABASE']['PASS']);
    $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
    if ( isset($ini['GLOBAL_SETTING']['DEBUG']) and $ini['GLOBAL_SETTING']['DEBUG'] ) {
        $db->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
} catch (\PDOException $e) {
    $_error = $e->getMessage();
    die(include "error_db_connect.php");
    // Класический Вывод ошибок
    // die(include "error_db_connect.php");
}
?>
