<?php

namespace Mixin;

// Credo

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
    
    use Querys;
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

// Model

abstract class Model extends Credo implements ModelInterface
{
    use ModelTrait, ModelTraitResponce;
    /**
     * 
     * Model + PDO
     * 
     * 
     * @version 12.0
     */

    public function set_post($post)
    {
        /**
         * Устанавливаем данные о записи!
         */
        $this->post = $post;
    }

    public function get_post()
    {
        /**
         * Данные о записи!
         */
        return $this->post;
    }


    public function clear_post()
    {
        /**
         * Очищаем данные о записи в классе!
         */
        unset($this->post);
    }

    public function set_table($table)
    {
        /**
         * Устанавливаем таблицу!
         */
        $this->table = $table;
    }

    public function get_table()
    {
        return $this->table;
    }

    public function form(int $pk = null)
    {
        /* Пример:

        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="<?= $this->value('name') ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Color</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="color" value="<?= $this->value('color') ?>" placeholder="">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        */
    }

    protected function value(String $var = null)
    {
        return (isset($this->post[$var])) ? $this->post[$var] : null;
    }

    public function get_or_404(int $pk)
    {
        /**
         * Данные о записи!
         * если не найдёт запись то выдаст 404 
         */
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(\PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Hell::error('404');
            exit;
        }

    }

    public function save()
    {
        /**
         * Операция создания записи в базе!
         */
        if($this->clean()){
            $object = HellCrud::insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
                exit;
            }
            $this->success();
        }
    }

    public function update()
    {
        /**
         * Операция обновления записи в базе!
         */
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = HellCrud::update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
                exit;
            }
            $this->success();
        }
    }

    public function file_download()
    {
        /**
         * Загрузка и сохранение файла
         * Можно настроить параметры валидации!
         */
        global $db;
        if ( isset($_FILES) ) {

            foreach ($_FILES as $key => $file) {

                if ( $file['name'] ) {
                    // Upload File
                    if ($file['error'] === UPLOAD_ERR_OK) {
                        $fileTmpPath = $file['tmp_name'];
                        $this->file['name'] = $file['name'];
                        $this->file['size'] = $file['size'];
                        $this->file['type'] = $file['type'];
                
                        $fileNameCmps = explode(".", $this->file['name']);
                        $this->file['extension'] = strtolower(end($fileNameCmps));
                        $newFileName = sha1(time() . $this->file['name']) . '.' . $this->file['extension'];
                
                        // File format
                        if (empty($this->file_format) or isset($this->file_format) and (is_array($this->file_format) and in_array($this->file['extension'], $this->file_format) or $this->file_format == $this->file['extension']) ) {
                            $uploadFileDir = $_SERVER['DOCUMENT_ROOT'].DIR.$this->file_directory;
                            $dest_path = $uploadFileDir . $newFileName;
                
                            // Check update
                            if( isset($this->post['id']) and $this->post['id'] ){
                                // Delete old file
                                $this->file_clean($key);
                            }
                            
                            if(move_uploaded_file($fileTmpPath, $dest_path)){
                                // File is successfully uploaded.
                                $this->post[$key] = $this->file_directory.$newFileName;
                                
                            }else{
                                $this->error("Ошибка записи в базу данных или сохранения файла!");
                            }
                
                        }else {
                            $this->error("Формат фыйла не поддерживается!");
                        }

                    }else {
                        $this->error("Ошибка загрузки во временную папку!");
                    }   
                }

            }

        }
    }

    public function file_clean(String $row_name, $pk = null)
    {
        global $db;
        if (!$pk) $pk = $this->post['id'];
        $select = $db->query("SELECT $row_name FROM $this->table WHERE id = {$pk}")->fetchColumn();
        if ($select) {
            unlink($_SERVER['DOCUMENT_ROOT'].DIR.$select);
        }
    }

    protected function clean()
    {
        /**
         * Очистка данных от скриптов! 
         * Можно настроить параметры валидации!
         */
        $this->file_download();
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
        return True;
    }

    protected function jquery_init()
    {
        /**
         * Инициализация jquery
         */
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
                // Select2Selects.init();
            });
        </script>
        <?php
    }

    public function delete(int $pk)
    {
        /**
         * Удаление объекта
         */
        $object = HellCrud::delete($this->table, $pk);
        if ($object) {
            $this->success();
        } else {
            if ($this->dinamic_delete) {
                $this->error("Не найден объект для удаления!");
            } else {
                Hell::error('404');
            }
            exit;
        }

    }

    // public function tb($index = null)
    // {
    //     global $db;
    //     return new \Table($db, "$this->table $index");
    // }

}

// Session

abstract class Session
{
    /**
     * 
     *  My Session
     * 
     *  @version 9.9
     **/

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
            $stmt = $this->db->query("SELECT id FROM users WHERE username = '$username' AND password = '$password' AND is_active IS NOT NULL")->fetch(\PDO::FETCH_OBJ);
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
            $this->data = $this->db->query("SELECT * FROM users WHERE id = $pk")->fetch(\PDO::FETCH_OBJ);
            unset($this->data->password);
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

?>