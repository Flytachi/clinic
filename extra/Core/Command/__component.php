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
        foreach (glob(dirname(__DIR__)."/$this->path/*") as $folder) {
            $create_folder = dirname(__DIR__, 3)."/".mb_strtolower(substr(basename($folder), 10, -2));
            $this->create_dir($create_folder);
            foreach (glob($folder."/*") as $file) $this->create_file("$create_folder/".mb_strtolower(substr(basename($file), 2, -2)).".php", file_get_contents($file));
        }

    }

    private function create_dir(String $path)
    {
        if (!file_exists($path)) mkdir($path);
    }

    private function create_file(String $path, String $code)
    {
        if (!file_exists($path)) {
            $fp = fopen($path, "w");
            fwrite($fp, $code);
            fclose($fp);
        }
    }

    private function help()
    {
        echo "\033[33m"." =======> Help <======= \n";
        echo "\033[33m"."  :init   -  создать папку для хранений персональный даных (файлы).\n";
        echo "\033[33m"." =======> Help <======= \n";
    }

}

?>