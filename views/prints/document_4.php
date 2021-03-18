<?php
require_once '../../tools/warframe.php';
is_auth();

$comp = $db->query("SELECT * FROM company")->fetchAll();
foreach ($comp as $value) {
    $company[$value['const_label']] = $value['const_value'];
}

$sql = "SELECT  us.id,
            us.dateBith,
            us.region,
            us.registrationAddress,
            vs.id 'visit_id',
            vs.parent_id,
            vs.report_title, vs.report,
            vs.add_date, vs.completed
        FROM users us
            LEFT JOIN visit vs ON(us.id=vs.user_id)
        WHERE
            vs.id={$_GET['id']} AND
            vs.direction IS NOT NULL AND
            vs.service_id = 1";
$docs = $db->query($sql)->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <body>

        <div class="row">

            <div class="col-6">
                <img src="<?= $company['print_header_logotype'] ?>" width="400" height="120">
            </div>

            <div class="col-6 text-right h3">
                <b>
                    <?= $company['print_header_title'] ?><br>
                    <?= $company['print_header_address'] ?><br>
                    <?= $company['print_header_phones'] ?>
                </b>
            </div>

        </div>

        <div class="my_hr-1"></div>
        <div class="my_hr-2"></div>

        <div class="text-left">
            <div class="h3">
                <b>Ф.И.О.: </b><?= get_full_name($docs->id) ?><br>
                <b>ID Пациента: </b><?= addZero($docs->id) ?><br>
                <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
                <b>Дата поступления: </b><?= date('d.m.Y H:i', strtotime($docs->add_date)) ?><br>
                <b>Дата выписки: </b><?= date('d.m.Y H:i', strtotime($docs->completed)) ?><br>
            </div>

            <h1 class="text-center"><b>АКТ сверки № <?= addZero($_GET['id']) ?></b></h1>

            <div class="table-responsive card">
                <table class="minimalistBlack">
                    <thead>
                        <tr id="text-h">
                            <th style="width: 40px !important;">№</th>
                            <th>Наименование</th>
                            <th class="text-center">Кол-во</th>
                            <th class="text-right" style="width: 200px;">Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total=0; $i=1; foreach ($db->query("SELECT id FROM visit WHERE physio IS NULL AND manipulation IS NULL AND laboratory IS NULL AND user_id = $docs->id AND accept_date BETWEEN \"$docs->add_date\" AND \"$docs->completed\"") as $value): ?>
                            <?php foreach ($db->query("SELECT * FROM visit_price WHERE visit_id = {$value['id']} AND item_type IN (1,2,3,4,5,101)") as $row): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row['item_name'] ?></td>
                                    <td class="text-center">1</td>
                                    <td class="text-right">
                                        <?php
                                        echo number_format($row['price_cash'] + $row['price_card'] + $row['price_transfer'], 1);
                                        $total += $row['price_cash'] + $row['price_card'] + $row['price_transfer'];
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                        <tr class="table-warning">
                            <td colspan="4" class="text-center"><b>Иследование лаборатории</b></td>
                        </tr>
                        <?php $i=1; foreach ($db->query("SELECT DISTINCT vp.item_id, vp.item_name, vp.price_cash, vp.price_card, vp.price_transfer FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE vs.laboratory IS NOT NULL AND vs.user_id = $docs->id AND vs.accept_date BETWEEN \"$docs->add_date\" AND \"$docs->completed\"") as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $row['item_name'] ?></td>
                                <td class="text-center">
                                    <?= $count = $db->query("SELECT vp.item_id FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE vs.laboratory IS NOT NULL AND vs.user_id = $docs->id AND vs.accept_date BETWEEN \"$docs->add_date\" AND \"$docs->completed\" AND vp.item_id = {$row['item_id']}")->rowCount() ?>
                                </td>
                                <td class="text-right">
                                    <?php
                                    echo number_format($count * ($row['price_cash'] + $row['price_card'] + $row['price_transfer']), 1);
                                    $total += $count * ($row['price_cash'] + $row['price_card'] + $row['price_transfer']);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <tr class="table-warning">
                            <td colspan="4" class="text-center"><b>Физиотерапия/Процедуры</b></td>
                        </tr>
                        <?php $i=1; foreach ($db->query("SELECT DISTINCT vp.item_id, vp.item_name, vp.price_cash, vp.price_card, vp.price_transfer FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE (vs.physio IS NOT NULL OR vs.manipulation IS NOT NULL) AND vs.user_id = $docs->id AND vs.accept_date BETWEEN \"$docs->add_date\" AND \"$docs->completed\"") as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $row['item_name'] ?></td>
                                <td class="text-center">
                                    <?= $count = $db->query("SELECT vp.item_id FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE (vs.physio IS NOT NULL OR vs.manipulation IS NOT NULL) AND vs.user_id = $docs->id AND vs.accept_date BETWEEN \"$docs->add_date\" AND \"$docs->completed\" AND vp.item_id = {$row['item_id']}")->rowCount() ?>
                                </td>
                                <td class="text-right">
                                    <?php
                                    echo number_format($count * ($row['price_cash'] + $row['price_card'] + $row['price_transfer']), 1);
                                    $total += $count * ($row['price_cash'] + $row['price_card'] + $row['price_transfer']);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfooter>
                        <tr class="table-secondary">
                            <td colspan="3" class="text-right"><b>Итог:</b></td>
                            <td class="text-right"><b><?= number_format($total, 1) ?></b></td>
                        </tr>
                    </tfooter>
                </table>
            </div>

        </div>

    </body>
</html>
