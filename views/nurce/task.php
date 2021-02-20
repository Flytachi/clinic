<?php
require_once '../../tools/warframe.php';
is_auth(7);
$pk = $_GET['pk'];

$sql = "SELECT DISTINCT bs.id FROM bypass bs LEFT JOIN bypass_date bd ON(bd.bypass_id=bs.id) WHERE bs.user_id = $pk AND bd.status IS NOT NULL AND bd.date = CURRENT_DATE()";
?>

<div class="row">
    <div class="col-md-12 text-center">
        <h3> <b>ID <?= addZero($pk) ?>:</b> <?= get_full_name($pk) ?></h3>
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
            <?php foreach ($db->query($sql) as $row): ?>
                <tr>
                    <td>
                        <?php foreach ($db->query("SELECT st.id, bp.qty, st.name, st.supplier, st.die_date FROM bypass_preparat bp LEFT JOIN storage st ON(st.id=bp.preparat_id) WHERE bp.bypass_id = {$row['id']}") as $prep): ?>
                            <span class="text-primary"><?= $prep['qty'] ?> шт</span> - <?= $prep['name'] ?> | <?= $prep['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($prep['die_date'])) ?>)<br>
                            <?php $perk[$prep['id']] = $prep['qty'] ?>
                        <?php endforeach; ?>
                        <ul>
                            <?php foreach ($db->query("SELECT bt.time, bd.status, bd.completed FROM bypass_time bt LEFT JOIN bypass_date bd ON(bd.bypass_time_id=bt.id AND bd.bypass_id={$row['id']} AND bd.status IS NOT NULL AND bd.date = CURRENT_DATE()) WHERE bt.bypass_id = {$row['id']}") as $value): ?>
                                <?php if ($value['status']): ?>
                                    <li>
                                        <?php if ($value['completed']): ?>
                                            <s class="text-success"><?= date('H:i', strtotime($value['time'])) ?> -- сделано</s>
                                        <?php else: ?>

                                            <?php
                                            foreach ($perk as $pr => $qty) {
                                                $store[$pr] = $db->query("SELECT qty FROM storage_home WHERE preparat_id = $pr")->fetchColumn();
                                                if ($store[$pr] >= $qty) {
                                                    $store_status = true;
                                                    continue;
                                                }elseif ($store[$pr] > 0) {
                                                    foreach ($perk as $pr1 => $qty1) {
                                                        $order[$pr1] = $db->query("SELECT qty FROM storage_orders WHERE preparat_id = $pr1")->fetchColumn();
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
                                                    break;
                                                }
                                                $store_status = false;
                                            }
                                            if ($store_status) {
                                                ?>
                                                <span class="text-muted"><?= date('H:i', strtotime($value['time'])) ?> -- не сделано <span class="text-success">(препарат в наличии)</span></span>
                                                <?php
                                            }elseif (!$stop) {
                                                foreach ($perk as $pr => $qty) {
                                                    $order[$pr] = $db->query("SELECT qty FROM storage_orders WHERE preparat_id = $pr")->fetchColumn();
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
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<a href="<?= viv('card/content_7') ?>?id=<?= $pk ?>" class="btn btn-outline-info btn-sm">Перейти к пациенту</a>
