<?php

use Mixin\HellCrud;
use Mixin\Model;

class BedTypeModel extends Model
{
    use ResponceRender;
    public $table = 'bed_types';

    public function form($pk = null)
    {
        global $session;
        is_message();
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">

            <div class="form-group">
                <label>Название:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $this->value('name') ?>">
            </div>

            <div class="form-group row">
                
                <div class="col-6">
                    <label>Цена:</label>
                    <input type="text" class="form-control input-price" name="price" placeholder="Введите цену" required value="<?= number_format($this->value('price')) ?>">
                </div>

                <div class="col-6">
                    <label>Цена(для иностранецев):</label>
                    <input type="text" class="form-control input-price" name="price_foreigner" placeholder="Введите цену" required value="<?= number_format($this->value('price_foreigner')) ?>">
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

            $(".input-price").on("input", function (event) {
                if (isNaN(Number(event.target.value.replace(/,/g, "")))) {
                    try {
                        event.target.value = event.target.value.replace(
                            new RegExp(event.originalEvent.data, "g"),
                            ""
                        );
                    } catch (e) {
                        event.target.value = event.target.value.replace(
                            event.originalEvent.data,
                            ""
                        );
                    }
                } else {
                    event.target.value = number_with(
                        event.target.value.replace(/,/g, "")
                    );
                }
            });

        </script>
        <?php
    }

    public function clean()
    {
        $this->post['price'] = (isset($this->post['price'])) ? str_replace(',', '', $this->post['price']) : 0;
        $this->post['price_foreigner'] = (isset($this->post['price_foreigner'])) ? str_replace(',', '', $this->post['price_foreigner']) : 0;
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
        return True;
    }
    
}
        
?>