<?php

class __Make
{
    private $argument;

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
        $file = dirname(__DIR__)."/Template/$this->argument";
        if (file_exists($file)) {
            if ($this->name) {
                $template = str_replace("_ModelIndex_", $this->UC_word($this->name), file_get_contents($file));
                $template = str_replace("_TableIndex_", $this->name, $template);
                $this->create_file($template);
            } else echo "\033[33m". " Укажите имя для шаблона!\n";
        } else echo "\033[33m". " Шаблона '$this->argument' не существует!\n";
    }

    private function create_file($code = "")
    {
        $name = $this->UC_word($this->name);
        $file_name = "model/$name.php";
        if (!file_exists($file_name)) {
            $fp = fopen($file_name, "x");
            fwrite($fp, $code);
            fclose($fp);
            echo "\033[32m"." Шаблон '$this->argument' успешно создан.\n";
        }else echo "\033[33m"." Шаблон \"$this->argument\" с наименованием '$name' уже существует.\n";
        return 1;
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