<?php

class __Base
{
    protected String $db_driver = "mysql";
    protected String $db_host = "localhost";
    protected String $db_charset = "utf8";
    protected String $db_user = "root";

    function __construct(string $db_password = null)
    {
        if ( isset($db_password) ) {
            $this->db_password = $db_password;
            $this->create();
        }else $this->handle();
    }

    private function handle()
    {
        echo "\033[33m"." Требуется 1 аргумента.\n";
        echo "\033[33m"." 1 => Пароль от root пользователя.\n";
    }

    private function create()
    {
        // Cfg
        if (!file_exists(dirname(__DIR__, 3)."/.cfg")) dieConection("Configuration file not found.");
        $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 3)."/.cfg") );
        define("ini", json_decode(zlib_decode(hex2bin($cfg)), true));
        //

        $this->create_db_name = ini['DATABASE']['NAME'];
        $this->create_db_user = ini['DATABASE']['USER'];
        $this->create_db_port = ini['DATABASE']['PORT'];
        $this->create_db_password = ini['DATABASE']['PASS'];
        $DNS = "$this->db_driver:host=$this->db_host;port=$this->create_db_port;charset=$this->db_charset";
        
        // Site Constants
        try {
            $rootDB = new PDO($DNS, $this->db_user, $this->db_password);
            $rootDB->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $rootDB->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $rootDB->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);

            $rootDB->beginTransaction();
            $rootDB->exec("CREATE USER '$this->create_db_user'@'%' IDENTIFIED BY '$this->create_db_password';");
            $rootDB->exec("GRANT USAGE ON *.* TO '$this->create_db_user'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;");
            $rootDB->exec("CREATE DATABASE IF NOT EXISTS `$this->create_db_name`;GRANT ALL PRIVILEGES ON `$this->create_db_name`.* TO '$this->create_db_user'@'%';");
            $rootDB->exec("FLUSH PRIVILEGES;");
            $rootDB->commit();
            echo "\033[32m"." Пользователь и база данных успешно созданы.\n";

        } catch (\PDOException $e) {
            // die($e);
            echo "\033[31m"." Ошибка в скрипте.\n";       
        }
    }
}

?>