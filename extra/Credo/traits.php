<?php

namespace Mixin;

// Model

trait ModelTraitResponce
{

    protected function success()
    {
        /**
         * Действие в случае успеха операции!
         */
        echo 1;
    }

    protected function error($message)
    {
        /**
         * Действие в случае ошибки операции!
         * Возвращает ошибку!
         */
        echo $message;
    }
}

trait ModelTrait
{
    protected $post;
    protected $table = '';
    protected $file_directory = "/storage/";
    protected $file_format = null;
    protected $dinamic_delete = true;
    
    protected function stop()
    {
        /**
         * Остановка операции!
         */
        exit;
    }

    protected function dd()
    {
        /**
         * Мод для тестов!
         */
        dd($this);
        exit;
    }
}

// Credo

trait Querys
{

    private function clsDta($value = "") {
        if (!is_array($value)) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
        }
        return $value;
    }

    private function pageAddon(String $url, int $value = 0)
    {
        $local = $this->urlToArray($url);
        $local['CRD_page'] += $value;
        return $this->arrayToUrl($local);
    }

    private function pageSet(String $url, int $value = 0)
    {
        $local = $this->urlToArray($url);
        $local['CRD_page'] = $value;
        return $this->arrayToUrl($local);
    }

    private function urlToArray(string $url)
    {
        $code = explode('?', $url);
        $result = [];
        foreach (explode('&', $code[1]) as $param) {
            if ($param) {
                $value = explode('=', $param);
                $result[$value[0]] = $value[1];
            }
        }
        return $result;
    }

    private function arrayToUrl(array $get)
    {
        $str = "?";
        foreach ($get as $key => $value) $str .= "$key=$value&";
        return substr($str,0,-1);
    }

}

?>