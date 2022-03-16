<?php

use Mixin\HellCrud;
use Mixin\HellTable;

class __Db
{
    private $argument;
    private $name;
    private String $path_base = "tools/base";
    private String $path_data = "tools/data";
    private String $path_hell = "/Src/Hell/__load__.php";
    private String $path_connection = "/Src/Connection/__load__.php";
    private String $format = "json";


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
            if ($this->argument == "generate") $this->generate();
            elseif($this->argument == "migrate") $this->migrate();
            elseif($this->argument == "compare") $this->compare();
            elseif($this->argument == "clean") $this->clean();
            elseif($this->argument == "delete") $this->delete();
            elseif($this->argument == "seed") $this->seed();
            else echo "\033[31m"." Нет такого аргумента.\n";
        } catch (\Error $e) {
            // echo $e->getMessage();
            echo "\033[31m"." Ошибка в скрипте.\n";
        }
    }

    private function generate()
    {
        require dirname(__DIR__, 2) . $this->path_connection;
        $ini = cfgGet();
        $db = (new Connect($ini['DATABASE']))->connection($ini['GLOBAL_SETTING']['DEBUG']);
        $tables = [];
        //
        foreach ($db->query("SHOW TABLES") as $table) {
            $t = $db->query("SHOW CREATE TABLE `{$table['Tables_in_'.$ini['DATABASE']['NAME']]}`")->fetch()['Create Table'];
            $t = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $t);
            $t = str_replace( stristr(strstr($t, 'AUTO_INCREMENT='), ' ', true), '', $t);
            $t = str_replace('  ', ' ', $t);
            $tables[] = $t;
        }
        $this->create_file(json_encode($tables, JSON_PRETTY_PRINT));
        echo "\033[32m"." Генерация таблиц и индексов прошла успешно.\n";

    }

    private function migrate()
    {
        require dirname(__DIR__, 2) . $this->path_connection;
        $ini = cfgGet();
        $db = (new Connect($ini['DATABASE']))->connection($ini['GLOBAL_SETTING']['DEBUG']);

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
        } catch (\Exception $e) {
            echo "\033[31m"." Во время миграции произошла ошибка.\n";
        }
    }

    private function create_file($code)
    {
        $file = fopen("$this->path_base/Index_Tables.$this->format", "w");
        fwrite($file, $code);
    }

    private function clean()
    {
        require dirname(__DIR__, 2) . $this->path_connection;
        $ini = cfgGet();
        $db = (new Connect($ini['DATABASE']))->connection($ini['GLOBAL_SETTING']['DEBUG']);

        if (isset($this->name)) {
            $db->exec("TRUNCATE TABLE $this->name;");
            echo "\033[32m"." Таблица '$this->name' успешно очищена.\n";
        }else {
            foreach ($db->query("SHOW TABlES") as $table) {
                $db->exec("TRUNCATE TABLE " . $table['Tables_in_'.$ini['DATABASE']['NAME']] . ";");
            }
            echo "\033[32m"." База данных успешно очищена.\n";
        }
       
    }

    private function delete()
    {
        require dirname(__DIR__, 2) . $this->path_connection;
        $ini = cfgGet();
        $db = (new Connect($ini['DATABASE']))->connection($ini['GLOBAL_SETTING']['DEBUG']);

        foreach ($db->query("SHOW TABlES") as $table) {
            $db->exec("DROP TABLE ". $table['Tables_in_'.$ini['DATABASE']['NAME']]);
        }
        echo "\033[32m"." База данных успешно удалена.\n";
    }

    private function seed()
    {
        global $db;
        require dirname(__DIR__, 2) . $this->path_hell;
        require dirname(__DIR__, 2) . $this->path_connection;
        $ini = cfgGet();
        $db = (new Connect($ini['DATABASE']))->connection($ini['GLOBAL_SETTING']['DEBUG']);

        if (isset($this->name)) {

            if(!file_exists(dirname(__DIR__, 3)."/$this->path_data/$this->name.$this->format")){
                echo "\033[31m"." Ошибка не найдены данные.\n";
                return 0;
            }

            $data = json_decode(file_get_contents(dirname(__DIR__, 3)."/$this->path_data/$this->name.$this->format"), true);
            foreach ($data as $row) HellCrud::insert($this->name, $row);

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
    }

    private function compare()
    {
        require dirname(__DIR__, 2) . $this->path_connection;
        $ini = cfgGet();
        $db = (new Connect($ini['DATABASE']))->connection($ini['GLOBAL_SETTING']['DEBUG']);
        $self_base=[];
        foreach ($db->query("SHOW TABLES") as $table) {
            $t = $db->query("SHOW CREATE TABLE `{$table['Tables_in_'.$ini['DATABASE']['NAME']]}`")->fetch()['Create Table'];
            $t = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $t);
            $t = str_replace( stristr(strstr($t, 'AUTO_INCREMENT='), ' ', true), '', $t);
            $t = str_replace('  ', ' ', $t);
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