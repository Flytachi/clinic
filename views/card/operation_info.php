<?php
require_once '../../tools/warframe.php';
is_auth();
$sql = "SELECT
            op.id 'pk', op.user_id 'id', vs.id 'visit_id', vs.grant_id,
            vs.accept_date, vs.direction, vs.add_date, sc.name,
            vs.discharge_date, vs.complaint, op.completed
        FROM operation op
            LEFT JOIN visit vs ON (vs.id = op.visit_id)
            LEFT JOIN service sc ON (sc.id = op.service_id)
        WHERE vs.status = 2 AND op.id = {$_GET['pk']}";

$patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);

$total_opetrator_price = 0;

$activity = $_GET['activity'];

if (!isset($_GET['type'])) {
    $color = "info";
}else {
    if ($_GET['type'] == 1) {
        $color = "success";
    }else {
        $color = "warning";
    }
}
?>

<div class="col-md-12 text-center">
    <h3> <b>Операция:</b> <?= $patient->name ?></h3>
</div>

<div class="col-md-7">

    <div class="card border-1 border-<?= $color ?>">
        <div class="card-header header-elements-inline alpha-<?= $color ?>">
            <h5 class="card-title">Динамика показателей</h5>
            <?php if ($activity): ?>
                <div class="header-elements">
                    <div class="list-icons">
                        <?php if (level() == 11): ?>
                            <?php if (!$patient->completed or ($patient->completed and $_GET['type'] == 1)): ?>
                                <a class="list-icons-item text-success mr-2" data-toggle="modal" data-target="#modal_add">
                                    <i class="icon-plus22"></i>Добавить
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <div class="chart-container">
                <div class="chart has-fixed-height" id="line_stat"></div>

                <div style="display:none;" id="content_dinamic">
                    <?php if ($_GET['type'] == 1): ?>
                        <?php $sql_stat = "SELECT pressure, pulse, temperature, saturation, time FROM operation_stats WHERE operation_id=$patient->pk AND add_date >= '".$patient->completed."' ORDER BY add_date DESC"; ?>
                    <?php elseif ($_GET['type'] == 0): ?>
                        <?php $sql_stat = "SELECT pressure, pulse, temperature, saturation, time FROM operation_stats WHERE operation_id=$patient->pk AND add_date < '".$patient->completed."' ORDER BY add_date DESC"; ?>
                    <?php else: ?>
                        <?php $sql_stat = "SELECT pressure, pulse, temperature, saturation, time FROM operation_stats WHERE operation_id=$patient->pk ORDER BY add_date DESC"; ?>
                    <?php endif; ?>

                    <?php foreach ($db->query($sql_stat) as $row): ?>
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
            <?php if ($activity): ?>
                <?php if (level() == 5): ?>
                    <?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id'] and (!$patient->completed or ($patient->completed and $_GET['type'] == 1))): ?>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add_inspection">
                                    <i class="icon-plus22"></i>Осмотр
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-<?= $color ?>">
                        <th>Дата и время осмотра</th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($patient->direction): ?>
                        <?php if ($_GET['type'] == 1): ?>
                            <?php $sql_inspect = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NOT NULL AND add_date >= '".$patient->completed."' ORDER BY add_date DESC"; ?>
                        <?php elseif ($_GET['type'] == 0): ?>
                            <?php $sql_inspect = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NOT NULL AND add_date < '".$patient->completed."' ORDER BY add_date DESC"; ?>
                        <?php else: ?>
                            <?php $sql_inspect = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NOT NULL ORDER BY add_date DESC"; ?>
                        <?php endif; ?>

                        <?php foreach ($db->query($sql_inspect) as $row): ?>
                            <tr>
                                <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                <td class="text-right">
                                    <button onclick="Check('<?= viv('card/operation_inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-<?= $color ?> btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
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
            <?php if ($activity): ?>
                <?php if (level() == 11): ?>
                    <div class="header-elements">
                        <div class="list-icons">
                            <?php if (!$patient->completed or ($patient->completed and $_GET['type'] == 1)): ?>
                                <a class="list-icons-item text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add_inspection_anest">
                                    <i class="icon-plus22"></i>Осмотр
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-<?= $color ?>">
                        <th>Дата и время осмотра</th>
                        <th>Врач</th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($patient->direction): ?>
                        <?php if ($_GET['type'] == 1): ?>
                            <?php $sql_inspect_any = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NULL AND add_date >= '".$patient->completed."' ORDER BY add_date DESC"; ?>
                        <?php elseif ($_GET['type'] == 0): ?>
                            <?php $sql_inspect_any = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NULL AND add_date < '".$patient->completed."' ORDER BY add_date DESC"; ?>
                        <?php else: ?>
                            <?php $sql_inspect_any = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NULL ORDER BY add_date DESC"; ?>
                        <?php endif; ?>

                        <?php foreach ($db->query($sql_inspect_any) as $row): ?>
                            <tr>
                                <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                <td><?= get_full_name($row['parent_id']) ?></td>
                                <td class="text-right">
                                    <button onclick="Check('<?= viv('card/operation_inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-<?= $color ?> btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
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
            <?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add_member">
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
                        <th>Сумма</th>
                        <?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
                            <th class="text-right" style="width:50px">Действия</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($patient->direction): ?>
                        <?php foreach ($db->query("SELECT * FROM operation_member WHERE operation_id = $patient->pk") as $row): ?>
                            <tr>
                                <td><?= get_full_name($row['member_id']) ?></td>
                                <td class="text-right text-success">
                                    <?php
                                    $total_opetrator_price += $row['price'];
                                    echo number_format($row['price']);
                                    ?>
                                </td>
                                <?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
                                    <td class="text-right">
                                        <div class="list-icons">
                                            <a onclick="Update('<?= up_url($row['id'], 'MemberModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                            <a href="<?= del_url($row['id'], 'VisitMemberModel') ?>" onclick="return confirm('Вы уверены что хотите удалить члена персонала?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-secondary">
                            <th class="text-right">Итого:</th>
                            <th class="text-right"><?= number_format($total_opetrator_price) ?></th>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<?php if ($activity): ?>
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
<?php endif; ?>

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
