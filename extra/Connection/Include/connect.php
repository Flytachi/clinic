<?php

$DNS = $ini['GLOBAL_SETTING']['DRIVER'].":host=".$ini['DATABASE']['HOST'].";dbname=".$ini['DATABASE']['NAME'].";charset=".$ini['GLOBAL_SETTING']['CHARSET'];
date_default_timezone_set($ini['GLOBAL_SETTING']['TIME_ZONE']);

try {
    $db = new PDO($DNS, $ini['DATABASE']['USER'], $ini['DATABASE']['PASS']);
    $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
    if ( isset($ini['GLOBAL_SETTING']['DEBUG']) and $ini['GLOBAL_SETTING']['DEBUG'] ) $db->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    $_error = $e->getMessage();
    die(include "error.php");
}

?>