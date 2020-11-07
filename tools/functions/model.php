<?php
require_once 'mixin.php';


class Model
{
    protected $post;
    protected $table = '';

    public function set_post($post)
    {
        $this->post = $post;
    }

    public function get_post()
    {
        return $this->post;
    }

    public function set_table($table)
    {
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
                <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="<?= ($pk) ? $this->post->name : '' ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Color</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="color" value="<?= ($pk) ? $this->post->color : '' ?>" placeholder="">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        */
    }

    public function get(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
        prit($object);
        $this->set_post($object);
        // $this->dd();
        return $this->form($object->id);
    }

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
        if($object){
            $this->set_post($object);
            return $this->form($object->id);
        }else{
            header('location: ../error/404.php');
        }

    }

    public function save()
    {
        // $form = insert(strtolower(__CLASS__)."s", $this->post);
        $object = Mixin\insert($this->table, $this->post);
        if ($object == 1){
            $this->success();
        }else{
            $this->error($object);
        }
    }

    public function update(int $pk)
    {
        // $form = insert(strtolower(__CLASS__)."s", $this->post);
        $object = Mixin\update($this->table, $this->post, $pk);
        if ($object == 1){
            $this->success();
        }else{
            $this->error($object);
        }
    }

    public function delete(int $pk)
    {
        $object = Mixin\delete($this->table, $pk);
        if ($object) {
            $this->success();
        } else {
            Mixin\error_404();
        }

    }

    public function dd()
    {
        prit($this->post);
        exit;
    }

    public function success()
    {
        echo "Успешно";
    }

    public function error($message)
    {
        echo $message;
    }

}
?>
