<?php
require_once '../../tools/warframe.php';

// $tab_lab = $db->query("DESCRIBE service")->fetchAll();
//
// $excel_column = array(
//     0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D',
//     4 => 'E', 5 => 'F', 6 => 'G', 7 => 'H',
//     8 => 'I', 9 => 'J', 10 => 'K', 11 => 'L',
//     12 => 'M', 13 => 'N', 14 => 'O', 15 => 'P',
//     16 => 'Q', 17 => 'R', 18 => 'S', 19 => 'T',
//     20 => 'U', 21 => 'V', 22 => 'W', 23 => 'X',
//     24 => 'Y', 25 => 'Z');
//
// prit(count($tab_lab));
// foreach ($tab_lab as $key => $value) {
//     prit($value['Field']);
// }



function write_excel()
{
    global $db;
    $tab_lab = $db->query("DESCRIBE service")->fetchAll();
    $excel_column = array(
        0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D',
        4 => 'E', 5 => 'F', 6 => 'G', 7 => 'H',
        8 => 'I', 9 => 'J', 10 => 'K', 11 => 'L',
        12 => 'M', 13 => 'N', 14 => 'O', 15 => 'P',
        16 => 'Q', 17 => 'R', 18 => 'S', 19 => 'T',
        20 => 'U', 21 => 'V', 22 => 'W', 23 => 'X',
        24 => 'Y', 25 => 'Z');

    include '../../tools/PHPExcel/Classes/PHPExcel.php';
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
    $active_sheet->setTitle("Данные из docs");

    //Ширина стобцов
    for ($i=0; $i < count($tab_lab); $i++) {
        $active_sheet->getColumnDimension($excel_column[$i])->setWidth(20);
    }
    // $active_sheet->getColumnDimension('B')->setWidth(10);
    // $active_sheet->getColumnDimension('C')->setWidth(90);


    //Вставить данные(примеры)
    //Нумерация строк начинается с 1, координаты A1 - 0,1
    // foreach ($variable as $key => $value) {
    //     $active_sheet->setCellValue('C3', 'info');
    // }
    foreach ($tab_lab as $key => $value) {
        // prit($value['Field']);
        $active_sheet->setCellValue($excel_column[$key].$key+1, $value['Field']);
    }


    //Вставка данных из выборки
    $start = 4;
    $i = 0;
    foreach($l as $row_l){
       $next = $start + $i;

       $active_sheet->setCellValueByColumnAndRow(0, $next, $row_l['id']);
       $active_sheet->setCellValueByColumnAndRow(1, $next, $row_l['name']);
       $active_sheet->setCellValueByColumnAndRow(2, $next, $row_l['info']);

       $i++;
    };

    //Отправляем заголовки с типом контекста и именем файла
    header("Content-Type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename='simple.xlsx'");

    //Сохраняем файл с помощью PHPExcel_IOFactory и указываем тип Excel
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    //Отправляем файл
    $objWriter->save('php://output');
}
//------------------------------------
write_excel();
?>
