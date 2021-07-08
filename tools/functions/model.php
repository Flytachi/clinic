<?php
require_once 'mixin.php';

class Model
{
    /**
     * 
     * Model + PDO
     * 
     * 
     * @version 8.9
     */

    protected $post;
    protected $table = '';
    protected $file_directory = "/storage/";
    protected $file_format = null;

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
        return (isset($this->post[$var])) ? $this->post[$var] : '';
    }

    public function get(int $pk)
    {
        /**
         * Данные о записи!
         */
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        // dd($object);
        $this->set_post($object);
        return $this->form($object['id']);
    }

    public function get_or_404(int $pk)
    {
        /**
         * Данные о записи!
         * если не найдёт запись то выдаст 404 
         */
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('404');
            exit;
        }

    }

    public function save()
    {
        /**
         * Операция создания записи в базе!
         */
        if($this->clean()){
            $object = Mixin\insert($this->table, $this->post);
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
            $object = Mixin\update($this->table, $this->post, $pk);
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
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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
        $object = Mixin\delete($this->table, $pk);
        if ($object) {
            $this->success();
        } else {
            Mixin\error('404');
            exit;
        }

    }

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

?>
