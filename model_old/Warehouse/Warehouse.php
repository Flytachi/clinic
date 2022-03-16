<?php

use Mixin\HellCrud;
use Mixin\ModelOld;

class WarehouseModel extends ModelOld
{
    public $table = 'warehouses';

    public function form($pk = null)
    {
        global $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="is_active" value="1">

            <div class="form-group">
                <label>Наименование</label>
                <input type="text" class="form-control" name="name" placeholder="Введите наименование" value="<?= $this->value('name') ?>">
            </div>

            <div class="form-group">
                <label>Статус склада:</label>
                <select class="<?= $classes['form-select'] ?>" name="status" data-placeholder="Выберите статус" required>
                    <option></option>
                    <option value="0" <?= ($this->value('is_payment')) ? 'selected' : ''; ?>>Платный</option>
                    <option value="1" <?= ($this->value('is_free')) ? 'selected' : ''; ?>>Бесплатный</option>
                </select>
            </div>

            <div class="form-group">
                <label class="d-block font-weight-semibold">Тип склада</label>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="iternal" name="is_internal" value="1" <?= ($this->value('is_internal')) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="iternal">Внутренний</label>
                </div>
                
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="external" name="is_external" value="1" <?= ($this->value('is_external')) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="external">Внешний</label>
                </div>
                
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="operation" name="is_operation" value="1" <?= ($this->value('is_operation')) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="operation">Операционный</label>
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
        $this->jquery_init();
    }

    public function clean()
    {
        if (isset($this->post['status'])) {
            if ($this->post['status']) {
                $this->post['is_payment'] = false;
                $this->post['is_free'] = true;
            } else {
                $this->post['is_payment'] = true;
                $this->post['is_free'] = false;
            }
            unset($this->post['status']);
        }
        if (empty($this->post['is_internal'])) $this->post['is_internal'] = null;
        if (empty($this->post['is_external'])) $this->post['is_external'] = null;
        if (empty($this->post['is_operation'])) $this->post['is_operation'] = null;
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
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