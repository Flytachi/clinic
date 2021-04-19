<?php

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
                    <!-- <button type="button" onclick="Proter_lab()" class="btn btn-outline-danger btn-sm">Завершить все</button> -->
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

?>