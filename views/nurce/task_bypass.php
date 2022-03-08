<?php
require_once '../../tools/warframe.php';
$session->is_auth(7);
$pk = $_GET['pk'];

$visit = (new Table($db, "visits"))->where("id = $pk AND completed IS NULL")->get_row();
?>

<?php if($visit): ?>
    <?php
    $events = (new Table($db, "visit_bypass_events"))->set_data("DISTINCT visit_bypass_id, responsible_id, event_title")->where("visit_id = $pk AND DATE(event_start) = CURRENT_DATE()");
    ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <h3> <b>ID <?= addZero($visit->patient_id) ?>:</b> <?= patient_name($visit->patient_id) ?></h3>
        </div>
    </div>
    
    <div class="table-responsive card">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="bg-secondary">
                    <th colspan="1">Информация</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events->get_table() as $event): ?>
                    <tr>
                        <td>
                            <strong><?= $event->event_title ?></strong>
                            <ul>
                                <?php
                                $event_time = (new Table($db, "visit_bypass_events"))->where("visit_id = $pk AND DATE(event_start) = CURRENT_DATE() AND visit_bypass_id = $event->visit_bypass_id")->order_by("event_start");
                                ?>
                                <?php foreach ($event_time->get_table() as $row): ?>
                                    <li>
                                        <?php
                                        if ($row->event_completed) {
                                            $status = "выполнено";
                                            $color = "success";
                                            $tag = "s";
                                        }elseif ($row->event_fail) {
                                            $status = "отменено";
                                            $color = "secondary";
                                            $tag = "s";
                                        }else {
                                            $status = "не выполнено";
                                            $color = "danger";
                                            $tag = "span";
                                        }
                                        ?>
                                        <<?= $tag ?> class="text-<?= $color ?>">
                                            <?php
                                            if ($row->event_end) echo "от ".date_f($row->event_start, "H:i")." до ".date_f($row->event_end, "H:i");
                                            else echo date_f($row->event_start, "H:i");
                                            ?> - <?= $status ?>
                                        </<?= $tag ?>>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                            <div class="text-right"><em><b>Назначил <?= get_full_name($event->responsible_id) ?></b></em></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php /* foreach ($db->query($sql) as $row): ?>
                    <tr>
                        <td>
                            <?php if ($diet = $db->query("SELECT diet_id FROM bypass WHERE id = {$row['id']}")->fetchColumn()): ?>
                                <strong>Диета: </strong><?= $diet_name = $db->query("SELECT name FROM diet WHERE id = $diet")->fetchColumn(); ?>
                            <?php else: ?>
                                <?php foreach ($db->query("SELECT preparat_id, preparat_name, preparat_supplier, preparat_die_date, qty FROM bypass_preparat WHERE bypass_id = {$row['id']}") as $prep): ?>
                                    <?php if($prep['preparat_id']): ?>
                                        <span class="text-primary"><?= $prep['qty'] ?> шт</span> - <?= $prep['preparat_name'] ?> | <?= $prep['preparat_supplier'] ?> (годен до <?= date("d.m.Y", strtotime($prep['preparat_die_date'])) ?>)<br>
                                        <?php $perk[$prep['preparat_id']] = $prep['qty'] ?>
                                    <?php else: ?>
                                        <span class="text-primary"><?= $prep['qty'] ?> шт</span> - <?= $prep['preparat_name'] ?> <span class="text-orange">(Сторонний)</span><br>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <ul>
                                <?php foreach ($db->query("SELECT date, time, status, completed FROM bypass_date WHERE bypass_id = {$row['id']} AND date = CURRENT_DATE()") as $value): ?>
                                    
                                    <?php if ($value['status']): ?>
                                        <li>
                                            <!-- diet stage -->
                                            <?php if (isset($diet_name)): ?>
    
                                                <?php if ($value['completed']): ?>
                                                    <s class="text-success"><?= date('H:i', strtotime($value['time'])) ?> -- принято</s>
                                                <?php else: ?>
                                                    <span class="text-muted"><?= date('H:i', strtotime($value['time'])) ?> -- назначено</span>
                                                <?php endif; ?>
    
                                            <?php else: ?>
    
                                                <?php if ($value['completed']): ?>
                                                    <s class="text-success"><?= date('H:i', strtotime($value['time'])) ?> -- сделано</s>
                                                <?php else: ?>
    
                                                    <?php if (isset($perk)): ?>
                                                        <?php
                                                        foreach ($perk as $pr => $qty) {
                                                            $store[$pr] = $db->query("SELECT qty FROM storage_home WHERE preparat_id = $pr")->fetchColumn();
                                                            if ($store[$pr] >= $qty) {
                                                                $store_status = true;
                                                                continue;
                                                            }elseif ($store[$pr] > 0) {
                                                                foreach ($perk as $pr1 => $qty1) {
                                                                    $order[$pr1] = $db->query("SELECT qty FROM storage_orders WHERE preparat_id = $pr1 AND date = CURRENT_DATE()")->fetchColumn();
                                                                    if ($order[$pr1] + $store[$pr] >= $qty1) {
                                                                        $order_status = true;
                                                                        continue;
                                                                    }
                                                                    $order_status = false;
                                                                }
                                                                if ($order_status) {
                                                                    ?>
                                                                    <span class="text-muted"><?= date('H:i', strtotime($value['time'])) ?> -- не сделано <span class="text-danger">(недостаток на складе)</span> <span class="text-orange">(заказ на препараты оформлен, на рассмотрении)</span></span>
                                                                    <?php
                                                                }else {
                                                                    ?>
                                                                    <span class="text-muted"><?= date('H:i', strtotime($value['time'])) ?> -- не сделано <span class="text-danger">(недостаток на складе)</span> <span class="text-danger">(заказ на препараты не оформлен)</span></span>
                                                                    <?php
                                                                }
                                                                $stop = true;
                                                                $store_status = false;
                                                                break;
                                                            }
                                                            $store_status = false;
                                                        }
                                                        if ($store_status) {
                                                            ?>
                                                            <span class="text-muted"><?= date('H:i', strtotime($value['time'])) ?> -- не сделано <span class="text-success">(препарат в наличии)</span></span>
                                                            <?php   
                                                        }elseif (!isset($stop) or !$stop) {
                                                            foreach ($perk as $pr => $qty) {
                                                                $order[$pr] = $db->query("SELECT qty FROM storage_orders WHERE preparat_id = $pr AND date = CURRENT_DATE()")->fetchColumn();
                                                                if ($order[$pr] + $store[$pr] >= $qty) {
                                                                    $order_status = true;
                                                                    continue;
                                                                }
                                                                $order_status = false;
                                                            }
                                                            if ($order_status) {
                                                                ?>
                                                                <span class="text-orange"><?= date('H:i', strtotime($value['time'])) ?> -- нет на складе (заказ на препараты оформлен, на рассмотрении)</span>
                                                                <?php
                                                            }else {
                                                                ?>
                                                                <span class="text-danger"><?= date('H:i', strtotime($value['time'])) ?> -- нет на складе (заказ на препараты не оформлен)</span>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    <?php else: ?>
                                                        <span class="text-muted"><?= date('H:i', strtotime($value['time'])) ?> -- не сделано</span>
                                                    <?php endif; ?>
    
                                                <?php endif; ?>
    
                                            <?php endif; ?>
                                        </li>
                                    <?php endif; ?>
    
                                    <?php unset($store); unset($order); unset($store_status); unset($order_status); unset($stop); ?>
    
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                    <?php unset($perk); unset($diet_name); ?>
                <?php endforeach; */ ?>
            </tbody>
        </table>
    </div>

    <?php if($visit->is_active): ?>
        <div class="text-right">
            <a href="<?= viv('card/content-9') ?>?pk=<?= $pk ?>&activity=1" class="btn btn-outline-info btn-sm">Перейти к пациенту</a>
        </div>
    <?php endif; ?>
<?php endif; ?>
