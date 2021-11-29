<?php
require_once '../tools/warframe.php';


// Акт Сверки


if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {
    $docs = $db->query("SELECT v.id, v.user_id, v.grant_id, v.parad_id, us.birth_date, v.add_date, v.completed, v.division_id, v.icd_id FROM visits v LEFT JOIN users us ON(us.id=v.user_id) WHERE v.id={$_GET['pk']} AND v.direction IS NOT NULL")->fetch(PDO::FETCH_OBJ);
    $docs->report = $db->query("SELECT service_report FROM visit_services WHERE visit_id = $docs->id AND service_id = 1")->fetchColumn();
    $data = (new Table($db, 'users'))->where("id = $docs->user_id")->get_row();
}else{
    Mixin\error('404');
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
        
        <h3 class="text-center h1"><b>История № <?= $docs->parad_id ?></b></h3>

        <div class="table-responsive card">
            <table class="minimalistBlack">
                <tbody>
                    <tr>
                        <td class="text-left"><b>ID/ФИО</b></td>
                        <td class="text-center"><?= addZero($docs->user_id) ?> / <?= get_full_name($docs->user_id) ?></td>
                    </tr>
                    <tr>
                        <td class="text-left"><b>Дата рождения</b></td>
                        <td class="text-center"><?= ($docs->birth_date) ? date_f($docs->birth_date) : '<span class="text-muted">Нет данных</span>' ?></td>
                    </tr>
                    <tr>
                        <td class="text-left"><b>Пол/Вес/Рост/Температура</b></td>
                        <td class="text-center">
                            <?= ($data->gender) ? "Муж" : "Жен" ?> /
                            <?= (isset($initial->weight) and $initial->weight) ? $initial->weight : '<span class="text-muted">Нет данных</span>' ?> /
                            <?= (isset($initial->height) and $initial->height) ? $initial->height : '<span class="text-muted">Нет данных</span>' ?> /
                            <?= (isset($initial->temperature) and $initial->temperature) ? $initial->temperature : '<span class="text-muted">Нет данных</span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left"><b>Город/Район</b></td>
                        <td class="text-center">
                            <?= ($data->province) ? $data->province : '<span class="text-muted">Нет данных</span>' ?> /
                            <?= ($data->region) ? $data->region : '<span class="text-muted">Нет данных</span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left"><b>Адрес проживания/прописки</b></td>
                        <td class="text-center">
                            <?= ($data->address_residence) ? $data->address_residence : '<span class="text-muted">Нет данных</span>' ?> /
                            <?= ($data->address_registration) ? $data->address_registration : '<span class="text-muted">Нет данных</span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left"><b>Группа крови</b></td>
                        <td class="text-center"></td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="table-responsive card">
            <table class="minimalistBlack">
                <tbody>
                    <tr>
                        <td class="text-left"><b>Дата поступления/выписки</b></td>
                        <td class="text-center">
                            <?= ($docs->add_date) ? date_f($docs->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?> / 
                            <?= ($docs->completed) ? date_f($docs->completed, 1) : '<span class="text-muted">Нет данных</span>' ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-left"><b>Приёмный диагноз</b></td>
                        <td class="text-center">
                            
                        </td>
                    </tr>

                </tbody>
            </table>
            <table class="minimalistBlack">
                <thead>
                    <tr>
                        <th class="text-left">Врач</th>
                        <th class="text-center">Диагноз</th>
                        <th class="text-center">Дата</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( (new Table($db, 'visit_icd_history'))->where("visit_id = $docs->id")->get_table() as $diagnos ): ?>
                        <tr>
                            <td><?= get_full_name($diagnos->parent_id) ?></td>
                            <td><?= icd($diagnos->icd_id)['decryption'] ?></td>
                            <td><?= date_f($diagnos->add_date, 1) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <table class="minimalistBlack">
                <tbody>
                    <tr>
                        <td class="text-left"><b>Код последнего диагноза</b></td>
                        <td class="text-center">
                            <?= icd($docs->icd_id)['code'] ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive card">
            <table class="minimalistBlack">
                <thead>
                    <tr>
                        <th class="text-left" style="width: 50px;">№</th>
                        <th class="text-left">Оперция</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $opI=1; foreach( (new Table($db, 'visit_operations'))->where("visit_id = $docs->id")->get_table() as $oper ): ?>
                        <tr>
                            <td><?= $opI++ ?></td>
                            <td><?= $oper->operation_name ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div style="font-size: 20px;">
            <?= $docs->report ?>
        </div>

        <div class="table-responsive card">
            <table class="minimalistBlack">
                <tbody>
                    <tr>
                        <td class="text-left"><b>Лечащий Врач</b></td>
                        <td class="text-center"><?= get_full_name($docs->grant_id) ?> ___________</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <em class="font-weight-bold" style="font-size: 16px;">Дата печати: <?= date("d.m.Y H:i") ?></em>
            </div>
        </div>

    </body>

</html>