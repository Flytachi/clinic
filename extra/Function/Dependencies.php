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
            try { 
                if( !class_exists($model) ) include $path;
            }
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

function debugPanel() {

    if(isset(ini['GLOBAL_SETTING']['DEBUG']) and ini['GLOBAL_SETTING']['DEBUG']) {
        global $session;
        echo "<style>" , file_get_contents( dirname(__DIR__) . '/Resource/css/debug.css' ) , "</style>";
        include dirname(__DIR__) . '/Resource/debug.php';
        echo "<script type=\"text/javascript\">" , file_get_contents( dirname(__DIR__) . '/Resource/js/debug.js' ) , "</script>";
    
        echo "<div id=\"warframe_debug-bar\">";
        $timeFinish = microtime(true); 
        $delta=round($timeFinish-$_SERVER['REQUEST_TIME'], 3); if ($delta < 0.001) $delta = 0.001;
        ?>
        <div class="navbar-collapse collapse ml-1" id="navbar-footer" style="background-color:black;">
                <span class="navbar-text text-white">
                    <b>Memory:</b> <?= round(memory_get_usage()/1024/1024, 2) ?> mb / 
                    <b>Time:</b> <?= $delta ?> sec 
                </span>
    
                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item navbar-nav-link" style="color: #ff0000;"><em><?= $session->browser ?? "None" ?></em></li>
                    <li class="nav-item navbar-nav-link text-white"><b>Level: </b><?= $session->session_level ?? "None" ?></li>
                    <li class="nav-item navbar-nav-link text-white"><b>Division: </b><?= $session->session_division ?? "None" ?></li>
                </ul>
            </div>
        <?php
        dd($_SERVER);
        echo "</div>";
    }

}

?>