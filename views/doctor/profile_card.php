<?php
$patient = $db->query('SELECT vs.id, vs.user_id, us.dateBith, vs.complaint, us.numberPhone, us.allergy, us.gender, us.region, us.residenceAddress, us.registrationAddress FROM visit vs LEFT JOIN users us ON (vs.user_id = us.id) WHERE vs.status = 2 AND vs.id = '.$_GET['id'])->fetch(PDO::FETCH_OBJ);
// prit($patient);
?>
<div class="card border-1 border-info">

    <div class="card-header text-dark header-elements-inline alpha-info">
        <h6 class="card-title" ><b>Информация о пациенте</b></h6>
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

            <div class="col-md-9">

                <fieldset class="mb-3 row">

                    <div class="col-md-6">

                        <div class="form-group row">
    						<label class="col-form-label col-md-3"><b>ФИО пациента:</b></label>
    						<div class="col-md-9">
    							<input type="text" class="form-control" value="<?= get_full_name($patient->user_id) ?>" disabled>
    						</div>
    					</div>

                        <div class="form-group row">
    						<label class="col-form-label col-md-3"><b>Дата рождение:</b></label>
    						<div class="col-md-9">
    							<input type="text" class="form-control" value="<?= $patient->dateBith ?>" disabled>
    						</div>
    					</div>

                        <div class="form-group row">
    						<label class="col-form-label col-md-4"><b>Адрес проживание:</b></label>
    						<div class="col-md-8">
    							<input type="text" class="form-control" value="г. <?= $patient->region ?> <?= $patient->residenceAddress ?>" disabled>
    						</div>
    					</div>

                        <div class="form-group row">
    						<label class="col-form-label col-md-3"><b>Адрес прописки:</b></label>
    						<div class="col-md-9">
    							<input type="text" class="form-control" value="г. <?= $patient->region ?> <?= $patient->registrationAddress ?>" disabled>
    						</div>
    					</div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group row">
    						<label class="col-form-label col-md-3"><b>ID:</b></label>
    						<div class="col-md-9">
    							<input type="text" class="form-control" value="<?= addZero($patient->user_id) ?>" disabled>
    						</div>
    					</div>

                        <div class="form-group row">
    						<label class="col-form-label col-md-3"><b>Телефон:</b></label>
    						<div class="col-md-9">
    							<input type="text" class="form-control" value="<?= $patient->numberPhone ?>" disabled>
    						</div>
    					</div>

                        <div class="form-group row">
    						<label class="col-form-label col-md-3"><b>Пол:</b></label>
    						<div class="col-md-9">
    							<input type="text" class="form-control" value="<?= ($patient->gender) ? "Мужской": "Женский" ?>" disabled>
    						</div>
    					</div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3"><b>Аллергия:</b></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="<?= $patient->allergy ?>" disabled>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><b>Жалоба:</b></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" value="<?= $patient->complaint ?>" disabled>
                            </div>
                        </div>
                    </div>

                </fieldset>

            </div>

            <!-- <div class="col-md-9">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <h6 style="margin-top: 7px;"><b>ФИО пациента: </b> <?= get_full_name($patient->user_id) ?></h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <h6 style="margin-top: 7px;"><b>ID: </b> <?= addZero($patient->user_id) ?></h6>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 style="margin-top: 7px;"><b>Дата рождение: </b> <?= $patient->dateBith ?></h6>
                        </div>
                        <div class="col-md-6">
                            <h6 style="margin-top: 7px;"><b>Жалоба пациента: </b> <?= $patient->complaint ?></h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 style="margin-top: 7px;"><b>Телефон: </b> <?= $patient->numberPhone ?></h6>
                        </div>
                        <div class="col-md-6">
                            <h6 style="margin-top: 7px;"><b>Аллергия: </b> <?= $patient->allergy ?></h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 style="margin-top: 7px;"><b>Пол:</b> <?= $patient->gender ?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 style="margin-top: 7px;"><b>Адрес проживание:</b> г. <?= $patient->region ?> <?= $patient->residenceAddress ?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 style="margin-top: 7px;"><b>Адрес прописки:</b> г. <?= $patient->region ?> <?= $patient->registrationAddress ?></h6>
                        </div>
                    </div>
                </fieldset>
            </div> -->

        </div>

    </div>

</div>
