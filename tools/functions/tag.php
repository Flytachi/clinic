<?php

function get_dir_contents($dir, $filter = '', &$results = array()) {
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value); 

        if(!is_dir($path)) {
            if(empty($filter) || preg_match($filter, $path)) $results[] = $path;
        } elseif($value != "." && $value != "..") {
            get_dir_contents($path, $filter, $results);
        }
    }

    return $results;
} 

function parad($title, $value) {
    echo "<strong>$title</strong>";
    echo "<pre style=\"background-color: black; color: #00ff00; border-style: solid; border-color: #ff0000; border-width: medium;\">";
    print_r($value);
    echo "</pre>";
}

function dd($value) {
    echo "<pre style=\"background-color: black; color: #00ff00; border-style: solid; border-color: #ff0000; border-width: medium;\">";
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

function index(){
    header("location:".DIR."/index".EXT);
    exit;
}

function layout($url){
    return $_SERVER['DOCUMENT_ROOT'].DIR."/views/layout/$url.php";
}

function viv($url=null){
    if ($url) {
        return DIR."/views/$url".EXT;
    }else {
        return DIR."/";
    }
}

function viv_link($url, $class = ""){

    if (is_array($url)) {
        
        foreach ($url as $value) {
            if (EXT == ".php") {
                if (viv($value) == $_SERVER['PHP_SELF']) {
                    return "active $class";
                }
            } else {
                if (viv($value).".php" == $_SERVER['PHP_SELF']) {
                    return "active $class";
                }
            }
        }

    } else {
        if (EXT == ".php") {
            if (viv($url) == $_SERVER['PHP_SELF']) {
                return "active $class";
            }
        } else {
            if (viv($url).".php" == $_SERVER['PHP_SELF']) {
                return "active $class";
            }
        }
    }
}

function img($url){
    return DIR."/views/$url";
}

function stack($url){
    return DIR."/static/$url";
}

function node($url){
    return DIR."/node_modules/$url";
}

function ajax($url)
{
    return DIR."/ajax/$url".EXT;
}


function add_url(){
    return DIR."/hook/create_to_update".EXT."?";
}

function del_url($id = null, $model = null){
    return DIR."/hook/delete".EXT."?id=$id&model=$model";
}

function up_url($id = null, $model, $form=null){
    if ($form) {
        $result = DIR."/hook/get".EXT."?id=$id&model=$model&form=$form";
    }else {
        $result = DIR."/hook/get".EXT."?id=$id&model=$model";
    }
    return $result;
}

function download_url($model, $file_name, $is_null = false){
    return DIR."/hook/download".EXT."?model=$model&file=$file_name&is_null=$is_null";
}
?>
