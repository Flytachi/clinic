<?php

class ServicePreparatModel extends Model
{
    public $table = 'service_preparat';

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
                    <?php foreach ($db->query("SELECT * from service WHERE type = 3") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?php if($row['id'] == $post['service_id']){echo'selected';} ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group row">

                <div class="col-md-10">
                    <div class="form-group">
                        <label>Препарат:</label>
                        <select data-placeholder="Выбрать услугу" name="preparat_id" class="<?= $classes['form-myselect'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT * from storage") as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>" <?php if($row['id'] == $post['preparat_id']){echo'selected';} ?>><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Кол-во:</label>
                        <input type="number" class="form-control" name="qty" placeholder="Введите кол-во" value="<?= $post['qty']?>">
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