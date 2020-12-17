<?php

function parad($title, $value) {
    echo "<strong>$title</strong>";
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}

function prit($value) {
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}


function render($url=null){
    if ($url) {
        header("location:".DIR."/views/$url.php");
    }else {
        header("location:".$_SERVER['HTTP_REFERER']);
    }
    exit;
}

function viv($url){
    return DIR."/views/$url.php";
}

function stack($url){
    return DIR."/static/$url";
}


function add_url(){
    return DIR."/model/create_to_update.php?";
}

function del_url($id, $model){
    return DIR."/model/delete.php?id=$id&model=$model";
}

function up_url($id, $model, $form=null){
    if ($form) {
        $result = DIR."/model/get.php?id=$id&model=$model&form=$form";
    }else {
        $result = DIR."/model/get.php?id=$id&model=$model";
    }
    return $result;
}

?>
