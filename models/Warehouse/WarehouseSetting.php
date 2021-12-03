<?php

use Warframe\Model;

class WarehouseSettingModel extends Model
{
    public $table = 'warehouse_settings';
    public $_warehouse = 'warehouses';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->_warehouse WHERE id = $pk AND is_active IS NOT NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('report_permissions_false');
            exit;
        }

    }

    public function form($pk = null)
    {
        global $classes, $db, $session;
        $division =[];
        $div_s = $db->query("SELECT division_id FROM warehouse_settings WHERE warehouse_id = {$this->value('id')}")->fetchAll();
        foreach ($div_s as $val) $division[] = $val['division_id'];
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Настройки склада <?= $this->value('name') ?></h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>" onsubmit="SubmitBp()">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
            <input type="hidden" name="warehouse_id" value="<?= $this->value('id') ?>">
            
            <div class="modal-body">
                
                <label>Доступ отделам на заявки(пациентам)</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" name="division[]" id="division_sett" class="<?= $classes['form-multiselect'] ?>">
                    <?php foreach($db->query("SELECT * FROM divisions WHERE branch_id = $session->branch AND level = 11") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= (in_array($row['id'], $division)) ? 'selected' : "" ?>><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
                
            </div>
            
            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script>
            function SubmitBp() {
                event.preventDefault();
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        if (result == "success") {
                            $('#modal_default').modal('hide');
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
                    },
                });
            }
        </script>
        <?php
        $this->jquery_init();
    }

    public function jquery_init()
    {
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                $("#division_sett").multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true
                });
            });
        </script>
        <?php
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            $db->beginTransaction();
            
            Mixin\delete($this->table, $this->post['warehouse_id'], "warehouse_id");
            
            if (isset($this->post['division'])) {
                foreach ($this->post['division'] as $divis) {
                    $object = Mixin\insert($this->table, array('branch_id' => $this->post['branch_id'], 'warehouse_id' => $this->post['warehouse_id'], 'division_id' => $divis));
                    if (!intval($object)){
                        $this->error($object);
                        $db->rollBack();
                    }
                }
            }

            $db->commit();
            $this->success();
        }
    }

    public function success()
    {
        echo "success";
    }

    public function error($message)
    {
        echo $message;
    }
}
        
?>