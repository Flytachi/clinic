<?php

class StoragesModel extends Model
{
    public $table = 'storages';
    // public $table_label = array(
    //     'id' => 'id',
    //     'code' => 'Код',
    //     'name' => 'Препарат',
    //     'supplier' => 'Поставщик',
    //     'category' => 'Категория(2,3,4)',
    //     'qty' => 'Кол-во',
    //     'qty_limit' => 'Лимит',
    //     'cost' => 'Цена прихода',
    //     'price' => 'Цена расхода',
    //     'faktura' => 'Счёт фактура',
    //     'shtrih' => 'Штрих код',
    //     'add_date' => 'Дата поставки',
    //     'die_date' => 'Срок годности',
    // );

    public function form($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" enctype="multipart/form-data">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="form-group">
                <label>Шаблон:</label>
                <input type="file" class="form-control" name="template" accept="application/vnd.ms-excel" required>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Внести</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo "Успешно";
    }

    public function error($message)
    {
        echo $message;
    }
}
        
?>