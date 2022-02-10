<?php

use Mixin\HellCrud;
use Mixin\HellTable;

class __Db
{
    private $argument;
    private String $path_base = "tools/base"; 
    private String $path_data = "tools/data"; 
    private String $format = "json";


    function __construct($value = null, $name = null)
    {
        $this->argument = $value;
        if ($name) $this->file_name = $name;
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
            if ($this->argument == "generate") $this->generate();
            elseif($this->argument == "migrate") $this->migrate();
            elseif($this->argument == "compare") $this->compare();
            elseif($this->argument == "clean") $this->clean();
            elseif($this->argument == "delete") $this->delete();
            elseif($this->argument == "seed") $this->seed();
            else echo "\033[31m"." Нет такого аргумента.\n";
        } catch (\Error $e) {
            echo "\033[31m"." Ошибка в скрипте.\n";
        }
    }

    private function generate()
    {
        global $db;
        require_once dirname(__DIR__, 2).'/Connection/__load__.php';
        require_once dirname(__DIR__, 3).'/tools/variables.php';
        new Connect;
        $tables = [];
        // 
        foreach ($db->query("SHOW TABLES") as $table) {
            $t = $db->query("SHOW CREATE TABLE `{$table['Tables_in_'.ini['DATABASE']['NAME']]}`")->fetch()['Create Table'];
            $t = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $t);
            $t = str_replace( stristr(substr(strstr($t, 'AUTO_INCREMENT='), 0, -1), ' ', true), "", $t);
            $tables[] = $t;
        }
        $this->create_file(json_encode($tables, JSON_PRETTY_PRINT), "Index_Tables");
        echo "\033[32m"." Генерация таблиц и индексов прошла успешно.\n";

    }

    private function migrate()
    {
        global $db; 
        require_once dirname(__DIR__, 2).'/Connection/__load__.php';
        require_once dirname(__DIR__, 2).'/Credo/__load__.php';
        new Connect($db);

        try {
            foreach (json_decode(file_get_contents(dirname(__DIR__, 3)."/$this->path_base/Index_Tables.$this->format"), 1) as $table) {
                $db->exec($table);
            }
            echo "\033[32m"." -- Таблицы успешно мигрированы.\n";
            //
            // foreach (json_decode(file_get_contents(dirname(__DIR__, 2)."/$this->path_base/Triggers.$this->format"), 1) as $trigger) {
            //     $db->exec("DROP TRIGGER IF EXISTS {$trigger['Trigger']}; DELIMITER $ CREATE TRIGGER {$trigger['Trigger']} {$trigger['Timing']} {$trigger['Event']} ON {$trigger['Table']} FOR EACH ROW {$trigger['Statement']} $ DELIMITER ;");
            // }
            // echo "\033[32m"." -- Триггеры успешно мигрированы.\n";
            
            echo "\033[32m"." Миграция прошла успешно.\n";
            return 1;
        } catch (\Exception $e) {
            echo "\033[31m"." Во время миграции произошла ошибка.\n";
        }
    }

    private function create_file($code, $file_name)
    {
        $file = fopen("$this->path_base/$file_name.$this->format", "w");
        fwrite($file, $code);
    }

    private function clean()
    {
        global $db;
        require_once dirname(__DIR__, 2).'/Connection/__load__.php';
        require_once dirname(__DIR__, 2).'/Credo/__load__.php';
        new Connect;
        if (isset($this->file_name)) {
            $_clean = HellTable::T_flush($this->file_name);
            echo "\033[32m"." Таблица '$this->file_name' успешно очищена.\n";
            return 1;
        }else {
            $_clean = HellTable::T_FLUSH_database();
            if ($_clean == 200) {
                echo "\033[32m"." База данных успешно очищена.\n";
                return 1;
            }
        }
       
    }

    private function delete()
    {
        global $db; 
        require_once dirname(__DIR__, 2).'/Connection/__load__.php';
        require_once dirname(__DIR__, 2).'/Credo/__load__.php';
        new Connect;
        $_delete = HellTable::T_DELETE_database();
        if ($_delete == 200) {
            echo "\033[32m"." База данных успешно удалена.\n";
            return 1;
        }
    }

    private function seed()
    {
        global $db; 
        require_once dirname(__DIR__, 2).'/Connection/__load__.php';
        require_once dirname(__DIR__, 2).'/Credo/__load__.php';
        new Connect;
        if (isset($this->file_name)) {

            if(!file_exists(dirname(__DIR__, 3)."/$this->path_data/$this->file_name.$this->format")){
                echo "\033[31m"." Ошибка не найдены данные.\n";
                return 0;
            }

            $data = json_decode(file_get_contents(dirname(__DIR__, 3)."/$this->path_data/$this->file_name.$this->format"), true);
            foreach ($data as $row) HellCrud::insert($this->file_name, $row);

        }else{

            foreach (glob(dirname(__DIR__, 3)."/$this->path_data/*.$this->format") as $file_name) {
                $table = pathinfo($file_name)['filename'];
                $data = json_decode(file_get_contents($file_name), true);
                $i = 0;
                foreach ($data as $row) {
                    $i++;
                    HellCrud::insert($table, $row);
                }
                echo "\033[32m"." Таблица $table ($i).\n";
            }

        }

        echo "\033[32m"." Данные успешно внесены.\n";
        return 1;
    }

    private function compare()
    {
        global $db;
        require_once dirname(__DIR__, 2).'/Connection/__load__.php';
        require_once dirname(__DIR__, 3).'/tools/variables.php';
        new Connect;
        $self_base=[];
        foreach ($db->query("SHOW TABLES") as $table) {
            $t = $db->query("SHOW CREATE TABLE `{$table['Tables_in_'.ini['DATABASE']['NAME']]}`")->fetch()['Create Table'];
            $t = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $t);
            $t = str_replace( stristr(substr(strstr($t, 'AUTO_INCREMENT='), 0, -1), ' ', true), "", $t);
            $self_base[] = $t;
        }
        
        $migrate_base = json_decode(file_get_contents(dirname(__DIR__, 3)."/$this->path_base/Index_Tables.$this->format"), 1);
        if ($diff = array_diff($self_base, $migrate_base)) print_r($diff);
    }

    private function help()
    {
        echo "\033[33m"." =======> Help <======= \n";
        echo "\033[33m"."  :generate -  сохранить образ базы данных.\n";
        echo "\033[33m"."  :migrate  -  миграция образа базы данных.\n";
        echo "\033[33m"."  :clean    -  очистить базу даных. (можно указать таблицу)\n";
        echo "\033[33m"."  :delete   -  удалить базу даных.\n";
        echo "\033[33m"."  :seed     -  внести данные в базу данных. (можно указать таблицу)\n";
        echo "\033[33m"."  :compare  -  сравнение базы даных и образа.\n";
        echo "\033[33m"." =======> Help <======= \n";
    }

}

?>