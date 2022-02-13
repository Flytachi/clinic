<?php

use Mixin\Hell;

class __Cfg
{
    private $argument;
    private $setting_name = "setting.ini";
    private $cfg_name = ".cfg";
    private $path_credo = "/Src/Credo/__load__.php";
    private $path_hell = "/Src/Hell/__load__.php";
    private $default_configuratuons = array(
        'PORT' => 80,
        'HOSTS' => ['warframe'],
        'SECURITY' => array(
            'GUARD' => false,
            'SERIA' => null,
        ),
        'GLOBAL_SETTING' => array(
            'TIME_ZONE' => 'Asia/Samarkand', 
            'SESSION_TIMEOUT' => null, 
            'SESSION_LIFE' => null,
            'HIDE_EXTENSION' => false, 
            'ROOT_MOD' => false, 
            'DEBUG' => true, 
        ), 
        'DATABASE' => array(
            'DRIVER' => 'mysql', 
            'CHARSET' => 'utf8', 
            'HOST' => 'localhost',
            'PORT' => 3306,
            'NAME' => null,  
            'USER' => null,
            'PASS' => null, 
        ) 
    );


    function __construct($value = null, $name = null)
    {
        $this->argument = $value;
        $this->name = $name;
        $this->handle();
    }

    public function handle()
    {
        if (!is_null($this->argument)) $this->resolution();
        else $this->help();
    }

    private function resolution()
    {
        if ($this->argument == "setting") $this->create_setting();
        elseif ($this->argument == "gen") $this->generate_key();
        elseif ($this->argument == "edit") $this->edit_key();
        elseif ($this->argument == "show") $this->setting_show();
        else echo "\033[31m"." Не такого аргумента.\n";
    }

    private function create_setting()
    {
        require_once dirname(__DIR__, 2) . $this->path_credo;
        require_once dirname(__DIR__, 2) . $this->path_hell;
        
        if (!file_exists(dirname(__DIR__, 3)."/$this->setting_name")) {
            $fp = fopen(dirname(__DIR__, 3)."/$this->setting_name", "x");
            fwrite($fp, Hell::array_to_ini($this->default_configuratuons));
            echo "\033[32m". " $this->setting_name сгенирирован успешно!\n";
            return fclose($fp);
        }
        echo "\033[33m". " $this->setting_name уже существует!\n";
        return 0;
    }

    private function edit_key()
    {
        require_once dirname(__DIR__, 2) . $this->path_credo;
        require_once dirname(__DIR__, 2) . $this->path_hell;
        
        if (file_exists(dirname(__DIR__, 3)."/$this->cfg_name")) {
            $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 3)."/$this->cfg_name") );
            $code = json_decode(zlib_decode(hex2bin($cfg)), true);

            $fp = fopen(dirname(__DIR__, 3)."/$this->setting_name", "x");
            fwrite($fp, Hell::array_to_ini($code));
            fclose($fp);
            unlink(dirname(__DIR__, 3)."/$this->cfg_name");
            echo "\033[32m". " $this->setting_name сгенирирован успешно!\n";
            return 1;
        }
        echo "\033[33m". " $this->cfg_name не существует!\n";
        return 0;
    }

    private function setting_show()
    {
        require_once dirname(__DIR__, 2) . $this->path_credo;
        require_once dirname(__DIR__, 2) . $this->path_hell;

        if (file_exists(dirname(__DIR__, 3)."/$this->cfg_name")) {
            $cfg = str_replace("\n", "", file_get_contents(dirname(__DIR__, 3)."/$this->cfg_name") );
            $code = json_decode(zlib_decode(hex2bin($cfg)), true);
            print_r(Hell::array_to_ini($code));
            return 1;
        }
        echo "\033[33m". " $this->cfg_name не существует!\n";
        return 0;
    }

    private function generate_key()
    {
        $FILE_setting_ini = dirname(__DIR__, 3)."/$this->setting_name";
        if (file_exists($FILE_setting_ini)) {
            $sett = parse_ini_file($FILE_setting_ini, true);
            if (!file_exists(dirname(__DIR__, 3)."/$this->cfg_name")) {
                $fp = fopen(dirname(__DIR__, 3)."/$this->cfg_name", "x");
                fwrite($fp, chunk_split( bin2hex(zlib_encode(json_encode($sett), ZLIB_ENCODING_DEFLATE)) , 50, "\n") );
                fclose($fp);
                if (unlink($FILE_setting_ini)) {
                    echo "\033[32m". " $this->cfg_name сгенирирован успешно!\n";
                }else {
                    unlink(dirname(__DIR__, 3)."/$this->cfg_name");
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

    private function help()
    {
        echo "\033[33m"." =======> Help <======= \n";
        echo "\033[33m"."  :setting  -  создать файл настроек.\n";
        echo "\033[33m"."  :gen      -  сгенерировать конфигурации.\n";
        echo "\033[33m"."  :edit     -  изменить настройки.\n";
        echo "\033[33m"."  :show     -  просмотр настроек.\n";
        echo "\033[33m"." =======> Help <======= \n";
    }

}

?>