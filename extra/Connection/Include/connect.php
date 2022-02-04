<?php

class Connect
{
    
    function __construct(String $DNS = null, String $user = null, String $password = null, String $_ = "db")
    {
        global ${$_};
        if (is_null($DNS)) $DNS = ini['DATABASE']['DRIVER'].":host=".ini['DATABASE']['HOST'].";port=".ini['DATABASE']['PORT'].";dbname=".ini['DATABASE']['NAME'].";charset=".ini['DATABASE']['CHARSET'];
        if (is_null($user)) $user = ini['DATABASE']['USER'];
        if (is_null($password)) $password = ini['DATABASE']['PASS'];
        
        try {
            ${$_} = new PDO($DNS, $user, $password);
            ${$_}->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            ${$_}->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
            if ( isset(ini['GLOBAL_SETTING']['DEBUG']) and ini['GLOBAL_SETTING']['DEBUG'] ) ${$_}->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $_error = $e->getMessage();
            die(include "error.php");
        }
    }
}

?>