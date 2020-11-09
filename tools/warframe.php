<?php

$PROJECT_NAME = "clinic";

$PERSONAL = array(
    1 => "Администратор",
    2 => "Регистратура",
    3 => "Кассир",
    4 => "Аптекарь",
    5 => "Врач",
    6 => "Лаборатория",
    7 => "Бугалтер",
    8 => "Медсестра",
);

$FLOOR = array(
    1 => "1 этаж",
    2 => "2 этаж",
    3 => "3 этаж",
);

require_once 'functions/connection.php';
require_once 'functions/auth.php';
require_once 'functions/tag.php';
require_once 'models.php';


function get_full_name($id = null) {
    global $db;
    if($id){
        $stmt = $db->query("SELECT first_name, last_name, father_name from users where id = $id")->fetch(PDO::FETCH_OBJ);
    }else{
        $id = $_SESSION['session_id'];
        $stmt = $db->query("SELECT first_name, last_name, father_name from users where id = $id")->fetch(PDO::FETCH_OBJ);
    }
    return ucwords($stmt->last_name." ".$stmt->first_name." ".$stmt->father_name);
}

function get_name($id = null) {
    global $db;
    if($id){
        $stmt = $db->query("SELECT first_name, last_name from users where id = $id")->fetch(PDO::FETCH_OBJ);
    }else{
        $id = $_SESSION['session_id'];
        $stmt = $db->query("SELECT first_name, last_name from users where id = $id")->fetch(PDO::FETCH_OBJ);
    }
    return ucwords($stmt->last_name." ".$stmt->first_name);
}

function level() {
    /*
    level()
    */
	global $db;
    $id = $_SESSION['session_id'];
    $stmt = $db->query("SELECT user_level from users where id = $id")->fetchColumn();
	return intval($stmt);
}

function level_name($id = null) {
    /*
    level_name(1)
    */
    global $db, $PERSONAL;
    if($id){
        $stmt = $id;
    }else{
        $id = $_SESSION['session_id'];
        $stmt = $db->query("SELECT user_level from users where id = $id")->fetchColumn();
    }
	return $PERSONAL[$stmt];
}

function permission($arr){
    /*
    permission(1) or permission([1,2, ..])
    */
    $perk =level();
    if (is_array($arr)){
        if(in_array($perk, $arr)){
            return true;
        }else{
            return false;
        }
    }else{
        if(intval($arr) == $perk){
            return true;
        }else{
            return false;
        }
    }

}

function dateformat($var=""){
	$var = strtotime($var) ;
	$var = date('Y-m-d', $var);
	return $var;
}

function nodateformat($var=""){
	$var = strtotime($var) ;
	$var = date('d-m-Y', $var);
	return $var ;
}

function showTitle() //Функция title
{
	$title = "Clinic";
	return $title;
}

function form($name) //Функция title
{
	return $name();
}

/* Добавляет нули к числам, чьи значаения меньше пятизначных*/

function addZero($number){

    $strNumber = strval($number);
    $newNumber = "";

    if(strlen($strNumber) < 5){

        $countZero = 5 - strlen($strNumber);

        for ($i=0; $i < $countZero; $i++) {

            $newNumber .= "0";
        }
        $newNumber .= $strNumber;
        return $newNumber;
    }

    return $strNumber;
}


function division_name($id = null) {
    global $db, $PERSONAL;
    if(!$id){
        $id = $_SESSION['session_id'];
        $id = $db->query("SELECT division_id from users where id = $id")->fetchColumn();
    }

    try{
        $stmt = $db->query("SELECT name from division where id = $id")->fetchColumn();
        // $stmt = "( $stmt )";
    }
    catch (PDOException $ex) {
        $stmt = null;
    }

	return $stmt;
}
?>
