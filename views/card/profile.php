<?php
use Mixin\Hell;
importModel('Region');
$region = (new Region)->byId($patient->region_id);
?>
<div class="<?= $classes['card'] ?>">

    <div class="<?= $classes['card-header'] ?>">
        <h5 class="card-title"><b><?= patient_name($patient) ?></b></h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3">
                <div class="card-img-actions text-center">
                    <img class="card-img-top img-fluid" src="<?= stack("assets/images/background_card.jpg")?>" alt="" style="width:80% !important;">
                </div>
                <fieldset class="mb-3 row">

                    <?php if($initial = (new Table($db, 'visit_initial'))->where("visit_id = $patient->visit_id")->get_row()): ?>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4"><b>Вес:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= $initial->weight ?>
                                </div>
                            </div>
                            <div class="form-group row" style="margin-top: -25px;">
                                <label class="col-md-8"><b>Температура:</b></label>
                                <div class="col-md-4 text-right">
                                    <?= $initial->temperature ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4"><b>Рост:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= $initial->height ?>
                                </div>
                            </div>
                        </div>
                        <?php if($activity and permission(7) and !$patient->completed): ?>
                            <div class="col-md-12 text-center" style="margin-top: -25px;">
                                <span onclick="UpdateProfile('<?= up_url($initial->id, 'VisitInitialModel') ?>&visit_id=<?= $patient->visit_id ?>')" class="text-primary">Изменить параметры</span>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if($activity and permission(7) and !$patient->completed): ?>
                            <div class="col-md-12 text-center" style="margin-top: -15px;">
                                <span onclick="UpdateProfile('<?= up_url(null, 'VisitInitialModel') ?>&visit_id=<?= $patient->visit_id ?>')" class="text-primary">Задать параметры</span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                </fieldset>
            </div>

            <div class="col-md-9" style="font-size: 0.9rem">

                <fieldset class="mb-3 row">

                    <div class="col-md-6">

                        <div class="form-group row">

                            <label class="col-md-4"><b>Статус:</b></label>
                            <div class="col-md-8 text-right">

                                <?php if ( $patient->direction ): ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Стационарный</span>
                                <?php else: ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
                                <?php endif; ?>

                                <?php if ( $patient->completed ): ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>
                                <?php else: ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
                                <?php endif; ?>

                            </div>
                            
                            <?php if ( $patient->parad_id ): ?>
                                <label class="col-md-6"><b>№ истории болезни:</b></label>
                                <div class="col-md-6 text-right">
                                    <?= addZero($patient->parad_id) ?>
                                </div>  
                            <?php endif; ?>

                            <label class="col-md-4"><b>Дата рождение:</b></label>
    						<div class="col-md-8 text-right">
    							<?= date_f($patient->birth_date) ?>
    						</div>

                            <label class="col-md-4"><b>Адрес проживания:</b></label>
    						<div class="col-md-8 text-right">
    							<?= $region->name ?> <?= $patient->address_residence ?>
    						</div>

                            <label class="col-md-4"><b>Адрес прописки:</b></label>
				            <div class="col-md-8 text-right">
                               <?= $region->name ?> <?= $patient->address_registration ?>
    						</div>

                            <label class="col-md-4"><b>Дата назначения визита:</b></label>
    						<div class="col-md-8 text-right">
    							<?= date('d.m.Y  H:i', strtotime($patient->add_date)) ?>
    						</div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group row">

                        <label class="col-md-4"><b>Статус пациента:</b></label>
                            <div class="col-md-8 text-right">

                                <?php if ( $patient->status ): ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
                                <?php else: ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>
                                <?php endif; ?>
                                <?php if ( $patient->is_foreigner ): ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-teal text-teal">Иностранец</span>
                                <?php else: ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-brown text-brown">Местный</span>
                                <?php endif; ?>
                                <?php if ( $patient->order ): ?>
                                    <span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Ордер №<?= $db->query("SELECT order_number FROM visit_orders WHERE id = $patient->order")->fetchColumn() ?></span>
                                <?php endif; ?>

                            </div>

    						<label class="col-md-3"><b>ID:</b></label>
    						<div class="col-md-9 text-right">
    							<?= addZero($patient->id) ?>
    						</div>

                            <label class="col-md-3"><b>Телефон:</b></label>
    						<div class="col-md-9 text-right">
    							<?= $patient->phone_number ?>
    						</div>

                            <label class="col-md-3"><b>Пол:</b></label>
    						<div class="col-md-9 text-right">
    							<?= ($patient->gender) ? "Мужской": "Женский" ?>
    						</div>

                            <?php
                            $icd_attr = "";
                            if ( $activity and (!$patient->direction or ($patient->direction and is_grant())) ) {
                                $icd_attr = "onclick='UpdateProfile(`".up_url($patient->visit_id, "VisitIcdHistoryModel")."`)' class=\"text-primary\"";
                            }

                            $comment_attr = "";
                            if ( $activity and (!$patient->direction or ($patient->direction and is_grant())) ) {
                                $comment_attr = "onclick='UpdateProfile(`". Hell::apiGet('VisitSet', $patient->visit_id, 'form') ."`)' class=\"text-primary\"";
                            }
                            ?>
                            <label class="col-md-3"><b>Диагноз (ICD):</b></label>
                            <div class="col-md-9 text-right">
                                <?php if ( $activity and (!$patient->direction or ($patient->direction and is_grant())) ): ?>
                                    <?php if ($patient->icd_id): ?>
                                        <?php $icd = icd($patient->icd_id); ?>
                                        <span data-trigger="hover" data-popup="popover" data-html="true" data-placement="right" title="" 
                                            data-original-title="<div class='d-flex justify-content-between'><?= $icd['code'] ?><span class='font-size-sm text-muted'><?= get_full_name($patient->icd_autor) ?></span></div>"
                                            data-content="<?= $icd['decryption'] ?>" <?= $icd_attr ?>>
                                            <?= $icd['code'] ?></span>
                                    <?php else: ?>
                                        <span <?= $icd_attr ?>>Назначить диагноз</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($patient->icd_id): ?>
                                        <?php $icd = icd($patient->icd_id); ?>
                                        <span data-trigger="hover" data-popup="popover" data-html="true" data-placement="right" title="" 
                                            data-original-title="<div class='d-flex justify-content-between'><?= $icd['code'] ?><span class='font-size-sm text-muted'><?= get_full_name($patient->icd_autor) ?></span></div>"
                                            data-content="<?= $icd['decryption'] ?>">
                                            <?= $icd['code'] ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">Нет данных</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <label class="col-md-5"><b>Диагноз (Коммент):</b></label>
                            <div class="col-md-7 text-right">
                                <?php if ( $activity and (!$patient->direction or ($patient->direction and is_grant())) ): ?>
                                    <?php if ($patient->comment): ?>
                                        <span <?= $comment_attr ?>><?= $patient->comment ?></span>
                                    <?php else: ?>
                                        <span <?= $comment_attr ?>>Назначить диагноз</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($patient->comment): ?>
                                        <span><?= $patient->comment ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">Нет данных</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <?php if ($patient->completed): ?>
                                <label class="col-md-4"><b>Дата завершения визита:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= date('d.m.Y  H:i', strtotime($patient->completed)) ?>
                                </div>
                            <?php endif; ?>
                            
    					</div>

                    </div>

                </fieldset>

                <?php $class_color_add = "text-success"; ?>
                <?php if ($patient->direction): ?>
                    <?php
                    $vps = (new VisitModel)->price_status($patient->visit_id);
                    if ($vps['result'] >= 0) {
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

                                <?php
                                $grant_attr = "";
                                if ($activity and is_grant()) {
                                    $grant_attr = "onclick='UpdateProfile(`".up_url($patient->visit_id, "VisitModel", "form_grant")."`)' class=\"text-primary\"";
                                }
                                ?>
                                <label class="col-md-5"><b>Лечащий врач:</b></label>
                                <div class="col-md-7 text-right">
                                    <span <?= $grant_attr ?>><?= get_full_name($patient->grant_id) ?></span>
                                </div>

                                <?php
                                $loc_attr = "";
                                if ($activity and permission(7)) {
                                    $loc_attr = "onclick='UpdateProfile(`".up_url($patient->visit_id, "VisitBedsModel")."`)' class=\"text-primary\"";
                                }
                                ?>
                                <label class="col-md-4"><b>Размещён:</b></label>
                                <div class="col-md-8 text-right" >
                                    <span <?= $loc_attr ?> id="patient_location">
                                        <?= $db->query("SELECT location FROM visit_beds WHERE visit_id = $patient->visit_id AND end_date IS NULL")->fetchColumn() ?>
                                    </span>
                                </div>

                                <label class="col-md-4"><b>Дата размещения:</b></label>
                                <div class="col-md-8 text-right">
                                    <?= date_f($patient->add_date, 1) ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">

                                <?php if ($patient->completed): ?>
                                    <label class="col-md-4"><b>Прибыль:</b></label>
                                    <div class="col-md-8 text-right <?= $class_card_balance ?>" id="id_selector_balance" data-balance_status="<?= $id_selector_balance ?>">
                                        <?= number_format($vps['balance']) ?>
                                    </div>
                                <?php else: ?>
                                    <label class="col-md-4"><b>Баланс:</b></label>
                                    <div class="col-md-8 text-right <?= $class_card_balance ?>" id="id_selector_balance" data-balance_status="<?= $id_selector_balance ?>">
                                        <?= number_format($vps['result']) ?>
                                    </div>
                                <?php endif; ?>

                                <label class="col-md-3"><b>Прибывание:</b></label>
                                <div class="col-md-9 text-right"><?= minToStr($vps['bed-time']); ?></div>

                                <label class="col-md-4"><b>Дата выписки:</b></label>
                                <div class="col-md-8 text-right">
                                    <?php if ($activity): ?>
                                        <?php if (is_grant()): ?>
                                            <span class="text-primary" data-toggle="modal" data-target="#modal_discharge_date">
                                                <?= ($patient->discharge_date) ? date_f($patient->discharge_date) : "Назначить дату выписки" ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="<?= ($patient->discharge_date) ? "" : "text-danger" ?>">
                                                <?= ($patient->discharge_date) ? date_f($patient->discharge_date) : "Не назначено" ?>
                                            </span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span>
                                            <?= ($patient->completed) ? date_f($patient->completed, 1) : "Не выписан" ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                <?php endif; ?>

            </div>

            <?php if ($activity and $patient->direction and is_grant()): ?>
                <div id="modal_discharge_date" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-md">
                        <div class="<?= $classes['modal-global_content'] ?>">
                            <div class="<?= $classes['modal-global_header'] ?>">
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
                                    <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
                                    <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                                        <span class="ladda-label">Отправить</span>
                                        <span class="ladda-spinner"></span>
                                    </button>
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
                            if ($patient->direction and is_grant()) {
                                $button_tip = 'data-btn="Выписать" data-question="Вы точно хотите выписать пациента!" data-pk="'.$patient->visit_id.'"';
                                $button_inner = "Выписать";
                            }else {
                                $button_tip = 'data-btn="Завершить" data-question="Вы точно хотите завершить визит пациента!" data-pk="'.$patient->visit_id.'"';
                                $button_inner = "Завершить";
                                $button_tip2 = 'data-btn="Завершить" data-question="Вы точно хотите завершить визит пациента и назначить его на стационар!" data-pk="'.$patient->visit_id.'"';
                                $button_inner2 = "Завершить и назначить на стационар";
                            }
                            ?>
                            <?php if(!$patient->direction): ?>
                                <button id="sweet_visit_finish2" data-href="<?= up_url($patient->visit_id, 'VisitFinishStationar') ?>" <?= $button_tip2 ?> class="<?= $classes['btn-completed'] ?>">
                                    <i class="icon-paste2 mr-2"></i><?= $button_inner2 ?>
                                </button>
                            <?php endif; ?>
                            <button id="sweet_visit_finish" data-href="<?= up_url($patient->visit_id, 'VisitFinish') ?>" <?= $button_tip ?> class="<?= $classes['btn-completed'] ?>">
                                <i class="icon-paste2 mr-2"></i><?= $button_inner ?>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" id="verification_url" value="<?= viv('card/verificaton') ?>">

                <?php elseif (permission(7)): ?>

                    <div class="col-md-12">
                        <div class="text-right">
                            <button data-grant_id="<?= $patient->grant_id ?>" data-parent="<?= get_full_name($session->session_id) ?>" id="sweet_call_nurce" data-btn="Вызвать" data-question="Вы точно хотите срочно вызвать врача!" class="btn btn-outline-danger btn-sm">Вызвать</button>
                        </div>
                    </div>

                <?php endif; ?>

                <div id="modal_profile" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="<?= $classes['modal-global_content'] ?>" id="form_card_profile"></div>
                    </div>
                </div>

                <script type="text/javascript">

                    function UpdateProfile(events) {
                        $.ajax({
                            type: "GET",
                            url: events,
                            success: function (result) {
                                $('#modal_profile').modal('show');
                                $('#form_card_profile').html(result);
                            },
                        });
                    };

                </script>

            <?php endif; ?>

            <?php if (!$activity and (!$patient->is_active or $patient->completed) and $patient->direction): ?>

                <div class="col-md-12">
                    <div class="text-right">
                        <button onclick="Check_kwin('<?= viv('card/journal') ?>?pk=<?= $patient->visit_id ?>')" type="button" class="<?= $classes['btn-journal'] ?>"><i class="icon-book mr-1"></i> Дневник</button>
                        <button onclick="Print('<?= prints('document-5').'?pk='.$patient->visit_id ?>')" type="button" class="<?= $classes['btn-completed'] ?>"><i class="icon-paste2 mr-1"></i> АКТ</button>
                        <button onclick="Check_kwin('<?= viv('doctor/report-2') ?>?pk=<?= $patient->visit_id ?>')" type="button" class="<?= $classes['btn-completed'] ?>"><i class="icon-paste2 mr-1"></i> Выписка</button>
                    </div>
                </div>

                <div id="modal_report_kwin" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="<?= $classes['modal-global_content'] ?>" id="report_show_kwin">

                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    function Check_kwin(events) {
                        $.ajax({
                            type: "GET",
                            url: events,
                            success: function (result) {
                                $('#modal_report_kwin').modal('show');
                                $('#report_show_kwin').html(result);
                            },
                        });
                    };
                </script>

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
