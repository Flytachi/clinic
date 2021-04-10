<?php

class DietModel extends Model
{
    public $table = 'diet';

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

            <div class="form-group">
                <label>Цена</label>
                <input type="number" name="price" value="<?= $post['price'] ?>" class="form-control" placeholder="Введите стоимость" required>
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
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}
        
?>