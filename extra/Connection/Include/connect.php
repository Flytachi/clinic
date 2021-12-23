<?php

class Connect
{
    
    function __construct(String $_ = "db", String $driver = null, String $host = null, String $port = null, String $dbname = null, String $charset = "utf8", String $user = null, String $password = null)
    {
        global $ini, ${$_};
        if (!$driver) $driver = $ini['DATABASE']['DRIVER'];
        if (!$host) $host = $ini['DATABASE']['HOST'];
        if (!$port) $port = $ini['DATABASE']['PORT'];
        if (!$dbname) $dbname = $ini['DATABASE']['NAME'];
        if (!$user) $user = $ini['DATABASE']['USER'];
        if (!$password) $password = $ini['DATABASE']['PASS'];
        $DNS = "$driver:host=$host;dbname=$dbname;charset=$charset";

        try {
            ${$_} = new PDO($DNS, $user, $password);
            ${$_}->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            ${$_}->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
            if ( isset($ini['GLOBAL_SETTING']['DEBUG']) and $ini['GLOBAL_SETTING']['DEBUG'] ) ${$_}->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $_error = $e->getMessage();
            die(include "error.php");
        }
    }
}

?>