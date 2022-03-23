<?php

try {

    if(!class_exists('Mixin\Hell')) dieConnection("Класс 'Mixin\Hell' не найден!");
    if(!class_exists('Mixin\HellCrud')) dieConnection("Класс 'Mixin\HellCrud' не найден!");
    //
    include 'Include/Session.php';

} catch (\Throwable $th) {
    dieConnection($th);
}

?>