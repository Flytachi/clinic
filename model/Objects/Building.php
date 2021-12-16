<?php

use Mixin\Model;
use Mixin\HellCrud;

class BuildingModel extends Model
{
    use ResponceRender;
    public $table = 'buildings';

    public function form($pk = null)
    {
        global $session;
        is_message();
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">

            <div class="form-group row">
            
                <div class="col-10">
                    <label>Наименование здания:</label>
                    <input type="text" class="form-control" name="name" placeholder="Введите наименование" required value="<?= str_replace("Здание ", '', $this->value('name')) ?>">
                </div>

                <div class="col-2">
                    <label>Кол-во этажей:</label>
                    <input type="number" class="form-control" name="floors" placeholder="Введите наименование" required value="<?= $this->value('floors') ?>">
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

    public function clean()
    {
        $this->post['name'] = "Здание ".$this->post['name'];
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
        return True;
    }
}
        
?>