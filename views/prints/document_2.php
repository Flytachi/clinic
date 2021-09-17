<?php
require_once '../../tools/warframe.php';
is_module('module_laboratory');

$comp = $db->query("SELECT * FROM company_constants")->fetchAll();
foreach ($comp as $value) {
    $company[$value['const_label']] = $value['const_value'];
}

if ( isset($_GET['items']) ) {
    $docs = $db->query("SELECT us.*, vs.accept_date FROM users us LEFT JOIN visit vs ON(vs.user_id = us.id AND vs.id = ".json_decode($_GET['items'])[0].") WHERE us.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
}else {
    $docs = $db->query("SELECT ds.is_document, vs.user_id, vs.parent_id, vs.service_id, us.dateBith, vs.accept_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN service sc ON(sc.id=vs.service_id) LEFT JOIN division ds ON(ds.id = sc.division_id) WHERE vs.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
    if ($docs->is_document) {
        global_render($docs->is_document.'?id='.$_GET['id']);
    }
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

            <?php if( isset($company['print_type_center']) and $company['print_type_center'] ): ?>
                <div class="col-4 text-center" style="font-size: 32px; color: blue;font-family: Arial, Helvetica, sans-serif;">
                    <b>
                        <?= $company['print_header_title'] ?><br>
                    </b>
                </div>

                <div class="col-4 text-center">
                    <img src="<?= $company['print_header_logotype'] ?>" width="200" height="160">
                </div>

                <div class="col-4 text-right h3">
                    <b>
                        <?= $company['print_header_address'] ?><br>
                        <?= $company['print_header_phones'] ?>
                    </b>
                </div>
            <?php else: ?>
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
            <?php endif;?>

        </div>

        <div class="my_hr-1"></div>
        <div class="my_hr-2"></div>

        <div class="text-left">
            <div class="h3">
                <?php if ( isset($_GET['items']) ): ?>
                    <b>Ф.И.О.: </b><?= get_full_name($docs->id) ?><br>
                    <b>ID Пациента: </b><?= addZero($docs->id) ?><br>
                    <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
                    <b>Дата исследования: </b><?= date('d.m.Y H:i', strtotime($docs->accept_date)) ?><br>
                <?php else: ?>
                    <b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
                    <b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
                    <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
                    <b>Дата исследования: </b><?= date('d.m.Y H:i', strtotime($docs->accept_date)) ?><br>
                <?php endif; ?>
            </div>

            <?php if ( isset($_GET['items']) ): ?>

                <?php foreach (json_decode($_GET['items']) as $item): ?>
                    <h1 class="text-center"><b><?= $db->query("SELECT sc.name FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.id=$item")->fetch()['name'] ?></b> </h1>

                    <div class="table-responsive card">
                        <table class="minimalistBlack">
                            <thead>
                                <t id="text-h">
                                    <th style="width:3%">№</th>
                                    <th class="text-left">Анализ</th>
                                    <th class="text-right" style="width:15%">Норма</th>
                                    <th class="text-right" style="width:10%">Ед</th>
                                    <th class="text-center" style="width:15%">Результат</th>
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
                                        <td class="text-center"><?= $row['result'] ?></td>
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
                                <th class="text-center" style="width:15%">Результат</th>
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
                                    <td class="text-center"><?= $row['result'] ?></td>
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
