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
        header("location:".DIR."/views/$url".EXT);
    }else {
        header("location:".$_SERVER['HTTP_REFERER']);
    }
    exit;
}

function layout($url){
    return $_SERVER['DOCUMENT_ROOT'].DIR."/views/layout/$url.php";
}

function viv($url){
    return DIR."/views/$url".EXT;
}

function img($url){
    return DIR."/views/$url";
}

function stack($url){
    return DIR."/static/$url";
}

function ajax($url)
{
    return DIR."/ajax/$url";
}


function add_url(){
    return DIR."/model/create_to_update".EXT."?";
}

function del_url($id, $model){
    return DIR."/model/delete".EXT."?id=$id&model=$model";
}

function up_url($id, $model, $form=null){
    if ($form) {
        $result = DIR."/model/get".EXT."?id=$id&model=$model&form=$form";
    }else {
        $result = DIR."/model/get".EXT."?id=$id&model=$model";
    }
    return $result;
}
?>
