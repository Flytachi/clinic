<?php
namespace Console;

/**
 *  Ядро консоли
 */
class Core
{
    private $argument_count;
    private $arguments;

    function __construct($arg1 = null, $arg2 = null)
    {
        $this->argument_count = $arg1;
        $this->arguments = $arg2;
        $this->handle();
    }

    private function handle()
    {
        if ($this->argument_count > 1) $this->resolution();
        else $this->help();
    }

    private function resolution()
    {
        foreach ($this->get_dir_contents(dirname(__FILE__)."/command/") as $filename) require_once $filename;

        try {
            if ($Class = stristr($this->arguments[1], ":", true)) {
                $Class_construct = "\__".$Class;
                $Arg = str_replace(":", "", stristr($this->arguments[1], ":"));
                $Arg2 = isset($this->arguments[2]) ? $this->arguments[2] : null;
            }else {
                $Class_construct = "\__".ucfirst($this->arguments[1]);
                $Arg = null;
                $Arg2 = isset($this->arguments[2]) ? $this->arguments[2] : null;
            }
            new $Class_construct($Arg, $Arg2);
        } catch (\Error $e) {
            echo "\033[31m"."Нет такой команды.\n";
        }

    }

    private function get_dir_contents($dir, $filter = '', &$results = array()) {
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value); 
            if(!is_dir($path)) {
                if(empty($filter) || preg_match($filter, $path)) $results[] = $path;
            } elseif($value != "." && $value != "..") get_dir_contents($path, $filter, $results);
        }
        return $results;
    }

    private function help()
    {
        echo "\033[33m"."Console helper.\n";
    }

}

?>
