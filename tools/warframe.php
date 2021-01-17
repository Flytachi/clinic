<?php
session_start();
require_once 'functions/connection.php';

// Settings debugger

if ($ini['GLOBAL_SETTING']['DEBUG']) {

    define('ROOT_DIR', "/".basename(dirname(__DIR__)));
    define('DIR', ROOT_DIR);

    // if ("/".$_SERVER['HTTP_HOST'] == ROOT_DIR or $_SERVER['HTTP_HOST'] == $ini['SOCKET']['HOST']) {
        // define('DIR', "");
    // }else {
        // define('DIR', ROOT_DIR);
    // }s

}else {
    if (condition) {
        # code...
    }
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
    11 => "Анестезиолог"
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

function write_exel($value='')
{
    // Redirect output to a client’s web browser (Excel5)
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=demo.xls");
    header('Cache-Control: max-age=0');

    // PHPExcel
    require_once 'PHPExcel/Classes/PHPExcel.php';
    require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set Orientation, size and scaling
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

    // Generate spreadsheet
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
?>
