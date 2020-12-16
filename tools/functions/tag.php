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
        global $PROJECT_NAME;
        header("location:/views/$url.php");
    }else {
        header("location:".$_SERVER['HTTP_REFERER']);
    }
    exit;
}

function viv($url){
    global $PROJECT_NAME;
    return "/views/$url.php";
}

function stack($url){
    global $PROJECT_NAME;
    return "/static/$url";
}


function add_url(){
    global $PROJECT_NAME;
    return "/model/create_to_update.php?";
}

function del_url($id, $model){
    global $PROJECT_NAME;
    return "/model/delete.php?id=$id&model=$model";
}

function up_url($id, $model, $form=null){
    global $PROJECT_NAME;
    if ($form) {
        $result = "/model/get.php?id=$id&model=$model&form=$form";
    }else {
        $result = "/model/get.php?id=$id&model=$model";
    }
    return $result;
}

?>
