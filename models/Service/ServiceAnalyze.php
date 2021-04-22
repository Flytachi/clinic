<?php

class ServiceAnalyzeModel extends Model
{
    public $table = 'service_analyze';

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
                <label>Услуга:</label>
                <select data-placeholder="Выбрать услугу" name="service_id" class="<?= $classes['form-select'] ?>" required>
                    <option></option>
                    <?php foreach ($db->query("SELECT * from service WHERE user_level = 6") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?php if($row['id'] == $post['service_id']){echo'selected';} ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8">
                            <label>Норматив:</label>
                            <textarea class="form-control" name="standart" rows="3" cols="2" placeholder="Норматив"><?= $post['standart']?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label>Ед:</label>
                            <textarea class="form-control" name="unit" rows="3" cols="2" placeholder="Единица"><?= $post['unit']?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Название:</label>
                            <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $post['name']?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Код:</label>
                            <input type="text" class="form-control" name="code" placeholder="Введите код" value="<?= $post['code']?>">
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info">Сохранить</button>
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