<?php

use Mixin\Hell;
use Mixin\Model;

class ServiceTerm extends Model
{
    public $table = 'service_terms';

    public function axe(){
        importModel('Service');
        $this->service = (new Service)->byId($this->getGet('service_id'));
        if ($this->service) {
            if ($term = $this->by($this->getGet())) {
                $this->setGet(array('id'=> $term->id));
                $this->setPost($term);
            }
            $this->form();
        }
        else Hell::error('404');
    }

    public function form(){
        global $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h5 class="modal-title">Услуга "<?= $this->service->name ?>"</h5>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>

        <form action="<?= $this->urlHook() ?>" method="post" onsubmit="submitForm()">

            <div class="modal-body">

                <?= $this->csrfToken(); ?>
                <input type="hidden" name="service_id" value="<?= $this->service->id ?>">

                <div class="form-group">
                    <label>Кол-во дней:</label>
                    <input type="number" class="form-control" name="day" min="0" step="1" max="10" value="<?= $this->value('day') ?>" placeholder="Введите кол-во">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script type="text/javascript">
            function submitForm() {
                event.preventDefault();
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (res) {
                        $('#modal_default').modal('hide');
                        if (res.status == "success") {
                            new Noty({
                                text: "Успешно!",
                                type: "success",
                            }).show();
                            credoSearch();
                        } else {
                            new Noty({
                                text: res.message,
                                type: "error",
                            }).show();
                        }
                    },
                });
            }
        </script>
        <?php
    }

    public function updateBefore()
    {
        if ($this->getPost('day') > 0) parent::updateBefore();
        else {
            $this->deleteBefore();
            $this->deleteBody();
            $this->deleteAfter();
        };
    }

}

?>