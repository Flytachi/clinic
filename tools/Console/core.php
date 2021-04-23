<?php
namespace Console;

require_once 'command.php';

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

    public function handle()
    {
        if ($this->argument_count > 1) {
            $this->resolution();
        }else {
            $this->help();
        }
    }

    private function resolution()
    {
        if ($this->arguments[1] === "serve") {
            echo "\033[32m"." Сокет сервер успешно запущен.\n";
            system('php7 socket.php');
            return 1;
        }

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

    public function help()
    {
        echo "\033[33m"."Help.\n";
    }


}


?>
