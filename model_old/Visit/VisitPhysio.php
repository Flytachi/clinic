<?php

use Mixin\ModelOld;

class VisitPhysioModel extends ModelOld
{
    public $table = 'visits';
    public $_patient = 'patients';
    public $_visit = 'visits';
    public $_visit_service = 'visit_services';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->_visit WHERE id = $pk AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){

            $this->set_post($object);
            return $this->form($object['id']);

        }else{
            Mixin\error('report_permissions_false');
            exit;
        }

    }

    public function form($pk = null)
    {
        global $db, $classes, $session;
        $patient = $db->query("SELECT id, birth_date, gender FROM $this->_patient WHERE id = {$this->post['patient_id']}")->fetch();
        $is_division = (division()) ? "AND division_id = ".division() : null;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h5 class="modal-title">Детально</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

            <div class="row" style="margin-bottom:20px;">
                                
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-bordered">
                        <tbody class="bg-secondary">
                            <tr>
                                <th style="width:150px">ID:</th>
                                <td><?= addZero($patient['id']) ?></td>

                                <th style="width:150px">Пол:</th>
                                <td><?= ($patient['gender']) ? "Мужской" : "Женский" ?></td>
                            </tr>
                            <tr>
                                <th style="width:150px">FIO:</th>
                                <td><?= patient_name($patient['id']) ?></td>

                                <th style="width:150px">Дата рождения:</th>
                                <td><?= date_f($patient['birth_date']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>


            <div class="card table-responsive">
                <table class="table table-sm table-hover">

                    <thead class="<?= $classes['table-thead'] ?>">
                        <tr>
                            <th style="width: 12%;">Дата</th>
                            <th>Отдел/Назначил</th>
                            <th>Название</th>
                            <!-- <th class="text-center">Комментарий</th> -->
                            <th class="text-center">Кол-во</th>
                            <th class="text-right">Действия Ед.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($db->query("SELECT DISTINCT service_id, service_name, route_id, add_date FROM $this->_visit_service WHERE visit_id = $pk AND level = 12 AND status = 2 AND (parent_id IS NULL OR parent_id = $session->session_id) $is_division") as $row): ?>
                            <?php $value = $db->query("SELECT id, COUNT(id) 'count' FROM $this->_visit_service WHERE visit_id = $pk AND level = 12 AND status = 2 AND service_id = {$row['service_id']} AND route_id = {$row['route_id']} AND add_date = '{$row['add_date']}' AND (parent_id IS NULL OR parent_id = $session->session_id) $is_division")->fetch(); ?>
                            <tr class="changer_tab-services">
                                <td><?= date_f($row['add_date'], 1) ?></td>
                                <td>
                                    <?php
                                    if ($title = division_title($row['route_id'])) echo $title;
                                    else echo level_name($row['route_id']);
                                    unset($title);
                                    ?>
                                    <div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
                                </td>
                                <td><?= $row['service_name'] ?> </td>
                                <td class="text-center changer_tab-service_qty"><?= $value['count'] ?></td>
                                <td class="text-right">
                                    <button onclick="CompleteVisitService('<?= del_url($value['id'], __CLASS__) ?>')" class="btn btn-outline-success btn-sm legitRipple">Завершить</button>
                                    <button onclick="FailureVisitService('<?= del_url($value['id'], 'VisitFailure') ?>')" class="btn btn-outline-danger btn-sm legitRipple">Отказ</button>
                                </td>
                            </tr>                            
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        </div>
        <script type="text/javascript">

            function CompleteVisitService(url) {
                event.target.className = "text-muted";
                event.target.removeAttribute("onclick");

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (result) {

                        if (result == "success") {

                            if ($(".changer_tab-services").length == 1 && Number(document.querySelector(".changer_tab-service_qty").innerHTML) == 1) {
                                location.reload();
                            } else {
                                new Noty({
                                    text: 'Процедура завершения прошла успешно!',
                                    type: 'success'
                                }).show();

                                ListVisit('<?= up_url($pk, __CLASS__) ?>');
                            }
                            
                            
                        }else{

                            new Noty({
                                text: result,
                                type: 'error'
                            }).show();

                        }
                    },
                });
                
            }

            function FailureVisitService(url) {
                event.target.disabled = true;

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (result) {
                        var data = JSON.parse(result);

                        if (data.status == "success") {

                            if ($(".changer_tab-services").length == 1 && Number(document.querySelector(".changer_tab-service_qty").innerHTML) == 1) {
                                location.reload();
                            } else {
                                new Noty({
                                    text: 'Процедура отказа прошла успешно!',
                                    type: 'success'
                                }).show();

                                ListVisit('<?= up_url($pk, __CLASS__) ?>');
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

        </script>
        <?php
    }

    public function delete(int $pk)
    {
        global $db, $session;
        $VisitFinish = new VisitFinish();
        $VisitFinish->set_post(array('parent_id' => $session->session_id, 'status' => 7, 'accept_date' => date('Y-m-d H:i:s'), 'completed' => date('Y-m-d H:i:s')));
        $VisitFinish->update_service($pk);
        $VisitFinish->status_update($db->query("SELECT visit_id FROM $this->_visit_service WHERE id = {$pk}")->fetchColumn());
        $this->success();
    }

    public function success()
    {
        echo "success";
        exit;
    }

    public function error($message)
    {
        echo $message;
        exit;
    }
}
        
?>