<?php

class OperationMemberModel extends Model
{
    public $table = 'operation_member';

    public function form($pk = null)
    {
        global $db, $patient, $classes;
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
                    <h5 class="modal-title">Изменить данные персонала: "<?= $post['member_name'] ?>"</h5>
                <?php else: ?>
                    <h5 class="modal-title">Добавить члена персонала</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>Член персонала:</label>
                    <select placeholder="Введите члена персонала" class="<?= $classes['form-select'] ?>" onchange="$('#member_name').val(this.value)">
                        <option>Введите члена персонала</option>
                        <?php foreach ($db->query("SELECT us.id, IFNULL(opm.id, NULL) 'opm_id' FROM users us LEFT JOIN operation_member opm ON(opm.member_name=us.first_name AND opm.operation_id=$operation_id) WHERE us.user_level = 5 AND us.id != {$_SESSION['session_id']}") as $row): ?>
                            <option value="<?= get_full_name($row['id']) ?>"><?= get_full_name($row['id']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Имя специолиста:</label>
                    <input type="text" class="form-control" name="member_name" id="member_name" placeholder="Введите имя специолиста" required value="<?= (isset($post['member_name'])) ? $post['member_name'] : '' ?>">
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Оператор</label>
                    <div class="col-md-3">
                        <input type="checkbox" class="swit" name="member_operator" <?= (isset($post['member_operator']) and $post['member_operator']==1) ? "checked" : "" ?>>
                    </div>

                    <div class="col-md-5">
                        <label>Сумма:</label>
                        <input type="number" class="form-control" name="price" step="0.1" value="<?= (isset($post['price'])) ? $post['price'] : "0"?>" placeholder="Введите сумму">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>
        <script type="text/javascript">
            $("#<?= __CLASS__ ?>_form").submit(function( events ) {
                events.preventDefault();
                $.ajax({
                    type: $(events.target).attr("method"),
                    url: $(events.target).attr("action"),
                    data: $(events.target).serializeArray(),
                    success: function (data) {
                        var result = JSON.parse(data);

                        $('#modal_add_member').modal('toggle');
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
        if ($this->post['member_operator']) {
            $this->post['member_operator'] = 1;
        }
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