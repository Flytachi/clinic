<?php

class __Make
{
    private $argument;
    private $name;

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
        try {
            if ($this->argument == "model") $this->mModel();
            elseif($this->argument == "table") $this->mTable();
            else echo "\033[33m". " Шаблона '$this->argument' не существует!\n";
        } catch (\Error $e) {
            // echo $e->getMessage();
           echo "\033[31m"." Ошибка в скрипте.\n";
        }
        
    }

    private function mModel(){
        $file = dirname(__DIR__) . "/Template/$this->argument";
        if ($this->name) {
            $template = str_replace("_ModelIndex_", $this->UC_word($this->name), file_get_contents($file));
            $template = str_replace("_TableIndex_", strtolower($this->name), $template);
            $this->create_file('model', $template);
        } else echo "\033[33m". " Укажите имя для шаблона!\n";
    }

    private function mTable(){
        $file = dirname(__DIR__) . "/Template/$this->argument";
        if ($this->name) {
            $template = str_replace("_TableIndex_", $this->UC_word($this->name), file_get_contents($file));
            $this->create_file('api/table', $template);
        } else echo "\033[33m". " Укажите имя для шаблона!\n";
    }

    private function create_file($path, $code = "")
    {
        if (!is_dir($path)) mkdir($path);
        $name = $this->UC_word($this->name);
        $file_name = "$path/$name.php";
        if (!file_exists($file_name)) {
            $fp = fopen($file_name, "x");
            fwrite($fp, $code);
            fclose($fp);
            echo "\033[32m"." Шаблон '$this->argument' успешно создан.\n";
        }else echo "\033[33m"." Шаблон \"$this->argument\" с наименованием '$name' уже существует.\n";
    }

    private function UC_word(String $str)
    {
        return str_replace(" ", "", ucwords(str_replace("_", " ", $str)));
    }

    private function help()
    {
        echo "\033[33m"." Help in create.\n";
    }

}

?>