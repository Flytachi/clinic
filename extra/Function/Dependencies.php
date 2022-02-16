<?php

function dieConection($_error = null) {
    die(include dirname(__DIR__) . "/Resource/error.php"); 
}

function dd($value = null) {
    echo "<pre style=\"background-color: black; color: #00ff00; border-style: solid; border-color: #ff0000; border-width: medium;\">";
    print_r($value);
    echo "</pre>";
}

function parad($title = null, $value = null) {
    echo "<pre style=\"background-color: black; color: #00ff00; border-style: solid; border-color: #ff0000; border-width: medium;\">";
    echo "<strong style=\"color: #ffffff;\">$title</strong><br>";
    print_r($value);
    echo "</pre>";
}

function getDirContent($dir, $filter = '', &$results = array()) {
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value); 

        if(!is_dir($path)) {
            if(empty($filter) || preg_match($filter, $path)) $results[] = $path;
        } elseif($value != "." && $value != "..") {
            getDirContent($path, $filter, $results);
        }
    }

    return $results;
}

function importModel(String $modelName){
    foreach (getDirContent(dirname(__DIR__, 2)."/model/") as $model) {
        if ( basename($model) == $modelName . ".php" ) {
            try { include $model; } 
            catch (\Throwable $th) { dd($th); exit; }
        }
    }
}

?>