<?php

class WarehouseSettingsModel extends Model
{
    public $table = 'warehouses';
    public $_application = 'warehouse_setting_applications';
    public $_permission = 'warehouses';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk AND is_active IS NOT NULL")->fetch(PDO::FETCH_ASSOC);
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
        global $classes, $db, $PERSONAL;
        $appl =[];
        $q_appl = $db->query("SELECT division_id FROM $this->_application WHERE warehouse_id = {$this->value('id')}")->fetchAll();
        foreach ($q_appl as $val) $appl[] = $val['division_id'];
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Настройки склада <?= $this->value('name') ?></h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>" onsubmit="SubmitBp()">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="warehouse_id" value="<?= $this->value('id') ?>">
            
            <div class="modal-body">

                <fieldset>
                    <legend><b>Доступ</b></legend>
                    
                    <div class="form-group">
                        <label>Роль</label>
                        <select data-placeholder="Выбрать роль" name="application" class="<?= $classes['form-select'] ?>">
                            <option value="5"><?= $PERSONAL[5] ?></option>
                            <option value="7"><?= $PERSONAL[7] ?></option>
                        </select>
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend><b>Заявки</b></legend>
                    <div class="form-group">
                        <label>Доступ к заявкам</label>
                        <select data-placeholder="Выбрать отдел" multiple="multiple" name="application[]" class="settin <?= $classes['form-multiselect'] ?>">
                            <?php foreach($db->query("SELECT * from divisions WHERE level IN (5)") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= (in_array($row['id'], $appl)) ? 'selected' : "" ?>><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </fieldset>
                
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
                FormLayouts.init();
                $(".settin").multiselect({
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
            
            Mixin\delete($this->_application, $this->post['warehouse_id'], "warehouse_id");
            
            if (isset($this->post['application'])) {
                foreach ($this->post['application'] as $division) {
                    $object = Mixin\insert($this->_application, array('warehouse_id' => $this->post['warehouse_id'], 'division_id' => $division));
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