<?php

use Mixin\ModelOld;

class WarehouseSettingsModel extends ModelOld
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
        $appl = $db->query("SELECT division_id FROM $this->_application WHERE warehouse_id = {$this->value('id')}")->fetchAll();
        $grants = $db->query("SELECT responsible_id FROM $this->_permission WHERE warehouse_id = {$this->value('id')} AND is_grant IS NOT NULL")->fetchAll();
        $users = $db->query("SELECT responsible_id FROM $this->_permission WHERE warehouse_id = {$this->value('id')} AND is_grant IS NULL")->fetchAll();
        for ($i=0; $i < count($grants); $i++) $grants[$i] = $grants[$i]['responsible_id'];
        for ($i=0; $i < count($users); $i++) $users[$i] = $users[$i]['responsible_id'];
        for ($i=0; $i < count($appl); $i++) $appl[$i] = $appl[$i]['division_id'];
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
                        <label>Полный доступ:</label>
                        <select data-placeholder="Выбрать пользователя" name="permission[grants][]" multiple="multiple" class="settin <?= $classes['form-multiselect'] ?>">
                            <?php foreach ($PERSONAL as $key => $value): ?>
                                <?php if(in_array($key, [4,5,6,7,10])): ?>
                                    <optgroup label="<?= $value ?>">
                                        <?php $level = ($key == 7) ? 5 : $key; ?>
                                        <?php foreach ((new Table($db, "users"))->where("user_level = $key AND division_id IS NULL")->get_table() as $user): ?>
                                            <option value="<?= $user->id ?>" <?= (in_array($user->id, $grants)) ? 'selected' : "" ?>><?= get_full_name($user->id) ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach ((new Table($db, "divisions"))->where("level = $level")->get_table() as $item): ?>
                                            <optgroup label="<?= $item->title ?>">
                                                <?php foreach ((new Table($db, "users"))->where("user_level = $key AND division_id = $item->id")->get_table() as $user): ?>
                                                    <option value="<?= $user->id ?>" <?= (in_array($user->id, $grants)) ? 'selected' : "" ?>><?= get_full_name($user->id) ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                            <option data-role="divider"></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Доступ на переводы:</label>
                        <select data-placeholder="Выбрать пользователя" name="permission[users][]" multiple="multiple" class="settin <?= $classes['form-multiselect'] ?>">
                            <?php foreach ($PERSONAL as $key => $value): ?>
                                <?php if(in_array($key, [4,5,6,7,10])): ?>
                                    <optgroup label="<?= $value ?>">
                                        <?php $level = ($key == 7) ? 5 : $key; ?>
                                        <?php foreach ((new Table($db, "users"))->where("user_level = $key AND division_id IS NULL")->get_table() as $user): ?>
                                            <option value="<?= $user->id ?>" <?= (in_array($user->id, $grants)) ? 'selected' : "" ?>><?= get_full_name($user->id) ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach ((new Table($db, "divisions"))->where("level = $level")->get_table() as $item): ?>
                                            <optgroup label="<?= $item->title ?>">
                                                <?php foreach ((new Table($db, "users"))->where("user_level = $key AND division_id = $item->id")->get_table() as $user): ?>
                                                    <option value="<?= $user->id ?>" <?= (in_array($user->id, $users)) ? 'selected' : "" ?>><?= get_full_name($user->id) ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                            <option data-role="divider"></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>


                </fieldset>
                
                <?php if($this->value('is_internal')): ?>
                    <fieldset>
                        <legend><b>Заявки</b></legend>
                        <div class="form-group">
                            <label>Видимость склада</label>
                            <select data-placeholder="Выбрать отдел" multiple="multiple" name="application[]" class="settin <?= $classes['form-multiselect'] ?>">
                                <?php foreach($db->query("SELECT * from divisions WHERE level IN (5)") as $row): ?>
                                    <option value="<?= $row['id'] ?>" <?= (in_array($row['id'], $appl)) ? 'selected' : "" ?>><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </fieldset>
                <?php endif; ?>
                
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
                    includeSelectAllOption: false,
                    enableFiltering: true,
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
            if (isset($this->post['permission']['grants'])) {
                foreach ($this->post['permission']['grants'] as $user) {
                    $object = Mixin\insert($this->_permission, array('warehouse_id' => $this->post['warehouse_id'], 'is_grant' => true, 'responsible_id' => $user));
                    if (!intval($object)){
                        $this->error($object);
                        $db->rollBack();
                    }
                }
            }
            if (isset($this->post['permission']['users'])) {
                foreach ($this->post['permission']['users'] as $user) {
                    $object = Mixin\insert($this->_permission, array('warehouse_id' => $this->post['warehouse_id'], 'responsible_id' => $user));
                    if (!intval($object)){
                        $this->error($object);
                        $db->rollBack();
                    }
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