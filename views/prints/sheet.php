<?php
require_once '../../tools/warframe.php';
// is_auth();

$comp = $db->query("SELECT * FROM company")->fetchAll();
foreach ($comp as $value) {
    $company[$value['const_label']] = $value['const_value'];
}

$sql = "SELECT  us.id,
            vs.id 'visit_id',
            vs.parent_id,
            wd.floor, wd.ward, bd.bed
        FROM users us
            LEFT JOIN visit vs ON(us.id=vs.user_id)
            LEFT JOIN beds bd ON (bd.user_id=us.id)
            LEFT JOIN wards wd ON(wd.id=bd.ward_id)
        WHERE
            vs.id={$_GET['id']} AND
            vs.direction IS NOT NULL AND
            vs.service_id = 1";
$docs = $db->query($sql)->fetch(PDO::FETCH_OBJ);
// prit($docs);
$old_date = 6; // Дни назад
$count_date = 10; // Количество отображемых дней
?>

<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <style media="print">
        body
        {
            font-size: 110% !important;
        }
    </style>

    <style>
        table.minimalistBlack thead th {
            font-size: 18px;
        }
        table.minimalistBlack tbody td {
            font-size: 16px;
        }
        table.minimalistBlack tfoot td {
            font-size: 17px;
        }
        table .trasform_text {
            text-align:center;
            white-space:nowrap;
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }
        table {
            text-align:center;
            table-layout:fixed;
            width:150%;
            border-collapse: collapse;
            border: 3px solid black;
        }

        .line {
            display:inline-block;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;   background:url(APNGImageWithWhiteBackgroundAndASingleDiagonalLineInTheMiddle.png);
            background-size:100% 100%;
        }
    </style>

    <body>

        <div class="table-responsive card line">
            
            <table class="minimalistBlack">
                <thead>
                    <tr>
                        <th style="width: 30px;" rowspan="3">№</th>
                        <th colspan="2">ID:<br><span style="font-weight:normal;"><?= addZero($docs->id) ?></span></th>
                        <th colspan="5">ФИО:<br><span style="font-weight:normal;"><?= get_full_name($docs->id) ?></span></th>
                        <th colspan="5">Расположение:<br><span style="font-weight:normal;"><?= $docs->floor ?> этаж <?= $docs->ward ?> палата <?= $docs->bed ?> койка</span></th>
                        <th colspan="4">Врач:<br><span style="font-weight:normal;"><?= get_full_name($docs->parent_id) ?></span></th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="16">Лист врачебных назначений</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="4">Назначения</th>
                        <th>Вр.</th>
                        <th>Исп.</th>
                       <?php for($i=-$old_date; $i < ($count_date - $old_date); $i++): ?>
                            <?php $date = new DateTime('+'.$i.' day'); ?>
                            <td height="55px" class="trasform_text" width='50%'><b><?= $date->format('d.m') ?></b></td>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $s=1;foreach ($db->query("SELECT * FROM bypass WHERE user_id = $docs->id AND visit_id = $docs->visit_id") as $bypass): ?>
                        <tr>
                            <td rowspan="2"><?= $s++ ?></td>
                            <td rowspan="2" colspan="4" style="font-size: 100% !important;">
                                <?php foreach ($db->query("SELECT * FROM bypass_preparat WHERE bypass_id = {$bypass['id']}") as $bypass_preparat): ?>
                                    <?= $bypass_preparat['qty'] ." - ". $bypass_preparat['preparat_name'] ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td rowspan="2" class="text-center">
                                <?php foreach ($db->query("SELECT * FROM bypass_time WHERE bypass_id = {$bypass['id']}") as $bypass_time): ?>
                                    <?= date("H:i", strtotime($bypass_time['time'])) ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td>Вр:</td>
                            <?php for($i=-$old_date; $i < ($count_date - $old_date); $i++): ?>
                                <?php $date = new DateTime('+'.$i.' day'); ?>
                                <td class="text-center">
                                    <?php foreach ($db->query("SELECT * FROM bypass_date WHERE bypass_id = {$bypass['id']} AND date = \"{$date->format('Y-m-d')}\" AND status IS NOT NULL") as $bypass_time): ?>
                                        &#10004;
                                    <?php endforeach; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td>Мед:</td>
                            <?php for($i=-$old_date; $i < ($count_date - $old_date); $i++): ?>
                                <?php $date = new DateTime('+'.$i.' day'); ?>
                                <td class="text-center">
                                    <?php foreach ($db->query("SELECT * FROM bypass_date WHERE bypass_id = {$bypass['id']} AND date = \"{$date->format('Y-m-d')}\" AND completed IS NOT NULL") as $bypass_time): ?>
                                        &#10004;
                                    <?php endforeach; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="text-center" colspan="7">Подпись врача</th>
                        <?php for($i=-$old_date; $i < ($count_date - $old_date); $i++): ?>
                            <td></td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="7">Подпись медсестры</th>
                        <?php for($i=-$old_date; $i < ($count_date - $old_date); $i++): ?>
                            <td></td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="7">Подпись больного</th>
                        <?php for($i=-$old_date; $i < ($count_date - $old_date); $i++): ?>
                            <td></td>
                        <?php endfor; ?>
                    </tr>
                </tfoot>

            </table>
        </div>

    </body>
</html>