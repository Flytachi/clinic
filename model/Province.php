<?php

use Mixin\Model;

class Province extends Model
{
    public $table = 'province';

    public function form()
    {
        ?>
        <form method="post" action="<?= $this->urlHook() ?>">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите name" required value="<?= $this->value('name') ?>">
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

    public function axe(){
        dd($this);
        $this->stop();
    }
}

?>