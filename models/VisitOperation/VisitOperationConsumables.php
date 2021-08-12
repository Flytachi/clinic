<?php

class VisitOperationConsumablesModel extends Model
{
    public $table = 'visit_operation_consumables';
    public $_visit_operations = 'visit_operations';
    public $_visits = 'visits';

    public function get_or_404(int $pk)
    {
        global $db;

        // Visit
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = {$_GET['visit_id']} AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){

            // Operation
            $object = $db->query("SELECT * FROM $this->_visit_operations WHERE id = $pk AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
            if($object){

                $this->visit_id = $_GET['visit_id'];
                $this->operation_id = $pk;
                if (isset($_GET['item']) and $_GET['item']) {
                    $data = $db->query("SELECT * FROM $this->table WHERE id = {$_GET['item']}")->fetch(PDO::FETCH_ASSOC);
                    if ($data) {
                        $this->set_post($data);
                        return $this->{$_GET['form']}($data['id']);
                    } else {
                        Mixin\error('report_permissions_false');
                        exit;
                    }
                }else{
                    return $this->{$_GET['form']}();
                }
                
            }else{
                Mixin\error('report_permissions_false');
                exit;
            }

        }else{
            Mixin\error('report_permissions_false');
        }

    }

    public function form($pk = null)
    {
        global $session, $classes;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="visit_id" value="<?= $this->visit_id ?>">
            <input type="hidden" name="operation_id" value="<?= $this->operation_id ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <?php if ($pk): ?>
                    <h5 class="modal-title">Изменить дополнительный расход: "<?= $this->value('item_name') ?>"</h5>
                <?php else: ?>
                    <h5 class="modal-title">Добавить дополнительный расход</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Наименование:</label>
                        <input type="text" placeholder="Введите наименование" name="item_name" value="<?= $this->value('item_name') ?>" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label>Сумма:</label>
                        <input type="text" name="item_cost" step="0.1" value="<?= number_format($this->value('item_cost')) ?>" class="form-control input-price" required>
                    </div>

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

            $("#<?= __CLASS__ ?>_form").submit(function( events ) {
                events.preventDefault();
                $.ajax({
                    type: $(events.target).attr("method"),
                    url: $(events.target).attr("action"),
                    data: $(events.target).serializeArray(),
                    success: function (data) {
                        var result = JSON.parse(data);

                        $('#modal_default').modal('hide');
                        if (result.status == "success") {
                            new Noty({
                                text: result.message,
                                type: 'success'
                            }).show();
                        }else {
                            new Noty({
                                text: result.message,
                                type: 'error'
                            }).show();
                        }

                        Title_up();
                    },
                });
            });

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
        $this->post['item_cost'] = (isset($this->post['item_cost'])) ? str_replace(',', '', $this->post['item_cost']) : 0;
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo json_encode(array(
            'status' => "success",
            'message' => "Успешно"
        ));
        exit;
    }

    public function error($message)
    {
        echo json_encode(array(
            'status' => "error",
            'message' => $message
        ));
        exit;
    }
}
        
?>