<?php
require_once '../tools/warframe.php';
is_module('module_laboratory');

if ( isset($_GET['pk']) ) {
    $docs = $db->query("SELECT vs.user_id, vs.parent_id, vs.service_id, us.birth_date, vs.accept_date, vs.service_name FROM visit_services vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['pk']}")->fetch(PDO::FETCH_OBJ);
}else {
    $docs = $db->query("SELECT us.id, us.birth_date, v.add_date, v.completed FROM users us LEFT JOIN visits v ON(v.user_id=us.id) WHERE v.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("assets/my_css/document.css") ?>">

    <body>

        <div class="row">

            <?php $block = (config('print_document_blocks') < 5) ? 12 / config('print_document_blocks') : 3; ?>

            <?php for ($i=1; $i <= config('print_document_blocks'); $i++): ?>
                
                <div class="col-<?= $block ?> text-<?= config("print_document_$i-aligin") ?>">
                    
                    <?php if ( config("print_document_$i-type") ): ?>
                        <img
                            class="img-fluid shadow-1 <?= (config("print_document_$i-logotype-is_circle") ) ? 'rounded-circle': '' ?>"
                            src="<?= ( config("print_document_$i-logotype") ) ? config("print_document_$i-logotype") : stack('global_assets/images/placeholders/cover.jpg') ; ?>" 
                            height="<?= ( config("print_document_$i-logotype-height") ) ? config("print_document_$i-logotype-height") : 120 ?>"
                            width="<?= ( config("print_document_$i-logotype-width") ) ? config("print_document_$i-logotype-width") : 400 ?>"
                        >
                    <?php else: ?>

                        <?php for ($t=1; $t <= $print_text_count; $t++): ?>

                            <?php if ( config("print_document_$i-text-$t") ): ?>
                                <span 
                                    class="<?= ( config("print_document_$i-text-$t-is_bold") ) ? 'font-weight-bold' : '' ?>" 
                                    style="font-size:<?= config("print_document_$i-text-$t-size") ?>px; color:<?= config("print_document_$i-text-$t-color") ?>"
                                ><?= config("print_document_$i-text-$t") ?></span><br>
                            <?php endif; ?>

                        <?php endfor; ?>

                    <?php endif; ?>
                

                </div>
            <?php endfor; ?>

        </div>

        <?php if (config("print_document_hr-1")) echo '<div class="my_hr-1" style="border-color:'.config("print_document_hr-1-color").'"></div>' ; ?>
        <?php if (config("print_document_hr-2")) echo '<div class="my_hr-2" style="border-color:'.config("print_document_hr-2-color").'"></div>' ; ?>
        
        <div class="text-left h3">
            <?php if ( isset($_GET['pk']) ): ?>
                <b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
                <b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
                <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->birth_date)) ?><br>
                <b>Дата исследования: </b><?= date('d.m.Y H:i', strtotime($docs->accept_date)) ?>
            <?php else: ?>
                <b>Ф.И.О.: </b><?= get_full_name($docs->id) ?><br>
                <b>ID Пациента: </b><?= addZero($docs->id) ?><br>
                <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->birth_date)) ?><br>
                <b>Дата начала визита: </b><?= date('d.m.Y H:i', strtotime($docs->add_date)) ?><br>
                <b>Дата конца визита: </b><?= date('d.m.Y H:i', strtotime($docs->completed)) ?>
            <?php endif; ?>
        </div>

        <?php if (config("print_document_hr-3")) echo '<div class="my_hr-1" style="border-color:'.config("print_document_hr-3-color").'"></div>' ; ?>
        <?php if (config("print_document_hr-4")) echo '<div class="my_hr-2" style="border-color:'.config("print_document_hr-4-color").'"></div>' ; ?>

        <div class="text-left">

            <?php if ( isset($_GET['pk']) ): ?>

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

            <?php else: ?>

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

            <?php endif; ?>

        </div>

    </body>
    
</html>
