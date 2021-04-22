<?php
require_once 'model.php';

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

                if ($this->name) {
                    $Class_construct = "__".ucfirst($this->argument);
                    $cmd = new $Class_construct($this->name);
                    if ($cmd->create()) {
                        echo "\033[32m". " Модель успешно создана.\n";
                    }else {
                        echo "\033[31m"." Ошибка при создании модели.\n";
                    }
                }else {
                    echo "\033[33m"." Введите название модели.\n";
                }
    
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
        SESSION_LIFE = 

        HIDE_EXTENSION = false
        ROOT_MOD = false
        DEBUG = true


        [DATABASE]
        HOST = localhost
        NAME = 
        USER = 
        PASS = 
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
            echo "\033[33m"." Директория storage создана.\n";
        }
        return 1;
    }

    public function create_dump()
    {
        $result = exec("mkdir dump && chmod 777 dump && echo 1");
        if ($result) {
            echo "\033[33m"." Директория dump создана.\n";
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
        "https://github.com/PHPOffice/PHPExcel.git" => "tools/PHPExcel",
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
    private $file_name = "database";
    private $DB_HEADER = "CREATE TABLE IF NOT EXISTS";
    private $DB_FOOTER = " ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    private $MUL = array('beds' => '`bed` (`ward_id`,`bed`)' ,'wards' => '`floor` (`floor`,`ward`)'); // array('beds' => 'bed' ,'wards' => 'floor');

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
                $this->clean();
            }elseif($this->argument == "delete") {
                $this->delete();
            }else{
                echo "\033[31m"." Нет такого аргумента.\n";
            }

        } catch (\Error $e) {
            echo "\033[31m"." Ошибка.\n". $e;
        }

    }

    public function delete()
    {
        global $db; 
        require_once dirname(__DIR__, 1).'/functions/connection.php';
        require_once dirname(__DIR__, 1).'/functions/mixin.php';
        
        $_delete = Mixin\T_DELETE_database();
        if ($_delete == 200) {
            echo "\033[32m"." База данных успешно удалена.\n";
            return 1;
        }
    }

    public function clean()
    {
        global $db; 
        require_once dirname(__DIR__, 1).'/functions/connection.php';
        require_once dirname(__DIR__, 1).'/functions/mixin.php';
        
        $_clean = Mixin\T_FLUSH_database();
        if ($_clean == 200) {
            echo "\033[32m"." База данных успешно очищена.\n";
            return 1;
        }
    }

    public function migrate()
    {
        global $db; 
        require_once dirname(__DIR__, 1).'/functions/connection.php';
        require_once dirname(__DIR__, 1).'/functions/mixin.php';

        $file = file_get_contents(dirname(__DIR__, 1)."/DB/$this->file_name.json");
        $data = json_decode($file, true);
        $_initialize = Mixin\T_INITIALIZE_database($data);
        if ($_initialize == 200) {
            echo "\033[32m"." Миграция прошла успешно.\n";
            return 1;
        }
    }

    public function generate()
    {
        global $db;
        require_once dirname(__DIR__, 1).'/functions/connection.php';

        $json = array();

        foreach ($db->query("SHOW TABlES") as $table) {

            $sql = $this->DB_HEADER." `{$table['Tables_in_clinic']}` (";
            $column = "";
            $keys = "";

            foreach ($db->query("DESCRIBE {$table['Tables_in_clinic']}") as $col) {
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
                        $keys .= "UNIQUE KEY {$this->MUL[$table['Tables_in_clinic']]} USING BTREE";
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
        $path = "tools/DB/$this->file_name.json";
        $fp = fopen($path, "w");
        fwrite($fp, $code);
        echo "\033[32m"." Генерация прошла успешно!\n";
        return fclose($fp);
    }

    public function help()
    {
        echo "\033[33m"." Help in create.\n";
    }

}

?>
