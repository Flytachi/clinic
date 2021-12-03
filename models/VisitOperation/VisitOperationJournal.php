<?php

use Warframe\Model;

class VisitOperationJournalModel extends Model
{
    public $table = 'visit_operation_journals';
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
        global $db, $session, $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Дневник</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

            <div class="listbock">

                <h5 class="text-center text-muted">Начало</h5>
                <div class="content" id="listbock">

                    <?php $tb = (new Table($db, $this->table))->where("operation_id = $this->operation_id")->order_by("add_date ASC"); ?>
                    <?php foreach ($tb->get_table() as $row): ?>
                        <?php 
                        if (date_f($row->add_date, 'Ymd') == date('Ymd')) $color = ($session->session_id == $row->responsible_id) ? "border-success" : "border-primary";
                        else $color = "";
                        if ($row->last_update) $dt = date_f($row->last_update, 1);
                        else $dt = date_f($row->add_date, 1);
                        ?>
                        <blockquote class="blockquote blockquote-bordered <?= $color ?> py-2 pl-3 mb-0" id="block_pk-<?= $row->id ?>">
                            <div class="row">
                                <div class="col-md-11"><p class="mb-2 font-size-base" id="record_pk-<?= $row->id ?>"><?= preg_replace("#\r?\n#", "<br />", $row->record) ?></p></div>
                                <?php if(config('card_stationar_journal_edit')): ?>
                                    <?php if($session->session_id == $row->responsible_id and $color == "border-success"): ?>
                                    <span onclick="ChangeRecord(<?= $row->id ?>)" class="col-md-1 text-right"><i class="icon icon-pencil"></i></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <footer class="blockquote-footer"><?= get_full_name($row->responsible_id) ?>, <cite title="Source Title"><?= $dt ?></cite></footer>
                        </blockquote>
                    <?php endforeach; ?>

                </div>
                <h6 class="text-center text-muted">Конец</h6>

            </div>
            
        </div>
        <form method="post" action="<?= add_url() ?>" onsubmit="AddDataJour()">
            <div class="modal-footer">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" id="input_id">
                <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
                <input type="hidden" name="visit_id" value="<?= $this->visit_id ?>">
                <input type="hidden" name="operation_id" value="<?= $this->operation_id ?>">
                <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">

                <textarea class="form-control" cols="2" rows="1" placeholder="Добавить новую запись" name="record" id="record_tip"></textarea>
                <div class="text-right">
                    <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                        <span class="ladda-label">Добавить</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
            </div>
        </form>
        <script type="text/javascript">

            function AddDataJour() {
                var listbock = document.querySelector("#listbock");
                var input = document.querySelector("#record_tip");
                event.preventDefault();

                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        var data = JSON.parse(result);

                        if (data.status == "success") {

                            var date = moment().format('DD.MM.YYYY HH:mm');
                            $(listbock).append(`
                            <blockquote class="blockquote blockquote-bordered border-success py-2 pl-3 mb-0" id="block_pk-${data.pk}">
                                <div class="row">
                                    <div class="col-md-11"><p class="mb-2 font-size-base" id="record_pk-${data.pk}">${input.value.replace(/\n/g, "<br>")}</p></div>
                                    <?php if(config('card_stationar_journal_edit')): ?>
                                        <span onclick="ChangeRecord(${data.pk})" class="col-md-1 text-right"><i class="icon icon-pencil"></i></span>
                                    <?php endif; ?>
                                </div>
                                <footer class="blockquote-footer"><?= get_full_name($session->session_id) ?>, <cite title="Source Title">${date}</cite></footer>
                            </blockquote>
                            `);
                            document.querySelector("#input_id").value = "";
                            input.value = "";
                            new Noty({
                                text: "Успешно!",
                                type: "success",
                            }).show();

                        } else {
                            new Noty({
                                text: data.message,
                                type: "error",
                            }).show();
                        }
                    },
                });
            }

        </script>
        <?php if(config('card_stationar_journal_edit')): ?>
            <script type="text/javascript">

                function ChangeRecord(pk) {
                    var listbock = document.querySelector("#listbock");
                    var input = document.querySelector("#record_tip");
                    input.value = document.querySelector(`#record_pk-${pk}`).innerHTML.replace(/<br>/g, "\n");
                    document.querySelector("#input_id").value = pk;

                    $(`#block_pk-${pk}`).css("background-color", "lightgreen");
                    $(`#block_pk-${pk}`).css("color", "black");
                    $(`#block_pk-${pk}`).fadeOut(900, function() {
                        $(this).remove();
                    });
                }

            </script>
        <?php endif; ?>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function save()
    {
        if($this->clean()){
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
                exit;
            }
            $this->pk = $object;
            $this->success();
        }
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $this->post['last_update'] = date("Y-m-d H:i:s");
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
                exit;
            }
            $this->pk = $pk;
            $this->success();
        }
    }

    public function success()
    {
        echo json_encode(array(
            'status' => 'success',
            'pk' => $this->pk
        ));
        exit;
    }

    public function error($message)
    {
        echo json_encode(array(
            'status' => 'error',
            'message' => $message
        ));
        exit;
    }
}
        
?>