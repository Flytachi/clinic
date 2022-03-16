<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$amb = (new VisitServicesModel())->as("vs")
        ->Data("vs.parent_id, vs.service_name, vs.patient_id")
        ->Join("visits v ON(v.id=vs.visit_id)")
        ->Where("v.direction IS NULL AND vs.division_id = {$_GET['pk']} AND vs.accept_date IS NOT NULL AND DATE_FORMAT(vs.add_date, '%Y-%m-%d') = CURRENT_DATE()")->list();
$sta = (new VisitServicesModel())->as("vs")
        ->Data()
        ->Join("visits v ON(v.id=vs.visit_id)")
        ->Where("v.direction IS NOT NULL AND vs.division_id = {$_GET['pk']} AND vs.accept_date IS NOT NULL AND DATE_FORMAT(vs.add_date, '%Y-%m-%d') = CURRENT_DATE()")->list();
?>
<div class="<?= $classes['modal-global_header'] ?>">
    <h5 class="modal-title"><?= (new DivisionModel())->byId($_GET['pk'])->title ?></h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body">
    <ul class="nav nav-tabs nav-tabs-solid nav-justified border-0">
        <li class="nav-item"><a href="#solid-justified-tab1" class="nav-link legitRipple active show" data-toggle="tab">
            Амбулатор <?php if(count($amb)) echo "<span class=\"badge bg-danger ml-auto\">" . count($amb) . "</span>" ?>
        </a></li>
        <li class="nav-item"><a href="#solid-justified-tab2" class="nav-link legitRipple" data-toggle="tab">
            Стационар <?php if(count($sta)) echo "<span class=\"badge bg-danger ml-auto\">" . count($sta) . "</span>" ?>
        </a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane fade active show" id="solid-justified-tab1">
            <div class="table-responsive card">
                <table class="table table-hover table-sm">
                    <thead class="<?= $classes['table-thead'] ?>">
                        <tr>
                            <th>Специалист</th>
                            <th>Услуга</th>
                            <th>Пациент</th>
                            <!-- <th class="text-center" style="width:210px">Действия</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($amb as $row): ?>
                            <tr>	
                                <td><?= get_full_name($row->parent_id) ?></td>
                                <td><?= $row->service_name ?></td>
                                <td><?= patient_name($row->patient_id) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="solid-justified-tab2">
            <div class="table-responsive card">
                <table class="table table-hover table-sm">
                    <thead class="<?= $classes['table-thead'] ?>">
                        <tr>
                            <th>Специалист</th>
                            <th>Услуга</th>
                            <th>Пациент</th>
                            <!-- <th class="text-center" style="width:210px">Действия</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sta as $row): ?>
                            <tr>	
                                <td><?= get_full_name($row->parent_id) ?></td>
                                <td><?= $row->service_name ?></td>
                                <td><?= patient_name($row->patient_id) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
</div>