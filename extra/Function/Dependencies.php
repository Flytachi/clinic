<?php

function dieConnection($_error = null)
{
    die(include dirname(__DIR__) . "/Resource/error.php"); 
}

function dieConection($_error = null) {
    die(include dirname(__DIR__) . "/Resource/error.php");
}

function cfgGet(): array
{
    if (!file_exists(cfgPathClose)) dieConection("Configuration file not found.");
    return json_decode(zlib_decode(hex2bin( str_replace("\n", "", file_get_contents(cfgPathClose)) )), true);
}

function dd($value = null) {
    echo '<pre style="background-color: black; color: #00ff00; border-style: solid; border-color: #ff0000; border-width: medium;">';
    print_r($value);
    echo '</pre>';
}

function parad($title = null, $value = null) {
    echo '<pre style="background-color: black; color: #00ff00; border-style: solid; border-color: #ff0000; border-width: medium;">';
    echo "<strong style=\"color: #ffffff;\">$title</strong><br>";
    print_r($value);
    echo '</pre>';
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

function importModel(String ...$models){
    foreach ($models as $model) {
        $path = dirname(__DIR__, 2) .'/model/' . $model . '.php';
        if (file_exists($path)) {
            try { include $path; }
            catch (\Throwable $th) { 
                if (!ini['GLOBAL_SETTING']['DEBUG']) dd('Ошибка в модели');
                else dd($th);
                die;
            }
        } else {
            dd("Модель не найдена"); 
            die;
        }
    }
}

?>