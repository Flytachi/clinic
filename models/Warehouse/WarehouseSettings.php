<?php

class WarehouseSettingsModel extends Model
{
    public $table = 'warehouses';
    public $_application = 'warehouse_setting_applications';
    public $_permission = 'warehouse_setting_permissions';

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
        $appl =[]; ; $perm = [];
        $q_appl = $db->query("SELECT division_id FROM $this->_application WHERE warehouse_id = {$this->value('id')}")->fetchAll();
        foreach ($q_appl as $val) $appl[] = $val['division_id'];
        $p_level = $db->query("SELECT level FROM $this->_permission WHERE warehouse_id = {$this->value('id')}")->fetchColumn();
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
                        <select data-placeholder="Выбрать роль" id="appl_level" name="permission[level]" class="<?= $classes['form-select'] ?>" onchange="ChangeLevel(this)">
                            <option></option>
                            <option value="5" <?= (5 == $p_level) ? 'selected' : "" ?>><?= $PERSONAL[5] ?></option>
                            <option value="7" <?= (7 == $p_level) ? 'selected' : "" ?>><?= $PERSONAL[7] ?></option>
                        </select>
                    </div>

                    <div id="result_division">
                        <?php if($p_level): ?>
                            <?php 
                            $lev = ($p_level == 7) ? 5 : $p_level;
                            $q_perm = $db->query("SELECT division_id FROM $this->_permission WHERE warehouse_id = {$this->value('id')} AND is_grant IS NULL")->fetchAll();
                            foreach ($q_perm as $val) $perm[] = $val['division_id'];
                            ?>
                            <div class="form-group">
                                <label>Отделы</label>
                                <select data-placeholder="Выбрать отдел" multiple="multiple" name="permission[division][]" required class="settin <?= $classes['form-multiselect'] ?>" onchange="ChangeDivision(this)">
                                    <?php foreach($db->query("SELECT * from divisions WHERE level = $lev") as $row): ?>
                                        <option value="<?= $row['id'] ?>" <?= (in_array($row['id'], $perm)) ? 'selected' : "" ?>><?= $row['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="result_user">
                        <?php if( isset($q_perm) and $q_perm): ?>
                            <?php $grant = $db->query("SELECT responsible_id FROM $this->_permission WHERE warehouse_id = {$this->value('id')} AND is_grant IS NOT NULL")->fetchColumn(); ?>
                            <div class="form-group">
                                <label>Пользователь</label>
                                <select data-placeholder="Выбрать пользователя" name="permission[responsible_id]" required class="<?= $classes['form-select'] ?>">
                                    <option></option>
                                    <?php foreach($db->query("SELECT * from users WHERE user_level = $p_level AND division_id IN (". implode(',', $perm) .")") as $row): ?>
                                        <option value="<?= $row['id'] ?>" <?= ($row['id'] == $grant) ? 'selected' : "" ?>><?= get_full_name($row['id']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
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

            function ChangeDivision(params) {
                var dis = []
                for (let index = 0; index < params.selectedOptions.length; index++) dis[index] = params.selectedOptions[index].value;
                $.ajax({
                    type: "POST",
                    url: "<?= ajax('warehouse/setting_user') ?>",
                    data: { level: document.querySelector("#appl_level").value, division: dis },
                    success: function (result) {
                        document.querySelector("#result_user").innerHTML = result;
                        FormLayouts.init();
                    },
                });
            }

            function ChangeLevel(params) {
                $.ajax({
                    type: "POST",
                    url: "<?= ajax('warehouse/setting_division') ?>",
                    data: { level: params.value },
                    success: function (result) {
                        document.querySelector("#result_division").innerHTML = result;
                        $(".settin").multiselect({
                            includeSelectAllOption: true,
                            enableFiltering: true
                        });
                    },
                }); 
            }

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
            
            $this->application();
            $this->permission();

            $db->commit();
            $this->success();
        }
    }

    private function permission()
    {
        global $db;
        Mixin\delete($this->_permission, $this->post['warehouse_id'], "warehouse_id");
            
        if (isset($this->post['permission'])) {
            foreach ($this->post['permission']['division'] as $division) {
                $object = Mixin\insert($this->_permission, array('warehouse_id' => $this->post['warehouse_id'], 'level' => $this->post['permission']['level'], 'division_id' => $division));
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }
            }
            if ($this->post['permission']['responsible_id']) {
                $object = Mixin\insert($this->_permission, array(
                    'warehouse_id' => $this->post['warehouse_id'],
                    'is_grant' => true,
                    'level' => $this->post['permission']['level'],
                    'division_id' => division($this->post['permission']['responsible_id']),
                    'responsible_id' => $this->post['permission']['responsible_id']));
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }
            }
        }
    }

    private function application()
    {
        global $db;
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