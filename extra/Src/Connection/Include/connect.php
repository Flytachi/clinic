<?php

class Connect
{
    private String $DNS;
    private String $user;
    private String $password;

    function __construct(Array $params)
    {
        if (is_null($params['DRIVER'])) dieConection("Connection: driver not found!");
        if (is_null($params['CHARSET'])) dieConection("Connection: charset not found!");
        if (is_null($params['HOST'])) dieConection("Connection: host not found!");
        if (is_null($params['PORT'])) dieConection("Connection: port not found!");
        if (is_null($params['NAME'])) dieConection("Connection: db name not found!");
        if (is_null($params['USER'])) dieConection("Connection: username not found!");
        $this->DNS = $params['DRIVER'] . ":host=".$params['HOST'] . ";port=" . $params['PORT'] . ";dbname=" . $params['NAME'] . ";charset=" . $params['CHARSET'];
        $this->user = $params['USER'];
        $this->password = $params['PASS'];
    }

    public function connection($debug = false) {
        try {
            $db = new PDO($this->DNS, $this->user, $this->password);
            $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $db->SetAttribute(PDO::ATTR_EMULATE_PREPARES, False);
            if ( $debug ) $db->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (\PDOException $e) {
            dieConection($e->getMessage());
        }
    }
}

?>