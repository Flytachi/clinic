<?php
require_once 'functions/connection.php';

// Extentions
ini_set('session.cookie_lifetime', 0);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', "SameSite");
ini_set('session.cache_limiter', "nocache");
ini_set('session.use_trans_sid', 0);
ini_set('session.sid_length', 48);
ini_set('session.sid_bits_per_character', 7);
ini_set('session.hash_function', "sha512");
ini_set('session.save_path', dirname(__DIR__)."/sessions");


// Settings mod
if ( !$ini['GLOBAL_SETTING']['ROOT_MOD'] ) {
    define('ROOT_DIR', "/".basename(dirname(__DIR__)));
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

require_once dirname(__FILE__).'/Credo/__load__.php';
require_once dirname(__FILE__).'/functions/tag.php';
require_once dirname(__DIR__).'/libs/lib.php';

// Проверка сессий
if (!is_dir(dirname(__DIR__)."/sessions")) Mixin\Hell::error('403');

// Подключение Моделей
if (is_dir(dirname(__DIR__)."/models")) foreach (get_dir_contents(dirname(__DIR__)."/models/") as $filename) require_once $filename;

?>
