<?php
session_start();
require_once 'functions/connection.php';

// Settings debugger

if ($ini['GLOBAL_SETTING']['DEBUG']) {

    define('ROOT_DIR', "/".basename(dirname(__DIR__)));

    if ("/".$_SERVER['HTTP_HOST'] == ROOT_DIR or $_SERVER['HTTP_HOST'] == $ini['SOCKET']['HOST']) {
        define('DIR', "");
    }else {
        define('DIR', ROOT_DIR);
    }

}else {
    define('DIR', "");
}

// END Settings debugger


// File extension

if ($ini['GLOBAL_SETTING']['HIDE_EXTENSION']) {

    define('EXT', "");

}else {

    define('EXT', ".php");

}

// END File extension


$PERSONAL = array(
    1 => "Администратор",
    2 => "Регистратура",
    3 => "Кассир",
    4 => "Аптекарь",
    5 => "Врач",
    6 => "Лаборатория",
    7 => "Медсестра",
    8 => "Главный врач",
    9 => "Повар",
    10 => "Диагностика",
    11 => "Анестезиолог",
    12 => "Физиотерапевт"
);

$FLOOR = array(
    1 => "1 этаж",
    2 => "2 этаж",
    3 => "3 этаж",
);

$methods = array(
    1 => "Через рот",
    2 => "Внутримышечный (в/м)",
    3 => "Подкожный (п/к)",
    4 => "Внутривенный (в/в)",
    5 => "Внутривенный капельный (в/в кап)",
    6 => "Ректальный",
    7 => "Вагинальный",
    8 => "Ингаляционный",
    9 => "Поверхностное натирание",
);

// Browser
if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $_SESSION['browser'] = "Firefox";
elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $_SESSION['browser'] = "Opera";
elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $_SESSION['browser'] = "Chrome";
elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $_SESSION['browser'] = "Internet Explorer";
elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false) $_SESSION['browser'] = "Safari";
else $_SESSION['browser'] = "Неизвестный";


require_once 'functions/auth.php';
require_once 'functions/tag.php';
require_once 'models.php';
require_once 'forms.php';
require_once 'forms_2.php';


function get_full_name($id = null) {
    global $db;
    if($id){
        $stmt = $db->query("SELECT first_name, last_name, father_name from users where id = $id")->fetch(PDO::FETCH_OBJ);
    }else{
        if ($_SESSION['session_id'] == "master") {
            return "Master";
        }
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
        if ($_SESSION['session_id'] == "master") {
            return "Master";
        }
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
    if ($_SESSION['session_id'] == "master") {
        return "master";
    }
    $id = $_SESSION['session_id'];
    $stmt = $db->query("SELECT user_level from users where id = $id")->fetchColumn();
	return intval($stmt);
}

function level_name($id = null) {
    /*
    level_name(1)
    */
    global $db, $PERSONAL;
    if(empty($id)){
        if ($_SESSION['session_id'] == "master") {
            return "";
        }
        $id = $_SESSION['session_id'];
    }
    $stmt = $db->query("SELECT user_level from users where id = $id")->fetchColumn();
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

function division($id = null) {
    global $db, $PERSONAL;
    if(empty($id)){
        if ($_SESSION['session_id'] == "master") {
            return "";
        }
        $id = $_SESSION['session_id'];
    }
    $id = $db->query("SELECT division_id from users where id = $id")->fetchColumn();
    try{
        $stmt = $db->query("SELECT id from division where id = $id")->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
	return $stmt;
}


function division_name($id = null) {
    global $db, $PERSONAL;
    if(empty($id)){
        if ($_SESSION['session_id'] == "master") {
            return "";
        }
        $id = $_SESSION['session_id'];
    }
    $id = $db->query("SELECT division_id from users where id = $id")->fetchColumn();
    try{
        $stmt = $db->query("SELECT name from division where id = $id")->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
	return $stmt;
}

function division_title($id = null) {
    global $db, $PERSONAL;
    if(empty($id)){
        if ($_SESSION['session_id'] == "master") {
            return "";
        }
        $id = $_SESSION['session_id'];
    }
    $id = $db->query("SELECT division_id from users where id = $id")->fetchColumn();
    try{
        $stmt = $db->query("SELECT title from division where id = $id")->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
	return $stmt;
}

function division_assist($id = null) {
    global $db, $PERSONAL;
    if(empty($id)){
        $id = $_SESSION['session_id'];
    }
    $id = $db->query("SELECT division_id from users where id = $id")->fetchColumn();
    try{
        $stmt = $db->query("SELECT assist from division where id = $id")->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
	return $stmt;
}

function read_excel($filepath){
    require_once "PHPExcel/Classes/PHPExcel.php"; //подключаем наш фреймворк

    $ar=array(); // инициализируем массив
    $inputFileType = PHPExcel_IOFactory::identify($filepath); // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
    $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
    $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
    $ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
    return $ar; //возвращаем массив
}

function read_labaratory($filepath){
    require_once "PHPExcel/Classes/PHPExcel.php"; //подключаем наш фреймворк

    $ar=array(); // инициализируем массив
    $inputFileType = PHPExcel_IOFactory::identify($filepath); // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
    $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
    $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект

    foreach($objPHPExcel->getWorksheetIterator() as $worksheet){
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

        for($row=2; $row<=$highestRow; $row++){
            $column1 = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
            $column2 = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $column3 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $column4 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $column5 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $column6 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

            // $finaldata[] = array(
            //     'code'   =>  trim($column1),
            //     'name'   =>  trim($column2),
            //     'result' =>  trim($column5),
            // );

            if ($column1 and $column2 and $column5) {
                $finaldata[] = array(
                    'type'   =>  "result",
                    'code'   =>  trim($column1),
                    'name'   =>  trim($column2),
                    'result' =>  trim($column5),
                );
            }elseif (trim($column1) == "№ :") {
                $finaldata[] = array(
                    'type'      =>  "label",
                    'label_lab' =>  trim($column2),
                );
            }
        }
    }

    // $ar = $objPHPExcel->getSheet()->toArray(); // выгружаем данные из объекта в массив
    return $finaldata; //возвращаем массив

}

function pagination_page($count, $elem)
{
    echo "<div class=\"card card-body text-center\">";
        echo "<ul class=\"pagination align-self-center\">";


    if(intval($_GET['of']) == 0){
        $_GET['of'] = 1;
    }

    for ($i= intval($_GET['of']) - 1; $i < intval($_GET['of']) and $i >= (intval($_GET['of']) - $elem) and  $i != 0 ; $i--) { 

        $mas[] = $i;
    }

    $mas = array_reverse($mas);

    // echo $mas[0];

    if($mas[0] != 1 and isset($mas)){
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=0' class='page-link' legitRipple>1</a></li>";
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".(floor($mas[0] / 2) ) ."' class='page-link' legitRipple>...</a></li>";
    }


    foreach ($mas as $key) {
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".($key - 1)."' class='page-link' legitRipple>$key</a></li>";
    }

    echo "<li class=\"page-item\"><a href=\"". $_SERVER['PHP_SELF'] ."?of=". ($_GET['of'] - 1) ."\" class=\"page-link legitRipple\">". intval($_GET['of']) ."</a></li>";



        for ($i= (intval($_GET['of'])+1) ; $i <= (intval($_GET['of'])+$elem) and $i <= $count; $i++) { 

        $mas1[] = $i;
    }


    foreach ($mas1 as $key) {

        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".($key - 1)."' class='page-link' legitRipple>$key</a></li>";
    }

    if( end($mas1) != $count and isset($mas1)){
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".(floor((end($mas1)  + $count) / 2 )) ."' class='page-link' legitRipple>...</a></li>";
        echo "<li class=page-item><a href='". $_SERVER['PHP_SELF'] ."?of=".($count - 1)."' class='page-link' legitRipple>$count</a></li>";
    }
        
        echo "</ul>";
    echo "</div>";
}

?>
