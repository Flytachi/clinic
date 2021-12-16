<?php

function dieConection($_error = null) { die(include "error.php"); }

if (!file_exists(dirname(__DIR__, 3)."/.cfg")) dieConection("Configuration file not found.");
$cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 3)."/.cfg") );
$ini = json_decode(zlib_decode(hex2bin($cfg)), true);

if (isset($ini['SECURITY']['GUARD']) and $ini['SECURITY']['GUARD']) {
    if (!file_exists(dirname(__DIR__, 3)."/.key")) dieConection("Authenticity check failed.");
    $key = explode("-", zlib_decode(hex2bin(file(dirname(__DIR__, 3)."/.key")[0])) );
    if ( empty($ini['SECURITY']['SERIA']) or trim($key[0]) !== trim($ini['SECURITY']['SERIA']) or !(date('Y-m-d H:i:s') >= date('Y-m-d H:i:s', $key[1]) && date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', $key[2])) ) dieConection("Authenticity check failed.");
}


// Settings mod
if ( !$ini['GLOBAL_SETTING']['ROOT_MOD'] ) {
    define('ROOT_DIR', "/".basename(dirname(__DIR__, 3)));
    if ("/".$_SERVER['HTTP_HOST'] == ROOT_DIR) define('DIR', "");
    else define('DIR', ROOT_DIR);
}else define('DIR', "");
// END Settings mod


// Settings debugger
if ( isset($ini['GLOBAL_SETTING']['DEBUG']) and $ini['GLOBAL_SETTING']['DEBUG'] ) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $DEBUG_time_start = microtime(true);
}
// END Settings debugger


// File extension
if ( isset($ini['GLOBAL_SETTING']['HIDE_EXTENSION']) and $ini['GLOBAL_SETTING']['HIDE_EXTENSION'] ) define('EXT', "");
else define('EXT', ".php");
// END File extension

?>