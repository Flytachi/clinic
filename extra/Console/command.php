<?php

use Mixin\Hell;
use Mixin\HellCrud;
use Mixin\HellTable;

require_once 'make.php';

/**
 * CMD
 **/
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
        if ($this->argument == "storage") {
            $this->create_storage();
        }elseif ($this->argument == "dump") {
            $this->create_dump();
        }else {

            try {

                $Class_construct = "__".ucfirst($this->argument);
                new $Class_construct($this->name);
    
            } catch (\Error $e) {
                echo "\033[31m"." Не такого аргумента.\n";
            }
            
        }
    }

    public function create_storage()
    {
        require_once dirname(__DIR__, 2).'/tools/variables.php';
        if (exec("mkdir storage && echo 1")) echo "\033[32m"." => Директория storage создана.\n";
        // storage
        if ( isset($storage) ) {
            foreach ($storage as $folder) {
                if (exec("mkdir storage/$folder && echo 1")) echo "\033[32m"." => Директория storage/$folder создана.\n";
            }
        }

        if (exec("chmod -R 777 storage && echo 1")) echo "\033[32m"." Права на запись установлены.\n";
        return 1;
    }

    public function create_dump()
    {
        $result = exec("mkdir dump && chmod 777 dump && echo 1");
        if ($result) echo "\033[32m"." Директория dump создана.\n";
        return 1;
    }

    public function help()
    {
        echo "\033[33m"." Help in create.\n";
    }

}

class __Key
{
    private $argument;
    private $name;
    private $key = ".key";
    private $auth = "master_key_ITACHI:2021-06-30";

    function __construct($value = null, $seria = null)
    {
        $this->argument = $value;
        $this->seria = $seria;
        $this->handle();
    }

    public function handle()
    {
        if (!is_null($this->argument) and !is_null($this->seria)) {
            $this->resolution();
        }else {
            echo "---ERROR---";
        }
    }

    private function resolution()
    {
        if (hex2bin("$this->argument") === $this->auth) {
            $this->generate_key();
        }else {
            echo "---ERROR---";
        }
    }

    public function generate_key()
    {
        $KEY = dirname(__DIR__, 2)."/$this->key";
        $fp = fopen($KEY, "w");
        fwrite($fp, bin2hex(zlib_encode($this->seria, ZLIB_ENCODING_DEFLATE)));
        fclose($fp);
        echo "---DONE---";
        return 1;
    }

}

class __Cfg
{
    private $argument;
    private $name;
    private $setting_name = "setting.ini";
    private $cfg_name = ".cfg";
    private $default_configuratuons = array(
        'MASTER_IPS' => array(
            ""
        ),
        'SECURITY' => array(
            'SERIA' => null,
        ),
        'GLOBAL_SETTING' => array(
            'DRIVER' => 'mysql', 
            'CHARSET' => 'utf8', 
            'TIME_ZONE' => 'Asia/Samarkand', 

            'SESSION_TIMEOUT' => null, 
            'SESSION_LIFE' => null,

            'ENGINEERING_WORKS' => false, 
            'HIDE_EXTENSION' => false, 
            'ROOT_MOD' => false, 
            'DEBUG' => false, 
        ), 
        'DATABASE' => array(
            'HOST' => 'localhost',
            'NAME' => null,  
            'USER' => null,
            'PASS' => null, 
        ), 
        'SOCKET' => array(
            'PORT' => 8080, 
            'HOST' => null,
        ), 
    );


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
        if ($this->argument == "setting") {
            $this->create_setting();
        }elseif ($this->argument == "gen") {
            $this->generate_key();
        }elseif ($this->argument == "edit") {
            $this->edit_key();
        }elseif ($this->argument == "show") {
            $this->setting_show();
        }else {
            echo "\033[31m"." Не такого аргумента.\n";
        }
    }

    public function create_setting()
    {
        require_once dirname(__DIR__).'/Credo/__load__.php';

        if (!file_exists(dirname(__DIR__, 2)."/$this->setting_name")) {
            $fp = fopen(dirname(__DIR__, 2)."/$this->setting_name", "x");
            fwrite($fp, Hell::array_to_ini($this->default_configuratuons));
            echo "\033[32m". " $this->setting_name сгенирирован успешно!\n";
            return fclose($fp);
        }
        echo "\033[33m". " $this->setting_name уже существует!\n";
        return 0;
    }

    public function edit_key()
    {
        require_once dirname(__DIR__).'/Credo/__load__.php';
        
        if (file_exists(dirname(__DIR__, 2)."/$this->cfg_name")) {
            $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 2)."/$this->cfg_name") );
            $code = json_decode(zlib_decode(hex2bin($cfg)), true);

            $fp = fopen(dirname(__DIR__, 2)."/$this->setting_name", "x");
            fwrite($fp, Hell::array_to_ini($code));
            fclose($fp);
            unlink(dirname(__DIR__, 2)."/$this->cfg_name");
            echo "\033[32m". " $this->setting_name сгенирирован успешно!\n";
            return 1;
        }
        echo "\033[33m". " $this->cfg_name не существует!\n";
        return 0;
    }

    public function setting_show()
    {
        require_once dirname(__DIR__).'/Credo/__load__.php';

        if (file_exists(dirname(__DIR__, 2)."/$this->cfg_name")) {
            $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 2)."/$this->cfg_name") );
            $code = json_decode(zlib_decode(hex2bin($cfg)), true);
            print_r(Hell::array_to_ini($code));
            return 1;
        }
        echo "\033[33m". " $this->cfg_name не существует!\n";
        return 0;
    }

    public function generate_key()
    {
        $FILE_setting_ini = dirname(__DIR__, 2)."/$this->setting_name";
        if (file_exists($FILE_setting_ini)) {
            $sett = parse_ini_file($FILE_setting_ini, true);
            if (!file_exists(dirname(__DIR__, 2)."/$this->cfg_name")) {
                $fp = fopen(dirname(__DIR__, 2)."/$this->cfg_name", "x");
                fwrite($fp, chunk_split( bin2hex(zlib_encode(json_encode($sett), ZLIB_ENCODING_DEFLATE)) , 50, "\n") );
                fclose($fp);
                if (unlink($FILE_setting_ini)) {
                    echo "\033[32m". " $this->cfg_name сгенирирован успешно!\n";
                }else {
                    unlink(dirname(__DIR__, 2)."/$this->cfg_name");
                    echo "\033[31m"."Ошибка при генерации.\n";
                }
                return 1;
            }
            echo "\033[33m". " $this->cfg_name уже существует!\n";
            return 0;
        }else {
            echo "\033[33m". " $this->setting_name не найден!\n";
            return 0;
        }
    }

    public function help()
    {
        echo "\033[33m"." Help in create.\n";
    }

}

class __Session
{
    private $argument;
    private $name;
    private $path = "sessions";

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
        if ($this->argument == "create") {
            $result = exec("mkdir $this->path && chmod 777 $this->path && echo 1");
            if ($result) echo "\033[32m"." Директория sessions создана.\n";
            return 1;
        }elseif($this->argument == "flush") {
            $path = dirname(__DIR__,2)."/$this->path";
            foreach (array_diff(scandir($path), array('..', '.')) as $file) {
                unlink("$path/$file");
            }

            require_once dirname(__DIR__).'/functions/connection.php';
            $life_session = $ini['GLOBAL_SETTING']['SESSION_LIFE'] + 5;
            $stmt = $db->prepare("DELETE FROM sessions WHERE last_update + INTERVAL $life_session MINUTE < CURRENT_TIMESTAMP()");
            $stmt->execute();
            echo "\033[32m"." Сессии успешно очищены.\n";

        }else{
            echo "\033[31m"." Не такого аргумента.\n";
        }
    }

    public function help()
    {
        echo "\033[33m"." Help in install.\n";
    }

}

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

            if ($this->argument == "generate") {
                $this->generate();
            }elseif($this->argument == "migrate") {
                $this->migrate();
            }elseif($this->argument == "compare"){
                $this->compare();
            }elseif($this->argument == "clean") {
                $this->clean();
            }elseif($this->argument == "delete") {
                $this->delete();
            }elseif($this->argument == "seed") {
                $this->seed();
            }else{
                echo "\033[31m"." Нет такого аргумента.\n";
            }

        } catch (\Error $e) {
            echo "\033[31m"." Ошибка.\n". $e;
        }

    }

    public function delete()
    {
        global $db, $ini; 
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__).'/Credo/__load__.php';
        
        $_delete = HellTable::T_DELETE_database();
        if ($_delete == 200) {
            echo "\033[32m"." База данных успешно удалена.\n";
            return 1;
        }
    }

    public function clean()
    {
        global $db, $ini; 
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__).'/Credo/__load__.php';
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

    public function migrate()
    {
        global $db, $ini; 
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__).'/Credo/__load__.php';

        try {
            foreach (json_decode(file_get_contents(dirname(__DIR__, 2)."/$this->path_base/Index_Tables.$this->format"), 1) as $table) {
                $db->exec($table);
            }
            echo "\033[32m"." -- Таблицы успешно мигрированы.\n";
            //
            // foreach (json_decode(file_get_contents(dirname(__DIR__, 2)."/$this->path_base/Triggers.$this->format"), 1) as $trigger) {
            //     $db->exec("DROP TRIGGER IF EXISTS {$trigger['Trigger']}; DELIMITER $ CREATE TRIGGER {$trigger['Trigger']} {$trigger['Timing']} {$trigger['Event']} ON {$trigger['Table']} FOR EACH ROW {$trigger['Statement']} $ DELIMITER ;");
            // }
            // echo "\033[32m"." -- Триггеры успешно мигрированы.\n";

            $this->clean();
            echo "\033[32m"." Миграция прошла успешно.\n";
            return 1;
        } catch (\Exception $e) {
            echo "\033[31m"." Во время миграции произошла ошибка.\n";
        }
    }

    public function generate()
    {
        global $db, $ini;
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__, 2).'/tools/variables.php';
        $tables = $triggers = [];
        //
        // foreach ($db->query("SHOW TRIGGERS") as $trig) $triggers[] = $trig;
        // $this->create_file(json_encode($triggers, JSON_PRETTY_PRINT), "Triggers");
        // echo "\033[32m"." Генерация триггеров прошла успешно.\n";
        // 
        foreach ($db->query("SHOW TABLES") as $table) $tables[] = $db->query("SHOW CREATE TABLE `{$table['Tables_in_'.$ini['DATABASE']['NAME']]}`")->fetch()['Create Table'];
        $this->create_file(json_encode($tables, JSON_PRETTY_PRINT), "Index_Tables");
        echo "\033[32m"." Генерация таблиц и индексов прошла успешно.\n";

    }

    public function create_file($code, $file_name)
    {
        $file = fopen("$this->path_base/$file_name.$this->format", "w");
        fwrite($file, $code);
    }

    public function seed()
    {
        global $db; 
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__).'/functions/tag.php';
        require_once dirname(__DIR__).'/Credo/__load__.php';

        if (isset($this->file_name)) {

            $data = json_decode(file_get_contents(dirname(__DIR__, 2)."/$this->path_data/$this->file_name.$this->format"), true);
            foreach ($data as $row) {
                HellCrud::insert($this->file_name, $row);
            }

        }else{

            foreach (glob(dirname(__DIR__, 2)."/$this->path_data/*.$this->format") as $file_name) {
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

    public function compare()
    {
        global $db, $ini;
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__, 2).'/tools/variables.php';

        $self_base=$migrate_base=[];
        foreach ($db->query("SHOW TABLES") as $table) $self_base[] = $db->query("SHOW CREATE TABLE `{$table['Tables_in_'.$ini['DATABASE']['NAME']]}`")->fetch()['Create Table'];
        $migrate_base[] = json_decode(file_get_contents(dirname(__DIR__, 2)."/$this->path_base/Index_Tables.$this->format"), 1);

        // if ($diff = array_diff($self_base, $migrate_base)) {
        //     print_r($diff);
        // }
    }

    public function help()
    {
        echo "\033[33m"." Help in create.\n";
    }

}

class __Install
{
    private $argument;
    private $name;
    private $path = "libs";

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

            if ($this->argument == "npm") {
                echo exec("npm install");
            }elseif($this->argument == "git") {
                require_once dirname(__DIR__, 2).'/tools/variables.php';
                foreach ($git_links as $link => $folder) {
                    echo exec("git clone $link $this->path/$folder");
                }
            }

        } catch (\Error $e) {
            echo "\033[31m"." Не такого аргумента.\n";
        }

    }

    public function help()
    {
        echo "\033[33m"." Help in install.\n";
    }

}

class __Dump
{
    private $argument;
    private $name;
    private String $file_format = "sql";
    private String $path = "dump"; 

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

            if ($this->argument == "create") {
                $this->create();
            }elseif ($this->argument == "show") {
                $this->show();
            }elseif ($this->argument == "delete") {
                $this->delete();
            }elseif ($this->argument == "migrate") {
                $this->migrate();
            }else{
                echo "\033[31m"." Нет такого аргумента.\n";
            }

        } catch (\Error $e) {
            echo "\033[31m"." Не такого аргумента.\n";
        }

    }

    public function create()
    {
        global $ini;
        require_once dirname(__DIR__).'/functions/connection.php';
        $path = dirname(__DIR__, 2)."/".$this->path;
        $file_name = ($this->name) ? $this->name : date("Y-m-d_H-i-s");
        exec("mysqldump -u {$ini['DATABASE']['USER']} -p{$ini['DATABASE']['PASS']} {$ini['DATABASE']['NAME']} > $path/$file_name.$this->file_format");
        echo "\033[32m"." Дамп успешно создан.\n";
        return 1;
    }

    public function delete()
    {
        if ($this->name) {
            $path = dirname(__DIR__, 2)."/".$this->path;
            unlink("$path/$this->name.$this->file_format");
            echo "\033[32m"." Дамп успешно удалён.\n";
        }else {
            echo "\033[33m"." Введите название удаляемого дампа.\n";
        }
        return 1;
    }

    public function migrate()
    {
        global $ini;
        if ($this->name) {
            require_once dirname(__DIR__).'/functions/connection.php';
            $path = dirname(__DIR__, 2)."/".$this->path;
            $file_name = ($this->name) ? $this->name : date("Y-m-d_H-i-s");
            exec("mysql -u {$ini['DATABASE']['USER']} -p{$ini['DATABASE']['PASS']} {$ini['DATABASE']['NAME']} < $path/$file_name.$this->file_format");
            echo "\033[32m"." Миграция дампа прошлаа успешно.\n";
        }else {
            echo "\033[33m"." Введите название файла дампа.\n";
        }
        return 1;
    }

    public function show()
    {
        $path = dirname(__DIR__, 2)."/".$this->path;
        $scanned_files = array_diff(scandir($path), array('..', '.'));
        foreach ($scanned_files as $file) {
            print_r(pathinfo($file, PATHINFO_FILENAME)."\n");
        }
        return 1;
    }

    public function help()
    {
        echo "\033[33m"." Help in create.\n";
    }

}

class __Serve
{

    function __construct($value = null, $name = null)
    {
        $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 2)."/.cfg") );
        $ini = json_decode(zlib_decode(hex2bin($cfg)), true);
        echo "\033[32m"." Сокет сервер успешно запущен.\n";
        
        require 'socket.php';
    }

}

?>
