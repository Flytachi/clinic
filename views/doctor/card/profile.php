<?php
$sql = "SELECT vs.id, vs.user_id, us.dateBith, vs.complaint, us.numberPhone, us.allergy, us.gender, us.region, us.residenceAddress, us.registrationAddress, vs.accept_date, vs.direction, vs.add_date, vs.discharge_date, bds.floor, bds.ward, bds.num FROM visit vs LEFT JOIN users us ON (vs.user_id = us.id) LEFT JOIN beds bds ON (bds.user_id=vs.user_id) WHERE vs.status = 2 AND vs.id = {$_GET['id']}";
$patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);
// prit($patient);
?>
<div class="card border-1 border-info">

    <div class="card-header text-dark header-elements-inline alpha-info">
        <h6 class="card-title" ><?= get_full_name($patient->user_id) ?></h6>
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
    							<?= addZero($patient->user_id) ?>
    						</div>

                            <label class="col-md-3"><b>Телефон:</b></label>
    						<div class="col-md-9 text-right">
    							<?= $patient->numberPhone ?>
    						</div>

                            <label class="col-md-3"><b>Пол:</b></label>
    						<div class="col-md-9 text-right">
    							<?= ($patient->gender) ? "Мужской": "Женский" ?>
    						</div>

                            <label class="col-md-3"><b>Аллергия:</b></label>
                            <div class="col-md-9 text-right">
                                <?= $patient->allergy ?>
                            </div>

    					</div>

                    </div>

                    <!-- <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><b>Жалоба:</b></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" value="<?= $patient->complaint ?>" disabled>
                            </div>
                        </div>
                    </div> -->
                </fieldset>

                <?php
                if ($patient->direction) {
                    ?>

                    <fieldset class="mb-3 row" style="margin-top: -40px; ">
                        <legend></legend>

                        <div class="col-md-6">
                            <div class="form-group row">

                                <label class="col-md-4"><b>Размещён:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= $patient->floor ?> этаж <?= $patient->ward ?> палата <?= $patient->num ?> койка
                                </div>

                                <label class="col-md-4"><b>Дата размещёния:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= date('d.m.Y  H:i', strtotime($patient->add_date)) ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">

                                <label class="col-md-3"><b>Прибывание:</b></label>
                                <div class="col-md-9 text-right">
                                    2 дня
                                </div>

                                <label class="col-md-4"><b>Дата выписки:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= ($patient->discharge_date) ? date('d.m.Y  H:i', strtotime($patient->discharge_date)) : "Нет данных" ?>
                                </div>

                            </div>
                        </div>

                    </fieldset>
                    <?php
                }
                ?>

            </div>

            <div class="col-md-12">
                <div class="text-right">
                    <?php
                    if ($patient->direction) {
                        ?>
                        <a href="<?= up_url($patient->id, 'PatientFinish') ?>" onclick="return confirm('Вы точно хотите выписать пациента?')" class="btn btn-outline-danger btn-md"><i class="icon-paste2"></i> Выписать</a>
                        <?php
                    }else {
                        ?>
                        <a href="<?= up_url($patient->id, 'PatientFinish') ?>" onclick="return confirm('Вы точно хотите завершить визит пациента?')" class="btn btn-outline-danger btn-md"><i class="icon-paste2"></i> Завершить</a>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>

    </div>

</div>
