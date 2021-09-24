<?php
require_once 'functions/connection.php';

// Settings mod
ini_set("session.gc_probability", ($ini['GLOBAL_SETTING']['SESSION_GC_PROBABILITY']) ? $ini['GLOBAL_SETTING']['SESSION_GC_PROBABILITY'] : 0);
ini_set("session.gc_divisor", ($ini['GLOBAL_SETTING']['SESSION_GC_DIVISOR']) ? $ini['GLOBAL_SETTING']['SESSION_GC_DIVISOR'] : 1000);
ini_set('session.gc_maxlifetime', ($ini['GLOBAL_SETTING']['SESSION_LIFE']) ? $ini['GLOBAL_SETTING']['SESSION_LIFE'] * 60 : 1800);
ini_set('session.cookie_lifetime', ($ini['GLOBAL_SETTING']['SESSION_COOKIE_LIFETIME']) ? $ini['GLOBAL_SETTING']['SESSION_COOKIE_LIFETIME'] * 60 : 0);

if ( !$ini['GLOBAL_SETTING']['ROOT_MOD'] ) {
    define('ROOT_DIR', "/".basename(dirname(__DIR__)));

    if ("/".$_SERVER['HTTP_HOST'] == ROOT_DIR) {
        define('DIR', "");
    }else {
        define('DIR', ROOT_DIR);
    }

}else {
    define('DIR', "");
}

// END Settings mod

// Settings debugger
if ( isset($ini['GLOBAL_SETTING']['DEBUG']) and $ini['GLOBAL_SETTING']['DEBUG'] ) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// END Settings debugger


// File extension

if ( isset($ini['GLOBAL_SETTING']['HIDE_EXTENSION']) and $ini['GLOBAL_SETTING']['HIDE_EXTENSION'] ) {

    define('EXT', "");

}else {

    define('EXT', ".php");

}

// END File extension

require_once dirname(__FILE__).'/functions/session.php';
require_once dirname(__FILE__).'/functions/model.php';
require_once dirname(__FILE__).'/functions/table.php';
require_once dirname(__FILE__).'/functions/tag.php';
require_once dirname(__DIR__).'/libs/lib.php';

// Engineering works

if ( isset($ini['GLOBAL_SETTING']['ENGINEERING_WORKS']) and $ini['GLOBAL_SETTING']['ENGINEERING_WORKS'] ) {

    if ( empty($work_url) ) {
        Mixin\error("engineering_work");
    }

}else{

    if ( isset($work_url) ) {
        index();
    }

}

// END Engineering works
function showTitle() //Функция title
{
    return "MedLine";
}

function get_full_name($id = null) {
    global $db, $session;
    if($id){
        $stmt = $db->query("SELECT first_name, last_name, father_name from users where id = $id")->fetch(PDO::FETCH_OBJ);
        return ucwords($stmt->last_name." ".$stmt->first_name." ".$stmt->father_name);
    }else{
        return $session->get_full_name();
    }
}

function bytes($bytes, $force_unit = NULL, $format = NULL, $si = TRUE)
{
    // Format string
    $format = ($format === NULL) ? '%01.2f %s' : (string) $format;

    // IEC prefixes (binary)
    if ($si == FALSE OR strpos($force_unit, 'i') !== FALSE)
    {
        $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
        $mod   = 1024;
    }
    // SI prefixes (decimal)
    else
    {
        $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
        $mod   = 1000;
    }

    // Determine unit to use
    if (($power = array_search((string) $force_unit, $units)) === FALSE)
    {
        $power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
    }

    return sprintf($format, $bytes / pow($mod, $power), $units[$power]);
}

function level($id = null) {
    /*
    level()
    */
    global $db, $session;
    if(!$id){
        $stmt = $session->get_level();
    }else {
        $stmt = $db->query("SELECT user_level from users where id = $id")->fetchColumn();
    }
    return intval($stmt);
}

function level_name($id = null) {
    /*
    level_name(1)
    */
    global $PERSONAL;
    return $PERSONAL[level($id)];
}

function permission($arr){
    /*
    permission(1) or permission([1,2, ..])
    */
    global $session;
    if (is_array($arr)){
        if(in_array($session->get_level(), $arr)){
            return true;
        }else{
            return false;
        }
    }else{
        if(intval($arr) == $session->get_level()){
            return true;
        }else{
            return false;
        }
    }

}

function number_color(Int $int = null, Bool $type = false)
{
    if ($int > 0) {
        return ($type) ? "danger" : "success";
    }elseif ($int < 0) {
        return ($type) ? "success" : "danger";
    } else {
        return "dark";
    }
}

function date_f($item = null, $format = null){
    $item = strtotime($item);
    if (!is_string($format)) $format = ($format) ? 'd.m.Y H:i' : 'd.m.Y';
    return date($format, $item);
}


function num_word($value, $words, $show = true) 
{
    $num = $value % 100;
    if ($num > 19) $num = $num % 10;
    $out = ($show) ? $value . ' ' : '';
    switch ($num) {
        case 1:  $out .= $words[0]; break;
        case 2: 
        case 3: 
        case 4:  $out .= $words[1]; break;
        default: $out .= $words[2]; break;
    }
    return $out;
}

function minToStr($mins)
{
    $res = '';
    $days = floor($mins / 24);
    $mins = $mins % 24;
    $res .= num_word($days, array('день', 'дня', 'дней')) . ' ';
    $hours = floor($mins / 1);
    $mins = $mins % 1;
    $res .= num_word($hours, array('час', 'часа', 'часов')) . ' ';
    return $res;
}

// Подключение Моделей
foreach (get_dir_contents(dirname(__DIR__)."/models/") as $filename) {
    require_once $filename;
}
?>
