<?php

function layout($url){
    return $_SERVER['DOCUMENT_ROOT'] . DIR . "/views/layout/$url.php";
}

function render($url=null){
    if ($url) {
        header("location:" . DIR . "/views/$url" . EXT);
    }else header("location:" . $_SERVER['HTTP_REFERER']);
}

function api(String $url, Array $param){
    $str = "?";
    foreach ($param as $key => $value) $str .= "$key=$value&";
    $param = substr($str,0,-1);
    return DIR . "/api/$url" . EXT. $param;
}

function stack(String $url){
    return DIR . "/static/$url";
}

function node(String $url){
    return DIR . "/node_modules/$url";
}

function prints(String $url){
    return DIR . "/print/default-$url".EXT;
}

?>