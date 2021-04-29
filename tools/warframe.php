<?php
require_once 'functions/connection.php';

// Settings mod
ini_set("session.gc_probability", ($ini['GLOBAL_SETTING']['SESSION_GC_PROBABILITY']) ? $ini['GLOBAL_SETTING']['SESSION_GC_PROBABILITY'] : 0);
ini_set("session.gc_divisor", ($ini['GLOBAL_SETTING']['SESSION_GC_DIVISOR']) ? $ini['GLOBAL_SETTING']['SESSION_GC_DIVISOR'] : 1000);
ini_set('session.gc_maxlifetime', ($ini['GLOBAL_SETTING']['SESSION_LIFE']) ? $ini['GLOBAL_SETTING']['SESSION_LIFE'] * 60 : 1800);
ini_set('session.cookie_lifetime', ($ini['GLOBAL_SETTING']['SESSION_COOKIE_LIFETIME']) ? $ini['GLOBAL_SETTING']['SESSION_COOKIE_LIFETIME'] : 0);


if (!$ini['GLOBAL_SETTING']['ROOT_MOD']) {
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

if ($ini['GLOBAL_SETTING']['DEBUG']) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// END Settings debugger


// File extension

if ($ini['GLOBAL_SETTING']['HIDE_EXTENSION']) {

    define('EXT', "");

}else {

    define('EXT', ".php");

}

// END File extension

require_once dirname(__FILE__).'/constant.php';
require_once dirname(__FILE__).'/functions/session.php';
require_once dirname(__FILE__).'/functions/tag.php';
require_once dirname(__FILE__).'/functions/base.php';
require_once dirname(__FILE__).'/functions/model.php';
require_once dirname(__DIR__).'/libs/lib.php';


$session = new Session($db, $ini['GLOBAL_SETTING']['SESSION_LIFE']);

// Подключение Моделей
foreach (get_dir_contents($_SERVER['DOCUMENT_ROOT']."/models/") as $filename) {
    require_once $filename;
}

// Module
require_once 'module.php';
// END Module

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

function zeTTa_data()
{
    global $db;
    $id = $_SESSION['session_id'];
    $stmt = $db->query("SELECT pacs_login, pacs_password from users where id = $id")->fetch(PDO::FETCH_OBJ);
    return $stmt;
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

function date_f($item = null, $type = 0){
    $item = strtotime($item) ;
    $format = ($type) ? 'd.m.Y H:i' : 'd.m.Y';
    return date($format, $item);
}

/* Добавляет нули к числам, чьи значаения меньше пятизначных*/

function addZero($number){

    $max_item = 6;
    $strNumber = strval($number);
    $newNumber = "";

    if(strlen($strNumber) < $max_item){

        $countZero = $max_item - strlen($strNumber);

        for ($i=0; $i < $countZero; $i++) {

            $newNumber .= "0";
        }
        $newNumber .= $strNumber;
        return $newNumber;
    }

    return $strNumber;
}

// Divisions
function division($id = null) {
    global $db, $session;

    if (!$id) {
        return $session->get_division();
    } else {
        $id = $db->query("SELECT division_id from users where id = $id")->fetchColumn();
        try{
            $stmt = $db->query("SELECT id from division where id = $id")->fetchColumn();
        }
        catch (PDOException $ex) {
            $stmt = null;
        }
        return $stmt;
    }
    
}

function division_name($id = null) {
    global $db;
    try{
        $stmt = $db->query("SELECT name FROM division WHERE id =".division($id))->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
    return $stmt;
}

function division_title($id = null) {
    global $db;
    try{
        $stmt = $db->query("SELECT title FROM division WHERE id =".division($id))->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
    return $stmt;
}

function division_assist($id = null) {
    global $db;
    try{
        $stmt = $db->query("SELECT assist FROM division WHERE id =".division($id))->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
    return $stmt;
}
// END Divisions

function pagination_page($count, $elem, $count_button = 2)
{
    $count -= 1;

    echo "<ul class=\"pagination align-self-center justify-content-center mt-3\" >";

    for ($i= intval($_GET['of']) - 1, $a = 0; $i < intval($_GET['of']) and $i >= (intval($_GET['of']) - $elem) and  $i >= 0 and $a != $count_button; $i--, $a++) {

        $mas[] = $i;
    }

    $mas = array_reverse($mas);

    // echo $mas[0];

    if(intval($_GET['of']) >= ($count_button + 1) and isset($mas)){
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=0' class='page-link' legitRipple>1</a></li>";
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".(floor($mas[0] / 2) ) ."' class='page-link' legitRipple>...</a></li>";
    }


    foreach ($mas as $key) {
        $label = $key + 1;
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".($key)."' class='page-link' legitRipple>$label</a></li>";
    }

    echo "<li class=\"page-item active\"><a href=\"". $_SERVER['PHP_SELF'] ."?of=". ($_GET['of']) ."\" class=\"page-link legitRipple\">". intval($_GET['of'] + 1) ."</a></li>";



    for ($i= (intval($_GET['of'])+1) , $a = 0; $i <= (intval($_GET['of'])+$elem) and $i <= $count and $a != $count_button; $i++, $a++) {

        $mas1[] = $i;
    }


    foreach ($mas1 as $key) {
        $label = $key + 1;
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".($key)."' class='page-link' legitRipple>$label</a></li>";
    }

    if( ($count - intval($_GET['of'])) >= ($count_button + 1) and isset($mas1)){
        $label = $count + 1;
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".(floor((end($mas1)  + $count) / 2 )) ."' class='page-link' legitRipple>...</a></li>";
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".($count)."' class='page-link' legitRipple>$label</a></li>";
    }

    echo "</ul>";
}
?>
