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
                        <?php foreach ($db->query("SELECT * FROM users WHERE user_level = 15 ORDER BY id DESC") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?> <?= ($row['status']) ? "---(лечится)---" : "" ?></option>
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
                    <optgroup label="Диогностика">
                        <?php foreach ($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Лаборатория">
                        <?php foreach ($db->query("SELECT * from division WHERE level = 6") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
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
                $post_big['physio'] = 1;
            }elseif ($level_divis == 13) {
                $post_big['manipulation'] = 1;
            }
            $post_big['parent_id'] = $this->post['parent_id'][$key];
            $post_big['grant_id'] = $post_big['parent_id'];
            $stat = $db->query("SELECT * FROM division WHERE id={$post_big['division_id']} AND level=6")->fetch();
            if ($stat) {
                $post_big['laboratory'] = True;
            }
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
        // Нахождение id визита
        $object_sel = $db->query("SELECT vs.*, vp.id 'vp_id' FROM $this->table vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id) WHERE vs.id = $pk")->fetch(PDO::FETCH_OBJ);
        $object = Mixin\delete($this->table, $pk);
        $object1 = Mixin\delete('visit_price', $object_sel->vp_id);
        if (!intval($object)) {
            $this->error($object, 1);
        }
        if (intval($object)) {
            $status = $db->query("SELECT * FROM $this->table WHERE user_id = $object_sel->user_id AND priced_date IS NULL AND completed IS NULL")->rowCount();
            if(!$status){
                Mixin\update($this->table1, array('status' => null), $object_sel->user_id);
                $this->success(2);
            }else {
                $this->success(1);
            }
        } else {
            $this->error($object, 1);
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

class VisitPriceModel extends Model
{
    public $table = 'visit_price';
    public $table1 = 'visit';
    public $table2 = 'investment';

    public function form($pk = null)
    {
        global $db;
        ?>
        <form method="post" action="<?= add_url() ?>" onsubmit="Submit_alert()">

            <div class="modal-body">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="pricer_id" value="<?= $_SESSION['session_id'] ?>">
                <input type="hidden" name="user_id" id="user_amb_id">

                <div class="form-group row">

                    <div class="col-md-9">
                        <label class="col-form-label">Сумма к оплате:</label>
                        <input type="text" class="form-control" id="total_price" disabled>
                        <input type="hidden" id="total_price_original">
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Скидка:</label>
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="number" class="form-control" step="0.1" name="sale" id="sale_input" placeholder="">
                            <div class="form-control-feedback text-success">
                                <span style="font-size: 20px;">%</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Наличный</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="price_cash" id="input_chek_1" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="form-control-switchery" data-fouc id="chek_1" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Пластиковый</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="price_card" id="input_chek_2" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="form-control-switchery" data-fouc id="chek_2" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Перечисление</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="price_transfer" id="input_chek_3" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="form-control-switchery" data-fouc id="chek_3" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-outline-info btn-sm">Печать</button>
            </div>

        </form>

        <script type="text/javascript">

            function Submit_alert() {
                event.preventDefault();
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        var result = JSON.parse(result);
                        if (result.status == "success") {

                            var parent_id = document.querySelectorAll('.parent_class');

                            let par_id;

                            parent_id.forEach(function(events) {
                                let obj = JSON.stringify({ type : 'alert_new_patient',  id : $(events).val(), message: "У вас новый амбулаторный пациент!" });

                                par_id = $(events).val()

                                conn.send(obj);
                            });
                                let obj1 = JSON.stringify({ type : 'new_patient',  id : "1983", user_id : $('#user_amb_id').val() , parent_id : par_id});

                                conn.send(obj1);


                                // Печать:
                                if ("<?= $_SESSION['browser'] ?>" == "Firefox") {
                                    $.ajax({
                                        type: "GET",
                                        url: result.val,
                                        success: function (data) {
                                            let ww = window.open();
                                            ww.document.write(data);
                                            ww.focus();
                                            ww.print();
                                            ww.close();
                                        },
                                    });
                    			}else {
                                    let we = window.open(result.val,'mywindow');
                                    setTimeout(function() {we.close()}, 100);
                    			}

                        }
                        sessionStorage['message'] = result.message;
                        setTimeout( function() {
                                location.reload();
                            }, 1000)
                    },
                });
            }

            function Checkert(event) {
                var input = $('#input_'+event.id);
                if(!input.prop('disabled')){
                    input.attr("disabled", "disabled");
                    Downsum(input);
                }else {
                    input.removeAttr("disabled");
                    Upsum(input);
                }
            }

            $("#sale_input").keyup(function() {
                var sum = $("#total_price_original").val();
                var proc = $("#sale_input").val() / 100;
                $("#total_price").val(sum - (sum * proc));
            });

        </script>
        <?php
    }

    public function form_button($pk = null)
    {
        global $pk, $pk_visit, $completed, $price, $price_cost;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="pricer_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="user_id" value="<?= $pk ?>">
            <input type="hidden" name="bed_cost" value="<?= $price['cost_bed'] ?>">
            <button onclick="SaleCheck(<?= $pk ?>)" type="button" class="btn btn-outline-secondary btn-sm">Скидка</button>
            <button onclick="Invest(1)" type="button" data-name="Разница" data-balance="<?= number_format($price['balance'] + $price_cost) ?>" class="btn btn-outline-success btn-sm">Предоплата</button>
            <button onclick="Invest(0)" type="button" data-name="Баланс" data-balance="<?= number_format($price['balance']) ?>" class="btn btn-outline-danger btn-sm">Возврат</button>
            <button onclick="Proter('<?= $pk_visit ?>')" type="button" class="btn btn-outline-warning btn-sm" <?= ($completed) ? "" : "disabled" ?>>Расщёт</button>
            <button onclick="Detail('<?= viv('cashbox/get_detail')."?pk=".$pk?>')" type="button" class="btn btn-outline-primary btn-sm" data-show="1">Детально</button>
        </form>
        <script type="text/javascript">

            function printdiv(printpage) {
                var printContents = document.getElementById(printpage).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }

            function SaleCheck(pk){
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('cashbox_sale_table') ?>",
                    data: {pk:pk},
                    success: function (result) {
                        swal({
                            type: 'warning',
                            html: result,
                        });
                    }
                });
            }

            function Proter(pk) {
                event.preventDefault();

                if (Math.round($('#prot_item').val()) != 0) {

                    if ($('#prot_item').val() < 0) {
                        var text = "Нехватка средств!";
                    }else {
                        var text = "Верните пациенту деньги!";
                    }
                    new Noty({
                        text: text,
                        type: 'error'
                    }).show();

                }else {
                    $.ajax({
                        type: $('#<?= __CLASS__ ?>_form').attr("method"),
                        url: $('#<?= __CLASS__ ?>_form').attr("action"),
                        data: $('#<?= __CLASS__ ?>_form').serializeArray(),
                        success: function (result) {
                            // alert(result);
                            var result = JSON.parse(result);

                            if (result.status == "success") {
                                // Выдача выписки
                                var url = "<?= viv('prints/document_3') ?>?id="+pk;
                                Print(url);
                                // Перезагрузка
                                sessionStorage['message'] = result.message;
                                setTimeout( function() {
                                        location.reload();
                                    }, 1000)
                            }else {
                                $('#check_div').html(result.message);
                            }

                        },
                    });
                }
            }

        </script>
        <?php
    }

    public function clean()
    {
        global $db;
        $this->user_pk = $this->post['user_id'];
        unset($this->post['user_id']);
        if (isset($this->post['bed_cost'])) {
            $this->bed_cost = $this->post['bed_cost'];
            unset($this->post['bed_cost']);
            return True;
        } else {
            $tot = $db->query("SELECT SUM(vp.item_cost) 'total_price' FROM $this->table1 vs LEFT JOIN $this->table vp ON(vp.visit_id=vs.id) WHERE vs.priced_date IS NULL AND vs.user_id = $this->user_pk")->fetch();
            if ($this->post['sale'] > 0) {
                $tot['total_price'] = $tot['total_price'] - ($tot['total_price'] * ($this->post['sale'] / 100));
            }
            $result = $tot['total_price'] - ($this->post['price_cash'] + $this->post['price_card'] + $this->post['price_transfer']);
        }
        if ($result < 0) {
            $this->error("Есть остаток ".$result);
        }elseif ($result > 0) {
            $this->error("Недостаточно средств! ". $result);
        }else {
            $this->post = Mixin\clean_form($this->post);
            $this->post = Mixin\to_null($this->post);
            $this->status = ($this->post['bed_cost']) ? null : 1;
            return True;
        }
    }

    public function price($row, $status)
    {
        global $db;
        $post = array(
            'pricer_id' => $this->post['pricer_id'],
            'sale' => $this->post['sale'],
            'price_date' => date("Y-m-d H:i"),
            'status' => $status
        );
        if ($this->post['price_cash'])
        {
            if ($this->post['price_cash'] >= $row['item_cost']) {
                $this->post['price_cash'] -= $row['item_cost'];
                $post['price_cash'] = $row['item_cost'];
            }else {
                $post['price_cash'] = $this->post['price_cash'];
                $this->post['price_cash'] = 0;
                $temp = round($row['item_cost'] - $post['price_cash']);
                if ($this->post['price_card'] >= $temp) {
                    $this->post['price_card'] -= $temp;
                    $post['price_card'] = $temp;
                }else {
                    $post['price_card'] = $this->post['price_card'];
                    $this->post['price_card'] = 0;
                    $temp = round($temp - $post['price_card']);
                    if ($this->post['price_transfer'] >= $temp) {
                        $this->post['price_transfer'] -= $temp;
                        $post['price_transfer'] = $temp;
                    }else {
                        $this->error("Ошибка в price transfer");
                    }
                }
            }
        }
        elseif ($this->post['price_card'])
        {
            if ($this->post['price_card'] >= $row['item_cost']) {
                $this->post['price_card'] -= $row['item_cost'];
                $post['price_card'] = $row['item_cost'];
            }else {
                $post['price_card'] = $this->post['price_card'];
                $this->post['price_card'] = 0;
                $temp = round($row['item_cost'] - $post['price_card']);
                if ($this->post['price_transfer'] >= $temp) {
                    $this->post['price_transfer'] -= $temp;
                    $post['price_transfer'] = $temp;
                }else {
                    $this->error("Ошибка в price transfer");
                }
            }
        }
        else
        {
            if ($this->post['price_transfer'] >= $row['item_cost']) {
                $this->post['price_transfer'] -= $row['item_cost'];
                $post['price_transfer'] = $row['item_cost'];
            }else {
                $this->error("Ошибка в price transfer");
            }
        }

        $object = Mixin\update($this->table1, array('status' => $this->status, 'priced_date' => date('Y-m-d H:i:s')), $row['visit_id']);
        if (!intval($object)){
            $this->error($object);
        }
        $object = Mixin\update($this->table, $post, $row['id']);
        if (!intval($object)){
            $this->error($object);
        }
    }

    public function ambusclor_price()
    {
        global $db;
        foreach ($db->query("SELECT vp.id, vs.id 'visit_id', vp.item_cost, vp.item_name FROM $this->table1 vs LEFT JOIN $this->table vp ON(vp.visit_id=vs.id) WHERE vs.priced_date IS NULL AND vs.user_id = $this->user_pk ORDER BY vp.item_cost") as $row) {
            $this->items[] = $row['id'];
            if ($this->post['sale'] > 0) {
                $row['item_cost'] = $row['item_cost'] - ($row['item_cost'] * ($this->post['sale'] / 100));
            }
            $this->price($row, 1);
        }
    }

    public function stationar_price()
    {
        global $db;
        $balance = $db->query("SELECT SUM(balance_cash) 'balance_cash', SUM(balance_card) 'balance_card', SUM(balance_transfer) 'balance_transfer' FROM $this->table2 WHERE user_id = $this->user_pk")->fetch();
        if ($balance['balance_cash'] < 0 or $balance['balance_card'] < 0 or $balance['balance_transfer'] < 0) {
            $this->error("Критическая ошибка!");
            exit;
        }
        $this->add_bed();
        $this->post['sale'] = null;
        if ($balance['balance_cash'] != 0) {
            $this->post['price_cash'] = $balance['balance_cash'];
        }
        if ($balance['balance_card'] != 0) {
            $this->post['price_card'] = $balance['balance_card'];
        }
        if ($balance['balance_transfer'] != 0) {
            $this->post['price_transfer'] = $balance['balance_transfer'];
        }
        foreach ($db->query("SELECT vp.id, vs.id 'visit_id', vp.operation_id, vp.item_id, vp.item_cost, vp.item_name FROM $this->table1 vs LEFT JOIN $this->table vp ON(vp.visit_id=vs.id) WHERE vs.priced_date IS NULL AND vs.user_id = $this->user_pk ORDER BY vp.item_cost") as $row) {
            if ($row['operation_id']) {
                Mixin\update('operation', array('priced_date' => date('Y-m-d H:i:s')), $row['operation_id']);
                unset($row['operation_id']);
            }
            $this->price($row, 0);
        }
        $this->up_invest();
        Mixin\update($this->table1, array('status' => null), $this->ti);
    }

    public function add_bed()
    {
        global $db;
        $ti = $db->query("SELECT * FROM $this->table1 WHERE user_id = $this->user_pk AND service_id = 1 AND priced_date IS NULL AND completed IS NOT NULL")->fetch();
        $this->ti = $ti['id'];
        $bed = $db->query("SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.id = {$ti['bed_id']}")->fetch();
        $post['visit_id'] = $ti['id'];
        $post['user_id'] = $this->user_pk;
        $post['pricer_id'] = $this->post['pricer_id'];
        $post['status'] = 0;
        $post['item_type'] = 101;
        $post['item_id'] = $ti['bed_id'];
        $post['item_name'] = $bed['floor']." этаж ".$bed['ward']." палата ".$bed['bed']." койка";
        $post['item_cost'] = $this->bed_cost;
        $object = Mixin\insert($this->table, $post);
        if (!intval($object)) {
            $this->error($object);
        }
    }

    public function up_invest()
    {
        global $db;
        foreach ($db->query("SELECT * FROM $this->table2 WHERE user_id = $this->user_pk") as $row) {
            $object = Mixin\update($this->table2, array('status' => null), $row['id']);
            if (!intval($object)){
                $this->error($object);
            }
        }
        Mixin\update('users', array('status' => null), $this->user_pk);
    }

    public function save()
    {
        global $db;
        if($this->clean()){

            $db->beginTransaction();
            if (isset($this->bed_cost)) {
                $this->stationar_price();
            }else {
                $this->ambusclor_price();
            }
            $db->commit();
            $this->success();

        }
    }

    public function success()
    {
        $value = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        if (isset($this->bed_cost)) {
            echo json_encode(array(
                'status' => "success",
                'message' => $value
            ));
        }else {
            echo json_encode(array(
                'status' => "success" ,
                'message' => $value,
                'val' => viv('prints/check')."?id=".$this->user_pk."&items=".json_encode($this->items)
            ));
        }
    }

    public function error($message)
    {
        $value = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold">'.$message.'</span>
        </div>
        ';
        echo json_encode(array(
            'status' => "error" ,
            'message' => $value
        ));
        exit;
    }

}

class VisitInspectionModel extends Model
{
    public $table = 'visit_inspection';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <!-- The toolbar will be rendered in this container. -->
                <div id="toolbar-container"></div>

                <!-- This container will become the editable. -->
                <div id="editor"></div>

                <textarea id="tickets-editor" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm" id="submit_insp">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            DecoupledEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                    const toolbarContainer = document.querySelector( '#toolbar-container' );

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                    editor.model.document.on( 'change:data', ( evt, data ) => {
                        console.log( data );
                        $('textarea#tickets-editor').html( editor.getData() );
                    } );
                } )
                .catch( error => {
                    console.error( error );
                } );

              document.getElementById( 'submit_insp' ).onclick = () => {
                  textarea.value = editor.getData();
              }
        </script>
        <?php
    }

    public function clean()
    {
        if (empty($this->post['report'])) {
            unset($this->post['report']);
        }else {
            $report = $this->post['report'];
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if ($report) {
            $this->post['report'] = $report;
        }
        return True;
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }
}

class VisitAnalyzeModel extends Model
{
    public $table = 'visit_analyze';

    public function table_form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        $pat = $db->query("SELECT gender FROM users WHERE id = {$_GET['id']}")->fetch();
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="user_id" value="<?= $_GET['id'] ?>">
            <input type="hidden" id="input_end" name="end"></input>
            <input type="hidden" id="division_end" name="division_end"></input>

            <div class="modal-body">

                <div class="text-right" style="margin-bottom:10px;">
                    <button type="button" onclick="Proter_lab()" class="btn btn-outline-danger btn-sm">Завершить все</button>
                    <button type="submit" id="btn_submit" class="btn btn-outline-info btn-sm">Сохранить все</button>
                </div>

                <div id="modal_message">
                </div>

				<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">

                    <?php foreach ($db->query("SELECT DISTINCT ds.id, ds.title FROM visit vs LEFT JOIN division ds ON(ds.id=vs.division_id) WHERE vs.completed IS NULL AND vs.laboratory IS NOT NULL AND vs.status = 2 AND vs.user_id = {$_GET['id']} ORDER BY ds.title ASC") as $tb => $tab): ?>
                        <li class="nav-item"><a href="#laboratory_tab-<?= $tab['id'] ?>" class="nav-link legitRipple <?= ($tb === 0) ? "active" : "" ?>" data-toggle="tab"><?= $tab['title'] ?></a></li>
                    <?php endforeach; ?>

				</ul>

                <div class="tab-content">

                    <?php $i=0; foreach ($db->query("SELECT DISTINCT ds.id FROM visit vs LEFT JOIN division ds ON(ds.id=vs.division_id) WHERE vs.completed IS NULL AND vs.laboratory IS NOT NULL AND vs.status = 2 AND vs.user_id = {$_GET['id']} ORDER BY ds.title ASC") as $tab): ?>
                        <div class="tab-pane fade <?= (empty($s)) ? "show active" : "" ?>" id="laboratory_tab-<?= $tab['id'] ?>">

                            <div class="table-responsive">
                                <table class="table table-hover table-sm table-bordered">
                                    <thead>
                                        <tr class="bg-info">
                                            <th style="width:3%">№</th>
                                            <th>Название услуги</th>
                                            <th>Код</th>
                                            <th>Анализ</th>
                                            <th style="width:10%">Норма</th>
                                            <th style="width:10%">Результат</th>
                                            <th class="text-center" style="width:10%">Отклонение</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($db->query("SELECT vs.id, vs.service_id, sc.name FROM visit vs LEFT JOIN service sc ON (sc.id=vs.service_id) WHERE vs.completed IS NULL AND vs.laboratory IS NOT NULL AND vs.status = 2 AND vs.user_id = {$_GET['id']} AND vs.division_id = {$tab['id']} ORDER BY vs.add_date ASC") as $row_parent): ?>
                                            <?php $norm = "scl.name, scl.code, scl.standart"; $s = 1; ?>
                                            <tr>
                                                <th colspan="9" class="text-center"><?= $row_parent['name'] ?></th>
                                            </tr>
                                            <?php foreach ($db->query("SELECT vl.id, vl.result, vl.deviation, scl.id 'analyze_id', $norm, sc.name 'ser_name' FROM service_analyze scl LEFT JOIN service sc ON(scl.service_id=sc.id) LEFT JOIN visit_analyze vl ON(vl.user_id={$_GET['id']} AND vl.analyze_id=scl.id AND vl.visit_id ={$row_parent['id']}) WHERE scl.service_id = {$row_parent['service_id']}") as $row): ?>
                                                <tr id="TR_<?= $i ?>" class="<?= ($row['deviation']) ? "table-danger" : "" ?>">
                                                    <td><?= $s++ ?></td>
                                                    <td><?= $row['ser_name'] ?></td>
                                                    <td><?= $row['code'] ?></td>
                                                    <td><?= $row['name'] ?></td>
                                                    <td>
                                                        <?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="<?= $i ?>[id]" value="<?= $row['id'] ?>">
                                                        <input type="hidden" name="<?= $i ?>[analyze_id]" value="<?= $row['analyze_id'] ?>">
                                                        <input type="hidden" name="<?= $i ?>[visit_id]" value="<?= $row_parent['id'] ?>">
                                                        <input type="text" class="form-control result_check" name="<?= $i ?>[result]" value="<?= $row['result'] ?>">
                                                    </td>
                                                    <td>
                                                        <div class="list-icons">
                                                            <label class="form-check-label">
                                                                <input data-id="TR_<?= $i ?>" type="checkbox" class="swit bg-danger cek_a" name="<?= $i ?>[deviation]" <?= ($row['deviation']) ? "checked" : "" ?>>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-right" style="margin-top:10px;">
                                <button type="button" onclick="Lab_one(<?= $tab['id'] ?>)" class="btn btn-outline-danger btn-sm">Завершить</button>
                            </div>

    					</div>
                    <?php endforeach; ?>

				</div>

            </div>

        </form>
        <script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>
        <script type="text/javascript">

            function Lab_one(id) {
                $('#input_end').val('Завершить');
                $('#division_end').val(id);
                $('#<?= __CLASS__ ?>_form').submit();
            }

            function Proter_lab() {
                swal({
                    position: 'top',
                    title: 'Внимание!',
                    text: 'Вы точно хотите завершить все анализы пациента?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Да'
                }).then(function(ivi) {
                    if (ivi.value) {
                        $('#input_end').val('Завершить');
                        $('#btn_submit').click();
                    }
                });
            }

            $('.cek_a').on('click', function(event) {
                if ($(this).is(':checked')) {
                    $('#'+this.dataset.id).addClass("table-danger");
                }else {
                    $('#'+this.dataset.id).removeClass("table-danger");
                }
            });

        </script>
        <?php
    }

    public function save()
    {
        global $db;
        $this->end = ($this->post['end']) ? true : false; unset($this->post['end']);
        $this->user_pk = $this->post['user_id']; unset($this->post['user_id']);
        $this->division_pk = $this->post['division_end']; unset($this->post['division_end']);
        $db->beginTransaction();
        $this->analize_save();
        $this->finish();

        $db->commit();
        $this->success();
    }

    public function analize_save()
    {
        global $db;
        foreach ($this->post as $val) {
            if ($val['id']) {
                $pk = $val['id']; unset($val['id']);
                $val['deviation'] = ($val['deviation']) ? 1 : null;

                $object = Mixin\update($this->table, $val, $pk);
            }else {
                $val['user_id'] = $this->user_pk; unset($val['id']);
                $val['deviation'] = ($val['deviation']) ? 1 : null;
                $val['service_id'] = $db->query("SELECT service_id FROM visit WHERE id = {$val['visit_id']}")->fetch()['service_id'];
                $object = Mixin\insert('visit_analyze', $val);
            }
            if (!intval($object)){
                $this->error($object);
            }
        }
    }

    public function finish()
    {
        global $db;
        if ($this->end) {
            if ($this->division_pk) {
                foreach ($db->query("SELECT id, grant_id, parent_id, direction FROM visit WHERE accept_date IS NOT NULL AND completed IS NULL AND laboratory IS NOT NULL AND status = 2 AND user_id = $this->user_pk AND division_id = $this->division_pk ORDER BY add_date ASC") as $row) {
                    if ($row['grant_id'] == $row['parent_id'] and 1 == $db->query("SELECT * FROM visit WHERE user_id=$this->user_pk AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount()) {
                        Mixin\update('users', array('status' => null), $this->user_pk);
                    }
                    $this->clear_post();
                    $this->set_table('visit');
                    $this->set_post(array(
                        'id' => $row['id'],
                        'status' => ($row['direction']) ? 0 : null,
                        'completed' => date('Y-m-d H:i:s')
                    ));
                    $this->update();
                }
            } else {
                foreach ($db->query("SELECT id, grant_id, parent_id, direction FROM visit WHERE accept_date IS NOT NULL AND completed IS NULL AND laboratory IS NOT NULL AND status = 2 AND user_id = $this->user_pk ORDER BY add_date ASC") as $row) {
                    if ($row['grant_id'] == $row['parent_id'] and 1 == $db->query("SELECT * FROM visit WHERE user_id=$this->user_pk AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount()) {
                        Mixin\update('users', array('status' => null), $this->user_pk);
                    }
                    $this->clear_post();
                    $this->set_table('visit');
                    $this->set_post(array(
                        'id' => $row['id'],
                        'status' => ($row['direction']) ? 0 : null,
                        'completed' => date('Y-m-d H:i:s')
                    ));
                    $this->update();
                }
            }

        }
    }

    public function update()
    {
        $pk = $this->post['id'];
        unset($this->post['id']);
        $object = Mixin\update($this->table, $this->post, $pk);
        if (!intval($object)){
            $this->error($object);
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

class VisitStatsModel extends Model
{
    public $table = 'visit_stats';

    public function form($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Состояние:</label>
                        <select placeholder="Введите состояние" name="stat" class="form-control form-control-select2">
                            <option value="">Актив</option>
                            <option value="1">Пассив</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Давление:</label>
                        <input type="text" class="form-control" name="pressure" placeholder="Введите давление">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-4">
                        <label>Пульс:</label>
                        <input type="number" class="form-control" name="pulse" min="40" step="1" max="150" value="85" placeholder="Введите пульс" required>
                    </div>

                    <div class="col-md-4">
                        <label>Температура:</label>
                        <input type="number" class="form-control" name="temperature" min="35" step="0.1" max="42" value="36.6" placeholder="Введите температура" required>
                    </div>

                    <div class="col-md-4">
                        <label>Сатурация:</label>
                        <input type="number" class="form-control" name="saturation" min="25" max="100" placeholder="Введите cатурация" required>
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Дыхание:</label>
                        <input type="number" class="form-control" name="breath" min="10" step="1" max="50" placeholder="Введите дыхание">
                    </div>

                    <div class="col-md-6">
                        <label>Моча:</label>
                        <input type="number" class="form-control" name="urine" min="0" step="0.1" max="5">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <label class="col-form-label">Примечание:</label>
                        <textarea rows="3" cols="3" name="description" class="form-control" placeholder="Описание"></textarea>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-link legitRipple" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
            </div>

        </form>
        <?php
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

class VisitReport extends Model
{
    public $table = 'visit';

    public function form($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">

                <h1>
                    <div class="col-md-8 offset-md-2">
                        <input type="text" style="font-size:1.3rem;" name="report_title" value="<?= ($post['report_title']) ? $post['report_title'] : $post['name'] ?>" class="form-control" placeholder="Названия отчета">
                    </div>
                </h1>

                <!-- The toolbar will be rendered in this container. -->
                <div id="toolbar-container"></div>

                <!-- This container will become the editable. -->
                <div id="editor">
                    <?php if ($post['report']): ?>
                        <?= $post['report'] ?>
                    <?php else: ?>
                        <br><span class="text-big"><strong>Рекомендация:</strong></span>
                    <?php endif; ?>
                </div>

                <textarea id="tickets-editor" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

            </div>

            <div class="modal-footer">
                <?php if (permission(10)): ?>
                    <?php if (division_assist() == 2): ?>
                        <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
                    <?php endif; ?>
                    <input style="display:none;" id="btn_end_submit" type="submit" value="Завершить" name="end" id="end"></input>
                    <button class="btn btn-outline-danger btn-sm" type="button" onclick="Verification()">Завершить</button>
                    <script type="text/javascript">
                        function Verification() {
                            event.preventDefault();

                            if ($('#editor').html() == `<p><br data-cke-filler="true"></p>`) {
                                swal({
                                    position: 'top',
                                    title: 'Невозможно завершить!',
                                    text: 'Не написан отчёт.',
                                    type: 'error',
                                    padding: 30
                                });
                                return 0;
                            }

                            swal({
                                position: 'top',
                                title: 'Внимание!',
                                text: 'Вы точно хотите завершить визит пациента?',
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Да'
                            }).then(function(ivi) {
                                if (ivi.value) {
                                    $('#btn_end_submit').click();
                                }
                            });
                        }
                    </script>
                <?php endif; ?>
                <?php if (permission([12, 13])): ?>
                    <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end" id="end"></input>
                <?php else: ?>
                    <button type="submit" class="btn btn-outline-info btn-sm" id="submit">Сохранить</button>
                <?php endif; ?>
            </div>

        </form>
        <script>
            DecoupledEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                    const toolbarContainer = document.querySelector( '#toolbar-container' );

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                    editor.model.document.on( 'change:data', ( evt, data ) => {
                        console.log( data );
                        $('textarea#tickets-editor').html( editor.getData() );
                    } );
                } )
                .catch( error => {
                    console.error( error );
                } );

              document.getElementById( 'submit' ).onclick = () => {
                  textarea.value = editor.getData();
              }
        </script>
        <?php if (permission([10,12,13])): ?>
            <script type="text/javascript">
                document.getElementById( 'end' ).onclick = () => {
                    textarea.value = editor.getData();
                }
            </script>
        <?php endif; ?>
        <?php
    }

    public function form_finish($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">
                <input type="hidden" name="report_title" value="<?= $post['name'] ?>">


                <!-- The toolbar will be rendered in this container. -->
                <div id="toolbar-container2"></div>

                <!-- This container will become the editable. -->
                <div id="editor2">
                    <?php if ($post['report']): ?>
                        <?= $post['report'] ?>
                    <?php else: ?>
                        <span class="text-big"><strong>Клинический диагноз:</strong></span><br>
                        <span class="text-big"><strong>Сопутствующие заболевания:</strong></span><br>
                        <span class="text-big"><strong>Жалобы:</strong></span><br>
                        <span class="text-big"><strong>Anamnesis morbi:</strong></span><br>
                        <span class="text-big"><strong>Объективно:</strong></span><br>
                        <span class="text-big"><strong>Рекомендация:</strong></span>
                    <?php endif; ?>
                </div>

                <textarea id="tickets-editor2" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

            </div>

            <div class="modal-footer">
                <?php if (level() == 10): ?>
                    <!-- <a href="<?= up_url($_GET['user_id'], 'VisitFinish') ?>" onclick="return confirm('Вы точно хотите завершить визит пациента!')" class="btn btn-outline-danger">Завершить</a> -->
                    <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end"></input>
                <?php endif; ?>
                <button type="submit" class="btn btn-outline-info btn-sm" id="submit">Сохранить</button>
            </div>

        </form>
        <script>
            DecoupledEditor
                .create( document.querySelector( '#editor2' ) )
                .then( editor2 => {
                    const toolbarContainer2 = document.querySelector( '#toolbar-container2' );

                    toolbarContainer2.appendChild( editor2.ui.view.toolbar.element );

                    editor2.model.document.on( 'change:data', ( evt, data ) => {
                        console.log( data );
                        $('textarea#tickets-editor2').html( editor2.getData() );
                    } );
                } )
                .catch( error => {
                    console.error( error );
                } );

              document.getElementById( 'submit' ).onclick = () => {
                  textarea.value = editor2.getData();
              }
              // document.getElementById( 'end' ).onclick = () => {
              //     textarea.value = editor2.getData();
              // }
        </script>
        <?php
    }

    public function get_or_404($pk)
    {
        global $db;
        $object = $db->query("SELECT vs.*, sc.name FROM $this->table vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.id = $pk")->fetch();
        if(division_assist() == 2){
            if ($object['parent_id'] = $object['assist_id'] or $object['parent_id'] == $_SESSION['session_id']) {
                if($object){
                    $this->set_post($object);
                    return $this->form($object['id']);
                }else{
                    Mixin\error('404');
                }
            }else {
                Mixin\error('404');
            }
        }else {
            if($object){
                $this->set_post($object);
                if ($object['service_id'] == 1) {
                    return $this->form_finish($object['id']);
                }else {
                    return $this->form($object['id']);
                }
            }else{
                Mixin\error('404');
            }
        }
    }

    public function update()
    {
        global $db;
        $end = ($this->post['end']) ? true : false;
        unset($this->post['end']);
        if($this->clean()){
            $db->beginTransaction();
            $pk = $this->post['id']; unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if ($end) {
                $row = $db->query("SELECT * FROM visit WHERE id = {$pk}")->fetch();
                if ($row['assist_id']) {
                    if ($row['grant_id'] != $row['route_id'] or !$db->query("SELECT * FROM visit WHERE id != {$pk} AND user_id = {$row['user_id']} AND completed IS NULL")->fetchColumn()) {
                        Mixin\update('users', array('status' => null), $row['user_id']);
                    }
                }else {
                    if ($row['grant_id'] == $row['parent_id'] and 1 == $db->query("SELECT * FROM visit WHERE user_id={$row['user_id']} AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount()) {
                        Mixin\update('users', array('status' => null), $row['user_id']);
                    }
                }
                $this->clear_post();
                $this->set_post(array(
                    'status' => ($row['direction']) ? 0 : null,
                    'completed' => date('Y-m-d H:i:s')
                ));
                $object = Mixin\update($this->table, $this->post, $pk);
                if (!intval($object)){
                    $this->error($object);
                }
            }else {
                if (!intval($object)){
                    $this->error($object);
                }
            }
        }
        $db->commit();
        $this->success();
    }

    public function clean()
    {
        if (empty($this->post['report'])) {
            unset($this->post['report']);
        }else {
            $report = $this->post['report'];
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if ($report) {
            $this->post['report'] = $report;
        }
        return True;
    }

    public function success()
    {
        render();
    }

}

class VisitUpStatus extends Model
{
    public $table = 'visit';

    public function get_or_404($pk)
    {
        if(division_assist()){
            $this->post['assist_id'] = $_SESSION['session_id'];
        }
        if (permission([12, 13])) {
            $this->post['parent_id'] = $_SESSION['session_id'];
            if (in_array(level($_GET['route_id']), [2, 32])) {
                $this->post['grant_id'] = $_SESSION['session_id'];
            }
        }
        $this->post['id'] = $pk;
        $this->post['status'] = 2;
        $this->post['accept_date'] = date('Y-m-d H:i:s');
        $this->url = "card/content_1.php?id=".$_GET['user_id'];
        $this->update();
    }

    public function success()
    {
        render();
        // header("location:/$PROJECT_NAME/views/doctor/$this->url");
        // exit;
    }

}

class VisitRoute extends Model
{
    public $table = 'visit';

    public function form_out($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php foreach ($db->query("SELECT * from division WHERE level in (5) AND id !=". division()) as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
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

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
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
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php foreach ($db->query("SELECT * from division WHERE level in (5) AND id !=". division()) as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
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
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
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
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_out_labaratory($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="laboratory" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Лаборатория</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php foreach ($db->query("SELECT * from division WHERE level in (6)") as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
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

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
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
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_sta_labaratory($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="laboratory" value="1">

            <div class="form-group">
                <label>Лаборатория</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php foreach ($db->query("SELECT * from division WHERE level in (6)") as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
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
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
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
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_out_diagnostic($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="diagnostic" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
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

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
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
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta_diagnostic($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="diagnostic" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
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
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
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
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_out_physio_manipulation($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="physio_manipulation" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level IN (12, 13)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
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

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
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
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta_physio_manipulation($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="physio_manipulation" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level IN (12, 13)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
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
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
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
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_sta_doc($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="2">
            <input type="hidden" name="accept_date" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="division_grant" value="<?= division() ?>">

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <th>Услуга</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">
                            <tr>
                                <td colspan="4" class="text-center" onclick="table_change()">услуги</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 3,
                        head: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change() {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        selected: service,
                        types: "1",
                        cols: 3,
                        head: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function clean()
    {
        if (is_array($this->post['service'])) {
            $this->save_rows();
        }
        if ($this->post['accept_date']) {
            $this->post['accept_date'] = date('Y-m-d H:i:s');
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
            }
            $service = $db->query("SELECT price, name FROM service WHERE id = {$this->post['service_id']}")->fetch();
            $post['visit_id'] = $object;
            $post['user_id'] = $this->post['user_id'];
            $post['item_type'] = 1;
            $post['item_id'] = $this->post['service_id'];
            $post['item_cost'] = $service['price'];
            $post['item_name'] = $service['name'];
            $object = Mixin\insert('visit_price', $post);
            if (intval($object)){
                $this->error($object);
            }
            $this->success();
        }
    }

    public function save_rows()
    {
        global $db;
        if ($this->post['accept_date'] and $this->post['division_grant']) {
            $post_big['accept_date'] = date('Y-m-d H:i:s');
            $post_big['division_id'] = $this->post['division_grant'];
            $post_big['parent_id'] = $this->post['parent_id'];
        }
        foreach ($this->post['service'] as $key => $value) {

            $post_big['direction'] = $this->post['direction'];
            $post_big['status'] = $this->post['status'];
            $post_big['grant_id'] = $this->post['grant_id'];
            $post_big['route_id'] = $this->post['route_id'];
            $post_big['user_id'] = $this->post['user_id'];
            $post_big['service_id'] = $value;
            if (!$this->post['division_grant']) {
                $post_big['parent_id'] = $this->post['parent_id'][$key];
                $post_big['division_id'] = $this->post['division_id'][$key];
            }
            if ($this->post['diagnostic']) {
                $post_big['diagnostic'] = $this->post['diagnostic'];
            }
            if ($this->post['laboratory']) {
                $post_big['laboratory'] = $this->post['laboratory'];
            }
            if ($this->post['physio_manipulation']) {
                $level_divis = $db->query("SELECT level FROM division WHERE id = {$post_big['division_id']}")->fetchColumn();
                if ($level_divis == 12) {
                    $post_big['physio'] = 1;
                } elseif ($level_divis == 13) {
                    $post_big['manipulation'] = 1;
                }
            }
            for ($i=0; $i < $this->post['count'][$key]; $i++) {
                $post_big = Mixin\clean_form($post_big);
                $post_big = Mixin\to_null($post_big);
                $object = Mixin\insert($this->table, $post_big);
                if (!intval($object)){
                    $this->error($object);
                }

                $service = $db->query("SELECT price, name FROM service WHERE id = {$post_big['service_id']}")->fetch();
                $post['visit_id'] = $object;
                $post['user_id'] = $this->post['user_id'];
                $post['item_type'] = 1;
                $post['item_id'] = $post_big['service_id'];
                $post['item_cost'] = $service['price'];
                $post['item_name'] = $service['name'];
                $object = Mixin\insert('visit_price', $post);
                if (!intval($object)){
                    $this->error($object);
                }
            }
        }
        $this->success();
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
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render();
    }
}

class VisitFinish extends Model
{
    public $table = 'visit';
    public $table1 = 'users';
    public $table2 = 'beds';

    public function get_or_404($pk)
    {
        global $db;
        $this->post['completed'] = date('Y-m-d H:i:s');
        $db->beginTransaction();

        if (!permission([12])) {
            foreach($db->query("SELECT * FROM visit WHERE user_id=$pk AND parent_id= {$_SESSION['session_id']} AND accept_date IS NOT NULL AND completed IS NULL AND (service_id = 1 OR (report_title IS NOT NULL AND report IS NOT NULL))") as $inf){
                $this->status_controller($pk, $inf);
                $this->update();
            }
        }else {
            $this->post['accept_date'] = date('Y-m-d H:i:s');
            foreach($db->query("SELECT * FROM visit WHERE id=$pk AND completed IS NULL AND physio IS NOT NULL") as $inf){
                $this->status_controller($inf['user_id'], $inf);
                $this->update();
            }
        }
        $db->commit();
        $this->success();
    }

    public function status_controller($pk, $inf)
    {
        global $db;
        $this->post['status'] = ($inf['direction']) ? 0 : null;
        if ($inf['grant_id'] == $inf['parent_id'] and ($inf['direction'] or 1 == $db->query("SELECT * FROM visit WHERE user_id=$pk AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount())) {
            if (!$inf['direction']) {
                Mixin\update($this->table1, array('status' => null), $pk);
            }
            if ($inf['direction']) {
                $pk_arr = array('user_id' => $pk);
                $object = Mixin\update($this->table2, array('user_id' => null), $pk_arr);
            }
        }
        if ($inf['assist_id']) {
            if (!$inf['direction']) {
                $this->post['grant_id'] = $_SESSION['session_id'];
                Mixin\update($this->table1, array('status' => null), $pk);
            }
        }
        $this->post['id'] = $inf['id'];
    }

    public function update()
    {
        $pk = $this->post['id'];
        unset($this->post['id']);
        $object = Mixin\update($this->table, $this->post, $pk);
        if ($object != 1){
            $this->error($object);
        }
    }

    public function success()
    {
        render("doctor/index");
    }

}

class VisitFailure extends Model
{
    public $table = 'visit';

    public function form($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="modal-body">
                <div class="form-group row">

                    <input type="hidden" id="vis_id" name="id" value="">
                    <input type="hidden" name="status" value="5">

                    <div class="col-md-12">
                        <label>Причина:</label>
                        <textarea rows="4" cols="4" name="failure" class="form-control" placeholder="Введите причину ..." required></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button id="renouncement" onclick="deletPatient(this);" data-userid="" data-parentid="" type="submit" id="button_<?= __CLASS__ ?>" class="btn btn-outline-danger btn-sm">Отказаться</button>
            </div>

        </form>

        <script type="text/javascript">

            $('#<?= __CLASS__ ?>_form').submit(function (events) {
                events.preventDefault();
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: $(this).serializeArray(),
                    success: function (result) {
                        $('#modal_failure').modal('hide');
                        $(result.replace("1#", "#")).css("background-color", "rgb(244, 67, 54)");
                        $(result.replace("1#", "#")).css("color", "white");
                        $(result.replace("1#", "#")).fadeOut(900, function() {
                            $(this).remove();
                        });
                    },
                });
            });
        </script>
        <?php
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
            }
            $this->success($pk);
        }
    }

    public function clean()
    {
        global $db;
        $visit = $db->query("SELECT direction FROM visit WHERE id = {$this->post['id']}")->fetch();
        if ($visit['direction']) {
            $form = new VisitModel;
            $form->delete($this->post['id']);
            $this->success($this->post['id']);
        }else {
            $this->post = Mixin\clean_form($this->post);
            $this->post = Mixin\to_null($this->post);
            return True;
        }

    }

    public function success($pk)
    {
        echo "#PatientFailure_tr_$pk";
    }

}

class VisitRefundModel extends Model
{
    public $table = 'visit_price';

    public function form($pk = null)
    {
        global $db;
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="modal-body">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="pricer_id" value="<?= $_SESSION['session_id'] ?>">
                <input type="hidden" name="user_id" id="user_id">
                <input type="hidden" name="visit_id" id="visit_id">

                <div class="form-group row">

                    <div class="col-md-12">
                        <label class="col-form-label">Сумма к оплате:</label>
                        <input type="text" class="form-control" id="total_price" disabled>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Наличный</label>
					<div class="col-md-9">
						<div class="input-group">
							<input type="number" name="price_cash" id="input_chek_1" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
								<span class="input-group-text">
									<input type="checkbox" class="form-control-switchery" data-fouc id="chek_1" onchange="Checkert(this)">
								</span>
							</span>
						</div>
					</div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Пластиковый</label>
					<div class="col-md-9">
						<div class="input-group">
							<input type="number" name="price_card" id="input_chek_2" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
								<span class="input-group-text">
									<input type="checkbox" class="form-control-switchery" data-fouc id="chek_2" onchange="Checkert(this)">
								</span>
							</span>
						</div>
					</div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Перечисление</label>
					<div class="col-md-9">
						<div class="input-group">
							<input type="number" name="price_transfer" id="input_chek_3" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
								<span class="input-group-text">
									<input type="checkbox" class="form-control-switchery" data-fouc id="chek_3" onchange="Checkert(this)">
								</span>
							</span>
						</div>
					</div>
                </div>

            </div>

    		<div class="modal-footer">
    			<button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-outline-info btn-sm">Печать</button>
    		</div>

        </form>

        <script type="text/javascript">

            function Checkert(event) {
                var input = $('#input_'+event.id);
                if(!input.prop('disabled')){
                    input.attr("disabled", "disabled");
                    Downsum(input);
                }else {
                    input.removeAttr("disabled");
                    Upsum(input);
                }
            }

        </script>
        <?php
    }

    public function clean()
    {
        global $db;
        $object = $db->query("SELECT * FROM visit_price WHERE visit_id ={$this->post['visit_id']}")->fetch();
        $this->post['sale'] = $object['sale'];
        $this->post['item_type'] = $object['item_type'];
        $this->post['item_id'] = $object['item_id'];
        $this->post['item_cost'] = $object['item_cost'];
        $this->post['item_name'] = $object['item_name'];
        $this->post['price_date'] = date('Y-m-d H:i:s');
        if (0 == $db->query("SELECT * FROM visit WHERE user_id={$this->post['user_id']} AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount()) {
            Mixin\update('users', array('status' => null), $this->post['user_id']);
        }
        Mixin\delete('visit', $this->post['visit_id']);
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        $this->post['price_cash'] = -$this->post['price_cash'];
        $this->post['price_card'] = -$this->post['price_card'];
        $this->post['price_transfer'] = -$this->post['price_transfer'];
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
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }

}

?>
