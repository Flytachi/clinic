<?php

/* 
    My Functions
*/

function showTitle()
{
    return "Med24Line";
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

function patient_name($data){
    global $db;
    if (is_numeric($data)) {
        $stmt = $db->query("SELECT first_name, last_name, father_name FROM patients WHERE id = $data")->fetch(PDO::FETCH_OBJ);
        return ucwords($stmt->last_name." ".$stmt->first_name." ".$stmt->father_name);
    }elseif(is_array($data) or is_object($data)) {
        $data = (object) $data;
        return ucwords($data->last_name." ".$data->first_name." ".$data->father_name);
    }else {
        return "<span class=\"text-muted\">Нет даных</span>";
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


function module($value = null)
{
    global $db;
    $mark = "module_";
    try {
        if ($value) {
            $value = str_replace($mark, '', $value);
            return $db->query("SELECT const_value FROM company_constants WHERE const_label = '$mark$value'")->fetchColumn();
        } else {
            foreach ($db->query("SELECT * FROM company_constants WHERE const_label LIKE '$mark%'") as $row) {
                $modules[$row['const_label']] = $row['const_value'];
            }
            return $modules;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

}

function config($value = null, $group = null)
{
    global $db;
    $mark = "constant_";
    try {
        if ($value) {
            $value = str_replace($mark, '', $value);
            if ($group) {
                foreach ($db->query("SELECT * FROM company_constants WHERE const_label LIKE '$mark$value%'") as $row) {
                    $modules[$row['const_label']] = $row['const_value'];
                }
                return $modules;
            } else {
                return $db->query("SELECT const_value FROM company_constants WHERE const_label = '$mark$value'")->fetchColumn();
            }
            
        } else {
            foreach ($db->query("SELECT * FROM company_constants WHERE const_label LIKE '$mark%'") as $row) {
                $modules[$row['const_label']] = $row['const_value'];
            }
            return $modules;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

}

function is_config($value = null){
    if (!config($value)) {
        Mixin\error('404');
    }
}

function is_module($value = null){
    if (!module($value)) {
        Mixin\error('404');
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
    $comp = $db->query("SELECT * FROM company_constants WHERE const_label LIKE 'constant_zetta_pacs_%'")->fetchAll(PDO::FETCH_OBJ);
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

//---------

function apiMy( $url, $param ){
    if ($url) {
        return DIR."/api/$url".EXT."?url=$param";
    }
}

function global_render( $url=null ){
    if ($url) {
        header("location:".DIR."$url".EXT);
    }else {
        header("location:".$_SERVER['HTTP_REFERER']);
    }
    exit;
}


function index(){
    header("location:".DIR."/index".EXT);
    exit;
}


function viv($url=null){
    if ($url) {
        return DIR."/views/$url".EXT;
    }else {
        return DIR."/";
    }
}

function viv_link($url, $class = ""){

    if (is_array($url)) {
        
        foreach ($url as $value) {
            if (EXT == ".php") {
                if (viv($value) == $_SERVER['PHP_SELF']) {
                    return "active $class";
                }
            } else {
                if (viv($value).".php" == $_SERVER['PHP_SELF']) {
                    return "active $class";
                }
            }
        }

    } else {
        if (EXT == ".php") {
            if (viv($url) == $_SERVER['PHP_SELF']) {
                return "active $class";
            }
        } else {
            if (viv($url).".php" == $_SERVER['PHP_SELF']) {
                return "active $class";
            }
        }
    }
}


function ajax($url)
{
    return DIR."/ajax/$url".EXT;
}

function prints(String $url){
    return DIR . "/print/default-$url".EXT;
}

function add_url(){
    return DIR."/hook/create_to_update".EXT."?";
}

function del_url($id = null, $model = null, $arg = "?"){
    if($id) $arg .= "id=$id";
    if($model) $arg .= "&model=$model";
    return DIR."/hook/delete".EXT.$arg;
}

function up_url($id = null, $model, $form = 'form', $arg = "?"){
    if($id) $arg .= "id=$id";
    if($model) $arg .= "&model=$model";
    if($form) $arg .= "&form=$form";
    return DIR."/hook/get".EXT.$arg;
}

function download_url($model, $file_name, $is_null = false){
    return DIR."/hook/download".EXT."?model=$model&file=$file_name&is_null=$is_null";
}

?>