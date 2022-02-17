<?php

define('DIR', str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__))); // $_SERVER['HTTP_HOST']


// Todo Prepare Setting

// * Settings


// * Cfg
if (!file_exists(dirname(__DIR__)."/.cfg")) dieConection("Configuration file not found.");
$cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__)."/.cfg") );
define("ini", json_decode(zlib_decode(hex2bin($cfg)), true));
$ini = ini;

// * File extension
if ( isset(ini['GLOBAL_SETTING']['HIDE_EXTENSION']) and ini['GLOBAL_SETTING']['HIDE_EXTENSION'] ) define('EXT', "");
else define('EXT', ".php");

// * Debugger
if ( isset(ini['GLOBAL_SETTING']['DEBUG']) and ini['GLOBAL_SETTING']['DEBUG'] ) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $DEBUG_time_start = microtime(true);
}

// * Guard
if (isset(ini['SECURITY']['GUARD']) and ini['SECURITY']['GUARD']) {
    if (!file_exists(dirname(__DIR__, 3)."/.key")) dieConection("Authenticity check failed.");
    $key = explode("-", zlib_decode(hex2bin(file(dirname(__DIR__, 3)."/.key")[0])) );
    if ( empty(ini['SECURITY']['SERIA']) or trim($key[0]) !== trim(ini['SECURITY']['SERIA']) or !(date('Y-m-d H:i:s') >= date('Y-m-d H:i:s', $key[1]) && date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', $key[2])) ) dieConection("Authenticity check failed.");
}


// * END Settings


// ! Import function
foreach (glob(dirname(__FILE__)."/Function/*") as $function) require $function;
// ! END Import

// ! Import src
foreach (glob(dirname(__FILE__)."/Src/*") as $plugin) require $plugin . '/__load__.php';
// ! END Import

// Todo Prepare End

?>