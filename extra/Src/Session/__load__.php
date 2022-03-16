<?php

try {

    if(!class_exists('Mixin\Hell')) dieConection("Класс 'Mixin\Hell' не найден!");
    if(!class_exists('Mixin\HellCrud')) dieConection("Класс 'Mixin\HellCrud' не найден!");
    //
    include 'Include/Session.php';

} catch (\Throwable $th) {
    dieConection($th); 
}

?>