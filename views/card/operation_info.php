<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$operation = (new Table($db, "visit_operations"))->where("id = {$_GET['pk']}")->order_by('add_date ASC')->get_row();
$patient = json_decode($_GET['patient']);
// dd($_GET);
// dd($operation);
// $sql = "SELECT
//             op.id 'pk', op.user_id 'id', vs.id 'visit_id', vs.grant_id, op.oper_date,
//             vs.accept_date, vs.direction, vs.add_date, vs.discharge_date,
//             vs.complaint, op.completed, op.item_id, op.item_name, op.item_cost
//         FROM visit_operations op
//             LEFT JOIN visits vs ON (vs.id = op.visit_id)
//         WHERE op.id = {$_GET['pk']}";

// $patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);

$total_opetrator_price = $total_service_price = $total_preparats_price = $total_other_price = 0;
$get_data = "&visit_id=$operation->visit_id";

$activity = $_GET['activity'];

if (!isset($_GET['type'])) {
    $color = "primary";
}else {
    if ($_GET['type'] == 1) {
        $color = "success";
    }else {
        $color = "warning";
    }
}
?>

<div class="col-md-12 text-center">
    <h3> <b>Операция:</b> <?= $operation->operation_name ?></h3>
</div>

<script type="text/javascript">
    function Title_up() {
        setTimeout(function(){
            Show_info(title_data_url);
        }, 500);
    };
</script>

<!-- ==> 1 Stage <== -->

    <div class="col-md-7">

        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <i class="icon-pulse2 mr-2"></i>Динамика показателей
            <?php if ($activity and !permission(11) and (!$patient->completed or ($patient->completed and $_GET['type'] == 1))): ?>
                <a onclick="UpdateOperations('<?= up_url($operation->id, 'VisitOperationStatsModel').$get_data ?>')" class="float-right text-<?= $color ?> mr-1">
        			<i class="icon-plus22"></i>Добавить
        		</a>
            <?php endif; ?>
        </legend>

        <div class="card border-1 border-<?= $color ?>">

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="line_stat"></div>

                    <div style="display:none;" id="content_dinamic">
                        <?php
                        if (!isset($_GET['type'])) $stats_where = "operation_id=$operation->id";
                        elseif ($_GET['type'] == 1) $stats_where = "operation_id=$operation->id AND add_date >= \"$patient->completed\"";
                        else $stats_where = "operation_id=$operation->id AND add_date < \"$patient->completed\"";
                        $operation_stats = (new Table($db, "visit_operation_stats"))->set_data("pressure, pulse, temperature, saturation, time")->where($stats_where)->order_by('add_date DESC');
                        ?>
                        <?php foreach ($operation_stats->get_table() as $row): ?>
                            <span class="chart_date"><?= date('H:i', strtotime($row->time)) ?></span>
                            <span class="chart_pressure"><?= $row->pressure ?></span>
                            <span class="chart_pulse"><?= $row->pulse ?></span>
                            <span class="chart_temperature"><?= $row->temperature ?></span>
                            <span class="chart_saturation"><?= $row->saturation ?></span>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>

    </div>

<!-- ==> 2 Stage <== -->

    <!-- Member -->
    <div class="col-md-5">

        <legend class="font-weight-semibold text-uppercase font-size-sm">
    		<i class="icon-reading mr-2"></i>Персонал
            <?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
                <a onclick="UpdateOperations('<?= up_url($operation->id, 'VisitOperationMembersModel').$get_data ?>')" class="float-right text-<?= $color ?> mr-1">
        			<i class="icon-plus22"></i>Добавить
        		</a>
            <?php endif; ?>
    	</legend>

        <div class="card border-1 border-<?= $color ?>">

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="bg-<?= $color ?>">
                            <th>ФИО</th>
                            <th>Сумма</th>
                            <?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
                                <th class="text-right" style="width:50px">Действия</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $operation_members = (new Table($db, "visit_operation_members"))->where("operation_id = $operation->id")->order_by('member_name ASC'); ?>
                        <?php foreach ($operation_members->get_table() as $row): ?>
                            <tr>
                                <td><?= $row->member_name ?><?= ($row->member_operator) ? " <span class=\"text-$color\">(Оператор)</span>" : "" ?></td>
                                <td class="text-right text-success">
                                    <?php
                                    $total_opetrator_price += $row->member_price;
                                    echo number_format($row->member_price, 1);
                                    ?>
                                </td>
                                <?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
                                    <td class="text-right">
                                        <div class="list-icons">
                                            <button onclick="UpdateOperations('<?= up_url($operation->id, 'VisitOperationMembersModel').$get_data.'&item='.$row->id ?>')" class="btn btn-sm list-icons-item text-primary"><i class="icon-pencil7"></i></button>
                                            <button onclick="Delete('<?= del_url($row->id, 'VisitOperationMembersModel') ?>')" class="btn btn-sm list-icons-item text-danger"><i class="icon-trash"></i></button>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-secondary">
                            <th class="text-right">Итого:</th>
                            <th class="text-right"><?= number_format($total_opetrator_price, 1) ?></th>
                            <?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- Сonsumables -->
    <div class="col-md-5">

        <legend class="font-weight-semibold text-uppercase font-size-sm">
    		<i class="icon-puzzle3 mr-2"></i>Расходы
            <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(8))): ?>
                <a onclick="UpdateOperations('<?= up_url($operation->id, 'VisitOperationConsumablesModel').$get_data ?>')" class="float-right text-<?= $color ?> mr-1">
        			<i class="icon-plus22"></i>Добавить
        		</a>
            <?php endif; ?>
    	</legend>

        <div class="card border-1 border-<?= $color ?>">

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="bg-<?= $color ?>">
                            <th style="width:84%;">Наименование</th>
                            <th class="text-right">Сумма</th>
                            <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(8))): ?>
                                <th class="text-right" style="width:50px">Действия</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $operation_consumables = (new Table($db, "visit_operation_consumables"))->where("operation_id = $operation->id")->order_by('item_name ASC'); ?>
                        <?php foreach ($operation_consumables->get_table() as $row): ?>
                            <tr>
                                <td><?= $row->item_name ?></td>
                                <td class="text-right text-success">
                                    <?php
                                    $total_other_price += $row->item_cost;
                                    echo number_format($row->item_cost, 1);
                                    ?>
                                </td>
                                <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(8))): ?>
                                    <td class="text-right">
                                        <div class="list-icons">
                                            <button onclick="UpdateOperations('<?= up_url($operation->id, 'VisitOperationConsumablesModel').$get_data.'&item='.$row->id ?>')" class="btn btn-sm list-icons-item text-primary"><i class="icon-pencil7"></i></button>
                                            <button onclick="Delete('<?= del_url($row->id, 'VisitOperationConsumablesModel') ?>')" class="btn btn-sm list-icons-item text-danger"><i class="icon-trash"></i></button>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-secondary">
                            <th colspan="1" class="text-right">Итого:</th>
                            <th class="text-right"><?= number_format($total_other_price, 1) ?></th>
                            <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(8))): ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>


<div id="modal_default" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
    </div>
</div>

<script type="text/javascript">

    function UpdateOperations(events) {
        $.ajax({
            type: "GET",
            url: events,
            success: function (result) {
                $('#modal_default').modal('show');
                $('#form_card').html(result);
            },
        });
    };

    function Delete(url, tr) {
        event.preventDefault();
        $.ajax({
            type: "GET",
            url: url,
            success: function (result) {
                var data = JSON.parse(result);

                if (data.status == "success") {
                    new Noty({
                        text: data.message,
                        type: 'success'
                    }).show();
                    
                }else {
                    new Noty({
                        text: data.message,
                        type: 'error'
                    }).show();
                }
                Title_up();

            },
        });
    };

</script>