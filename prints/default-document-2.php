<?php
require_once '../tools/warframe.php';
is_module('module_laboratory');

if ( empty($_GET['pk']) ) {
    $docs = $db->query("SELECT us.id, us.birth_date, v.add_date, v.completed FROM users us LEFT JOIN visits v ON(v.user_id=us.id) WHERE v.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
}else {
    $docs = $db->query("SELECT vs.user_id, vs.parent_id, vs.service_id, us.birth_date, vs.accept_date, vs.service_name FROM visit_services vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['pk']}")->fetch(PDO::FETCH_OBJ);
    // if ($docs->is_document) {
    //     global_render($docs->is_document.'?id='.$_GET['id']);
    // }
}
?>

<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("assets/my_css/document.css") ?>">

    <style>
        body
        {
            font-size: 120% !important;
        }
    </style>

    <body>

        <div class="row">

            <div class="col-6">
                <img src="<?= ( config('print_header_logotype') ) ? config('print_header_logotype') : stack('global_assets/images/placeholders/cover.jpg') ; ?>" width="400" height="120">
            </div>

            <div class="col-6 text-right h4">
                <b>
                    <?= ( config('print_header_title') ) ? config('print_header_title') : "Title text"; ?><br>
                    <?= ( config('print_header_address') ) ? config('print_header_address') : "Title text"; ?><br>
                    <?= ( config('print_header_phones') ) ? config('print_header_phones') : "Title text"; ?><br>
                </b>
            </div>

        </div>

        <div class="my_hr-1"></div>
        <div class="my_hr-2"></div>

        <div class="text-left">
            <div class="h3">
                <?php if ( empty($_GET['pk']) ): ?>
                    <b>Ф.И.О.: </b><?= get_full_name($docs->id) ?><br>
                    <b>ID Пациента: </b><?= addZero($docs->id) ?><br>
                    <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->birth_date)) ?><br>
                    <b>Дата начала визита: </b><?= date('d.m.Y H:i', strtotime($docs->add_date)) ?><br>
                    <b>Дата конца визита: </b><?= date('d.m.Y H:i', strtotime($docs->completed)) ?>
                <?php else: ?>
                    <b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
                    <b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
                    <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->birth_date)) ?><br>
                    <b>Дата исследования: </b><?= date('d.m.Y H:i', strtotime($docs->accept_date)) ?>
                <?php endif; ?>
            </div>

            <?php if ( empty($_GET['pk']) ): ?>

                <?php foreach (json_decode($_GET['items']) as $item): ?>
                    <h1 class="text-center"><b><?= $db->query("SELECT service_name FROM visit_services WHERE id=$item")->fetchColumn() ?></b> </h1>

                    <div class="table-responsive card">
                        <table class="minimalistBlack">
                            <thead>
                                <t id="text-h">
                                    <th style="width:3%">№</th>
                                    <th class="text-left">Анализ</th>
                                    <th class="text-center" style="width:15%">Норма</th>
                                    <th class="text-center" style="width:10%">Ед</th>
                                    <th class="text-center" style="width:15%">Результат</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($db->query("SELECT va.analyze_name, va.result, sa.standart, sa.unit FROM visit_analyzes va LEFT JOIN service_analyzes sa ON (sa.id=va.service_analyze_id) WHERE va.visit_service_id = $item") as $row): ?>
                                    <tr id="text-b">
                                        <td><?= $i++ ?></td>
                                        <td class="text-left"><?= $row['analyze_name'] ?></td>
                                        <td class="text-center">
                                            <?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?>
                                        </td>
                                        <td class="text-center">
                                            <?= preg_replace("#\r?\n#", "<br />", $row['unit']) ?>
                                        </td>
                                        <td class="text-center"><?= $row['result'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>

                <h1 class="text-center"><b><?= $docs->service_name ?></b></h1>

                <div class="table-responsive card">
                    <table class="minimalistBlack">
                        <thead>
                            <tr id="text-h">
                                <th style="width:3%">№</th>
                                <th class="text-left">Анализ</th>
                                <th class="text-center" style="width:15%">Норма</th>
                                <th class="text-center" style="width:10%">Ед</th>
                                <th class="text-center" style="width:15%">Результат</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($db->query("SELECT va.analyze_name, va.result, sa.standart, sa.unit FROM visit_analyzes va LEFT JOIN service_analyzes sa ON (sa.id=va.service_analyze_id) WHERE va.visit_service_id = {$_GET['pk']}") as $row): ?>
                                <tr id="text-b">
                                    <td><?= $i++ ?></td>
                                    <td class="text-left"><?= $row['analyze_name'] ?></td>
                                    <td class="text-center">
                                        <?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?>
                                    </td>
                                    <td class="text-center">
                                        <?= preg_replace("#\r?\n#", "<br />", $row['unit']) ?>
                                    </td>
                                    <td class="text-center"><?= $row['result'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </div>

    </body>
</html>
