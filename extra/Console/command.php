<?php
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
        if ($result) {
            echo "\033[32m"." Директория dump создана.\n";
        }
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

            'SESSION_GC_DIVISOR' => 100, 
            'SESSION_GC_PROBABILITY' => 0, 
            'SESSION_TIMEOUT' => null, 
            'SESSION_LIFE' => null, 
            'SESSION_COOKIE_LIFETIME' => null, 

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
        require_once dirname(__DIR__).'/functions/mixin.php';

        if (!file_exists(dirname(__DIR__, 2)."/$this->setting_name")) {
            $fp = fopen(dirname(__DIR__, 2)."/$this->setting_name", "x");
            fwrite($fp, Mixin\array_to_ini($this->default_configuratuons));
            echo "\033[32m". " $this->setting_name сгенирирован успешно!\n";
            return fclose($fp);
        }
        echo "\033[33m". " $this->setting_name уже существует!\n";
        return 0;
    }

    public function edit_key()
    {
        require_once dirname(__DIR__).'/functions/mixin.php';
        
        if (file_exists(dirname(__DIR__, 2)."/$this->cfg_name")) {
            $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 2)."/$this->cfg_name") );
            $code = json_decode(zlib_decode(hex2bin($cfg)), true);

            $fp = fopen(dirname(__DIR__, 2)."/$this->setting_name", "x");
            fwrite($fp, Mixin\array_to_ini($code));
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
        require_once dirname(__DIR__).'/functions/mixin.php';

        if (file_exists(dirname(__DIR__, 2)."/$this->cfg_name")) {
            $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 2)."/$this->cfg_name") );
            $code = json_decode(zlib_decode(hex2bin($cfg)), true);
            print_r(Mixin\array_to_ini($code));
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

class __Db
{
    private $argument;
    private String $path = "tools/db"; 
    private String $path_seed = "tools/ci"; 
    private String $format = "json"; 
    private String $file_name = "database";
    private String $DB_HEADER = "CREATE TABLE IF NOT EXISTS";
    private String $DB_FOOTER = " ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";


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
            }elseif($this->argument == "clean") {
                $this->clean_table = ($this->file_name == "database") ? null : $this->file_name;
                $this->clean();
            }elseif($this->argument == "delete") {
                $this->delete();
            }elseif($this->argument == "seed") {
                $this->seed_table = ($this->file_name == "database") ? null : $this->file_name;
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
        require_once dirname(__DIR__).'/functions/mixin.php';
        
        $_delete = Mixin\T_DELETE_database();
        if ($_delete == 200) {
            echo "\033[32m"." База данных успешно удалена.\n";
            return 1;
        }
    }

    public function clean()
    {
        global $db, $ini; 
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__).'/functions/mixin.php';
        if (!$this->clean_table) {
            $_clean = Mixin\T_FLUSH_database();
            if ($_clean == 200) {
                echo "\033[32m"." База данных успешно очищена.\n";
                return 1;
            }
        }else {
            $_clean = Mixin\T_flush($this->clean_table);
            echo "\033[32m"." Таблица '$this->clean_table' успешно очищена.\n";
            return 1;
        }
       
    }

    public function migrate()
    {
        global $db, $ini; 
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__).'/functions/mixin.php';

        $file = file_get_contents(dirname(__DIR__, 2)."/$this->path/$this->file_name.$this->format");
        
        $data = json_decode($file, true);
        $_initialize = Mixin\T_INITIALIZE_database($data);
        if ($_initialize == 200) {
            echo "\033[32m"." Миграция прошла успешно.\n";
            return 1;
        }
    }

    public function generate()
    {
        global $db, $ini;
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__, 2).'/tools/variables.php';

        $json = array();
        $i = 0;

        foreach ($db->query("SHOW TABlES") as $table) {
            $i++;
            $sql = $this->DB_HEADER." `{$table['Tables_in_'.$ini['DATABASE']['NAME']]}` (";
            $column = "";
            $keys = "";

            foreach ($db->query("DESCRIBE {$table['Tables_in_'.$ini['DATABASE']['NAME']]}") as $col) {
                $column .= "`{$col['Field']}` {$col['Type']}";

                if ($col['Null'] == "YES") {
                    $column .= " DEFAULT";
                    if (is_null($col['Default'])) {
                        $column .= " NULL";
                    }else {
                        $column .= " ".$col['Default'];
                    }
                }else {
                    $column .= " NOT NULL";
                    if ($col['Default']) {
                        $column .= " DEFAULT ".$col['Default'];
                    }
                }

                if ($col['Extra']) {
                    $column .= " ".strtoupper($col['Extra']);
                }

                switch ($col['Key']) {
                    case "PRI":
                        $keys .= "PRIMARY KEY (`{$col['Field']}`)";
                        $keys .=",";
                        break;
                    case "UNI":
                        $keys .= "UNIQUE KEY `{$col['Field']}` (`{$col['Field']}`)";
                        $keys .=",";
                        break;
                    case "MUL":
                        if ( isset($MUL) ) {
                            $keys .= "UNIQUE KEY {$MUL[$table['Tables_in_'.$ini['DATABASE']['NAME']]]} USING BTREE";
                            $keys .=",";
                        }
                        break;
                }

                $column .= ",";
                unset($col);
            }
            $column_keys = substr($column.$keys,0,-1);

            $sql .= $column_keys.")";
            $sql .= $this->DB_FOOTER.";";
            $json[] = $sql;
            unset($column);
            unset($keys);

            echo "\033[32m"." Таблица {$table['Tables_in_'.$ini['DATABASE']['NAME']]}.\n";
        }

        return $this->create_file(json_encode($json), $i);
    }

    public function create_file($code = "", $qty)
    {
        $file = fopen("$this->path/$this->file_name.$this->format", "w");
        fwrite($file, $code);
        echo "\033[32m"." Генерация ($qty) таблиц прошла успешно!\n";
        return fclose($file);
    }

    public function seed()
    {
        global $db; 
        require_once dirname(__DIR__).'/functions/connection.php';
        require_once dirname(__DIR__).'/functions/tag.php';
        require_once dirname(__DIR__).'/functions/mixin.php';

        if (!$this->seed_table) {

            foreach (glob(dirname(__DIR__, 2)."/$this->path_seed/*.$this->format") as $file_name) {
                $table = pathinfo($file_name)['filename'];
                $data = json_decode(file_get_contents($file_name), true);
    
                $i = 0;
                foreach ($data as $row) {
                    $i++;
                    Mixin\insert($table, $row);
                }
                echo "\033[32m"." Таблица $table ($i).\n";
            }

        }else{

            $data = json_decode(file_get_contents(dirname(__DIR__, 2)."/$this->path_seed/$this->seed_table.$this->format"), true);
    
            foreach ($data as $row) {
                Mixin\insert($this->seed_table, $row);
            }

        }

        echo "\033[32m"." Данные успешно внесены.\n";
        return 1;
    }

    public function help()
    {
        echo "\033[33m"." Help in create.\n";
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
