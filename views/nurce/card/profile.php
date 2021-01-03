<?php
$sql = "SELECT
            us.id, vs.id 'visit_id', vs.grant_id,
            us.dateBith, us.numberPhone, us.gender,
            us.region, us.residenceAddress,
            us.registrationAddress, vs.accept_date,
            vs.direction, vs.add_date, vs.discharge_date,
            vs.oper_date, wd.floor, wd.ward, bd.bed
        FROM users us
            LEFT JOIN visit vs ON (vs.user_id = us.id)
            LEFT JOIN beds bd ON (bd.user_id=vs.user_id)
            LEFT JOIN wards wd ON(wd.id=bd.ward_id)
        WHERE vs.status = 2 AND us.id = {$_GET['id']} ORDER BY add_date ASC";

$patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);
?>
<div class="card border-1 border-info">

    <div class="card-header text-dark header-elements-inline alpha-info">
        <h6 class="card-title" ><?= get_full_name($patient->id) ?></h6>
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


                            <label class="col-md-4"><b>Дата рождение:</b></label>
    						<div class="col-md-8 text-right">
    							<?= date('d.m.Y', strtotime($patient->dateBith)) ?>
    						</div>

                            <label class="col-md-4"><b>Адрес проживание:</b></label>
    						<div class="col-md-8 text-right">
    							г. <?= $patient->region ?> <?= $patient->residenceAddress ?>
    						</div>

                            <label class="col-md-4"><b>Адрес прописки:</b></label>
    						<div class="col-md-8 text-right">
    							г. <?= $patient->region ?> <?= $patient->registrationAddress ?>
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

                            <label class="col-md-6"><b>№ истории болезни:</b></label>
                            <div class="col-md-6 text-right">
                                <?= addZero($patient->visit_id) ?>
                            </div>

                            <label class="col-md-3"><b>Телефон:</b></label>
    						<div class="col-md-9 text-right">
    							<?= $patient->numberPhone ?>
    						</div>

                            <label class="col-md-3"><b>Пол:</b></label>
    						<div class="col-md-9 text-right">
    							<?= ($patient->gender) ? "Мужской": "Женский" ?>
    						</div>

                            <!-- <label class="col-md-3"><b>Аллергия:</b></label>
                            <div class="col-md-9 text-right">
                                <?= $patient->allergy ?>
                            </div> -->

    					</div>

                    </div>
                </fieldset>

                <?php
                $class_color_add = "text-success";
                if ($patient->direction) {

                    // Баланс пациента
                    $pl = 0;
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
                                    (SELECT IFNULL(SUM(item_cost), 0) FROM visit_price WHERE visit_id = vs.id AND item_type IN (2,4)) +
                                    (SELECT IFNULL(SUM(item_cost), 0) FROM visit_price WHERE visit_id = vs.id AND item_type = 3)
                                )
                                 'balance'
                            FROM users us
                                LEFT JOIN investment iv ON(iv.user_id = us.id)
                                LEFT JOIN beds bd ON(bd.user_id = us.id)
                                LEFT JOIN bed_type bdt ON(bdt.id = bd.types)
                                LEFT JOIN visit vs ON(vs.user_id = us.id AND vs.grant_id = vs.parent_id AND priced_date IS NULL)
                            WHERE us.id = $patient->id";
                    $price = $db->query($sql)->fetch(PDO::FETCH_OBJ);
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
                    <fieldset class="mb-3 row" style="margin-top: -40px; ">
                        <legend></legend>

                        <div class="col-md-6">
                            <div class="form-group row">

                                <label class="col-md-5"><b>Ответственный врач:</b></label>
                                <div class="col-md-7 text-right <?= ($patient->grant_id == $_SESSION['session_id']) ? "text-success" : "text-primary" ?>">
                                    <?= get_full_name($patient->grant_id) ?>
                                </div>

                                <label class="col-md-4"><b>Размещён:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= $patient->floor ?> этаж <?= $patient->ward ?> палата <?= $patient->bed ?> койка
                                </div>

                                <label class="col-md-4"><b>Дата размещёния:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= date('d.m.Y  H:i', strtotime($patient->add_date)) ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">

                                <label class="col-md-4"><b>Баланс:</b></label>
                                <div class="col-md-8 text-right <?= $class_card_balance ?>" id="id_selector_balance" data-balance_status="<?= $id_selector_balance ?>">
                                    <?= number_format($price->balance) ?>
                                </div>

                                <label class="col-md-3"><b>Прибывание:</b></label>
                                <div class="col-md-9 text-right">
                                    <?php
                                    $dr= date_diff(new \DateTime(), new \DateTime($patient->add_date));
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
                                <?php if ($patient->grant_id == $_SESSION['session_id']): ?>
                                    <div class="col-md-8 text-right text-primary" data-toggle="modal" data-target="#modal_discharge_date">
                                        <?= ($patient->discharge_date) ? date('d.m.Y', strtotime($patient->discharge_date)) : "Назначить дату выписки" ?>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-8 text-right <?= ($patient->discharge_date) ? "text-primary" : "text-danger" ?>">
                                        <?= ($patient->discharge_date) ? date('d.m.Y', strtotime($patient->discharge_date)) : "Не назначено" ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                    </fieldset>
                    <?php
                }
                ?>

            </div>

            <div class="col-md-12">
                <div class="text-right">
                    <button data-grant_id="<?= $patient->grant_id ?>" data-parent="<?= get_full_name($_SESSION['session_id']) ?>" id="sweet_call_nurce" data-btn="Вызвать" data-question="Вы точно хотите срочно вызвать врача!" class="btn btn-outline-danger btn-md">Вызвать</button>
                </div>
            </div>

        </div>

    </div>

</div>
