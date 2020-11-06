<?php

$PERSONAL = array(
    1 => "Администратор",
    2 => "Регистратура",
    3 => "Аптекарь",
    4 => "Кассир",
    5 => "Врач",
    6 => "Бугалтер",
);

$FLOOR = array(
    1 => "1 этаж",
    2 => "2 этаж",
    3 => "3 этаж",
);

// TODO Functions
/*
    --| is_auth()
    --| get_full_name(),
    --| get_name(),
    --| level(),
    --| permission(),
    --| delete(),
    --| prit()
    --| clean(),
    --| dateformat(),
    --| nodateformat(),
    --| showTitle(),
    --| form(),
    --| addZero(),
*/

require_once 'connection.php';
require_once 'forms.php';

function is_auth($arr = null){
    session_start();
    if (!$_SESSION['session_id']) {
        header('location: auth/login.php');
    }
    if ($arr){
        $perk =level();
        if (is_array($arr)){
            if(!in_array($perk, $arr)){
                header('location: error/303.php');
            }
        }else{
            if(intval($arr) != $perk){
                header('location: error/303.php');
            }
        }
    }
}

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

function level($id = null) {
    /*
    level(1)
    */
	global $db;
	if($id){
        $stmt = $db->query("SELECT user_level from users where id = $id")->fetchColumn();
    }else{
        $id = $_SESSION['session_id'];
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

function delete($id, $table, $location='', $status = null){
    if($status){
        global $db;
        if ($id and $table) {
            $stmt = $db->prepare("DELETE FROM $table WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            if ($stmt->rowCount()) {
                header("location:$location");
            }else{
                header("location:../error/404.php");
            }
        }else{
            echo "Ошибка не указаны(id или таблица)!";
        }
    }else{
        if ($id and $table) {
            return "id=".$id."&table=".$table."&location=".$location;
        }else{
            return "Ошибка не указаны(id или таблица)!";
        }
    }
}

function prit($value) {
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}

function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

function clean_arr($array){
    foreach ($array as $key => $value) {
        $array[$key] = clean($value);
    };
    return $array;
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
	$title = "Clinics";
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
