<?php

namespace Mixin;

abstract class Credo implements CredoInterface
{
    use CredoQuerys;
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
     * $search = $tb->getSerch();       ---> Искомое
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
    
        <form action="#">
            <input type="text" value="<?= $search ?>" id="search_input">
        </form>
      
     * -----------------------------------------------------------------------
     * 
     * Скрипт на Js + Ajax:
     * 
     * -----------------------------------------------------------------------
    
        $("#search_input").keyup(function() {
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
        });
      
     * -----------------------------------------------------------------------
     * 
     * @version 1.0
     */
    
    private $db;

    public function __construct($table = null) {
        global $db;
        $this->db = $db;
        (String) $this->CRD_as = "";
        (String) $this->CRD_data = "*";
        (String) $this->CRD_join = "";
        (String) $this->CRD_where = "";
        (String) $this->CRD_order = "";
        (String) $this->CRD_selfPage = "";
        (String) $this->CRD_search = "";
        (String) $this->CRD_searchGetName = "CRD_search=";
        (Bool) $this->CRD_error = false;
        (Int) $this->CRD_limit = 0;
    }

    public function as(String $context = "*")
    {
        /*
            Установка столбцов которые хотим вытащить, по умолчаню все!
        */
        $this->CRD_as = $context;
        return $this;
    }

    public function Data(String $context = "*")
    {
        /*
            Установка столбцов которые хотим вытащить, по умолчаню все!
        */
        $this->CRD_data = $context;
        return $this;
    }

    public function Limit(Int $limit = null) 
    {
        /*
            Установка Лимита строк на странице
        */
        $this->CRD_limit = $limit;
        return $this;
    }

    public function Join(String $context = null)
    {
        /*
            Установка дополнений в скрипе!
            До WHERE!
        */
        $this->CRD_join = $context;
        return $this;
    }

    public function Where($context = null)
    {
        /*
            Установка зависимостей!
        */
        if (is_array($context)) {
            if ($this->CRD_search) $this->CRD_where = $context[1];
            else $this->CRD_where = $context[0];
            return $this;
        }else $this->CRD_where = $context;
        return $this;
    }

    public function Order(String $context = null)
    {
        /*
            Установка порядка сортировки!
        */
        $this->CRD_order = $context;
        return $this;
    }

    public function returnPath(String $uri = null)
    {
        /*
            Установка главной страницы!
            Используется в скрипте поиска.
        */
        $this->CRD_selfPage = $uri;
        return $this;
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

    // --------------------

    public function panel()
    {
        /*
            Получение панели пагинации!
        */
        if ($this->CRD_limit > 0) {
            $this->CRD_totalPages = ceil($this->db->query(substr($this->CRD_sql, 0, strpos($this->CRD_sql, 'LIMIT')))->rowCount() / $this->CRD_limit);
            if ($this->CRD_totalPages <= 1) return 0;
            $page = (int)(isset($_GET['CRD_page'])) ? $_GET['CRD_page'] : $page = 1;

            if ($page > $this->CRD_totalPages) $page = $this->CRD_totalPages;
            elseif ($page < 1) $page = 1;

            if (empty($_GET['CRD_page'])) $_GET['CRD_page'] = 1;
            $this->CRD_params = $this->arrayToUrl($_GET);

            // echo "<div class=\"card card-body border-top-1 border-top-pink text-center\">";
            // echo "  <ul class=\"pagination pagination-flat pagination-rounded align-self-center mt-3\" >";
            echo "  <ul class=\"pagination pagination-flat pagination-rounded align-self-center justify-content-center mt-3\" >";
            echo $this->buildPanel($page);
            echo "  </ul>";
            // echo "</div>";
            /*
            <div class="card card-body border-top-1 border-top-pink text-center">
    
                <ul class="pagination pagination-flat pagination-rounded align-self-center">
                    <li class="page-item"><a href="#" class="page-link">&larr; &nbsp; Prev</a></li>
                    <li class="page-item active"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item disabled"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">Next &nbsp; &rarr;</a></li>
                </ul>
    
            </div>
            */
        }
    }

    private function buildPanel(int $page)
    {
        $this->selfP = $this->CRD_firstBack = $this->CRD_nextLast = "";
        $self_uri = $this->path();

        // prev
        if ($this->CRD_totalPages > 5) {
            if ($page > 1) $this->CRD_firstBack = "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, -1)."\" class=\"page-link\">&larr; &nbsp; Prev</a></li>";
        }

        // left
        if ($page <= floor($this->CRD_totalPages / 2)) {

            if ($this->CRD_totalPages == 5) {

                if ($page == 1) {
                    $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, 1)."\" class=\"page-link\">".($page+1)."</a></li>";
                }elseif($page == 2) {
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, -1)."\" class=\"page-link\">".($page-1)."</a></li>";
                    $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";
                }
                
            }elseif ($this->CRD_totalPages == 4) {

                if ($page == 1) {
                    $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, 1)."\" class=\"page-link\">".($page+1)."</a></li>";
                }elseif($page == 2) {
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, -1)."\" class=\"page-link\">".($page-1)."</a></li>";
                    $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";
                }
                
            }else {
                $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";
                if ($this->CRD_totalPages > 4) $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, 1)."\" class=\"page-link\">".($page+1)."</a></li>";
            }
        
        }else {
            $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageSet($this->CRD_params, 1)."\" class=\"page-link\">1</a></li>";
            if ($this->CRD_totalPages > 3) $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageSet($this->CRD_params, 2)."\" class=\"page-link\">2</a></li>";
        }

        // center
        if ($this->CRD_totalPages == 5) {

            $status = ($page == 3) ? "active" : ""; 
            $this->selfP .= "<li class=\"page-item $status\"><a href=\"$self_uri\t".$this->pageSet($this->CRD_params, 3)."\" class=\"page-link\">3</a></li>";
       
        }elseif ($this->CRD_totalPages > 4) {

            if ($page <= floor($this->CRD_totalPages / 2)) $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageSet($this->CRD_params, floor(($this->CRD_totalPages+$page)/2))."\" class=\"page-link\">...</a></li>";
            else $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageSet($this->CRD_params, floor(($page)/2))."\" class=\"page-link\">...</a></li>";

        }elseif($this->CRD_totalPages == 3) {

            $status = ($page == 2) ? "active" : ""; 
            $this->selfP .= "<li class=\"page-item $status\"><a href=\"$self_uri\t".$this->pageSet($this->CRD_params, 2)."\" class=\"page-link\">2</a></li>";
        
        }
        

        // right
        if ($page > floor($this->CRD_totalPages / 2)) {

            if ($this->CRD_totalPages > 5) $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, -1)."\" class=\"page-link\">".($page-1)."</a></li>";
            
            if ($this->CRD_totalPages == 5) {

                if ($page == 4) {
                    $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, 1)."\" class=\"page-link\">".($page+1)."</a></li>";
                }elseif($page == 5) {
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, -1)."\" class=\"page-link\">".($page-1)."</a></li>";
                    $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";
                }else {
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, 1)."\" class=\"page-link\">".($page+1)."</a></li>";
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, 2)."\" class=\"page-link\">".($page+2)."</a></li>";
                }
                
            }elseif ($this->CRD_totalPages == 4) {

                if ($page == 3) {
                    $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, 1)."\" class=\"page-link\">".($page+1)."</a></li>";
                }elseif($page == 4) {
                    $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, -1)."\" class=\"page-link\">".($page-1)."</a></li>";
                    $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";
                }
                
            }elseif ($this->CRD_totalPages == 3) {
                $status = ($page == 3) ? "active" : ""; 
                $this->selfP .= "<li class=\"page-item $status\"><a href=\"$self_uri\t".$this->pageSet($this->CRD_params, 3)."\" class=\"page-link\">3</a></li>";
            }else $this->selfP .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->CRD_params\" class=\"page-link\">$page</a></li>";

        }else {
            if ($this->CRD_totalPages > 3) $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageSet($this->CRD_params, $this->CRD_totalPages-1)."\" class=\"page-link\">".($this->CRD_totalPages-1)."</a></li>";
            $this->selfP .= "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageSet($this->CRD_params, $this->CRD_totalPages)."\" class=\"page-link\">$this->CRD_totalPages</a></li>";
        }
        
        // next
        if ($this->CRD_totalPages > 5) {
            if ($page < $this->CRD_totalPages) $this->CRD_nextLast =  "<li class=\"page-item\"><a href=\"$self_uri\t".$this->pageAddon($this->CRD_params, 1)."\" class=\"page-link\">Next &nbsp; &rarr;</a></li>";
        }

        return $this->CRD_firstBack.$this->selfP.$this->CRD_nextLast;
    }

    // --------------------

    public function byId(int $id)
    {
        /*
        Получение 1 экземпляра даных gj id
        */
        $this->Where("id = $id");
        $this->generateSql();
        try {
            $get = $this->db->query($this->CRD_sql)->fetch(\PDO::FETCH_OBJ);
            return $get;
        } catch (\Throwable $th) {
            if ($this->CRD_error) throw $th;
            else die("Ошибка в генерации скрипта!");
        }

    }

    public function get()
    {
        /*
        Получение 1 экземпляра даных
        */
        $this->generateSql();
        
        try {
            $get = $this->db->query($this->CRD_sql)->fetch(\PDO::FETCH_OBJ);
            return $get;
        } catch (\Throwable $th) {
            if ($this->CRD_error) throw $th;
            else die("Ошибка в генерации скрипта!");
        }
        
    }

    public function getId()
    {
        /*
        Получение 1 экземпляра даных
        */
        $this->Data("id");
        $this->generateSql();
        
        try {
            $get = $this->db->query($this->CRD_sql)->fetchColumn();
            return $get;
        } catch (\Throwable $th) {
            if ($this->CRD_error) throw $th;
            else die("Ошибка в генерации скрипта!");
        }
        
    }

    public function list(Bool $counter = false)
    {
        /*
            Получение массива с данными!
        */
        $this->generateSql();
        
        if ($this->CRD_limit) {
            $page = (int)(isset($_GET['CRD_page'])) ? (int) $_GET['CRD_page'] : $page = 1;
            $offset = (int) $this->CRD_limit * ($page - 1);
            $this->CRD_sql .= " LIMIT $this->CRD_limit OFFSET $offset";
        }
        try {
            $list = $this->db->query($this->CRD_sql)->fetchAll(\PDO::FETCH_OBJ);
            if ($counter) {
                $off_count = (($this->CRD_limit) ? $offset : 0) + 1;
                foreach ($list as $key => $value) {
                    $list[$key]->{'count'} = $off_count++;
                }
            }
            return $list;
        } catch (\Throwable $th) {
            if ($this->CRD_error) throw $th;
            else die("Ошибка в генерации скрипта!");
        }

    }

    // --------------------

    private function generateSql()
    {
        try {
            $this->CRD_sql = "SELECT $this->CRD_data FROM $this->table $this->CRD_as";
            if($this->CRD_join) $this->CRD_sql .= " ".$this->CRD_join;
            if($this->CRD_where) $this->CRD_sql .= " WHERE ".$this->CRD_where;
            if($this->CRD_order) $this->CRD_sql .= " ORDER BY ".$this->CRD_order;
            $this->CRD_search = (isset($_GET['CRD_search']) and $_GET['CRD_search']) ? $this->CRD_searchGetName.$_GET['CRD_search'] : "";
        } catch (\Throwable $th) {
            if ($this->CRD_error) throw $th;
            else die("Ошибка в генерации скрипта!");
        }
        
    }

    public function showError(Bool $status = false) 
    {
        /*
            Вывод ошибок
        */
        $this->CRD_error = $status;
        return $this;
    }

    public function getSql()
    {
        /*
            Получение массива с данными!
        */
        $this->generateSql();
        return $this->CRD_sql;
    }

    public function getSearch()
    {
        /*
            Получить искомый объект!
        */
        $this->CRD_search = (isset($_GET['CRD_search']) and $_GET['CRD_search']) ? $this->CRD_searchGetName.$_GET['CRD_search'] : "";
        $search = str_replace($this->CRD_searchGetName, "", $this->CRD_search);
        return $this->clsDta($search);
    }

}

?>