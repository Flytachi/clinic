<?php
require_once 'make.php';

/**
 * CMD
 */
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
        if ($this->argument == "setting") {
            $this->create_setting();
        }elseif ($this->argument == "storage") {
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

    public function gen_setting()
    {
        return <<<EOF
        [GLOBAL_SETTING]
        DRIVER = mysql
        CHARSET = utf8
        TIME_ZONE = Asia/Samarkand

        SESSION_GC_PROBABILITY = 0
        SESSION_GC_DIVISOR = 100
        SESSION_TIMEOUT = 
        SESSION_LIFE = 
        SESSION_COOKIE_LIFETIME = 

        ENGINEERING_WORKS = false
        HIDE_EXTENSION = false
        ROOT_MOD = false
        DEBUG = false


        [DATABASE]
        HOST = localhost
        NAME = 
        USER = 
        PASS = 

        [SOCKET]
        PORT = 8080
        HOST = 
        EOF;
    }

    public function create_setting()
    {
        $file_name = "setting.ini";
        if (!file_exists($file_name)) {
            $fp = fopen($file_name, "x");
            fwrite($fp, $this->gen_setting());
            echo "\033[32m". " $file_name сгенирирован успешно!\n";
            return fclose($fp);
        }
        echo "\033[33m". " $file_name уже существует!\n";
        return 0;
    }

    public function create_storage()
    {
        $result = exec("mkdir storage && chmod 777 storage && echo 1");
        if ($result) {
            echo "\033[32m"." Директория storage создана.\n";
        }
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

class __Install
{
    private $argument;
    private $name;
    private $git_links = array(
        "https://github.com/PHPOffice/PHPExcel.git" => "libs/PHPExcel",
        "https://github.com/t0k4rt/phpqrcode.git" => "libs/QRcode",
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

        try {

            if ($this->argument == "npm") {
                echo exec("npm install");
            }elseif($this->argument == "git") {
                foreach ($this->git_links as $link => $path) {
                    echo exec("git clone $link $path");
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
    private String $path = "tools/Data/database"; 
    private String $path_seed = "tools/Data/ci"; 
    private String $format = "json"; 
    private String $file_name = "database";
    private String $DB_HEADER = "CREATE TABLE IF NOT EXISTS";
    private String $DB_FOOTER = " ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    private Array $MUL = array('beds' => '`building_id` (`building_id`,`floor`,`ward_id`,`bed`)' ,'wards' => '`building_id` (`building_id`,`floor`,`ward`)'); // array('beds' => 'bed' ,'wards' => 'floor');

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
            echo "\033[32m"." База данных '$this->clean_table' успешно очищена.\n";
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

        $json = array();

        foreach ($db->query("SHOW TABlES") as $table) {

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
                        $keys.=",";
                        break;

                    case "MUL":
                        // $keys .= "UNIQUE KEY `{$MUL[$table['Tables_in_clinic']]}` (`{$col['Field']}`,`{$MUL[$table['Tables_in_clinic']]}`) USING BTREE";
                        $keys .= "UNIQUE KEY {$this->MUL[$table['Tables_in_'.$ini['DATABASE']['NAME']]]} USING BTREE";
                        $keys.=",";
                        break;
                }

                $column.=",";
                unset($col);
            }
            $column_keys = substr($column.$keys,0,-1);

            $sql .= $column_keys.")";
            $sql .= $this->DB_FOOTER.";";
            $json[] = $sql;
            unset($column);
            unset($keys);
        }

        return $this->create_file(json_encode($json));
    }

    public function create_file($code = "")
    {
        $file = fopen("$this->path/$this->file_name.$this->format", "w");
        fwrite($file, $code);
        echo "\033[32m"." Генерация прошла успешно!\n";
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
    
                foreach ($data as $row) {
                    Mixin\insert($table, $row);
                }
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
        global $ini;
        echo "\033[32m"." Сокет сервер успешно запущен.\n";
        
        require 'socket.php';

    }

}

?>
