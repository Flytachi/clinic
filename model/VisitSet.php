<?php

use Mixin\Model;

class VisitSet extends Model
{
    public $table = 'visits';

    public function form(){
        global $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Назначить диагноз</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= $this->urlHook() ?>" onsubmit="submit<?= __CLASS__ ?>()">

            <div class="modal-body">

                <div class="form-group">
                    <label>Диагноз:</label>
                    <input type="text" class="form-control" name="comment" placeholder="Введите Диагноз" required value="<?= $this->value('comment') ?>">
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>

        <script>
            function submit<?= __CLASS__ ?>() {
                event.preventDefault();
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        if (result == 1) {
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
                        $('#modal_profile').modal('hide');
                    },
                });
            }
        </script>
        <?php
    }
}

?>