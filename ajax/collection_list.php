<?php
require_once '../tools/warframe.php';
$session->is_auth();

$date_start = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
$date_end = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));

$price_up = $price_down = 0;
?>

<div class="row">

    <div class="col-md-6">
        <h4 class="text-center">Приход</h4>

        <div class="table-responsive card">
            <table class="table table-hover table-sm">
                <thead class="<?= $classes['table-thead'] ?>">
                    <tr>
                        <th>Дата</th>
                        <th>Кассир</th>
                        <th class="text-right">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($db->query("SELECT * FROM collection WHERE (DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN '$date_start' AND '$date_end') AND amount_bank > 0") as $row): ?>
                        <tr data-toggle="tooltip" title="<?= $row['comment'] ?>">
                            <td><?= date_f($row['add_date'], 1) ?></td>
                            <td><?= get_full_name($row['parent_id']) ?></td>
                            <td class="text-right text-success">
                                <?php $price_up += $row['amount_bank']; echo number_format($row['amount_bank']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <h4 class="text-center">Расход</h4>

        <div class="table-responsive card">
            <table class="table table-hover table-sm">
                <thead class="<?= $classes['table-thead'] ?>">
                    <tr>
                        <th>Дата</th>
                        <th>Кассир</th>
                        <th class="text-right">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($db->query("SELECT * FROM collection WHERE (DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN '$date_start' AND '$date_end') AND amount_bank < 0") as $row): ?>
                        <tr data-toggle="tooltip" title="<?= $row['comment'] ?>">
                            <td><?= date_f($row['add_date'], 1) ?></td>
                            <td><?= get_full_name($row['parent_id']) ?></td>
                            <td class="text-right text-danger">
                                <?php $price_down += $row['amount_bank']; echo number_format($row['amount_bank']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-12">

        <h4 class="text-center">Итог</h4>

        <div class="table-responsive card">
            <table class="table table-hover table-sm">
                <thead class="<?= $classes['table-thead'] ?>">
                    <tr>
                        <th>Информация</th>
                        <th class="text-right">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Приход</td>
                        <td class="text-right text-success"><?= number_format($price_up) ?></td>
                    </tr>
                    <tr>
                        <td>Расход</td>
                        <td class="text-right text-danger"><?= number_format($price_down) ?></td>
                    </tr>
                    <tr class="table-secondary">
                        <td>Итог</td>
                        <td class="text-right"><?= number_format($price_up + $price_down) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

