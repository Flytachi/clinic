<?php

class __Key
{
    private $argument;
    private $key = ".key";
    private $auth = "master_key_ITACHI:2021-06-30";

    function __construct($value = null, $seria = null)
    {
        $this->argument = $value;
        $this->seria = $seria;
        $this->handle();
    }

    private function handle()
    {
        if (!is_null($this->argument) and !is_null($this->seria)) $this->resolution();
    }

    private function resolution()
    {
        if (hex2bin("$this->argument") === $this->auth) $this->generate_key();
    }

    private function generate_key()
    {
        $KEY = dirname(__DIR__, 3)."/$this->key";
        $fp = fopen($KEY, "w");
        fwrite($fp, bin2hex(zlib_encode($this->seria, ZLIB_ENCODING_DEFLATE)));
        fclose($fp);
        echo 1; 
    }

}

?>