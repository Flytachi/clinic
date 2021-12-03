<?php

use Warframe\Model;

class WarehouseModel extends Model
{
    public $table = 'warehouses';

    public function form($pk = null)
    {
        global $PERSONAL, $classes, $db, $session;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        if($this->value('level')) $level = json_decode($this->value('level'));
        if($this->value('level')) $level_imp = implode(',', $level);
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">

            <div class="form-group">
                <label>Наименование:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите наименование" required value="<?= $this->value('name') ?>">
            </div>

            <div class="form-group">
                <label>Выбирите роль:</label>
                <select data-placeholder="Выбрать роль" multiple="multiple" name="level[]" class="<?= $classes['form-multiselect'] ?>" onchange="ChangeLevel(this)" required>
                    <?php foreach ($PERSONAL as $key => $value): ?>
                        <?php if($key == 25): ?>
                            <option value="<?= $key ?>" <?= ($this->value('level') and in_array($key, $level)) ? 'selected': '' ?>><?= $value ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group row" id="div_level_change">

                <?php if( $this->value('division') ): ?>
                    <?php if($this->value('level')) $division = json_decode($this->value('division')); ?>
                    <div class="col-md-6">
                        <label>Отделы:</label>
                        <select data-placeholder="Выбрать отделы" multiple="multiple" name="division[]" class="<?= $classes['form-multiselect'] ?>">
                            <?php foreach($db->query("SELECT * FROM divisions WHERE branch_id = $session->branch AND level IN ($level_imp)") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= ($this->value('division') and in_array($row['id'], $division)) ? 'selected': '' ?>><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                
                <?php if( $this->value('responsible_id') ): ?>
                    <div class="col-md-6">
                        <label>Ответственное лицо:</label>
                        <select data-placeholder="Выберите ответственное лицо" name="responsible_id" id="responsible_id" class="<?= $classes['form-select'] ?>" required>
                            <?php foreach($db->query("SELECT * FROM users WHERE branch_id = $session->branch AND is_active IS NOT NULL AND user_level IN ($level_imp)") as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= ($this->value('responsible_id') == $row['id']) ? 'selected': '' ?>><?= get_full_name($row['id']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script type="text/javascript">

            function ChangeLevel(params) {
                var options = params.selectedOptions;
                var data = [];

                for (let i = 0; i < (options).length; i++) {
                    data[i] = options[i].value;
                }

                $.ajax({
                    type: "GET",
                    url: "<?= ajax("pharmacy/options_division_and_parent") ?>",
                    data: { level: data },
                    success: function (result) {
                        $("#div_level_change").html(result);
                        FormLayouts.init();
                    },
                });
            }

        </script>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        $this->post['level'] = ( isset($this->post['level']) ) ? json_encode($this->post['level']) : null;
        $this->post['division'] = ( isset($this->post['division']) ) ? json_encode($this->post['division']) : null;
        return True;
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

?>