<?php
require_once 'mixin.php';

class Model
{
    protected $post;
    protected $table = '';

    function set_post($post)
    {
        $this->post = $post;
    }

    function get_post()
    {
        return $this->post;
    }

    function clear_post()
    {
        unset($this->post);
    }


    function set_table($table)
    {
        $this->table = $table;
    }

    function get_table()
    {
        return $this->table;
    }

    function form(int $pk = null)
    {
        /* Пример:

        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="<?= $post['name'] ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Color</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="color" value="<?= $post['color']?>" placeholder="">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        */
    }

    function get(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        prit($object);
        $this->set_post($object);
        return $this->form($object['id']);
    }

    function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->form($object['id']);
        }else{
            Mixin\error('404');
        }

    }

    function save()
    {
        if($this->clean()){
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
            }
            $this->success();
        }
    }

    function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
            }
            $this->success();
        }
    }

    function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    function delete(int $pk)
    {
        $object = Mixin\delete($this->table, $pk);
        if ($object) {
            $this->success();
        } else {
            Mixin\error('404');
        }

    }

    function stop()
    {
        exit;
    }

    function mod($mod=null)
    {
        switch ($mod) {
            case "test":
                prit($this);
                break;

            default:
                echo "Не назначен мод";
                break;
        }
        exit;
    }

    function success()
    {
        echo 1;
    }

    function error($message)
    {
        echo $message;
    }

}
?>
