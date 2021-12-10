<?php

use Mixin\Hell;
use Mixin\HellCrud;
use Mixin\Model;

class BedModel extends Model
{
    use ResponceRender;
    public $table = 'beds';
    public $_buildings = 'buildings';
    public $_wards = 'wards';
    public $_types = 'bed_types';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        is_message();
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">

            <div class="form-group row">

                <div class="col-4">
                    <label>Выбирите здание:</label>
                    <select data-placeholder="Выбрать здание" name="building_id" id="building_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM buildings WHERE branch_id = $session->branch") as $row): ?>
                            <option value="<?= $row['id'] ?>"<?= ($this->value('building_id') == $row['id']) ? 'selected': '' ?>><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-4">
                    <label>Выбирите этаж:</label>
                    <select data-placeholder="Выбрать этаж" name="floor" id="floor" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM buildings WHERE branch_id = $session->branch") as $row): ?>
                            <?php for ($i=1; $i <= $row['floors']; $i++): ?>
                                <option value="<?= $i ?>" data-chained="<?= $row['id'] ?>" <?= ($this->value('floor') == $i) ? 'selected': '' ?>><?= $i ?> этаж</option>
                            <?php endfor; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-4">
                    <label>Выбирите палату:</label>
                    <select data-placeholder="Выбрать палату" name="ward_id" id="ward_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php if($this->value('ward_id')): ?>
                            <option value="<?= $this->value('ward_id') ?>" selected><?= $db->query("SELECT ward FROM wards WHERE id =".$this->value('ward_id'))->fetchColumn() ?></option>
                        <?php endif; ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <?php if(!$pk): ?>
                    <div class="col-6">
                        <label>Кол-во коек:</label>
                        <input type="text" class="form-control" name="bed" placeholder="Введите кол-во" required value="<?= $this->value('bed') ?>">
                    </div>
                <?php endif; ?>
    
                <div class="col-6">
                    <label>Тип:</label>
                    <select data-placeholder="Выбрать тип" name="type_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach($db->query("SELECT * from bed_types WHERE branch_id = $session->branch") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($this->value('type_id') == $row['id']) ? 'selected': '' ?>><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#floor").chained("#building_id");
            });

            $('#building_id').change(function(){
                if(document.querySelector("#floor").value){
                    document.querySelector("#floor").value = "";
                }
            });

            $('#floor').change(function(){
                var params = this;
                if (params.selectedOptions[0].value) {
                    $.ajax({
                        type: "GET",
                        url: "<?= ajax('options/wards') ?>",
                        data: {
                            building_id: params.selectedOptions[0].dataset.chained,
                            floor: params.selectedOptions[0].value,
                        },
                        success: function (result) {
                            if (result.trim() == "<option></option>") {
                                document.querySelector("#ward_id").disabled = true;
                            } else {
                                document.querySelector("#ward_id").disabled = false;
                                document.querySelector("#ward_id").innerHTML = result;
                            }
                        },
                    });
                }else{
                    document.querySelector("#ward_id").disabled = true;
                }
            });
            
        </script>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object){
            if (is_null($object['client_id'])) {
                $this->set_post($object);
                return $this->{$_GET['form']}($object['id']);
            }
        }else{
            Hell::error('404');
            exit;
        }

    }

    public function save()
    {
        /**
         * Операция создания записи в базе!
         */
        if($this->clean()){
            $counts = $this->post['bed'];
            for ($i=1; $i <= $counts; $i++) {
                $this->post['bed'] = $i;
                $object = HellCrud::insert($this->table, $this->post);
                if (!intval($object)){
                    $this->error($object);
                    exit;
                }
            }
            $this->success();
        }
    }

    public function clean()
    {
        global $db;
        if ($this->post['building_id']) {
            $this->post['building'] = $db->query("SELECT name FROM $this->_buildings WHERE id = {$this->post['building_id']}")->fetchColumn();
        }
        if ($this->post['ward_id']) {
            $this->post['ward'] = $db->query("SELECT ward FROM $this->_wards WHERE id = {$this->post['ward_id']}")->fetchColumn();
        }
        if ($this->post['type_id']) {
            $this->post['types'] = $db->query("SELECT name FROM $this->_types WHERE id = {$this->post['type_id']}")->fetchColumn();
        }
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
        return True;
    }

}

?>