<?php

function arrayToRequest(Array $param = null) {
    if ($param == null) return null;
    else {
        $str = "?";
        foreach ($param as $key => $value) $str .= "$key=$value&";
        return substr($str,0,-1);
    }
}

function layout(String $url) {
    return $_SERVER['DOCUMENT_ROOT'] . DIR . "/views/layout/$url.php";
}

function render(String $url = null, Array $param = null) {
    if ($url) header("location:" . DIR . "/views/$url" . EXT . arrayToRequest($param));
    else header("location:" . $_SERVER['HTTP_REFERER']);
}

function api(String $url, Array $param = null) {
    return DIR . "/api/$url" . EXT . arrayToRequest($param);
}

function stack(String $url) {
    return DIR . "/static/$url";
}

function node(String $url) {
    return DIR . "/node_modules/$url";
}

?>