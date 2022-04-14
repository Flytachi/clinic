<?php

use Mixin\Hell;
use Mixin\HellCrud;
use Mixin\Model;


class Warehouse extends Model
{
    public $table = 'warehouses';
    public $tApplication = 'warehouse_setting_applications';
    public $tPermission = 'warehouse_setting_permissions';

    public function Axe()
    {
        global $classes;
        if ($this->getGet('users')){
            importModel('User', 'WarehousePermission');
            $users = (new User)->Where("id IN (" . implode(',', $this->getGet('users')) . ")")->Order('user_level ASC');
            ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="<?= $classes['table-thead'] ?>">
                        <tr>
                            <th style="width: 65%;">Пользователь</th>
                            <th class="text-center">Заявки</th>
                            <th class="text-center">Перевод</th>
                            <th class="text-center">Grant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users->list() as $user): ?>
                            <?php $permission  = (new WarehousePermission)->by(array('warehouse_id' => $this->getGet('warehouse_id'), 'user_id' => $user->id)) ?>
                            <tr>
                                <td><?= userFullName($user) ?></td>
                                <td class="text-center">
                                    <input type="hidden" name="permission[<?= $user->id ?>][warehouse_id]" value="<?= $this->getGet('warehouse_id') ?>">
                                    <input type="checkbox" name="permission[<?= $user->id ?>][is_application]" class="form-control swit" value="1" <?php if($permission and $permission->is_application) echo "checked" ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="permission[<?= $user->id ?>][is_transaction]" class="form-control swit" value="1" <?php if($permission and $permission->is_transaction) echo "checked" ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="permission[<?= $user->id ?>][is_grant]" class="form-control swit" value="1" <?php if($permission and $permission->is_grant) echo "checked" ?>>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <script>
                $( document ).ready(function() {
                    Swit.init();
                });
            </script>
            <?php
        }
    }

    public function prepare()
    {
        if ($this->getPost('status')) {
            $this->setPostItem('is_payment', false);
            $this->setPostItem('is_free', true);
        } else {
            $this->setPostItem('is_payment', true);
            $this->setPostItem('is_free', false);
        }
        $this->deletePostItem('status');
        if (!$this->getPost('is_internal')) $this->setPostItem('is_internal', null);
        if (!$this->getPost('is_external')) $this->setPostItem('is_external', null);
        if (!$this->getPost('is_operation')) $this->setPostItem('is_operation', null);
    }

    public function saveBefore()
    {
        $this->prepare();
        parent::saveBefore();
    }

    public function updateBefore()
    {
        if($this->getPost('SETTING')){
            $this->setting();
        } else {
            $this->prepare();
            parent::updateBefore();
        }
    }

    public function form()
    {
        global $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Добавиь Склад</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= $this->urlHook() ?>" onsubmit="submitForm()">

            <?php $this->csrfToken(); ?>

            <div class="modal-body">

                <div class="form-group">
                    <label>Наименование</label>
                    <input type="text" class="form-control" name="name" placeholder="Введите наименование" value="<?= $this->value('name') ?>" required>
                </div>

                <div class="form-group">
                    <label>Статус склада:</label>
                    <select class="<?= $classes['form-select'] ?>" name="status" data-placeholder="Выберите статус" required>
                        <option></option>
                        <option value="0" <?= ($this->value('is_payment')) ? 'selected' : ''; ?>>Платный</option>
                        <option value="1" <?= ($this->value('is_free')) ? 'selected' : ''; ?>>Бесплатный</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="d-block font-weight-semibold">Тип склада</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="external" name="is_external" value="1" <?= ($this->value('is_external')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="external">Внешний</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="iternal" name="is_internal" value="1" <?= ($this->value('is_internal')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="iternal">Внутренний</label>
                    </div>
                    
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="operation" name="is_operation" value="1" <?= ($this->value('is_operation')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="operation">Операционный</label>
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

        <script>
            $( document ).ready(function() {
                FormLayouts.init();
            });
        </script>
        <?php
    }

    public function permissions()
    {
        global $classes, $PERSONAL, $PHARM_VISION;
        importModel('User', 'WarehousePermission');
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Настройки склада <?= $this->value('name') ?></h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= $this->urlHook() ?>" onsubmit="submitForm(0)">

            <?php $this->csrfToken(); ?>
            <input type="hidden" name="SETTING" value="1">
            
            <div class="modal-body">

                <fieldset>
                    <legend><b>Доступ</b></legend>

                    <div class="form-group">
                        <label>Пользователь:</label>
                        <select data-placeholder="Выбрать пользователя" id="select_user" onchange="selectUsers()" multiple="multiple" class="<?= $classes['form-multiselect'] ?>">
                            <?php
                            $users = (new WarehousePermission)->Data('user_id')->Where("warehouse_id=" . $this->getGet('id'))->list();
                            for ($i=0; $i < count($users); $i++) $users[$i] = $users[$i]->user_id;
                            ?>
                            <?php foreach ($PERSONAL as $key => $value): ?>
                                <?php if(in_array($key, $PHARM_VISION)): ?>
                                    <optgroup label="<?= $value ?>">
                                        <?php foreach ((new User)->Where("user_level = $key")->list() as $row): ?>
                                            <option value="<?= $row->id ?>" <?php if(in_array($row->id, $users)) echo 'selected' ?>><?= userFullName($row) . " (" . $row->username .")" ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="user_div"></div>

                </fieldset>
                
                <?php if($this->value('is_internal')): ?>
                    <?php
                    $appl_amb = $this->db->query("SELECT division_id FROM $this->tApplication WHERE warehouse_id = {$this->value('id')} AND direction IS NULL")->fetchAll();
                    $appl_sta = $this->db->query("SELECT division_id FROM $this->tApplication WHERE warehouse_id = {$this->value('id')} AND direction IS NOT NULL")->fetchAll();
                    for ($i=0; $i < count($appl_amb); $i++) $appl_amb[$i] = $appl_amb[$i]['division_id'];
                    for ($i=0; $i < count($appl_sta); $i++) $appl_sta[$i] = $appl_sta[$i]['division_id'];    
                    ?>
                    <fieldset>

                        <legend><b>Видимость</b></legend>
                        <div class="form-group row">
                        
                            <div class="col-md-6">
                                <label>Заявки (амбулатор)</label>
                                <select data-placeholder="Выбрать отдел" multiple="multiple" name="application[ambulator][]" class="settin <?= $classes['form-multiselect'] ?>">
                                    <?php foreach($this->db->query("SELECT * from divisions WHERE level IN (5)") as $row): ?>
                                        <option value="<?= $row['id'] ?>" <?= (in_array($row['id'], $appl_amb)) ? 'selected' : "" ?>><?= $row['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Заявки (стационар)</label>
                                <select data-placeholder="Выбрать отдел" multiple="multiple" name="application[stationar][]" class="settin <?= $classes['form-multiselect'] ?>">
                                    <?php foreach($this->db->query("SELECT * from divisions WHERE level IN (5)") as $row): ?>
                                        <option value="<?= $row['id'] ?>" <?= (in_array($row['id'], $appl_sta)) ? 'selected' : "" ?>><?= $row['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

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
            $( document ).ready(function() {
                FormLayouts.init();
                BootstrapMultiselect.init();
                <?php if(count($users)) echo "selectUsers()"; ?>
            });

            function selectUsers() {
                var params = document.querySelector("#select_user");
                var data = [];
                for (let index = 0; index < params.selectedOptions.length; index++) {
                    data.push(params.selectedOptions[index].value);
                }
                $.ajax({
                    type: "GET",
                    url: "<?= Hell::apiAxe(__CLASS__) ?>",
                    data: {
                        warehouse_id: <?= $this->getGet('id') ?>,
                        users: data,
                    },
                    success: function (result) {
                        $('#user_div').html(result);
                    },
                });
            }
        </script>
        <?php
    }

    public function setting()
    {
        $this->db->beginTransaction();
        $this->settingApplications();
        $this->settingPermissions();
        $this->db->commit();
        $this->success();
    }

    public function settingApplications()
    {
        HellCrud::delete($this->tApplication, $this->getGet('id'), "warehouse_id");
        if($this->getPost('application')){
            
            if ( isset($this->getPost('application')['ambulator']) ) {
                foreach ($this->getPost('application')['ambulator'] as $division) {
                    $q = HellCrud::insert($this->tApplication, array('warehouse_id' => $this->getGet('id'), 'division_id' => $division, 'direction' => null));
                    if ( !is_numeric($q) ) $this->error('Ошибка при создании прав видимости');
                }
            }
            if ( isset($this->getPost('application')['stationar']) ) {
                foreach ($this->getPost('application')['stationar'] as $division) {
                    $q = HellCrud::insert($this->tApplication, array('warehouse_id' => $this->getGet('id'), 'division_id' => $division, 'direction' => 1));
                    if ( !is_numeric($q) ) $this->error('Ошибка при создании прав видимости');
                }
            }

        }
    }

    public function settingPermissions()
    {
        if($this->getPost('permission')){

            importModel('WarehousePermission');
            foreach ($this->getPost('permission') as $user => $permission) {
                $separator = array('warehouse_id' => $permission['warehouse_id'], 'user_id' => $user);
                $data = (new WarehousePermission)->by($separator);
                if ($data) {
                    if(!isset($permission['is_application']) and !isset($permission['is_transaction']) and !isset($permission['is_grant'])) {
                        # delete
                        if (HellCrud::delete($this->tPermission, $data->id) <= 0 ) $this->error('Ошибка при удалении прав доступа');
                    } else {
                        # update
                        $newPermission = array(
                            'is_application' => (isset($permission['is_application'])) ? 1 : null,
                            'is_transaction' => (isset($permission['is_transaction'])) ? 1 : null,
                            'is_grant' => (isset($permission['is_grant'])) ? 1 : null,
                        );
                        $q = HellCrud::update($this->tPermission, array_merge($separator, $newPermission), $data->id);
                        if ( !is_numeric($q) and $q <= 0 ) $this->error('Ошибка при обновление прав доступа');
                    }
                } else {
                    # create
                    if(isset($permission['is_application']) or isset($permission['is_transaction']) or isset($permission['is_grant'])) {
                        $q = HellCrud::insert($this->tPermission, array_merge(array('user_id' => $user), $permission));
                        if ( !is_numeric($q) ) $this->error('Ошибка при создании прав доступа');
                    }
                }
            }

        }
    }
}

?>