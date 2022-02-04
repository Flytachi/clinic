<?php

use Mixin\Model;

class VisitBedsModel extends Model
{
    public $table = 'visit_beds';
    public $_visits = 'visits';
    public $_beds = 'beds';
    public $_bed_types = 'bed_types';
    public $_user = 'users';


    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = $pk AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object and permission(7)){
            $this->set_post($db->query("SELECT * FROM $this->table WHERE visit_id = $pk AND end_date IS NULL")->fetch(PDO::FETCH_ASSOC));
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('report_permissions_false');
        }
    }

    public function form($pk = null)
    {
        global $classes, $session, $db;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Переместить на другую койку</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="old_id" value="<?= $this->value('id') ?>">
            <input type="hidden" name="visit_id" value="<?= $pk ?>">
            <input type="hidden" name="parent_id" value="<?= $session->session_id ?>">

            <div class="modal-body">

                <?php if(config('wards_by_division')): ?>
                    <div class="form-group row">

                        <div class="col-md-12">
                            <label>Отдел:</label>
                            <select data-placeholder="Выберите отдел" id="division_id" class="<?= $classes['form-select'] ?>" required>
                                <option></option>
                                <?php foreach($db->query("SELECT * from divisions WHERE level = 5") as $row): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>
                <?php endif; ?>

                <legend><b>Расположение</b></legend>

                <div class="form-group row">

                    <div class="col-3">
                        <label>Выбирите здание:</label>
                        <select data-placeholder="Выбрать здание" id="building_id" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT DISTINCT bg.id, bg.name FROM wards w LEFT JOIN buildings bg ON(bg.id=w.building_id)") as $row): ?>
                                <?php
                                $result = [];
                                foreach ($db->query("SELECT division_id FROM wards WHERE building_id = {$row['id']}") as $value) if(!in_array($value['division_id'], $result)) $result[] = $value['division_id'];
                                ?>
                                <option value="<?= $row['id'] ?>" data-divisions="<?= json_encode($result) ?>"><?= $row['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-3">
                        <label>Выбирите этаж:</label>
                        <select data-placeholder="Выбрать этаж" id="floor" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT DISTINCT bg.id, bg.floors FROM wards w LEFT JOIN buildings bg ON(bg.id=w.building_id)") as $row): ?>
                                <?php for ($i=1; $i <= $row['floors']; $i++): ?>
                                    <?php
                                    $result = [];
                                    foreach ($db->query("SELECT division_id FROM wards WHERE building_id = {$row['id']} AND floor = $i") as $value) if(!in_array($value['division_id'], $result)) $result[] = $value['division_id'];
                                    ?>
                                    <option value="<?= $i ?>" data-chained="<?= $row['id'] ?>" data-divisions="<?= json_encode($result) ?>" data-ward_qty="<?= $db->query("SELECT * FROM wards WHERE building_id = {$row['id']} AND floor = $i")->rowCount() ?>"><?= $i ?> этаж</option>
                                <?php endfor; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-3">
                        <label>Выбирите палату:</label>
                        <select data-placeholder="Выбрать палату" id="ward_id" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Койка:</label>
                        <select data-placeholder="Выбрать койку" name="bed_id" id="bed" class="<?= $classes['form-select_price'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT bd.*, bdt.price FROM beds bd LEFT JOIN bed_types bdt ON(bd.type_id=bdt.id)") as $row): ?>
                                <?php if ($row['user_id']): ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-name="<?= $row['types'] ?>" disabled><?= $row['bed'] ?> койка (<?= ($db->query("SELECT gender FROM users WHERE id = {$row['user_id']}")->fetchColumn()) ? "Male" : "Female" ?>)</option>
                                <?php else: ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-name="<?= $row['types'] ?>"><?= $row['bed'] ?> койка</option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Переместить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php if(config('wards_by_division')): ?>
            <script type="text/javascript">

                $('#division_id').change(function(){
                    var building_id = document.querySelector("#building_id");
                    var floor = document.querySelector("#floor");
                    var ward_id = document.querySelector("#ward_id");
                    var divis = document.querySelector("#division_id").value;

                    // buildings
                    var i = 1;
                    Array.prototype.slice.call(building_id.options).forEach(function(item) {

                        if(item.dataset.divisions){
                            var data = JSON.parse(item.dataset.divisions);

                            if(data.includes( Number(divis) )){
                                if(i == 1){
                                    $(building_id).val(item.value).change();
                                    i++;
                                }
                                item.disabled = false;
                            }else{
                                item.disabled = true;
                            }
                            delete data;
                        }
                        
                    });

                    // floor
                    var i = 1;
                    Array.prototype.slice.call(floor.options).forEach(function(item) {

                        if(item.dataset.divisions){
                            var data = JSON.parse(item.dataset.divisions);
                            
                            if(data.includes( Number(divis) ) && item.dataset.ward_qty > 0){
                                if(i == 1){
                                    $(floor).val(item.value).change();
                                    i++;
                                }
                                item.disabled = false;
                            }else{
                                item.disabled = true;
                            }
                            delete data;
                        }

                    });
                    // FormLayouts.init();

                });

            </script>
        <?php endif; ?>
        <script type="text/javascript">
            $(function(){
                // $("#ward").chained("#floor");
                $("#bed").chained("#ward_id");
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
                        url: "<?= ajax('options_wards') ?>",
                        data: {
                            building_id: params.selectedOptions[0].dataset.chained,
                            division_id: document.querySelector("#division_id").value,
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
        $this->jquery_init();
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function save()
    {
        global $db, $session;
        

        if($this->clean()){
            
            if (isset($this->post['old_id'])) {
                $data = $db->query("SELECT * FROM $this->table WHERE id = {$this->post['old_id']}")->fetch();
                $bed_data = $db->query("SELECT * FROM  $this->_beds WHERE id = {$this->post['bed_id']}")->fetch();
                $bed_types = $db->query("SELECT * FROM  $this->_bed_types WHERE id = {$bed_data['type_id']}")->fetch();
                
                $this->post['user_id'] = $data['user_id'];
                $this->is_foreigner = $db->query("SELECT is_foreigner FROM $this->_user WHERE id = {$this->post['user_id']}")->fetchColumn();
                $this->post['location'] = "{$bed_data['building']} {$bed_data['floor']} этаж {$bed_data['ward']} палата {$bed_data['bed']} койка";
                $this->post['type'] = $bed_data['types'];
                $this->post['cost'] = ($this->is_foreigner) ? $bed_types['price_foreigner'] : $bed_types['price'];
                unset($this->post['old_id']);
    
                $db->beginTransaction();

                // Остановка предыдущей койки
                $object = Mixin\update($this->table, array('end_date' => date("Y-m-d H:i:s")), $data['id']);
                $object2 = Mixin\update($this->_beds, array('user_id' => null), $data['bed_id']);
                if (!intval($object) and !intval($object2)){
                    $this->error("Ошибка на сервере!");
                    exit;
                }

                // Создание новой койки
                $object3 = Mixin\insert($this->table, $this->post);
                if (!intval($object3)) {
                    $this->error("Ошибка на сервере!");
                    $db->rollBack();
                }
                $object4 = Mixin\update($this->_beds, array('user_id' => $this->post['user_id']), $bed_data['id']);
                if (!intval($object4)){
                    $this->error("Ошибка на сервере!");
                    $db->rollBack();
                }

                $db->commit();
                $this->success();

            }else {
                $this->error("Ошибка на сервере!");
            }
            
        }
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