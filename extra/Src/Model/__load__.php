<?php

try {

    if(!class_exists('Mixin\Hell')) dieConnection("Класс 'Mixin\Hell' не найден!");
    if(!class_exists('Mixin\HellCrud')) dieConnection("Класс 'Mixin\HellCrud' не найден!");
    //
    include 'Include/Interface.php';
    include 'Include/Trait.php';
    include 'Include/Model.php';

} catch (\Throwable $th) {
    dieConnection($th);
}

?>