<?php
if ($_GET['pk']) {
    $agr = "?pk=".$_GET['pk'];
    $activity = False;
    $sql = "SELECT
                us.id, vs.id 'visit_id', vs.grant_id,
                us.dateBith, us.numberPhone, us.gender,
                us.region, us.residenceAddress, vs.priced_date,
                us.registrationAddress, vs.add_date, vs.accept_date,
                vs.direction, vs.add_date, vs.discharge_date,
                vs.complaint, vs.status, vp.item_name, vs.completed, vp.item_cost
            FROM users us
                LEFT JOIN visit vs ON (vs.user_id = us.id)
                LEFT JOIN visit_price vp ON (vp.visit_id=vs.id AND vp.item_type = 101)
            WHERE vs.id = {$_GET['pk']} ORDER BY add_date ASC";
} else if ($_GET['id']){
    $agr = "?id=".$_GET['id'];
    $activity = True;
    $sql = "SELECT
                us.id, vs.id 'visit_id', vs.grant_id,
                us.dateBith, us.numberPhone, us.gender,
                us.region, us.residenceAddress,
                us.registrationAddress, vs.accept_date,
                vs.direction, vs.add_date, vs.discharge_date,
                wd.floor, wd.ward, bd.bed, vs.complaint,
                vs.status, vs.priced_date
            FROM users us
                LEFT JOIN visit vs ON (vs.user_id = us.id AND vs.completed IS NULL)
                LEFT JOIN beds bd ON (bd.user_id=vs.user_id)
                LEFT JOIN wards wd ON(wd.id=bd.ward_id)
            WHERE us.id = {$_GET['id']} ORDER BY add_date ASC";
}

$patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);
// prit($patient);
?>
<div class="card border-1 border-info">

    <div class="card-header text-dark header-elements-inline alpha-info">
        <h5 class="card-title"><b><?= get_full_name($patient->id) ?></b></h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3">
                <div class="card-img-actions">
                    <img class="card-img-top img-fluid" src="<?= stack("vendors/image/user3.jpg")?>" alt="">
                </div>
            </div>

            <div class="col-md-9" style="font-size: 0.9rem">

                <fieldset class="mb-3 row">

                    <div class="col-md-6">

                        <div class="form-group row">

                            <label class="col-md-4"><b>Статус визита:</b></label>
                            <div class="col-md-8 text-right">

                                <?php
                                switch ($patient->status):
                                    case 1:
                                        ?>
                                        <span style="font-size:15px;" class="badge badge-flat border-success text-success">Размещён</span>
                                        <?php
                                        break;
                                    case 2:
                                        ?>
                                        <span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
                                        <?php
                                        break;
                                    default:
                                        ?>
                                        <?php if ($patient->priced_date): ?>
                                            <span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
                                        <?php else: ?>
                                            <span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
                                        <?php endif; ?>
                                        <?php
                                        break;
                                endswitch;
                                ?>
                            </div>


                            <label class="col-md-4"><b>Дата рождение:</b></label>
    						<div class="col-md-8 text-right">
    							<?= date('d.m.Y', strtotime($patient->dateBith)) ?>
    						</div>

                            <label class="col-md-4"><b>Адрес проживания:</b></label>
    						<div class="col-md-8 text-right">
    							<?= $patient->region ?> <?= $patient->residenceAddress ?>
    						</div>

                            <label class="col-md-4"><b>Адрес прописки:</b></label>
				            <div class="col-md-8 text-right">
                               <?= $patient->region ?> <?= $patient->registrationAddress ?>
    						</div>

                            <label class="col-md-4"><b>Дата визита:</b></label>
    						<div class="col-md-8 text-right">
    							<?= date('d.m.Y  H:i', strtotime($patient->accept_date)) ?>
    						</div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group row">

    						<label class="col-md-3"><b>ID:</b></label>
    						<div class="col-md-9 text-right">
    							<?= addZero($patient->id) ?>
    						</div>

                            <?php if ($patient->direction): ?>
                                <label class="col-md-6"><b>№ истории болезни:</b></label>
                                <div class="col-md-6 text-right">
                                    <?= addZero($patient->visit_id) ?>
                                </div>
                            <?php endif; ?>

                            <label class="col-md-3"><b>Телефон:</b></label>
    						<div class="col-md-9 text-right">
    							<?= $patient->numberPhone ?>
    						</div>

                            <label class="col-md-3"><b>Пол:</b></label>
    						<div class="col-md-9 text-right">
    							<?= ($patient->gender) ? "Мужской": "Женский" ?>
    						</div>

    					</div>

                    </div>

                </fieldset>

                <?php $class_color_add = "text-success"; ?>
                <?php if ($patient->direction): ?>
                    <?php
                    // Баланс пациента
                    $pl = 0;
                    if ($activity) {
                        $serv_id = $db->query("SELECT id FROM visit WHERE user_id = $patient->id AND priced_date IS NULL AND service_id != 1")->fetchAll();
                        foreach ($serv_id as $value) {
                            $item_service = $db->query("SELECT SUM(item_cost) 'price' FROM visit_price WHERE visit_id = {$value['id']} AND item_type = 1")->fetchAll();
                            foreach ($item_service as $pri_ze) {
                                $pl += $pri_ze['price'];
                            }
                        }
                        $sql = "SELECT
                                    IFNULL(SUM(iv.balance_cash + iv.balance_card + iv.balance_transfer), 0) -
                                    (
                                        ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), vs.add_date), '%H') / 24) * bdt.price +
                                        IFNULL($pl, 0) +
                                        (SELECT IFNULL(SUM(item_cost), 0) FROM visit_price WHERE visit_id = vs.id AND item_type IN (1,2,3,4,5))
                                    )
                                     'balance'
                                FROM users us
                                    LEFT JOIN investment iv ON(iv.user_id = us.id AND iv.status IS NOT NULL)
                                    LEFT JOIN beds bd ON(bd.user_id = us.id)
                                    LEFT JOIN bed_type bdt ON(bdt.id = bd.types)
                                    LEFT JOIN visit vs ON(vs.user_id = us.id AND vs.grant_id = vs.parent_id AND priced_date IS NULL)
                                WHERE us.id = $patient->id";
                        $price = $db->query($sql)->fetch(PDO::FETCH_OBJ);
                    } else {
                        $serv_id = $db->query("SELECT id FROM visit WHERE user_id = $patient->id AND accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\"")->fetchAll();
                        foreach ($serv_id as $value) {
                            $item_service = $db->query("SELECT SUM(item_cost) 'price' FROM visit_price WHERE visit_id = {$value['id']} AND item_type = 1")->fetchAll();
                            foreach ($item_service as $pri_ze) {
                                $pl += $pri_ze['price'];
                            }
                        }
                        $price->balance = $pl + $patient->item_cost;
                    }

                    if (!$patient->priced_date) {
                        $price->balance = -$price->balance;
                    }

                    // prit($price);
                    if ($price->balance >= 0) {
                        $class_card_balance = "text-success";
                        $class_color_add = "cl_btn_balance text-success";
                        $id_selector_balance = "1";
                    }else {
                        $class_card_balance = "text-danger";
                        $class_color_add = "cl_btn_balance text-danger";
                        $id_selector_balance = "0";
                    }
                    ?>
                    <fieldset class="mb-3 row" style="margin-top: -50px; ">
                        <legend></legend>

                        <div class="col-md-6">
                            <div class="form-group row">

                                <label class="col-md-5"><b>Лечащий врач:</b></label>
                                <div class="col-md-7 text-right <?= ($patient->grant_id == $_SESSION['session_id']) ? "text-success" : "text-primary" ?>">
                                    <?= get_full_name($patient->grant_id) ?>
                                </div>

                                <label class="col-md-4"><b>Размещён:</b></label>
                                <div class="col-md-8 text-right" id="patient_location">
                                    <?php if ($activity): ?>
                                        <?= $patient->floor ?> этаж <?= $patient->ward ?> палата <?= $patient->bed ?> койка
                                    <?php else: ?>
                                        <?= $patient->item_name ?>
                                    <?php endif; ?>
                                </div>

                                <label class="col-md-4"><b>Дата размещения:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= date('d.m.Y  H:i', strtotime($patient->add_date)) ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">

                                <?php if ($activity): ?>
                                    <label class="col-md-4"><b>Баланс:</b></label>
                                    <div class="col-md-8 text-right <?= $class_card_balance ?>" id="id_selector_balance" data-balance_status="<?= $id_selector_balance ?>">
                                        <?= number_format($price->balance) ?>
                                    </div>
                                <?php else: ?>
                                    <label class="col-md-4"><b>Прибыль:</b></label>
                                    <div class="col-md-8 text-right <?= $class_card_balance ?>" id="id_selector_balance" data-balance_status="<?= $id_selector_balance ?>">
                                        <?= number_format($price->balance) ?>
                                    </div>
                                <?php endif; ?>

                                <label class="col-md-3"><b>Прибывание:</b></label>
                                <div class="col-md-9 text-right">
                                    <?php
                                    $dr= date_diff(new \DateTime($patient->completed), new \DateTime($patient->add_date));
                                    $end_date = $dr->days + round($dr->h/24);
                                    if ($end_date == 1) {
                                        echo $end_date." день";
                                    }elseif (in_array($end_date, [2,3,4])) {
                                        echo $end_date." дня";
                                    }elseif ($end_date >= 5) {
                                        echo $end_date." дней";
                                    }else {
                                        echo "Прибыл сегодня";
                                    }
                                    ?>
                                </div>

                                <label class="col-md-4"><b>Дата выписки:</b></label>
                                <?php if ($activity): ?>
                                    <?php if ($patient->grant_id == $_SESSION['session_id']): ?>
                                        <div class="col-md-8 text-right text-primary" data-toggle="modal" data-target="#modal_discharge_date">
                                            <?= ($patient->discharge_date) ? date('d.m.Y', strtotime($patient->discharge_date)) : "Назначить дату выписки" ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="col-md-8 text-right <?= ($patient->discharge_date) ? "text-primary" : "text-danger" ?>">
                                            <?= ($patient->discharge_date) ? date('d.m.Y', strtotime($patient->discharge_date)) : "Не назначено" ?>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="col-md-8 text-right">
                                        <?= ($patient->completed) ? date('d.m.Y H:i', strtotime($patient->completed)) : "Не выписан" ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </fieldset>
                <?php endif; ?>

                <?php if (!$patient->direction): ?>
                    <div class="col-md-12">
                        <b>Жалоба: </b><?= $patient->complaint ?>
                    </div>
                <?php endif; ?>

            </div>

            <?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
                <div id="modal_discharge_date" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h6 class="modal-title">Назначить дату выписки</h6>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form method="post" action="<?= add_url() ?>">
                                <input type="hidden" name="model" value="VisitModel">
                                <input type="hidden" name="id" value="<?= $patient->visit_id ?>">

                                <div class="modal-body">

                                    <div class="form-group">
                                        <input type="date" name="discharge_date" class="form-control daterange-single" value="<?= $patient->discharge_date ?>" required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($activity): ?>

                <?php if (permission(5)): ?>

                    <div class="col-md-12">
                        <div class="text-right">
                            <?php
                            if ($patient->direction and $patient->grant_id == $_SESSION['session_id']) {
                                $button_tip = 'data-btn="Выписать" data-question="Вы точно хотите выписать пациента!" data-user_id="'.$patient->id.'"';
                                $button_inner = "Выписать";
                            }else {
                                $button_tip = 'data-btn="Завершить" data-question="Вы точно хотите завершить визит пациента!" data-user_id="'.$patient->id.'"';
                                $button_inner = "Завершить";
                            }
                            ?>
                            <button data-href="<?= up_url($patient->id, 'VisitFinish') ?>" id="sweet_visit_finish" <?= $button_tip ?> class="btn btn-outline-danger btn-sm">
                                <i class="icon-paste2"></i> <?= $button_inner ?>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" id="verification_url" value="<?= viv('doctor/verificaton') ?>">

                <?php elseif (permission(7)): ?>

                    <div class="col-md-12">
                        <div class="text-right">
                            <button data-grant_id="<?= $patient->grant_id ?>" data-parent="<?= get_full_name($_SESSION['session_id']) ?>" id="sweet_call_nurce" data-btn="Вызвать" data-question="Вы точно хотите срочно вызвать врача!" class="btn btn-outline-danger btn-md">Вызвать</button>
                        </div>
                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </div>

    </div>

</div>
<?php if ($activity): ?>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.cl_btn_balance').click(function(events) {
                if (document.getElementById('id_selector_balance').dataset.balance_status != 1) {
                    new Noty({
                        text: '<strong>Предупреждение!</strong><br>У пациента недостаточно средств.',
                        type: 'error'
                    }).show();
                }
            });
        });
    </script>
<?php endif; ?>
