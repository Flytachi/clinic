<?php

namespace Warframe;

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

?>