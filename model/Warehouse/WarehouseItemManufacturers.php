<?php

use Mixin\Model;

class WarehouseItemManufacturersModel extends Model
{
    public $table = 'warehouse_item_manufacturers';

    public function form($pk = null)
    {
        global $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Добавить производителя</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>" onsubmit="Submit()">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="modal-body">

                <div class="form-group">
                    <label>Наименование:</label>
                    <input type="text" name="manufacturer" class="form-control" value="<?= $this->value('manufacturer') ?>" placeholder="Введите наименование" required>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script type="text/javascript">

            function Submit() {
                event.preventDefault();
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        if (result == 1) {
                            $(event).trigger("reset");
                            new Noty({
                                text: "Успешно!",
                                type: "success",
                            }).show();
                        } else {
                            new Noty({
                                text: result,
                                type: "error",
                            }).show();
                        }
                        $('#modal_default').modal('hide');
                    },
                });
            }

        </script>
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
        echo 1;
    }

    public function error($message)
    {
        echo $message;
    }
}
        
?>