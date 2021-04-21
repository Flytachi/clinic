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

    public function clear_post()
    {
        unset($this->post);
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

    public function get(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        // dd($object);
        $this->set_post($object);
        return $this->form($object['id']);
    }

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->form($object['id']);
        }else{
            Mixin\error('404');
            exit;
        }

    }

    public function save()
    {
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

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function jquery_init()
    {
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
        $object = Mixin\delete($this->table, $pk);
        if ($object) {
            $this->success();
        } else {
            Mixin\error('404');
            exit;
        }

    }

    public function stop()
    {
        exit;
    }

    public function mod($mod=null)
    {
        switch ($mod) {
            case "test":
                dd($this);
                break;

            default:
                echo "Не назначен мод";
                break;
        }
        exit;
    }

    public function dd()
    {
        dd($this);
        exit;
    }

    public function success()
    {
        echo 1;
    }

    public function error($message)
    {
        echo $message;
    }

}

?>
