<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$sql = "SELECT
            op.id 'pk', op.user_id 'id', vs.id 'visit_id', vs.grant_id, op.oper_date,
            vs.accept_date, vs.direction, vs.add_date, vs.discharge_date,
            vs.complaint, op.completed, op.item_id, op.item_name, op.item_cost
        FROM operation op
            LEFT JOIN visit vs ON (vs.id = op.visit_id)
        WHERE op.id = {$_GET['pk']}";

$patient = $db->query($sql)->fetch(PDO::FETCH_OBJ);

$total_opetrator_price = $total_service_price = $total_preparats_price = $total_other_price = 0;

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
    <h3> <b>Операция:</b> <?= $patient->item_name ?></h3>
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
            <?php if ($activity and permission(11) and (!$patient->completed or ($patient->completed and $_GET['type'] == 1))): ?>
                <a class="float-right text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add">
        			<i class="icon-plus22"></i>Добавить
        		</a>
            <?php endif; ?>
        </legend>

        <div class="card border-1 border-<?= $color ?>">

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="line_stat"></div>

                    <div style="display:none;" id="content_dinamic">
                        <?php if (!isset($_GET['type'])): ?>
                            <?php $sql_stat = "SELECT pressure, pulse, temperature, saturation, time FROM operation_stats WHERE operation_id=$patient->pk ORDER BY add_date DESC"; ?>
                        <?php elseif ($_GET['type'] == 1): ?>
                            <?php $sql_stat = "SELECT pressure, pulse, temperature, saturation, time FROM operation_stats WHERE operation_id=$patient->pk AND add_date >= \"$patient->completed\" ORDER BY add_date DESC"; ?>
                        <?php else: ?>
                            <?php $sql_stat = "SELECT pressure, pulse, temperature, saturation, time FROM operation_stats WHERE operation_id=$patient->pk AND add_date < \"$patient->completed\" ORDER BY add_date DESC"; ?>
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

        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <i class="icon-file-text mr-2"></i>Протокол операции
            <?php if ($activity and permission(5) and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and (!$patient->completed or ($patient->completed and $_GET['type'] == 1))): ?>
                <a class="float-right text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add_inspection">
        			<i class="icon-plus22"></i>Добавить
        		</a>
            <?php endif; ?>
        </legend>

        <div class="card">

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
                            <?php if (!isset($_GET['type'])): ?>
                                <?php $sql_inspect = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NOT NULL ORDER BY add_date DESC"; ?>
                            <?php elseif ($_GET['type'] == 1): ?>
                                <?php $sql_inspect = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NOT NULL AND add_date >= \"$patient->completed\" ORDER BY add_date DESC"; ?>
                            <?php else: ?>
                                <?php $sql_inspect = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NOT NULL AND add_date < \"$patient->completed\" ORDER BY add_date DESC"; ?>
                            <?php endif; ?>

                            <?php foreach ($db->query($sql_inspect) as $row): ?>
                                <tr>
                                    <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                    <td class="text-right">
                                        <button onclick="Check('<?= viv('card/operation_inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-<?= $color ?> btn-sm legitRipple"><i class="icon-eye"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <i class="icon-file-text mr-2"></i>Протокол анестезии
            <?php if ($activity and permission(11) and (!$patient->completed or ($patient->completed and $_GET['type'] == 1))): ?>
                <a class="float-right text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add_inspection">
        			<i class="icon-plus22"></i>Добавить
        		</a>
            <?php endif; ?>
        </legend>

        <div class="card">

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
                            <?php if (!isset($_GET['type'])): ?>
                                <?php $sql_inspect_any = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NULL ORDER BY add_date DESC"; ?>
                            <?php elseif ($_GET['type'] == 1): ?>
                                <?php $sql_inspect_any = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NULL AND add_date >= \"$patient->completed\" ORDER BY add_date DESC"; ?>
                            <?php else: ?>
                                <?php $sql_inspect_any = "SELECT * FROM operation_inspection WHERE operation_id = $patient->pk AND status IS NULL AND add_date < \"$patient->completed\" ORDER BY add_date DESC"; ?>
                            <?php endif; ?>

                            <?php foreach ($db->query($sql_inspect_any) as $row): ?>
                                <tr>
                                    <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                    <td><?= get_full_name($row['parent_id']) ?></td>
                                    <td class="text-right">
                                        <button onclick="Check('<?= viv('card/operation_inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-<?= $color ?> btn-sm legitRipple"><i class="icon-eye"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

<!-- ==> 2 Stage <== -->

    <!-- Service -->
    <div class="col-md-7">

        <legend class="font-weight-semibold text-uppercase font-size-sm">
    		<i class="icon-bag mr-2"></i>Услуги анестезиолога
            <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission([8,11]))): ?>
                <a class="float-right text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add_service">
        			<i class="icon-plus22"></i>Добавить
        		</a>
            <?php endif; ?>
    	</legend>

        <div class="card border-1 border-<?= $color ?>">

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="bg-<?= $color ?>">
                            <th style="width:84%">Услуга</th>
                            <th class="text-right">Сумма</th>
                            <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission([8,11]))): ?>
                                <th class="text-right" style="width:50px">Действия</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($patient->direction): ?>
                            <?php foreach ($db->query("SELECT ops.id, ops.item_name, ops.item_cost FROM operation_service ops WHERE ops.operation_id = $patient->pk ORDER BY ops.item_name ASC") as $row): ?>
                                <tr>
                                    <td><?= $row['item_name'] ?></td>
                                    <td class="text-right text-success">
                                        <?php
                                        $total_service_price += $row['item_cost'];
                                        echo number_format($row['item_cost'], 1);
                                        ?>
                                    </td>
                                    <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission([8,11]))): ?>
                                        <td class="text-right">
                                            <div class="list-icons">
                                                <button onclick="Delete('<?= del_url($row['id'], 'OperationServiceModel') ?>')" class="btn btn-sm list-icons-item text-danger"><i class="icon-trash"></i></button>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="table-secondary">
                                <th colspan="1" class="text-right">Итого:</th>
                                <th class="text-right"><?= number_format($total_service_price, 1) ?></th>
                                <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission([8,11]))): ?>
                                    <th></th>
                                <?php endif; ?>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- Member -->
    <div class="col-md-5">

        <legend class="font-weight-semibold text-uppercase font-size-sm">
    		<i class="icon-reading mr-2"></i>Персонал
            <?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
                <a class="float-right text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add_member">
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
                        <?php if ($patient->direction): ?>
                            <?php foreach ($db->query("SELECT * FROM operation_member WHERE operation_id = $patient->pk") as $row): ?>
                                <tr>
                                    <td><?= $row['member_name'] ?><?= ($row['member_operator']) ? " <span class=\"text-$color\">(Оператор)</span>" : "" ?></td>
                                    <td class="text-right text-success">
                                        <?php
                                        $total_opetrator_price += $row['price'];
                                        echo number_format($row['price'], 1);
                                        ?>
                                    </td>
                                    <?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
                                        <td class="text-right">
                                            <div class="list-icons">
                                                <button onclick="UpdateOperations('<?= up_url($row['id'], 'OperationMemberModel') ?>', 'member')" class="btn btn-sm list-icons-item text-primary"><i class="icon-pencil7"></i></button>
                                                <button onclick="Delete('<?= del_url($row['id'], 'OperationMemberModel') ?>')" class="btn btn-sm list-icons-item text-danger"><i class="icon-trash"></i></button>
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
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <?php if(module('module_pharmacy')): ?>    
        <!-- Preparat -->
        <div class="col-md-7">

            <legend class="font-weight-semibold text-uppercase font-size-sm">
                <i class="icon-aid-kit mr-2"></i>Препараты
                <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(7))): ?>
                    <a class="float-right text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add_preparat">
                        <i class="icon-plus22"></i>Добавить
                    </a>
                <?php endif; ?>
            </legend>

            <div class="card border-1 border-<?= $color ?>">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-<?= $color ?>">
                                <th style="width:70%">Препарат</th>
                                <th class="text-center">Количество</th>
                                <th class="text-right">Цена</th>
                                <th class="text-right">Сумма</th>
                                <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(7))): ?>
                                    <th class="text-right" style="width:50px">Действия</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($patient->direction): ?>
                                <?php foreach ($db->query("SELECT opp.id, opp.item_name, opp.item_cost, opp.item_qty FROM operation_preparat opp WHERE opp.operation_id = $patient->pk ORDER BY opp.item_name ASC") as $row): ?>
                                    <tr>
                                        <td><?= $row['item_name'] ?></td>
                                        <td class="text-center"><?= $row['item_qty'] ?></td>
                                        <td class="text-right text-success"><?= number_format($row['item_cost'], 1);?> </td>
                                        <td class="text-right text-success">
                                            <?php
                                            $total_preparats_price += $row['item_qty'] * $row['item_cost'];
                                            echo number_format($row['item_qty'] * $row['item_cost'], 1);
                                            ?>
                                        </td>
                                        <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(7))): ?>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <button onclick="UpdateOperations('<?= up_url($row['id'], 'OperationPreparatModel') ?>', 'preparat')" class="btn btn-sm list-icons-item text-primary"><i class="icon-pencil7"></i></button>
                                                    <button onclick="Delete('<?= del_url($row['id'], 'OperationPreparatModel') ?>')" class="btn btn-sm list-icons-item text-danger"><i class="icon-trash"></i></button>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                <?php /* foreach ($db->query("SELECT scp.id, scp.qty, st.price, st.name, st.supplier, st.die_date from service_preparat scp LEFT JOIN storage st ON(st.id=scp.preparat_id) WHERE scp.service_id = $patient->item_id ORDER BY st.name ASC") as $row): ?>
                                    <tr>
                                        <td><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>)</td>
                                        <td class="text-center"><?= $row['qty'] ?></td>
                                        <td class="text-right text-success"><?= number_format($row['price'], 1);?> </td>
                                        <td class="text-right text-success">
                                            <?php
                                            $total_preparats_price += $row['qty'] * $row['price'];
                                            echo number_format($row['qty'] * $row['price'], 1);
                                            ?>
                                        </td>
                                        <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(7))): ?>
                                            <td class="text-right">
                                                <div class="list-icons">
                                                    <button class="btn btn-sm list-icons-item text-primary"><i class="icon-pencil7"></i></button>
                                                    <button class="btn btn-sm list-icons-item text-danger"><i class="icon-trash"></i></button>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; */ ?>
                                <tr class="table-secondary">
                                    <th colspan="3" class="text-right">Итого:</th>
                                    <th class="text-right"><?= number_format($total_preparats_price, 1) ?></th>
                                    <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(7))): ?>
                                        <th></th>
                                    <?php endif; ?>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    <?php endif; ?>

    <!-- Сonsumables -->
    <div class="col-md-5">

        <legend class="font-weight-semibold text-uppercase font-size-sm">
    		<i class="icon-puzzle3 mr-2"></i>Расходы
            <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(8))): ?>
                <a class="float-right text-<?= $color ?> mr-1" data-toggle="modal" data-target="#modal_add_consumables">
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
                        <?php if ($patient->direction): ?>
                            <?php foreach ($db->query("SELECT opc.id, opc.item_name, opc.item_cost FROM operation_consumables opc WHERE opc.operation_id = $patient->pk ORDER BY opc.item_name ASC") as $row): ?>
                                <tr>
                                    <td><?= $row['item_name'] ?></td>
                                    <td class="text-right text-success">
                                        <?php
                                        $total_other_price += $row['item_cost'] ;
                                        echo number_format($row['item_cost'], 1);
                                        ?>
                                    </td>
                                    <?php if ($activity and $patient->direction and !$patient->completed and ($patient->grant_id == $_SESSION['session_id'] or permission(8))): ?>
                                        <td class="text-right">
                                            <div class="list-icons">
                                                <button onclick="UpdateOperations('<?= up_url($row['id'], 'OperationConsumablesModel') ?>', 'consumables')" class="btn btn-sm list-icons-item text-primary"><i class="icon-pencil7"></i></button>
                                                <button onclick="Delete('<?= del_url($row['id'], 'OperationConsumablesModel') ?>')" class="btn btn-sm list-icons-item text-danger"><i class="icon-trash"></i></button>
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
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

<!-- ==> 3 Stage <== -->

    <div class="col-md-12">

        <legend class="font-weight-semibold text-uppercase font-size-sm">
    		<i class="icon-stats-bars mr-2"></i>Итог
    	</legend>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <tbody>

                    <tr class="table-secondary">
                        <td>Начальная стоимость операции</td>
                        <td class="text-right text-success"><?= number_format($patient->item_cost, 1) ?></td>
                    </tr>
                    <tr class="table-secondary">
                        <td>Стоимость персонала операции</td>
                        <td class="text-right text-success"><?= number_format($total_opetrator_price, 1) ?></td>
                    </tr>
                    <tr class="table-secondary">
                        <td>Стоимость услуг анестезиолога</td>
                        <td class="text-right text-success"><?= number_format($total_service_price, 1) ?></td>
                    </tr>
                    <?php if(module('module_pharmacy')): ?>    
                        <tr class="table-secondary">
                            <td>Стоимость препаратов</td>
                            <td class="text-right text-success"><?= number_format($total_preparats_price, 1) ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr class="table-secondary">
                        <td>Стоимость расходов</td>
                        <td class="text-right text-success"><?= number_format($total_other_price, 1) ?></td>
                    </tr>

                    <tr class="table-<?= $color ?>">
                        <th>Общая стоимость операции</th>
                        <th class="text-right text-default"><?= number_format($total_opetrator_price + $total_service_price + $total_preparats_price + $total_other_price + $patient->item_cost, 1) ?></th>
                    </tr>

                </tbody>
            </table>
        </div>

        <?php if ($activity and $patient->grant_id == $_SESSION['session_id'] and !$patient->completed): ?>
            <?php if(strtotime($patient->oper_date) <= strtotime(date('Y-m-d H:i'))): ?>
                <div class="text-right">
                    <button onclick="Finish_date('<?= $patient->pk ?>', '<?= $patient->visit_id ?>', '<?= $patient->oper_date ?>')" class="btn btn-outline-success btn-sm mt-2">Завершить</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

<?php if ($activity): ?>
    <div id="modal_add" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-3 border-info">

                <?= (new OperationStatsModel)->form() ?>

            </div>
        </div>
    </div>

    <div id="modal_add_inspection" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <?php (new OperationInspectionModel)->form() ?>

            </div>
        </div>
    </div>

    <div id="modal_add_member" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-3 border-info">

                <div id="form_card_member">

                    <?= (new OperationMemberModel)->form() ?>

                </div>

            </div>
        </div>
    </div>

    <div id="modal_add_service" class="modal fade" tabindex="-1">
    
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Добавить услугу анестезиолога</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <?php (new OperationServiceModel)->form() ?>
                </div>

            </div>
        </div>
    </div>

    <?php if(module('module_pharmacy')): ?>    
        <div id="modal_add_preparat" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div id="form_card_preparat">

                        <?php (new OperationPreparatModel)->form() ?>

                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <div id="modal_add_consumables" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div id="form_card_consumables">

                    <?php (new OperationConsumablesModel)->form() ?>

                </div>

            </div>
        </div>
    </div>

    <div id="modal_finish_date" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-3 border-info">

                <?php (new OperationModel)->form_finish() ?>

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

    function Delete(events) {
        event.preventDefault();
        $.ajax({
            type: "GET",
            url: events,
            success: function (data) {
                var result = JSON.parse(data);

                if (result.status == "success") {
                    new Noty({
                        text: result.message,
                        type: 'success'
                    }).show();
                }else {
                    new Noty({
                        text: result.message,
                        type: 'error'
                    }).show();
                }

                Title_up();
            },
        });
    }

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

    function UpdateOperations(events, clas) {
        $.ajax({
            type: "GET",
            url: events,
            success: function (result) {
                $('#modal_add_'+clas).modal('show');
                $('#form_card_'+clas).html(result);
            },
        });
    };

    function Finish_date(pk, visit_id, date) {
        $('#modal_finish_date').modal('show');
        $('#finish_id').val(pk);
        $('#visit_id').val(visit_id);
        document.getElementById('OperationModel_form').dataset.c_date = date;
    };
</script>
