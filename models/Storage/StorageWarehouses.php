<?php

class StorageWarehousesModel extends Model
{
    public $table = 'storage_warehouses';

    public function form($pk = null)
    {
        global $PERSONAL, $classes, $db;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">


            <div class="form-group">
                <label>Наименование:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите наименование" required value="<?= $this->value('name') ?>">
            </div>

            <div class="form-group">
                <label>Выбирите роль:</label>
                <select data-placeholder="Выбрать роль" name="level" id="level" class="<?= $classes['form-select'] ?>" required>
                    <option></option>
                    <?php foreach ($PERSONAL as $key => $value): ?>
                        <?php if(in_array($key, [5,6,7,10,11,12,13])): ?>
                            <option value="<?= $key ?>"<?= ($this->value('level') == $key) ? 'selected': '' ?>><?= $value ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach($db->query("SELECT * from divisions") as $row): ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['level'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id" class="<?= $classes['form-select'] ?>" required>
                        <?php foreach($db->query("SELECT * from users WHERE is_active IS NOT NULL") as $row): ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['user_level'] ?>"><?= get_full_name($row['id']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#division_id").chained("#level");
                $("#parent_id").chained("#level");
            });
        </script>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
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