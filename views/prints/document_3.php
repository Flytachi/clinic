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

    <style media="print">
        body
        {
            font-size: 110% !important;
        }
    </style>

    <body>

        <div class="row">

            <div class="col-6">
                <img src="<?= $company['print_header_logotype'] ?>" width="480" height="105">
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

            <h3 class="text-center h1"><b>Выписка <?= $docs->id ?> № <?= $docs->visit_id ?></b></h3>

            <p>
                <?= stristr($docs->report, "Рекомендация:", true) ?>
            </p>

            <h4 class="text-center"><strong>Результаты визитов:</strong></h4>
            <p>
                <!-- Результаты визитов -->
                <?php foreach ($db->query("SELECT DISTINCT vs.division_id, ds.name, ds.title FROM visit vs LEFT JOIN division ds ON(ds.id=vs.division_id) WHERE ds.level NOT IN (12, 13) AND vs.user_id = $docs->id AND vs.completed IS NOT NULL AND vs.direction IS NOT NULL AND vs.laboratory IS NULL AND vs.service_id != 1 AND (DATE_FORMAT(vs.completed, '%Y-%m-%d %H:%i') BETWEEN \"$docs->add_date\" AND \"$docs->completed\")") as $div): ?>
                    <strong><?= $div['title'] ?>: </strong>
                    <ul>
                        <?php foreach ($db->query("SELECT * FROM visit WHERE user_id = $docs->id AND completed IS NOT NULL AND direction IS NOT NULL AND service_id != 1 AND (DATE_FORMAT(completed, '%Y-%m-%d %H:%i') BETWEEN \"$docs->add_date\" AND \"$docs->completed\") AND division_id = {$div['division_id']}") as $row): ?>
                            <li>
                                <strong><?= $row['report_title'] ?>:</strong>
                                <?= str_replace("Рекомендация:", '', stristr($row['report'], "Рекомендация:")); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </p>

            <h4 class="text-center"><strong>Результаты лабораторных и инструментальных исследований:</strong></h4>
            <p>
                <!-- Результаты лабораторных и инструментальных исследований -->
                <?php foreach ($db->query("SELECT vs.id, sc.id 'serv_id', sc.name FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.user_id = $docs->id AND vs.completed IS NOT NULL AND vs.laboratory IS NOT NULL AND vs.direction IS NOT NULL AND (DATE_FORMAT(vs.completed, '%Y-%m-%d %H:%i') BETWEEN \"$docs->add_date\" AND \"$docs->completed\")") as $any): ?>
                    <li>
                        <strong><?= $any['name'] ?>:</strong>
                        <?php foreach ($db->query("SELECT scl.name, vl.result FROM visit_analyze vl LEFT JOIN service_analyze scl ON(scl.id=vl.analyze_id) WHERE vl.visit_id = {$any['id']} AND vl.service_id = {$any['serv_id']}") as $row): ?>
                            <?= $row['name'] ?> - <?= $row['result'] ?>;
                        <?php endforeach; ?>
                    </li>
                <?php endforeach; ?>
            </p>

            <div class="table-responsive card">
                <table class="table table-bordered table-sm">
                    <tbody>

                        <!-- Результаты лечения -->
                        <!-- <tr>
                            <td colspan="2">
                                <strong>Лечение: </strong><br>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </td>
                        </tr> -->

                        <!-- Рекомендация -->
                        <td>
                            <strong>Рекомендация:</strong>
                        </td>
                        <td>
                            <?= str_replace("Рекомендация:", '', stristr($docs->report, "Рекомендация:")) ?>
                        </td>

                    </tbody>
                </table>
            </div>

        </div>

        <div class="row">
            <div class="col-4"></div>
            <div class="col-4 h5 text-left">
                <strong>Лечащий врач</strong>
            </div>
            <div class="col-4 h6 text-right">
                <em><strong><?= get_full_name($docs->parent_id) ?></strong></em>
            </div>
        </div>

        <div class="row">
            <div class="col-4"></div>
            <div class="col-4 h4 text-left">
                <strong>Глав.врач</strong>
            </div>
            <div class="col-4 h5 text-right">
                <em><strong><?= get_full_name($db->query("SELECT id FROM users WHERE user_level = 8")->fetch()['id']) ?></strong></em>
            </div>
        </div>

    </body>

</html>
