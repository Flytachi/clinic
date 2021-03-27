<?php
require_once 'model.php';

/**
 * CMD
 */
class __Create
{
    private $argument;
    private $name;

    function __construct($value = null, $name = null)
    {
        $this->argument = $value;
        $this->name = $name;
        $this->handle();
    }

    public function handle()
    {
        if (!is_null($this->argument)) {
            $this->resolution();
        }else {
            $this->help();
        }
    }

    private function resolution()
    {

        try {

            if ($this->name) {
                $Class_construct = "__".ucfirst($this->argument);
                $cmd = new $Class_construct($this->name);
                if ($cmd->create()) {
                    echo "\033[32m". "Модель успешно создана.\n";
                }else {
                    echo "\033[31m"."Ошибка при создании модели.\n";
                }
            }else {
                echo "\033[33m"." Введите название модели.\n";
            }

        } catch (\Error $e) {
            echo "\033[31m"."Не такого аргумента.\n";
        }

    }

    public function help()
    {
        echo "\033[33m"."Help in create.\n";
    }

}


?>
