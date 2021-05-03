<?php
require_once '../../tools/warframe.php';
is_module('module_laboratory');

$comp = $db->query("SELECT * FROM company_constants")->fetchAll();
foreach ($comp as $value) {
    $company[$value['const_label']] = $value['const_value'];
}

if ( isset($_GET['items']) ) {
    $docs = $db->query("SELECT * FROM users WHERE id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
}else {
    $docs = $db->query("SELECT vs.user_id, vs.parent_id, vs.service_id, us.dateBith, vs.completed FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <style>
        body
        {
            font-size: 120% !important;
        }
    </style>

    <body>

        <div class="row">

            <div class="col-6">
                <img src="<?= $company['print_header_logotype'] ?>" width="400" height="120">
            </div>

            <div class="col-6 text-right h4">
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
                <?php if ( isset($_GET['items']) ): ?>
                    <b>Ф.И.О.: </b><?= get_full_name($docs->id) ?><br>
                    <b>ID Пациента: </b><?= addZero($docs->id) ?><br>
                    <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
                <?php else: ?>
                    <b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
                    <b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
                    <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
                    <b>Дата исследования: </b><?= date('d.m.Y H:i', strtotime($docs->completed)) ?><br>
                <?php endif; ?>
            </div>

            <?php if ( isset($_GET['items']) ): ?>

                <?php foreach (json_decode($_GET['items']) as $item): ?>
                    <h1 class="text-center"><b><?= $db->query("SELECT sc.name FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.id=$item")->fetch()['name'] ?></b></h1>

                    <div class="table-responsive card">
                        <table class="minimalistBlack">
                            <thead>
                                <t id="text-h">
                                    <th style="width:3%">№</th>
                                    <th class="text-left">Анализ</th>
                                    <th class="text-right" style="width:15%">Норма</th>
                                    <th class="text-right" style="width:10%">Ед</th>
                                    <th class="text-right" style="width:15%">Результат</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $norm = "scl.name, scl.code, scl.standart";
                                $sql = "SELECT vl.id, vl.result, vl.deviation, $norm, scl.unit FROM visit_analyze vl LEFT JOIN service_analyze scl ON (vl.analyze_id = scl.id) WHERE vl.visit_id = $item";
                                foreach ($db->query($sql) as $row) {
                                    ?>
                                    <tr id="text-b">
                                        <td><?= $i++ ?></td>
                                        <td class="text-left"><?= $row['name'] ?></td>
                                        <td class="text-right">
                                            <?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?>
                                        </td>
                                        <td class="text-right">
                                            <?= preg_replace("#\r?\n#", "<br />", $row['unit']) ?>
                                        </td>
                                        <td class="text-right"><?= $row['result'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>

                <h1 class="text-center"><b><?= $db->query("SELECT name FROM service WHERE id={$docs->service_id}")->fetch()['name'] ?></b></h1>

                <div class="table-responsive card">
                    <table class="minimalistBlack">
                        <thead>
                            <tr id="text-h">
                                <th style="width:3%">№</th>
                                <th class="text-left">Анализ</th>
                                <th class="text-right" style="width:15%">Норма</th>
                                <th class="text-right" style="width:10%">Ед</th>
                                <th class="text-right" style="width:15%">Результат</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $norm = "scl.name, scl.code, scl.standart";
                            $sql = "SELECT vl.id, vl.result, vl.deviation, $norm, scl.unit FROM visit_analyze vl LEFT JOIN service_analyze scl ON (vl.analyze_id = scl.id) WHERE vl.visit_id = {$_GET['id']}";
                            foreach ($db->query($sql) as $row) {
                                ?>
                                <tr id="text-b">
                                    <td><?= $i++ ?></td>
                                    <td class="text-left"><?= $row['name'] ?></td>
                                    <td class="text-right">
                                        <?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?>
                                    </td>
                                    <td class="text-right">
                                        <?= preg_replace("#\r?\n#", "<br />", $row['unit']) ?>
                                    </td>
                                    <td class="text-right"><?= $row['result'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </div>

    </body>
</html>
