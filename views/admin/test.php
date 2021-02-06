<?php
require_once '../../tools/warframe.php';
header("Content-Disposition:attachment;filename='simple.xls'");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
//
// exit();
?>
