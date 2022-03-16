<?php

use Mixin\Hell;

require_once '../tools/warframe.php';

if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {
    $docs = $db->query("SELECT v.id, v.patient_id, v.grant_id, v.parad_id, p.first_name, p.last_name, p.father_name, p.birth_date, v.add_date, v.completed FROM visits v LEFT JOIN patients p ON(p.id=v.patient_id) WHERE v.id={$_GET['pk']} AND v.direction IS NOT NULL")->fetch(PDO::FETCH_OBJ);
    $docs->report = $db->query("SELECT service_report FROM visit_services WHERE visit_id = $docs->id AND service_id = 1")->fetchColumn();

}else Hell::error('404');

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
            <b>Ф.И.О.: </b><?= patient_name($docs) ?><br>
            <b>ID Пациента: </b><?= addZero($docs->patient_id) ?><br>
            <b>Дата рождения: </b><?= ($docs->birth_date) ? date_f($docs->birth_date) : '<span class="text-muted">Нет данных</span>' ?><br>
            <b>Дата поступления: </b><?= ($docs->add_date) ? date_f($docs->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?><br>
            <b>Дата выписки: </b><?= ($docs->completed) ? date_f($docs->completed, 1) : '<span class="text-muted">Нет данных</span>' ?><br>
        </div>

        <?php if (config("print_document_hr-3")) echo '<div class="my_hr-1" style="border-color:'.config("print_document_hr-3-color").'"></div>' ; ?>
        <?php if (config("print_document_hr-4")) echo '<div class="my_hr-2" style="border-color:'.config("print_document_hr-4-color").'"></div>' ; ?>

        <h3 class="text-center h1"><b>Выписка <?= $docs->patient_id ?> № <?= $docs->parad_id ?></b></h3>

        <div class="text-left h3">

            <p>
                <?= stristr($docs->report, "Рекомендация:", true) ?>
            </p>

            <h4 class="text-center"><strong>Результаты визитов:</strong></h4>
            <p>
                <!-- Результаты визитов -->
                <?php foreach ($db->query("SELECT DISTINCT vs.division_id, ds.name, ds.title FROM visit_services vs LEFT JOIN divisions ds ON(ds.id=vs.division_id) WHERE vs.visit_id = $docs->id AND vs.level IN (5,10) AND vs.completed IS NOT NULL AND vs.service_id != 1 ") as $div): ?>
                    <strong><?= $div['title'] ?>: </strong>
                    <ul>
                        <?php foreach ($db->query("SELECT * FROM visit_services WHERE visit_id = $docs->id AND level IN (5,10) AND completed IS NOT NULL AND service_id != 1 AND division_id = {$div['division_id']}") as $row): ?>
                            <li>
                                <strong><?= $row['service_title'] ?>:</strong>
                                <?= str_replace("Рекомендация:", '', stristr($row['service_report'], "Рекомендация:")); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </p>

            <?php if(module('module_laboratory')): ?>
                <h4 class="text-center"><strong>Результаты лабораторных и инструментальных исследований:</strong></h4>
                <p>
                    <!-- Результаты лабораторных и инструментальных исследований -->
                    <?php foreach ($db->query("SELECT id, service_name FROM visit_services WHERE visit_id = $docs->id AND completed IS NOT NULL AND level IN (6)") as $any): ?>
                        <li>
                            <strong><?= $any['service_name'] ?>:</strong>
                            <?php foreach ($db->query("SELECT analyze_name, result FROM visit_analyzes WHERE visit_id = $docs->id AND visit_service_id = {$any['id']}") as $row): ?>
                                <?= $row['analyze_name'] ?> - <?= $row['result'] ?>;
                            <?php endforeach; ?>
                        </li>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>

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
                <em><strong><?= get_full_name($docs->grant_id) ?></strong></em>
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