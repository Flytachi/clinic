<?php

class Test_grupModel extends Model
{
    public $table = 'test_grup';

    public function form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">  
<div class="form-group">
    <label>Названия</label>
    <input type="text" name="name" value="<?= $post['name'] ?>" class="form-control" placeholder="Введите название" required>
</div>

<div class="text-right">
    <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
</div>
        </form>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
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