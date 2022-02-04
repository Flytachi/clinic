<?php
require_once '../tools/warframe.php';


// Акт Сверки
if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {
    $docs = $db->query("SELECT v.id, v.user_id, v.grant_id, v.parad_id, us.birth_date, v.add_date, v.completed FROM visits v LEFT JOIN users us ON(us.id=v.user_id) WHERE v.id={$_GET['pk']} AND v.direction IS NOT NULL")->fetch(PDO::FETCH_OBJ);
    $order = $db->query("SELECT id FROM visit_orders WHERE visit_id = $docs->id")->fetchColumn();
    $total = 0; 
}else Mixin\error('404');

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
            <b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
            <b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
            <b>Дата рождения: </b><?= ($docs->birth_date) ? date_f($docs->birth_date) : '<span class="text-muted">Нет данных</span>' ?><br>
            <b>Дата поступления: </b><?= ($docs->add_date) ? date_f($docs->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?><br>
            <b>Дата выписки: </b><?= ($docs->completed) ? date_f($docs->completed, 1) : '<span class="text-muted">Нет данных</span>' ?><br>
            <?php if($order): ?>
                <b>Ордер №: </b><?= $order ?><br>
            <?php endif; ?>
        </div>

        <?php if (config("print_document_hr-3")) echo '<div class="my_hr-1" style="border-color:'.config("print_document_hr-3-color").'"></div>' ; ?>
        <?php if (config("print_document_hr-4")) echo '<div class="my_hr-2" style="border-color:'.config("print_document_hr-4-color").'"></div>' ; ?>

        <h1 class="text-center"><b>АКТ сверки № <?= $docs->parad_id ?></b></h1>
        
        <div class="table-responsive card">
            <table class="minimalistBlack">
                <thead>
                    <tr id="text-h">
                        <th style="width: 40px !important;">№</th>
                        <th>Наименование</th>
                        <th class="text-center">Кол-во</th>
                        <th class="text-right" style="width: 200px;">Цена</th>
                        <th class="text-right" style="width: 200px;">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                    $bed = new Table($db, "visit_beds");
                    $bed->set_data("location, type, cost, ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(end_date, CURRENT_TIMESTAMP()), start_date), '%H')) 'time'")->where("visit_id = $docs->id")->order_by("start_date ASC");
                    $sale_info = (new Table($db, "visit_sales"))->where("visit_id = $docs->id")->get_row();
                    $total_bed = 0;
                    ?>
                    <?php foreach($bed->get_table(1) as $row): ?>
                        <tr>
                            <td><?= $row->count ?></td>
                            <td>
                                <?= $row->location ?> (<?= $row->type ?>) 
                            </td>
                            <td class="text-center">
                                <?= minToStr($row->time) ?>
                            </td>
                            <td class="text-right">
                                <?= number_format($row->cost) ?>/День
                            </td>
                            
                            <td class="text-right">
                                <?php if($order): ?>
                                    0
                                <?php else: ?>
                                    <?php $total += $row->time * ($row->cost / 24); echo number_format($row->time * ($row->cost / 24)); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-warning">
                        <td colspan="5" class="text-center"><b>Услуги</b></td>
                    </tr>
                    <?php  
                    $service = new Table($db, "visit_service_transactions");
                    $service->set_data("DISTINCT item_id, item_name, item_cost")->where("visit_id = $docs->id AND item_type IN (1,2,3)")->order_by("item_name ASC");
                    ?>
                    <?php foreach ($service->get_table(1) as $row): ?>
                        <tr>
                            <td><?= $row->count ?></td>
                            <td><?= $row->item_name ?></td>
                            <td class="text-center"><?php $row->qty = $db->query("SELECT * FROM visit_service_transactions WHERE visit_id = $docs->id AND item_id = $row->item_id AND item_cost = $row->item_cost")->rowCount(); echo $row->qty; ?></td>
                            <td class="text-right">
                                <?= number_format($row->item_cost); ?>
                            </td>
                            <td class="text-right text-<?= number_color($row->qty * $row->item_cost, true) ?>">
                                <?php $total += $row->qty * $row->item_cost; echo number_format($row->qty * $row->item_cost); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if(module('module_pharmacy')): ?>
                        <tr class="table-warning">
                            <td colspan="5" class="text-center"><b>Препараты</b></td>
                        </tr>
                        <?php  
                        $preparats = new Table($db, "visit_bypass_transactions");
                        $preparats->set_data("DISTINCT item_name, item_cost")->where("visit_id = $docs->id")->order_by("item_name ASC");
                        ?>
                        <?php foreach ($preparats->get_table(1) as $row): ?>
                            <tr>
                                <td><?= $row->count ?></td>
                                <td><?= $row->item_name ?></td>
                                <td class="text-center"><?php $row->qty = $db->query("SELECT SUM(item_qty) FROM visit_bypass_transactions WHERE visit_id = $docs->id AND item_name LIKE '$row->item_name' AND item_cost = $row->item_cost")->fetchColumn(); echo $row->qty; ?></td>
                                <td class="text-right">
                                    <?= number_format($row->item_cost); ?>
                                </td>
                                <td class="text-right">
                                    <?php $total += $row->qty * $row->item_cost; echo number_format($row->qty * $row->item_cost); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </tbody>
                <tfooter>
                    <tr class="table-secondary">
                        <td colspan="4" class="text-right"><b>Итог:</b></td>
                        <td class="text-right"><b><?= number_format($total, 1) ?></b></td>
                    </tr>
                </tfooter>
            </table>
        </div>

    </body>

</html>