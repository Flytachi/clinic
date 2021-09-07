<?php

function read_excel($filepath){
    ini_set('error_reporting', 0);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    require_once "PHPExcel/Classes/PHPExcel.php"; //подключаем наш фреймворк

    $ar=array(); // инициализируем массив
    $inputFileType = PHPExcel_IOFactory::identify($filepath); // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
    $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
    $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
    $ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
    return $ar; //возвращаем массив
}

function write_excel($table, $file_name = "docs", $table_label=null, $is_null = false)
{
    global $db;
    ini_set('error_reporting', 0);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    include 'PHPExcel/Classes/PHPExcel.php'; //подключаем наш фреймворк

    if ($is_null) {
        unset($table_label['id']);
    }

    if ($table_label) {
        foreach ($table_label as $key => $value) {
            $labels[] = $value;
        }
        $sql_select = implode(", ", array_keys($table_label));
    }else {
        $table_q = $db->query("DESCRIBE $table")->fetchAll();
        foreach ($table_q as $key => $value) {
            $labels[] = $value['Field'];
        }
        $sql_select = implode(", ", $labels);
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

    if (!$is_null) {

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

    }

    //Отправляем заголовки с типом контекста и именем файла
    header("Content-Type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=$file_name.xlsx");

    //Сохраняем файл с помощью PHPExcel_IOFactory и указываем тип Excel
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    //Отправляем файл
    $objWriter->save('php://output');
}

?>