<?php

class __Seed
{
    protected String $name;
    private String $path = "tools/data"; 
    private String $path_connection = "/Src/Connection/__load__.php";
    private String $format = "json"; 
    private Array $json = array();

    function __construct(string $name = null)
    {
        // Cfg
        if (!file_exists(dirname(__DIR__, 3)."/.cfg")) dieConection("Configuration file not found.");
        $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 3)."/.cfg") );
        define("ini", json_decode(zlib_decode(hex2bin($cfg)), true));
        //

        if ($name) {
            $this->name = $name;
            if ($this->generate()) {
                echo "\033[32m". " Генерация прошла успешно.\n";
            }else {
                echo "\033[31m"." Ошибка при генерации.\n";
            }
        } else {
            echo "\033[33m"." Введите аргумент! (название таблицы)\n";
            return 0;
        }
        
    }

    private function generate()
    {
        global $db;
        require_once dirname(__DIR__, 2) . $this->path_connection;
        new Connect;
        if ($db->query("SHOW TABLES LIKE '$this->name';")->rowCount()) {
            foreach ($db->query("SELECT * FROM $this->name") as $value) {
                $this->json[] = $value;
            }
            return $this->create_file();
        } else {
            echo "\033[31m"." Таблица $this->name не найдена.\n";
            exit;
        }
    }

    private function create_file()
    {
        $file = fopen("$this->path/$this->name.$this->format", "w");
        fwrite($file, json_encode($this->json, JSON_PRETTY_PRINT));
        return fclose($file);
    }
}

?>