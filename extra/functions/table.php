<?php

class Table
{
    /**
     * Table + Db + Pagination
     *
     * 
     * Краткая инструкция:
     * 
     * $tb = new Table($db, "table");    --->  Вызов и указание таблицы
     * 
     * 
     * $tb->where("id = 1");             --->  SQL WHERE
     * $tb->order_by("id ASC");          --->  SQL ORDER BY
     * $tb->set_limit(20);               --->  Колличество строк на странице
     * $tb->get_table()                  --->  Получае массив с данными
     * $tb->get_panel()                  --->  Вытаскиваем панель с пагинациией
     * 
     * 
     * 
     * Поисковая система Ajax:
     * 
     * $search = $tb->get_serch();       ---> Искомое
     * $tb->where_or_serch(@array);      ---> SQL WHERE + SEARCH
     * 
     * 
     * -- search.php
     * 
     * $tb->set_self('адрес главной страницы');
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
                    table_search: input.value,
                },
                success: function (result) {
                    display.innerHTML = result;
                },
            });
        });
      
     * -----------------------------------------------------------------------
     * 
     * @version 8.5
     */

    // database handle
    private $db;
    private $limit;
    private $data = "*";
    private $firstBack;
    private $nextLast;
    private $additions;
    private $where;
    private $order_by;
    private $php_self;
    private $search;
    
    public $search_get_name = "table_search=";
    public $params = "?";
    public $table;
    

    public function __construct($db, $table) {
        $this->db = $db;
        $this->table = $table;
    }

    public function set_limit(Int $limit = null)
    {
        /*
            Установка Лимита строк на странице
        */
        try {
            $this->limit = $limit;
            $this->generate_sql();
            $this->total_pages = ceil($this->db->query($this->sql)->rowCount() / $this->limit);
            return $this;
        } catch (\Throwable $th) {
            //throw $th;
            die("Ошибка в генерации скрипта!");
        }
    }

    public function set_data(String $data = null)
    {
        /*
            Установка столбцов которые хотим вытащить, по умолчаню все!
        */
        $this->data = $data;
        return $this;
    }

    public function set_self($uri)
    {
        /*
            Установка главной страницы!
            Используется в скрипте поиска.
        */
        $this->php_self = $uri;
        return $this;
    }

    public function additions(String $additions = null)
    {
        /*
            Установка дополнений в скрипе!
            До WHERE!
        */
        $this->additions = $additions;
        return $this;
    }

    public function where($where = null)
    {
        /*
            Установка зависимостей!
        */
        $this->where = $where;
        return $this;
    }

    public function where_or_serch(Array $array = null)
    {
        if ($this->search) {
            $this->where = $array[1];
        } else {
            $this->where = $array[0];
        }
        return $this;
    }

    public function order_by($order_by = null)
    {
        /*
            Установка порядка сортировки!
        */
        $this->order_by = $order_by;
        return $this;
    }

    private function generate_sql()
    {
        try {
            $this->sql = "SELECT $this->data FROM $this->table";
            if($this->additions) $this->sql .= " ".$this->additions;
            if($this->where) $this->sql .= " WHERE ".$this->where;
            if($this->order_by) $this->sql .= " ORDER BY ".$this->order_by;
            $this->search = (isset($_GET['table_search']) and $_GET['table_search']) ? $this->search_get_name.$_GET['table_search'] : "";
        } catch (\Throwable $th) {
            //throw $th;
            die("Ошибка в генерации скрипта!");
        }
        
    }
    
    private function create_panel($page)
    {
        $this->self = "";
        $self_uri = $this->gen_self();

        // prev
        if ($this->total_pages > 5) {
            if ($page > 1) {
                $prev_page = $page -1;
                $this->firstBack = "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=$prev_page$this->search\" class=\"page-link\">&larr; &nbsp; Prev</a></li>";
            }
        }

        // left
        if ($page <= floor($this->total_pages / 2)) {

            if ($this->total_pages == 5) {

                if ($page == 1) {
                    $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page+1)."$this->search\" class=\"page-link\">".($page+1)."</a></li>";
                }else if($page == 2) {
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page-1)."$this->search\" class=\"page-link\">".($page-1)."</a></li>";
                    $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
                }
                
            }elseif ($this->total_pages == 4) {

                if ($page == 1) {
                    $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page+1)."$this->search\" class=\"page-link\">".($page+1)."</a></li>";
                }else if($page == 2) {
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page-1)."$this->search\" class=\"page-link\">".($page-1)."</a></li>";
                    $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
                }
                
            }else {
                $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
                if ($this->total_pages > 4) $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page+1)."$this->search\" class=\"page-link\">".($page+1)."</a></li>";
            }
        
        }else {
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=1$this->search\" class=\"page-link\">1</a></li>";
            if ($this->total_pages > 3) $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=2$this->search\" class=\"page-link\">2</a></li>";
        }

        // center
        if ($this->total_pages == 5) {

            $status = ($page == 3) ? "active" : ""; 
            $this->self .= "<li class=\"page-item $status\"><a href=\"$self_uri\t$this->params\ttable_page=3$this->search\" class=\"page-link\">3</a></li>";
       
        }elseif ($this->total_pages > 4) {

            if ($page <= floor($this->total_pages / 2)) {
                $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".floor(($this->total_pages+$page)/2)."$this->search\" class=\"page-link\">...</a></li>";
            }else {
                $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".floor(($page)/2)."$this->search\" class=\"page-link\">...</a></li>";
            }

        }elseif($this->total_pages == 3) {

            $status = ($page == 2) ? "active" : ""; 
            $this->self .= "<li class=\"page-item $status\"><a href=\"$self_uri\t$this->params\ttable_page=2$this->search\" class=\"page-link\">2</a></li>";
        
        }
        

        // right
        if ($page > floor($this->total_pages / 2)) {

            if ($this->total_pages > 5) $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page-1)."$this->search\" class=\"page-link\">".($page-1)."</a></li>";
            
            if ($this->total_pages == 5) {

                if ($page == 4) {
                    $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page+1)."$this->search\" class=\"page-link\">".($page+1)."</a></li>";
                }else if($page == 5) {
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page-1)."$this->search\" class=\"page-link\">".($page-1)."</a></li>";
                    $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
                }else {
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page+1)."$this->search\" class=\"page-link\">".($page+1)."</a></li>";
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page+2)."$this->search\" class=\"page-link\">".($page+2)."</a></li>";
                }
                
            }elseif ($this->total_pages == 4) {

                if ($page == 3) {
                    $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page+1)."$this->search\" class=\"page-link\">".($page+1)."</a></li>";
                }else if($page == 4) {
                    $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($page-1)."$this->search\" class=\"page-link\">".($page-1)."</a></li>";
                    $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
                }
                
            }elseif ($this->total_pages == 3) {
                $status = ($page == 3) ? "active" : ""; 
                $this->self .= "<li class=\"page-item $status\"><a href=\"$self_uri\t$this->params\ttable_page=3$this->search\" class=\"page-link\">3</a></li>";
            }else {
                $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri\t$this->params\ttable_page=$page$this->search\" class=\"page-link\">$page</a></li>";
            }

        }else {
            if ($this->total_pages > 3) $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=".($this->total_pages-1)."$this->search\" class=\"page-link\">".($this->total_pages-1)."</a></li>";
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=$this->total_pages$this->search\" class=\"page-link\">$this->total_pages</a></li>";
        }
        
        // next
        if ($this->total_pages > 5) {
            if ($page < $this->total_pages) {
                $next_page = $page + 1;
                $this->nextLast =  "<li class=\"page-item\"><a href=\"$self_uri\t$this->params\ttable_page=$next_page$this->search\" class=\"page-link\">Next &nbsp; &rarr;</a></li>";
            }
        }

        return $this->firstBack.$this->self.$this->nextLast;
    }

    public function get_table($count_status = null)
    {
        /*
            Получение массива с данными!
        */
        $this->generate_sql();
        
        if ($this->limit) {
            $page = (int)(isset($_GET['table_page'])) ? (int) $_GET['table_page'] : $page = 1;
            $offset = (int) $this->limit * ($page - 1);
            $this->sql .= " LIMIT $this->limit OFFSET $offset";
        }
        try {
            $get = $this->db->query($this->sql)->fetchAll(PDO::FETCH_OBJ);
            if ($count_status) {
                $off_count = (($this->limit) ? $offset : 0) + 1;
                foreach ($get as $key => $value) {
                    $get[$key]->{'count'} = $off_count++;
                }
            }
            return $get;
        } catch (\Throwable $th) {
            //throw $th;
            die("Ошибка в генерации скрипта!");
        }
        
    }

    public function get_row($count_status = null)
    {
        /*
            Получение 1 элемента массива с данными!
        */
        $this->generate_sql();
        
        if ($this->limit) {
            $page =  (int)(isset($_GET['table_page'])) ? $_GET['table_page'] : $page = 1;
            $offset = $this->limit * ($page - 1);
            $this->sql .= " LIMIT $this->limit OFFSET $offset";
        }
        $get = $this->db->query($this->sql)->fetch(PDO::FETCH_OBJ);
        if ($count_status) {
            $off_count = (($this->limit) ? $offset : 0) + 1;
            foreach ($get as $key => $value) {
                $get[$key]->{'count'} = $off_count++;
            }
        }
        return $get;
    }

    public function get_panel()
    {
        /*
            Получение панели пагинации!
        */
        if ($this->limit) {
            if ($this->total_pages <= 1) {
                return 0;
            }
            $page = (int)(isset($_GET['table_page'])) ? $_GET['table_page'] : $page = 1;
    
            if ($page > $this->total_pages) {
                $page = $this->total_pages;
            } elseif ($page < 1) {
                $page = 1;
            }

            if ($_GET) {
                foreach ($_GET as $key => $value) {
                    if ($key != "table_page") {
                        $this->params .= "$key=$value&";
                    }
                }
            }

            // echo "<div class=\"card card-body border-top-1 border-top-pink text-center\">";
            // echo "  <ul class=\"pagination pagination-flat pagination-rounded align-self-center mt-3\" >";
            echo "  <ul class=\"pagination pagination-flat pagination-rounded align-self-center justify-content-center mt-3\" >";
            echo $this->create_panel($page);
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

    private function gen_self()
    {
        if (!$this->php_self) {
            $uri = $_SERVER['PHP_SELF'];
            if (EXT != ".php") {
                $uri = str_replace('.php', '', $_SERVER['PHP_SELF']);
            }
            return $uri;
        }
        return $this->php_self;
        
    }

    public function get_serch()
    {
        /*
            Получить искомый объект!
        */
        $this->search = (isset($_GET['table_search']) and $_GET['table_search']) ? $this->search_get_name.$_GET['table_search'] : "";
        $search = str_replace($this->search_get_name, "", $this->search);
        return Mixin\clean($search);
    }

    public function get_sql()
    {
        /*
            Получение массива с данными!
        */
        $this->generate_sql();
        return $this->sql;
    }

}

?>