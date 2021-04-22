<?php

class MultiAccountsModel extends Model
{
    public $table = 'multi_accounts';

    public function form($pk = null)
    {
        global $db, $classes;
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
                <label>Slot:</label>
                <input type="text" class="form-control" name="slot" placeholder="Enter slot" required value="<?= $post['slot'] ?>">
            </div>

            <div class="form-group">
                <label>Выбирите Роль:</label>
                <select data-placeholder="Enter user" name="user_id" class="<?= $classes['form-select'] ?>" required>
                    <option></option>
                    <?php foreach ($db->query("SELECT id, username FROM users WHERE user_level != 15") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= ($post['user_id'] == $row['id']) ? "selected" : "" ?>><?= $row['username'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>

        </form>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
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