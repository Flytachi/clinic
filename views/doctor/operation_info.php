<?php
require_once '../../tools/warframe.php';
is_auth();
$sql = "SELECT
            op.id 'pk', op.user_id 'id', vs.id 'visit_id', vs.grant_id,
            vs.accept_date, vs.direction, vs.add_date,
            vs.discharge_date, vs.complaint
        FROM operation op
            LEFT JOIN visit vs ON (vs.id = op.visit_id)
        WHERE vs.status = 2 AND op.id = {$_GET['pk']}";

$patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);
?>
<div class="col-md-7">

    <div class="card border-1 border-success">
        <div class="card-header header-elements-inline alpha-success">
            <h5 class="card-title">Динамика показателей</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <?php if (level() == 11): ?>
                        <a class="list-icons-item text-success mr-2" data-toggle="modal" data-target="#modal_add">
                            <i class="icon-plus22"></i>Добавить
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="chart-container">
                <div class="chart has-fixed-height" id="line_stat"></div>

                <div style="display:none;" id="content_dinamic">
                    <?php foreach ($db->query("SELECT pressure, pulse, temperature, saturation, time FROM operation_stats WHERE operation_id=$patient->pk ORDER BY add_date DESC") as $row): ?>
                        <span class="chart_date"><?= date('H:i', strtotime($row['time'])) ?></span>
                        <span class="chart_pressure"><?= $row['pressure'] ?></span>
                        <span class="chart_pulse"><?= $row['pulse'] ?></span>
                        <span class="chart_temperature"><?= $row['temperature'] ?></span>
                        <span class="chart_saturation"><?= $row['saturation'] ?></span>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="col-md-5">

    <div class="card">

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Операционный осмотр</h5>
            <?php if (level() == 5): ?>
                <?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item text-info mr-1" data-toggle="modal" data-target="#modal_add_inspection">
                                <i class="icon-plus22"></i>Осмотр
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-info">
                        <th>Дата и время осмотра</th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($patient->direction): ?>
                        <?php foreach ($db->query("SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NOT NULL ORDER BY add_date DESC") as $row): ?>
                            <tr>
                                <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                <td class="text-right">
                                    <button onclick="Check('<?= viv('doctor/operation_inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="card">

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Осмотр Анестезиолога</h5>
            <?php if (level() == 11): ?>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item text-primary mr-1" data-toggle="modal" data-target="#modal_add_inspection_anest">
                            <i class="icon-plus22"></i>Осмотр
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-info">
                        <th>Дата и время осмотра</th>
                        <th>Врач</th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($patient->direction): ?>
                        <?php foreach ($db->query("SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NULL ORDER BY add_date DESC") as $row): ?>
                            <tr>
                                <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                <td><?= get_full_name($row['parent_id']) ?></td>
                                <td class="text-right">
                                    <button onclick="Check('<?= viv('doctor/operation_inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="card">

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Персонал</h5>
            <?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item text-info mr-1" data-toggle="modal" data-target="#modal_add_member">
                            <i class="icon-plus22"></i>Добавить
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-info">
                        <th>ФИО</th>
                        <?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
                            <th class="text-right">Действия</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($patient->direction): ?>
                        <?php foreach ($db->query("SELECT * FROM operation_member WHERE operation_id = $patient->pk") as $row): ?>
                            <tr>
                                <td><?= get_full_name($row['member_id']) ?></td>
                                <?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
                                    <td class="text-right">
                                        <a href="<?= del_url($row['id'], 'VisitMemberModel') ?>" onclick="return confirm('Вы уверены что хотите удалить члена персонала?')" class="btn btn-outline-danger btn-sm legitRipple"><i class="icon-trash"></i></a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>


<div id="modal_add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-3 border-info">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Добавить примечание</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <?= OperationStatsModel::form() ?>

        </div>
    </div>
</div>


<div id="modal_add_inspection" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title">Осмотр</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <?php OperationInspectionModel::form() ?>

        </div>
    </div>
</div>

<div id="modal_add_inspection_anest" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title">Осмотр</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <?php OperationInspectionModel::form_anest() ?>

        </div>
    </div>
</div>

<div id="modal_add_member" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-3 border-info">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Добавить примечание</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <?= OperationMemberModel::form() ?>

        </div>
    </div>
</div>

<div id="modal_show" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-3 border-info" id="div_show">

        </div>
    </div>
</div>

<script type="text/javascript">
    function Check(events) {
        $.ajax({
            type: "GET",
            url: events,
            success: function (data) {
                $('#modal_show').modal('show');
                $('#div_show').html(data);
            },
        });
    };
</script>
