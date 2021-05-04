<?php

class DivisionModel extends Model
{
    public $table = 'division';

    public function form($pk = null)
    {
        global $db, $PERSONAL, $classes;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group">
                <label>Выбирите Роль:</label>
                <select data-placeholder="Выбрать роль" name="level" class="<?= $classes['form-select'] ?>" required>
                    <option></option>
                    <?php foreach ($PERSONAL as $key => $value): ?>
                        <option value="<?= $key ?>"<?= ($this->value($post, 'level') == $key) ? 'selected': '' ?>><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Название отдела:</label>
                <input type="text" class="form-control" name="title" placeholder="Введите название отдела" required value="<?= $this->value($post, 'title') ?>">
            </div>

            <div class="form-group">
                <label>Название специолиста:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название специолиста" required value="<?= $this->value($post, 'name') ?>">
            </div>

            <?php if(module('module_diagnostic')): ?>
                <div class="form-group row">
                    <label class="col-form-label col-md-1">Ассистент</label>
                    <div class="col-md-3">
                        <input type="checkbox" class="swit" name="assist" <?= ($this->value($post, 'assist') == 1) ? "checked" : "" ?>>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-1">Радиолог</label>
                    <div class="col-md-3">
                        <input type="checkbox" class="swit" name="assist" <?= ($this->value($post, 'assist') == 2) ? "checked" : "" ?>>
                    </div>
                </div>
            <?php endif; ?>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function clean()
    {
        if ($this->post['assist']) {
            $this->post['assist'] = True;
        }else {
            $this->post['assist'] = False;
        }
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