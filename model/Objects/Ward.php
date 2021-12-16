<?php

use Mixin\Model;
use Mixin\HellCrud;

class WardModel extends Model
{
    use ResponceRender;
    public $table = 'wards';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        is_message();
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">

            <div class="form-group row">

                <div class="col-8">
                    <label>Выбирите здание:</label>
                    <select data-placeholder="Выбрать здание" name="building_id" id="building_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM buildings WHERE branch_id = $session->branch") as $row): ?>
                            <option value="<?= $row['id'] ?>"<?= ($this->value('building_id') == $row['id']) ? 'selected': '' ?>><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-4">
                    <label>Выбирите этаж:</label>
                    <select data-placeholder="Выбрать этаж" name="floor" id="floor" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM buildings WHERE branch_id = $session->branch") as $row): ?>
                            <?php for ($i=1; $i <= $row['floors']; $i++): ?>
                                <option value="<?= $i ?>" data-chained="<?= $row['id'] ?>" <?= ($this->value('floor') == $i) ? 'selected': '' ?>><?= $i ?> этаж</option>
                            <?php endfor; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <?php if(config('wards_by_division')): ?>
                    <div class="col-6">
                        <label>Отдел:</label>
                        <select data-placeholder="Выбрать отдел" name="division_id" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT * FROM divisions WHERE branch_id = $session->branch AND level = 11") as $row): ?>
                                <option value="<?= $row['id'] ?>"<?= ($this->value('division_id') == $row['id']) ? 'selected': '' ?>><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="col-6">
                    <label>Палата:</label>
                    <input type="text" class="form-control" name="ward" placeholder="Введите кабинет" required value="<?= $this->value('ward') ?>">
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
                $("#floor").chained("#building_id");
            });
        </script>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function clean()
    {
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
        return True;
    }

}
        
?>