<?php

/* 
    My Functions
*/

use Mixin\Hell;

function is_config($value = null){
    if (!config($value)) Hell::error('404');
}

function is_module($value = null){
    if (!module($value)) Hell::error('404');
}

function showTitle()
{
    return "Med24Line";
}

function get_full_name($obj = null) {
    global $db, $session;
    if (is_object($obj)) return ucwords($obj->last_name." ".$obj->first_name." ".$obj->father_name);
    if (is_array($obj)) return ucwords($obj['last_name']." ".$obj['first_name']." ".$obj['father_name']);
    else {
        if($obj){
            $stmt = $db->query("SELECT first_name, last_name, father_name FROM users WHERE id = $obj")->fetch(PDO::FETCH_OBJ);
            return ucwords($stmt->last_name." ".$stmt->first_name." ".$stmt->father_name);
        }else return $session->get_full_name();
    }
}

// Добавляет нули к числам, чьи значаения меньше пятизначных
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

function zeTTa_data()
{
    global $db, $session;
    $company = new stdClass();
    $data = new stdClass();
    $stmt = $db->query("SELECT pacs_login, pacs_password from users where id = $session->session_id")->fetch(PDO::FETCH_OBJ);
    $comp = $db->query("SELECT * FROM corp_constants WHERE const_label LIKE 'constant_zetta_pacs_%'")->fetchAll(PDO::FETCH_OBJ);
    foreach ($comp as $value) {
        $company->{$value->const_label} = $value->const_value;
    }
    $data->IP = ( isset($company->constant_zetta_pacs_IP) ) ? $company->constant_zetta_pacs_IP : '';
    $data->LID = $stmt->pacs_login;
    $data->LPW = $stmt->pacs_password;
    $data->LICD = ( isset($company->constant_zetta_pacs_LICD) ) ? $company->constant_zetta_pacs_LICD : '';
    $data->VTYPE = ( isset($company->constant_zetta_pacs_VTYPE) ) ? $company->constant_zetta_pacs_VTYPE : '';
    return $data;
}

// Divisions
function division(Int $id = null) {
    global $db, $session;
    if (!$id) {
        return $session->get_division();
    } else {
        $pk = (Int) $db->query("SELECT division_id FROM users WHERE id = $id")->fetchColumn();
        try{
            $stmt = $db->query("SELECT id FROM divisions WHERE id = $pk")->fetchColumn();
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
        $stmt = $db->query("SELECT name FROM divisions WHERE id =".(int) division($id))->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
    return $stmt;
}

function division_title($id = null) {
    global $db;
    try{
        $stmt = $db->query("SELECT title FROM divisions WHERE id =".(int) division($id))->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
    return $stmt;
}

function division_assist($id = null) {
    global $db;
    try{
        $stmt = $db->query("SELECT assist FROM divisions WHERE id =".(int) division($id))->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
    return $stmt;
}
// END Divisions

function icd($pk = null, $title = 'code,decryption')
{
    global $db;
    if ($pk) {
        $stmt = $db->query("SELECT $title FROM international_classification_diseases WHERE id = $pk")->fetch();
    }else{
        $stmt = null;
    }
    return $stmt;
}

function client_name($obj = null) {
    global $db;
    if (is_object($obj)) return ucwords($obj->last_name." ".$obj->first_name." ".$obj->father_name);
    if (is_array($obj)) return ucwords($obj['last_name']." ".$obj['first_name']." ".$obj['father_name']);
    else {
        $stmt = $db->query("SELECT first_name, last_name, father_name FROM clients WHERE id = $obj")->fetch(PDO::FETCH_OBJ);
        return ucwords($stmt->last_name." ".$stmt->first_name." ".$stmt->father_name);
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

function array_multisort_value(){
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row) {
                $tmp[$key] = $row[$field];
            }
            $args[$n] = $tmp;
        }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
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

// GET vs URL 
function url_to_array(string $url)
{
    $code = explode('?', $url);
    $result = array('url' => $code[0], 'get' => []);
    foreach (explode('&', $code[1]) as $param) {
        if ($param) {
            $value = explode('=', $param);
            $result['get'][$value[0]] = $value[1];
        }
    }
    return $result;
}

function array_to_url(array $get)
{
    $str = "?";
    foreach ($get as $key => $value) $str .= "$key=$value&";
    return substr($str,0,-1);
}
//

function is_message(){
    if( isset($_SESSION['message']) ){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}
?>