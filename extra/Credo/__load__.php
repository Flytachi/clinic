<?php

function GDC($dir, $filter = '', &$results = array()) {
    $files = scandir($dir);
    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value); 
        if(!is_dir($path)) {
            if(empty($filter) || preg_match($filter, $path)) $results[] = $path;
        } elseif($value != "." && $value != "..") get_dir_contents($path, $filter, $results);
    }
    return $results;
}

foreach (GDC(dirname(__FILE__)."/App/") as $filename) include $filename;
foreach (GDC(dirname(__FILE__)."/Interface/") as $filename) include $filename;
foreach (GDC(dirname(__FILE__)."/Trait/") as $filename) include $filename;
foreach (GDC(dirname(__FILE__)."/Class/") as $filename) include $filename;

?>