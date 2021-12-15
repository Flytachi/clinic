<?php

use Mixin\Hell;
use Mixin\HellCrud;
use Mixin\Model;

class VisitOperationMemberModel extends Model
{
    public $table = 'visit_operation_members';
    public $_visit_operations = 'visit_operations';
    public $_visits = 'visits';

    public function get_or_404(int $pk)
    {
        global $db, $session;

        // Visit
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = {$_GET['visit_id']} AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){

            // Operation
            $object2 = $db->query("SELECT * FROM $this->_visit_operations WHERE id = $pk AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
            if($object2 and $session->session_id == $object2['grant_id']){

                $this->visit_id = $_GET['visit_id'];
                $this->operation_id = $pk;
                $this->operation_division = $object2['division_id'];
                if (isset($_GET['item']) and $_GET['item']) {
                    $data = $db->query("SELECT * FROM $this->table WHERE id = {$_GET['item']}")->fetch(PDO::FETCH_ASSOC);
                    if ($data) {
                        $this->set_post($data);
                        return $this->{$_GET['form']}($data['id']);
                    } else {
                        Hell::error('report_permissions_false');
                        exit;
                    }
                }else{
                    return $this->{$_GET['form']}();
                }
                
            }else{
                Hell::error('report_permissions_false');
                exit;
            }

        }else{
            Hell::error('report_permissions_false');
        }

    }

    public function form($pk = null)
    {
        global $db, $classes, $session;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
            <input type="hidden" name="visit_id" value="<?= $this->visit_id ?>">
            <input type="hidden" name="operation_id" value="<?= $this->operation_id ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <?php if ($pk): ?>
                    <h5 class="modal-title">Изменить данные персонала: "<?= $this->value('member_name') ?>"</h5>
                <?php else: ?>
                    <h5 class="modal-title">Добавить члена персонала</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <?php if (!$pk): ?>
                    <div class="form-group">
                        <label>Член персонала:</label>
                        <select placeholder="Введите члена персонала" class="<?= $classes['form-select'] ?>" onchange="$('#member_name').val(this.value)">
                            <option>Введите члена персонала</option>
                            <?php foreach ($db->query("SELECT id FROM users WHERE branch_id = $session->branch AND user_level = 11 AND division_id = $this->operation_division") as $row): ?>
                                <option value="<?= get_full_name($row['id']) ?>"><?= get_full_name($row['id']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Имя специолиста:</label>
                        <input type="text" class="form-control" name="member_name" id="member_name" placeholder="Введите имя специолиста" required>
                    </div>
                <?php endif; ?>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Оператор</label>
                    <div class="col-md-3">
                        <input type="checkbox" class="swit" name="member_operator" <?= ($this->value("member_operator")) ? "checked" : "" ?>>
                    </div>

                    <div class="col-md-5">
                        <label>Сумма:</label>
                        <input type="text" class="form-control input-price" name="member_price" value="<?= number_format($this->value("member_price")) ?>" placeholder="Введите сумму">
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
        <script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
        <script src="<?= stack("assets/js/custom.js") ?>"></script>
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
        $this->jquery_init();
    }

    protected function jquery_init()
    {
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
                Swit.init();
            });
        </script>
        <?php
    }

    public function clean()
    {
        global $session;
        $this->post['creater_id'] = $session->session_id;
        if (isset($this->post['member_operator']) and $this->post['member_operator']) $this->post['member_operator'] = 1;
        else $this->post['member_operator'] = null;
        $this->post['member_price'] = (isset($this->post['member_price'])) ? str_replace(',', '', $this->post['member_price']) : 0;
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
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