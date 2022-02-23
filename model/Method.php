<?php

use Mixin\Model;

class Method extends Model
{
    use ResponceRender;
    public $table = 'methods';

    public function form()
    {
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= $this->urlHook() ?>">
            <div class="form-group">
                <label>Наименование:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите наименование" required value="<?= $this->value('name') ?>">
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