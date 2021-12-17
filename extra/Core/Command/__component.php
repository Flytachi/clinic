<?php

class __Component
{
    private $argument;
    private $path = "Components";

    function __construct($value = null, $name = null)
    {
        $this->argument = $value;
        $this->name = $name;
        $this->handle();
    }

    private function handle()
    {
        if (!is_null($this->argument)) $this->resolution();
        else $this->help();
    }

    private function resolution()
    {
        if ($this->argument == "init") $this->init();
        else echo "\033[31m"." Не такого аргумента.\n";
    }

    private function init()
    {
        $this->init_components();        
    }

    private function init_components()
    {
        $this->change_dir(dirname(__DIR__)."/$this->path");
    }

    private function change_dir(String $path, String $c_path = null)
    {
        foreach (glob("$path/*") as $item) {
            if (is_dir($item)) {
                $c = ($c_path) ? basename($c_path)."/" : "";
                $create_folder = dirname(__DIR__, 3)."/$c".mb_strtolower(substr(basename($item), 10, -2));
                $this->create_dir($create_folder);
                $this->change_dir($item, $create_folder);
            }else {
                $extention = ( $temp = mb_strtolower(strstr(basename($item), '_', true)) ) ? ".$temp" : "";
                $name = mb_strtolower(substr(strstr(basename($item), '_'), 2, -2));
                if ($c_path) $this->create_file("$c_path/$name$extention", file_get_contents($item));
                else $this->create_file(dirname(__DIR__, 3)."/$name$extention", file_get_contents($item));
            }
        }
    }

    private function create_dir(String $path)
    {
        if (!file_exists($path)) mkdir($path);
        // echo "$path\n";
    }

    private function create_file(String $path, String $code)
    {
        if (!file_exists($path)) {
            $fp = fopen($path, "w");
            fwrite($fp, $code);
            fclose($fp);
        }
        // echo "    $path\n";
    }

    private function help()
    {
        echo "\033[33m"." =======> Help <======= \n";
        echo "\033[33m"."  :init   -  Инициализация фреймфорка.\n";
        echo "\033[33m"." =======> Help <======= \n";
    }

}

?>