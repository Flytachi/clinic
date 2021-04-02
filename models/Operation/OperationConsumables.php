<?php

class OperationConsumablesModel extends Model
{
    public $table = 'operation_consumables';

    public function form($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
            $operation_id = $post['operation_id'];
        }else{
            $post = array();
            $operation_id = $patient->pk;
        }
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="operation_id" value="<?= $operation_id ?>">

            <div class="modal-header bg-info">
                <?php if ($pk): ?>
                    <h5 class="modal-title">Изменить дополнительный расход: "<?= $post['item_name'] ?>"</h5>
                <?php else: ?>
                    <h5 class="modal-title">Добавить дополнительный расход</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Наименование:</label>
                        <input type="text" placeholder="Введите наименование" name="item_name" value="<?= $post['item_name'] ?>" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label>Сумма:</label>
                        <input type="number" name="item_cost" step="0.1" value="<?= ($post['item_cost']) ? $post['item_cost'] : "0" ?>" class="form-control" required>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
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

                        $('#modal_add_consumables').modal('toggle');
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

        </script>
        <?php
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