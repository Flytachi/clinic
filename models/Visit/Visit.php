<?php

class VisitModel extends Model
{
    public $table = 'visit';
    public $table1 = 'users';
    public $table2 = 'beds';

    public function form_out($pk = null)
    {
        global $db;
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="0">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <select data-placeholder="Выбрать пациента" name="user_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT DISTINCT us.id, us.status, vs.user_id 'stationar' FROM users us LEFT JOIN visit vs ON(vs.user_id = us.id AND direction IS NOT NULL AND (completed IS NULL OR priced_date IS NULL)) WHERE us.user_level = 15 ORDER BY us.id DESC") as $row): ?>
                            <?php if ($row['stationar']): ?>
                                <option value="<?= $row['id'] ?>" disabled><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?> <?= ($row['status']) ? "---(стационар лечится)---" : "---(стационар оплачивается)---" ?></option>
                            <?php else: ?>
                                <option value="<?= $row['id'] ?>"><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?> <?= ($row['status']) ? "---(лечится)---" : "" ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Направитель:</label>
                    <select data-placeholder="Выберите направителя" name="guide_id" class="form-control form-control-select2" data-fouc>
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
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <optgroup label="Врачи">
                        <?php foreach ($db->query("SELECT * from division WHERE level = 5") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <?php if(module('module_diagnostic')): ?>
                        <optgroup label="Диогностика">
                            <?php foreach ($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                    <?php if(module('module_laboratory')): ?>
                        <optgroup label="Лаборатория">
                            <?php foreach ($db->query("SELECT * from division WHERE level = 6") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                    <optgroup label="Остальные">
                        <?php foreach ($db->query("SELECT * from division WHERE level IN (12, 13) AND (assist IS NULL OR assist = 1)") as $row): ?>
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
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
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
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
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

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
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
        global $db;
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group row">
                <div class="col-md-6">
                    <label>Направитель:</label>
                    <select data-placeholder="Выберите направителя" name="guide_id" class="form-control form-control-select2">
                        <option></option>
                        <?php foreach ($db->query("SELECT * from guides ORDER BY name") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($post['guide_id'] == $row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function form_sta($pk = null)
    {
        global $db, $FLOOR;
        if($_SESSION['message']){
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

                <div class="col-md-5">
                    <label>Пациент:</label>
                    <select data-placeholder="Выбрать пациента" name="user_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM users WHERE user_level = 15 ORDER BY id DESC") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($row['status']) ? "disabled" : "" ?>><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?> <?= ($row['status']) ? "---(лечится)---" : "" ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Этаж:</label>
                    <select data-placeholder="Выбрать этаж" name="" id="floor" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php foreach ($FLOOR as $key => $value): ?>
                            <?php if ($db->query("SELECT id FROM wards WHERE floor = $key")->rowCount() != 0): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php else: ?>
                                <option value="<?= $key ?>" disabled><?= $value ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Палата:</label>
                    <select data-placeholder="Выбрать палату" name="" id="ward" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT ws.id, ws.floor, ws.ward FROM wards ws") as $row): ?>
                            <?php if ($db->query("SELECT id FROM beds WHERE ward_id = {$row['id']}")->rowCount() != 0): ?>
                                <option value="<?= $row['id'] ?>" data-chained="<?= $row['floor'] ?>"><?= $row['ward'] ?> палата</option>
                            <?php else: ?>
                                <option value="<?= $row['id'] ?>" data-chained="<?= $row['floor'] ?>" disabled><?= $row['ward'] ?> палата</option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Койка:</label>
                    <select data-placeholder="Выбрать койку" name="bed" id="bed" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query('SELECT bd.*, bdt.price, bdt.name from beds bd LEFT JOIN bed_type bdt ON(bd.types=bdt.id)') as $row): ?>
                            <?php if ($row['user_id']): ?>
                                <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-price="<?= $row['price'] ?>" data-name="<?= $row['name'] ?>" disabled><?= $row['bed'] ?> койка (<?= ($db->query("SELECT gender FROM users WHERE id = {$row['user_id']}")->fetchColumn()) ? "Male" : "Female" ?>)</option>
                            <?php else: ?>
                                <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-price="<?= $row['price'] ?>" data-name="<?= $row['name'] ?>"><?= $row['bed'] ?> койка</option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from division WHERE level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id" class="form-control form-control-select2" required data-fouc>
                        <?php
                        foreach($db->query('SELECT * from users WHERE user_level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label>Направитель:</label>
                    <select data-placeholder="Выберите направителя" name="guide_id" class="form-control form-control-select2" data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT * from guides") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- <div class="form-group row">
                <div class="col-md-12">
                    <label>Жалоба:</label>
                    <textarea class="form-control" name="complaint" rows="2" cols="2" placeholder="Жалоба"></textarea>
                </div>
            </div> -->

            <div class="text-right">
                <button type="submit" onclick="submitAlert()" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#ward").chained("#floor");
                $("#bed").chained("#ward");
                $("#parent_id").chained("#division_id");
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
        global $db, $FLOOR, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="bed_stat" value="1">
            <input type="hidden" name="id" value="<?= $patient->visit_id ?>">

            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Этаж:</label>
                    <div class="col-lg-9">
                        <select data-placeholder="Выбрать этаж" name="" id="floor" class="form-control form-control-select2" required data-fouc>
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
                        <select data-placeholder="Выбрать палату" name="" id="ward" class="form-control form-control-select2" required data-fouc>
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
                        <select data-placeholder="Выбрать койку" name="bed_id" id="bed" class="form-control select-price" required data-fouc>
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
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
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

    public function save()
    {
        global $db;
        if($this->clean()){

            if ($this->post['direction']) {
                $object1 = Mixin\update($this->table2, array('user_id' => $this->post['user_id']), $this->post['bed']);
                if (!intval($object1)){
                    $this->error($object1);
                }
                $this->post['bed_id'] = $this->post['bed'];
                unset($this->post['bed']);
                $this->post['service_id'] = 1;
            }
            $this->post['grant_id'] = $this->post['parent_id'];
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
            }
            if (!$this->post['direction'] or (!permission([2, 32]) and $this->post['direction'])) {
                $service = $db->query("SELECT price, name FROM service WHERE id = {$this->post['service_id']}")->fetch();
                $post['visit_id'] = $object;
                $post['user_id'] = $this->post['user_id'];
                $post['item_type'] = 1;
                $post['item_id'] = $this->post['service_id'];
                $post['item_cost'] = $service['price'];
                $post['item_name'] = $service['name'];
                $object = Mixin\insert('visit_price', $post);
                if (!intval($object)){
                    $this->error($object);
                }
            }
            // Обновление статуса у пациента
            $object1 = Mixin\update($this->table1, array('status' => True), $this->post['user_id']);
            if (intval($object1)){
                $this->success();
            }else {
                $this->error($object1);
            }

        }
    }

    public function save_rows()
    {
        global $db;
        foreach ($this->post['service'] as $key => $value) {

            $post_big['direction'] = $this->post['direction'];
            $post_big['route_id'] = $this->post['route_id'];
            $post_big['user_id'] = $this->post['user_id'];
            $post_big['guide_id'] = $this->post['guide_id'];
            $post_big['complaint'] = $this->post['complaint'];
            $post_big['service_id'] = $value;
            $post_big['division_id'] = $this->post['division_id'][$key];
            $level_divis = $db->query("SELECT level FROM division WHERE id = {$post_big['division_id']}")->fetchColumn();
            if ($level_divis == 12) {
                $post_big['physio'] = True;
            }elseif ($level_divis == 13) {
                $post_big['manipulation'] = True;
            }elseif ($level_divis == 10) {
                $post_big['diagnostic'] = True;
            }elseif ($level_divis == 6) {
                $post_big['laboratory'] = True;
            }
            $post_big['parent_id'] = $this->post['parent_id'][$key];
            $post_big['grant_id'] = $post_big['parent_id'];
            for ($i=0; $i < $this->post['count'][$key]; $i++) {
                $post_big = Mixin\clean_form($post_big);
                $post_big = Mixin\to_null($post_big);
                $object = Mixin\insert($this->table, $post_big);
                if (!intval($object)){
                    $this->error($object);
                }

                if (!$post_big['direction'] or (!permission([2, 32]) and $post_big['direction'])) {
                    $service = $db->query("SELECT price, name FROM service WHERE id = $value")->fetch();
                    $post['visit_id'] = $object;
                    $post['user_id'] = $this->post['user_id'];
                    $post['item_type'] = 1;
                    $post['item_id'] = $value;
                    $post['item_cost'] = $service['price'];
                    $post['item_name'] = $service['name'];
                    $object = Mixin\insert('visit_price', $post);
                    if (!intval($object)){
                        $this->error($object);
                    }
                }
            }
            unset($post_big);
        }
        // Обновление статуса у пациента
        $object1 = Mixin\update($this->table1, array('status' => True), $this->post['user_id']);
        if (!intval($object1)){
            $this->error($object1);
        }
        $this->success();
    }

    public function clean()
    {
        global $db;
        if ($this->post['bed_stat']) {
            $this->bed_edit();
        }
        if (is_array($this->post['service'])) {
            $this->save_rows();
        }
        if ($this->post['division_id']) {
            $stat = $db->query("SELECT * FROM division WHERE id={$this->post['division_id']} AND level=6")->fetch();
            if ($stat) {
                $this->post['laboratory'] = True;
            }
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function bed_edit()
    {
        global $db;
        unset($this->post['bed_stat']);
        $visit = $db->query("SELECT * FROM visit WHERE id = {$this->post['id']}")->fetch();
        $this->bed_price($visit);
        $this->change_beds($visit);
        $this->update();
    }

    public function change_beds($visit)
    {
        global $db;
        $bed_old = $db->query("SELECT * FROM beds WHERE id = {$visit['bed_id']}")->fetch();
        $bed_new = $db->query("SELECT * FROM beds WHERE id = {$this->post['bed_id']}")->fetch();
        $bed_old['user_id'] = null;
        $bed_new['user_id'] = $visit['user_id'];
        $object = Mixin\insert_or_update('beds', $bed_old);
        if (!intval($object)) {
            $this->error($object);
        }
        $object = Mixin\insert_or_update('beds', $bed_new);
        if (!intval($object)) {
            $this->error($object);
        }
    }

    public function bed_price($visit)
    {
        global $db;
        $sql = "SELECT wd.floor,
                    wd.ward, bd.bed,
                    ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), IFNULL(vp.add_date, vs.add_date)), '%H')) * (bdt.price / 24) 'bed_cost'
                FROM visit vs
                    LEFT JOIN beds bd ON(bd.id=vs.bed_id)
                    LEFT JOIN wards wd ON(wd.id=bd.ward_id)
                    LEFT JOIN bed_type bdt ON(bdt.id=bd.types)
                    LEFT JOIN visit_price vp ON(vp.visit_id=vs.id AND vp.item_type = 101)
                WHERE vs.id = {$visit['id']} ORDER BY vp.add_date DESC";
        $bed = $db->query($sql)->fetch();
        if ($bed['bed_cost'] > 0) {
            $post['visit_id'] = $visit['id'];
            $post['user_id'] = $visit['user_id'];
            $post['status'] = 0;
            $post['item_type'] = 101;
            $post['item_id'] = $visit['bed_id'];
            $post['item_cost'] = $bed['bed_cost'];
            $post['item_name'] = $bed['floor']." этаж ".$bed['ward']." палата ".$bed['bed']." койка";
            $object = Mixin\insert('visit_price', $post);
            if (!intval($object)) {
                $this->error($object);
            }
        }
    }

    public function delete(int $pk)
    {
        global $db;
        if (!$_GET['type']) {

            // Нахождение id визита
            $object_sel = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_OBJ);

            if ($object_sel->direction) {
                $db->beginTransaction();

                if ($object_sel->service_id == 1) {
                    // Удаляем все визиты внутри гланого визита

                    foreach ($db->query("SELECT vs.id FROM $this->table vs WHERE vs.id != $pk AND vs.direction IS NOT NULL AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i:%s') BETWEEN \"$object_sel->add_date\" AND \"IFNULL($object_sel->completed, CURRENT_TIMESTAMP())\")") as $value) {
                        $object = Mixin\delete($this->table, $value['id']);
                        if (!intval($object)) {
                            $this->error($object, 1);
                            $db->rollBack();
                        }
                        Mixin\delete('visit_price', $value['id'], 'visit_id');
                    }
    
                    // Удаляем главный визит
                    $object = Mixin\delete($this->table, $pk);
                    if (!intval($object)) {
                        $this->error($object, 1);
                        $db->rollBack();
                    }
                    Mixin\delete('visit_price', $pk, 'visit_id');
                    // Освобождаем койку
                    Mixin\update($this->table2, array('user_id' => null), $object_sel->bed_id);
                    // Обновляем статус
                    Mixin\update($this->table1, array('status' => null), $object_sel->user_id);
    
                    $success = 2;
    
                }else{
    
                    // Удаляем визит
                    $object = Mixin\delete($this->table, $pk);
                    if (!intval($object)) {
                        $this->error($object, 1);
                        $db->rollBack();
                    }
                    Mixin\delete('visit_price', $pk, 'visit_id');
    
                    // Обновляем статус
                    $status = $db->query("SELECT * FROM $this->table WHERE user_id = $object_sel->user_id AND priced_date IS NULL AND completed IS NULL")->rowCount();
                    if(!$status){
                        Mixin\update($this->table1, array('status' => null), $object_sel->user_id);
                        $success = 2;
                    }else {
                        $success = 1;
                    }
                }

                $db->commit();
                $this->success($success);
            }else {
                $db->beginTransaction();
                
                // Удаляем визит
                $object = Mixin\delete($this->table, $pk);
                if (!intval($object)) {
                    $this->error($object, 1);
                    $db->rollBack();
                }
                Mixin\delete('visit_price', $pk, 'visit_id');

                // Обновляем статус
                $status = $db->query("SELECT * FROM $this->table WHERE user_id = $object_sel->user_id AND priced_date IS NULL AND completed IS NULL")->rowCount();
                if(!$status){
                    Mixin\update($this->table1, array('status' => null), $object_sel->user_id);
                    $success = 2;
                }else {
                    $success = 1;
                }

                $db->commit();
                $this->success($success);
            }

        }else {
            $object = Mixin\update($this->table, array('status' => 5), $pk);
            $this->success(1);
        }

        
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
