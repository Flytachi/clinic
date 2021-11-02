<div class="<?= $classes['card'] ?>">

    <div class="<?= $classes['card-header'] ?>">
        <h5 class="card-title"><b><?= client_name($patient->id) ?></b></h5>
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
                    <img class="card-img-top img-fluid" src="<?= stack("assets/images/background_card.jpg")?>" alt="">
                </div>
            </div>

            <div class="col-md-9" style="font-size: 0.9rem">

                <fieldset class="mb-3 row">

                    <div class="col-md-6">

                        <div class="form-group row">

                            <label class="col-md-4"><b>Статус:</b></label>
                            <div class="col-md-8 text-right">
                                <?php if ($patient->status): ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
                                <?php else: ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
                                <?php endif; ?>
                                <?php if ( $patient->is_foreigner ): ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-teal text-teal">Иностранец</span>
                                <?php else: ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-brown text-brown">Местный</span>
                                <?php endif; ?>
                            </div>

                            <label class="col-md-4"><b>Адрес проживания:</b></label>
    						<div class="col-md-8 text-right">
    							<?= $patient->region ?> <?= $patient->address_residence ?>
    						</div>

                            <label class="col-md-4"><b>Адрес прописки:</b></label>
				            <div class="col-md-8 text-right">
                               <?= $patient->region ?> <?= $patient->address_registration ?>
    						</div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group row">

                            <label class="col-md-3"><b>ID:</b></label>
                            <div class="col-md-9 text-right">
                                <?= addZero($patient->id) ?>
                            </div>

                            <label class="col-md-3"><b>Телефон:</b></label>
                            <div class="col-md-9 text-right">
                                <?= $patient->phone_number ?>
                            </div>

                            <label class="col-md-4"><b>Дата рождение:</b></label>
                            <div class="col-md-8 text-right">
                                <?= date_f($patient->birth_date) ?>
                            </div>

                            <label class="col-md-3"><b>Пол:</b></label>
                            <div class="col-md-9 text-right">
                                <?= ($patient->gender) ? "Мужской": "Женский" ?>
                            </div>

                        </div>

                    </div>

                    <!-- <div class="col-md-6">

                        <div class="form-group row">

                            <label class="col-md-8"><b>Количество курсов лечения:</b></label>
                            <div class="col-md-4 text-right">
                                100
                            </div>

                            <label class="col-md-8"><b>Количество стационарных курсов лечения:</b></label>
                            <div class="col-md-4 text-right">
                                100
                            </div>

                            <label class="col-md-8"><b>Количество амбулаторных курсов лечения:</b></label>
                            <div class="col-md-4 text-right">
                                100
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group row">

                            <label class="col-md-8"><b>Количество визитов:</b></label>
                            <div class="col-md-4 text-right">
                                100
                            </div>

                            <label class="col-md-8"><b>Количество стационарных визитов:</b></label>
                            <div class="col-md-4 text-right">
                                100
                            </div>

                            <label class="col-md-8"><b>Количество амбулаторных визитов:</b></label>
                            <div class="col-md-4 text-right">
                                100
                            </div>

                        </div>

                    </div> -->

                </fieldset>

            </div>

        </div>

    </div>

</div>