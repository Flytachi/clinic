<?php
require_once '../../tools/warframe.php';
is_auth(3);
if ($_GET['pk']) {
    $pk = $_GET['pk'];
    $serv_id = $db->query("SELECT id FROM visit WHERE user_id = $pk AND completed IS NULL AND service_id != 1")->fetchAll();
    $sql = "SELECT
                vs.id,
                SUM(iv.balance_cash + iv.balance_card + iv.balance_transfer) 'balance',
                ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), vs.add_date), '%H') / 24) 'bed_days',
                bdt.name 'bed_type',
                bdt.price 'bed_price',
                ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), vs.add_date), '%H') / 24) * bdt.price 'cost_bed',
                (SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type = 1) 'cost_service',
                (SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type = 2) 'cost_item_2',
                (SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type = 3) 'cost_item_3'
                -- vs.add_date
            FROM users us
                LEFT JOIN investment iv ON(iv.user_id = us.id)
                LEFT JOIN beds bd ON(bd.user_id = us.id)
                LEFT JOIN bed_type bdt ON(bdt.id = bd.types)
                LEFT JOIN visit vs ON(vs.user_id = us.id AND vs.grant_id = vs.parent_id)
            WHERE us.id = $pk";
    $price = $db->query($sql)->fetch();
    foreach ($serv_id as $value) {
        $item_service = $db->query("SELECT SUM(item_cost) 'price' FROM visit_price WHERE visit_id = {$value['id']} AND item_type = 1")->fetchAll();
        foreach ($item_service as $pri_ze) {
            $price['cost_service'] += $pri_ze['price'];
        }
    }
    // prit($price);
    ?>
    <div class="table-responsive mt-3">
        <table class="table table-hover">
            <thead>
                <tr class="bg-blue">
                    <th class="text-left" colspan="2">Наименование</th>
                    <th>Дата и время</th>
                    <th class="text-right">Сумма</th>
                    <!-- <th class="text-center" style="width: 150px">Оплатить</th> -->
                </tr>
            </thead>
            <tbody>
                <tr class="table-warning">
                    <td>Койка (<?= $price['bed_days'] ?> дней)</td>
                    <td colspan="2"><?= $price['bed_type'] ?> (<?= number_format($price['bed_price']) ?>)</td>
                    <td class="text-right"><?= number_format($price['cost_bed']) ?></td>
                </tr>

                <tr class="text-center table-primary">
                    <td colspan="3" class="text-left">Мед услуги</td>
                    <td class="text-right"><?= number_format($price['cost_service']) ?></td>
                </tr>
                <?php foreach ($db->query("SELECT id FROM visit WHERE user_id = $pk AND completed IS NULL") as $val): ?>
                    <?php foreach ($db->query("SELECT * FROM visit_price WHERE visit_id = {$val['id']} AND item_type = 1") as $row): ?>
                        <tr>
                            <!-- <input type="hidden" class="parent_class" value="<?= $row['parent_id'] ?>"> -->
                            <td colspan="2"><?= $row['item_name'] ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                            <td class="text-right total_cost"><?= number_format($row['item_cost']) ?></td>
                            <!-- <td class="text-center">
                                <button onclick="alert('в разработке')" class="btn btn-outline-success"><i class="icon"></i></button>
                            </td> -->
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <tr class="table-primary">
                    <td>Препараты</td>
                    <td>Количество</td>
                    <td>Цена ед.</td>
                    <td class="text-right"><?= number_format($price['cost_item_2']) ?></td>
                </tr>
                <?php foreach ($db->query("SELECT DISTINCT vp.item_name, vp.item_cost, (SELECT COUNT(*) FROM visit_price WHERE visit_id = {$price['id']} AND item_type = 2 AND item_id=vp.item_id) 'count' FROM visit_price vp WHERE vp.visit_id = {$price['id']} AND vp.item_type = 2") as $row): ?>
                    <tr>
                        <td><?= $row['item_name'] ?></td>
                        <td><?= $row['count'] ?></td>
                        <td><?= number_format($row['item_cost']) ?></td>
                        <td class="text-right"><?= number_format($row['count'] * $row['item_cost']) ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr class="table-primary">
                    <td>Расходные материалы</td>
                    <td>Количество</td>
                    <td>Цена ед.</td>
                    <td class="text-right"><?= number_format($price['cost_item_3']) ?></td>
                </tr>
                <?php foreach ($db->query("SELECT DISTINCT vp.item_name, vp.item_cost, (SELECT COUNT(*) FROM visit_price WHERE visit_id = {$price['id']} AND item_type = 3 AND item_id=vp.item_id) 'count' FROM visit_price vp WHERE vp.visit_id = {$price['id']} AND vp.item_type = 3") as $row): ?>
                    <tr>
                        <td><?= $row['item_name'] ?></td>
                        <td><?= $row['count'] ?></td>
                        <td><?= number_format($row['item_cost']) ?></td>
                        <td class="text-right"><?= number_format($row['count'] * $row['item_cost']) ?></td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <?php
}else {
    ?>
    <div class="alert bg-danger alert-styled-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        <span class="font-weight-semibold">Нет данных!</span>
    </div>
    <?php
}
?>
