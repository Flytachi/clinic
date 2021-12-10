<?php

use Mixin\Model;

class GuideModel extends Model
{
    use ResponceRender;
    public $table = 'guides';

    public function form($pk = null)
    {
        is_message();
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group">
                <label>ФИО:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите ФИО" required value="<?= $this->value('name') ?>">
            </div>

            <div class="row">

                <div class="form-group col-md-6">
                    <label>Сумма:</label>
                    <input type="number" class="form-control" name="price" placeholder="Введите плата" required value="<?= $this->value('price') ?>">
                </div>

                <div class="form-group col-md-6">
                    <label>Доля:</label>
                    <input type="number" class="form-control" step="0.1" name="share" placeholder="Введите Долю" required value="<?= $this->value('share') ?>">
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
    }

    public function form_regy($pk = null)
    {
        is_message();
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group">
                <label>ФИО:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите ФИО" required value="<?= $this->value('name') ?>">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

}
        
?>