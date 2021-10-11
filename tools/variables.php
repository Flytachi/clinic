<?php

// Varitables

// Директории для хранения файлов 
$storage = array(
    'avatars',
    'documents',
    'images'
);

// Ссылки на git ресурсы
$git_links = array(
    "https://github.com/PHPOffice/PHPExcel.git" => "PHPExcel",
    "https://github.com/t0k4rt/phpqrcode.git" => "QRcode",
);

// Настроки для миграции базы даных
$MUL = array(
    'beds' => '`building_id` (`building_id`,`floor`,`ward_id`,`bed`)' ,
    'wards' => '`building_id` (`building_id`,`floor`,`ward`)',
    'international_classification_diseases' => '`code` (`code`)',
);

?>