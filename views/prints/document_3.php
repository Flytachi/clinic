<?php
require_once '../../tools/warframe.php';
is_auth();
$sql = "SELECT  us.id,
            us.dateBith,
            us.region,
            us.registrationAddress,
            vs.id 'visit_id',
            vs.parent_id,
            vs.report_title, vs.report, vs.report_diagnostic, vs.report_description, vs.report_recommendation,
            vs.add_date, vs.completed
        FROM users us
            LEFT JOIN visit vs ON(us.id=vs.user_id)
        WHERE
            vs.id={$_GET['id']} AND
            vs.direction IS NOT NULL AND
            vs.service_id = 1 AND
            vs.completed IS NOT NULL";
$docs = $db->query($sql)->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <style media="screen">
        body
        {
            font-size: 120% !important;
        }
    </style>

    <body>

        <div class="row">

            <div class="col-6">
                <img src="<?= stack("assets/images/logo.png") ?>" width="480" height="105">
            </div>

            <div class="col-6 text-right h3">
                <b>
                    <?php include 'title.php' ?>
                </b>
            </div>

        </div>

        <div class="my_hr-1"></div>
        <div class="my_hr-2"></div>

        <div class="text-left">

            <h3 class="text-center h1"><b>Выписка <?= $docs->id ?> № <?= $docs->visit_id ?></b></h3>

            <div class="table-responsive card">
                <table class="table table-bordered table-sm">
                    <tbody>

                        <tr>
                            <td style="width: 250px">
                                <strong>Пациент:</strong>
                            </td>
                            <td>
                                <?= get_full_name($docs->id) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Дата рождения:</strong>
                            </td>
                            <td>
                                <?= ($docs->dateBith) ? date('d.m.Y', strtotime($docs->dateBith)) : '<span class="text-muted">Нет данных</span>' ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Адрес:</strong>
                            </td>
                            <td>
                                г. <?= $docs->region ?> <?= $docs->registrationAddress ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Дата поступления:</strong>
                            </td>
                            <td>
                                <?= ($docs->add_date) ? date('d.m.Y H:i', strtotime($docs->add_date)) : '<span class="text-muted">Нет данных</span>' ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Дата выписки:</strong>
                            </td>
                            <td>
                                <?= ($docs->completed) ? date('d.m.Y H:i', strtotime($docs->completed)) : '<span class="text-muted">Нет данных</span>' ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Клинический диагноз:</strong>
                            </td>
                            <td>
                                <?= ($docs->report) ? str_replace("Сопутствующие заболевания:", '', stristr(str_replace("Клинический диагноз:", '', stristr($docs->report, "Клинический диагноз:")), "Сопутствующие заболевания:", true)) : '<span class="text-muted">Нет данных</span>' ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Сопутствующие заболевания:</strong>
                            </td>
                            <td>
                                <?= ($docs->report) ? str_replace("Жалобы:", '', stristr(str_replace("Сопутствующие заболевания:", '', stristr($docs->report, "Сопутствующие заболевания:")), "Жалобы:", true)) : '<span class="text-muted">Нет данных</span>' ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Жалобы:</strong>
                            </td>
                            <td>
                                <?= ($docs->report) ? str_replace("Anamnesis morbi:", '', stristr(str_replace("Жалобы:", '', stristr($docs->report, "Жалобы:")), "Anamnesis morbi:", true)) : '<span class="text-muted">Нет данных</span>' ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Anamnesis morbi:</strong>
                            </td>
                            <td>
                                <?= ($docs->report) ? str_replace("Объективно:", '', stristr(str_replace("Anamnesis morbi:", '', stristr($docs->report, "Anamnesis morbi:")), "Объективно:", true)) : '<span class="text-muted">Нет данных</span>' ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong>Объективно: </strong>
                                <?= ($docs->report) ? str_replace("Рекомендация:", '', stristr(str_replace("Объективно:", '', stristr($docs->report, "Объективно:")), "Рекомендация:", true)) : '<span class="text-muted">Нет данных</span>' ?>
                            </td>
                        </tr>

                        <!-- Результаты визитов -->
                        <?php foreach ($db->query("SELECT DISTINCT vs.division_id, ds.name, ds.title FROM visit vs LEFT JOIN division ds ON(ds.id=vs.division_id) WHERE vs.user_id = $docs->id AND vs.completed IS NOT NULL AND vs.direction IS NOT NULL AND vs.laboratory IS NULL AND vs.service_id != 1 AND (DATE_FORMAT(vs.completed, '%Y-%m-%d %H:%i') BETWEEN \"$docs->add_date\" AND \"$docs->completed\")") as $div): ?>
                            <tr>
                                <td colspan="2">
                                    <strong><?= $div['title'] ?>: </strong>
                                    <ol>
                                        <?php foreach ($db->query("SELECT * FROM visit WHERE user_id = $docs->id AND completed IS NOT NULL AND direction IS NOT NULL AND service_id != 1 AND (DATE_FORMAT(completed, '%Y-%m-%d %H:%i') BETWEEN \"$docs->add_date\" AND \"$docs->completed\") AND division_id = {$div['division_id']}") as $row): ?>
                                            <li>
                                                <strong><?= $row['report_title'] ?>:</strong>
                                                <?= str_replace("Рекомендация:", '', stristr($row['report'], "Рекомендация:")); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ol>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- Результаты лабораторных и инструментальных исследований -->
                        <tr>
                            <td colspan="2" class="text-center">
                                <strong>Результаты лабораторных и инструментальных исследований:</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <ol>
                                    <?php foreach ($db->query("SELECT vs.id, sc.id 'serv_id', sc.name FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.user_id = $docs->id AND vs.completed IS NOT NULL AND vs.laboratory IS NOT NULL AND vs.direction IS NOT NULL AND (DATE_FORMAT(vs.completed, '%Y-%m-%d %H:%i') BETWEEN \"$docs->add_date\" AND \"$docs->completed\")") as $any): ?>
                                        <li>
                                            <strong><?= $any['name'] ?>:</strong><br>
                                            <?php foreach ($db->query("SELECT lat.name, la.result FROM laboratory_analyze la LEFT JOIN laboratory_analyze_type lat ON(lat.id=la.analyze_id) WHERE la.visit_id = {$any['id']} AND la.service_id = {$any['serv_id']}") as $row): ?>
                                                <?= $row['name'] ?> - <?= $row['result'] ?>;
                                            <?php endforeach; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ol>
                            </td>
                        </tr>

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
                            <?= ($docs->report) ? str_replace("Рекомендация:", '', stristr($docs->report, "Рекомендация:")) : '<span class="text-muted">Нет данных</span>' ?>
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
            <div class="col-4 h5 text-left">
                <strong>Глав.врач</strong>
            </div>
            <div class="col-4 h6 text-right">
                <em><strong><?= get_full_name($db->query("SELECT id FROM users WHERE user_level = 8")->fetch()['id']) ?></strong></em>
            </div>
        </div>

    </body>

</html>
