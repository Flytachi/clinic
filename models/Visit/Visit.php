<?php

class VisitModel extends Model
{
    public $table = 'visits';
    public $table2 = 'beds';
    public $_user = 'users';
    public $_service = 'visit_services';
    public $_beds = 'visit_beds';
    public $_prices = 'visit_prices';

    public function form_out($pk = null)
    {
        global $db, $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <select data-placeholder="Выбрать пациента" name="user_id" id="user_id" class="<?= $classes['form-select'] ?>" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM users WHERE user_level = 15 ORDER BY id DESC") as $row): ?>
                            <option value="<?= $row['id'] ?>" data-is_foreigner="<?= $row['is_foreigner'] ?>"><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?> <?= ($row['status']) ? "---(лечится)---" : "" ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Направитель:</label>
                    <select data-placeholder="Выберите направителя" name="guide_id" class="<?= $classes['form-select'] ?>">
                        <option></option>
                        <?php foreach ($db->query("SELECT * from guides ORDER BY name") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="form-group">
                <label>Жалоба:</label>
                <textarea class="form-control" name="complaint" rows="2" cols="2" placeholder="Жалоба"></textarea>
            </div>

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)" required>
                    <optgroup label="Врачи">
                        <?php foreach ($db->query("SELECT * from divisions WHERE level = 5") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <?php if(module('module_diagnostic')): ?>
                        <optgroup label="Диогностика">
                            <?php foreach ($db->query("SELECT * from divisions WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                    <?php if(module('module_laboratory')): ?>
                        <optgroup label="Лаборатория">
                            <?php foreach ($db->query("SELECT * from divisions WHERE level = 6") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                    <optgroup label="Остальные">
                        <?php foreach ($db->query("SELECT * from divisions WHERE level IN (12, 13) AND (assist IS NULL OR assist = 1)") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>


            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-11">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Отправить</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <th>Тип</th>
                                <th>Доктор</th>
                                <th style="width:100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>

        <script type="text/javascript">

            var service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        is_foreigner: document.querySelector("#user_id").selectedOptions[0].dataset.is_foreigner,
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 0
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function TableChangeServices(params) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(params).val(),
                        is_foreigner: document.querySelector("#user_id").selectedOptions[0].dataset.is_foreigner,
                        selected: service,
                        types: "1,2",
                        cols: 0
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_gudes($pk = null)
    {
        global $db, $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group row">
                <div class="col-md-6">
                    <label>Направитель:</label>
                    <select data-placeholder="Выберите направителя" name="guide_id" class="<?= $classes['form-select'] ?>">
                        <option></option>
                        <?php foreach ($db->query("SELECT * from guides ORDER BY name") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($this->value('guide_id') == $row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
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
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function form_sta($pk = null)
    {
        global $db, $FLOOR, $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <select data-placeholder="Выбрать пациента" name="user_id" class="<?= $classes['form-select'] ?>" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM users WHERE user_level = 15 ORDER BY id DESC") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($row['status']) ? "disabled" : "" ?>><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?> <?= ($row['status']) ? "---(лечится)---" : "" ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Направитель:</label>
                    <select data-placeholder="Выберите направителя" name="guide_id" class="<?= $classes['form-select'] ?>">
                        <option></option>
                        <?php foreach ($db->query("SELECT * from guides") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach($db->query("SELECT * from divisions WHERE level = 5") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id" class="<?= $classes['form-select'] ?>" required>
                        <?php foreach($db->query("SELECT * from users WHERE user_level = 5 AND is_active IS NOT NULL") as $row): ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

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
                    <select data-placeholder="Выбрать койку" name="bed" id="bed" class="<?= $classes['form-select_price'] ?>" required>
                        <option></option>
                        <?php foreach ($db->query("SELECT bd.*, bdt.price FROM beds bd LEFT JOIN bed_types bdt ON(bd.type_id=bdt.id)") as $row): ?>
                            <?php if ($row['user_id']): ?>
                                <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-name="<?= $row['name'] ?>" disabled><?= $row['bed'] ?> койка (<?= ($db->query("SELECT gender FROM users WHERE id = {$row['user_id']}")->fetchColumn()) ? "Male" : "Female" ?>)</option>
                            <?php else: ?>
                                <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-name="<?= $row['types'] ?>"><?= $row['bed'] ?> койка</option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" onclick="submitAlert()" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Отправить</span>
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

                    FormLayouts.init();

                });
            </script>
        <?php endif; ?>
        <script type="text/javascript">
            $(function(){
                // $("#ward").chained("#floor");
                $("#bed").chained("#ward_id");
                $("#floor").chained("#building_id");
                $("#parent_id").chained("#division_id");
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
                            console.log(result);
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

            function submitAlert() {
                let obj = JSON.stringify({ type : 'alert_new_patient',  id : $("#parent_id").val(), message: "У вас новый стационарный пациент!" });
                conn.send(obj);
            }
        </script>
        <?php
    }

    public function form_beds($pk = null)
    {
        global $db, $FLOOR, $patient, $classes;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="bed_stat" value="1">
            <input type="hidden" name="id" value="<?= $patient->visit_id ?>">

            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Этаж:</label>
                    <div class="col-lg-9">
                        <select data-placeholder="Выбрать этаж" name="" id="floor" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                            <?php foreach ($FLOOR as $key => $value): ?>
                                <?php if ($db->query("SELECT id FROM wards WHERE floor = $key")->rowCount() != 0): ?>
                                    <option value="<?= $key ?>" <?= ($key == $patient->floor) ? "selected" : "" ?>><?= $value ?></option>
                                <?php else: ?>
                                    <option value="<?= $key ?>" disabled><?= $value ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Палата:</label>
                    <div class="col-lg-9">
                        <select data-placeholder="Выбрать палату" name="" id="ward" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT ws.id, ws.floor, ws.ward FROM wards ws") as $row): ?>
                                <?php if ($db->query("SELECT id FROM beds WHERE ward_id = {$row['id']}")->rowCount() != 0): ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['floor'] ?>" <?= ($row['ward'] == $patient->ward) ? "selected" : "" ?>><?= $row['ward'] ?> палата</option>
                                <?php else: ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['floor'] ?>" disabled><?= $row['ward'] ?> палата</option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Койка:</label>
                    <div class="col-lg-9">
                        <select data-placeholder="Выбрать койку" name="bed_id" id="bed" class="<?= $classes['form-select_price'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT bd.*, bdt.price, bdt.name from beds bd LEFT JOIN bed_type bdt ON(bd.types=bdt.id)") as $row): ?>
                                <?php if ($row['user_id']): ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-price="<?= $row['price'] ?>" data-name="<?= $row['name'] ?>" disabled><?= $row['bed'] ?> койка (<?= ($db->query("SELECT gender FROM users WHERE id = {$row['user_id']}")->fetchColumn()) ? "Male" : "Female" ?>)</option>
                                <?php else: ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-price="<?= $row['price'] ?>" data-name="<?= $row['name'] ?>" ><?= $row['bed'] ?> койка</option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->form_gudes($object['id']);
        }else{
            Mixin\error('404');
        }

    }

    public function create_or_update_visit()
    {
        global $db;
        $post = array(
            'grant_id' => ( isset($this->post['direction']) and $this->post['direction'] ) ? $this->post['parent_id'] : null,
            'user_id' => ($this->post['user_id']) ? $this->post['user_id'] : null,
            'direction' => ( isset($this->post['direction']) ) ? $this->post['direction'] : null,
            'complaint' => ( isset($this->post['complaint']) ) ? $this->post['complaint'] : null,
        );
        dd($post);
        $this->dd();
        $object = Mixin\insert_or_update($this->table, $post, 'user_id', "completed IS NULL");
        if (!intval($object)) {
            $this->error($object);
            $db->rollBack();
        }else{
            $this->visit_pk = $object;
            $this->is_foreigner = $db->query("SELECT is_foreigner FROM $this->_user WHERE id = {$this->post['user_id']}")->fetchColumn();
        }
    }

    public function add_visit_service($key = null, $value)
    {
        global $db;
        $data = $db->query("SELECT * FROM services WHERE id = $value")->fetch();
        $post['division_id'] = ($this->post['direction']) ? $this->post['division_id'] : $this->post['division_id'][$key];

        $post['visit_id'] = $this->visit_pk;
        $post['user_id'] = $this->post['user_id'];
        $post['parent_id'] = ($this->post['direction']) ? $this->post['parent_id'] : $this->post['parent_id'][$key];
        $post['route_id'] = $_SESSION['session_id'];
        $post['guide_id'] = $this->post['guide_id'];
        $post['level'] = $db->query("SELECT level FROM divisions WHERE id = {$post['division_id']}")->fetchColumn();
        $post['status'] = ($this->post['direction']) ? 2 : 1;
        $post['service_id'] = $data['id'];
        $post['service_name'] = $data['name'];
        
        $count = ($this->post['direction']) ? 1 : $this->post['count'][$key];
        for ($i=0; $i < $count; $i++) {
            $post = Mixin\clean_form($post);
            $post = Mixin\to_null($post);
            $object = Mixin\insert($this->_service, $post);
            if (!intval($object)){
                $this->error($object);
                $db->rollBack();
            }

            if (!$this->post['direction'] or (!permission([2, 32]) and $this->post['direction'])) {
                $post_price['visit_id'] = $this->visit_pk;
                $post_price['visit_service_id'] = $object;
                $post_price['user_id'] = $this->post['user_id'];
                $post_price['item_type'] = 1;
                $post_price['item_id'] = $data['id'];
                $post_price['item_cost'] = ($this->is_foreigner) ? $data['price_foreigner'] : $data['price'];
                $post_price['item_name'] = $data['name'];
                $object = Mixin\insert($this->_prices, $post_price);
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }
            }
        }
        unset($post);
    }

    public function add_visit_bed()
    {
        global $db;
        $bed_data = $db->query("SELECT wd.floor, wd.ward, bd.bed, bdt.name FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) LEFT JOIN bed_types bdt ON(bdt.id=bd.types) WHERE bd.id = {$this->post['bed']}")->fetch();

        $post = array(
            'visit_id' => $this->visit_pk,
            'user_id' => $this->post['user_id'],
            'bed_id' => $this->post['bed'],
            'location' => "{$bed_data['floor']} этаж {$bed_data['ward']} палата {$bed_data['bed']} койка",
            'type' => $bed_data['name'],
        );
        $object = Mixin\insert($this->_beds, $post);
        if (!intval($object)) {
            $this->error($object);
            $db->rollBack();
        }

        $object2 = Mixin\update($this->table2, array('user_id' => $this->post['user_id']), $this->post['bed']);
        if (!intval($object2)){
            $this->error($object2);
            $db->rollBack();
        }
    }

    public function save()
    {
        global $db;
        if($this->clean()){

            $db->beginTransaction();

            $this->create_or_update_visit();
            if (is_array($this->post['service'])) {

                foreach ($this->post['service'] as $key => $value) {
                    $this->add_visit_service($key, $value);
                }

            }else{
                
                $this->add_visit_service(null, 1);
                $this->add_visit_bed();
                // $this->dd();
                
            }

            // Обновление статуса у пациента
            $object1 = Mixin\update($this->_user, array('status' => True), $this->post['user_id']);
            if (!intval($object1)){
                $this->error($object1);
                $db->rollBack();
            }
            $db->commit();
            $this->success();

        }
    }

    public function clean()
    {
        global $db;
        
        if (is_array($this->post['division_id']) and empty($this->post['direction']) and !$this->post['service']) {
            $this->error("Не назначены услуги!");
        }
        // if ($this->post['bed_stat']) {
        //     $this->bed_edit();
        // }
        // $object = Mixin\insert($this->table, $post_big);
        return True;
    }

    public function bed_edit()
    {
        global $db;
        // unset($this->post['bed_stat']);
        // $visit = $db->query("SELECT * FROM visit WHERE id = {$this->post['id']}")->fetch();
        // $this->bed_price($visit);
        // $this->change_beds($visit);
        // $this->update();
    }

    public function change_beds($visit)
    {
        global $db;
        // $bed_old = $db->query("SELECT * FROM beds WHERE id = {$visit['bed_id']}")->fetch();
        // $bed_new = $db->query("SELECT * FROM beds WHERE id = {$this->post['bed_id']}")->fetch();
        // $bed_old['user_id'] = null;
        // $bed_new['user_id'] = $visit['user_id'];
        // $object = Mixin\insert_or_update('beds', $bed_old);
        // if (!intval($object)) {
        //     $this->error($object);
        // }
        // $object = Mixin\insert_or_update('beds', $bed_new);
        // if (!intval($object)) {
        //     $this->error($object);
        // }
    }

    public function bed_price($visit)
    {
        global $db;
        // $sql = "SELECT wd.floor,
        //             wd.ward, bd.bed,
        //             ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), IFNULL(vp.add_date, vs.add_date)), '%H')) * (bdt.price / 24) 'bed_cost'
        //         FROM visit vs
        //             LEFT JOIN beds bd ON(bd.id=vs.bed_id)
        //             LEFT JOIN wards wd ON(wd.id=bd.ward_id)
        //             LEFT JOIN bed_type bdt ON(bdt.id=bd.types)
        //             LEFT JOIN visit_price vp ON(vp.visit_id=vs.id AND vp.item_type = 101)
        //         WHERE vs.id = {$visit['id']} ORDER BY vp.add_date DESC";
        // $bed = $db->query($sql)->fetch();
        // if ($bed['bed_cost'] > 0) {
        //     $post['visit_id'] = $visit['id'];
        //     $post['user_id'] = $visit['user_id'];
        //     $post['status'] = 0;
        //     $post['item_type'] = 101;
        //     $post['item_id'] = $visit['bed_id'];
        //     $post['item_cost'] = $bed['bed_cost'];
        //     $post['item_name'] = $bed['floor']." этаж ".$bed['ward']." палата ".$bed['bed']." койка";
        //     $object = Mixin\insert('visit_price', $post);
        //     if (!intval($object)) {
        //         $this->error($object);
        //     }
        // }
    }

    public function delete(int $pk)
    {
    //     global $db;
    //     if (empty($_GET['type'])) {
            
    //         // Нахождение id визита
    //         $object_sel = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_OBJ);

    //         if ($object_sel->direction) {
    //             $db->beginTransaction();

    //             if ($object_sel->service_id == 1) {
    //                 // Удаляем все визиты внутри гланого визита

    //                 foreach ($db->query("SELECT vs.id FROM $this->table vs WHERE vs.id != $pk AND vs.user_id = $object_sel->user_id AND vs.direction IS NOT NULL AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i:%s') BETWEEN \"$object_sel->add_date\" AND \"IFNULL($object_sel->completed, CURRENT_TIMESTAMP())\")") as $value) {
    //                     $object = Mixin\delete($this->table, $value['id']);
    //                     if (!intval($object)) {
    //                         $this->error($object, 1);
    //                         $db->rollBack();
    //                     }
    //                     Mixin\delete('visit_price', $value['id'], 'visit_id');
    //                 }
    
    //                 // Удаляем главный визит
    //                 $object = Mixin\delete($this->table, $pk);
    //                 if (!intval($object)) {
    //                     $this->error($object, 1);
    //                     $db->rollBack();
    //                 }
    //                 Mixin\delete('visit_price', $pk, 'visit_id');
    //                 // Освобождаем койку
    //                 Mixin\update($this->table2, array('user_id' => null), $object_sel->bed_id);
    //                 // Обновляем статус
    //                 Mixin\update($this->_user, array('status' => null), $object_sel->user_id);
    
    //                 $success = 2;
    
    //             }else{
    
    //                 // Удаляем визит
    //                 $object = Mixin\delete($this->table, $pk);
    //                 if (!intval($object)) {
    //                     $this->error($object, 1);
    //                     $db->rollBack();
    //                 }
    //                 Mixin\delete('visit_price', $pk, 'visit_id');
    
    //                 // Обновляем статус
    //                 $status = $db->query("SELECT * FROM $this->table WHERE user_id = $object_sel->user_id AND completed IS NULL")->rowCount();
    //                 if($status <= 1){
    //                     if ($status == 0) {
    //                         Mixin\update($this->_user, array('status' => null), $object_sel->user_id);
    //                     }
    //                     $success = 2;
    //                 }else {
    //                     $success = 1;
    //                 }
    //             }

    //             $db->commit();
    //             $this->success($success);
    //         }else {
    //             $db->beginTransaction();
                
    //             // Удаляем визит
    //             $object = Mixin\delete($this->table, $pk);
    //             if (!intval($object)) {
    //                 $this->error($object, 1);
    //                 $db->rollBack();
    //             }
    //             Mixin\delete('visit_price', $pk, 'visit_id');

    //             // Обновляем статус
    //             $status = $db->query("SELECT * FROM $this->table WHERE user_id = $object_sel->user_id AND completed IS NULL")->rowCount();
    //             if($status <= 1){
    //                 if ($status == 0) {
    //                     Mixin\update($this->_user, array('status' => null), $object_sel->user_id);
    //                 }
    //                 $success = 2;
    //             }else {
    //                 $success = 1;
    //             }
    //             $db->commit();
    //             $this->success($success);
    //         }

    //     }else {
    //         $object = Mixin\update($this->table, array('status' => 5), $pk);
    //         $this->success(1);
    //     }

    }

    public function is_update(int $pk)
    {
        global $db;
        $user = $db->query("SELECT user_id FROM $this->table WHERE id = $pk")->fetchColumn();
        $data = $db->query("SELECT * FROM $this->_service WHERE visit_id = $pk AND status NOT IN(6,7)")->rowCount();

        if ($data == 0) {

            $object = Mixin\update($this->table, array('completed' => date("Y-m-d H:i:s")), $pk);
            if(!intval($object)){
                return $object;
            }
            $this->status_update($user);
            return null;

        } else {
            return $data;
        }
        
    }

    public function is_delete(int $pk)
    {
        global $db;
        $user = $db->query("SELECT user_id FROM $this->table WHERE id = $pk")->fetchColumn();
        $data = $db->query("SELECT * FROM $this->_service WHERE visit_id = $pk")->rowCount();
        $data_update = $db->query("SELECT * FROM $this->_service WHERE visit_id = $pk AND status IN(1,2,3,5)")->rowCount();

        if ($data == 0) {

            $object = Mixin\delete($this->table, $pk);
            if(!intval($object)){
                return $object;
            }
            $this->status_update($user);
            return null;

        } else {

            if ($data_update == 0) {
                $object = Mixin\update($this->table, array('completed' => date("Y-m-d H:i:s")), $pk);
                if(!intval($object)){
                    return $object;
                }
                $this->status_update($user);
            }
            return $data;
        }
        
    }

    public function status_update($user)
    {
        return (new UserModel())->update_status($user);
    }

    public function success($stat=null)
    {
        if ($stat == 2) {
            echo '<div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>';
        }elseif ($stat == 1) {
            echo 1;
        }else {
            $_SESSION['message'] = '
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>
            ';
            render();
        }
    }

    public function error($message, $stat=null)
    {
        if ($stat) {
            echo '
            <div class="alert bg-danger alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold"> '.$message.'</span>
            </div>
            ';
        } else {
            $_SESSION['message'] = '
            <div class="alert bg-danger alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold"> '.$message.'</span>
            </div>
            ';
            render();
        }
    }
}

?>
