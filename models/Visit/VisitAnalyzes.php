<?php

class VisitAnalyzesModel extends Model
{
    public $table = 'visit_analyzes';
    public $_user = 'users';
    public $_visit = 'visits';
    public $_visit_service = 'visit_services';
    public $_service_analyze = 'service_analyzes';

    public function get_or_404(int $pk)
    {
        /**
         * Данные о записи!
         * если не найдёт запись то выдаст 404 
         */
        global $db;
        $object = $db->query("SELECT * FROM $this->_visit WHERE id = $pk AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){

            foreach (json_decode($_GET['items']) as $key) {
                if ($item = $db->query("SELECT id, division_id FROM $this->_visit_service WHERE id = $key AND level = 6 AND status = 3")->fetch()) {
                    $this->items[] = $item['id'];
                    $this->divisions[$item['division_id']] = $db->query("SELECT title FROM divisions WHERE id = {$item['division_id']}")->fetchColumn();
                }
            }
            $this->divisions = array_unique($this->divisions);
            $this->set_post($object);
            return $this->form($object['id']);

        }else{
            Mixin\error('report_permissions_false');
            exit;
        }

    }

    public function form($pk = null)
    {
        global $db, $classes;
        $user = $db->query("SELECT id, birth_date, gender FROM $this->_user WHERE id = {$this->post['user_id']}")->fetch();
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form" onsubmit="SubmitSave(this)">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $pk ?>">
            <input type="hidden" name="action" id="inputs_action">

            <div id="inputs_finish"></div>

            <div class="<?= $classes['modal-global_header'] ?>">
                <h5 class="modal-title">Лист анализов</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="row" style="margin-bottom:20px;">
                        
                    <div class="col-8">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered">
                                <tbody class="bg-secondary">
                                    <tr>
                                        <th style="width:150px">ID:</th>
                                        <td><?= addZero($user['id']) ?></td>

                                        <th style="width:150px">Пол:</th>
                                        <td><?= ($user['gender']) ? "Мужской" : "Женский" ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:150px">FIO:</th>
                                        <td><?= get_full_name($user['id']) ?></td>

                                        <th style="width:150px">Дата рождения:</th>
                                        <td><?= date_f($user['birth_date']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="text-right" style="margin-bottom:10px;">
                            <button type="button" onclick="SubmitCheckAll(<?= json_encode($this->items) ?>)" class="btn btn-outline-danger btn-sm">Завершить все</button>
                            <button type="button" onclick="FinishService()" class="btn btn-outline-info btn-sm">Сохранить все</button>
                            <button type="submit" id="btn_submit" style="display:none;"></button>
                        </div>
                    </div>

                    <div id="modal_message"></div>

                </div>

                <ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">

                    <?php $t=0; foreach ($this->divisions as $key => $title): ?>
                        <li class="nav-item"><a id="laboratory_tab_label-<?= $key ?>" href="#laboratory_tab-<?= $key ?>" class="nav-link legitRipple <?= ($t++ === 0) ? "active" : "" ?>" data-toggle="tab"><?= $title ?></a></li>
                    <?php endforeach; ?>

				</ul>

                <div class="tab-content">

                    <?php $s=0; foreach ($this->divisions as $key => $title): ?>
                        <div class="tab-pane fade <?= ($s++ === 0) ? "show active" : "" ?>" id="laboratory_tab-<?= $key ?>">

                            <div class="table-responsive">
                                <table class="table table-hover table-sm table-bordered">
                                    <thead class="<?= $classes['table-thead'] ?>">
                                        <tr>
                                            <th style="width:3%">№</th>
                                            <th>Анализ</th>
                                            <th>Код</th>
                                            <th style="width:10%">Норма</th>
                                            <th style="width:10%">Результат</th>
                                            <th class="text-center" style="width:10%">Отклонение</th>
                                        </tr>
                                    </thead>
                                    <!-- Services -->
                                    <?php foreach ($db->query("SELECT id, service_id, service_name FROM $this->_visit_service WHERE level = 6 AND status = 3 AND division_id = $key AND id IN (".implode(',', $this->items).")") as $service_row): ?>
                                        
                                        <?php $submit_division_items[] = $service_row['id']; ?>
                                        <tbody id="VisitService_tr_<?= $service_row['id'] ?>">
                                            <tr>
                                                <th colspan="5" class="text-center"><?= $service_row['service_name'] ?></th>
                                                <th class="text-right">
                                                    <div class="list-icons">
                                                        <a href="#" onclick="SubmitCheckService(<?= $service_row['id'] ?>, '<?= $service_row['service_name'] ?>')" type="button" class="text-success legitRipple">Завершить</a>
                                                        <a href="#" onclick="FailureVisitService('<?= del_url($service_row['id'], 'VisitFailure') ?>')" type="button" class="text-danger legitRipple">Отказ</a>
                                                    </div>
                                                </th>
                                            </tr>
                                            <!-- Analyzes -->
                                            <?php $p=1; foreach ($db->query("SELECT sa.id, sa.name, sa.code, sa.standart, va.id 'pk', va.result, va.deviation FROM $this->_service_analyze sa LEFT JOIN $this->table va ON(va.visit_service_id = {$service_row['id']} AND va.service_id = {$service_row['service_id']} AND va.service_analyze_id = sa.id) WHERE sa.service_id = {$service_row['service_id']} AND sa.status IS NOT NULL") as $row): ?>
                                                <tr id="TR_<?= $row['id'] ?>" class="<?= ($row['deviation']) ? "table-danger" : "" ?>">
                                                    <td><?= $p++ ?></td>
                                                    <td><?= $row['name'] ?></td>
                                                    <td><?= $row['code'] ?></td>
                                                    <td>
                                                        <?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="items[<?= $service_row['id'] ?>][<?= $row['id'] ?>][id]" value="<?= $row['pk'] ?>">
                                                        <input type="hidden" name="items[<?= $service_row['id'] ?>][<?= $row['id'] ?>][visit_service_id]" value="<?= $service_row['id'] ?>">
                                                        <input type="hidden" name="items[<?= $service_row['id'] ?>][<?= $row['id'] ?>][service_analyze_id]" value="<?= $row['id'] ?>">
                                                        <input type="text" class="form-control result_check_all result_check_tab-<?= $key ?> result_check_service-<?= $service_row['id'] ?>" name="items[<?= $service_row['id'] ?>][<?= $row['id'] ?>][result]" value="<?= $row['result'] ?>">
                                                    </td>
                                                    <td>
                                                        <div class="list-icons">
                                                            <label class="form-check-label">
                                                                <input data-id="TR_<?= $row['id'] ?>" type="checkbox" class="swit bg-danger cek_a" name="items[<?= $service_row['id'] ?>][<?= $row['id'] ?>][deviation]" <?= ($row['deviation']) ? "checked" : "" ?>>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <!-- End Analyzes -->
                                        </tbody>

                                    <?php endforeach; ?>
                                    <!-- End Services -->
                                </table>
                            </div>


                            <div class="text-right" style="margin-top:10px;">
                                <button type="button" onclick="SubmitCheckDivision(<?= $key ?>, '<?= $title ?>', <?= json_encode($submit_division_items) ?>)" class="btn btn-outline-danger btn-sm">Завершить</button>
                            </div>

    					</div>
                        <?php unset($submit_division_items); ?>
                    <?php endforeach; ?>

				</div>

            </div>

        </form>
        <script type="text/javascript">
            let deletes_pks;
            Swit.init();

            function SubmitSave(params) {
                event.preventDefault();
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        var data = JSON.parse(result);

                        if (data.status == "success") {
                            
                            // save
                            if (data.action == "save") { 
                                new Noty({
                                    text: "Анализы успешно сохранены!",
                                    type: 'success'
                                }).show();
                            }
                            // finish for service
                            if (data.action == "finish for service") { 
                                new Noty({
                                    text: "Анализ успешно завершён!",
                                    type: 'success'
                                }).show();
                                $(`#VisitService_tr_${deletes_pks}`).css("background-color", "rgb(0, 255, 0)");
                                $(`#VisitService_tr_${deletes_pks}`).css("color", "white");
                                $(`#VisitService_tr_${deletes_pks}`).fadeOut(900, function() {
                                    $(this).remove();
                                });
                            }
                            // finish for division
                            if (data.action == "finish for division") {
                                new Noty({
                                    text: "Все анализы отдела успешно завершены!",
                                    type: 'success'
                                }).show();
                                $(`#laboratory_tab-${deletes_pks}`).css("background-color", "rgb(0, 255, 0)");
                                $(`#laboratory_tab-${deletes_pks}`).css("color", "white");
                                $(`#laboratory_tab-${deletes_pks}`).fadeOut(900, function() {
                                    $(this).remove();
                                });
                                $(`#laboratory_tab_label-${deletes_pks}`).css("background-color", "rgb(0, 0, 255)");
                                $(`#laboratory_tab_label-${deletes_pks}`).css("color", "white");
                                $(`#laboratory_tab_label-${deletes_pks}`).fadeOut(900, function() {
                                    $(this).remove();
                                });
                                
                            }
                            // finish all
                            if (data.action == "finish all") { 
                                location.reload();
                            }
                            
                            
                        }else{

                            new Noty({
                                text: data.message,
                                type: 'error'
                            }).show();

                        }
                    },
                });
            }

            function FailureVisitService(url) {
                
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (result) {
                        var data = JSON.parse(result);

                        if (data.status == "success") {
                            new Noty({
                                text: 'Процедура отказа прошла успешно!',
                                type: 'success'
                            }).show();
                            
                            $(`#VisitService_tr_${data.pk}`).css("background-color", "rgb(244, 67, 54)");
                            $(`#VisitService_tr_${data.pk}`).css("color", "white");
                            $(`#VisitService_tr_${data.pk}`).fadeOut(900, function() {
                                $(this).remove();
                            });
                            
                        }else{

                            new Noty({
                                text: data.message,
                                type: 'error'
                            }).show();

                        }
                    },
                });
            }

            function SubmitCheckService(id, name) {
                var status = true;
                var inputs = document.querySelectorAll(`.result_check_service-${id}`);

                for (let key = 0; key < inputs.length; key++) {
                    const element = inputs[key];
                    if (!element.value) {
                        status = false;
                        element.className += " border-danger";
                    }
                    continue;
                }

                if (status) {
                    FinishService(id, 1, id);
                }else{
                    swal({
                        position: 'top',
                        title: `Введены не все результаты анализов услуги ${name}!`,
                        text: `Вы точно хотите завершить все анализы услуги ${name}?`,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Да'
                    }).then(function(ivi) {
                        if (ivi.value) {
                            FinishService(id, 1, id);
                        }
                    });
                }
            }

            function SubmitCheckDivision(id, name, array) {
                var status = true;
                var inputs = document.querySelectorAll(`.result_check_tab-${id}`);

                for (let key = 0; key < inputs.length; key++) {
                    const element = inputs[key];
                    if (!element.value) {
                        status = false;
                        element.className += " border-danger";
                    }
                    continue;
                }

                if (status) {
                    SubmitVerification(1, id, array);
                }else{
                    swal({
                        position: 'top',
                        title: `Введены не все результаты анализов группы ${name}!`,
                        text: `Вы точно хотите завершить все анализы группы ${name}?`,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Да'
                    }).then(function(ivi) {
                        if (ivi.value) {
                            SubmitVerification(1, id, array);
                        }
                    });
                }
            }

            function SubmitCheckAll(items) {
                var status = true;
                var inputs = document.querySelectorAll(".result_check_all");
                
                for (let key = 0; key < inputs.length; key++) {
                    const element = inputs[key];
                    if (!element.value) {
                        status = false;
                        element.className += " border-danger";
                    }
                    continue;
                }

                if (status) {
                    SubmitVerification(null, null, items);
                }else{
                    swal({
                        position: 'top',
                        title: 'Введены не все результаты анализов!',
                        text: 'Вы точно хотите завершить все анализы пациента?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Знаю'
                    }).then(function(ivi) {
                        if (ivi.value) {
                            SubmitVerification(null, null, items);
                        }
                    });
                }
            }

            function SubmitVerification(type = null, id = null, array = null) {
                if (type == 1) {
                    FinishService(array, 2, id);
                }else {
                    swal({
                        position: 'top',
                        title: 'Внимание!',
                        text: 'Вы точно хотите завершить все анализы пациента?',
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Да'
                    }).then(function(ivi) {
                        if (ivi.value) {
                            FinishService(array, 3);
                        }
                    });
                }
                
            }

            function FinishService(params = null, action = null, deletes = null) {
                var display_finish = document.querySelector("#inputs_finish"); 
                deletes_pks = deletes;
                display_finish.innerHTML = "";
                document.querySelector("#inputs_action").value = action;

                if (Array.isArray(params)) {
                    params.forEach(element => display_finish.innerHTML += `<input type="hidden" name="finish_service[]" value="${element}"></input>` );
                }else{
                    display_finish.innerHTML += `<input type="hidden" name="finish_service" value="${params}"></input>`;
                }
                document.querySelector("#btn_submit").click();
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

    public function analize_save()
    {
        global $db;
        foreach ($this->post['items'] as $service_pk => $analyzes) {
            foreach ($analyzes as $key => $post) {
                $post = Mixin\clean_form($post);
                $post = Mixin\to_null($post);
                $post['visit_id'] = $this->post['visit_id'];
                $post['user_id'] = $db->query("SELECT user_id FROM $this->_visit WHERE id = {$this->post['visit_id']}")->fetchColumn();
                $post['service_id'] = $db->query("SELECT service_id FROM $this->_visit_service WHERE id = {$post['visit_service_id']}")->fetchColumn();
                $post['service_name'] = $db->query("SELECT service_name FROM $this->_visit_service WHERE id = {$post['visit_service_id']}")->fetchColumn();
                $post['analyze_name'] = $db->query("SELECT name FROM $this->_service_analyze WHERE id = {$post['service_analyze_id']}")->fetchColumn();
                $post['deviation'] = ( isset($post['deviation']) and $post['deviation'] ) ? 1 : null;
                $object = Mixin\insert_or_update($this->table, $post);
                if (!intval($object)){
                    $this->error($object);
                }
            }
        }
    }

    public function clean()
    {
        global $db;
        if ($this->post['action'] == null) $this->action = "save";
        elseif ($this->post['action'] == 1) $this->action = "finish for service";
        elseif ($this->post['action'] == 2) $this->action = "finish for division";
        elseif ($this->post['action'] == 3) $this->action = "finish all";

        $db->beginTransaction();
        
        $this->analize_save();
        // $this->finish();
        
        $db->commit();
        $this->success();
    }

    public function success($stat = null)
    {
        $mess = 'Успешно';
        echo json_encode(array(
            'status' => 'success',
            'action' => $this->action,
            'message' => $mess,
        ));
        exit;
    }

    public function error($message)
    {
        $mess = $message;
        echo json_encode(array(
            'status' => 'error',
            'action' => $this->action,
            'message' => $mess,
        ));
        exit;
    }
}
        
?>