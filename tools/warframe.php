<?php
session_start();
require_once 'functions/connection.php';

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

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
    12 => "Физиотерапевт",
    13 => "Процедурная медсестра",
    14 => "Массажист",
    32 => "Касса-Регистратура",
);

$FLOOR = array(
    1 => "1 этаж",
    2 => "2 этаж",
    3 => "3 этаж",
);

$CATEGORY = array(
    2 => "Лекарства",
    3 => "Расходные материалы",
    4 => "Наркотические вещества",
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
require_once 'functions/base.php';
require_once 'functions/model.php';

foreach (ModelDir($_SERVER['DOCUMENT_ROOT'].DIR."/tools/models") as $filename) {
    require_once 'models/'.$filename;
}

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

function level($id = null) {
    /*
    level()
    */
    global $db;
    if ($_SESSION['session_id'] == "master") {
        return "master";
    }
    if(empty($id)){
        $id = $_SESSION['session_id'];
    }
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

function write_excel($table, $file_name = "docs", $table_label=null)
{
    global $db;
    include 'PHPExcel/Classes/PHPExcel.php';

    if ($table_label) {
        foreach ($table_label as $key => $value) {
            $labels[] = $value;
        }
        $sql_select = implode(array_keys($table_label), ", ");
    }else {
        $table_q = $db->query("DESCRIBE $table")->fetchAll();
        foreach ($table_q as $key => $value) {
            $labels[] = $value['Field'];
        }
        $sql_select = implode($labels, ", ");
    }

    $excel_column = array(
        0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D',
        4 => 'E', 5 => 'F', 6 => 'G', 7 => 'H',
        8 => 'I', 9 => 'J', 10 => 'K', 11 => 'L',
        12 => 'M', 13 => 'N', 14 => 'O', 15 => 'P',
        16 => 'Q', 17 => 'R', 18 => 'S', 19 => 'T',
        20 => 'U', 21 => 'V', 22 => 'W', 23 => 'X',
        24 => 'Y', 25 => 'Z');

    //Создание объекта класса библиотеки
    $objPHPExcel = new PHPExcel();

    //Указываем страницу, с которой работаем
    $objPHPExcel->setActiveSheetIndex(0);

    //Получаем страницу, с которой будем работать
    $active_sheet = $objPHPExcel->getActiveSheet();

    //Создание новой страницы(пример)
    //$objPHPExcel->createSheet();

    //Ориентация и размер страницы
    // $active_sheet->getPageSetup()
       // ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    $active_sheet->getPageSetup()
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $active_sheet->getPageSetup()
       ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

    //Имя страницы
    $active_sheet->setTitle("Данные ".showTitle());
    $active_sheet->getRowDimension("1")->setRowHeight(25);

    //Ширина стобцов
    foreach ($labels as $key => $value) {
        $erch = "{$excel_column[$key]}1";
        $active_sheet->getColumnDimension($excel_column[$key])->setWidth(20);
        $active_sheet->setCellValue($erch, $value);
        $active_sheet->getStyle($erch)->getFont()->setBold(true);

        if (in_array($value, ['Услуга', 'Препарат'])) {
            $active_sheet->getColumnDimension($excel_column[$key])->setWidth(70);
        } else {
            $active_sheet->getColumnDimensionByColumn($excel_column[$key])->setAutoSize(true);
        }
        $active_sheet->getStyle($erch)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $active_sheet->getStyle($erch)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $active_sheet->getStyle($erch)->applyFromArray(array(
        	'borders'=>array(
        		'allborders' => array(
        			'style' => PHPExcel_Style_Border::BORDER_THIN,
        			'color' => array('rgb' => '000000')
    		      )
             )
        ));
        $active_sheet->getStyle($erch)->applyFromArray(array(
        	'fill' => array(
        		'type' => PHPExcel_Style_Fill::FILL_SOLID,
        		'color' => array('rgb' => 'EEEE11')
        	)
        ));
    }

    if ($table == "service") {
        $sql = "SELECT $sql_select FROM $table WHERE type != 101";
    }else {
        $sql = "SELECT $sql_select FROM $table";
    }

    foreach ($db->query($sql) as $key => $row) {
        $kt = $key+2;
        foreach ($labels as $key_st => $value) {
            $erch = "{$excel_column[$key_st]}$kt";
            // echo "$erch => ".$row[array_keys($row)[$key_st]]."<br>";
            $active_sheet->setCellValue($erch, $row[array_keys($row)[$key_st]]);
            $active_sheet->getStyle($erch)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $active_sheet->getStyle($erch)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $active_sheet->getStyle($erch)->applyFromArray(array(
            	'borders'=>array(
            		'allborders' => array(
            			'style' => PHPExcel_Style_Border::BORDER_THIN,
            			'color' => array('rgb' => '000000')
        		      )
                 )
            ));
        }
    }
    //Вставка данных из выборки

    //Отправляем заголовки с типом контекста и именем файла
    header("Content-Type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=$file_name.xlsx");

    //Сохраняем файл с помощью PHPExcel_IOFactory и указываем тип Excel
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    //Отправляем файл
    $objWriter->save('php://output');
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
