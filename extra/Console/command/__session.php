<?php

class __Session
{
    private $argument;
    private $path = "sessions";

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
        if ($this->argument == "init") {
            $result = exec("mkdir $this->path && chmod 777 $this->path && echo 1");
            if ($result) echo "\033[32m"." Директория sessions создана.\n";
            return 1;
        }elseif($this->argument == "flush") {
            $path = dirname(__DIR__, 3)."/$this->path";
            foreach (array_diff(scandir($path), array('..', '.')) as $file) {
                unlink("$path/$file");
            }

            require_once dirname(__DIR__, 2).'/functions/connection.php';
            $life_session = $ini['GLOBAL_SETTING']['SESSION_LIFE'] + 5;
            $stmt = $db->prepare("DELETE FROM sessions WHERE last_update + INTERVAL $life_session MINUTE < CURRENT_TIMESTAMP()");
            $stmt->execute();
            echo "\033[32m"." Сессии успешно очищены.\n";

        }else echo "\033[31m"." Не такого аргумента.\n";
    }

    private function help()
    {
        echo "\033[33m"." =======> Help <======= \n";
        echo "\033[33m"."  :init     -  создать папку для хранений сессии.\n";
        echo "\033[33m"."  :flush    -  очистить сессии.\n";
        echo "\033[33m"." =======> Help <======= \n";
    }

}

?>