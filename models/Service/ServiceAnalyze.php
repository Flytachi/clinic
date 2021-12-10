<?php

use Mixin\Model;

class ServiceAnalyzeModel extends Model
{
    use ResponceRender;
    public $table = 'service_analyzes';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        is_message();
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">

            <div class="form-group">
                <label>Услуга:</label>
                <select data-placeholder="Выбрать услугу" name="service_id" class="<?= $classes['form-select'] ?>" required>
                    <option></option>
                    <?php foreach ($db->query("SELECT * FROM services WHERE branch_id = $session->branch AND level = 13") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= ($this->value('service_id') == $row['id']) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8">
                            <label>Норматив:</label>
                            <textarea class="form-control" name="standart" rows="3" cols="2" placeholder="Норматив"><?= $this->value('standart') ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label>Ед:</label>
                            <textarea class="form-control" name="unit" rows="3" cols="2" placeholder="Единица"><?= $this->value('unit') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Название:</label>
                            <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $this->value('name') ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Код:</label>
                            <input type="text" class="form-control" name="code" placeholder="Введите код" value="<?= $this->value('code') ?>">
                        </div>
                    </div>
                </div>

            </div>

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

}

?>