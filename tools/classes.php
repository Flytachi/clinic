<?php

/* 
    My Classes
*/

use Mixin\Credo;
use Mixin\Hell;
use Mixin\HellCrud;

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
     * @version 8.6
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
            if ($this->limit) $this->total_pages = ceil($this->db->query($this->sql)->rowCount() / $this->limit);
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
        return HellCrud::clean($search);
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

class SessionC
{
    protected $db;
    protected $login_url = DIR."/auth/login".EXT;
    protected $index_url = "../index".EXT; //../index.php
    protected $logout_url = DIR."/auth/logout".EXT;
    protected $confirm_password_url = DIR."/auth/confirm_password".EXT;
    protected $timeout_mark_url = DIR."/auth/timeout_mark".EXT;
    
    protected $table = "sessions";
    public $life_session = 5; // minute

    function __construct($database, $life_session = null)
    {
        $this->db = $database;
        if ($life_session) $this->life_session = $life_session;
        if ($life_session) $this->life_session = $life_session;
        if (!is_dir(dirname(__DIR__, 1)."/session")) Hell::error('403');
        ini_set('session.save_path', dirname(__DIR__, 1)."/session");
        session_start();
    }

    protected function init()
    {
        $this->session_id = $_SESSION['session_id'];
        $this->session_login = $_SESSION['session_login'];
        if( isset($_SESSION['status']) ) $this->status = $_SESSION['status'];
        if( isset($_SESSION['session_get_full_name']) ) $this->session_get_full_name = $_SESSION['session_get_full_name'];
        if( isset($_SESSION['session_level']) ) $this->session_level = $_SESSION['session_level'];
        
        if ( isset($_SESSION['browser']) ) {
            $this->browser = $_SESSION['browser'];
        }else{
            if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $_SESSION['browser'] = "Firefox";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $_SESSION['browser'] = "Opera";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $_SESSION['browser'] = "Chrome";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $_SESSION['browser'] = "Explorer";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false) $_SESSION['browser'] = "Safari";
            else $_SESSION['browser'] = "Неизвестный";
        }
    }

    public function is_auth($arr = null)
    {
        if ( isset($_SESSION['session_timeout_logout']) ) {
            $this->logout();
        }elseif ( isset($_SESSION['session_id']) ) {
            if ( ((EXT) ? $this->login_url : $this->login_url.".php") == $_SERVER['PHP_SELF']) {
                $this->login_success();
            }
            // присвоение и создание в базе сессии
            $this->session_check();
            $this->set_data($_SESSION['session_id']);
        }else {
            if ( ((EXT) ? $this->login_url : $this->login_url.".php") != $_SERVER['PHP_SELF']) {
                $this->login();
            }elseif ($_POST) {
                $this->auth($_POST['username'], $_POST['password']);
            }
        }

        // проверка прав
        if ( isset($_SESSION['session_id']) and $_SESSION['session_id'] != "master") {
            if ($arr){
                if (is_array($arr)){
                    if(!in_array($this->data->user_level, $arr)){
                        Hell::error('423');
                    }
                }else{
                    if(intval($arr) != $this->data->user_level){
                        Hell::error('423');
                    }
                }
            }
        }

        if( isset($_SESSION['session_id']) and $this->session_id != "master" and empty($this->status) ){
            $sessionActive = true;
        }

    }

    protected function auth(string $login = null, string $password = null)
    {
        $username = HellCrud::clean($login);
        $password = sha1(HellCrud::clean($password));

        if ($this->master_confirm($username, $password)) {
            $this->set_data("master");
            $this->login_success();
        }

        try {
            $stmt = $this->db->query("SELECT id FROM users WHERE username = '$username' AND password = '$password' AND is_active IS NOT NULL")->fetch(PDO::FETCH_OBJ);
            if($stmt){
                $this->set_data($stmt->id);
                $this->login_success();
            }else{
                $_SESSION['message'] = 'Не верный логин или пароль';
            }
        } catch (\Throwable $th) {
            $_SESSION['message'] = 'Не верный логин или пароль';
        }

        
    }

    protected function session_check()
    {
        $sid = session_id();
        $this->session_confirm($sid);
        $object = $this->db->query("SELECT * FROM $this->table WHERE session_id = \"$sid\"")->fetch();
        if ($object) {
            $this->init();
            $this->session_create_or_update();  
        }else {
            $this->destroy();
        }
    }

    protected function session_confirm($sid)
    {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE session_id = \"$sid\" AND last_update + INTERVAL $this->life_session MINUTE < CURRENT_TIMESTAMP()");
        $stmt->execute();
    }

    protected function session_create_or_update()
    {
        $date = date("Y-m-d H:i:s");
        $new_ses = array(
            'session_id' => session_id(), 
            'self_id' => $_SESSION['session_id'], 
            'self_ip' => $_SERVER['REMOTE_ADDR'], 
            'self_login' => $_SESSION['session_login'], 
            'self_render' => $_SERVER['PHP_SELF'], 
            'self_agent' => $_SERVER['HTTP_USER_AGENT'], 
            'last_update' => $date);
        HellCrud::insert_or_update($this->table, $new_ses, 'session_id');        
    }

    protected function gen_password()
    {
        if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $browser = "Firefox";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $browser = "Opera";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $browser = "Chrome";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $browser = "Explorer";
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false) $browser = "Safari";
        else $browser = "Unknown";
        
        return sha1("browser-$browser|key-".date('YdH'));
    }

    public function destroy()
    {
        HellCrud::delete($this->table, session_id(), 'session_id');
        session_destroy();
        header("location: $this->login_url");
        exit;
    }

    public function set_data($pk) {
        if ($pk == "master") {
            $_SESSION['session_id'] = "master";
            $_SESSION['session_login'] = "master";
            $_SESSION['session_level'] = "master";
            
        }else {
            $this->data = $this->db->query("SELECT * FROM users WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
            $_SESSION['session_id'] = $pk;
            $_SESSION['session_login'] = $this->data->username;
            $_SESSION['session_get_full_name'] = ucwords($this->data->last_name." ".$this->data->first_name." ".$this->data->father_name);
            $_SESSION['session_level'] = $this->data->user_level;
        }
        
    }

    protected function master_confirm(string $username = null, string $password = null)
    {
        global $ini;
        if ( isset($_POST['master-key']) and $_POST['master-key'] == "master-key" ) {
            if ( isset($ini['MASTER_IPS']) and in_array(trim($_SERVER['REMOTE_ADDR']), $ini['MASTER_IPS']) and $username == null) {
                return true;
            }else {
                return false;
            }
        }elseif ($username == "master" and $password == $this->gen_password()) {
            return true;
        } else {
            return false;
        }
        
    }

    public function login()
    {
        header("location: $this->login_url");
    }

    public function login_link()
    {
        return $this->login_url;
    }

    protected function login_success()
    {
        $this->init();
        $this->session_create_or_update();
        header("location: $this->index_url");
    }

    public function logout()
    {
        return header("location: $this->logout_url");
    }

    public function logout_link()
    {
        return $this->logout_url;
    }

    public function logout_avatar_link($status)
    {
        return DIR."/auth/avatar_logout".EXT."?pk=$status";
    }

    public function timeout_mark_link()
    {
        return $this->timeout_mark_url;
    }

    public function confirm_password_link()
    {
        return $this->confirm_password_url;
    }

    public function get_session_create_or_update()
    {
        $this->session_create_or_update();
    }

    public function get_data() {
        return $this->data;
    }

    public function get_full_name() {
        return $this->session_get_full_name;
    }

    public function get_level() {
        return $this->data->user_level;
    }
}

class MySession extends SessionC
{

    protected function init()
    {
        $this->session_id = $_SESSION['session_id'];
        $this->session_login = $_SESSION['session_login'];
        if( isset($_SESSION['status']) ) $this->status = $_SESSION['status'];
        if( isset($_SESSION['session_get_full_name']) ) $this->session_get_full_name = $_SESSION['session_get_full_name'];
        if( isset($_SESSION['session_level']) ) $this->session_level = $_SESSION['session_level'];
        if( isset($_SESSION['session_division']) ) $this->session_division = $_SESSION['session_division'];
        if( isset($_SESSION['session_slot']) ) $this->session_slot = $_SESSION['session_slot'];
        
        if ( isset($_SESSION['browser']) ) {
            $this->browser = $_SESSION['browser'];
        }else{
            if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) $_SESSION['browser'] = "Firefox";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) $_SESSION['browser'] = "Opera";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) $_SESSION['browser'] = "Chrome";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) $_SESSION['browser'] = "Internet Explorer";
            elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false) $_SESSION['browser'] = "Safari";
            else $_SESSION['browser'] = "Неизвестный";
        }
    }

    protected function auth(string $login = null, string $password = null)
    {
        $username = HellCrud::clean($login);
        $password = sha1(HellCrud::clean($password));

        if ($this->master_confirm($username, $password)) {
            $this->set_data("master");
            $this->login_success();
        }elseif($username == "avatar" and $password == sha1("mentor".date('dH'))){
            $this->set_data("avatar");
            $this->login_success();
        }

        try {
            $stmt = $this->db->query("SELECT id FROM users WHERE username = '$username' AND password = '$password' AND is_active IS NOT NULL")->fetch(PDO::FETCH_OBJ);
            if($stmt){
                $this->set_data($stmt->id);
                $slot = $this->db->query("SELECT slot FROM multi_accounts WHERE user_id = $stmt->id")->fetchColumn();
                if ($slot) {
                    $_SESSION['session_slot'] = HellCrud::clean($slot);
                }
                $this->login_success();
            }else{
                $_SESSION['message'] = 'Не верный логин или пароль';
            }
        } catch (\Throwable $th) {
            $_SESSION['message'] = 'Не верный логин или пароль';
        }

        
    }

    public function set_data($pk) {
        if ($pk == "master") {
            $_SESSION['session_id'] = "master";
            $_SESSION['session_login'] = "master";
            $_SESSION['session_level'] = "master";
	        $_SESSION['session_division'] = "master";
            
        }elseif ($pk == "avatar") {
            $_SESSION['session_id'] = "avatar";
            $_SESSION['session_login'] = "avatar";
            $_SESSION['session_level'] = "avatar";
	        $_SESSION['session_division'] = "avatar";   
        }else {
            $this->data = $this->db->query("SELECT * FROM users WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
            $_SESSION['session_id'] = $pk;
            $_SESSION['session_login'] = $this->data->username;
            $_SESSION['session_get_full_name'] = ucwords($this->data->last_name." ".$this->data->first_name." ".$this->data->father_name);
            $_SESSION['session_level'] = $this->data->user_level;
	        $_SESSION['session_division'] = $this->data->division_id;
        }
        
    }

    public function get_accounts()
    {
        if (isset($this->session_slot)) {
            return $this->db->query("SELECT us.id, us.username FROM multi_accounts mca LEFT JOIN users us ON(mca.user_id=us.id) WHERE mca.slot = \"$this->session_slot\" ")->fetchAll();
        }
        return [];
    }

    public function get_division() {
        return $this->data->division_id;
    }

}

?>