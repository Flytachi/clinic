<?php

class OperationPreparatModel extends Model
{
    public $table = 'operation_preparat';

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
                    <h5 class="modal-title">Изменить препарат: "<?= $post['item_name'] ?>"</h5>
                <?php else: ?>
                    <h5 class="modal-title">Добавить препарат</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Препарат:</label>
                        <select data-placeholder="Выберите материал" name="item_id" class="form-control select-price" required>
                            <option></option>
                            <?php $sql = "SELECT st.id, st.price, st.name,
                                            (
                                                st.qty -
                                                IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0)
                                            ) 'qty'
                                            FROM storage st WHERE st.category AND st.qty != 0 ORDER BY st.name"; ?>
                            <?php foreach ($db->query($sql) as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>" <?= ($post['item_id'] == $row['id']) ? "selected" : "" ?>><?= $row['name'] ?> (в наличии - <?= $row['qty'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Количество:</label>
                        <input type="number" name="item_qty" value="<?= ($post['item_qty']) ? $post['item_qty'] : "1" ?>" class="form-control" required>
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

                        $('#modal_add_preparat').modal('toggle');
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

    public function clean()
    {
        global $db;
        $prep = $db->query("SELECT name, price FROM storage WHERE id = {$this->post['item_id']}")->fetch();
        $this->post['item_name'] = $prep['name'];
        $this->post['item_cost'] = $prep['price'];
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