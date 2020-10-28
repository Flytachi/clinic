<?php
require_once 'connection.php';


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

function permission($arr){
    /*
    permission(1) or permission([1,2, ..])
    */
    $perk =level(1);
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

function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);    
    return $value;
}
?>