<?php

class __Backup
{
    private $argument;
    private $name;
    private String $file_format = "sql";
    private String $path = "backup"; 

    function __construct($value = null, $name = null)
    {
        $this->argument = $value;
        $this->name = $name;
        $this->handle();
    }

    private function handle()
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
            if ($this->argument == "init") $this->init();
            elseif ($this->argument == "create") $this->create();
            elseif ($this->argument == "show") $this->show();
            elseif ($this->argument == "delete") $this->delete();
            elseif ($this->argument == "migrate") $this->migrate();
            else echo "\033[31m"." Нет такого аргумента.\n";
        } catch (\Error $e) {
            echo "\033[31m"." Не такого аргумента.\n";
        }
    }

    private function init()
    {
        $path = dirname(__DIR__, 3)."/".$this->path;
        if (!file_exists($path)) {
            if (exec("mkdir $this->path && chmod 777 $this->path && echo 1")) echo "\033[32m"." Директория для резервного копирования создана.\n";
        }else echo "\033[32m"." Директория для резервного копирования уже существует.\n";
    }

    public function is_dir()
    {
        if (file_exists(dirname(__DIR__, 3)."/".$this->path)) return true;
        else return false;
    }

    private function show()
    {
        if ($this->is_dir()) {
            $path = dirname(__DIR__, 3)."/".$this->path;
            $scanned_files = array_diff(scandir($path), array('..', '.'));
            foreach ($scanned_files as $file) {
                print_r(pathinfo($file, PATHINFO_FILENAME)."\n");
            }
            return 1;
        }else echo "\033[33m"." Директория для резервного копирования не существует.\n";
    }

    private function create()
    {
        global $ini;
        if ($this->is_dir()) {
            require_once dirname(__DIR__, 2).'/Connection/__load__.php';
            $path = dirname(__DIR__, 3)."/".$this->path;
            $file_name = ($this->name) ? $this->name : date("Y-m-d_H-i-s");
            exec("mysqldump -u {$ini['DATABASE']['USER']} -p{$ini['DATABASE']['PASS']} {$ini['DATABASE']['NAME']} > $path/$file_name.$this->file_format");
            echo "\033[32m"." Дамп успешно создан.\n";
            return 1;
        }else echo "\033[33m"." Директория для резервного копирования не существует.\n";
    }

    private function delete()
    {
        if ($this->is_dir()) {
            if ($this->name) {
                $path = dirname(__DIR__, 3)."/".$this->path;
                unlink("$path/$this->name.$this->file_format");
                echo "\033[32m"." Дамп успешно удалён.\n";
            }else echo "\033[33m"." Введите название удаляемого дампа.\n";
            return 1;
        }else echo "\033[33m"." Директория для резервного копирования не существует.\n";
    }

    private function migrate()
    {
        global $ini;
        if ($this->is_dir()) {
            if ($this->name) {
                require_once dirname(__DIR__, 2).'/Connection/__load__.php';
                $path = dirname(__DIR__, 3)."/".$this->path;
                $file_name = ($this->name) ? $this->name : date("Y-m-d_H-i-s");
                exec("mysql -u {$ini['DATABASE']['USER']} -p{$ini['DATABASE']['PASS']} {$ini['DATABASE']['NAME']} < $path/$file_name.$this->file_format");
                echo "\033[32m"." Миграция дампа прошлаа успешно.\n";
            }else echo "\033[33m"." Введите название файла дампа.\n";
            return 1;
        }else echo "\033[33m"." Директория для резервного копирования не существует.\n";
    }

    private function help()
    {
        echo "\033[33m"." =======> Help <======= \n";
        echo "\033[33m"."  :init     -  создать директорию резервного копирования.\n";
        echo "\033[33m"."  :show     -  просмотр резервных копий.\n";
        echo "\033[33m"."  :create   -  создать резервную копию.\n";
        echo "\033[33m"."  :delete   -  удалить резервную копию (указать резервную копию).\n";
        echo "\033[33m"."  :migrate  -  востановить резервную копию (указать резервную копию).\n";
        echo "\033[33m"." =======> Help <======= \n";
    }

}

?>