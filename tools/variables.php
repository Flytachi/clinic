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
    'beds' => '`branch_id` (`branch_id`,`building_id`,`floor`,`ward_id`,`bed`)' ,
    'services' => '`branch_id` (`branch_id`,`code`)',
    'wards' => '`branch_id` (`branch_id`,`building_id`,`floor`,`ward`)',
);

?>