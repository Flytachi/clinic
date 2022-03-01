<?php

namespace Mixin;

abstract class Credo implements CredoInterface
{
    /**
     * Table + Db + Pagination
     *
     * 
     * Краткая инструкция:
     * 
     * $tb->Where("id = 1");             --->  SQL WHERE
     * $tb->Order("id ASC");             --->  SQL ORDER BY
     * $tb->Limit(20);                   --->  Колличество строк на странице
     * $tb->list()                       --->  Получае массив с данными
     * $tb->panel()                      --->  Вытаскиваем панель с пагинациией
     * 
     * 
     * 
     * Поисковая система Ajax:
     * 
     * $search = $tb->getSearch();       ---> Искомое
     * 
     * 
     * -- search.php
     * 
     * $tb->returnPath('адрес главной страницы');
     * 
     * 
     * 
     * Скрипт на Php + Html:
     * 
     * -----------------------------------------------------------------------
    
        <input type="text" value="<?= $search ?>" id="search_input">
      
     * -----------------------------------------------------------------------
     * 
     * Скрипт на Js + Ajax:
     * 
     * -----------------------------------------------------------------------
    
        $("#search_input").keyup(credoSearch);

        function credoSearch() {
            var input = document.querySelector('#search_input');
            var display = document.querySelector('#search_display');
            $.ajax({
                type: "GET",
                url: "search.php",
                data: {
                    CRD_search: input.value,
                },
                success: function (result) {
                    display.innerHTML = result;
                },
            });
        }
      
     * -----------------------------------------------------------------------
     * 
     * @version 3.0
     */
    
    private String $CRD_sql;
    private String $CRD_as = '';
    private String $CRD_data = '*';
    private String $CRD_join = '';
    private String $CRD_where = '';
    private String $CRD_order = '';
    private String $CRD_group = '';
    private String $CRD_selfPage = '';
    private String $CRD_search = '';
    private String $CRD_searchGetName = 'CRD_search=';
    private Int $CRD_limit = 0;
    private Bool $CRD_error = false;
    protected $db;

    use 
        CredoQuery,
        CredoParams,
        CredoPanel,
        CredoHelp;

    
    public function __construct($table_As = null) {
        global $db;
        $this->db = $db;
        if ($table_As) $this->CRD_as = $table_As;
    }

    private function generateSql()
    {
        try {
            $this->CRD_sql = "SELECT $this->CRD_data FROM $this->table $this->CRD_as";
            if($this->CRD_join)  $this->CRD_sql .= " " . $this->CRD_join;
            if($this->CRD_where) $this->CRD_sql .= " " . $this->CRD_where;
            if($this->CRD_order) $this->CRD_sql .= " " . $this->CRD_order;
            if($this->CRD_group) $this->CRD_sql .= " " . $this->CRD_group;
            $this->CRD_search = (isset($_GET['CRD_search']) and $_GET['CRD_search']) ? $this->CRD_searchGetName.$_GET['CRD_search'] : "";
        } catch (\Throwable $th) {
            if ($this->CRD_error) $this->error($th);
            else echo 'Ошибка в генерации скрипта <strong>"SQL"</strong>';
        }
        
    }

    private function path()
    {
        if (!$this->CRD_selfPage) {
            $uri = $_SERVER['PHP_SELF'];
            if (EXT != ".php") $uri = str_replace('.php', '', $_SERVER['PHP_SELF']);
            return $uri;
        }
        return $this->CRD_selfPage;
    }

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

    private function error($error){
        $message = "\t" . $error->getMessage();
        foreach ($error->getTrace() as $key => $value) {
            if ($key != 0) {
                $message .= "\n\t\t#" . $key . ' ';  
                if (isset($value['file']))     $message .= $value['file'];
                if (isset($value['line']))     $message .= '(' . $value['line'] . '): ';
                if (isset($value['class']))    $message .= $value['class'];
                if (isset($value['type']))     $message .= $value['type'];
                if (isset($value['function'])) $message .= $value['function'];
            }
        }
        die (parad('CREDO', $message));
    }

}

?>