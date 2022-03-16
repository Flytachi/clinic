<?php

try {

    if(!class_exists('Mixin\Hell')) dieConection("Класс 'Mixin\Hell' не найден!");
    if(!class_exists('Mixin\HellCrud')) dieConection("Класс 'Mixin\HellCrud' не найден!");
    //
    include 'Include/Interface.php';
    include 'Include/Trait.php';
    include 'Include/Model.php';

} catch (\Throwable $th) {
    dieConection($th); 
}

?>